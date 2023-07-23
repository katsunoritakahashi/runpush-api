<?php

namespace App\Exceptions;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\JsonResponse;
use RuntimeException;

class BaseErrorResponseException extends RuntimeException implements Responsable
{
    /**
     * @var string
     */
    protected $message;

    /**
     * @var int
     */
    protected $statusCode;

    /**
     * @var string|null
     */
    protected $errorCode;

    /**
     * @var array
     */
    protected $errorDetails;

    /**
     * 初期エラーコード一覧
     * ステータスコードに紐付いた基本的なエラーコードで、アプリケーション固有のエラーコードは定義しない
     *
     * @var array
     */
    protected $defaultErrorCodes = [
        400 => 'bad_request',
        401 => 'unauthorized',
        403 => 'forbidden',
        404 => 'not_found',
        405 => 'method_not_allowed',
        422 => 'validation_error',
        500 => 'internal_server_error',
    ];

    /**
     * BaseErrorException constructor.
     *
     * @param string $message 簡易エラーメッセージ
     * @param int $statusCode ステータスコード
     */
    public function __construct(?string $message = '', ?int $statusCode = 500, ?string $errorDetails = null)
    {
        $this->message = $message;
        $this->statusCode = $statusCode;
        $this->errorDetails = $errorDetails;
    }

    /**
     * @param string $message
     */
    public function setErrorMessage(string $message): void
    {
        $this->message = $message;
    }

    /**
     * @param int $statusCode
     */
    public function setStatusCode(int $statusCode): void
    {
        $this->statusCode = $statusCode;
    }

    /**
     * @param string $errorCode
     */
    public function setErrorCode(string $errorCode): void
    {
        $this->errorCode = $errorCode;
    }

    /**
     * @return string
     */
    public function getErrorMessage(): string
    {
        return $this->message;
    }

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statusCode;
    }

    /**
     * @return null|string
     */
    public function getErrorCode(): ?string
    {
        return $this->errorCode;
    }

    public function toResponse($request)
    {
        return new JsonResponse(
            $this->getBasicResponse(),
            $this->getStatusCode()
        );
    }

    protected function getBasicResponse()
    {
        return [
            'message_for_app' => $this->getErrorMessage(),
            'errorMessage' => $this->errorDetails,
            'error_code' => $this->getErrorCode() ?? $this->getDefaultErrorCode(),
        ];
    }

    protected function getDefaultErrorCode(): string
    {
        return $this->defaultErrorCodes[$this->getStatusCode()];
    }
}
