<?php

namespace Manage\Controller;

use Think\Controller;

class SellerController extends Controller {

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

    //商家列表
    public function sellerlist() {
        $where = "1 ";
        $info = I("info");
        if ($info) {
            @extract($info);
            //按名称搜索
            if ($sellername) {
                $info['sellername'] = urldecode($info['sellername']);
                $where .= " and (ec_seller.sellername like '%" . urldecode(trim($info['sellername'])) . "%') ";
                $this->assign('sellername', urldecode($info['sellername']));
            }
            //按时间搜索
            if ($starttime) {
                $info['starttime'] = urldecode($info['starttime']);
                $where .= " and ec_seller.seller_addtime>='" . strtotime(urldecode($info['starttime'])) . "' ";
                $this->assign('starttime', urldecode($starttime));
            }
            if ($endtime) {
                $info['endtime'] = urldecode($info['endtime']);
                $where .= " and ec_seller.seller_addtime<='" . strtotime(urldecode($info['endtime'])) . "' ";
                $this->assign('endtime', urldecode($endtime));
            }
        }
        $count = M("Seller")->where($where)->count();
        $pagesize = I('pagesize') ? I('pagesize') : 15;
        $Page = new \Think\Page($count, $pagesize);
        //分页跳转的时候保证查询条件
        if ($info) {
            foreach ($info as $key => $val) {
                $Page->parameter['info[' . $key . ']'] = urlencode($val);
            }
        }
        $Page->parameter['pagesize'] = $pagesize;
        $pageshow = $Page->manageshow();
        $sellerlist = M('Seller')
                ->where($where)
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->order("seller_id desc")
                ->select();
        //dump($contentinfo);
        foreach ($contentinfo as $k => $v) {
            $contentinfo[$k]['seller_addtime'] = date('Y/m/d H:i:s', $v['seller_addtime']);
        }
        $this->assign('pageshow', $pageshow);
        $this->assign('sellerlist', $sellerlist);
        $this->assign('type', D("Seller")->get_type()); //账号状态	
        $this->display();
    }

    //添加商家
    public function addseller() {
        $admin_realname = session('admin.realname');
        if (IS_POST) {
            $info = I("info");
            $info['seller_addtime'] = SYS_TIME;
            $info['admin_realname'] = $admin_realname;
            $info['password'] = md5($info['password']);
            $info['avatar'] = C('WEB_URL') . "public/wap/images/touxiang_03.png";
            $flag = M("seller")->add($info);
            if ($flag) {
                jump('商家添加成功！', U('seller/sellerlist'));
            } else {
                jump('商家添加失败！', U('seller/sellerlist'));
            }
        } else {
            $this->display();
        }
    }

    //编辑商家
    public function editseller() {
        $seller_id = I("get.seller_id");
        $this->assign('seller_id', $seller_id);
        if (IS_POST) {
            $info = I("info");
            $info['avatar'] = C('WEB_URL') . "public/wap/images/touxiang_03.png";
            $flag = M("Seller")->where('seller_id=' . $seller_id)->save($info);
            if ($flag) {

                $this->success('商家编辑成功！', U('seller/sellerlist'));
            } else {
                $this->error('商家编辑失败！', U('seller/sellerlist'));
            }
        } else {
            $Seller = M("Seller")->where('seller_id=' . $seller_id)->find();
            //dd($Seller);
            $this->assign('seller', $Seller);
            $this->display();
        }
    }

    //商家详情
    public function seller_xq() {
        $seller_id = I('get.seller_id');
        $listinfo = M('Seller')->where('seller_id=' . $seller_id)->find();
        $this->assign('type', D("Seller")->get_type()); //账号状态	
        $this->assign('listinfo', $listinfo);
        $this->display();
    }

    //商家列表重置密码
    public function chongzhi() {
        $seller_id = I("get.seller_id");
        $flag = M("Seller")->where("seller_id=" . $seller_id)->save(array("password" => MD5('123456')));
        if ($flag) {
            jump('重置密码成功！', U('seller/sellerlist'));
        } else {
            jump('重置密码失败！', U('seller/sellerlist'));
        }
    }

    //商家禁用启用
    public function seller_able() {
        $seller_id = I("get.seller_id");
        $sellertype_ = M('Seller')->where('seller_id=' . $seller_id)->field('seller_able')->find();
        if ($sellertype_['seller_able'] == 1) {
            $info['seller_able'] = 2;
        } else {
            $info['seller_able'] = 1;
        }
        M('Seller')->where('seller_id=' . $seller_id)->save($info);
        jump('操作成功！', U('seller/sellerlist'));
    }

    //删除商家信息
    public function del_seller() {
        $seller_id = I("get.seller_id");
        M('Seller')->where('seller_id=' . $seller_id)->delete();
        jump('商家删除成功！', U('seller/sellerlist'));
    }

    //商家活动列表
    public function seller_activelist() {
        $where = "1 ";
        $info = I("info");
        if ($info) {
            @extract($info);
            //按商家名称搜索
            if ($sellername) {
                $info['sellername'] = urldecode($info['sellername']);
                $where .= " and (ec_seller.sellername like '%" . urldecode(trim($info['sellername'])) . "%') ";
                $this->assign('sellername', urldecode($info['sellername']));
            }
            //按活动开始时间搜索
            if ($starttime) {
                $info['starttime'] = urldecode($info['starttime']);
                $where .= " and ec_activity.activity_starttime>='" . strtotime(urldecode($info['starttime'])) . "' ";
                $this->assign('starttime', urldecode($starttime));
            }
            if ($endtime) {
                $info['endtime'] = urldecode($info['endtime']);
                $where .= " and ec_activity.activity_starttime<='" . strtotime(urldecode($info['endtime'])) . "' ";
                $this->assign('endtime', urldecode($endtime));
            }
        }
        $count = M("Activity")->join('left join ec_seller on ec_seller.seller_id=ec_activity.seller_id ')->where($where)->count();
        $pagesize = I('pagesize') ? I('pagesize') : 15;
        $Page = new \Think\Page($count, $pagesize);
        //分页跳转的时候保证查询条件
        if ($info) {
            foreach ($info as $key => $val) {
                $Page->parameter['info[' . $key . ']'] = urlencode($val);
            }
        }
        $Page->parameter['pagesize'] = $pagesize;
        $pageshow = $Page->manageshow();
        $activelist = M('Activity')
                ->where($where)
                ->join('left join ec_seller on ec_seller.seller_id=ec_activity.seller_id ')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->order("ec_activity.id desc")
                ->select();
        //echo $activelist;
        foreach ($contentinfo as $k => $v) {
            $contentinfo[$k]['seller_addtime'] = date('Y/m/d H:i:s', $v['seller_addtime']);
        }
        $this->assign('pageshow', $pageshow);
        $this->assign('activelist', $activelist);
        $this->display();
    }

    //添加商家活动
    public function addactive() {
        $seller_id = I("get.seller_id");
        $this->assign('seller_id', $seller_id);
        if (IS_POST) {
            $info = I("info");
            $starttime = strtotime($info['activity_starttime']);
            $endtime = strtotime($info['activity_endtime']);
            $info['activity_starttime'] = $starttime;
            $info['activity_endtime'] = $endtime;
            $info['activity_addtime'] = SYS_TIME;
            $info['seller_id'] = $seller_id;
            $flag = M("activity")->add($info);
            //echo $flag;die;
            if ($flag) {
                jump('添加活动成功！', U('seller/seller_activelist'));
            } else {
                jump('添加活动失败！', U('seller/seller_activelist'));
            }
        } else {
            $this->display();
        }
    }

    //编辑活动
    public function editactive() {
        $id = I("get.id");
        $seller_id = I("get.seller_id");
        $this->assign('id', $id);
        $this->assign('seller_id', $seller_id);
        if (IS_POST) {
            $info = I("info");
            $info['seller_id'] = $seller_id;
            $starttime = strtotime($info['activity_starttime']);
            $endtime = strtotime($info['activity_endtime']);
            $info['activity_starttime'] = $starttime;
            $info['activity_endtime'] = $endtime;
            $flag = M("Activity")->where('id=' . $id)->save($info);
            if ($flag) {

                $this->success('编辑活动成功！', U('seller/seller_activelist'));
            } else {
                $this->error('编辑活动失败！', U('seller/seller_activelist'));
            }
        } else {
            $activity = M("Activity")->where('id=' . $id)->find();
            $this->assign('activity', $activity);
            $this->display();
        }
    }

    //删除活动
    public function delactive() {
        $id = I("get.id");
        M('Activity')->where('id=' . $id)->delete();
        jump('活动删除成功！', U('seller/seller_activelist'));
    }

    //查看某个商家的报名列表
    public function sell_active() {
        $id = I("get.id");
        $sell = M('baoming')
                ->where('ec_activity.id=' . $id)
                ->join('left join ec_activity on ec_activity.id=ec_baoming.activity_id')
                ->join('left join ec_seller on ec_seller.seller_id=ec_activity.seller_id ')
                ->join('left join ec_user on ec_user.user_id=ec_baoming.user_id ')
                ->field('ec_user.realname,ec_user.phone,ec_baoming.bao_addtime')
                ->select();
        $this->assign('sell', $sell);
        $this->display();
    }

    //报名列表
    public function active_baominglist() {
        $where = "1 ";
        $info = I("info");
        if ($info) {
            @extract($info);
            //按活动名称搜索
            if ($activity_title) {
                $info['activity_title'] = urldecode($info['activity_title']);
                $where .= " and (ec_activity.activity_title like '%" . urldecode(trim($info['activity_title'])) . "%') ";
                $this->assign('activity_title', urldecode($info['activity_title']));
            }
            //按会员电话搜索
            if ($phone) {
                $info['phone'] = urldecode($info['phone']);
                $where .= " and (ec_user.phone like '%" . urldecode(trim($info['phone'])) . "%') ";
                $this->assign('phone', urldecode($info['phone']));
            }
            //按商家名称搜索
            if ($sellername) {
                $info['sellername'] = urldecode($info['sellername']);
                $where .= " and (ec_seller.sellername like '%" . urldecode(trim($info['sellername'])) . "%') ";
                $this->assign('sellername', urldecode($info['sellername']));
            }
            //按时间搜索
            if ($starttime) {
                $info['starttime'] = urldecode($info['starttime']);
                $where .= " and ec_baoming.bao_addtime>='" . strtotime(urldecode($info['starttime'])) . "' ";
                $this->assign('starttime', urldecode($starttime));
            }
            if ($endtime) {
                $info['endtime'] = urldecode($info['endtime']);
                $where .= " and ec_baoming.bao_addtime<='" . strtotime(urldecode($info['endtime'])) . "' ";
                $this->assign('endtime', urldecode($endtime));
            }
        }
        $count = M("Baoming")
                ->join('left join ec_user on ec_user.user_id=ec_baoming.user_id ')
                ->join('left join ec_activity on ec_activity.id=ec_baoming.activity_id')
                ->join('left join ec_seller on ec_activity.seller_id=ec_seller.seller_id')
                ->where($where)
                ->count();
        $pagesize = I('pagesize') ? I('pagesize') : 15;
        $Page = new \Think\Page($count, $pagesize);
        //分页跳转的时候保证查询条件
        if ($info) {
            foreach ($info as $key => $val) {
                $Page->parameter['info[' . $key . ']'] = urlencode($val);
            }
        }
        $Page->parameter['pagesize'] = $pagesize;
        $pageshow = $Page->manageshow();
        $baominglist = M('Baoming')
                ->where($where)
                ->join('left join ec_user on ec_user.user_id=ec_baoming.user_id ')
                ->join('left join ec_activity on ec_activity.id=ec_baoming.activity_id')
                ->join('left join ec_seller on ec_activity.seller_id=ec_seller.seller_id')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->order("ec_baoming.bao_id desc")
                ->select();
        //dump($baominglist);
        foreach ($contentinfo as $k => $v) {
            $contentinfo[$k]['seller_addtime'] = date('Y/m/d H:i:s', $v['seller_addtime']);
        }
        $this->assign('pageshow', $pageshow);
        $this->assign('baominglist', $baominglist);
        $this->display();
    }

    //商家提现记录   
    public function popinfo() {
        $where = "1 ";
        $info = I("info");
        if ($info) {
            @extract($info);
            //按手机号搜索
            if ($sellername) {
                $info['sellername'] = urldecode(trim($info['sellername']));
                $where .= " and ( seller.sellername like '%" . urldecode($info['sellername']) . "%') ";
                $this->assign('sellername', urldecode($info['sellername']));
            }
            //按客户名称
            if ($sellerlinkphone) {
                $info['sellerlinkphone'] = urldecode(trim($info['sellerlinkphone']));
                $where .= " and ( seller.sellerlinkphone like '%" . urldecode($info['sellerlinkphone']) . "%') ";
                $this->assign('sellerlinkphone', urldecode($info['sellerlinkphone']));
            }
            //按申请状态
            if ($pop_flag) {
                $info['pop_flag'] = urldecode(trim($info['pop_flag']));
                $where .= "and ec_popinfo.pop_flag = '" . urldecode($info['pop_flag']) . "' ";
                $this->assign('pop_flag', urldecode($info['pop_flag']));
            }
        }

        $popinfo = M('popinfo');
        // 查询满足要求的总记录数
        $count = $popinfo->where($where)
                ->join("left join ec_seller as seller on seller.seller_id=ec_popinfo.seller_id")
                ->field("ec_popinfo.*,seller.sellername as sellernames")
                ->order('ec_popinfo.pop_id desc')
                ->count();

        $pagesize = I('pagesize') ? I('pagesize') : 15;
        $Page = new \Think\Page($count, $pagesize);
        //分页跳转的时候保证查询条件
        if ($info) {
            foreach ($info as $key => $val) {
                $Page->parameter['info[' . $key . ']'] = urlencode($val);
            }
        }
        $Page->parameter['pagesize'] = $pagesize;
        $pageshow = $Page->manageshow();
        // 进行分页数据查询
        $listinfo = $popinfo->where($where)
                ->join("left join ec_seller as seller on seller.seller_id=ec_popinfo.seller_id")
                ->field("ec_popinfo.*,seller.sellername ,seller.sellerlinkphone")
                ->order('ec_popinfo.pop_id desc')->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();

        $this->assign('listinfo', $listinfo);
        $this->assign('get_popflag', D('Popinfo')->get_popflag());
        $this->assign('pageshow', $pageshow);
        $this->display();
    }

    //未审核用户提现申请审核
    public function popstate() {
        $pop_id = I("get.pop_id");
        $data['pop_flag'] = 2;
        $infolist = M('Popinfo')->where('pop_id=' . $pop_id . " ")->data($data)->save();
        jump('提现审核成功！', U('seller/popinfo'));
    }

    //商家信息修改记录   
    public function sellermodityss() {
        $where = "1 ";
        $info = I("info");
        if ($info) {
            @extract($info);
            //按客户名称
            if ($sellername) {
                $info['sellername'] = urldecode(trim($info['sellername']));
                $where .= " and ( seller.sellername like '%" . urldecode($info['sellername']) . "%') ";
                $this->assign('sellername', urldecode($info['sellername']));
            }
            //按申请状态
            if ($modify_flag) {
                $info['modify_flag'] = urldecode(trim($info['modify_flag']));
                $where .= "and ec_sellermodify.modify_flag = '" . urldecode($info['modify_flag']) . "' ";
                $this->assign('modify_flag', urldecode($info['modify_flag']));
            }
        }

        $sellermodify = M('sellermodify');
        // 查询满足要求的总记录数
        $count = $sellermodify->where($where)
                ->join("left join ec_seller as seller on seller.seller_id=ec_sellermodify.seller_id")
                ->field(" ec_sellermodify.* ")
                ->count();

        $pagesize = I('pagesize') ? I('pagesize') : 15;
        $Page = new \Think\Page($count, $pagesize);
        //分页跳转的时候保证查询条件
        if ($info) {
            foreach ($info as $key => $val) {
                $Page->parameter['info[' . $key . ']'] = urlencode($val);
            }
        }
        $Page->parameter['pagesize'] = $pagesize;
        $pageshow = $Page->manageshow();
        // 进行分页数据查询
        $listinfo = $sellermodify->where($where)
                ->join("left join ec_seller as seller on seller.seller_id=ec_sellermodify.seller_id")
                ->field("ec_sellermodify.*,seller.sellername")
                ->order('ec_sellermodify.modify_id desc')->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();

        $this->assign('listinfo', $listinfo);
        $this->assign('get_popflag', D('Popinfo')->get_popflag());
        $this->assign('get_modify_type', D('Popinfo')->get_modify_type());
        $this->assign('pageshow', $pageshow);
        $this->display();
    }

    //未审核用户商家信息审核
    public function moditystate() {
        $modify_id = I("get.modify_id");
        $sellermodify_ = M('sellermodify')->where('modify_id=' . $modify_id)->find();
        if ($sellermodify_['modify_type'] == 1) {
            //联系人
            $data1['sellerlinkman'] = $sellermodify_['modify_value'];
        } else if ($sellermodify_['modify_type'] == 2) {
            //联系电话
            $data1['sellerlinkphone'] = $sellermodify_['modify_value'];
        }
        $data['modify_flag'] = 2;
        M('seller')->where('seller_id=' . $sellermodify_['seller_id'])->save($data1);
        M('sellermodify')->where('modify_id=' . $modify_id)->save($data);

        jump('审核成功！', U('seller/sellermodityss'));
    }

}
