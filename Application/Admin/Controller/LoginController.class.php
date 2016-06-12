<?php
namespace Admin\Controller;
use Admin\Logic as l;
use Think\Controller;
use Org\Util\Image as Image; 


/**
* 登录控制器
*/
class LoginController extends Controller {
    public function index(){
   		header("Location:".__MODULE__."/Login/login");
    }

    //生成验证码
    public function verify() {
		$type = I('type', 'gif');
		Image::buildImageVerify( 4, 1, $type);
	}

	//登录检查
	public function checkLogin() {
		$login_logic = new l\LoginLogic();
		$result = $login_logic->checkLogin(I('loginname'), I('password'), I('verify'));
		if ($result == false) {
			$data['success']=false;
			$data['error_code']=$login_logic->getErrorCode();
			$data['jumpUrl']=$login_logic->getJumpUrl();
			$data['errorMsg']=$login_logic->getErrorMessage();
			$this->ajaxReturn($data,'JSON');
		} else {
			$data['success']=true;
			$data['jumpUrl']=__MODULE__.'/Index';
			$data['successMsg']='登录成功！';
			$this->ajaxReturn($data,'JSON');
		}
	}

	public function login() {
		$is_login = session(C('USER_AUTH_KEY'));
		if(empty($is_login)) {
			$this->display();
		} else {
			header("Location:".__MODULE__.'/Index');
			exit;
		}
	}

		// 用户登出
	public function loginout() {
		session(null);
		session_destroy();
		$data['message']='登出成功！';
		$data['jumpUrl']=__MODULE__.'/Login';
		$this->ajaxReturn($data,'JSON');
	}


}
