<?php

declare(strict_types=1);

namespace App\Supports;

use App\Supports\Traits\Serializable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\JsonResponse;

class Result implements Arrayable
{
    use Serializable;

    protected string $code;

    protected string $message;

    public function __construct(string $code, string $message)
    {
        $this->code = $code;
        $this->message = $message;
    }

    public function getCode(): string
    {
        return $this->code;
    }

    public function setCode(string $code): void
    {
        $this->code = $code;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function return(): JsonResponse
    {
        return response()->json($this)->setEncodingOptions(320);
    }
}
