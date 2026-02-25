<?php

declare(strict_types=1);

namespace App\Supports\DocsStrategies;

use Knuckles\Scribe\Attributes\BodyParam;

class GetBodyParamFromData extends GetFromDataBase
{
    protected string $attributeName = BodyParam::class;
}
