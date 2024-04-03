<?php

namespace App\Http\Requests\Core;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'authenticate\.enabled2FA' => ['sometimes', 'in:no,yes'],
            'campaign\.autoApproval' => ['sometimes', 'in:no,yes'],
        ];
    }
}
