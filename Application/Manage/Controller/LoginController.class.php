<?php
namespace Manage\Controller;
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
	
	//登录页面
    public function login(){
		if (IS_POST){
			$username=I("username");
			$password=I("password");
			$flag=D("Admin")->adminlogin($username,$password);
			if($flag){
				jump('登录成功！',U('index/index'));
			}else{
				jump('登录失败！',U('login/login'));
			}
		}else{
			$this->display();
		}
    }

	//退出
	public function loginout(){
		session('admin',null);
		jump('退出登录成功！',U('login/login'));
    }
}