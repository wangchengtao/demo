<?php

declare(strict_types=1);

namespace App\Supports;

use App\Supports\Traits\Serializable;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PaginateModel implements Arrayable
{
    use Serializable;

    private int $count;

    private int $current;

    private int $pageSize;

    private array $list;

    public function __construct(int $current, int $pageSize, int $count, array $list)
    {
        $this->current = $current;
        $this->pageSize = $pageSize;
        $this->count = $count;
        $this->list = $list;
    }

    public static function fromPaginator(LengthAwarePaginator $paginator): PaginateModel
    {
        return new static(
            $paginator->currentPage(),
            $paginator->perPage(),
            $paginator->total(),
            $paginator->items(),
        );
    }

    public static function fromCollection(ResourceCollection $collection): PaginateModel
    {
        return new static(
            $collection->resource->currentPage(),
            $collection->resource->perPage(),
            $collection->resource->total(),
            $collection->jsonSerialize(),
        );
    }
}
