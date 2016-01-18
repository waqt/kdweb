<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2016 http://www.ikuaidian.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: LTJ 
// +----------------------------------------------------------------------

/**
 * 系统配文件
 * 所有系统级别的配置
 */
return array(
    /* 调试配置 */
    'SHOW_PAGE_TRACE' => true,
    /* URL配置 */
    'URL_CASE_INSENSITIVE' => false, //默认false 表示URL区分大小写 true则表示不区分大小写
    'URL_MODEL'	           => 3,
    'VAR_URL_PARAMS'       => '', // PATHINFO URL参数变量
    'URL_PATHINFO_DEPR'    => '/', //PATHINFO URL分割符

    /* 模板相关配置 */
	'TMPL_PARSE_STRING' => array(
	'__STATIC__' => __ROOT__ . '/Public/static', //静态文件
	'__ASSETS__' => __ROOT__ . '/Public/' . Home . '/assets', //插件目录
	'__IMG__'    => __ROOT__ . '/Public/' . Home . '/images', //图片目录
	'__CSS__'    => __ROOT__ . '/Public/' . Home . '/css', //CSS目录
	'__JS__'     => __ROOT__ . '/Public/' . Home . '/js', //JS目录
	'__FONTS__'  => __ROOT__ . '/Public/' . Home . '/fonts', //JS目录
	),
    /* 数据库配置 */
    'DB_TYPE'   => 'mysql', // 数据库类型
    'DB_HOST'   => 'ikuaidian.mysql.rds.aliyuncs.com', // 服务器地址
    'DB_NAME'   => 'kdweb', // 数据库名
    'DB_USER'   => 'ltj', // 用户名
    'DB_PWD'    => '1990730ltj',  // 密码
    'DB_PORT'   => '3306', // 端口
    'DB_PREFIX' => 'web_', // 数据库表前缀

);
