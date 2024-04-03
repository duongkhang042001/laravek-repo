<?php

namespace App\Rules;

use Closure;
use App\Models\Core\Partner;
use Illuminate\Contracts\Validation\ValidationRule;

class IsPartnerAllowToCreateBrandnameRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $roles = Partner::findOrFail($value)->roles->pluck('name')->toArray();
        if ($roles == NULL) {
            $fail('There are no roles exist in current Partner! please contact the administrator');
        }
        if ($value == null && in_array("Brandname", $roles)) {
            $fail('Brandnames are required');
        } else if ($value != null && !in_array("Brandname", $roles)) {
            $fail('Partner doesnt have permission to add brandname');
        };
    }
}
