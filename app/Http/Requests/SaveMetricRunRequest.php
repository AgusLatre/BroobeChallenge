<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SaveMetricRunRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'url' => 'required|url',
            'metrics' => 'required|array',
            'strategy_id' => 'required|exists:strategies,id'
        ];
    }
}