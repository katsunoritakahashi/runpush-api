<?php

namespace App\Exceptions;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Response;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Throwable;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Illuminate\Auth\AuthenticationException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
        });
    }

    public function render($request, $e)
    {
        if (!$request->is('api/*')) {
            // API以外は何もしない
            return parent::render($request, $e);
        } else if ($e instanceof ValidationException) {
            // バリデーションエラー
            $message = $this->getValidationMessage($e->errors());
            return $this->toResponse($request, $message, Response::HTTP_UNPROCESSABLE_ENTITY, $e->getMessage());
        } else if ($e instanceof AuthenticationException) {
            // 認証エラー
            return $this->toResponse($request, __("exception.authentication"), Response::HTTP_UNAUTHORIZED, $e->getMessage());
        } else if ($e instanceof ModelNotFoundException) {
            // Modelデータが見つからない
            $message = $this->getNotfoundMessage($e->getModel());
            return $this->toResponse($request, $message, Response::HTTP_NOT_FOUND, $e->getMessage());
        } else if ($e instanceof NotFoundHttpException) {
            // Route が存在しない
            return $this->toResponse($request, $e->getMessage(), $e->getStatusCode(), $e->getMessage());
        } else if ($e instanceof \InvalidArgumentException || $e instanceof BadRequestException) {
            // リクエストエラー
            return $this->toResponse($request, (__("exception.bad_request")), Response::HTTP_BAD_REQUEST, $e->getMessage());
//            return $this->toResponse($request, $e->getMessage(), Response::HTTP_BAD_REQUEST, $e->getMessage());
        } else if ($e instanceof Responsable) {
            // カスタム例外インスタンスの場合そのclassのもつtoResponse()
            return $e->toResponse($request);
        } else {
            return $this->toResponse($request, __("exception.server"), Response::HTTP_INTERNAL_SERVER_ERROR, $e->getMessage());
        }
    }

    /**
     * @param mixed $request
     * @param string $message
     * @param int $statusCode
     * @param string $errorMessage
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function toResponse($request, string $message, int $statusCode, string $errorMessage): \Illuminate\Http\JsonResponse
    {
        return (new BaseErrorResponseException($message, $statusCode, $errorMessage))
            ->toResponse($request);
    }

    /**
     * @param array $errors
     *
     * @return string
     */
    protected function getValidationMessage(array $errors): string
    {
        $message = __("exception.validation");
        foreach ($errors as $errorMessages) {
            foreach ($errorMessages as $errorMessage) {
                $message .= "\n" .  $errorMessage;
            }
        }

        return $message;
    }

    /**
     * @param string $model ModelNotFoundExceptionクラスのgetModel()関数はModelクラスのパスをstringdで取得
     *
     * @return string
     */
    protected function getNotfoundMessage(string $model): string
    {
        switch ($model) {
            case \App\Models\Operator::class:
                $message = (__("exception.notfound.beautician"));
                break;
            default:
                $message = (__("exception.notfound.default"));
                break;
        }

        return $message;
    }
}
