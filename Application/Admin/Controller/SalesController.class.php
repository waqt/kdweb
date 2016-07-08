<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/**
* 销售商管理控制器
*/
class SalesController extends CommonController {
  /**
     * 获取销售商列表      
     * @return array
  */  
  public function lists(){
      $condition   = I('condition');
      $page = I('page');
      $limit = 10;

      $salesLogic = new l\SalesLogic();


      $salesData=$salesLogic->getSalesList($condition, $page, $limit);


      $sales_list=$salesData['datas'];
      $list_count=$salesData['allcount'];
      $current=$salesData['current'];               //当前页
      $pages=ceil($list_count/$limit); 

      addErrorLog('sales','lists','sales_list',$sales_list);

      $data['error_code']=$salesLogic->getErrorCode();
      $data['error_message']=$salesLogic->getErrorMessage();

      $this->assign('pages',$pages);
      $this->assign('current', $current);
      $this->assign('list_count',$list_count);
      $this->assign('sales_list', $sales_list);
      $this->display();
  }

  public function addView(){
    $this->display();
  }  

  public function add(){
        $sales['account']=I('account');
        $sales['password'] = I('password');
        $sales['phone'] = I('phone');
        $sales['real_name'] = I('real_name');
        $sales['saleor_name'] = I('saleor_name');
        $sales['address'] = I('address');
        $sales['describe'] = I('describe');
        $salesLogo = $_FILES['logo'];

        $logoUrl = null;

        $salesLogic = new l\SalesLogic();

        if($salesLogo != '' && $salesLogo !=null){
            $filepath=UploadBeforeOss( $salesLogo);
            $logoName= "sales/pic/".uniqid().strrchr($salesLogo['name'],46);
            $logoUrl=C('OSS_FILE_PREFIX').'/'.$logoName;
            //上传文件到OSS
            if(!ImgOssUpload($logoName, $filepath)){
              $data['status'] = 300;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            }
        }
          $result=$salesLogic->addSales($sales,$logoUrl);
          $data['status'] = $result['status'];
          $data['message'] = $result['message'];
          $this->ajaxReturn($data,'JSON');
      }
  
}