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
* 电器品类控制Logic
*/
class ApplianceLogic extends BaseLogic {
    /**
     * 获取电器品类列表
     * @param int $fl_id 父类ID
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
     */
    public function getApplianceList($fl_id=null, $page=1, $limit=10) {

        $data['fl_id']           =$fl_id;
        $data['page']            =$page;    
        $data['limit']           =$limit;                           //分页单页显示行数
        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.APPLIANCE_LIST_URL;

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
        $appliance_list = $result['data'];
        return $appliance_list;
    }

    /**
     * 获取电器品类(父类)列表     
     * @return array
     */
    public function getApplianceFatherList() {

        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.APPLIANCE_FATHER_LIST_URL;

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
        $father_list = $result['data'];
        /****************
        $data['module'] = MODULE_NAME;
        $data['action'] = ACTION_NAME;
        $data['dataname'] = "father_list";
        $data['data'] = $father_list;
        addErrorLog($data['action'],$data['module'],$data['dataname'],$data['data']);
        ***************/
        return $father_list;
    }  


    /**
     * 删除电器品类
     * @param array $appliance_id 品类ID         
     * @return array
     */
    public function delAppliance($appliance_id) {

        $data['appliance_id']           =$appliance_id; 
        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.DELETE_APPLIANCE_URL;

        try{
            $result=request_post($req_url,$data);
            $result=json_decode($result,true);
        }
        catch(\Exception $e){
            print $e->getMessage();
            exit();
        } 
        return $result;
    } 



    /**
     * 添加电器品类
     * @param array $appliance_name 品类名称
     * @param array $input_name 商户端图标控件
     * @param array $input_name2 商户端小图标控件
     * @param array $input_name3 用户端图标控件          
     * @return array
     */
    public function addAppliance($appliance_name, $input_name=null ,$input_name2=null ,$input_name3=null) {

        $data['appliance_name']           =$appliance_name; 
        $data['input_name']           =$input_name; 
        $data['input_name2']           =$input_name2; 
        $data['input_name3']           =$input_name3; 
        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.ADD_FATHER_APPLIANCE_URL;

        try{
            $result=request_post($req_url,$data);
            $result=json_decode($result,true);
        }
        catch(\Exception $e){
            print $e->getMessage();
            exit();
        } 
        return $result;
    } 
}