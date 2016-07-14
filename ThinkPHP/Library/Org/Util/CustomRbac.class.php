<?php
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ikuaidian.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liutj
// +----------------------------------------------------------------------

namespace Org\Util;
use Think\Db;


/**
* 自定义站点权限管理
*/
class CustomRbac extends Rbac {

    /**
    * API验证用户身份
    * @param $username   用户名
    * @param $password   密码
    * @return array
    */
    static public function verifyUser($username,$password) {
        $data['phone']=$username;
        $data['password']=$password;
        $req_url=BASE_URL.LOGIN_AUTHENTICATION_URL;
        $result=request_post($req_url,$data);
        $result=json_decode($result,true);
        //addErrorLog('','','login_api_result',$result);
        return $result;
    }

    /**
    * 获取用户权限
    * @param $authId   用户id
    * @param $roleId   角色id
    */
    static function saveCustomAccessList($authId=null,$roleId=null) {
        if(null===$authId)   $authId = session(C('USER_AUTH_KEY'));
        if(null===$roleId)   $roleId = session('user_info.role');
        // 如果使用普通权限模式，保存当前用户的访问权限列表
        // 对管理员开发所有权限
        if(C('USER_AUTH_TYPE') !=2 && !session(C('ADMIN_AUTH_KEY')))
            //session('_ACCESS_LIST',self::getCustomAccessList($authId,$roleId));
            $_SESSION['_ACCESS_LIST']   =   self::getCustomAccessList($authId,$roleId);
        return ;
    }


    /**
     * 取得当前用户的所有权限列表
     * @param integer $authId 用户ID
     * @param integer $roleId 角色ID
     * @access public
     */
     static public function getCustomAccessList($authId,$roleId) {
        // Db方式权限数据
        //$db     =   Db::getInstance(C('RBAC_DB_DSN'));
        $dao = M();

        $table = array('role'=>C('RBAC_ROLE_TABLE'),'access'=>C('RBAC_ACCESS_TABLE'),'node'=>C('RBAC_NODE_TABLE'));
        $sql    =   "select node.id,node.module,node.action,access.request_method from ".
        $table['role']." as role,".
        $table['access']." as access ,".
        $table['node']." as node ".
        "where role.id={$roleId} and access.role_id=role.id and role.status=1 and access.node_id=node.id and node.status=1 ";
        $node_list =   $dao->query($sql);
        $access =  array();
        foreach ($node_list as $key => $value) {
            $access[strtoupper(MODULE_NAME)][strtoupper($value['module'])][strtoupper($value['action'])] = $value;
        }
        return $access;
    }



}