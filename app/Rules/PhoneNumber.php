<?php

namespace App\Rules;

use Closure;
use libphonenumber\PhoneNumberUtil;
use libphonenumber\NumberParseException;
use Illuminate\Contracts\Validation\ValidationRule;


class PhoneNumber implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $phoneNumberUtil = PhoneNumberUtil::getInstance();

        try {
            $phoneNumberObject = $phoneNumberUtil->parse($value, 'VN');
        } catch (NumberParseException $e) {
            if ($e->getCode() === 0) {
                $phoneNumberObject = $phoneNumberUtil->parse("+{$value}", null);
            } else {
                $fail("Số điện thoại người nhận không hợp lệ");
            }
        }

        if ($phoneNumberObject) {
            if (!$phoneNumberUtil->isValidNumber($phoneNumberObject)) {
                $fail("Số điện thoại người nhận không hợp lệ");
            }
        }
    }
}
