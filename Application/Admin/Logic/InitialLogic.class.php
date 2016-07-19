<?php
// +----------------------------------------------------------------------
// | Ikuaidian  快点后台管理系统
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2017 http://www.ikuaidian.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liutj
// +----------------------------------------------------------------------

namespace Admin\Logic;
use Lib\Log;
use Admin\Logic as l;

/**
* 数据初始化控制Logic
*/
class InitialLogic extends BaseLogic {
    /**
     * 从缓存中读取品牌列表   
     * @return array
     */
    public function getAllBrands() {
        S('brands',null);
        if(! S('brands')){
            $brandLogic = new l\BrandLogic();
            $brandList=$brandLogic->getAllBrandList();
            for($i= 0; $i< count($brandList); $i++){
                $brandName=$brandList[$i]['brand_name'];
                $brandNameList[$i]=$brandName;
                $brandNameMap[$brandName]=$brandList[$i]['brand_id'];
            }
            $brandMap['NameList']=$brandNameList;
            $brandMap['Map']=$brandNameMap;
            S('brands',$brandMap); 
        }
        return S('brands');
    }

    /**
     * 从缓存中读取品类数据   
     * @return array
     */
    public function getAllAppliances() {
    //电器品类初始化
        S('appliances',null);
        if(! S('appliances')){
            $applianceLogic = new l\ApplianceLogic();
            $applianceFatherList=$applianceLogic->getApplianceFatherList();
            foreach($applianceFatherList as $father){
                $fatherId=$father['appliance_id'];
                $child=$applianceLogic->getApplianceSonList($fatherId);
                //addErrorLog("initial","initiallogic","eachchild",$child);
                $childMap[$fatherId]=$child;
            }
            $applianceMap['father']= $applianceFatherList;
            $applianceMap['child']= $childMap;
            //addErrorLog("initial","initiallogic","allchild",$childMap['43']);
            S('appliances',$applianceMap);  
        }
        return S('appliances');
    }

        /**
     * 从缓存中读取品类数据   
     * @return array
     */
    public function getAllSales() {
    //电器品类初始化
        S('sales',null);
        if(! S('sales')){
            $salesLogic = new l\SalesLogic();
            $salesData=$salesLogic->getSalesList($condition, null , 0);
            $sales_list=$salesData['datas'];
            $count=count($sales_list);
            for($i= 0; $i< $count; $i++){
                $salesName=$sales_list[$i]['saleor_name'];
                $salesNameList[$i]=$salesName;
                $salesNameMap[$salesName]=$sales_list[$i]['saleor_id'];
            }
            $salesMap['NameList']=$salesNameList;
            $salesMap['Map']=$salesNameMap;
            S('sales',$salesMap); 
        }
        return S('sales');
    }


    /**
     * 从缓存中读取故障数据   
     * @return array
     */
    public function getAllTroubles() {
    //电器品类初始化
        S('troubles',null);
        if(! S('troubles')){
            $applianceTroubleLogic = new l\ApplianceTroubleLogic();
            $troubleData=$applianceTroubleLogic->getTroubleList($condition, $page, $limit);
            $trouble_list=$salesData['datas'];
            $count=count($trouble_list);
            for($i= 0; $i< $count; $i++){
                $applianceName=$trouble_list[$i]['f_name'];
                $troubleMap[$applianceName]['break_name']=$trouble_list[$i]['break_name'];
                $troubleMap[$applianceName]['break_id']=$trouble_list[$i]['break_id'];
            }
            S('troubles',$troubleMap); 
        }
        return S('troubles');
    }

    /**
     * 从缓存中读取菜单数据   
     * @return array
     */
    public function getLeftMenus() {
    //电器品类初始化
        $roleID=session('user_info.role');
        //S('leftmenus',null);
        if(! S('leftmenus')){
            $menu_logic = new l\MenuLogic();
            $roleList= M("role")->field('id')->select();
            $left_menu=null;
            foreach($roleList as $role){
                $role_id=$role['id'];
                $left_menu[$role_id]=$menu_logic->getAccessibleLeftMenu($role_id);
                foreach($left_menu[$role_id] as &$lm){
                    $lm['child_menu']=$menu_logic->getAccessibleLeftChildMenu($lm['id'],$role_id);
                }
            }
            /**********
            $left_menu = $menu_logic->getAccessibleLeftMenu();
            foreach($left_menu as &$lm){
                $lm['child_menu']=$menu_logic->getAccessibleLeftChildMenu($lm['id']);
            }
            S('leftmenus',$left_menu); 
            *************/
            S('leftmenus',$left_menu); 
        }
        $menu=S('leftmenus');
        $roleMenu=$menu[$roleID];
        return $roleMenu;
    }     
}