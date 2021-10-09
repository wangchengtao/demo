<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        CustomException::class,
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof CustomException) {
            return $this->response(['code' => $exception->getCode(), 'message' => $exception->getMessage(), 'data' => null]);
        }

        if ($exception instanceof NotFoundHttpException) {
            return $this->response(['code' => NOT_EXISTS, 'message' => '404T_T', 'data' => null]);
        }

        if ($exception instanceof AuthenticationException) {
            return $this->response(['code' => EXPIRED, 'message' => '未登录', 'data' => null]);
        }

        if ($exception instanceof AuthorizationException) {
            return $this->response(['code' => NOT_ALLOWED, 'message' => '无权访问', 'data' => null]);
        }

        return parent::render($request, $exception);
    }

    protected function invalidJson($request, ValidationException $exception)
    {
        return $this->response(['code' => PARAM_ERROR, 'message' => $exception->validator->errors()->first(), 'data' => null]);
    }

    public function response($params)
    {
        return response()->json($params)->setEncodingOptions(JSON_UNESCAPED_UNICODE);
    }
}
