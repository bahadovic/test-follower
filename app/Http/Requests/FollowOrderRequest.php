<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FollowOrderRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Adjust authorization logic as needed
    }

    public function rules()
    {
        return [
            'order_id' => 'required|exists:orders,id',
        ];
    }
}
