<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
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
            //
        });
    }

    /**
     * @inheritDoc
     */
    public function render($request, Throwable $exception)
    {
        if ($request->expectsJson()) {
            if ($exception instanceof AuthenticationException) {
                return response()->json(
                    [
                        'data' => $exception->getMessage(),
                    ],
                    Response::HTTP_UNAUTHORIZED
                );
            } else if ($exception instanceof AuthorizationException) {
                return response()->json(
                    [
                        'data' => $exception->getMessage(),
                    ],
                    Response::HTTP_FORBIDDEN
                );
            } else if ($exception instanceof ModelNotFoundException) {
                return response()->json(
                    [
                        'data' => sprintf(
                            '%s(ID:%s) is not found.',
                            class_basename($exception->getModel()),
                            implode(',', $exception->getIds())
                        ),
                    ],
                    Response::HTTP_NOT_FOUND
                );
            } else {
                return response()->json(
                    [
                        'data' => $exception->getMessage(),
                    ],
                    Response::HTTP_INTERNAL_SERVER_ERROR
                );
            }
        }
        return parent::render($request, $exception);
    }
}
