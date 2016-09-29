<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


/**
* 网点储备管理控制器
*/
class CompanyController extends CommonController {
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
      $map['skill'] = I('skill');;
      $map['province'] = I('province');
      $map['city'] = I('city');
      $map['campus'] = I('campus');
      $map['address'] = I('address');
      $map['company_name'] = I('company_name');
      $map['herader_phone'] = I('herader_phone');
      $map['brands'] = I('brands');
      

      $companyLogic = new l\CompanyLogic();
      $applianceLogic = new l\ApplianceLogic();

      $companyData=$companyLogic->getCompanyList($fl_id, $page, $limit, $map);
      $father_list=$applianceLogic->getApplianceFatherList();

      $appliance_list=$applianceData['datas'];
      $current=$applianceData['current'];
      $list_count=$applianceData['allcount'];
      $pages=ceil($list_count/$limit);

      //addErrorLog('appliance','loginc','current',$current);

      $this->assign('pages',$pages);
      $this->assign('list_count',$list_count);
      $this->assign('current', $current);
      $this->assign('appliance_list', $appliance_list);
      $this->assign('father_list', $father_list);
      $this->display();
  }

  public function addView(){
    $this->display();
  }
}