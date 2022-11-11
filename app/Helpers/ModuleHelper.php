<?php

namespace App\Helpers;

use Nwidart\Modules\Facades\Module;

class ModuleHelper
{
    public static function isActive(string $name): bool
    {
        return Module::find($name)->isEnabled();
    }
}
