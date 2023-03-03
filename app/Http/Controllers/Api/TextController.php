<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\BaseController;
use App\Http\Controllers\VerifyTokenController;
use Illuminate\Http\Request;

class TextController extends BaseController
{
    /**
     * @Notes: 测试获取登录信息
     * @Author: DoKi
     * @Date: 2020/1/2
     * @Time: 13:14
     * @Interface text_token
     */
    public function text_token()
    {
        dd($this->user_id);
    }
    
    
    /**
     * @NodeAnotation(title="定标接口")
     */
	public function send_succ(){
		$url = "http://jpbao.zhongfeitong.com/jpbao/v1/auctioneer/syncEntrustDispose";
        $data = ['sign'=>"Kb3BLAP5NHDrfgJbihoCyMcv","app_id"=>"73054371", "timestamp"=>"1667152031",
        "biz_content"=>"{\"entrust_code\":\"2022110101\",\"docking_status\":\"10030\"}"];
		$res = $this->curl_post($url,$data,2);     
		return $res;
		if($res['code'] == 000000){
		    return json_encode($res);
		}
		return json_encode($res);
		
	}
	
	public function syncAuction(){
	
		
		$url = "http://jpbao.zhongfeitong.com/jpbao/v1/auctioneer/syncAuction";
        $data = ['entrust_code'=>'2022101801','auction_code'=>'106','auction_name'=>'河北石家庄某企业废铁一批','auction_status'=>'20030','auction_status_name'=>'已结束','auction_start_time'=>'2022-10-18 12:01:12','signup_start_time'=>'2022-10-18 14:01:12','signup_end_time'=>'2022-10-18 14:31:12','check_start_time'=>'2022-10-18 13:01:12','check_end_time'=>'2022-10-18 14:01:12'];
         $aa = [];
         $aa['sign'] = "Kb3BLAP5NHDrfgJbihoCyMcv";
         $aa['app_id'] = "73054371";
         $aa['timestamp'] = time();
         $aa['biz_content'] = json_encode($data);
		$res = $this->curl_post($url,$aa,2);     
		return $res;
		if($res['code'] == 000000){
		    return json_encode($res);
		}
		return json_encode($res);
		
	}
	
		public function syncCorpore(){
	
		
		$url = "http://jpbao.zhongfeitong.com/jpbao/v1/auctioneer/syncCorpore";
         $data = ['auction_code'=>'106','corpore_code'=>'320','corpore_name'=>'废铁一批','material_code'=>'1','start_price'=>'3','reserve_price'=>'5','estimate_qty'=>'5','pc_link'=>'www.baidu.com',"material_unit"=>"吨","material_unit_name"=>"吨"];
         $aa = [];
         $aa['sign'] = "Kb3BLAP5NHDrfgJbihoCyMcv";
         $aa['app_id'] = "73054371";
         $aa['timestamp'] = time();
         $aa['biz_content'] = json_encode($data);
        
		$res = $this->curl_post($url,$aa,2);     
		return $res;
		if($res['code'] == 000000){
		    return json_encode($res);
		}
		return json_encode($res);
		
	}
    
    function curl_post($url,$data,$body=0){
      
		$curl_con = curl_init();
		curl_setopt($curl_con, CURLOPT_URL,$url);
		curl_setopt($curl_con, CURLOPT_HEADER, false);
		curl_setopt($curl_con, CURLOPT_POST, true);
		curl_setopt($curl_con, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($curl_con, CURLOPT_CONNECTTIMEOUT, 5);
		if($body==1){
			$data = http_build_query($data);
		}elseif($body==2){
			$data = json_encode($data,JSON_UNESCAPED_UNICODE);
			curl_setopt($curl_con, CURLOPT_HTTPHEADER, array(
				'Content-Type: application/json',
				'Content-Length: ' . strlen($data))
			);
		}  
		curl_setopt($curl_con, CURLOPT_POSTFIELDS, $data);
		$res = curl_exec($curl_con);
	 
		//var_dump($res);
		$status = curl_getinfo($curl_con);
	    
		//var_dump($status);  
		curl_close($curl_con);
	 
		if (isset($status['http_code']) && $status['http_code'] == 200) {
			return $res;
		} else {
			return $res;
		}
	}
}
