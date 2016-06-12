<?php
/**
 * 生产环境URL，上线时请将配置文件中的配置指向该处
 */

	const LOGIN_AUTHENTICATION_URL = 'http://ikuaidian.com:8181/kd2/api/web/index.php/v1/web-login/login';

		//管理员获取商户列表接口
	const ADMIN_GET_MERCHANT_URL  =  'http://ikuaidian.com:8181/kd2/api/web/index.php/v1/web-merchants/merchants-lists';

	//服务商获取商户列表接口
	const MER_GET_MERCHANT_URL  =  'http://ikuaidian.com:8181/kd2/api/web/index.php/v1/web-merchants/myself-list';
?>