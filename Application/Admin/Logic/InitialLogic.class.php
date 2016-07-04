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
            S('brands',$brandList); 
        }
        return s('brands');
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
                $child=$applianceLogic->getApplianceList($father['appliance_id'],1,30);
                $father['child']=$child['datas'];
            }
            S('appliances',$applianceFatherList);  
        }
        return S('appliances');
    }

        /**
     * 从缓存中读取品类数据   
     * @return array
     */
    public function getAllSales() {
    //电器品类初始化
        if(! S('sales')){
            $limit = 0;
            $salesLogic = new l\SalesLogic();
            $salesData=$salesLogic->getSalesList($condition, , $limit);
            $sales_list=$salesData['datas'];
            
            S('sales',$sales_list);  
        }
        return S('sales');
    }  
}