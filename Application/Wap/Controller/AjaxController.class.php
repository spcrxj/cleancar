<?php

/*
 *  ajaxko控制器 
 * 张伟松
 * 2017年7月18日16:03:49
 * 
 */

namespace Wap\Controller;

use Think\Controller;

class AjaxController extends Controller {

    //验证手机号是否存在
    public function check_register_mobile_number() {
        $mobile = I("mobile");
        $existed_record = D('user')->check_mobile($mobile);
        echo $existed_record ? 1 : 0;
    }

    //发送验证码
    public function send_sms() {
        $mobile = I("mobile");
        //发送验证码
        $vcode = mt_rand(1000, 9999);
        session("vcode", $vcode);
        echo $vcode;
    }

    //判断验证码是否正确
    function check_if_cvode_is_verified() {
        $vcode = I("vcode");
        echo $vcode == session('vcode') ? 1 : 0;
    }

    //判断原始密码是否正确
    function check_if_password_is_verified() {

        $user_id = session('user.user_id');
        $old_password = I("old_password");
        $flag = D("user")->check_password($user_id, $old_password);
        echo $flag ? 1 : 0;
    }

    public function is_login() {
        $data['user_id'] = $_GET['user_id'];
        $data['activity_id'] = $_GET['activity_id'];
        $data['bao_addtime'] = time();
        if (empty($data['user_id'])) {
            echo $code = 0;
        } else {
            //插入一条报名记录
            $addBaomingLog = M('baoming')->data($data)->add();
            //参加报名人数加一
            M('activity')->where("id='{$data['activity_id']}'")->setInc('activity_num', 1);
            echo $addBaomingLog ? 1 : 2;
        }
    }

    public function index_get_more() {
        //用户的经纬度
        $lat = session('lat');
        $lng = session('lng');
        $index = I("index");
        switch ($index) {
            case 0:
                $order = "seller_id desc"; //综合排序
                break;
            case 1:
                $order = "clean_people desc"; //洗车人次
                break;
            case 2:
                $order = "distance"; //距离最近
                break;
            default:
                $order = "seller_id desc"; //综合排序
                break;
        }
        $count = M('seller')
                ->count();
        $Page = new \Think\Page($count, 2);
        $sellerList = M('seller')
                ->field("ec_seller.*,round(6378.138*2*ASIN(SQRT(POW(SIN((" . $lng . "*PI()/180-substring_index(seller_location, ',', 1)*PI()/180)/2),2)+COS(" . $lng . "*PI()/180)*COS(substring_index(seller_location, ',', 1)*PI()/180)*POW(SIN((" . $lat . "*PI()/180-substring_index(seller_location, ',', -1)*PI()/180)/2),2))),1)as distance")
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->order($order)
                ->select();
        foreach ($sellerList as $key => $value) {
            $sellerList[$key]['remark'] = explode(',', $value['remark']);
            $seller_location = explode(',', $value['seller_location']);
            $sellerList[$key]['seller_location'] = $seller_location[1] . ',' . $seller_location[0];
        }
        $this->ajaxReturn(array('sellerList' => $sellerList));
    }

    //优惠活动获取更多
    public function activity_get_more() {
        $list = M('activity');
        $count = $list->field('id')->count();
        $Page = new \Think\Page($count, 5);
        // 进行分页数据查询
        $activityList = $list
                ->field('id,activity_image')
                ->order('activity_addtime desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        $this->ajaxReturn(array('activityList' => $activityList));
    }

}
