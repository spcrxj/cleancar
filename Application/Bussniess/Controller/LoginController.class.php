<?php

namespace Bussniess\Controller;

use Think\Controller;

class LoginController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
    }
    //空方法，防止报错
    public function _empty(){
        $this->login();
    }
	public function index(){
        $this->display('login');
    }
    //登录
    public function login(){
		$username=I("get.username");
		if(IS_POST){
			$username=I("username");
			$password=I("password");
			$flag=D('Seller')->sellerlogin($username, $password);
			if($flag){
				jump("登录成功",U("index/index"));
			}else{
				jump("登录失败",U("login/index"));
			}
		}else{
			$this->assign('username', $username);
			$this->display();
		}
    }
	//退出
	public function loginout(){
		session('seller',null);
		jump('退出登录成功！',C("WEB_URL")."index.php?m=Bussniess&c=login&a=login");
    }
}
