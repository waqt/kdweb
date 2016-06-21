<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/**
* 电器品类管理控制器
*/
class ApplianceController extends CommonController {
  /**
     * 获取电器品类列表
     * @param int $fl_id 父类ID
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
  */  
  public function index(){
      $page = I('page');
      $fl_id = I('fl_id');
      $limit = 10;

      $applianceLogic = new l\ApplianceLogic();

      $applianceData=$applianceLogic->getApplianceList($fl_id, $page, $limit);
      $father_list=$applianceLogic->getApplianceFatherList();

      $appliance_list=$applianceData['datas'];
      $list_count=$applianceData['allcount'];
      $pages=ceil($list_count/$limit);

      $data['error_code']=$applianceLogic->getErrorCode();
      $data['error_message']=$applianceLogic->getErrorMessage();

      $this->assign('pages',$pages);
      $this->assign('list_count',$list_count);
      $this->assign('appliance_list', $appliance_list);
      $this->assign('father_list', $father_list);
      $this->display();
  }

  public function addpar(){
    	if(I('applianceName')==null){
        $applianceLogic = new l\ApplianceLogic();
        $father_list=$applianceLogic->getApplianceFatherList();
        $this->assign('father_list', $father_list);
        $this->display();
      }else{
         $applianceName=I('applianceName');
         $img1 = $_FILES['shd-photo'];
         $img2 = $_FILES['shd-photo-little'];
         $img3 = $_FILES['yhd-photo'];  

         $img_name= "/appliance/pic/shd_img/".uniqid();
         $img_name2 = "/appliance/pic/shd_little_img/".uniqid();
         $img_name3 = "/appliance/pic/yhd_img/".uniqid();


         if($img1==null && $img2==null && $img3==null){
             $data['success'] = false;
             $data['message'] = '图片提交失败';
             $data['error_code'] = 10001;
             $this->ajaxReturn($data,'JSON');
         }else{   
          if(ImgOssUpload($img_name,$img1)&&ImgOssUpload($img_name2,$img2)
              &&ImgOssUpload($img_name3,$img3)){
             $data['success'] = true;
             $data['message'] = '添加成功';
             $data['img_url'] = C('OSS_ENDPOINT').$img_name;
             $this->ajaxReturn($data,'JSON');
          }else{
             $data['success'] = false;
             $data['message'] = '图片上传失败';
             $data['error_code'] = 10002;
             $this->ajaxReturn($data,'JSON');
          }
        }
      }
    }
  

  public function del() {
    $id=I('appliance_id');
    $applianceLogic = new l\ApplianceLogic();
    $result=$applianceLogic->delAppliance($id);
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');
  }
}