<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self cskh()
 * @method static self qc()
 */
final class SMSType extends Enum
{
    protected static function values(): array
    {
        return [
            'cskh' => 1,
            'qc' => 2
        ];
    }
}
