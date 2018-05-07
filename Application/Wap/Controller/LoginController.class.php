<?php

/*
 *  用户注册、登录一套相关
 * 张伟松
 * 2017年7月18日14:50:43
 */

namespace Wap\Controller;

use Think\Controller;

class LoginController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
        //判断登录状态
        
        if (D('user')->islogin()) { //未登录
            jump('您已经是会员，无需再次注册！', U('user/index'));
        }
    }

    //空方法，防止报错
    public function _empty() {
        $this->login();
    }

    public function index() {
        $this->redirect(U('login'));
    }

    //用户须知
    #显示用户须知
    public function notice() {
//        dd() 
        $this->assign('noticeinfo', D('login')->get_notice());
        $this->display();
    }

    //注册
    public function register() {
        if (IS_POST) {
            $user = array();
            $user['realname'] = I("realname");
            $user['phone'] = I("phone");
            $user['password'] = md5(I("password"));
            $user['brand'] = I("brand");
            $user['carcode'] = I("per_carcode") . I("carcode");
            $user['addtime'] = time();
            $existed_record = D('user')->check_mobile($user['phone']);
            if ($existed_record) {
                jump("手机号已经被注册！", U('login/register'));
            }
            $register_flag = D("user")->add($user);
            if ($register_flag) {
                jump("注册成功", U('login/login'));
            } else {
                jump("注册失败", U('login/register'));
            }
        } else {
            $this->display();
        }
    }

    //登录
    public function login() {
        if (IS_POST) {
            $username = I("username");
            $password = I("password");
            $user_id = D('user')->check_username_and_password($username, $password);
            if ($user_id) {
                D("user")->user_login($user_id);
                jump("登录成功", U('index/index'));
            } else {
                jump("用户名或密码不正确", U('login/login'));
            }
        } else {
            $this->display();
        }
    }

    //忘记密码
    public function forget_password() {
        if (IS_POST) {
            session('user.phone', I("phone"));
            $this->redirect(U('set_password'));
        } else {
            $this->display();
        }
    }

    //退出登录
    public function logout() { 
        session_unset();
        session_destroy();
        jump("退出成功", U("index/index"));
    }

}
