<?php

namespace App\Http\Requests\Message;

use Illuminate\Foundation\Http\FormRequest;

class MessageRequest extends FormRequest
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
        return [
            'vendor_id' => 'required|min:3|max:50',
            'telco' => 'required|min:3|max:50',
            'partner_id' => 'required|min:3|max:50',
            'brandname_id' => 'nullable|min:3|max:50',
            'campaign_id' => 'nullable|min:3|max:50',
            'phone_number' => 'required|digits_between:9,15',
            'is_MT' => 'required|boolean',
            'msg_type' => 'required|min:3|max:50',
            'text' => 'required|min:3|max:50',
            'is_delivered' => 'required|boolean',
            'is_sent' => 'required|boolean',
            'error' => 'required|min:3|max:50'
        ];
    }
}
