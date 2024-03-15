<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderStoreRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => 'required|string|min:1|max:255',
            'last_name' => 'required|string|min:1|max:255',
            'phone' => 'required|string|min:8|max:16',
            'email' => 'required|string|min:1|max:255',
            'quantity' => 'required|integer|min:1|max:10',
            'note' => 'nullable|string|max:255',
        ];
    }
}
