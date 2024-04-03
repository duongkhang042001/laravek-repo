<?php

namespace App\Http\Requests\File;

use Closure;
use App\Enums\CampaignType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\HeadingRowImport;

class ImportRequest extends FormRequest
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
            'file'              => 'required|mimes:xlsx',
            'campaign_type'     => ['required', Rule::in(CampaignType::toValues())],
            'headings'          => [
                'required',
                function (string $attribute, mixed $value, Closure $fail) {
                    if (!isset($value[0]) || $value[0] !== 'phone') {
                        $fail('Cột đầu tiên phải là phone');
                    }

                    $type = CampaignType::tryFrom($this->input('campaign_type'));
                    if ($type && $type->equals(CampaignType::cmsn())) {
                        if (!isset($value[1]) || $value[1] !== 'birthday') {
                            $fail('Cột thứ hai phải là birthday');
                        }
                    }
                },
            ],
        ];
    }

    public function prepareForValidation()
    {
        if ($file = $this->file('file')) {

            $readData = (new HeadingRowImport())->toArray($file);

            $this->merge([
                'headings' => $readData[0][0]
            ]);
        }
    }
}
