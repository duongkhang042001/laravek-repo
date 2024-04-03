<?php

namespace App\Rules;

use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class BrandnameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {

        if (preg_match('/[-_.%#&\[\]{}\\\<@]/', $value)) {
            $fail('Brandname much not include special characters as (-, _, ., %, #, &, [, ], {, }, \, <, @)! Please try again');
        }

        $notExist = DB::table('v3_brandnames')
            ->where('name', $value)
            ->doesntExist();

        if (!$notExist) {
            $fail('Brandname already exist! Please try again');
        }
    }
}
