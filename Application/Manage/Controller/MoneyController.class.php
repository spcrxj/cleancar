<?php

namespace Manage\Controller;

use Think\Controller;

class MoneyController extends Controller {

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

    //我的消费明细
    public function xiaofei() { 
        $where=" 1";
        $info=I("info"); 
        if ($info){
            @extract($info);
			//按用户名和电话搜索
            if($realname){
                $info['realname']=urldecode(trim($info['realname']));
				$where.= " and (a.realname like '%".urldecode($info['realname'])."%' or a.phone like '%".urldecode($info['realname'])."%') ";
                $this->assign('realname',urldecode($info['realname']));
            } 
			//会员车牌号
            if($carcode){
                $info['carcode']=urldecode(trim($info['carcode']));
				$where.=" and a.carcode like '%".urldecode($info['carcode'])."%' ";
                $this->assign('carcode',urldecode($info['carcode']));
            }
            //是否确定 
            if($is_checked){
                $info['is_checked']=urldecode(trim($info['is_checked']));
				$where.=" and is_checked = '".urldecode($info['is_checked'])."' ";
                $this->assign('ischecked',urldecode($info['is_checked']));
            } 
			//按时间查询
			if($starttime){
				$info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_clearlog.log_time  >= ".urldecode(strtotime($info['starttime']))." ";
				$this->assign('starttime',urldecode($info['starttime']));
            }
			if($endtime){
				$info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_clearlog.log_time  <= ".urldecode(strtotime($info['endtime']))." ";
                $this->assign('endtime',urldecode($info['endtime']));	
            }
		}  
        $model = M('Clearlog'); 
		// 查询满足要求的总记录数
        $count = $model->where($where)
                ->join('left join ec_user as a on a.user_id=ec_clearlog.user_id')
                ->join('left join ec_seller as b on b.seller_id=ec_clearlog.seller_id')
                ->field('ec_clearlog.*,a.realname,a.phone,a.carcode,b.sellername')
                ->order('ec_clearlog.log_id desc')
                ->count();
        $pagesize=I('pagesize')?I('pagesize'):15;	
		$Page = new \Think\Page($count,$pagesize);
		//分页跳转的时候保证查询条件
        if($info){
            foreach($info as $key=>$val) {
                $Page->parameter['info['.$key.']']   =   urlencode($val);
            }
        }
        $Page->parameter['pagesize']   =   $pagesize;
        $pageshow  = $Page->manageshow();		
		
		//导出excel表格
		//dump(I("flag"));
		if(I("flag")=="wdfanxianmingxifile"){ 	
			 $incomelist = $model
                ->where($where)
                ->join('left join ec_user as a on a.user_id=ec_clearlog.user_id ')
                ->field('ec_clearlog.*,a.realname,a.carcode')
                ->order('ec_clearlog.log_id desc')
                ->select();
		    header("Content-type:application/vnd.ms-excel");
			header("Content-Disposition:attachment;filename=我的返现明细".date("Y-m-d",SYS_TIME).".xls");
			$this->assign('incomelist',$incomelist);
			$this->assign('popflag', D("Popinfo")->get_income()); //是否返现
			$this->display("managesalemoneyfile");
		} 
		// 进行分页数据查询
        $incomelist = $model
                ->where($where)
                ->join('left join ec_user as a on a.user_id=ec_clearlog.user_id')
                ->join('left join ec_seller as b on b.seller_id=ec_clearlog.seller_id')
                ->field('ec_clearlog.*,a.realname,a.phone,a.carcode,b.sellername')
                ->order('ec_clearlog.log_id desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();
        foreach ($incomelist as $k => $v) {
        	if($v['log_backmoney']==1){
        		$incomelist[$k]['log_backmoney']='<span style="color:red;">未结算</span>';
        	}else if($v['log_backmoney']==2){
        		$incomelist[$k]['log_backmoney']='<span style="color:green;">已结算</span>';
        	} 
        } 
        $this->assign('outxlspsw', session('user.outxlspsw'));		
        $this->assign('incomelist', $incomelist);  
        $this->assign('pageshow', $pageshow);
        $this->assign('is_checked', D('Clearlog')->is_checked());
        $this->display();
    }
    //全部结算
    public function xfquanbjies() {
    	$backmoney=C('backmoney');
    	//结算
        //商家返佣
        $sellerinfo=M('Clearlog')->where('log_backmoney=1')->select();
        if($sellerinfo){
	        foreach($sellerinfo as $key=>$val){
	 			$seller_money=M('Seller')->where('seller_id='.$val['seller_id'] )->setInc('money',$backmoney);
	 			$clearlog=M('Clearlog')->where('seller_id='.$val['seller_id'] )->save(array('log_backmoney'=>2));
	        }
    		jump('结算成功！', U('money/xiaofei'));
    	}else{
    		jump('无未结算的账单！', U('money/xiaofei'));
    	}
    }

    //我的缴费明细
    public function jiaofei() {  
        $where=" 1";
        $info=I("info"); 
        if ($info){
            @extract($info);
			//按用户名和电话搜索
            if($realname){
                $info['realname']=urldecode(trim($info['realname']));
				$where.= " and a.realname like '%".urldecode($info['realname'])."%' ";
                $this->assign('realname',urldecode($info['realname']));
            }
			//会员车牌号
            if($carcode){
                $info['carcode']=urldecode(trim($info['carcode']));
				$where.=" and a.carcode like '%".urldecode($info['carcode'])."%' ";
                $this->assign('carcode',urldecode($info['carcode']));
            }
			//按时间查询
			if($starttime){
				$info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_payinfo.pay_addtime  >= ".urldecode(strtotime($info['starttime']))." ";
				$this->assign('starttime',urldecode($info['starttime']));
            }
			if($endtime){
				$info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_payinfo.pay_addtime  <= ".urldecode(strtotime($info['endtime']))." ";
                $this->assign('endtime',urldecode($info['endtime']));	
            }
		} 
        $model = M('Payinfo'); 
		// 查询满足要求的总记录数
        $count = $model->where($where)
                ->join('left join ec_user as a on a.user_id=ec_payinfo.user_id') 
                ->field('ec_payinfo.*,a.realname,a.phone,a.carcode')
                ->order('ec_payinfo.pay_id desc')
                ->count();
        $pagesize=I('pagesize')?I('pagesize'):15;	
		$Page = new \Think\Page($count,$pagesize);
		//分页跳转的时候保证查询条件
        if($info){
            foreach($info as $key=>$val) {
                $Page->parameter['info['.$key.']']   =   urlencode($val);
            }
        }
        $Page->parameter['pagesize']   =   $pagesize;
        $pageshow  = $Page->manageshow();		
		
		//导出excel表格
		//dump(I("flag"));
		if(I("flag")=="wdfanxianmingxifile"){ 	
			 $incomelist = $model
                ->where($where)
                ->join('left join ec_user as a on a.user_id=ec_clearlog.user_id ')
                ->field('ec_clearlog.*,a.realname,a.carcode')
                ->order('ec_clearlog.log_id desc')
                ->select();
		    header("Content-type:application/vnd.ms-excel");
			header("Content-Disposition:attachment;filename=我的返现明细".date("Y-m-d",SYS_TIME).".xls");
			$this->assign('incomelist',$incomelist);
			$this->assign('popflag', D("Popinfo")->get_income()); //是否返现
			$this->display("managesalemoneyfile");
		} 
		// 进行分页数据查询
        $incomelist = $model
                ->where($where)
               ->join('left join ec_user as a on a.user_id=ec_payinfo.user_id') 
                ->field('ec_payinfo.*,a.realname,a.phone,a.carcode')
                ->order('ec_payinfo.pay_id desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();   
        $this->assign('outxlspsw', session('user.outxlspsw'));		
        $this->assign('incomelist', $incomelist); 
        $this->assign('paytype', D('Payinfo')->paytype()); 
        $this->assign('payflag', D('Payinfo')->payflag());
        $this->assign('pageshow', $pageshow);
        $this->display();
    }

}
