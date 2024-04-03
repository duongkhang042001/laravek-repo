<?php

namespace App\Http\Requests\File;

use Illuminate\Foundation\Http\FormRequest;

class ExportRequest extends FormRequest
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
            'title' => 'nullable|min:6|max:250'
        ];
    }

    public function prepareForValidation()
    {
        if (!$this->input('title')) {
            $this->merge([
                'title' => 'Export_' . now()->format('siHdmY')
            ]);
        }
    }
}
