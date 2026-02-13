<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Constants\BizCode;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Support\Facades\App;
use Illuminate\Validation\ValidationException;
use Summer\ExceptionNotify\Message\Dingtalk\DingtalkText;
use Summer\LaravelExceptionNotify\Notify;
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
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            if (App::isProduction()) {
                $message = new DingtalkText();
                $message->setTitle('服务器内部错误');
                $message->setContent($e->getMessage());

                Notify::send($message);
            }
        });

        $this->renderable(function (CustomException $e) {
            return $this->response(['code' => $e->getCode(), 'message' => $e->getMessage()]);
        });

        $this->renderable(function (ValidationException $e) {
            // @formatter:off
            return $this->response(['code' => BizCode::FAIL->value, 'message' => $e->validator->errors()->first()]);
        });

        $this->renderable(function (Throwable $e) {
            $message = App::isProduction() ? '服务器内部错误' : $e->getMessage();

            return $this->response(['code' => BizCode::FAIL->value, 'message' => $message]);
        });
    }

    public function response($params)
    {
        return response()->json($params)->setEncodingOptions(JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
    }
}
