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
* 用户管理控制Logic
*/
class CustomerLogic extends BaseLogic {
    /**
     * 获取商户列表
     * @param String $phone 用户手机号
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
     */
    public function getCustomerList($phone=null ,$page=1, $limit=10) {
        if($page=='' || $page==null){
            $page=1;
        }
        $data['condition']       =$phone;                           //用户注册电话
        $data['page']            =$page;                            //分页页码
        $data['limit']           =$limit;                           //分页单页显示行数
        $data['token']           =session('user_info.token');


        $req_url=BASE_URL.GET_CUSTOMER_LIST_URL;
        // API URL 管理员获取列表URL 与 商户获取列表URL
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
     * 获取用户详情
     * @param Int $customer_id 用户id       
     * @return array
     */
    public function getCustomerDetail($customer_id) {
        $data['user_id']          =$customer_id;                            //商户ID                         //分页单页显示行数
        $data['token']           =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.GET_CUSTOMER_DETAIL_URL;
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



}