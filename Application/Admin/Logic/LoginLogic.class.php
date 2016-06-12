<?php
// +----------------------------------------------------------------------
// | TP-Admin [ 多功能后台管理系统 ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2016 http://www.hhailuo.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: 逍遥·李志亮 <xiaoyao.working@gmail.com>
// +----------------------------------------------------------------------

namespace Admin\Logic;
use Lib\Log;
use Org\Util\CustomRbac as CUSTOMRABC;

/**
* 登录控制Logic
*/
class LoginLogic extends BaseLogic {
    protected $jumpUrl = '';

    /**
     * 登录检查
     * @param String $username 用户名
     * @param String $password 密码
     * @param String $verify 验证码         
     * @return boolean
     */
    public function checkLogin($username, $password, $verify) {
        $this->jumpUrl = __MODULE__ . C('USER_AUTH_GATEWAY');
        if(session('verify') != md5($verify)) {
            $this->errorCode = 10001;
            $this->errorMessage = '验证码错误！';
            return false;
        }

        // 生成认证条件
        /*****************
        $data = array();
        $data['ip']    = get_client_ip();
        $data['date']  = date("Y-m-d H:i:s");
        $data['username'] = $username;
        $data['module'] = MODULE_NAME;
        $data['action'] = ACTION_NAME;
        $data['querystring'] = U( MODULE_NAME . '/' . ACTION_NAME );
        ********************/
        //使用用户名、密码和状态的方式进行认证
        $verifyResult=CUSTOMRABC::verifyUser($username, $password);
        $authInfo =array();
        $authInfo=$verifyResult['data'][0];
        //$data['dataname'] ='data';
        //$data['data']=$authInfo;
        //model("Log")->add($data);
        //addErrorLog($data['action'],$data['module'],$data['dataname'],$data['data']);

        /***************
        //301  手机号和密码都不可以为空
        //400  该手机号尚未注册
        //401  密码错误,请重新输入
        //402  无该商户信息
        //403  无该员工信息
        //200  登录成功
        //500  登录失败
        ***************/
        if($verifyResult['status']=='301'||$verifyResult['status']=='401')
            {
                //$data['status'] = $verifyResult['status'];
                //M('Log')->add($data);
                $this->errorCode = $verifyResult['status'];
                $this->errorMessage = '帐号不存在或密码错误';
                return false;
            }
        else if($verifyResult['status']=='500')
            {
                //$data['status'] = $verifyResult['status'];
                //M('Log')->add($data);
                $this->errorCode = $verifyResult['status'];
                $this->errorMessage = '服务器响应中';
                return false;

            }
        else if($verifyResult['status']=='400')
            {
                //$data['status'] = $verifyResult['status'];
                //M('Log')->add($data);
                $this->errorCode = $verifyResult['status'];
                $this->errorMessage = '您没有登陆后台的权限';
                return false;

            } 
        else if($verifyResult['status']=='200')
            {
                // 登录状态session
                session(array('name'=>C('USER_AUTH_KEY'),'expire'=>3600));
                session(C('USER_AUTH_KEY'),$authInfo['role']);
                // 用户信息session
                session('user_info',$authInfo);
                if($authInfo['role']==3000) {
                    //记录超级管理员角色
                    session('administrator', true);
                }else{
                    session('administrator', false);
                }
                CUSTOMRABC::saveCustomAccessList($authInfo['id'],$authInfo['role']);
                //$data['status'] = $verifyResult['status'];
                //$data['userid'] = $authInfo['id'];
                //M('Log')->add($data);
                return true;
            }
    }

    public function getJumpUrl() {
        return $this->jumpUrl;
    }

}