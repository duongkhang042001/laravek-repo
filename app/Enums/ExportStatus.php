<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self new()
 * @method static self processing()
 * @method static self completed()
 * @method static self failed()
 */
final class ExportStatus extends Enum
{
    protected static function values(): array
    {
        return [
            'new' => 0,
            'processing' => 1,
            'completed' => 2,
            'failed' => 3
        ];
    }
}
