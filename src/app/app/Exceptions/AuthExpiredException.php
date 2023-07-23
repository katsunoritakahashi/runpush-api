<?php

namespace App\Exceptions;

use Exception;

class AuthExpiredException extends BaseException
{
    protected $messageKey = 'authexpired';
    public $statusCode = 401;
}
