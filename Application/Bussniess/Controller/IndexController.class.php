<?php

namespace Bussniess\Controller;

use Think\Controller;

class IndexController extends Controller {

    function __construct() {
        //继承父类
        parent::__construct();
		//判断登录状态
        if (!D('Seller')->islogin()) {//未登录
			jump('您尚未登录，请先登录！',C("WEB_URL")."index.php?m=Bussniess&c=login&a=login");
        }
    }
    //空方法，防止报错
    public function _empty() {
        $this->index();
    }
    //商家中心
    public function index() {
		$sellertel=C('sellertel');
		$seller_id = session("seller.seller_id");
		//实时查询当前商家个人信息
		$sellerinfo = M("Seller")->where("seller_id=".$seller_id)->field("*")->find();
		$this->assign('sellerinfo', $sellerinfo);
		$this->assign('sellertel', $sellertel);
    	$this->display();
		
    }
	//商家信息
    public function bussniessinfo() {
		$seller_id = session("seller.seller_id");
		//实时查询当前商家个人信息
		$sellerinfo = M("Seller")->where("seller_id=".$seller_id)->field("*")->find();
		$this->assign('sellerinfo', $sellerinfo);
    	$this->display();
    }
	//修改电话
    public function xgdh() {
		$seller_id = session("seller.seller_id");
		$sellerlinkphone = session("seller.sellerlinkphone");
		if(IS_POST){
			$info['modify_value']=I("sellerlinkphone");
			$info['seller_id']=$seller_id;
		    $info['modify_type']=2;                        
            $info['modify_flag']=1;                                                 
			M("sellermodify")->add($info);
			$this->redirect('index/bussniessinfo');
		}
		$this->assign('sellerlinkphone', $sellerlinkphone);
		$this->display();
    }
	//修改联系人
    public function xgllr() {
		$seller_id = session("seller.seller_id");
		$sellerlinkman = session("seller.sellerlinkman");
		if(IS_POST){
			$info['modify_value']=I("sellerlinkman");
			$info['seller_id']=$seller_id;
		    $info['modify_type']=1;                        
            $info['modify_flag']=1;                                                 
			M("sellermodify")->add($info);
			$this->redirect('index/bussniessinfo');
		}
		$this->assign('sellerlinkman', $sellerlinkman);
		$this->display();
    }	
    //消息通知
    public function message() {
	$seller_id = session("seller.seller_id");
	$count = M("Message")
		->where("msg_to='" . $seller_id . "' and msg_type=1")
		->field("*")
		->count();
	$Page = new \Think\Page($count, 10);
	//实时查询当前商家个人信息
	$messageinfo = M("Message")
		->where("msg_to='" . $seller_id . "' and msg_type=1")
		->field("*")
		->limit($Page->firstRow . ',' . $Page->listRows)
		->select();
	foreach ($messageinfo as $k=>$v){
	    $messageinfo[$k]['msg_addtime']=date('Y-m-d H:i:s',$v['msg_addtime']);
	}
	//加载更多
	if (IS_AJAX) {
	    if ($Page->totalPages >= $p) {
		$this->ajaxReturn(array('messageinfo' => $messageinfo));
	    } else {
		$this->ajaxReturn(array('messageinfo' => array()));
	    }
	}
	$this->assign('messageinfo', $messageinfo);
	$this->assign('count', $count);
	$this->display();
    }
	
	//消息详情
	public function messageinfo(){
		$msg_id=I("get.msg_id");
		$message=M("Message")->where("msg_id=".$msg_id)->find();
		$this->assign('message', $message);
		$this->display();
		
	}
	
	
}
