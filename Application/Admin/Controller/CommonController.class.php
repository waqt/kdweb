<?php
// +----------------------------------------------------------------------
// | Ikuaidian [ 快点台管理系统 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2015-2016 http://www.ikuaidian.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: liutj
// +----------------------------------------------------------------------

namespace Admin\Controller;
use Think\Controller;
use Org\Util\Rbac as RBAC;

/**
* 后台基类
*/
class CommonController extends Controller {
    // 无需验证方法
    protected $exceptAuth = array(
        'Index' => array('index','left', 'main', 'public_session_life'),
        );

    function __construct() {
        parent::__construct();
        $this->filterLogin();
        if (isset($this->exceptAuth[CONTROLLER_NAME]) && in_array(ACTION_NAME, $this->exceptAuth[CONTROLLER_NAME])) {
            return ;
        }
        $this->filterAuth();
    }

    protected function beforeFilter($method, $params=array()) {
        if (empty($params)) {
            call_user_func(array($this, $method));
        } else {
            if (isset($params['only'])) {
                if (in_array(ACTION_NAME, $params['only'])) {
                    call_user_func(array($this, $method));
                }
            } elseif (isset($params['except'])) {
                if (!in_array(ACTION_NAME, $params['except'])) {
                    call_user_func(array($this, $method));
                }
            }
        }
    }

    protected function filterLogin() {
        if (!$_SESSION[C('USER_AUTH_KEY')]) {
            if (IS_AJAX) {
                $this->ajaxReturn("<script type='text/javascript'>window.top.location.reload();</script>", 'eval');
            }
            //跳转到认证网关
            $this->assign('jumpUrl', __MODULE__ . C('USER_AUTH_GATEWAY'));
            $this->assign('waitSecond',3);
            header("Location:".__MODULE__."/Login");
            exit();
        }
    }

    protected function filterAuth() {
		// 用户权限检查
		if (!RBAC::AccessDecision()) {
			// 没有权限 抛出错误
			if (C('RBAC_ERROR_PAGE')) {
				// 定义权限错误页面
				$this->assign('jumpUrl', __MODULE__ . C('RBAC_ERROR_PAGE'));
                //$data['auth']=false;
                //$this->error($data,ajax);
                //$this->ajaxReturn($data,'JSON');
				//model('Log')->addLog(2);
				redirect(C('RBAC_ERROR_PAGE'));
			} else {
				if (C('GUEST_AUTH_ON')) {
					$this->assign('jumpUrl', PHP_FILE . C('USER_AUTH_GATEWAY'));
				}
				// 提示错误信息
				$this->error(L('_VALID_ACCESS_'));
			}
		}
		// 记录操作日志
		//model('Log')->addLog(1);
    }

    protected function filterPostTypeAuth() {
        return true;
    }

	protected function checkToken() {
		if (IS_POST) {
			if (!M()->autoCheckToken($_POST)) {
				$this->error('[hash]数据验证失败');
			}
		}
	}

}