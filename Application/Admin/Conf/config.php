<?php
include_once 'proConstUrl.php';
return array(
	//'配置项'=>'配置值'

	//SESSION 配置
	'SESSION_AUTO_START'        =>  true,
	'TMPL_ACTION_ERROR'         =>  'Login:success',   // 默认错误跳转对应的模板文件
	'TMPL_ACTION_SUCCESS'       =>  'Login:success',   // 默认成功跳转对应的模板文件
	'USER_AUTH_ON'              =>  true,
	'USER_AUTH_TYPE'            =>  2,          // 默认认证类型 1 登录认证 2 实时认证
	'USER_AUTH_KEY'             =>  'authId',     // 用户认证SESSION标记
	'ADMIN_AUTH_KEY'            =>  'administrator',    // 超级管理员标志
	'USER_AUTH_MODEL'           =>  'User',       // 默认验证数据表模型
	'AUTH_PWD_ENCODER'          =>  'md5',        // 用户认证密码加密方式
	'USER_AUTH_GATEWAY'         =>  '/Login/index',  // 默认认证网关
	'USER_INFO_KEY'             =>  'userInfo',

	'GUEST_AUTH_ON'             =>  false,          // 是否开启游客授权访问
	'GUEST_AUTH_ID'             =>  0,              // 游客的用户ID
	'RBAC_ROLE_TABLE'           =>  'sys_role',
	'RBAC_USER_TABLE'           =>  'sys_role_user',
	'RBAC_ACCESS_TABLE'         =>  'sys_access',
	'RBAC_NODE_TABLE'           =>  'sys_node',
	'OSS_ACCESS_KEY_ID'         =>  'aJCzSIJn3TFLjuEp',
	'OSS_ACCESS_KEY_SECRET'     =>  '63BzvVOBSUhetWDkuXWgOzPK0WMQy9',
	'OSS_ENDPOINT'              =>  'oss-cn-hangzhou.aliyuncs.com',
	'OSS_BUCKET'                =>  'appliance',
	'OSS_FILE_PREFIX'           =>  'http://appliance.oss-cn-hangzhou.aliyuncs.com',
	

	'URL_ROUTE_RULES' => array(

		),
);