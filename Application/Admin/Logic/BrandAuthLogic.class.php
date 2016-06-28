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
* 品牌授权控制Logic
*/
class BrandAuthLogic extends BaseLogic {
    /**
     * 获取商户品牌申请列表
     * @param Int $merchant_id 商户id
     * @param Int $merchant_name 商户名称
     * @param Int $merchant_phone 商户详情联系电话
     * @param Int $handle_state 授权状态     
     * @return array
     */
    public function getBrandApplyList($merchant_phone=null ,$merchant_id=null,
     $merchant_name=null, $handle_state=null, $page=1, $limit=20) {
        if($page=='' || $page==null){
            $page=1;
        }
        $data['phone']           =$merchant_phone;
        $data['mer_name']        =$merchant_name;
        $data['mer_id']          =$merchant_id;                            //商户ID 
        $data['page']            =$page;            //分页单页显示行数
        $data['limit']           =$limit;            //分页单页显示行数
        $data['token']           =session('user_info.token');

        $req_url=BASE_URL.GET_BRAND_APPLY_LIST;
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
        $brand_apply_list = $result['data'];
        $brand_apply_list['current']=$page;
        return $brand_apply_list;
    }

    /**
     * 获取商户已授权品牌列表
     * @param Int $merchant_id 商户id 
     * @return array
     */
    public function getAchieveBrandList($merchant_id=null) {

        $data['mer_id']          =$merchant_id;                            //商户ID 
        $data['token']           =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.GET_ACHIEVE_BRAND_LIST;
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
        $achieve_brand_list = $result['data'];
        return $achieve_brand_list;
    }

    /**
     * 获取品牌授权申请详情
     * @param Int $apply_id 申请id 
     * @return array
     */
    public function getApplyDetail($apply_id=null) {

        $data['apply_brand_id']          =$apply_id;                            //商户ID 
        $data['token']           =session('user_info.token');

    
        $req_url=BASE_URL.GET_BRAND_APPLY_DETAIL;
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
        $achieve_brand_list = $result;
        return $achieve_brand_list;
    }

       /**
     * 拒绝商户认证
     * @param  Int $applyId 申请id
     * @param  array $reason 意见理由        
     * @return array
     */
    public function disagreeApply($applye_id, $reason=null) {
        $data['apply_brand_id']  =$applye_id;                            //申请ID                        //分页单页显示行数
        $data['reason']          =$reason;
        $data['token']           =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.DISAGREE_BRAND_APPLY;
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
     * 同意商户认证
     * @param  Int $applyId 申请id
     * @param  array $brandList 授权品牌列表
     * @param  array $reason 意见理由           
     * @return array
     */
    public function agreeBrand($applyId, $brandList=null, $reason=null) {
        $data['apply_brand_id']  =$applyId;
        $data['brand_id']        =$brandList;                   //申请ID                        //分页单页显示行数
        $data['reason']          =$reason;
        $data['token']           =session('user_info.token');

        //addErrorLog('BrandAuth','logic','agreeBrand',$brandList);

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.AGREE_BRAND_APPLY;
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
}