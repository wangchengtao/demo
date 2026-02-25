<?php

declare(strict_types=1);

namespace App\Supports\DocsStrategies;

use Knuckles\Scribe\Attributes\QueryParam;

class GetQueryParamFromData extends GetFromDataBase
{
    protected string $attributeName = QueryParam::class;
}
