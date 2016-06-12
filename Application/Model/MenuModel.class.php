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
 * 菜单模型
 */
class MenuModel extends BaseModel {
    protected $tableName = 'node';

    public function getMenus($where, $order, $limit) {
        return $this->where($where)->order($order)->limit($limit)->select();
    }

    public function nodeList() {
        $nodes = $this->order("sort desc")->select();
        $list = list_to_tree($nodes,'id','pid');
        $nodes = array();
        tree_to_array($list,$nodes);
        return $nodes;
    }
}