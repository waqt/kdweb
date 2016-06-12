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
      $merchant_list=$merchantLogic->getMerchantList($area, $authorize_state, $appliance_id, $phone, $onlycode, $brand_name, $page, $limit);
      $data['error_code']=$merchantLogic->getErrorCode();
      $data['error_message']=$merchantLogic->getErrorMessage();
      $this->assign('merchant_list', $merchant_list);
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