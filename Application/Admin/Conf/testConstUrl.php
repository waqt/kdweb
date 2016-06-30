<?php
/**
 * 测试环境URL，测试时请将配置文件中的配置指向该处
 */
 	const BASE_URL   =		'http://ikuaidian.com:8181/kd2test/api/web/index.php/v1/';

	//登录验证接口
	const LOGIN_AUTHENTICATION_URL = 'web-login/login';

	/**
	 *电器品类管理
	 */
	//电器品类列表接口
	const APPLIANCE_LIST_URL  =  'web-appliance/appliance-list';

	//删除电器品类接口
	const DELETE_APPLIANCE_URL  =  'web-appliance/delete-appliance';

	//获取电器品类（父类)接口
	const APPLIANCE_FATHER_LIST_URL = 'web-appliance/appliance-father-list';

	//添加电器品类
	const ADD_APPLIANCE_URL = 'web-appliance/insert-appliance';

	/*
	* 商户管理
	*/
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

	//同意品牌授权
	const AGREE_BRAND_APPLY = 'web-brand/save-agree';

	//同意商户认证
	const AGREE_MERCHANT_AUTH = 'web-merchants/agree-merchant-authorize';

	//取消商户认证
	const REFUSE_MERCHANT_AUTH = 'web-merchants/refund-merchant-authorize';

	//管理员获取商户列表接口
	const ADMIN_GET_MERCHANT_URL  =  'web-merchants/merchants-lists';

	//服务商获取商户列表接口
	const MER_GET_MERCHANT_URL  =  'web-merchants/myself-list';


	/*
	* 品牌管理
	*/
	//品牌列表
	const GET_BRAND_LIST_PAGE = 'web-brand/brand-page-list';

	//品牌列表无分页
	const GET_BRAND_LIST = 'web-brand/brand-list';

	//删除品牌
	const DELETE_BRAND_URL = 'web-brand/delete-brand';

	//添加品牌
	const ADD_BRAND_URL = 'web-brand/insert-brand';

	/*
	* 用户管理
	*/
	//获取用户列表
	const GET_CUSTOMER_LIST_URL = 'web-users/user-lists';

	//获取用户列表
	const GET_CUSTOMER_DETAIL_URL = 'web-users/user-detail';

	/*
	* 订单管理
	*/
	//管理员获取订单列表接口
	const ADMIN_GET_ORDER_URL  =  'web-orders/admin-order-lists';

	//服务商获取订单列表接口
	const MER_GET_ORDER_URL  =  'web-orders/merchant-order-lists';

	//服务商获取订单列表接口
	const SALE_GET_ORDER_URL  =  'web-orders/saleor-order-lists';

	//服务商获取订单列表接口
	const GET_ORDER_DETAIL  =  'web-orders/order-detail-info';
?>