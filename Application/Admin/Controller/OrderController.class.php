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
      /********
      $order_type  = I('order_type');         //订单业务类型
      $order_state = I('order_state');        //订单状态
      $appliance   = I('appliance');          //订单品类
      $pay_state   = I('pay_state');          //订单支付状态
      $brand       = I('brand');              //电器品牌
      $city        = I('city');               //订单所在区域
      $order_code  = I('order_code');         //订单编号
      $user_phone  = I('user_phone');         //用户手机号
      $mer_phone   = I('mer_phone');          //商户手机号
      $staff_phone = I('staff_phone');        //师傅手机号
      $buy_address = I('buy_address');        //购买地址（销售商）
      ***********/
      $condition   = I('condition');
      $page        = I('page');
      $limit       = 10;

      $condition['page'] =$page;
      

      $orderLogic = new l\OrderLogic();
      //API 获取用户数据
      $orderData=$orderLogic->getOrderList($condition, $page, $limit);

      $ordetrList=$orderData['datas'];
      $list_count=$orderData['allcount'];
      $current=$orderData['current'];               //当前页
      $pages=ceil($list_count/$limit); 
      
      
      $this->assign('condition', $condition);
      $this->assign('ordetrList', $ordetrList);
      $this->assign('pages',$pages);
      $this->assign('current', $current);
      $this->assign('list_count',$list_count);
      $this->display();
  }

  /*
  *订单详情
  */
  public function detail() {
    $orderID=I('order_id');
    $condition   = I('condition');

    $orderLogic = new l\OrderLogic();
    $orderDetail=$orderLogic->getOrderDetail($orderID);
    //addErrorLog('customer','detail','customer',$customerID);

    $this->assign('conditon',$condition);
    $this->assign('orderDetail',$orderDetail);

    $this->display();
  }


  /*
  *添加订单页面
  */
  public function addStepOne() {

    $initialLogic = new l\InitialLogic();

    $applianceList = $initialLogic->getAllAppliances();


    $brandList = $initialLogic->getAllBrands();
    $salesList = $initialLogic->getAllSales();

    $brandNameList = json_encode($brandList['NameList']);

    $salesNameList = json_encode($salesList['NameList']);

    $applianceFather=$applianceList['father'];
    $applianceChildMap=json_encode($applianceList['child']);


    $this->assign('applianceFather',$applianceFather);
    $this->assign('applianceChildMap',$applianceChildMap);
    $this->assign('brandNameList',$brandNameList);
    $this->assign('salesNameList',$salesNameList);

   
    $this->display();
  }


}