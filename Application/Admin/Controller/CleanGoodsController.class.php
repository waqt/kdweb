<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/**
* 清洗养护控制器
*/
class CleanGoodsController extends CommonController {
  /**
     * 获取清洗养护商品类别列表
     * @param int $fl_id 父类ID
     * @param int $page 分页页数
     * @param int $limit 每页显示的条数         
     * @return array
  */  
  public function lists(){

      $cleanGoodsLogic = new l\CleanGoodsLogic();

      $kindData=$cleanGoodsLogic->getKindsList();

      $kindList=$kindData['datas'];
      $list_count=$kindData['allcount'];

      //addErrorLog('appliance','loginc','current',$current);

      $this->assign('list_count',$list_count);
      $this->assign('kindList', $kindList);
      $this->display();
  }

  public function addKindView(){
     $initialLogic = new l\InitialLogic();

     $applianceList = $initialLogic->getAllAppliances();

     $applianceFather=$applianceList['father'];
     $applianceChildMap=json_encode($applianceList['child']);


     $this->assign('applianceFather',$applianceFather);
     $this->assign('applianceChildMap',$applianceChildMap);

     $this->display();

  }
  
  public function addKind(){
    if(I('appliance')=='' || I('appliance')==null){
      $cleanKind['appliance_id']=I('appliance-father');
    }else{
      $cleanKind['appliance_id']=I('appliance');
    }

    // \Think\Log::record(json_encode($cleanKind));

    $cleanGoodsLogic = new l\CleanGoodsLogic();
    $result=$cleanGoodsLogic->addCleanKind($cleanKind);
            
    $data['status']= $result['status'];
    $data['message'] = $result['message'];
    $this->ajaxReturn($data,'JSON');

  }

  public function del() {
    $id=I('protect_type_id');
    $cleanGoodsLogic = new l\CleanGoodsLogic();
    $result=$cleanGoodsLogic->delCleanKind($id);
    //S('appliances',NULL);
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');
  }
}