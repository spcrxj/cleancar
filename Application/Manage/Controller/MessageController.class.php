<?php
namespace Manage\Controller;
use Think\Controller;
class MessageController extends Controller {
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
		$this->assign('admin_id', $admin_id);
		$model = M('Message');
		
		$msg_title=I('msg_title');
		$msg_type=I('msg_type');
		if($msg_title){
			$where['msg_title']  = array('like', '%'.urldecode($msg_title).'%');
			$this->assign('msg_title',urldecode($msg_title));
		}
		if($msg_type){	
			$where['msg_type']  = array('eq', intval($msg_type));
			$this->assign('msg_type',$msg_type);
		}
		
		if($msg_title || $msg_type){			
			$count = $model->where($where)->count();
			$pagesize=I('pagesize')?I('pagesize'):15;
			$Page= new \Think\Page($count,$pagesize);
			$Page->parameter['msg_title']   =   urlencode(urldecode($msg_title));
			$Page->parameter['msg_type']   =   urlencode($msg_type);
			$Page->parameter['pagesize']   =   $pagesize;
        	$pageshow   = $Page->manageshow();
			$contentinfo=$model->where($where)->order(array('msg_id'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->select();
		}else{
			$count = $model->count();
			$pagesize=I('pagesize')?I('pagesize'):15;
			$Page= new \Think\Page($count,$pagesize);
			$Page->parameter['pagesize']   =   $pagesize;
			$pageshow   = $Page->manageshow();
			$contentinfo=$model->order(array('msg_id'=>'desc'))->limit($Page->firstRow.','.$Page->listRows)->select();
		}
		
		$this->assign('contentinfo', $contentinfo);		
		$this->assign('pageshow',$pageshow);
        $this->display();
    }
   

    //欢迎页
    public function add() {
		$admin_id = session("admin.admin_id");
		$this->assign('admin_id', $admin_id);
		/*用户id*/
		
		
		/*商家id*/
		
		$this->display();
    }
	public function messclass(){
		$messclass=$_POST['id'];
		switch($messclass){
			case 0:
				echo $messclass;	
				break;
			case 1: 	//1位商家
				$model = M('Seller');
				$result=$model->field('seller_id,sellername')->select();	
				//echo $result;
				echo json_encode($result);
				break;
			case 2:	//2为用户
				$model = M('User');
				$user=$model->field('user_id,realname')->select();	
				echo json_encode($user);
				//echo $user;
				break;
		}
	}
	/*添加信息*/
    public function addMessage() {
		/*$admin_id = session("admin.admin_id");
		$this->assign('admin_id', $admin_id);
		*/
			$data['msg_title']=$_POST['msg_title'];
			$data['msg_type']=$_POST['msg_type'];		
			$data['msg_to']=$_POST['msg_to'];	
			$data['msg_content']=$_POST['msg_content'];	
			$data['msg_addtime']=time();
			$data['is_read']=0;	
			$model = M('Message');
			if($model->add($data)) {
					$this->success('消息添加成功!',U('Message/index'));
				}else{
					$this->error('消息添加失败!',U('Message/add'));
			}
		
    }

	 public function edit() {
		if($_GET['editid']){
			$id=$_GET['editid'];
			$model = M('Message');
			$result=$model->where('msg_id='.$id)->select();	
			$msg_type=$result[0]['msg_type'];
			$msg_to=$result[0]['msg_to'];//判断商家
			switch($msg_type){  			
			case 1: 	//1为商家
				$model = M('Seller');
				$res=$model->field('seller_id,sellername')->where('seller_id='.$msg_to)->select();			
				break;
			case 2:	//2为用户
				$model = M('User');
				$res2=$model->field('user_id,realname')->where('user_id='.$msg_to)->select();		
				break;
		}
			$this->assign('res', $res);		
			$this->assign('res2', $res2);					
			$this->assign('result', $result);
			/*
			if($del) {
				$this->success('删除成功!',U('Photo/index'));
			}else{
				$this->error('删除失败!',U('Photo/index'));
			}*/
		}
		 $this->display();
		
		$admin_id = session("admin.admin_id");
		$this->assign('admin_id', $admin_id);
		
		
    }
    public function editMessage() {
		
		$id=$_POST['msg_id'];
		$data['msg_title']=$_POST['msg_title'];
		$data['msg_type']=$_POST['msg_type'];		
		$data['msg_to']=$_POST['msg_to'];	
		$data['msg_content']=$_POST['msg_content'];	
		$data['msg_addtime']=time();	
		$model = M('Message');
		$model->where('msg_id='.$id)->save($data);
		$this->success('信息修改成功!',U('Message/index'));
    }
  //欢迎页
    public function del() {
		if($_GET['delid']){
			$id=$_GET['delid'];
			$model =  M('Message');
			$del=$model->where('msg_id='.$id)->delete();
			if($del) {
				$this->success('删除成功!',U('Message/index'));
			}else{
				$this->error('删除失败!',U('Message/index'));
		}
		}
		
		$admin_id = session("admin.admin_id");
		$this->assign('admin_id', $admin_id);
		
		
    }


}
