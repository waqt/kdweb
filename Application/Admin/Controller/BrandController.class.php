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

         $img_name= "brand/pic/".uniqid().str_replace(' ','',$brandLogo['name']);

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
  

  public function del() {
    $id=I('brand_id');
    $brandLogic = new l\BrandLogic();
    $result=$brandLogic->delBrand($id);
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');
    S('brands',NULL);
  }
}