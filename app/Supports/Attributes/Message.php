<?php

declare(strict_types=1);

namespace App\Supports\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS_CONSTANT)]
class Message
{
    public function __construct(
        public string $value,
    ) {
    }
}
