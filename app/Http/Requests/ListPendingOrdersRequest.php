<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ListPendingOrdersRequest extends FormRequest
{
    public function authorize()
    {
        return [
            'page' => ['required_if_accepted:page', 'int'],
            'per_page' => ['required_if_accepted:per_page', 'int'],
            ];
    }

    public function rules()
    {
        return [];
    }
}
