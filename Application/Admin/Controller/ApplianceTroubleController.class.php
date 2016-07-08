<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/**
* 电器故障管理控制器
*/
class ApplianceTroubleController extends CommonController {
  /**
     * 获取电器故障列表
     * @param object $condition 查询条件
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
  */  
  public function index(){
      $page = I('page');
      $condition= I('condition');
      $limit = 10;

      $applianceTroubleLogic = new l\ApplianceTroubleLogic();

      $troubleData=$applianceTroubleLogic->getTroubleList($condition, $page, $limit);
      

      $trouble_list=$troubleData['datas'];
      $current=$troubleData['current'];
      $list_count=$troubleData['allcount'];
      $pages=ceil($list_count/$limit);

      $data['error_code']=$applianceTroubleLogic->getErrorCode();
      $data['error_message']=$applianceTroubleLogic->getErrorMessage();

      $this->assign('pages',$pages);
      $this->assign('list_count',$list_count);
      $this->assign('current', $current);
      $this->assign('trouble_list', $trouble_list);
      $this->display();
  }

  public function addView(){
    $initialLogic = new l\InitialLogic();
    $applianceList = $initialLogic->getAllAppliances();

    $applianceFather=$applianceList['father'];
    $applianceChildMap=json_encode($applianceList['child']);


    $this->assign('applianceFather',$applianceFather);
    $this->assign('applianceChildMap',$applianceChildMap);
    $this->display();
  }

  public function troubleList(){
    $condition['father_id'] = I('father_id');
    $condition['son_id'] = I('son_id');

    addErrorLog("applianceTrouble","troubleList","condition",$condition);
    $applianceTroubleLogic = new l\ApplianceTroubleLogic();
    $troubleData=$applianceTroubleLogic->getTroubleList($condition, null, 0);

    $trouble_list=$troubleData['datas'];

    $this->assign('trouble_list',$trouble_list);
    $this->display();
  }

  public function add() {
    $trouble['father_id'] = I('appliance-father');
    $trouble['son_id'] = I('appliance-child');
    $trouble['break_name']=I('troubleName');
    if($trouble['son_id']==''){
      $trouble['son_id']=null;
    }

    $applianceTroubleLogic = new l\ApplianceTroubleLogic();
    $result=$applianceTroubleLogic->addTrouble($trouble);

    S('troubles',NULL);
    $data['status'] = $result['status'];
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');
  }

  public function del() {
    $id=I('break_id');
    $applianceTroubleLogic = new l\ApplianceTroubleLogic();
    $result=$applianceTroubleLogic->delTrouble($id);
    S('troubles',NULL);
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');
  }
}