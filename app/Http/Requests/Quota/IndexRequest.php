<?php

namespace App\Http\Requests\Quota;

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
            'pageSize' => 'nullable|integer',
            'from' => 'nullable|date',
            'to' => 'nullable|date',
            'partner_id' => 'nullable|integer',
            'quotas_current_usage' => 'nullable|integer',
            'quotas_limit' => 'nullable|integer',
            'sort' => 'nullable|string',
            'order' => 'nullable|in:ascend,descend',
        ];
    }
}
