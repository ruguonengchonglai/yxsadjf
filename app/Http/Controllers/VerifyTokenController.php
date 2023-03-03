<?php

namespace App\Http\Controllers;

use App\Models\Api\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;

/**
 * Class VerifyTokenController
 * @package App\Http\Controllers
 * token 验证类
 */
class VerifyTokenController extends BaseController
{

    protected $user_id;
    protected $user_info;

    public function __construct()
    {
        $verify = $this->verifyToken();
        if ($verify['status'] == '9100') { //TOKEN错误
            echo error($verify['msg'], '', $verify['status']);
            die;
        }
        if ($verify['status'] == '9110') { //TOKEN超时
            echo error($verify['msg'], '', $verify['status']);
            die;
        }
        if ($verify['status'] == '9111') { //TOKEN失效
            echo error($verify['msg'], '', $verify['status']);
            die;
        }
    }

    /**
     * @Notes: 验证token
     * @Author: DoKi
     * @Date: 2020/1/2
     * @Time: 11:16
     * @Interface verifyToken
     */
    protected function verifyToken()
    {
        $token = $this->getHeaderToken();
        if(!$token){
            return ['status' => '9100', 'msg' => '请求错误，原因：TOKEN错误'];
        }
        $token_expired = env('TOKEN_EXPIRED');
        // 解密token，判断是否失效
        $verify_token = decrypt($token);
        parse_str($verify_token, $token);
        if (count($token) !== 2) {
            return ['status' => '9100', 'msg' => '请求错误，原因：TOKEN错误'];
        }
        if (!is_numeric($token['time']) || $token['time'] > time()) {
            return ['status' => '9110', 'msg' => '请求错误，原因：TOKEN超时'];
        }
        if (!is_numeric($token['time']) || time() - $token['time'] > $token_expired) {
            return ['status' => '9110', 'msg' => '请求错误，原因：TOKEN超时'];
        }
        // 使用 token 去redis中获取存储的用户信息
        $user_info = Redis::get($token['key']);
        if (!$user_info) {
            return ['status' => '9111', 'msg' => '请求错误，原因：TOKEN失效'];
        }
        $user_info = json_decode($user_info,true);
        $this->user_info = $user_info;
        $this->user_id = $user_info['id'];
    }

    /**
     * @Notes: 获取header头中携带的 token
     * @Author: DoKi
     * @Date: 2020/1/2
     * @Time: 10:59
     * @Interface getHeaderToken
     */
    private function getHeaderToken()
    {
        $header_token = \Request::header('token');

        return $header_token;
    }

}
