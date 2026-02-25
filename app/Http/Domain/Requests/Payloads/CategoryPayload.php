<?php

declare(strict_types=1);

namespace App\Http\Domain\Requests\Payloads;

use Knuckles\Scribe\Attributes\BodyParam;
use Spatie\LaravelData\Data;

#[BodyParam('name', 'string', 'Name of the category', required: true, example: '活跃')]
#[BodyParam('order', 'integer', 'Order of the category', required: false, example: 0)]
class CategoryPayload extends Data
{
    public function __construct(
        public string $name,
        public int $order = 0,
    ) {
    }

    public static function messages(...$args): array
    {
        return [
            'name.required' => '请填写分类名称',
        ];
    }
}
