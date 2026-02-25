<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Domain\Requests\Payloads\CategoryPayload;
use App\Http\Domain\Requests\Queries\CategoryQuery;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Knuckles\Scribe\Attributes\Endpoint;
use Knuckles\Scribe\Attributes\Group;
use Knuckles\Scribe\Attributes\Response;

#[Group('Category', '分类')]
class CategoryController extends Controller
{
    #[Endpoint('列表')]
    public function index(CategoryQuery $query)
    {
        $categories = Category::query()->filter($query->toArray())->paginate($query->size);

        return $this->paginate($categories);
    }

    #[Endpoint('搜索')]
    public function search()
    {
        $categories = Category::all();

        return $this->collection(CategoryResource::collection($categories));
    }

    #[Endpoint('创建')]
    #[Response('{"code": "000000", "message": "操作成功", "data": null}')]
    public function store(CategoryPayload $payload)
    {
        Category::create($payload->toArray());

        return $this->success();
    }

    #[Endpoint('更新')]
    #[Response('{"code": "000000", "message": "操作成功", "data": null}')]
    public function update(CategoryPayload $payload, Category $category)
    {
        $category->update($payload->toArray());

        return $this->success();
    }

    #[Endpoint('详情')]
    public function show(Category $category)
    {
        return $this->success(new CategoryResource($category));
    }

    #[Endpoint('删除')]
    #[Response('{"code": "000000", "message": "操作成功", "data": null}')]
    public function destroy(Category $category)
    {
        $category->delete();

        return $this->success();
    }
}
