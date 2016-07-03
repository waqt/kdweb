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
* 菜单列表控制Logic
*/
class SalesLogic extends BaseLogic {
    /**
     * 获取销售商列表
     * @param array $condition 查询条件     
     * @return array
     */
    public function getSalesList($condition=null, $page=1, $limit=10) {
        if($page=='' || $page==null){
            $page=1;
        }

        $data['name']  =$condition['name'];                  //销售商名称 
        $data['phone'] =$condition['phone'];                 //销售商电话
        $data['page']            =$page;                            //分页页码
        $data['limit']           =$limit;                           //分页单页显示行数                   
        $data['token'] =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL

        if(!empty($_SESSION[C('ADMIN_AUTH_KEY')])){
            $req_url=BASE_URL.ADMIN_GET_SALES_LIST;
        }else{
            $req_url=BASE_URL.SALES_GET_SALES_LIST;
        }
    
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
     * 添加销售商
     * @param object $sales 销售商对象
     * @param string $logo_url  销售商logo路径      
     * @return array
     */
    public function addSales($sales, $logo_url=null) {
        $data          =$sales;
        $data['logo']  = $logo_url;                                               
        $data['token'] =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.ADD_SALES_URL;
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
     * 获取商户详情
     * @param Int $merchant_id 商户id       
     * @return array
     */
    public function getOrderDetail($order_id) {
        $data['order_id']        =$order_id;                            //商户ID                         //分页单页显示行数
        $data['token']           =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.GET_ORDER_DETAIL;
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
        $detail = $result['data'];
        return $detail;
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
}