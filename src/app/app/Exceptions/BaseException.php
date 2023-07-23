<?php

namespace App\Exceptions;

use RuntimeException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;

class BaseException extends RuntimeException implements Responsable
{
    /**
     * @var string
     */
    protected $messageKey = 'base';

    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $statusCode = 500;

    /**
     * @var int
     */
    protected $errorCode;

    /**
     * @var array
     */
    protected $errorDetails;

    /**
     * BaseErrorException constructor.
     *
     * @param string $message error message
     * @param int $errorCode error code
     */
    public function __construct(?string $message = null, ?int $errorCode = null, ?array $errorDetails = null)
    {
        $this->message = $message ?? __("exception.{$this->messageKey}");
        $this->errorCode = $errorCode;
        $this->errorDetails = $errorDetails;
    }

    public function toResponse($request)
    {
        return new JsonResponse(
            [
                'statusCode' => $this->statusCode,
                'errorMessage' => $this->message,
                'errorDetails' => $this->errorDetails,
                'errorCode' => $this->errorCode
            ],
            $this->statusCode
        );
    }
}
