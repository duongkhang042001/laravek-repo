<?php

namespace App\Rules;

use Closure;
use App\Models\Core\Partner;
use App\Models\Brandname\Brandname;
use Illuminate\Contracts\Validation\ValidationRule;

class IsVerifiedBrandname implements ValidationRule
{
    public $partner_id;

    public function __construct($partner_id)
    {
        $this->partner_id = $partner_id;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $brandnames = Brandname::where("partner_id", $this->partner_id);
        if (!is_array($value) || !is_numeric($this->partner_id)) {
            abort(402, "Syntax Error! please try again");
        }

        if (!empty(array_diff($value, $brandnames->pluck('id')->toArray()))) {
            $fail('Brandname was not found! please try again');
        }

        $roles = Partner::findOrFail($this->partner_id)->roles->pluck('name')->toArray();

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
