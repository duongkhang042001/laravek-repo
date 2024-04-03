<?php

namespace App\Http\Requests\Brandname;

use App\Rules\BrandnameRule;
use Illuminate\Validation\Rule;
use App\Models\Brandname\Brandname;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\IsPartnerAllowToCreateBrandnameRule;



class BrandnameRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        $rules = [
            'name' => 'unique:App\Models\Brandname\Brandname,name',
            'enable' => 'nullable|boolean',
        ];

        return $rules;
    }
}
