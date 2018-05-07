<?php

/*
 *  官方系统相关
 * 公司介绍
 * 系统消息等
 * 
 * 
 * 张伟松
 * 
 * 2017年7月18日14:50:50
 */

namespace Wap\Controller;

use Think\Controller;

class SystemController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
        //判断登录状态

        if (!D('user')->islogin()) { //未登录
            jump('您尚未登录，请先登录！', U('login/login'));
        }
    }

    //空方法，防止报错
    public function _empty() {
        $this->company_introduction();
    }

    //公司介绍
    public function company_introduction() {
        $this->display();
    }

    //活动列表
    public function activity_list() {
        $user_id = session("user.user_id"); 
        $where = 'ec_activity.activity_starttime< '  .time(). ' and '.time().' < ec_activity.activity_endtime  ';
        $where .= " AND ec_baoming.user_id= ".$user_id." ";
        $list = M('baoming');
        $count = $list
                ->join("LEFT JOIN ec_activity ON ec_activity.id = ec_baoming.activity_id") 
                ->where($where)
                ->count(); 
        $pagesize = 5;
        $Page = new \Think\Page($count, $pagesize);

        // 进行分页数据查询
        $activityList = $list
                ->field('id,activity_image')
                ->join("LEFT JOIN ec_activity ON ec_activity.id = ec_baoming.activity_id") 
                ->where($where)
                ->order('ec_baoming.bao_addtime desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select(); 
        if (IS_AJAX) {
            $this->ajaxReturn($activityList);
        } else {
            $this->assign('activityList', $activityList);
            $this->display();
        }
    }

    //活动详情
    public function activity_detail($activity_id) {
        $user_id = session('user.user_id');
        $activityDetails = M('activity')
                ->where("id='{$activity_id}'")
                ->field('id,activity_image,activity_content')
                ->select();
        $this->assign('activityDetails', $activityDetails);
        $isEngage = M('baoming')
                ->where("user_id = " . $user_id . " and activity_id = " . $activity_id . "")
                ->select();
        $this->assign('user_id', $user_id);
        $this->assign('activity_id', $activity_id);
        //如果不为空 且为 数组
        if (!empty($isEngage) && is_array($isEngage)) {
            $this->assign('isEngage', 1);
        } else {
            $this->assign('isEngage', 2);
        }
        $this->display();
    }

    //消息通知
    public function message() {
        $user_id = session('user.user_id');
        $message = M('message');
        $count = $message
                ->where('(msg_type=0 OR msg_type=2) AND (msg_to=0 OR msg_to=' . $user_id . ')')
                ->count(); //22
        $pagesize = 9;
        $Page = new \Think\Page($count, $pagesize);
        // 进行分页数据查询
        $messageList = $message
                //->field('is_read')
                ->where('(msg_type=0 OR msg_type=2) AND (msg_to=0 OR msg_to=' . $user_id . ')')
                ->order('msg_addtime')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        if (IS_AJAX) {
            $this->ajaxReturn($messageList);
        } else {
            $this->assign('messageList', $messageList);
            $this->display();
        }
    }

    //商家详情
    public function bus_detail($seller_id) {
        $seller = M('seller');
        $sellerInfo = $seller->where("seller_id='{$seller_id}'")->find();
        $seller_location = explode(',', $sellerInfo['seller_location']);
        $sellerInfo['seller_location'] = $seller_location[1].','.$seller_location[0];
        $this->assign('sellerInfo', $sellerInfo);
        $this->assign("user_location", session("lat").','.session("lng")); 
        $this->display();
    }

    //消息详情
    public function messageinfo() {
        $msg_id = I('msg_id');
        $data = array('is_read' => 1);
        M('message')->where('msg_id=' . $msg_id)->save($data);
        $message = M('message')->where('msg_id=' . $msg_id)->select();
        $this->assign('message', $message);
        $this->display();
    }

}
