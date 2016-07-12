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
  *订单列表
  */
  public function lists(){
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
  public function addView() {

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


  public function add(){
         $initialLogic = new l\InitialLogic();
         $brandList = $initialLogic->getAllBrands();
         $salesList = $initialLogic->getAllSales();

         $brandName= I('brandName');
         $brandID=$brandList['Map'][$brandName];

         $salesName= I('salesName');
         $salesID = $salesList['Map'][$salesName];


         $break_pic = $_FILES['break_pics'];
         $bill_pic =  $_FILES['billphoto'];

         $break_pics= null;
         $invoice_pic = null;
         if($break_pic != '' && $break_pic !=null){
            $break_photo_name= "order/pic/breakphoto/".uniqid().strrchr($break_pic['name'],46);
            $filepath=UploadBeforeOss( $break_pic);
            $break_pics=C('OSS_FILE_PREFIX').'/'.$break_photo_name;
            if(!ImgOssUpload($break_photo_name,$filepath)){
              $data['status'] = 300;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            } 
         }
         if($bill_pic != '' && $bill_pic !=null){
            $bill_photo_name = "order/pic/billphoto/".uniqid().strrchr($bill_pic['name'],46);
            $filepath=UploadBeforeOss($bill_pic);
            $invoice_pic=C('OSS_FILE_PREFIX').'/'.$bill_photo_name;
            if(!ImgOssUpload($bill_photo_name,$filepath)){
              $data['status'] = 300;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            } 
         }

         $order['send_type']=I('order_type');
         $order['appliance_id']=I('appliance-father');
         $order['uappliance_id']=I('appliance');
         $order['brand_id']=$brandID;
         $order['servicetime']=I('servicetime');
         $order['phone']=I('customerPhone');
         $order['user_name']=I('customerName');
         $order['address']=I('prov')."-".I('city')."-".I('dist')."-".I('address')."-".I('doorNumber');
         $order['is_auto']=I('pushMethod');
         $order['mer_only_code']=I('merchant_code');
         $order['buy_time']=I('buytime');
         $order['invoice']=I('billNumber');
         $order['buy_mer_id']=$salesID;
         $order['break_describe']=I('break_describe');
         $order['invoice_pic'] = $invoice_pic;
         $order['break_pics'] = $break_pics;

         //$data = json_encode($order);

         //addErrorLog("Order","add","address",$data);

         $orderLogic = new l\OrderLogic();
         $result=$orderLogic->addOrder($order);
         $data['success'] = true;
         $data['status']= $result['status'];
         $data['message'] = $result['message'];
         addErrorLog("order","add","result",$data);
         $this->ajaxReturn($data,'JSON');
  }


  /*
  *退单列表
  */
  public function chargeback(){
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
      $backData=$orderLogic->getChargeBack($condition, $page, $limit);

      $backList=$backData['datas'];
      $list_count=$backData['allcount'];
      $current=$backData['current'];               //当前页
      $pages=ceil($list_count/$limit); 
      
      
      $this->assign('condition', $condition);
      $this->assign('backList', $backList);
      $this->assign('pages',$pages);
      $this->assign('current', $current);
      $this->assign('list_count',$list_count);
      $this->display();
  }

  /*
  *订单详情
  */
  public function backdetail() {
    $backID=I('back_id');
    $condition   = I('condition');

    $orderLogic = new l\OrderLogic();
    $orderDetail=$orderLogic->getOrderBackDetail($backID);
    //addErrorLog('customer','detail','customer',$customerID);

    $this->assign('conditon',$condition);
    $this->assign('orderDetail',$orderDetail);

    $this->display();
  }


}