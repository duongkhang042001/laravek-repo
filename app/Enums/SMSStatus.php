<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self awaiting_send()
 * @method static self sent()
 * @method static self success()
 * @method static self fail()
 */
final class SMSStatus extends Enum
{
    protected static function values(): array
    {
        return [
            'awaiting_send' => 1,
            'sent' => 2,
            'success' => 3,
            'fail' => 4,
        ];
    }
}
