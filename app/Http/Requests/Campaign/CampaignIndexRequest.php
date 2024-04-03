<?php

namespace App\Http\Requests\Campaign;

use App\Enums\CampaignType;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class CampaignIndexRequest extends FormRequest
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
            'title' => 'string|min:5|max:255',
            'status' => [Rule::in(CampaignType::toLabels())],
            'order' => 'string|min:3|max:10',
            'sort' => 'string|min:3|max:10',
            'from' => 'date_format:Y-m-d',
            'to' => 'date_format:Y-m-d',
        ];
    }
}
