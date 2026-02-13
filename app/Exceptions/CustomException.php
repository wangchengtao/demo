<?php

declare(strict_types=1);

namespace App\Exceptions;

use App\Constants\BizCode;
use Exception as BaseException;
use Throwable;

class CustomException extends BaseException
{
    public function __construct($message = '', BizCode $code = BizCode::FAIL, ?Throwable $previous = null)
    {
        parent::__construct($message, (int) $code->value, $previous);
    }
}
