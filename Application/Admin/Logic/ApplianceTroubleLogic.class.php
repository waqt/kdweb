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
* 电器故障控制Logic
*/
class ApplianceTroubleLogic extends BaseLogic {
    /**
     * 获取电器故障列表
     * @param int $fl_id 父类ID
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
     */
    public function getTroubleList($condition=null, $page=1, $limit=10) {

        if($page=='' || $page==null){
            $page=1;
        }
        $data['appliance_id'] =$condition['father_id'];
        $data['son_id']       =$condition['son_id'];
        $data['page']         =$page;    
        $data['limit']        =$limit;                           //分页单页显示行数
        $data['token']        =session('user_info.token');
        $req_url=BASE_URL.TROUBLE_LIST_URL;

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
     * 删除电器故障
     * @param array $break_id 故障ID         
     * @return array
     */
    public function delTrouble($break_id) {

        $data['break_id']           =$break_id; 
        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.DELETE_TROUBLE_URL;

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
     * 添加电器故障
     * @param obj $trouble 故障对象     
     * @return array
     */
    public function addTrouble($trouble) {

        $data['break_name']   =$trouble['break_name'];
        $data['appliance_id'] =$trouble['father_id'];
        $data['son_id']       =$trouble['son_id'];
        $data['token']        =session('user_info.token');

        $req_url=BASE_URL.ADD_TROUBLE_URL;

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