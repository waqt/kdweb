<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/**
* 电器品类管理控制器
*/
class ApplianceController extends CommonController {
  public function index(){
      $page = I('page');
      $limit = 10;
      $ApplianceLogic = new l\ApplianceLogic();
      $merchant_list=$merchantLogic->getMerchantList($area, $authorize_state, $appliance_id, $phone, $onlycode, $brand_name, $page, $limit);
      $data['error_code']=$merchantLogic->getErrorCode();
      $data['error_message']=$merchantLogic->getErrorMessage();
      $this->assign('merchant_list', $merchant_list);
      $this->display();
      $this->display();
  }

  public function add_par(){
    	return true;
    }

  public function add_son(){
      return true;
    }    

  public function del() {
    return true;
  }
}