<?php

declare(strict_types=1);

namespace App\Http\Resources;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Knuckles\Scribe\Attributes\ResponseField;

class CategoryResource extends JsonResource
{
    #[ResponseField('id', 'integer')]
    #[ResponseField('name', 'string', '分类名称', required: true, example: '测试分类')]
    #[ResponseField('slug', 'string', '分类别名', required: true, example: 'test')]
    #[ResponseField('description', 'string', '分类描述', example: '测试分类描述')]
    #[ResponseField('created_at', 'string', '创建时间', example: '2023-01-01 00:00:00')]
    #[ResponseField('updated_at', 'string', '更新时间', example: '2023-01-01 00:00:00')]
    public function toArray(Request $request): array
    {
        /** @var Category $resource */
        $resource = $this->resource;

        return [
            'id' => $resource->id,
            'name' => $resource->name,
            'order' => $resource->order,
            'created_at' => $resource->created_at,
            'updated_at' => $resource->updated_at,
        ];
    }
}
