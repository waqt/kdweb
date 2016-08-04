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
* 清洗保养控制Logic
*/
class CleanGoodsLogic extends BaseLogic {
    /**
     * 获取清洗保养类别列表
     * @return array
     */
    public function getKindsList() {

        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.GET_CLEANGOODS_LIST;

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

    /**
     * 删除清洗保养品类
     * @param array $appliance_id 品类ID         
     * @return array
     */
    public function delCleanKind($protect_type_id) {

        $data['protect_type_id']           =$protect_type_id; 
        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.DELETE_CLEAN_KIND_URL;

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
     * 添加清洗保养品类
     * @param object $cleanKind  清洗保养品类        
     * @return array
     */
    public function addCleanKind($cleanKind) {

        $data       =$cleanKind;
        $data['token']       =session('user_info.token');
        $req_url=BASE_URL.ADD_CLEAN_KIND_URL;
        //\Think\Log::record($data['name']);
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