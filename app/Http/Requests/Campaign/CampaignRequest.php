<?php

namespace App\Http\Requests\Campaign;

use Carbon\Carbon;
use App\Enums\SMSType;
use App\Enums\CampaignType;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use App\Rules\IsVerifiedBrandname;
use Illuminate\Foundation\Http\FormRequest;


class CampaignRequest extends FormRequest
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
    public function rules()
    {
        $rules = [
            'title' => 'nullable|min:5|max:255',
            'scheduled_at' => [
                'required',
                Rule::when(
                    $this->input('sms_type') === SMSType::qc()->value,
                    function () {
                        $from = (now()->diffInMinutes(now()->format('Y-m-d 08:00')) > 0)
                            ? now()->format('Y-m-d H:i')
                            : now()->format('Y-m-d 08:00');
                        return [
                            'after_or_equal:' . $from,
                            'before:' . now()->format('Y-m-d 17:30')
                        ];
                    },
                    function () {
                        return [
                            'after_or_equal:' . now()->format('Y-m-d H:i'),
                        ];
                    }
                ),
            ],
        ];

        return ($this->getMethod() == 'PATCH' || $this->getMethod() == 'PUT')
            ? $rules
            : collect($rules)->merge([
                'brandname_id' => [
                    'required',
                    new IsVerifiedBrandname($this->partner_id),
                ],
                'file_import_id' => [
                    'required',
                    Rule::exists('v3_file_imports', 'id')->where('partner_id', $this->partner_id)
                ],
                'content' => 'required|min:3|max:1000',
                'type' => ['required', Rule::in(CampaignType::toValues())],
                'sms_type' => ['required', Rule::in(SMSType::toValues())],
                'partner_id' => [
                    'required',
                    Rule::exists('v3_partners', 'id'),
                    'interger'
                ]
            ])->toArray();
    }

    public function prepareForValidation()
    {
        $type = CampaignType::tryFrom($this->input('type'));

        if (empty($this['title']) && !is_null($type)) {
            $this['title'] = Str::upper($type->label) . ' ' . now()->format('d/m/Y H:i:s');
        }

        switch ($this['type']) { //nếu type là ssms hoặc cmsn thì sms_type sẽ là cshk, qc sẽ là qc
            case CampaignType::ssms()->value:
                $this['sms_type'] = SMSType::cskh()->value;
                break;
            case CampaignType::cmsn()->value:
                $this['sms_type'] = SMSType::cskh()->value;
                break;
            case CampaignType::qc()->value:
                $this['sms_type'] = SMSType::qc()->value;
                break;
        }

        if (empty($this['scheduled_at'])) {
            $this['scheduled_at'] = now()->format('Y-m-d H:i');
        }
    }
}
