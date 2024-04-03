<?php

namespace App\Http\Requests\Brandname;

use Illuminate\Foundation\Http\FormRequest;

class BrandnameIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'pageSize' => 'integer|min:1',
            'current' => 'integer|min:1',
            'partner_id' => 'integer|min:1',
            'name' =>  'string|min:3|max:10',
            'enabled' => 'boolean',
            'order' => 'string|min:3|max:10',
            'sort' => 'string|min:3|max:10',
        ];
    }
}
