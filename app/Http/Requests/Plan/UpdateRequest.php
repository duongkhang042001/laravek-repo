<?php

namespace App\Http\Requests\Plan;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules()
    {
        return [
            'partner_id' => 'sometimes|exists:v3_partners,id',
            'volume_pricings.*.id' => 'required|exists:v3_volume_pricings,id',
            'volume_pricings.*.min_qty' => 'required|numeric|min:0',
            'volume_pricings.*.max_qty' => 'required|numeric|min:-1',
            'volume_pricings.*.price_per_unit' => 'required|numeric|min:0',
        ];
    }
}
