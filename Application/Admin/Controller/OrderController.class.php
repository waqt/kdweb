<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/** 
 * 类名称：OrderController
 * 创建人：LTJ
 * 创建时间：2016年6月1日
 * @version
 */
class OrderController extends CommonController {

  /*
  *用户列表
  */
  public function index(){
      $phone = I('phone');
      $page = I('page');
      $limit = 10;
      

      $customerLogic = new l\CustomerLogic();
      //API 获取用户数据
      $customer_data=$customerLogic->getCustomerList($phone, $page, $limit);
      $customer_list=$customer_data['datas'];
      $list_count=$customer_data['allcount'];
      $current=$customer_data['current'];               //当前页
      $pages=ceil($list_count/$limit); 
      
      $data['error_code']=$customerLogic->getErrorCode();
      $data['error_message']=$customerLogic->getErrorMessage();
      
      $this->assign('customer_list', $customer_list);
      $this->assign('pages',$pages);
      $this->assign('current', $current);
      $this->assign('list_count',$list_count);
      $this->display();
  }

  /*
  *用户详情
  */
  public function detail() {
    $customerID=I('customer_id');
    $customerLogic = new l\CustomerLogic();
    $customer=$customerLogic->getCustomerDetail($customerID);
    //addErrorLog('customer','detail','customer',$customerID);

    $this->assign('customer',$customer);

    $this->display();
  }

}