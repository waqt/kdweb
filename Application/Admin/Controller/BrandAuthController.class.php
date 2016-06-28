<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/** 
 * 类名称：BrandAuthController
 * 品牌授权控制器
 * 创建人：LTJ
 * 创建时间：2016年6月1日
 * @version
 */
class BrandAuthController extends CommonController {
  public function index(){
      $this->display();
  }

  /*
  * 品牌授权申请列表
  */
  public function lists() {
    $merchantID=I('merchant_id');
    $handle_state = I('handle_state');
    $mer_name = I('mer_name');
    $phone = I('phone');
    $page = I('page');
    $limit = 10;

    $brandAuthLogic = new l\BrandAuthLogic();
    $brandApplyData=$brandAuthLogic->getBrandApplyList($phone, $merchantID, 
                                  $mer_name, $handle_state, $page, $limit);
    $brandApplyList=$brandApplyData['datas'];

    $list_count=$brandApplyData['allcount'];
    $current=$brandApplyData['current'];               //当前页
    $pages=ceil($list_count/$limit); 

    $role= session('user_info.role');
    $this->assign('role',$role);
    $this->assign('applyList',$brandApplyList);
    $this->assign('pages',$pages);
    $this->assign('current', $current);
    $this->assign('list_count',$list_count);
    $this->display();

  }

  /*
  *品牌授权申请详情
  */
  public function detail() {
    $applyId=I('apply_id');
    $merID=I('mer_id');

    $brandAuthLogic = new l\BrandAuthLogic();
    $applyDetailData=$brandAuthLogic->getApplyDetail($applyId);
    $applyDetail=$applyDetailData['data'];
    $applyDetail['created_at']=date('Y-m-d H:i:s',$applyDetail['created_at']);
    $picList= explode('|',$applyDetail['business_pics']); 

    $role= session('user_info.role');
    $this->assign('mer_id',$merID);
    $this->assign('role',$role);
    $this->assign('applyDetail',$applyDetail);
    $this->assign('applyPicList',$picList);
    $this->display();

  }


  /*
  * 单个商户品牌授权申请列表
  */
  public function brandApplyList() {
    $merchantID=I('merchant_id');

    $brandAuthLogic = new l\BrandAuthLogic();
    $brandApplyData=$brandAuthLogic->getBrandApplyList(null,$merchantID);
    $brandApplyList=$brandApplyData['datas'];

    $brandAchieveList=$brandAuthLogic->getAchieveBrandList($merchantID);

    $role= session('user_info.role');
    $this->assign('role',$role);
    $this->assign('applyList',$brandApplyList);
    $this->assign('achieveList',$brandAchieveList);
    $this->display();

  }

  /*
  * 单个商户品牌授权申请详情
  */
  public function brandApplyDetail() {
    $applyId=I('apply_id');
    $merID=I('mer_id');

    $brandAuthLogic = new l\BrandAuthLogic();
    $applyDetailData=$brandAuthLogic->getApplyDetail($applyId);
    $applyDetail=$applyDetailData['data'];
    $applyDetail['created_at']=date('Y-m-d H:i:s',$applyDetail['created_at']);
    $picList= explode('|',$applyDetail['business_pics']); 


    $role= session('user_info.role');
    $this->assign('mer_id',$merID);
    $this->assign('role',$role);
    $this->assign('applyDetail',$applyDetail);
    $this->assign('apply_pic_list',$picList);
    $this->display();

  }

  public function disagree() {
    $applyId=I('apply_id');
    $reason=I('reason');
    $merId=I('mer_id');

    $brandAuthLogic = new l\BrandAuthLogic();

    $result=$brandAuthLogic->disagreeApply($applyId, $reason);

    $data['mer_id']=$merId;
    $data['status']=$result['status'];
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');  
  }

  public function showBrand() {
    $applyId=I('apply_id');
    $merId=I('mer_id');

    $brandAuthLogic = new l\BrandAuthLogic();
    $brandLogic = new l\BrandLogic();

    $brandList=$brandLogic->getAllBrandList();
    $achieveBrandList=$brandAuthLogic->getAchieveBrandList($merId);


    $role= session('user_info.role');
    $this->assign('apply_id',$applyId);
    $this->assign('role',$role);
    $this->assign('brandList',$brandList);
    $this->assign('achieveList',$achieveBrandList);
    $this->display();
  }

    public function agree() {
    $applyId=I('apply_id');
    $reason=I('reason');
    $brandList=I('agree-list');

    addErrorLog('BrandAuth','agree','applyId',$applyId);

    $brandAuthLogic = new l\BrandAuthLogic();

    $result=$brandAuthLogic->agreeBrand($applyId, $brandList, $reason);

    $data['status']=$result['status'];
    $data['message']=$result['message'];
    $this->ajaxReturn($data,'JSON');  
  }

}