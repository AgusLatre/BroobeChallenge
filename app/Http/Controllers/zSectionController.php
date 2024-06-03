<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetMetricsRequest;
use App\Http\Requests\SaveMetricRunRequest;
use App\Models\MetricHistoryRun;
use App\Models\Category;
use App\Models\Strategy;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class zSectionController extends Controller
{
    private $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function index()
    {
        $categories = Category::all();
        $strategies = Strategy::all();
        return view('index', compact('categories', 'strategies'));
    }

    public function getMetrics(GetMetricsRequest $request)
    {
        try {
            $url = $request->input('url');
            $categories = $request->input('categories');
            $strategy = $request->input('strategy');
            // $apiKey = env('GOOGLE_API_KEY');
            $apiKey = 'AIzaSyBZDS4daL-5UeBJRYK9eEWDBGKrgqtB3io';
            

            Log::info('Sending request to Google PageSpeed API', [
                'url' => $url,
                'categories' => $categories,
                'strategy' => $strategy,
                'key' => $apiKey
            ]);

            $query = [
                'url' => $url,
                'strategy' => $strategy,
                'category' => $categories,
                'key' => $apiKey
            ];

            $response = $this->client->get("https://www.googleapis.com/pagespeedonline/v5/runPagespeed", [
                'query' => $query
            ]);

            $data = json_decode($response->getBody(), true);

            Log::info('Response from Google PageSpeed API', ['response' => $data]);

            $categories = ['ACCESSIBILITY', 'BEST_PRACTICES', 'PERFORMANCE', 'PWA', 'SEO'];
            $metrics = [];

            foreach ($categories as $category) {
                $lowercaseCategory = strtolower($category);
                if (isset($data['lighthouseResult']['categories'][$lowercaseCategory])) {
                    $metrics[$category] = $data['lighthouseResult']['categories'][$lowercaseCategory]['score'] * 100;
                } else {
                    $metrics[$category] = null;
                }
            }

            return response()->json(['metrics' => $metrics]);

            return response()->json($metrics);

        } catch (\Exception $e) {
            Log::error('Error in getMetrics', ['exception' => $e]);
            return response()->json(['error' => 'Unable to fetch metrics'], 500);
        }
    }
    public function saveMetricRun(SaveMetricRunRequest $request)
    {
        $metricRun = new MetricHistoryRun();
        $metricRun->url = $request->input('url');
        $metrics = $request->input('metrics');

        $metricRun->accessibility_metric = $metrics['accessibility'] ?? null;
        $metricRun->pwa_metric = $metrics['pwa'] ?? null;
        $metricRun->performance_metric = $metrics['performance'] ?? null;
        $metricRun->seo_metric = $metrics['seo'] ?? null;
        $metricRun->best_practices_metric = $metrics['best_practices'] ?? null;
        $metricRun->strategy_id = $request->input('strategy_id');
        $metricRun->save();

        return response()->json(['status' => 'success']);
    }

    public function history()
    {
        $metricHistory = MetricHistoryRun::with('strategy')->get();
        return view('history', compact('metricHistory'));
    }
}
