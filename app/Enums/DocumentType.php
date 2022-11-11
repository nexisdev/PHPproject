<?php

namespace App\Enums;

use Spatie\Enum\Laravel\Enum;

/**
 * @method static self PASSPORT()
 * @method static self NATIONAL_CARD()
 * @method static self DRIVER_LICENSE()
 */
final class DocumentType extends Enum
{
    protected static function values()
    {
        return [
            'PASSPORT' => 'passport',
            'NATIONAL_CARD' => 'national_card',
            'DRIVER_LICENSE' => 'driver_license'
        ];
    }

    protected static function labels()
    {
        return [
            'PASSPORT' => 'Passport',
            'NATIONAL_CARD' => 'National ID Card',
            'DRIVER_LICENSE' => 'Driver\'s License'
        ];
    }
}
