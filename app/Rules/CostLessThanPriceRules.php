<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class CostLessThanPriceRules implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $pricePerSms = request()->input(str_replace('cost_', 'price_', $attribute));

        if ($value > $pricePerSms) {
            $fail('Cost much not higher than price');
        };
    }
}
