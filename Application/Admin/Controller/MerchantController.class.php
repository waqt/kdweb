<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/** 
 * 类名称：MerchantController
 * 创建人：LTJ
 * 创建时间：2016年6月1日
 * @version
 */
class MerchantController extends CommonController {
  public function index(){
      $this->display();
  }

  /*
  *商户列表
  */
  public function lists(){
      $area = I('area');
      $authorize_state = I('authorize_state');
      $appliance_id = I('appliance_id');
      $phone = I('phone');
      $onlycode = I('onlycode');
      $brand_name = I('brand_name');
      $page = I('page');
      $limit = 10;
      

      $merchantLogic = new l\MerchantLogic();
      //API 获取商户数据
      $merchant_data=$merchantLogic->getMerchantList($area, $authorize_state, $appliance_id, $phone, $onlycode, $brand_name, $page, $limit);
      $merchant_list=$merchant_data['datas'];
      $list_count=$merchant_data['allcount'];
      $current=$merchant_data['current'];               //当前页
      $pages=ceil($list_count/$limit); 
      
      $data['error_code']=$merchantLogic->getErrorCode();
      $data['error_message']=$merchantLogic->getErrorMessage();
      
      $this->assign('merchant_list', $merchant_list);
      $this->assign('pages',$pages);
      $this->assign('current', $current);
      $this->assign('list_count',$list_count);
      $this->display();
  }

  /*
  *商户详情
  */
  public function detail() {
    $merchantID=I('merchant_id');
    $merchantLogic = new l\MerchantLogic();
    $merchant_data=$merchantLogic->getMerchantDetail($merchantID);
    $merchant_data['avag_score']=round($merchant_data['avag_score'],2);

    
    $role= session('user_info.role');

    $this->assign('role',$role);
    $this->assign('merchant',$merchant_data);

    $this->display();
  }


  public function agreeAuth() {
    $merchantID=I('mer_id');

    $merchantLogic = new l\MerchantLogic();
    $result=$merchantLogic->agreeMerchantAuth($merchantID);

    $data['mer_id']=$merchantID;
    $data['status']=$result['status'];
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');
  }

  public function refuseAuth() {
    $merchantID=I('mer_id');

    $merchantLogic = new l\MerchantLogic();
    $result=$merchantLogic->refuseMerchantAuth($merchantID);

    $data['mer_id']=$merchantID;
    $data['status']=$result['status'];
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');  
  }

  public function staffDetail() {
    $merchantID=I('mer_id');
    $staffID= I('staff_id');

    $merchantLogic = new l\MerchantLogic();
    $staffData=$merchantLogic->getStaffList($merchantID);

    $staffList=$staffData['datas'];

    $role= session('user_info.role');
    $this->assign('role',$role);
    $this->assign('staffList',$staffList);
    $this->assign('mer_id',$merchantID);
    $this->display();
  }

  public function staffList() {
    $merchantID=I('mer_id');

    $merchantLogic = new l\MerchantLogic();
    $staffData=$merchantLogic->getStaffList($merchantID);

    $staffList=$staffData['datas'];

    $role= session('user_info.role');
    $this->assign('role',$role);
    $this->assign('staffList',$staffList);
    $this->assign('mer_id',$merchantID);
    $this->display();
  }

  public function applyAuth() {
    return true;
  }

  public function del() {
    return true;
  }
}