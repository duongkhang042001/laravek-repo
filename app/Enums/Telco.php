<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self other()
 * @method static self vinaphone()
 * @method static self viettel()
 * @method static self mobifone()
 * @method static self vietnamemobile()
 * @method static self gmobile()
 * @method static self itelecom()
 * @method static self reddi()
 */
final class Telco extends Enum
{
    protected static function values(): array
    {
        return [
            'other' => 0,
            'vinaphone' => 1,
            'viettel' => 2,
            'mobifone' => 3,
            'vietnamemobile' => 4,
            'gmobile' => 5,
            'itelecom' => 6,
            'reddi' => 7,
        ];
    }

    public static function toArrayWithoutUnknown(): array
    {
        return array_filter(self::values(), fn ($value) => $value !== self::other()->value);
    }
}
