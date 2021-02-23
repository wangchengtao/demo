<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function success($data = [], $message = '请求成功')
    {
        return response()->json([
            'code' => SUCCESS,
            'message' => $message,
            'data' => $data,
        ]);
    }

    protected function error($message = '请求失败', $code = FAILED, $data = [])
    {
        $result = compact('message', 'code', 'data');

        return response()->json($result);
    }
}
