<?php

declare(strict_types=1);

namespace App\Supports\Attributes;

use Attribute;

/**
 * 被注解的属性在序列化时将被忽略.
 */
#[Attribute(Attribute::TARGET_PROPERTY)]
class JsonIgnore
{
}
