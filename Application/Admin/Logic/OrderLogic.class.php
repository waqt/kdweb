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
class OrderLogic extends BaseLogic {
    /**
     * 获取订单列表
     * @param int $order_type 订单业务类型
     * @param int $order_state 订单状态  
     * @param String $appliance 订单电器品类
     * @param int $pay_state 订单支付状态
     * @param String $brand  订单品牌
     * @param String $city  订单所在区域
     * @param String $order_code  订单号
     * @param String $user_phone  用户电话
     * @param String $mer_phone  商户电话
     * @param String $staff_phone  员工电话
     * @param String $buy_address  购买地址销售商
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
     */
    public function getOrderList($condition=null, $page=1, $limit=10) {
        if($page=='' || $page==null){
            $page=1;
        }
        $data  =$condition;                                      
        $data['page']        =$page;                            //分页页码
        $data['limit']       =$limit;                           //分页单页显示行数
        $data['token']       =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        if(!empty($_SESSION[C('ADMIN_AUTH_KEY')]))
        {
            $req_url=BASE_URL.ADMIN_GET_ORDER_URL;
        }
        else if(session('user_info.role')=='2001')
        {
            $req_url=BASE_URL.MER_GET_ORDER_URL;
        }
        else if(session('user_info.role')=='3002')
        {
            $req_url=BASE_URL.SALE_GET_ORDER_URL;
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
     * 获取订单详情
     * @param Int $order_id 订单id       
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
     * 添加订单
     * @param object $order 订单对象       
     * @return array
     */
    public function addOrder($order) {
        $data          =$order;                            //订单对象                       //分页单页显示行数
        $data['token']           =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.ADD_ORDER_URL;
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
     * 获取退单列表
     * @param String $order_code  订单号码
     * @param String $mer_phone   商户电话  
     * @param String $user_phone  客户电话
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
     */
    public function getChargeBack($condition=null, $page=1, $limit=10) {
        if($page=='' || $page==null){
            $page=1;
        }
        $data、  =$condition;                                                             
        $data['page']        =$page;                            //分页页码
        $data['limit']       =$limit;                           //分页单页显示行数
        $data['token']       =session('user_info.token');

        
        $req_url=BASE_URL.ADMIN_GET_CHARGEBACK_URL;

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
     * 获取退单详情
     * @param Int $back_id 退单id       
     * @return array
     */
    public function getOrderBackDetail($back_id) {
        $data['back_id']        =$back_id;                            //商户ID                         //分页单页显示行数
        $data['token']           =session('user_info.token');

        // API URL 管理员获取列表URL 与 商户获取列表URL
        $req_url=BASE_URL.GET_ORDER_BACK_DETAIL;
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