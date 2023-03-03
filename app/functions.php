<?php

/**
 * 自定义函数库
 */

use App\Models\Api\Users;
use Illuminate\Support\Facades\Redis;


/**
 * @Notes: 返回成功
 * @Interface success
 * @param array $message
 * @param array $info
 * @return false|string：
 */
function success($message = [], $info = [])
{
    // return json_encode([
    //     'status' => '0000',
    //     'message' => $message,
    //     'info' => $info
    // ]);
    return response([
        'code' => '000000',
        'msg' => $message,
        'data' => $info
    ])->header('Content-Type', 'application/json');
             
}
/**
 * 水电八局成功
**/
function sdbjsuccess($message = [], $info = [])
{
    return response([
        "success" => true,
        "code" => "000000",
        "httpStatus" => 0,
        "msg" => $message,
        "data" => null,
        "count" => 0,
        "hint" =>null,
        "notSuccess" =>false
    ])->header('Content-Type', 'application/json');
             
}

/**
 * 水电八局失败
**/
function sdbjerror($message = [], $info = [])
{
    return response([
        "success" => false,
        "code" => "A0001",
        "httpStatus" => 0,
        "msg" => $message,
        "data" => null,
        "count" => 0,
        "hint" => null,
        "notSuccess" =>true
    ])->header('Content-Type', 'application/json');
}
/*


/**
 * @Notes: 返回失败
 * @Interface error
 * @param array $message
 * @param array $info
 * @return false|string：
 */
function error($message = [], $info = [], $code = '101001')
 {
//     return json_encode([
//         'status' => $code,
//         'message' => $message,
//         'info' => $info
//     ]);
      return response([
        'code' => $code,
        'msg' => $message,
        'data' => $info
    ])->header('Content-Type', 'application/json');
    
}


/**判断是否是手机号
 * @param string $mobiel
 * @return bool
 */
function is_mobile($mobiel = '')
{
    if (preg_match("/^1[345789]{1}\d{9}$/", $mobiel)) {
        return true;
    } else {
        return false;

    }
}

/**
 * @Notes: 登录成功之后生成token
 * @Author: DoKi
 * @Date: 2020/1/2
 * @Time: 11:21
 * @Interface createToken
 */
function createToken($user_id)
{
    if (!$user_id) {
        return ['status' => 9999, 'msg' => '参数错误，原因：用户id不能为空'];
    }
    // 生成唯一的 redis 键
    $token = md5('user_id=' . $user_id . '&time=' . time());
    $token_str = encrypt('key=' . $token . '&time=' . time());
    $user_model = new Users();
    $user_info = $user_model->getUserInfoById($user_id);
    Redis::setex($token, env('TOKEN_EXPIRED'), json_encode($user_info));
    return $token_str;
}
