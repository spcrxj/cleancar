<?php

namespace Manage\Controller;

use Think\Controller;

class DaijiaofeiController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
    }

    //空方法，防止报错
    public function _empty() {
        $this->index();
    }

    //默认首页
    public function index() {
        $this->display();
    }

    //待充值会员列表
    public function userList()
    {
        $where="1";
        $info=I("info");
        if ($info){
            @extract($info);
            //姓名查找
            if($realname){
                $info['realname']=urldecode($info['realname']);
                $where.=" and realname like '%".trim(urldecode($info['realname']))."%' ";
                $this->assign('realname',urldecode($info['realname']));
            }
            //电话查找
            if($phone){
                $where.=" and phone like '%".trim(urldecode($info['phone']))."%' ";
                $this->assign('phone',$phone);
            }
            //车牌号查找
            if($carcode){
                $info['carcode']=urldecode($info['carcode']);
                $where.=" and carcode like '%".trim(urldecode($info['carcode']))."%' ";
                $this->assign('carcode',urldecode($info['carcode']));
            }
        }
        $user=M('user');
        $monthtime=strtotime("+1 month");
        $where.=" and cleantime < " .$monthtime."";
        // 查询满足要求的总记录数
        $count = $user->where($where)->count();
        $pagesize=I('pagesize')?I('pagesize'):15;
        $Page = new \Think\Page($count,$pagesize);
        //分页跳转的时候保证查询条件
        if($info){
            foreach($info as $key=>$val) {
                $Page->parameter['info['.$key.']']   =   urlencode($val);
            }
        }
        $Page->paramete['pagesize']=$pagesize;
        $pageshow   = $Page->manageshow();
        $userlist = $user->where($where)
						 ->join('left join ec_admin on ec_admin.admin_id=ec_user.dealwith')
						 ->field('ec_user.*,ec_admin.realname as realname1')
		                 ->order('ec_user.user_id desc')
						 ->select();
        $this->assign('userlist', $userlist);
        $this->assign('pageshow',$pageshow);
        $this->display();
    }
    //手工充值成功：
    public function rechargePro($user_id)
    {
        $data['pay_tradeno']=time();
        $data['pay_addtime']=time();
        $data['user_id']=$user_id;
        $data['pay_money']=500;
        $data['pay_type']=2;
        $data['pay_remarks']="手工充值500元";
        $data['pay_flag']=2;
        $payInfo = M("payinfo");
        //更新用户表的洗车时间；
        $UserTab=M("user");
        $dat['user_id']=$user_id;
        $dat['cleantime']=strtotime("+1 year");
        $resTab=$UserTab->data($dat)->save();
        $res=$payInfo->data($data)->add();
        if($res && $resTab) {
            jump('充值成功！',U('Daijiaofei/userList'));
        }else {
            jump('充值失败！',U('Daijiaofei/userList'));
        }
    }

}
