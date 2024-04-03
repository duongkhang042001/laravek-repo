<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self new()
 * @method static self awaiting_approval()
 * @method static self pending()
 * @method static self sending()
 * @method static self sent()
 * @method static self cancelled()
 * @method static self error()
 *
 */
final class CampaignStatus extends Enum
{
    protected static function values(): array
    {
        return [
            'new' => 1,
            'awaiting_approval' => 2,
            'pending' => 3, // 1
            'sending' => 4,
            'sent' => 5,
            'cancelled' => 6,
            'error' => 7
        ];
    }
}
