<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Constants\BizCode;
use App\Supports\ApiResult;
use App\Supports\PageResult;
use App\Supports\PaginateModel;
use App\Supports\Result;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    protected function paginate(LengthAwarePaginator $paginator): JsonResponse
    {
        $model = PaginateModel::fromPaginator($paginator);

        return $this->response(new PageResult($model));
    }

    protected function collection(ResourceCollection $collection): JsonResponse
    {
        $model = PaginateModel::fromCollection($collection);

        return $this->response(new PageResult($model));
    }

    protected function success(mixed $data = null): JsonResponse
    {
        return $this->response(ApiResult::success($data));
    }

    protected function error(string $message = '请求失败', BizCode $code = BizCode::FAIL): JsonResponse
    {
        return $this->response(new Result($code->value, $message));
    }

    protected function response(Result $result): JsonResponse
    {
        return response()->json($result)->setEncodingOptions(320);
    }
}
