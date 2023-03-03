<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\BaseController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\Targets;
use App\Models\Api\Items;
use App\Models\Api\Auction;

class IndexController extends BaseController
{
    public function index()
    {
        return success('成功了');
    }

    /**
     * @Notes: 测试登录
     * @Author: gxk
     * @Date: 2020/1/2
     * @Time: 11:50
     * @Interface textLogin
     */
    public function textLogin()
    {
        dd(12);
        $token = createToken(1);
        //        dd(decrypt($token));
        dd($token);
    }
    /**
     * 处置申请单推送
     */

    public function pushDisposaApplicationForm(Request $request, Targets $targets, Items $items)
    {

        $data = $request->all();
        $biz_content = $request->post('biz_content');
        $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
        file_put_contents($file, "处置申请单推送：" . date("Y-m-d H:i:s") . "--请求数据：" . json_encode($data) . "\n", FILE_APPEND);
        if ($biz_content) {
            $entrust = json_decode($biz_content, true);
            if (isset($entrust['items'])) {
                $list = $entrust['items'];
                unset($entrust['items']);
                $id = $targets->insert($entrust);
                foreach ($list as $k => $v) {
                    $v['entrust_code'] = $entrust['entrust_code'];
                    if (isset($v['material_image'])) {
                        $v['material_image'] = json_encode($v['material_image']);
                    }
                    if (isset($v['attachment'])) {
                        $v['attachment'] = json_encode($v['attachment']);
                    }
                    $aa = $items->insert($v);
                }
                return success('');
            } else {
                $id = $targets->insert($entrust);
                if ($id) {
                    return success('');
                }
            }
        } else {
            return error('参数信息异常');
        }
    }
    /**
     * 标的结算单上传
     */

    public function uploadTargetSettlement(Request $request)
    {

        $data = $request->all();
        $biz_content = $request->post('biz_content');
        $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
        file_put_contents($file, "标的结算单上传：" . date("Y-m-d H:i:s") . "--请求数据：" . json_encode($data) . "\n", FILE_APPEND);
        if ($biz_content) {

            return success('');
        } else {
            return error('参数信息异常');
        }
    }
    /**
     * 标的最高价审批推送
     *
     * @param Request $request
     * @return void
     */
    public function approvalPushHighestPrice(Request $request)
    {

        $data = $request->all();
        $biz_content = $request->post('biz_content');
        $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
        file_put_contents($file, "标的最高价审批推送：" . date("Y-m-d H:i:s") . "--请求数据：" . json_encode($data) . "\n", FILE_APPEND);
        if ($biz_content) {
            return success('');
        } else {
            return error('参数信息异常');
        }
    }

    /**
     * 获取处置单关联拍卖会及标的编号
     *
     * @param Request $request
     * @return void
     */
    public function getAuctionTargetNum(Request $request, Targets $targets, Items $items, Auction $auction)
    {

        $data = $request->all();
        $biz_content = $request->post('biz_content');
        $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
        file_put_contents($file, "获取处置单关联拍卖会及标的编号：" . date("Y-m-d H:i:s") . "--请求数据：" . json_encode($data) . "\n", FILE_APPEND);
        if ($biz_content) {
            $l = json_decode($biz_content);
            if (isset($l->entrust_code)) {
                $aa = $targets->getData($l->entrust_code);
                $params = $this->getParams($aa->url);
                if (!empty($params['auction_id'])) {
                    $auction_data = $auction->getData($params['auction_id']);
                    return $auction_data;
                } else {
                    return error('参数信息异常');
                }
            }
        } else {
            return error('参数信息异常');
        }
    }


    public function getAuctionInfo(Request $request)
    {

        $data = $request->all();
        $biz_content = $request->post('biz_content');
        $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
        file_put_contents($file, "获取拍卖会信息：" . date("Y-m-d H:i:s") . "--请求数据：" . json_encode($data) . "\n", FILE_APPEND);
        if ($biz_content) {
            $aaa = json_decode($biz_content);
            if ($aaa->entrust_code == 2022101801) {
                $data = ['entrust_code' => '2022101801', 'auction_code' => '106', 'auction_name' => '河北石家庄某企业废铁一批', 'auction_status' => '449700230003', 'auction_status_name' => '已结束', 'auction_start_time' => '2022-10-18 12:00:00', 'signup_start_time' => '2022-10-18 14:00:00', 'signup_end_time' => '2022-10-18 14:30:00', 'check_start_time' => '2022-10-18 13:00:00', 'check_end_time' => '2022-10-18 13:00:01'];
                return success('', $data);
            } else {
                return success('处置单未关联拍卖会');
            }
        } else {
            return error('参数信息异常');
        }
    }

    public function getTargetInfo(Request $request)
    {

        $data = $request->all();
        $biz_content = $request->post('biz_content');
        $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
        file_put_contents($file, "获取拍卖会标的信息：" . date("Y-m-d H:i:s") . "--请求数据：" . json_encode($data) . "\n", FILE_APPEND);
        if ($biz_content) {
            $aaa = json_decode($biz_content);
            if ($aaa->entrust_code == 2022101801) {
                $data = ['auction_code' => '106', 'corpore_code' => '320', 'corpore_name' => '废铁一批', 'material_code' => '1', 'start_price' => '3', 'reserve_price' => '5', 'estimate_qty' => '5', 'pc_link' => 'www.baidu.com', "material_unit" => "吨", "material_unit_name" => "吨", 'corpore_status' => '4497005900010002', 'report_url' => '中标报告书|www.baidu.com', 'top_audit_report_url' => '审批书|www.baidu.com', 'real_count' => '5', 'signups' => 5, 'checkers' => ''];
                return success('', $data);
            } else {
                return success('处置单未关联拍卖会');
            }
        } else {
            return error('参数信息异常');
        }
    }
    public function getTargetStatementList(Request $request)
    {

        $data = $request->all();
        $biz_content = $request->post('biz_content');
        $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
        file_put_contents($file, "获取拍卖会标的结算列表：" . date("Y-m-d H:i:s") . "--请求数据：" . json_encode($data) . "\n", FILE_APPEND);
        if ($biz_content) {
            $aaa = json_decode($biz_content);
            if ($aaa->entrust_code == 2022101801) {
                $data = ['entrust_code' => '2022101801', 'statement_status' => 1, 'statement_name' => '结算单', 'corpore_code' => '320', 'statement_url' => 'www.baidu.com', 'statement_code ' => 78, 'work_report' => '[{file_name:"竞拍报告书",file_uUrl:"www.baidu.com"}]'];
                return success('', $data);
            } else {
                return success('处置单未关联拍卖会');
            }
        } else {
            return error('参数信息异常');
        }
    }

    public function getTargetParticipationList(Request $request)
    {

        $data = $request->all();
        $biz_content = $request->post('biz_content');
        $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
        file_put_contents($file, "获取标的参拍信息列表：" . date("Y-m-d H:i:s") . "--请求数据：" . json_encode($data) . "\n", FILE_APPEND);
        if ($biz_content) {
            $aaa = json_decode($biz_content);
            if ($aaa->entrust_code == 2022101801) {
                $data = ['auction_code' => '106', 'auth_type' => 1, 'mobile' => '15122222222', 'corpore_code' => '320', 'real_name' => '张三', 'bidding_result' => 1, 'id_number' => '130220200001015236', 'bidding_code' => 'L5986', 'bid_price' => '5', 'bid_time' => '2022-10-18 12:00:00'];
                return success('', $data);
            } else {
                return success('处置单未关联拍卖会');
            }
        } else {
            return error('参数信息异常');
        }
    }


    public function getTargetWatcherInfo(Request $request)
    {

        $data = $request->all();
        $biz_content = $request->post('biz_content');
        $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
        file_put_contents($file, "获取标的看货报名信息列表：" . date("Y-m-d H:i:s") . "--请求数据：" . json_encode($data) . "\n", FILE_APPEND);
        if ($biz_content) {
            $aaa = json_decode($biz_content);
            if ($aaa->entrust_code == 2022101801) {
                $data = ['auction_code' => '106', 'auth_type' => 1, 'mobile' => '15122222222', 'corpore_code' => '320', 'real_name' => '张三', 'bidding_result' => 1, 'id_number' => '130220200001015236', 'bidding_code' => 'L5986', 'is_check' => 1];
                return success('', $data);
            } else {
                return success('处置单未关联拍卖会');
            }
        } else {
            return error('参数信息异常');
        }
    }

    /**
     * 获取url参数
     */

    function getParams($url)

    {

        $refer_url = parse_url($url);
        $params = $refer_url['query'];
        $arr = array();
        if (!empty($params)) {

            $paramsArr = explode('&', $params);
            foreach ($paramsArr as $k => $v) {
                $a = explode('=', $v);
                $arr[$a[0]] = $a[1];
            }
        }
        return $arr;
    }
}
