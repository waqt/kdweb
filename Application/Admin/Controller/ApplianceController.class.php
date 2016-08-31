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
         $img4 = $_FILES['yhd-qxby-photo'];

         $big_logo=null;
         $small_logo=null;
         $middle_logo=null;
         $middle2_logo=null; 

         if($img1 != '' && $img1 !=null){
            $img_name1= "appliance/pic/shd_img/".uniqid().strrchr($img1['name'],46);
            $filepath1=UploadBeforeOss($img1);
            $big_logo=C('OSS_FILE_PREFIX').'/'.$img_name1;
            if(!ImgOssUpload($img_name1,$filepath1)){
              $data['status'] = 300;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            } 
         }
         if($img2 != '' && $img2 !=null){
            $img_name2 = "appliance/pic/shd_little_img/".uniqid().strrchr($img2['name'],46);
            $filepath2=UploadBeforeOss($img2);
            $small_logo=C('OSS_FILE_PREFIX').'/'.$img_name2;
            if(!ImgOssUpload($img_name2,$filepath2)){
              $data['status'] = 300;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            } 
         }
         if($img3 != '' && $img3 !=null){
            $img_name3 = "appliance/pic/yhd_img/".uniqid().strrchr($img3['name'],46);
            $filepath3=UploadBeforeOss($img3);
            $middle_logo=C('OSS_FILE_PREFIX').'/'.$img_name3;
            if(!ImgOssUpload($img_name3,$filepath3)){
              $data['status'] = 300;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            }  
         }
        if($img4 != '' && $img4 !=null){
            $img_name4 = "appliance/pic/yhd_qxby_img/".uniqid().strrchr($img4['name'],46);
            $filepath4=UploadBeforeOss($img4);
            $middle2_logo=C('OSS_FILE_PREFIX').'/'.$img_name4;
            if(!ImgOssUpload($img_name4,$filepath4)){
              $data['status'] = 300;
              $data['message'] = '图片上传失败';
              $data['error_code'] = 10002;
              $this->ajaxReturn($data,'JSON');
            }  
         }    
              $applianceLogic = new l\ApplianceLogic();
              
              $result=$applianceLogic->addAppliance($applianceName, $fid, $big_logo,
                                 $small_logo, $middle_logo, $middle2_logo);
              S('appliances',NULL);
              $data['status']= $result['status'];
              $data['message'] = $result['message'];
              $this->ajaxReturn($data,'JSON');
        }
  }
  

  public function del() {
    $id=I('appliance_id');
    $applianceLogic = new l\ApplianceLogic();
    $result=$applianceLogic->delAppliance($id);
    S('appliances',NULL);
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');
  }

  public function editView(){
    $appliance['applianceName']=I('applianceName');
    $this->assign('appliance', $appliance);
    $this->display();
    
  }
}