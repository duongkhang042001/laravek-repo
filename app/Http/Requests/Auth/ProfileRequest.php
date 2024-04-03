<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;

class ProfileRequest extends FormRequest
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
            'full_name' => 'required|min:3|max:50',
            'email' => [
                'required',
                'email',
                Rule::unique('v3_users')
                    ->ignore(core()->currentUser()->id, 'id')
                    ->where(function ($query) {
                        $query->where('partner_id', core()->currentUser()->partner_id)->where('deleted_at', null);
                    })
            ],
            'phone_number' => [
                'required',
                'min:9',
                'max:15',
                Rule::unique('v3_users')
                    ->ignore(core()->currentUser()->id, 'id')
                    ->where(function ($query) {
                        $query->where('partner_id', core()->currentUser()->partner_id)->where('deleted_at', null);
                    })
            ],
            'old_password' => 'sometimes|current_password',
            'new_password' => [
                'required_with:old_password',
                Password::min(6)->letters()->mixedCase()->numbers()->symbols(),
                'max:30',
                'different:old_password'
            ],
            'confirm_new_password' => 'required_with:new_password|same:new_password'
        ];
    }
}
