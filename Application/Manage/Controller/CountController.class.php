<?php
namespace Manage\Controller;

use Think\Controller;

class CountController extends Controller {


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
	
	//店铺统计
	public function shop(){
		$where = " 1  ";
		$adminid = session('admin.admin_id'); 
	    $info=I("info");		
		if ($info){
			@extract($info);
			if($start){
				$this->assign('start',$start);
			}
			if($end){
				$this->assign('end',$end);
			}  
		}
		if(!$start){
			$start=date("Y-m-d",strtotime("-1 month"));
			$this->assign('start',$start);
		}
		if(!$end){
			$end=date("Y-m-d",SYS_TIME);
			$this->assign('end',$end);
		}
		
		$seller = M('seller');
		$daylist=$this->get_daylist($start,$end);
		$daylist=array_reverse($daylist);
		$sellerlist=array();
		
        foreach($daylist as $k=>$v){
			$where_=$where;
			$where_.=" and ec_seller.seller_addtime>=".strtotime($v." 00:00:00")." ";
			$where_.=" and ec_seller.seller_addtime<=".strtotime($v." 23:59:59")." ";

			$num = $seller->where($where_)->select();
			$sum=sizeof($num);
			$sellerlist[$k] = array(
				'day'=>$v,
				'sum'=>$sum?$sum:0,
			);
		}
        $this->assign('sellerlist', $sellerlist);
        $this->display();
    }
	
	//会员统计
	public function vip(){
		$where = " 1  ";
		$adminid = session('admin.admin_id'); 
	    $info=I("info");		
		if ($info){
			@extract($info);
			if($start){
				$this->assign('start',$start);
			}
			if($end){
				$this->assign('end',$end);
			}  
		}
		if(!$start){
			$start=date("Y-m-d",strtotime("-1 month"));
			$this->assign('start',$start);
		}
		if(!$end){
			$end=date("Y-m-d",SYS_TIME);
			$this->assign('end',$end);
		}
		
		$vip = M('user');
		$daylist=$this->get_daylist($start,$end);
		$daylist=array_reverse($daylist);
		$userlist=array();
		
        foreach($daylist as $k=>$v){
			$where_=$where;
			$where_.=" and ec_user.addtime>=".strtotime($v." 00:00:00")." ";
			$where_.=" and ec_user.addtime<=".strtotime($v." 23:59:59")." ";
			//. " and ec_user.addtime>=".strtotime($todaydate." 00:00:00")."  and ec_user.addtime<=".strtotime($todaydate." 23:59:59")." "
			$num = $vip->where($where_)->select();
			$sum=sizeof($num);
			$userlist[$k] = array(
				'day'=>$v,
				'sum'=>$sum?$sum:0,
			);
		}
        $this->assign('userlist', $userlist);
        $this->display();
    }
	
	
	//消费统计
    public function seller(){
		$where = " 1  ";
		$adminid = session('admin.admin_id'); 
	    $info=I("info");		
		if ($info){
			@extract($info);
			if($start){
				$this->assign('start',$start);
			}
			if($end){
				$this->assign('end',$end);
			}  
		}
		if(!$start){
			$start=date("Y-m-d",strtotime("-1 month"));
			$this->assign('start',$start);
		}
		if(!$end){
			$end=date("Y-m-d",SYS_TIME);
			$this->assign('end',$end);
		}
		
		//按商家名称搜索
		if($sellername){
			$info['sellername']=urldecode($info['sellername']);
			$where.=" and (ec_seller.sellername like '%".urldecode($info['sellername'])."%') ";
			$this->assign('sellername',urldecode($info['sellername']));
		}
		
		$clearlog = M('clearlog');
		$daylist=$this->get_daylist($start,$end);
		$daylist=array_reverse($daylist);
		$clearloglist=array();
		
        foreach($daylist as $k=>$v){
			$where_=$where;
			$where_.=" and ec_clearlog.log_time>=".strtotime($v." 00:00:00")." ";
			$where_.=" and ec_clearlog.log_time<=".strtotime($v." 23:59:59")." ";
			$num = $clearlog->where($where_)->join('left join ec_seller on ec_clearlog.seller_id=ec_seller.seller_id')->select();
			$sum=sizeof($num);
			$clearloglist[$k] = array(
				'day'=>$v,
				'sum'=>$sum?$sum:0,
			);
		}
        $this->assign('clearloglist', $clearloglist);
        $this->display();
    }
	
	//缴费统计
    public function pay(){
		$where = " 1  ";
		$adminid = session('admin.admin_id'); 
	    $info=I("info");		
		if ($info){
			@extract($info);
			if($start){
				$this->assign('start',$start);
			}
			if($end){
				$this->assign('end',$end);
			}  
		}
		if(!$start){
			$start=date("Y-m-d",strtotime("-1 month"));
			$this->assign('start',$start);
		}
		if(!$end){
			$end=date("Y-m-d",SYS_TIME);
			$this->assign('end',$end);
		}
		
		//按会员电话搜索
		if($phone){
			$info['phone']=urldecode($info['phone']);
			$where.=" and (ec_user.phone =".urldecode($info['phone']).") ";
			$this->assign('phone',urldecode($info['phone']));
		}
		
		$payinfo = M('payinfo');
		$daylist=$this->get_daylist($start,$end);
		$daylist=array_reverse($daylist);
		$payinfolist=array();
		
        foreach($daylist as $k=>$v){
			$where_=$where;
			$where_.=" and ec_payinfo.pay_addtime>=".strtotime($v." 00:00:00")." ";
			$where_.=" and ec_payinfo.pay_addtime<=".strtotime($v." 23:59:59")." ";
			$sum = $payinfo->where($where_. "and ec_payinfo.pay_flag=2")->join('left join ec_user on ec_payinfo.user_id=ec_user.user_id')->sum('ec_payinfo.pay_money');
			
			$payinfolist[$k] = array(
				'day'=>$v,
				'sum'=>$sum?$sum:0,
			);
		}
        $this->assign('payinfolist', $payinfolist);
        $this->display();
    }
	
	//财务消费统计
    public function cwseller(){
		$where = " 1  ";
		$adminid = session('admin.admin_id'); 
	    $info=I("info");		
		if ($info){
			@extract($info);
			if($start){
				$info['start']=urldecode(trim($info['start']));
                $where.=" and ec_clearlog.log_time  >= ".urldecode(strtotime($info['start']." 00:00:00"))." ";
				$this->assign('start',urldecode($info['start']));
            }
			if($end){
				$info['end']=urldecode(trim($info['end']));
                $where.=" and ec_clearlog.log_time  <= ".urldecode(strtotime($info['end']." 23:59:59"))." "; 
                $this->assign('end',urldecode($info['end']));	
            }
			//按商家名称搜索
			if($sellername){
				$info['sellername']=urldecode($info['sellername']);
				$where.=" and (ec_seller.sellername like '%".urldecode($info['sellername'])."%') ";
				$this->assign('sellername',urldecode($info['sellername']));
			}
		}
		
		$clearlog=M('clearlog')
			->where($where)
			->join('left join ec_seller on ec_clearlog.seller_id=ec_seller.seller_id')
			->group('ec_clearlog.seller_id')
			->select();
		$backmoney=C('backmoney');
		foreach ($clearlog as $k=>$v){
			//总的洗车次数
			$count=M('clearlog')
				->where($where. " and ec_clearlog.seller_id='".$v['seller_id']."'")
				->join('left join ec_seller on ec_clearlog.seller_id=ec_seller.seller_id')
				->count();
			$clearlog[$k]['count']=$count?$count:0;
			//已结算次数
			$jiesuannum=M('clearlog')
				->where($where. " and ec_clearlog.seller_id='".$v['seller_id']."' and ec_clearlog.log_backmoney=2")
				->join('left join ec_seller on ec_clearlog.seller_id=ec_seller.seller_id')
				->count();
			$clearlog[$k]['jiesuannum']=$jiesuannum?$jiesuannum:0;
			//结算返现金额
			$jiesuanmoney=$backmoney*$clearlog[$k]['jiesuannum'];
			$clearlog[$k]['jiesuanmoney']=$jiesuanmoney?$jiesuanmoney:0;
			//未结算次数
			$nojiesuannum=M('clearlog')
				->where($where. " and ec_clearlog.seller_id='".$v['seller_id']."' and ec_clearlog.log_backmoney=1")
				->join('left join ec_seller on ec_clearlog.seller_id=ec_seller.seller_id')
				->count();
			$clearlog[$k]['nojiesuannum']=$nojiesuannum?$nojiesuannum:0;	
			//未返现金额	
			$nojiesuanmoney=$backmoney*$clearlog[$k]['nojiesuannum'];
			$clearlog[$k]['nojiesuanmoney']=$nojiesuanmoney?$nojiesuanmoney:0;	
		}
		$this->assign('clearlog', $clearlog);
        $this->display();
    }
	
	//财务缴费统计
	public function cwpay(){
		$where = " 1  ";
		$adminid = session('admin.admin_id'); 
	    $info=I("info");		
		if ($info){
			@extract($info);
			if($start){
				$info['start']=urldecode(trim($info['start']));
                $where.=" and ec_payinfo.pay_addtime  >= ".urldecode(strtotime($info['start']." 00:00:00"))." ";
				$this->assign('start',urldecode($info['start']));
            }
			if($end){
				$info['end']=urldecode(trim($info['end']));
                $where.=" and ec_payinfo.pay_addtime  <= ".urldecode(strtotime($info['end']." 23:59:59"))." "; 
                $this->assign('end',urldecode($info['end']));	
            }
			//按会员电话搜索
			if($phone){
				$info['phone']=urldecode($info['phone']);
				$where.=" and (ec_user.phone=".urldecode($info['phone']).") ";
				$this->assign('phone',urldecode($info['phone']));
			} 
		}
		
		$count=M('payinfo')
			//->where($where. "and ec_payinfo.pay_flag=2")
			->where($where. "and ec_payinfo.pay_flag=2")
			->join('left join ec_user on ec_payinfo.user_id=ec_user.user_id')
			->group('ec_payinfo.user_id')
			->count();
		//合计
		$total=M('payinfo')
			->where($where. "and ec_payinfo.pay_flag=2")
			->join('left join ec_user on ec_payinfo.user_id=ec_user.user_id')
			->sum('ec_payinfo.pay_money');    
		$payinfo=M('payinfo')
			->where($where. "and ec_payinfo.pay_flag=2")
			->join('left join ec_user on ec_payinfo.user_id=ec_user.user_id')
			->group('ec_payinfo.user_id')
			->select();
		foreach($payinfo as $k=>$v){
			$money=M('payinfo')
				->join('left join ec_user on ec_payinfo.user_id=ec_user.user_id')
				->where($where." and ec_payinfo.user_id='".$v['user_id']."' and ec_payinfo.pay_flag=2")
				->sum('ec_payinfo.pay_money');
			$payinfo[$k]['money']=$money?$money:0;	
		}	
		
		$this->assign('payinfo', $payinfo);
		$this->assign('count', $count);
		$this->assign('total', $total);
		$this->display();
	} 
	
	//财务提现统计
	public function cwpopinfo(){
		$where = " 1  ";
		$adminid = session('admin.admin_id'); 
	    $info=I("info");		
		if ($info){
			@extract($info);
			if($start){
				$info['start']=urldecode(trim($info['start']));
                $where.=" and ec_popinfo.pop_addtime  >= ".urldecode(strtotime($info['start']." 00:00:00"))." ";
				$this->assign('start',urldecode($info['start']));
            }
			if($end){
				$info['end']=urldecode(trim($info['end']));
                $where.=" and ec_popinfo.pop_addtime  <= ".urldecode(strtotime($info['end']." 23:59:59"))." "; 
                $this->assign('end',urldecode($info['end']));	
            }
			//按商家名称搜索
			if($sellername){
				$info['sellername']=urldecode($info['sellername']);
				$where.=" and (ec_seller.sellername like '%".urldecode($info['sellername'])."%') ";
				$this->assign('sellername',urldecode($info['sellername']));
			} 
		}
		$count=M('popinfo')
			->where($where. "and ec_popinfo.pop_flag=2")
			->join('left join ec_seller on ec_popinfo.seller_id=ec_seller.seller_id')
			->group('ec_popinfo.seller_id')
			->count();
		//合计
		$total=M('popinfo')
			->where($where. "and ec_popinfo.pop_flag=2")
			->join('left join ec_seller on ec_popinfo.seller_id=ec_seller.seller_id')
			->sum('ec_popinfo.seller_money'); 
		
		$popinfo=M('popinfo')
			->where($where. "and ec_popinfo.pop_flag=2")
			->join('left join ec_seller on ec_popinfo.seller_id=ec_seller.seller_id')
			->group('ec_popinfo.seller_id')
			->select();
		foreach($popinfo as $k=>$v){
			$money=M('popinfo')
				->join('left join ec_seller on ec_popinfo.seller_id=ec_seller.seller_id')
				->where($where." and ec_popinfo.seller_id='".$v['seller_id']."' and ec_popinfo.pop_flag=2")
				->sum('ec_popinfo.seller_money');
			$popinfo[$k]['money']=$money?$money:0;	
		}	
		$this->assign('count', $count);
		$this->assign('total', $total);
		$this->assign('popinfo', $popinfo);
		$this->display();
	} 
	//获取两个日期段内所有日期
	public function get_daylist($startdate,$enddate){
		$stimestamp = strtotime($startdate);
		$etimestamp = strtotime($enddate);
		// 计算日期段内有多少天
		$days = ($etimestamp-$stimestamp)/86400+1;
		// 保存每天日期
		$date = array();
		for($i=0; $i<$days; $i++){
			$date[] = date('Y-m-d', $stimestamp+(86400*$i));
		}
		return $date;
	}

}