<?php

/* 
 * 登录注册相关模型
 * 
 * 张伟松
 * 
 * 2017年7月18日14:55:25
 */

namespace Wap\Model;

use Think\Model;

class LoginModel extends Model {
    //获取登录所需会员须知
    public function get_notice(){
        $notice = M('content')->find(3); 
        return $notice;
    }
}
