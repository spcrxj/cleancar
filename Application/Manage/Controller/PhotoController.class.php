<?php

namespace Manage\Controller;

use Think\Controller;
class PhotoController extends Controller {

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
		$model = M('Focus');
		$msg_title=I('focus_title');
		$where['focus_title']  = array('like', '%'.urldecode($msg_title).'%');
		$this->assign('msg_title',urldecode($msg_title));
		if($msg_title ){			
			$count = $model->where($where)->count();
			$pagesize=I('pagesize')?I('pagesize'):15;
			$Page= new \Think\Page($count,$pagesize);
			$Page->parameter['focus_title']   =   urlencode(urldecode($msg_title));
			$Page->parameter['pagesize']   =   $pagesize;
        	$pageshow   = $Page->manageshow();
			$contentinfo=$model->where($where)->order(array('focus_sort','focus_id'=>'asc'))->limit($Page->firstRow.','.$Page->listRows)->select();
		}else{
			$count = $model->count();
			$pagesize=I('pagesize')?I('pagesize'):15;
			$Page= new \Think\Page($count,$pagesize);
			$Page->parameter['pagesize']   =   $pagesize;
			$pageshow   = $Page->manageshow();
			$contentinfo=$model->order(array('focus_sort','focus_id'=>'asc'))->limit($Page->firstRow.','.$Page->listRows)->select();
		}		
		
		$this->assign('contentinfo', $contentinfo);		
		$this->assign('pageshow',$pageshow);
        $this->display();
    }

   

    //欢迎页
    public function add() {
		$admin_id = session("admin.admin_id");
		$this->assign('admin_id', $admin_id);
		$this->display();
    }
    public function addphoto() {
		$admin_id = session("admin.admin_id");
		$this->assign('admin_id', $admin_id);
		//$sumbit=isset($_POST["submit"])?$_POST["submit"]:false;
		if(IS_POST){
			$data['focus_title']=$_POST['focus_title'];
			$data['focus_image']=$_POST['focus_image'];		
			$data['focus_sort']=$_POST['focus_sort'];	
			$data['focus_url']=$_POST['focus_url'];	
			$model = M('Focus')->add($data);
			//echo $model;die;
			if($model) {
					$this->success('幻灯片添加成功!',U('Photo/index'));
				}else{
					$this->error('幻灯片添加失败!',U('Photo/add'));
			}
		}
		
    }

	 public function edit() {
		if($_GET['editid']){
			$id=$_GET['editid'];
			$model = M('Focus');
			$result=$model->where('focus_id='.$id)->select();	
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
    public function editphoto() {
		
		$id=$_POST['focus_id'];
		$data['focus_title']=$_POST['focus_title'];
		$data['focus_image']=$_POST['focus_image'];		
		$data['focus_sort']=$_POST['focus_sort'];	
		$data['focus_url']=$_POST['focus_url'];	
		$model = M('Focus');
		$model->where('focus_id='.$id)->save($data);
			
		$this->success('幻灯片修改成功!',U('Photo/index'));
			
			
		
    }

	
	
  //欢迎页
    public function del() {
		if($_GET['delid']){
			$id=$_GET['delid'];
			$model = M('Focus');
			$del=$model->where('focus_id='.$id)->delete();
			if($del) {
				$this->success('删除成功!',U('Photo/index'));
			}else{
				$this->error('删除失败!',U('Photo/index'));
		}
		}
		
		$admin_id = session("admin.admin_id");
		$this->assign('admin_id', $admin_id);
		
		
    }


}
