<?php

namespace App\Exceptions;

use Exception;

class ValidationException extends BaseException
{
    protected $messageKey = 'validation';
    public $statusCode = 422;
}
