<?php


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

/*
* 成功或者失败的提示
*/
function flash_message($message = '成功', $success = true)
{
    $className = $success ? 'alert-success' : 'alert-danger';
    session()->flash('alert-message', $message);
    session()->flash('alert-class', $className);
}
