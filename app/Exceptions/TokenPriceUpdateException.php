<?php

namespace App\Exceptions;

use Exception;

class TokenPriceUpdateException extends Exception
{
    protected $message = 'Cannot update the token price, please try again later.';
}
