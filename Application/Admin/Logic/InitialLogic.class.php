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

            for($i= 0; $i< count($sales_list); $i++){
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
}