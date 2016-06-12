<?php
// +----------------------------------------------------------------------
// | Ikuaidian [ 快点后台管理系统 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2016 http://www.ikuaidian.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liutj
// +----------------------------------------------------------------------
namespace Model;

/**
 * 角色模型
 */
class RoleModel extends BaseModel {

    public function roleList() {
        $list = $this->order('id ASC')->select();
        return $list;
    }
}