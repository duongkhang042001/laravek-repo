<?php

namespace App\Rules;

use App\Models\Brandname\Brandname;
use Closure;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\Validation\ValidationRule;

class BrandnameIdsExist implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $count = count($value);

        $missingIds = DB::table('v3_brandnames')
            ->whereIn('id', $value)
            ->count();

        if ($missingIds < $count) {
            $fail('One or more selected brandname IDs do not exist! Please try again');
        }
    }
}
