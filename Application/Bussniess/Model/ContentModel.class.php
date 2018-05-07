<?php 
namespace Bussniess\Model;

use Think\Model;

class ContentModel extends Model {
    //获取登录所需会员须知
    public function get_notice(){
        $notice = M('content')->find(3); 
        return $notice;
    }
}
