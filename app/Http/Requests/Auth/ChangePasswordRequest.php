<?php

namespace App\Http\Requests\Auth;

use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordRequest extends FormRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => [
                'required',
                'current_password'
            ],
            'new_password' => [
                'required',
                Password::min(6)->letters()->mixedCase()->numbers()->symbols(),
                'max:30',
                'different:old_password'
            ],
            'confirm_new_password' => 'required|same:new_password',
            'user_id' => [
                'required',
                'interger',
                Rule::exists('v3_partners', 'id')
            ]
        ];
    }
}
