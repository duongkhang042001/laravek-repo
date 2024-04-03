<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self st()
 */
final class Provider extends Enum
{
    protected static function values(): array
    {
        return [
            'st' => 1,
            // 'vg' => 2,
            // 'tl' => 3,
            // 'vm' => 4,
            // 'gp' => 5,
            // 'ht' => 6,
        ];
    }
}
