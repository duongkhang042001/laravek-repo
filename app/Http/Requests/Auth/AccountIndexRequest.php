<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;

class AccountIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'page' => 'integer|min:1',
            'limit' => 'integer|min:1',
            'enabled' => 'boolean',
            'q' => 'string|min:3|max:255',
            'is_admin' => 'boolean',
            'order' => 'string|min:3|max:10',
            'sort' => 'string|min:3|max:10',
            'from' => 'date_format:Y-m-d',
            'to' => 'date_format:Y-m-d',
        ];
    }
}
