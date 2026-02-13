<?php

declare(strict_types=1);

namespace App\Constants;

use App\Supports\Attributes\Message;
use App\Supports\Traits\GetMessage;

enum BizCode: string
{
    use GetMessage;

    #[Message('请求成功')]
    case SUCCESS = '000000';

    #[Message('系统异常')]
    case FAIL = '100000';
}
