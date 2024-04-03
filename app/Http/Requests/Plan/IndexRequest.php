<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class IndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'limit' => 'sometimes|integer|min:1',
            'from' => 'sometimes|date',
            'to' => 'sometimes|date',
            'partner_id' => 'sometimes|exists:v3_plans,partner_id',
            'provider' => 'sometimes|string',
            'telcos' => 'sometimes|string',
            'sms_type' => 'sometimes|string',
            'region_code' => 'sometimes|string',
        ];
    }
}
