<?php
// +----------------------------------------------------------------------
// | Ikuaidian  快点后台管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 http://www.ikuaidian.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liutj
// +----------------------------------------------------------------------

namespace Admin\Logic;
use Lib\Log;

/**
* 商户列表控制Logic
*/
class MerchantLogic extends BaseLogic {
    /**
     * 获取商户列表
     * @param String $area 用户所在区域
     * @param int $authorize_state 商户认证状态
     * @param int $appliance_id 商户技能品类  
     * @param String $phone 商户注册手机号
     * @param String $onlycode 商户唯一标识码
     * @param String $brand_name  商户授权品牌
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
     */
    public function getMerchantList($merchant=null, $page=1, $limit=10) {
        if($page=='' || $page==null){
            $page=1;
        }
        $data = $merchant;
        $data['page']            =$page;                            //分页页码
        $data['limit']           =$limit;                           //分页单页显示行数
        $data['token']           =session('user_info.token');


        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.ADMIN_GET_MERCHANT_URL;
        /********
        if(!empty($_SESSION[C('ADMIN_AUTH_KEY')])){
            $req_url=BASE_URL.ADMIN_GET_MERCHANT_URL;
        }else{
            $req_url=BASE_URL.MER_GET_MERCHANT_URL;
        }
        **********/
        try{
            $result=request_post($req_url,$data);
            $result=json_decode($result,true);
        }
        catch(\Exception $e){
            print $e->getMessage();
            exit();
        } 
        $this->errorCode = $result['status'];
        $this->errorMessage = $result['message'];
        $list = $result['data'];
        $list['current']=$page;
        return $list;
    } 


    /**
     * 获取商户详情
     * @param Int $merchant_id 商户id       
     * @return array
     */
    public function getMerchantDetail($merchant_id) {
        $data['mer_id']          =$merchant_id;                            //商户ID                         //分页单页显示行数
        $data['token']           =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.GET_MERCHANT_DETAIL;
        try{
            $result=request_post($req_url,$data);
            $result=json_decode($result,true);
        }
        catch(\Exception $e){
            print $e->getMessage();
            exit();
        } 
        $this->errorCode = $result['status'];
        $this->errorMessage = $result['message'];
        $merchant_detail = $result['data'];
        return $merchant_detail;
    }




     /**
     * 同意商户认证
     * @param Int $merchant_id 商户id       
     * @return array
     */
    public function agreeMerchantAuth($merchant_id) {
        $data['mer_id']          =$merchant_id;                            //商户ID                         //分页单页显示行数
        $data['token']           =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.AGREE_MERCHANT_AUTH;
        try{
            $result=request_post($req_url,$data);
            $result=json_decode($result,true);
        }
        catch(\Exception $e){
            print $e->getMessage();
            exit();
        } 
        $this->errorCode = $result['status'];
        $this->errorMessage = $result['message'];
        return $result;
    }

    /**
     * 拒绝商户认证
     * @param Int $merchant_id 商户id       
     * @return array
     */
    public function refuseMerchantAuth($merchant_id) {
        $data['mer_id']          =$merchant_id;                            //商户ID                         //分页单页显示行数
        $data['token']           =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.REFUSE_MERCHANT_AUTH;
        try{
            $result=request_post($req_url,$data);
            $result=json_decode($result,true);
        }
        catch(\Exception $e){
            print $e->getMessage();
            exit();
        } 
        $this->errorCode = $result['status'];
        $this->errorMessage = $result['message'];
        return $result;
    }

    /**
     * 获取商户员工列表
     * @param Int $mer_id 商户id    
     * @return array
     */
    public function getStaffList($mer_id=null) {
        $data['mer_id']          =$mer_id;
        $data['token']           =session('user_info.token');

        $req_url=BASE_URL.GET_MER_STAFF_LIST;
        try{
            $result=request_post($req_url,$data);
            $result=json_decode($result,true);
        }
        catch(\Exception $e){
            print $e->getMessage();
            exit();
        } 
        $this->errorCode = $result['status'];
        $this->errorMessage = $result['message'];
        $list = $result['data'];
        return $list;
    }
}