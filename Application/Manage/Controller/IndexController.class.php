<?php

namespace Manage\Controller;

use Think\Controller;

class IndexController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();

        //判断登录状态
        if (!D('Admin')->islogin()) {//未登录
            jump('您尚未登录，请先登录！', U('login/login'));
        }
    }

    //空方法，防止报错
    public function _empty() {
        $this->index();
    }

    //默认首页
    public function index() {
		$admin_id = session("admin.admin_id");
    	//$weidu = M("message")->where("user_id='".$user_id."' and msg_flag=1")->count();
    	//$this->assign("weidu",$weidu);
    	$this->display();
    }

    //欢迎页
    public function welcome() {
		$admin_id = session("admin.admin_id");
		$this->assign('admin_id', $admin_id);
        $this->display();
    }

    //修改密码
    public function passwordadmin() {
        $admin_id = session('admin.admin_id');
        if (IS_POST) {
            $info = I("info");
            $flag = D("Admin")->pswadmin($admin_id, trim($info['oldpassword']), trim($info['newpassword']));
            if ($flag) {
                jump('密码修改成功！', U('index/welcome'));
            } else {
                jump('密码修改失败！', U('index/passwordadmin'));
            }
        } else {
            $admininfo = M("Admin")->where("admin_id=" . $admin_id)->find();
            $this->assign('admininfo', $admininfo);
            $this->display();
        }
    }
}
