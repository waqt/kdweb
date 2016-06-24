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
      $current=$applianceData['current'];
      $list_count=$applianceData['allcount'];
      $pages=ceil($list_count/$limit);

      //addErrorLog('appliance','loginc','current',$current);

      $data['error_code']=$applianceLogic->getErrorCode();
      $data['error_message']=$applianceLogic->getErrorMessage();

      $this->assign('pages',$pages);
      $this->assign('list_count',$list_count);
      $this->assign('current', $current);
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
         $fid=I('appliance-father');
         $img1 = $_FILES['shd-photo'];
         $img2 = $_FILES['shd-photo-little'];
         $img3 = $_FILES['yhd-photo'];  

         if($img1 != '' && $img1 !=null){
            $img_name1= "appliance/pic/shd_img/".uniqid().$img1['name'];
            $filepath1=UploadBeforeOss($img1);
            if(!ImgOssUpload($img_name1,$filepath1)){
              $data['success'] = false;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            } 
         }
         if($img2 != '' && $img2 !=null){
            $img_name2 = "appliance/pic/shd_little_img/".uniqid().$img2['name'];
            $filepath2=UploadBeforeOss($img2);
            if(!ImgOssUpload($img_name2,$filepath2)){
              $data['success'] = false;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            } 
         }
         if($img3 != '' && $img3 !=null){
            $img_name3 = "appliance/pic/yhd_img/".uniqid().$img3['name'];
            $filepath3=UploadBeforeOss($img3);
            if(!ImgOssUpload($img_name3,$filepath3)){
              $data['success'] = false;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            }  
         }   
              $applianceLogic = new l\ApplianceLogic();
              
              $big_logo=C('OSS_FILE_PREFIX').'/'.$img_name1;
              $small_logo=C('OSS_FILE_PREFIX').'/'.$img_name2;
              $middle_logo=C('OSS_FILE_PREFIX').'/'.$img_name3;
              $result=$applianceLogic->addAppliance($applianceName, $fid, $big_logo,
                                 $small_logo, $middle_logo);
              $data['success'] = true;
              $data['message'] = $result['message'];
              $this->ajaxReturn($data,'JSON');
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