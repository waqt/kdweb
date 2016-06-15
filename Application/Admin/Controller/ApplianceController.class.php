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
      $appliance_list=$applianceData['datas'];
      $list_count=$applianceData['allcount'];
      $pages=ceil($list_count/$limit);
      $data['error_code']=$applianceLogic->getErrorCode();
      $data['error_message']=$applianceLogic->getErrorMessage();
      $this->assign('pages',$pages);
      $this->assign('list_count',$list_count);
      $this->assign('appliance_list', $appliance_list);
      $this->display();
  }

  public function addpar(){
    	if(I('appliance-name')==null){
        $this->display();
      }else{
         $applianceName=I('appliance-name');
      }
    }

  public function add_son(){
      return true;
    }    

  public function del() {
    $id=I('appliance_id');
    $applianceLogic = new l\ApplianceLogic();
    $result=$applianceLogic->delAppliance($id);
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');
  }
}