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
}