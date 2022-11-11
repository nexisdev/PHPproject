<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self ACTIVE()
 * @method static self SUSPENDED()
 */
final class UserStatus extends Enum
{
    protected static function values()
    {
        return [
            'ACTIVE' => 'active',
            'SUSPENDED' => 'suspended',
        ];
    }

    protected static function labels()
    {
        return [
            'ACTIVE' => 'Active',
            'SUSPENDED' => 'Suspended',
        ];
    }
}
