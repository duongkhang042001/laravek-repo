<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self sms()
 * @method static self ssms()
 * @method static self cmsn()
 * @method static self qc()
 *
 */
final class CampaignType extends Enum
{
    protected static function values(): array
    {
        return [
            'sms' => 1, // sms_type = cskh,qc // scheduled_at >= now()
            'ssms' => 2, // sms_type = cskh,qc // scheduled_at >= now()
            'cmsn' => 3, // sms_type = cskh // scheduled_at >= now()
            'qc' => 4 // sms_type = qc // scheduled_at >= now() + 30'
        ];
    }
}
