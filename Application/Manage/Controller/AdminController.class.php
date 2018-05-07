<?php

namespace Manage\Controller;

use Think\Controller;

class AdminController extends Controller {

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
	
	//设置管理员状态
	public function admin_able(){
		$admin_id=I("get.admin_id");
    	$admintype_=M('Admin')->where('admin_id='.$admin_id)->field('admin_able')->find();
		if($admintype_['admin_able']==1){
		   $info['admin_able']=2;
		}else{
		   $info['admin_able']=1;
		}
		M('Admin')->where('admin_id='.$admin_id)->save($info);
		jump('操作成功！', U('admin/index'));
	}
	
	//重置登录密码
	public function repassword(){
		$admin_id=I("get.admin_id");
		$info2['password']=MD5('123456');//重置登录密码
        $flag= M('Admin')->where('admin_id='.$admin_id)->save($info2);	
		jump('重置登录密码成功！', U('admin/index'));
	}
	//管理员-管理
    public function index() {
        $admin_id = session('admin.admin_id', ""); //用户id
		$admintype = session('admin.admin_type', ""); //管理员等级
        $where=" 1 ";
  
        $info=I("info");
        if ($info){
            @extract($info);
            if($username){
                $info['username']=urldecode(trim($info['username']));
                $where.="and ec_admin.username like '%".urldecode(trim($info['username']))."%'    ";
                $this->assign('username',urldecode(trim($info['username'])));
            }
			if($phone){
                $info['phone']=urldecode(trim($info['phone']));
                $where.="and (ec_admin.phone like '%".urldecode($info['phone'])."%'  )  ";
                $this->assign('phone',urldecode(trim($info['phone'])));
            }
			if($admin_type){
                $info['admin_type']=urldecode(trim($info['admin_type']));
                $where.="and ec_admin.admin_type like '%".urldecode(trim($info['admin_type']))."%'    ";
                $this->assign('admin_type',urldecode(trim($info['admin_type'])));
            }
        }
        $admin=M('Admin');
        // 查询满足要求的总记录数
        $count      = $admin->where($where)
					->count();
					
		$pagesize=I('pagesize')?I('pagesize'):15;
        $Page       = new \Think\Page($count,$pagesize);
        //分页跳转的时候保证查询条件
        if($info){
            foreach($info as $key=>$val) {
                $Page->parameter['info['.$key.']']   =   urlencode($val);
            }
        }
		$Page->parameter['pagesize']   =   $pagesize;
        $pageshow   = $Page->manageshow();
		
        // 进行分页数据查询
        $listinfo = $admin->where($where)
				  ->order('ec_admin.admin_id desc')
				  ->field("ec_admin.*")
				  ->limit($Page->firstRow.','.$Page->listRows)
				  ->select();
          				  
		$this->assign('get_admin_type',D('admin')->get_admin_type());//等级
        $this->assign('get_able_type',D('admin')->get_able_type());//员工状态（正常、禁用）	
        $this->assign('admintype',$admintype);
		$this->assign('listinfo',$listinfo);
        $this->assign('pageshow',$pageshow);	
        $this->display();
		
    }
	  //添加管理员
    public function addguanliyuan(){
       if (IS_POST){
			$admin_id = session('admin.admin_id', ""); 
            $info=I("info");
			$count=M("admin")->where("username = '".$info['username']."'")->count();
			if($count>0){
				jump('当前账号和已被注册，请重新更换账号！',U('admin/addguanliyuan'));
			}			
			$info['admin_able']=1;
            $info['admin_addtime']=SYS_TIME;
			$info['avatar']=C('WEB_URL')."public/Manage/images/touxiang_03.png";
            $info['password']=MD5("123456");
            $flag=M("admin")->add($info);
            if($flag){
               jump('添加管理员成功！',U('admin/index'));
            }else{
               jump('添加管理员失败！',U('admin/index'));
            }
        }else{
			$this->assign('admin_type',session('admin.admintype', ""));
            $this->assign('get_admin_type',D('admin')->get_admin_type());	
            $this->display();
        }
    }
	//修改管理员
	public function editguanliyuan(){
		$admin_id =I("get.admin_id");
		$where="1 and ec_admin.admin_id=".$admin_id." ";
		$listinfo = M('Admin')->where($where)
				  ->field("ec_admin.*")
				  ->find();	
		$this->assign('listinfo',$listinfo);
		$this->assign('admin_id',$admin_id);	 //用户admin_id		
		if(IS_POST){
			$info=I("info");
			$admin_id =I("get.admin_id");			
			$flag=M("Admin")->where(" admin_id=".$admin_id)->save($info);
			if($flag){
				jump('修改成功！',U('admin/index'));
			}else{
				jump('修改失败！',U('admin/index'));
			}
		}else{
			$this->display();
		}
	}
	//管理员管理-删除
	public function delguanliyuan(){
	    $admin_id=I("get.admin_id");
        M('Admin')->where('admin_id='.$admin_id)->delete();
        jump('删除用户成功！',U('admin/index'));
	}
    //用户密码管理
    public function password() {
        $admin_id = session('admin.admin_id');
        if (IS_POST) {
            $info = I("info");
			$password =md5($info['password1_']);
            $flag = M("Admin")->where("admin_id='".$admin_id."'")->save(array('password'=>$password));
            jump('密码修改成功！', U('index/welcome'));
        } else {
            $userinfo = M("Admin")->where("admin_id=" . $admin_id)->find();
            $this->assign('userinfo', $userinfo);
            $this->display();
        }
    }
	//修改密码 -检查checkpass旧密码输入是否有误
	public function checkpass() {
		 $password =md5(trim(I("get.password")));
		 $admin_id = session('admin.admin_id'); //用户id
		 $count=M("Admin")->where("password = '".$password."' and admin_id='".$admin_id."' ")->count();
         if($count>0){
			 echo "ook";
			 exit();
		 }else{
			 echo "noon";
			 exit();
		 } 
	}
}
