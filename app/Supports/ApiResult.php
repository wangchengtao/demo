<?php

declare(strict_types=1);

namespace App\Supports;

use App\Constants\BizCode;
use Illuminate\Contracts\Support\Arrayable;

/**
 * @template T
 */
class ApiResult extends Result
{
    protected mixed $data;

    public function __construct(BizCode $code, string $message, mixed $data)
    {
        parent::__construct($code->value, $message);

        $this->data = $data;
    }

    public function setData(mixed $data): void
    {
        $this->data = $data;
    }

    public static function of(mixed $data, BizCode $code, string $message): static
    {
        $data = $data instanceof Arrayable ? $data->toArray() : $data;

        return new static($code, $message, $data);
    }

    public static function success(mixed $data = null): static
    {
        return static::of($data, BizCode::SUCCESS, '请求成功');
    }
}
