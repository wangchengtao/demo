<?php

declare(strict_types=1);

namespace App\Http\Domain\Requests\Queries;

use Knuckles\Scribe\Attributes\QueryParam;
use Spatie\LaravelData\Data;

#[QueryParam('page', 'int', '页码', required: false, example: 1)]
#[QueryParam('size', 'int', '页大小', required: false, example: 15)]
abstract class PageQuery extends Data
{
    public int $page = 1;

    public int $size = 15;
}
