<?php
namespace Admin\Controller;
use Think\Controller;
use Admin\Controller\CommonController;
use Admin\Logic as l;


class IndexController extends CommonController {
  public function index(){
    // 获取顶部可访问菜单
    $menu_logic = new l\MenuLogic();
    $left_menu = $menu_logic->getAccessibleLeftMenu();
    foreach($left_menu as &$lm){
       $lm['child_menu']=$menu_logic->getAccessibleLeftChildMenu($lm['id']);
    }
    $top_menu[0]= array("class" => "fa fa-tasks","ul" =>"dropdown-menu extended tasks-bar","number" => "4");
    $top_menu[1]= array("class" => "fa fa-envelope-o","ul" =>"dropdown-menu extended inbox","number" => "5");
    $role = model('Role')->find(session('user_info.role'));
    //$role = model('Role')->find(session('user_info.role_id'));
    //$_SESSION['user_info']['name'] = $role['name'];

    $this->assign('top_menu', $top_menu);
    $this->assign('left_menu', $left_menu);
    $this->assign('user_info', session('user_info'));
    $this->display();
  }

  public function logined(){
    	return true;
    }

  /**
  * 维持 session 登陆状态
  */
  public function public_session_life() {
    return true;
  }
}