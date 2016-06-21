<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/**
* 商户管理控制器
*/
class MerchantController extends CommonController {
  public function index(){
      $this->display();
  }

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
      $pages=ceil($list_count/$limit);
      
      $data['error_code']=$merchantLogic->getErrorCode();
      $data['error_message']=$merchantLogic->getErrorMessage();
      
      $this->assign('merchant_list', $merchant_list);
      $this->assign('pages',$pages);
      $this->assign('list_count',$list_count);
      $this->display();
  }

  public function detail() {
    $merchantID=I('merchant_id');
    $merchantLogic = new l\MerchantLogic();
    $merchant_data=$merchantLogic->getMerchantDetail($merchantID);
    $merchant_data['avag_score']=round($merchant_data['avag_score'],2);

    
    $role= session('user_info.role');
    /**********
    $module=MODULE_NAME;
    $action=ACTION_NAME;
    $menu_logic = new l\MenuLogic();
    **************/
    $this->assign('role',$role);
    $this->assign('merchant',$merchant_data);
    /***************
    $data['module'] = MODULE_NAME;
    $data['action'] = ACTION_NAME;
    $data['dataname'] ='merchant_id';
    $data['data']=$merchant_data;
    addErrorLog($data['action'],$data['module'],$data['dataname'],$data['data']);
    *****************/
    $this->display();
  }


  public function brandApplyList() {
    $merchantID=I('merchant_id');

    $merchantLogic = new l\MerchantLogic();
    $brandApplyData=$merchantLogic->getBrandApplyList(null,$merchantID);
    $brandApplyList=$brandApplyData['datas'];

    $role= session('user_info.role');
    $this->assign('role',$role);
    $this->assign('applyList',$brandApplyList);
    $this->display();

  }


  public function agreeAuth() {
    return true;
  }

  public function refuseAuth() {
    return true;
  }

  public function applyAuth() {
    return true;
  }

  public function del() {
    return true;
  }
}