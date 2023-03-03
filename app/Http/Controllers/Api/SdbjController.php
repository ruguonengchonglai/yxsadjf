<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Api\TargetsSd;
use App\Models\Api\Items;
use App\Models\Api\Auction;

class SdbjController extends Controller
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
        $token = createToken(1);
//        dd(decrypt($token));
        dd($token);
        
        
    }
    /**
     * 处置申请单推送
     */
        
     public function pushDisposaApplicationForm(Request $request,TargetsSd $targets)
    {
         
            $data = $request->all();
            $biz_content = $request->post('bizContent');
            $appId = '73054371';
            $app_secret = 'Kb3BLAP5NHDrfgJbihoCyMcv';
             if(!isset($data['appId'])){
                return sdbjerror('没有appId');
             }else{
                if($data['appId'] != $appId){
                    return sdbjerror('appId不正确');  
                }
             }
             $sign = md5($biz_content.$appId.$app_secret);
             if(!isset($data['sign'])){
                return sdbjerror('没有sign');
             }else{
                if($data['sign'] != $sign){
                    return sdbjerror('sign不正确');  
                }
             }
             $file = "/www/wwwroot/laravel9.33.0/log/sdbj.log";
             file_put_contents($file,"处置申请单推送：".date("Y-m-d H:i:s")."--请求数据：". json_encode($data)."\n",FILE_APPEND);
            if($biz_content){
               
                $entrust = json_decode($biz_content,true);
               
                if(isset($entrust['images'])){
                    $entrust['images'] = json_encode($entrust['images']);
                }
                if(isset($entrust['items'])){
                    $entrust['items'] = json_encode($entrust['items']);
                }
               
                    $id = $targets->insert($entrust);
                    if($id){
                        return sdbjsuccess();
                    }else{
                        return sdbjerror('处置信息'.$entrust['id'].'已存在');
                    }
                
            }else{
                return sdbjerror('参数信息异常');
            }     
            
       
    }
        /**
         * 标的结算单上传
         */
    
     public function uploadTargetSettlement(Request $request,TargetsSd $targets)
    {
        
                $data = $request->all();
                $biz_content = $request->post('param');
                  $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
			       file_put_contents($file,"标的结算单上传：".date("Y-m-d H:i:s")."--请求数据：". json_encode($data)."\n",FILE_APPEND);
			     $file = "/www/wwwroot/laravel9.33.0/log/ceshi.log";
			     $data = file_get_contents($file);
			     $biz_content = json_decode($data)->biz_content;
			     
			     return $aa;
                if($biz_content){
                 
                    return success('');
                }else{
                    return error('参数信息异常');
                }  
                $data = $request->all();
                $biz_content = $request->post('bizContent');
                $appId = '73054371';
                $app_secret = 'Kb3BLAP5NHDrfgJbihoCyMcv';
                $methodNum = '401';
                 if(!isset($data['appId'])){
                    return error('没有appId');
                 }else{
                    if($data['appId'] != $appId){
                        return error('appId不正确');  
                    }
                 }
                 $sign = md5($biz_content.$appId.$methodNum.$app_secret);
                 if(!isset($data['sign'])){
                    return error('没有sign');
                 }else{
                    if($data['sign'] != $sign){
                        return error('sign不正确');  
                    }
                 }
                 $file = "/www/wwwroot/laravel9.33.0/log/sdbj.log";
			     file_put_contents($file,"处置申请单推送：".date("Y-m-d H:i:s")."--请求数据：". json_encode($data)."\n",FILE_APPEND);
                if($biz_content){
                   
                    $entrust = json_decode($biz_content,true);
                    if(isset($entrust['images'])){
                        $entrust['images'] = json_encode($entrust['images']);
                    }
                    if(isset($entrust['items'])){
                        $entrust['items'] = json_encode($entrust['items']);
                    }
                   
                        $id = $targets->insert($entrust);
                        if($id){
                            return response([
                                'code' => '200',
                                'message' => "操作成功",
                                'data' => ''
                            ])->header('Content-Type', 'application/json');
                        }else{
                            return error('重复提交');
                        }
                        
                    
                }else{
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
			        file_put_contents($file,"标的最高价审批推送：".date("Y-m-d H:i:s")."--请求数据：". json_encode($data)."\n",FILE_APPEND);
                if($biz_content){
                    return success('');
                }else{
                    return error('参数信息异常');
                }     
            
       
    }
    
   /**
    * 获取处置单关联拍卖会及标的编号
    *
    * @param Request $request
    * @return void
    */
    public function getAuctionTargetNum(Request $request,TargetsSd $targets,Items $items,Auction $auction)
    {
        
                $entrustCode = $request->get('entrustCode');
                if(!empty($entrustCode)){
                    
                    $aa = $targets->getData($entrustCode);
                    $params = $this->getParams($aa->url);
                    if(!empty($params['auction_id'])){
                        $auction_data = $auction->getData($params['auction_id']);
                        return $auction_data;
                    }else{
                        return error('参数信息异常');
                    }
                                         
                }else{
                    return error('参数信息异常');
                }     
            
       
    }


    public function getAuctionInfo(Request $request)
    {
        
                $data = $request->all();
                $biz_content = $request->post('biz_content');
                  $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
			        file_put_contents($file,"获取拍卖会信息：".date("Y-m-d H:i:s")."--请求数据：". json_encode($data)."\n",FILE_APPEND);
                if($biz_content){
                     $aaa = json_decode($biz_content);
                     if($aaa->entrust_code == 2022101801){
                        $data = ['entrust_code'=>'2022101801','auction_code'=>'106','auction_name'=>'河北石家庄某企业废铁一批','auction_status'=>'449700230003','auction_status_name'=>'已结束','auction_start_time'=>'2022-10-18 12:00:00','signup_start_time'=>'2022-10-18 14:00:00','signup_end_time'=>'2022-10-18 14:30:00','check_start_time'=>'2022-10-18 13:00:00','check_end_time'=>'2022-10-18 13:00:01'];
                        return success('',$data);
                     }else{
                          return success('处置单未关联拍卖会');
                     }
                    
                }else{
                    return error('参数信息异常');
                }     
            
       
    }

    public function getTargetInfo(Request $request)
    {
        
                $data = $request->all();
                $biz_content = $request->post('biz_content');
                 $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
			        file_put_contents($file,"获取拍卖会标的信息：".date("Y-m-d H:i:s")."--请求数据：". json_encode($data)."\n",FILE_APPEND);
                if($biz_content){
                    $aaa = json_decode($biz_content);
                     if($aaa->entrust_code == 2022101801){
                        $data = ['auction_code'=>'106','corpore_code'=>'320','corpore_name'=>'废铁一批','material_code'=>'1','start_price'=>'3','reserve_price'=>'5','estimate_qty'=>'5','pc_link'=>'www.baidu.com',"material_unit"=>"吨","material_unit_name"=>"吨",'corpore_status'=>'4497005900010002','report_url'=>'中标报告书|www.baidu.com','top_audit_report_url'=>'审批书|www.baidu.com','real_count'=>'5','signups'=>5,'checkers'=>''];
                        return success('',$data);
                     }else{
                          return success('处置单未关联拍卖会');
                     }
                    
                }else{
                    return error('参数信息异常');
                }     
            
       
    }
     public function getTargetStatementList(Request $request)
    {
        
                $data = $request->all();
                $biz_content = $request->post('biz_content');
                 $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
			        file_put_contents($file,"获取拍卖会标的结算列表：".date("Y-m-d H:i:s")."--请求数据：". json_encode($data)."\n",FILE_APPEND);
                if($biz_content){
                     $aaa = json_decode($biz_content);
                     if($aaa->entrust_code == 2022101801){
                        $data = ['entrust_code'=>'2022101801','statement_status'=>1,'statement_name'=>'结算单','corpore_code'=>'320','statement_url'=>'www.baidu.com','statement_code '=>78,'work_report'=>'[{file_name:"竞拍报告书",file_uUrl:"www.baidu.com"}]'];
                        return success('',$data);
                     }else{
                          return success('处置单未关联拍卖会');
                     }
                }else{
                    return error('参数信息异常');
                }     
            
       
    }
    
    public function getTargetParticipationList(Request $request)
    {
        
                $data = $request->all();
                $biz_content = $request->post('biz_content');
                 $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
			        file_put_contents($file,"获取标的参拍信息列表：".date("Y-m-d H:i:s")."--请求数据：". json_encode($data)."\n",FILE_APPEND);
                if($biz_content){
                     $aaa = json_decode($biz_content);
                     if($aaa->entrust_code == 2022101801){
                        $data = ['auction_code'=>'106','auth_type'=>1,'mobile'=>'15122222222','corpore_code'=>'320','real_name'=>'张三','bidding_result'=>1,'id_number'=>'130220200001015236','bidding_code'=>'L5986','bid_price'=>'5','bid_time'=>'2022-10-18 12:00:00'];
                        return success('',$data);
                     }else{
                          return success('处置单未关联拍卖会');
                     }
                    
                }else{
                    return error('参数信息异常');
                }     
            
       
    }
    
    
     public function getTargetWatcherInfo(Request $request)
    {
        
                $data = $request->all();
                $biz_content = $request->post('biz_content');
                 $file = "/www/wwwroot/laravel9.33.0/log/jupai.log";
			        file_put_contents($file,"获取标的看货报名信息列表：".date("Y-m-d H:i:s")."--请求数据：". json_encode($data)."\n",FILE_APPEND);
                if($biz_content){
                    $aaa = json_decode($biz_content);
                     if($aaa->entrust_code == 2022101801){
                        $data = ['auction_code'=>'106','auth_type'=>1,'mobile'=>'15122222222','corpore_code'=>'320','real_name'=>'张三','bidding_result'=>1,'id_number'=>'130220200001015236','bidding_code'=>'L5986','is_check'=>1];
                        return success('',$data);
                     }else{
                          return success('处置单未关联拍卖会');
                     }
                    
                   
                }else{
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
        if(!empty($params)) {

        $paramsArr = explode('&',$params);
            foreach($paramsArr as $k=>$v){
            $a = explode('=',$v);
            $arr[$a[0]] = $a[1];
            }
        }
        return $arr;
    }


    /**
     * 内嵌页面
     */

    public function getAuction(Request $request,TargetsSd $targets,Auction $auction)
    {
        
                $entrustCode = $request->get('entrustCode');
                if(!empty($entrustCode)){
                  $data = $targets->getDetailByEntryId($entrustCode);
                   if(isset($data->auction_id)){
                     $auc_data = $auction->getData($data->auction_id);
                     if(!isset($auc_data)){
                         $list = ['data'=> $data,'auc_data'=>'','tar_data'=>''];
                         return response([
                        'code' => '200',
                        'message' => "操作成功",
                        'data' => $list
                       ])->header('Content-Type', 'application/json');
                     }
                     unset($auc_data->notice);
                     $tar_data = $auction->getTarData($data->auction_id);
                     if(!$tar_data){
                        $list = ['data'=> $data,'auc_data'=>$auc_data,'tar_data'=>''];
                         return response([
                        'code' => '200',
                        'message' => "操作成功",
                        'data' => $list
                       ])->header('Content-Type', 'application/json');
                     }
                     $aa = json_decode($data->items,true);
                     for ($i = 0; $i < count($aa); $i++) {
                          $tar_data[$i]->quantity = $aa[$i]['quantity'];
                     }
                     $list = ['data'=> $data,'auc_data'=>$auc_data,'tar_data'=>$tar_data];
                     return response([
                        'code' => '200',
                        'message' => "操作成功",
                        'data' => $list
                    ])->header('Content-Type', 'application/json');
                   }else{
                    return error('ID为空或ID不存在!');
                   }
                   }else{
                    return error('参数信息异常');
                   }
    }
    
    /**
     * 处置反馈
     * 
     **/
            
    public function updateFankui(Request $request,TargetsSd $targets,Auction $auction)
    {
        
                $entrustCode = $request->post('entrustCode');
                $feedback = $request->post('feedback');
                if(!empty($entrustCode)){
                  $data = $targets->getDetailByEntryId($entrustCode);
                    $res = $targets->updateByEntryId($entrustCode,['feedback'=>$feedback]);
                       return response([
                        'code' => '200',
                        'message' => "操作成功",
                        'data' => $feedback
                    ])->header('Content-Type', 'application/json');
                   }else{
                    return error('ID为空或ID不存在!');
                   }
    }
    
    
     /**
     * 评价
     * 
     **/
            
    public function updateEvaluate(Request $request,TargetsSd $targets,Auction $auction)
    {
        
                $entrustCode = $request->post('entrustCode');
                $evaluate = $request->post('evaluate');
                if(!empty($entrustCode)){
                  $data = $targets->getDetailByEntryId($entrustCode);
                    $res = $targets->updateByEntryId($entrustCode,['evaluate'=>$evaluate]);
                       return response([
                        'code' => '200',
                        'message' => "操作成功",
                        'data' => $evaluate
                    ])->header('Content-Type', 'application/json');
                   }else{
                    return error('ID为空或ID不存在!');
                   }
    }
    

                        
    
    
}
