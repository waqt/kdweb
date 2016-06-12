<?php
namespace Admin\Controller;
use Think\Controller;
class TestController extends Controller {
    public function index(){
    	$this->assign('prourl',LOGIN_AUTHENTICATION_URL);
   		$this->display();
    }

}