<?php

namespace Manage\Controller;

use Think\Controller;

class SbeiglController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct(); 
		//判断登录状态
        if (!D('Admin')->islogin()) {//未登录
            jump('您尚未登录，请先登录！', U('login/login'));
        }
    }

    //设备管理
    public function shebeigl() { 
    	$where=" 1";
        $info=I("info"); 
        if ($info){
            @extract($info);
			//商家名称
            if($sellername){
                $info['sellername']=urldecode(trim($info['sellername'])); 
				$where.= " and a.sellername like '%".urldecode($info['sellername'])."%' ";
                $this->assign('sellername',urldecode($info['sellername']));
            }
			//设备名称
            if($device_name){
                $info['device_name']=urldecode(trim($info['device_name']));
				$where.=" and ec_device.device_name like '%".urldecode($info['device_name'])."%' ";
                $this->assign('device_name',urldecode($info['device_name']));
            }
			//按时间查询
			if($starttime){
				$info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_device.device_addtime  >= ".urldecode(strtotime($info['starttime']))." ";
				$this->assign('starttime',urldecode($info['starttime']));
            }
			if($endtime){
				$info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_device.device_addtime  <= ".urldecode(strtotime($info['endtime']))." ";
                $this->assign('endtime',urldecode($info['endtime']));	
            }
		} 
        $model = M('Device'); 
		// 查询满足要求的总记录数
        $count = $model->where($where)
                ->join('left join ec_seller as a on a.seller_id=ec_device.seller_id') 
                ->field('ec_device.*,a.sellername,a.sellerlinkman,a.sellerlinkphone')
                ->order('ec_device.device_id desc')
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
                ->join('left join ec_seller as a on a.seller_id=ec_device.seller_id') 
                ->field('ec_device.*,a.sellername,a.sellerlinkman,a.sellerlinkphone')
                ->order('ec_device.device_id desc')
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
                ->join('left join ec_seller as a on a.seller_id=ec_device.seller_id') 
                ->field('ec_device.*,a.sellername,a.sellerlinkman,a.sellerlinkphone')
                ->order('ec_device.device_id desc')
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();  
      
        $this->assign('outxlspsw', session('user.outxlspsw'));		
        $this->assign('incomelist', $incomelist);
		
        $this->assign('deviceflag', D('Device')->deviceflag());    
        $this->assign('pageshow', $pageshow);
        $this->display();
    } 
    //修改设备状态
	public function device(){
		$device_id=I("get.device_id");
		$incomelist = M('Device')
                ->where('device_id='.$device_id) 
                ->find();
        if($incomelist['device_flag']==1){
        	$info['device_flag']=2;
        }else{
        	$info['device_flag']=1;
        }
		M('device')->where('device_id='.$device_id)->save($info);
		jump('设备状态修改成功！', U('sbeigl/shebeigl'));
	}
	//商家设备增加
	public function shebeigladd(){
		//当前所有店铺信息
		$sellerinfo = M("Seller")
						->field('ec_seller.seller_id,ec_seller.sellername')
						->select(); 
		$this->assign('deviceflag',D('Device')->deviceflag()); 
		$this->assign('sellerinfo', $sellerinfo);
		if(IS_POST){ 
				$data['seller_id']=I("seller_id");
				$data['device_name']=I("device_name");
				$data['device_content']=I("device_content");
				$data['device_flag']=I("device_flag");
				$data['device_addtime']=SYS_TIME;
				$data['device_sim']=I("device_sim");	
				$flag=M('Device')->add($data);
			    if($flag){
					jump("添加设备成功！",U("sbeigl/shebeigl"));
				}else{
					jump("添加设备失败！",U("sbeigl/shebeigl"));
				}	
		}else{
			$this->display();
		}
	}
	//商家设备修改
	public function shebeigledit(){
		//当前所有店铺信息
		$sellerinfo = M("Seller")
						->field('ec_seller.seller_id,ec_seller.sellername')
						->select();
		$this->assign('deviceflag',D('Device')->deviceflag()); 
		$this->assign('sellerinfo', $sellerinfo);
		//当前所选设备
		$device_id=I("device_id");
		session('device_id',$device_id);
		$device_id=session('device_id'); 
		$deviceinfo = M("Device")
					->where('device_id='.$device_id)
					->join('left join ec_seller as a on a.seller_id=ec_device.seller_id')
                	->field('ec_device.*,a.sellername')
					->find(); 
		$this->assign('deviceinfo', $deviceinfo);
		if(IS_POST){ 
				$device_id=session('device_id');
				$data['seller_id']=I("seller_id");
				$data['device_name']=I("device_name");
				$data['device_content']=I("device_content");
				$data['device_flag']=I("device_flag");
				$data['device_addtime']=SYS_TIME;
				$data['device_sim']=I("device_sim"); 
				$flag=M('Device')->where('device_id='.$device_id)->save($data);
			    if($flag){
					jump("修改设备信息成功！",U("sbeigl/shebeigl"));
				}else{
					jump("修改设备信息失败！",U("sbeigl/shebeigl"));
				}	
		}else{
			$this->display();
		}
	}

	//商家设备修改
	public function shebeigldele(){
		//当前所选设备
		$device_id=I("device_id");
		$devicedele = M("Device")
					->where('device_id='.$device_id)
					->delete(); 
	    if($devicedele){
			jump("删除设备信息成功！",U("sbeigl/shebeigl"));
		}else{
			jump("删除设备信息失败！",U("sbeigl/shebeigl"));
		}	
	}


	//商家json输出
	public function jsonseller(){
		$query=trim(I("query"));
		$seller=M("seller")->where("username like '%".$query."%' or sellername like '%".$query."%'")->limit(10)->select();
		$info=array();
		foreach($seller as $k=>$v){
			$info[]=array("value"=>$v['seller_id'],"label"=>$v['sellername']);
		}
		echo json_encode($info);
		exit();
	}
}
