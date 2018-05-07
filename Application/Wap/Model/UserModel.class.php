<?php

/*
 * 张伟松
 * 
 * 用户模型
 * 
 * 2017年7月19日10:41:38
 */

namespace Wap\Model;

use Think\Model;

class UserModel extends Model {

    //判断当前用户是否登录

    public function islogin() {
        //user_id  phone carcode
        $user_id = session('user.user_id');
        $phone = session('user.phone');
        $carcode = session('user.carcode');
        if (!$user_id || !$phone || !$carcode) {
            return false;
        } else {
            return true;
        }
    }

    //用户登录

    public function user_login($user_id) {
        $user = $this->find($user_id);
        session("user", $user);
        return true;
    }

    //用户修改密码
    /*
     * user_id 用户id
     * oldpassword 原密码
     * newpassword 新密码
     * return true/false
     */
    public function pswuser($user_id, $oldpassword, $newpassword) {
        if (!$user_id || !$oldpassword || !$newpassword)
            return false;

        $data = $this->where("user_id=" . $user_id)->find();
        if ($data) {
            if ($data['password'] == md5($oldpassword)) {
                $newpassword = md5($newpassword);
                $this->where("user_id=" . $user_id)->save(array("password" => $newpassword));
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    //判断手机号是否存在
    //返回存在的个数
    public function check_mobile($mobile) {
        return $this->where("phone=" . $mobile)->count();
    }

    //check_username_and_password

    public function check_username_and_password($username, $password) {
        //车牌号 或者 手机号
        $user1 = $this->where("carcode=" . $username)->find();
        if ($user1['password'] == md5($password)) {
            return $user1['user_id'];
        }
        $user2 = $this->where("phone=" . $username)->find();
        if ($user2['password'] == md5($password)) {
            return $user2['user_id'];
        }
        return false;
    }

    //重设密码
    public function set_password_by_phone($phone, $password) {
        if ($phone && $password) {
            $user = $this->where("phone=" . $phone)->find();
            if (!$user)
                return false;
            $this->data(array("password" => md5($password)))->where("user_id=" . $user['user_id'])->save();
            return true;
        } else {
            return false;
        }
    }

    //ajax验证时检验密码
    public function check_password($user_id, $old_password) {
        if ($user_id && $old_password) {
            $user = $this->find($user_id);
            if (!$user)
                return false;
            if ($user['password'] == md5($old_password)) { //验证成功
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
    //退出登录
    public function logout(){
        session("user", array());
    }

}
