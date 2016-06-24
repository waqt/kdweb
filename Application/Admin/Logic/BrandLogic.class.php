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
* 电器品牌控制Logic
*/
class BrandLogic extends BaseLogic {
    /**
     * 获取电器品类列表
     * @param int $fid 品类ID
     * @param String $brand_name 品牌名称
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
     */
    public function getBrandList($fid=null, $brand_name=null, $page=1, $limit=10) {

        if($page=='' || $page==null){
            $page=1;
        }
        $data['fid']             =$fid;
        $data['brand_name']      =$brand_name;
        $data['page']            =$page;    
        $data['limit']           =$limit;                           //分页单页显示行数
        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.GET_BRAND_LIST;

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
     * 删除电器品牌
     * @param array $brand_id 品牌ID         
     * @return array
     */
    public function delBrand($brand_id) {

        $data['bid']           =$brand_id; 
        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.DELETE_BRAND_URL;

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
    public function addBrand($brand_name, $brand_url=null) {

        $data['brand_name']          =$brand_name; 
        $data['brand_url']           =$brand_url; 
        $data['token']           =session('user_info.token');
        $req_url=BASE_URL.ADD_BRAND_URL;

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