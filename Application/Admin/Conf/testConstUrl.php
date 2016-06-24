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

	/**
	 *电器品类管理
	 */
	//电器品类列表接口
	const APPLIANCE_LIST_URL  =  'web-appliance/appliance-list';

	//删除电器品类接口
	const DELETE_APPLIANCE_URL  =  'web-appliance/delete-appliance';

	//获取电器品类（父类)接口
	const APPLIANCE_FATHER_LIST_URL = 'web-appliance/appliance-father-list';

	//添加电器父类
	const ADD_FATHER_APPLIANCE_URL = 'web-appliance/insert-father-appliance';

	//获取商户详情
	const GET_MERCHANT_DETAIL = 'web-merchants/merchant-info';

	//商户品牌授权申请列表
	const GET_BRAND_APPLY_LIST = 'web-brand/apply-brand-list';

	//商户已授权品牌
	const GET_ACHIEVE_BRAND_LIST = 'web-brand/achieve-brand-list';

	//商户品牌申请详情
	const GET_BRAND_APPLY_DETAIL = 'web-brand/brand-detail-info';

	//拒绝品牌授权
	const DISAGREE_BRAND_APPLY = 'web-brand/save-refund';

	//同意商户认证
	const AGREE_MERCHANT_AUTH = 'web-merchants/agree-merchant-authorize';

	//取消商户认证
	const REFUSE_MERCHANT_AUTH = 'web-merchants/refund-merchant-authorize';

	//品牌列表
	const GET_BRAND_LIST = 'web-brand/brand-page-list';

	//删除品牌
	const DELETE_BRAND_URL = 'web-brand/delete-brand';

	//添加品牌
	const ADD_BRAND_URL = 'web-brand/insert-brand';
?>