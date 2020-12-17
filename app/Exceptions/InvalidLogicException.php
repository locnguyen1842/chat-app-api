<?php

namespace App\Exceptions;

use Exception;

class InvalidLogicException extends Exception
{
    //
    public function __construct($message = "Invalid logic!", $code = 400)
    {
        parent::__construct($message, 400);
    }
}
