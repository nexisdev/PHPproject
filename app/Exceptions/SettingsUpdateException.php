<?php

namespace App\Exceptions;

use Exception;

class SettingsUpdateException extends Exception
{
    protected $message = 'Settings cannot be updated';
}
