<?php

namespace App\Http\Requests\Auth;

use App\Models\Auth\User;

use App\Rules\PhoneNumber;
use App\Rules\NotBrandname;
use App\Models\Core\Partner;
use Illuminate\Validation\Rule;
use App\Rules\IsVerifiedBrandname;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;


class AccountRequest extends FormRequest
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
        if ($this->getMethod() == 'PATCH' || $this->getMethod() == 'PUT') {
            $id = is_numeric($this->account) ? $this->account : $this->account->getAttribute('id');
            $user = User::findOrFail($id);
            $currentPhoneNumber = $user->phone_number;
            $currentEmail = $user->email;
            $rules = [
                'password' => [
                    'max:30',
                    Password::min(6)->letters()->mixedCase()->numbers()->symbols()
                ],
            ];
        } else {
            $id = null;
            $currentPhoneNumber = null;
            $currentEmail = null;

            $rules = [
                'username' => [
                    'required',
                    'min:5',
                    'max:30',
                    'regex:/^[a-zA-Z][a-zA-Z0-9_]/',
                    Rule::unique('v3_users')
                ],
                'password' => [
                    'required',
                    'max:30',
                    Password::min(6)->letters()->mixedCase()->numbers()->symbols()
                ],

            ];
        }
        return collect($rules)->merge([
            'full_name' => 'required|min:3|max:50',
            'partner_id' => [
                'required',
                'numeric',
                Rule::exists('v3_partners', 'id')
            ],
            'phone_number' => [
                'required',
                'min:9',
                'max:15',
                'regex:/^[0][0-9]{8,14}$/',
                new PhoneNumber,
                Rule::unique('v3_users')->ignore($currentPhoneNumber, 'phone_number')
            ],
            'brandnames' => [
                new IsVerifiedBrandname($this->partner_id),
                'array'
            ],
            'brandnames.*' => [
                'numeric', Rule::exists('v3_brandnames', 'id')
            ],
            'email' => [
                'required',
                'email',
                Rule::unique('v3_users')->ignore($currentEmail, 'email')
            ],
            'enabled' => 'required|boolean',

        ])->toArray();
    }
}
