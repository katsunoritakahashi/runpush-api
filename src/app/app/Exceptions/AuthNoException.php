<?php

namespace App\Exceptions;

use Exception;

class AuthNoException extends BaseException
{
    protected $messageKey = 'authno';
    public $statusCode = 401;
}
