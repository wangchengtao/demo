<?php

declare(strict_types=1);

namespace App\Supports;

use App\Constants\BizCode;

class PageResult extends Result
{
    protected PaginateModel $data;

    public function __construct(PaginateModel $paginator)
    {
        parent::__construct(BizCode::SUCCESS->value, '请求成功');

        $this->data = $paginator;
    }

    public function getData(): PaginateModel
    {
        return $this->data;
    }

    public function setData(PaginateModel $data): void
    {
        $this->data = $data;
    }

    public static function of(int $current, int $pageSize, int $count, array $list): static
    {
        $paginator = new PaginateModel($current, $pageSize, $count, $list);

        return new static($paginator);
    }
}
