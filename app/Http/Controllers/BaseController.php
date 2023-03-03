<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

/**
 * Class BaseController
 * @package App\Http\Controllers
 *  校验签名类
 */
class BaseController extends Controller
{

    public function __construct()
    {
        // $verify = $this->verifySign();
        // if ($verify['status'] == '9990') { // 签名不存在
        //     echo error($verify['msg'], '', $verify['status']);
        //     die;
        // }
        // if ($verify['status'] == '9000') { // 签名错误
        //     echo error($verify['msg'], '', $verify['status']);
        //     die;
        // }
        // if ($verify['status'] == '9900') { // 签名超时
        //     echo error($verify['msg'], '', $verify['status']);
        //     die;
        // }
    }


    /**
     * @Notes: 验证签名
     * @Author: DoKi
     * @Date: 2019/12/31
     * @Time: 17:24
     * @Interface verifySign
     */
    public function verifySign()
    {
        $sign = $this->getHeaderSign(); // header头中携带的签名
        $verify_sign = $this->createBaseSign(); // 生成的校验签名
        $sign_expire = env('SIGN_EXPIRE'); // 签名有效时间

//        dd(base64_encode('key='.$sign_expire.'&time=1577928906')); //测试签名
        if ($sign['status'] != '0000') {
            return ['status' => $sign['status'], 'msg' => $sign['msg']];
        }
        if ($sign['msg']['key'] != $verify_sign) {
            return ['status' => '9000', 'msg' => '请求错误，原因：签名错误'];
        }
        if (!is_numeric($sign['msg']['time']) || $sign['msg']['time'] > time()) {
            return ['status' => '9900', 'msg' => '请求错误，原因：签名超时'];
        }
        if (!is_numeric($sign['msg']['time']) || time() - $sign['msg']['time'] > $sign_expire) {
            return ['status' => '9900', 'msg' => '请求错误，原因：签名超时'];
        }
    }

    /**
     * @Notes: 获取deader中携带的签名
     * @Author: DoKi
     * @Date: 2019/12/31
     * @Time: 17:18
     * @Interface getHeaderSign
     */
    private function getHeaderSign()
    {
        $header_sign = \Request::header('sign');
        if (!$header_sign) {
            return ['status' => '9990', 'msg' => '请求错误，原因：签名不存在'];
        }
        // 解密（base64_decode）
        $decode_sign = base64_decode($header_sign);
        parse_str($decode_sign, $sign);
        if (count($sign) !== 2) {
            return ['status' => '9000', 'msg' => '请求错误，原因：签名错误'];
        }
        return ['status' => '0000', 'msg' => $sign];
    }


    /**
     * @Notes: 生成基础签名
     * @Author: DoKi
     * @Date: 2019/12/31
     * @Time: 17:26
     * @Interface createBaseSign
     */
    private function createBaseSign()
    {
        $verigy_str = env('VERIFY_STR');// 加密字符串

        // md5加密生成签名基础加密串
        return md5($verigy_str);
    }
}
