<?php

namespace App\Http\Requests\Message;

use App\Enums\SMSType;
use App\Enums\SMSStatus;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class MessageIndexRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'limit' => 'integer|min:1',
            'from' => 'date_format:Y-m-d',
            'to' => 'date_format:Y-m-d',
            'brandname_id' => 'integer|min:1',
            'campaign_id' => 'integer|min:1',
            'telcos' => 'integer|min:1',
            'sms_type' => [Rule::in(SMSType::toLabels())],
            'recipent' => 'interger',
            'status' => [Rule::in(SMSStatus::toLabels())]
        ];
    }
}
