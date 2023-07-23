<?php

namespace App\Exceptions;

use Exception;

class AuthenticationException extends BaseException
{
    protected $messageKey = 'authentication';
    public $statusCode = 401;
}
