<?php

namespace App\Rules;

use Closure;
use League\ISO3166\ISO3166;
use Illuminate\Contracts\Validation\ValidationRule;

class CountryAlpha2CodeRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $iso3166 = new ISO3166();
        $countries = $iso3166->all();

        $countryCodes = array_column($countries, 'alpha2');
        $check = in_array($value, $countryCodes);

        if (!$check) {
            $fail("Country code not valid iso3166");
        };
    }
}
