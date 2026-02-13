<?php

declare(strict_types=1);

namespace App\Supports\Traits;

use App\Supports\Attributes\Message;
use InvalidArgumentException;
use ReflectionEnumUnitCase;

trait GetMessage
{
    public function getMessage(): string
    {
        $enum = new ReflectionEnumUnitCase($this, $this->name);
        $attrs = $enum->getAttributes(Message::class);

        if (count($attrs) < 1) {
            throw new InvalidArgumentException('枚举值 getMessage() 失败');
        }

        return $attrs[0]->newInstance()->value;
    }
}
