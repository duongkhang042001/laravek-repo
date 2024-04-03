<?php

namespace App\Http\Requests\Core;

use Illuminate\Validation\Rule;
use App\Rules\BrandnameIdsExist;
use App\Rules\NoDuplicateValues;
use Illuminate\Foundation\Http\FormRequest;

class PartnerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $partnerId = $this->route('partner');

        return [
            'name' => [
                'required',
                'min:3',
                'max:50',
                Rule::unique('v3_partners')->ignore($partnerId),
            ],
            'enabled' => 'required|boolean',
            'roles' => [
                'required',
                'array',
                new NoDuplicateValues()
            ],
            'roles.*' => 'numeric',
            'brandname_ids' => [
                'required',
                'array',
                new BrandnameIdsExist(),
            ],
            'brandname_ids.*' => 'numeric',
        ];
    }
}
