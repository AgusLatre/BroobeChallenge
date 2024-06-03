<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetMetricsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'url' => 'required|url',
            'categories' => 'required|array',
            'strategy' => 'required|string'
        ];
    }
}
