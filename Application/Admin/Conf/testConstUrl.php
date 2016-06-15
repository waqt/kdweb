<?php
/**
 * 测试环境URL，测试时请将配置文件中的配置指向该处
 */
 	const BASE_URL   =		'http://ikuaidian.com:8181/kd2test/api/web/index.php/v1/';

	//登录验证接口
	const LOGIN_AUTHENTICATION_URL = 'web-login/login';

	//管理员获取商户列表接口
	const ADMIN_GET_MERCHANT_URL  =  'web-merchants/merchants-lists';

	//服务商获取商户列表接口
	const MER_GET_MERCHANT_URL  =  'web-merchants/myself-list';

	//电器品类列表接口
	const APPLIANCE_LIST_URL  =  'web-appliance/appliance-list';

	//删除电器品类接口
	const DELETE_APPLIANCE_URL  =  'web-appliance/delete-appliance';
?>