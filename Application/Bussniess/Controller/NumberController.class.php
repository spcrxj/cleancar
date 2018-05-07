<?php

namespace Bussniess\Controller;

use Think\Controller;

class NumberController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
    }


    //数据统计
    public function numcount() {
		$dealwith=session('seller.seller_id');
		//当日时间
		$t = time();
        $start = mktime(0,0,0,date("m",$t),date("d",$t),date("Y",$t));
        $end = mktime(23,59,59,date("m",$t),date("d",$t),date("Y",$t)); 
		//默认十天时间
		$start_m = date("Y-m-d ",$t);
        $end_m=date("Y-m-d ",strtotime("-10 days"));
		$daylist=$this->get_daylist($end_m,$start_m);
		$infolist=array();
		foreach($daylist as $k=>$v){
			$where=' ' ;
			$where.=" log_time>=".strtotime($v." 00:00:00")." ";
		    $where.="and log_time<=".strtotime($v." 23:59:59")."";
			$count =M('Clearlog')->where($where)->count('log_id');
			$infolist[$k]=array(
				'day'=>$v,
				'count'=>$count?$count:0,//人数
			);
				foreach($infolist as $k=>$value){
					$day[$k]=$value['day'];
					$counts[$k]=$value['count'];
				}
		  }
		  
		/* 会员人数 */
		$usernum=M('User')->where("dealwith=' ".$dealwith."' ")->count('user_id');//会员总数
		$usernum_day=M('User')->where(" dealwith='".$dealwith."' and addtime>='".$start."' and addtime<='".$end."'  " )->count('user_id');//当日新增会员
		
	    /*洗车记录统计 */
		//合计
		$xiche_sum=M('clearlog')->count('log_id');
        $xiche_sum=$xiche_sum?$xiche_sum:0;
		
		//当日
		$xiche_day=M('clearlog')->where(" log_time>='".$start."' and  log_time<='".$end."' " )->count('log_id');
        $xiche_day=$xiche_day?$xiche_day:0;
		
		//本周
        $ftime = mktime ( 0, 0, 0, date ( "m" ), date ( "d" ) - date ( "w" ) + 1, date ( "Y" ) );
        $ltime = mktime ( 23, 59, 59, date ( "m" ), date ( "d" ) - date ( "w" ) + 7, date ( "Y" ) );
		$xiche_week=M('clearlog')->where(" log_time>='".$ftime."' and  log_time<='".$ltime."' "  )->count('log_id');
        $xiche_week=$xiche_week?$xiche_week:0;

		//本月
		$year = date("Y");
	    $month = date("m");
	    $allday = date("t");
	    $mstart = strtotime($year."-".$month."-1");
	    $mend = strtotime($year."-".$month."-".$allday);
		$xiche_month=M('clearlog')->where(" log_time>='".$mstart."' and  log_time<='".$mend."' " )->count('log_id');
        $xiche_month=$xiche_month?$xiche_month:0;
		
		/*佣金数据统计 */
		//累计佣金
		$backmoney=C('backmoney');//返佣金额
		$leijiyongjin=M('clearlog')->where("seller_id='".$dealwith."'  ")->count('log_id');
		$yongjin=$leijiyongjin*$backmoney;//合计佣金
		$nojiyongjin=M('clearlog')->where("seller_id='".$dealwith."' and log_backmoney=1 ")->count('log_id');
		$noyongjin=$nojiyongjin*$backmoney;//未发放佣金
		//echo $noyongjin;
		$yesjiyongjin=M('clearlog')->where("seller_id='".$dealwith."' and log_backmoney=2 ")->count('log_id');
		$yesyongjin=$yesjiyongjin*$backmoney;//已发放佣金
		//echo $yesyongjin;
		
		$this->assign('day',json_encode($day));
		$this->assign('counts',json_encode($counts)); 
		$this->assign('xiche_sum',$xiche_sum);//合计
		$this->assign('xiche_day',$xiche_day);//当天
		$this->assign('xiche_week',$xiche_week);//本周
		$this->assign('xiche_month',$xiche_month);//本月
		$this->assign('usernum_day',$usernum_day);//当日新增会员
		$this->assign('usernum',$usernum);//总会员人数
		$this->assign('yongjin',$yongjin);//合计佣金
		$this->assign('noyongjin',$noyongjin);//未发放佣金
		$this->assign('yesyongjin',$yesyongjin);//已发放佣金
		$this->display();
    } 
	//申请发放佣金
	 public function tixian() {
		$seller_id=session('seller.seller_id');
		$time=SYS_TIME;
		//查询商户余额
		$yue=M('Seller')->where('seller_id='.$seller_id )->field('money')->find();
		if(floatval($yue['money'])>100){
			//扣除余额
			M('Seller')->where('seller_id='.$seller_id )->setDec('money',floatval($yue['money']));
			//添加提现记录
		    M('Popinfo')->add(array('seller_id'=>$seller_id,'seller_money'=>floatval($yue['money']),'pop_flag'=>1,'pop_addtime'=>$time));
			jump("申请成功，等待审核 ",U("number/numcount"));
		}else{
			jump("您的账户余额不足100元，申请失败 ",U("number/numcount"));
		} 
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
