<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PageSpeed Insights History</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <div class="container">
        <h1>Metric History</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>URL</th>
                    <th>Accessibility</th>
                    <th>PWA</th>
                    <th>Performance</th>
                    <th>SEO</th>
                    <th>Best Practices</th>
                    <th>Strategy</th>
                    <th>Created At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($metricHistory as $history)
                    <tr>
                        <td>{{ $history->id }}</td>
                        <td>{{ $history->url }}</td>
                        <td>{{ $history->accessibility_metric }}</td>
                        <td>{{ $history->pwa_metric }}</td>
                        <td>{{ $history->performance_metric }}</td>
                        <td>{{ $history->seo_metric }}</td>
                        <td>{{ $history->best_practices_metric }}</td>
                        <td>{{ $history->strategy->name }}</td>
                        <td>{{ $history->created_at }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
