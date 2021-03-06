<?php

use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;
use function foo\func;

/**
 * 成功提示
 *
 * @param array $data
 * @param string $dataName
 *
 * @return \Illuminate\Http\JsonResponse
 */
function success($data = [], $dataName = 'data', $message = 'success')
{
    return response()->json(['message' => $message, 'code' => 1, "{$dataName}" => $data], 200);
}


function getrandstr(){
    $str='ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890';
    $randStr = str_shuffle($str);//打乱字符串
    $rands= substr($randStr,0,6);//substr(string,start,length);返回字符串的一部分
    return $rands;
}

if (!function_exists('is_route')) {
    /**
     * Generate the URL to a named route.
     *
     * @param  array|string $name
     * @return bool
     */
    function is_route($name)
    {
        try {
            route($name);
            return true;
        } catch (\Exception $e) {
            return false;
        }
    }
}