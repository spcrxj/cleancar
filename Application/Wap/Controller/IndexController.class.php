<?php

/*
 *  首页控制器 
 * 张伟松
 * 2017年7月18日14:50:32
 * 
 */

namespace Wap\Controller;

use Think\Controller;

class IndexController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
        //判断登录状态
    }

    //空方法，防止报错
    public function _empty() {
        $this->index();
    }

    //默认首页
    public function index() {
        session("lat", I("lat"));
        session("lng", I("lng"));
        //定位
        if (session("lat") == "" || session("lng") == "") {
            $this->redirect(U("index/location"));
        }

        //用户的经纬度  
        //未读信息
        $user_id = session('user.user_id');
        $count = M('Message')
                ->where('(msg_type=0 OR msg_type=2) AND (msg_to=0 OR msg_to=' . $user_id . ') AND is_read = 0')
                ->count();
        $this->assign('count', $count);
        //$this->ajaxReturn(array('count'=>$count)); 
        //轮播图
        $focuslist = M('Focus')
                ->order('focus_id desc')
                ->select();
        $this->assign('focuslist', $focuslist);
        //滚动广告
        $activitylist = M('Activity')
                ->where('activity_starttime < ' . time() . ' and ' . time() . '< activity_endtime')
                ->join("LEFT JOIN ec_seller ON ec_activity.seller_id = ec_seller.seller_id")
                ->order('activity_addtime desc')
                ->field('ec_activity.activity_title,ec_activity.id,ec_activity.activity_starttime,ec_seller.sellername')
                ->select();
        foreach ($activitylist as $key => $value) {
            $activitylist[$key]['activity_starttime'] = future_time($value['activity_starttime']);
        }
        $this->activitylist = $activitylist;
        //热门活动显示三个；
        $activity = M('activity');
        $where = 'activity_starttime<' . time() . ' and ' . time() . '< activity_endtime';
        $activityList = $activity
                ->field('id,activity_image')
                ->order('activity_num desc')
                ->where($where)
                ->limit(3)
                ->select();
        $this->assign('activityList', $activityList);
        //推荐商家显示全部；
        $where = " 1";
        $seller = M('seller');
        // 查询满足要求的总记录数  
        //综合排序
        $lat = session("lat");
        $lng = session("lng");
        $sellerList = $seller
                ->where($where)
                ->field("ec_seller.*,round(6378.138*2*ASIN(SQRT(POW(SIN((" . $lng . "*PI()/180-substring_index(seller_location, ',', 1)*PI()/180)/2),2)+COS(" . $lng . "*PI()/180)*COS(substring_index(seller_location, ',', 1)*PI()/180)*POW(SIN((" . $lat . "*PI()/180-substring_index(seller_location, ',', -1)*PI()/180)/2),2))),1)as distance")
                ->order('seller_id desc')
                ->limit(2)
                ->select();
        foreach ($sellerList as $key => $value) {
            $sellerList[$key]['remark'] = explode(',', $value['remark']);
            $seller_location = explode(',', $value['seller_location']);
            $sellerList[$key]['seller_location'] = $seller_location[1] . ',' . $seller_location[0];
        }
        $this->assign('sellerList', $sellerList);
        //洗车人次
        $sellerTimesList = $seller
                ->where($where)
                ->field("ec_seller.*,round(6378.138*2*ASIN(SQRT(POW(SIN((" . $lng . "*PI()/180-substring_index(seller_location, ',', 1)*PI()/180)/2),2)+COS(" . $lng . "*PI()/180)*COS(substring_index(seller_location, ',', 1)*PI()/180)*POW(SIN((" . $lat . "*PI()/180-substring_index(seller_location, ',', -1)*PI()/180)/2),2))),1)as distance")
                ->order('clean_people desc')
                ->limit(2)
                ->select();
        foreach ($sellerTimesList as $key => $value) {
            $sellerTimesList[$key]['remark'] = explode(',', $value['remark']);
            $seller_location = explode(',', $value['seller_location']);
            $sellerTimesList[$key]['seller_location'] = $seller_location[1] . ',' . $seller_location[0];
        }
        $this->assign('sellerTimesList', $sellerTimesList);
        //离我最近
        $sellerDistanceList = $seller
                ->where($where)
                ->field("ec_seller.*,round(6378.138*2*ASIN(SQRT(POW(SIN((" . $lng . "*PI()/180-substring_index(seller_location, ',', 1)*PI()/180)/2),2)+COS(" . $lng . "*PI()/180)*COS(substring_index(seller_location, ',', 1)*PI()/180)*POW(SIN((" . $lat . "*PI()/180-substring_index(seller_location, ',', -1)*PI()/180)/2),2))),1)as distance")
                ->order('distance')
                ->limit(2)
                ->select();
        foreach ($sellerDistanceList as $key => $value) {
            $sellerDistanceList[$key]['remark'] = explode(',', $value['remark']);
            $seller_location = explode(',', $value['seller_location']);
            $sellerDistanceList[$key]['seller_location'] = $seller_location[1] . ',' . $seller_location[0];
        }
        $this->assign('sellerDistanceList', $sellerDistanceList);
        $this->assign("user_location", session("lat") . ',' . session("lng"));
        $this->display();
    }

    public function location() {
        $this->display();
    }

}
