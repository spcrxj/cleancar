<?php

namespace Bussniess\Controller;

use Think\Controller;

class RecordController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
		if (!D('Seller')->islogin()) {//未登录
			jump('您尚未登录，请先登录！',C("WEB_URL")."index.php?m=Bussniess&c=login&a=login");
        }
    }
    //洗车记录
    public function index(){
		$seller_id = session("seller.seller_id");
		$sellername = session("seller.sellername");
		$where=" 1 ";
		$log_time = I('get.log_time');
		//按时间查询记录
		if($log_time){
		   $where.=" and  ec_clearlog.log_time >=".strtotime($log_time." 00:00:00")." " ;
		   $where.=" and  ec_clearlog.log_time <=".strtotime($log_time." 23:59:59")." " ;
		}
		
		//按车牌号查询记录
		$carcode = I('get.carcode');
		if($carcode){
		   $where.=" and  a.carcode = '".$carcode."'" ;
		}
		//按结算状态查询记录
		$log_backmoney = I('get.log_backmoney');
		if($log_backmoney){
		   $where.=" and  ec_clearlog.log_backmoney=".$log_backmoney ;
		}
		$where.=" and ec_clearlog.seller_id=".$seller_id ;
		
		$count = M("Clearlog")
				->where($where)
				->join('left join ec_user as a on a.user_id=ec_clearlog.user_id')
				->field("ec_clearlog.*,a.carcode")
				->count();
		$Page   = new \Think\Page($count,10);
		//查询当前商家体系下的洗车记录
		$cleaninfo=M("Clearlog")
				->where($where)
				->join('left join ec_user as a on a.user_id=ec_clearlog.user_id')
				->field("ec_clearlog.*,a.carcode")
				->limit($Page->firstRow . ',' . $Page->listRows)
				->order('ec_clearlog.log_id desc')
				->select(); 
		foreach($cleaninfo as $k=>$v){
			$cleaninfo[$k]['log_time']=date('Y-m-d H:i:s',$v['log_time']);
			$cleaninfo[$k]['sellername']=$sellername;
		}
		//加载更多
		if(IS_AJAX){
				if($Page->totalPages>=$p){
					  $this->ajaxReturn(array('cleaninfo'=>$cleaninfo));
				  }else{
					  $this->ajaxReturn(array('cleaninfo'=>array()));
				  }
		}
		$this->assign('log_time', $log_time);
		$this->assign('carcode', $carcode);
		$this->assign('log_backmoney', $log_backmoney);
		$this->assign('cleaninfo', $cleaninfo);
		$this->assign('log_backmoneys', D('Clearlog')->log_backmoney());
		$this->display();
	}
}
