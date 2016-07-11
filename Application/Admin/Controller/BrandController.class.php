<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/**
* 电器品牌管理控制器
*/
class BrandController extends CommonController {
  /**
     * 获取电器品类列表
     * @param int $fid 品类ID
     * @param int $page 分页页数
     * @param String $brand_name 品牌名称
     * @param int $limit 每页显示的条数         
     * @return array
  */  
  public function index(){
      $page = I('page');
      $applianceId = I('fid');
      $brandName=I('brand_name');
      $limit = 10;

      $brandLogic = new l\BrandLogic();
      $applianceLogic = new l\ApplianceLogic();

      $brandData=$brandLogic->getBrandList($applianceId, $brandName, $page, $limit);

      $father_list=$applianceLogic->getApplianceFatherList();

      $brand_list=$brandData['datas'];
      $current=$brandData['current'];
      $list_count=$brandData['allcount'];
      $pages=ceil($list_count/$limit);

      //addErrorLog('appliance','loginc','current',$current);

      $data['error_code']=$brandLogic->getErrorCode();
      $data['error_message']=$brandLogic->getErrorMessage();

      $this->assign('pages',$pages);
      $this->assign('list_count',$list_count);
      $this->assign('current', $current);
      $this->assign('brand_list', $brand_list);
      $this->assign('father_list', $father_list);
      $this->display();
  }

  public function add(){
    	if(I('brand-name')==null){
          $this->display();
      }else{
         $brandName=I('brand-name');
         $brandLogo = $_FILES['brand-logo'];

         $img_name= "brand/pic/".uniqid().strrchr($brandLogo['name'],46);

         $filepath=UploadBeforeOss($brandLogo);   //上传图片到服务器，获取服务器文件路径
         $brandLogic = new l\BrandLogic();
         $logoUrl=null;
        if($brandLogo != ''){
            //上传文件到OSS
            if(ImgOssUpload($img_name, $filepath)){
              $logoUrl=C('OSS_FILE_PREFIX').'/'.$img_name;
            }else{
              $data['status'] = 300;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
          }
        }
        $result=$brandLogic->addBrand($brandName,$logoUrl);
        $data['status'] = $result['status'];
        $data['message'] = $result['message'];
        S('brands',NULL);
        $this->ajaxReturn($data,'JSON');

      }
    }
  
    /**
     * 获取品牌授权商户  
     * @return array
  */  
  public function brandMerchant(){
      $merchant['brand_id'] = I('brand_id');
      $page = I('page');

      $initialLogic = new l\InitialLogic();
      $brandList = $initialLogic->getAllBrands();

      $brand_name = array_search($merchant['brand_id'], $brandList['Map']); 
      $limit = 10;

      $merchantLogic = new l\MerchantLogic();
      //API 获取商户数据
      $merchant_data=$merchantLogic->getMerchantList($merchant, $page, $limit);

      $merchant_list=$merchant_data['datas'];
      $list_count=$merchant_data['allcount'];
      $current=$merchant_data['current'];               //当前页
      $pages=ceil($list_count/$limit); 


      //addErrorLog('appliance','loginc','current',$current);
      $this->assign('brandName',$brand_name);
      $this->assign('brandID',$merchant['brand_id']);
      $this->assign('merchant_list', $merchant_list);
      $this->assign('pages',$pages);
      $this->assign('current', $current);
      $this->assign('list_count',$list_count);
      $this->display();
  }

  /**
     * 添加订单时获取品牌授权商户  
     * @return array
  */  
  public function listBrandMerchant(){
      $brand_name=I('brand_name');

      $initialLogic = new l\InitialLogic();
      $brandList = $initialLogic->getAllBrands();
      $merchant['brand_id']=$brandList['Map'][$brand_name];

      $merchantLogic = new l\MerchantLogic();
      //API 获取商户数据
      $merchant_data=$merchantLogic->getMerchantList($merchant, null , 0);

      $merchant_list=$merchant_data['datas'];


      //addErrorLog('appliance','loginc','current',$current);
      $this->assign('brandName',$brand_name);
      $this->assign('merchant_list', $merchant_list);
      $this->display();
  }


  public function del() {
    $id=I('brand_id');
    $brandLogic = new l\BrandLogic();
    $result=$brandLogic->delBrand($id);
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');
    S('brands',NULL);
  }
}