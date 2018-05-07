<?php

namespace Manage\Controller;

use Think\Controller;

class UserController extends Controller {

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

    //会员列表
    public function index() {
		
		$where=1;
		$info=I("info");
		
        if($info){
            @extract($info);
			//按车牌号
            if($carcode){
                $info['carcode']=urldecode(trim($info['carcode']));
				$where.=" and ( ec_user.carcode like '%".urldecode($info['carcode'])."%') ";
                $this->assign('carcode',urldecode($info['carcode']));
            }
			//品牌
			if($brand){
                $info['brand']=urldecode(trim($info['brand']));
				$where.=" and ( ec_user.brand like '%".urldecode($info['brand'])."%') ";
                $this->assign('brand',urldecode($info['brand']));
            }
			//按车型
            if($cartype){
                $info['cartype']=urldecode(trim($info['cartype']));
				$where.=" and ( ec_user.cartype like '%".urldecode($info['cartype'])."%') ";
                $this->assign('cartype',urldecode($info['cartype']));
            }
			
			//按手机号
            if($phone){
                $info['phone']=urldecode(trim($info['phone']));
				$where.=" and ( ec_user.phone like '%".urldecode($info['phone'])."%') ";
                $this->assign('phone',urldecode($info['phone']));
            }
			//用户名
            if($realname){
                $info['realname']=urldecode(trim($info['realname']));
				$where.=" and ( ec_user.realname like '%".urldecode($info['realname'])."%') ";
                $this->assign('realname',urldecode($info['realname']));
            }
			//经办人
            if($dealwith){
                $info['dealwith']=urldecode(trim($info['dealwith']));
				$where.=" and ( ec_admin.realname like '%".urldecode($info['dealwith'])."%') ";
                $this->assign('dealwith',urldecode($info['dealwith']));
            }
			//按时间查询
			if($starttime){
				$info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_user.addtime  >= ".urldecode(strtotime($info['starttime']))." ";
				$this->assign('starttime',urldecode($info['starttime']));
            }
			if($endtime){
				$info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_user.addtime  <= ".urldecode(strtotime($info['endtime']))." ";
                $this->assign('endtime',urldecode($info['endtime']));	
            }			
		}
		
		 $user=M('User');
        // 查询满足要求的总记录数
		$count = $user->where($where)
            ->join('left join ec_admin on ec_admin.admin_id=ec_user.dealwith')
			->field('ec_user.*,ec_admin.realname as realname1')
			->order('ec_user.user_id desc')
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
        $pageshow   = $Page->manageshow();

        // 进行分页数据查询
        $listinfo = $user->where($where)
		    ->join('left join ec_admin on ec_admin.admin_id=ec_user.dealwith')
			->field('ec_user.*,ec_admin.realname as realname1')
            ->order('ec_user.user_id desc')->limit($Page->firstRow.','.$Page->listRows)
            ->select();
			
		//会员类型 1普通会员，2特殊会员，3 黑名单会员',
		$this->assign('userflag',D("User")->get_userflag());	
		$this->assign('listinfo',$listinfo);
        $this->display();
		
    }
	
	
    //特殊会员
	public function teshuhuiyuan(){
	 
	    $where= " 1 and ec_user.user_flag = 2 ";
		$info=I("info");
		
        if($info){
            @extract($info);
			//按车牌号
            if($carcode){
                $info['carcode']=urldecode(trim($info['carcode']));
				$where.=" and ( ec_user.carcode like '%".urldecode($info['carcode'])."%') ";
                $this->assign('carcode',urldecode($info['carcode']));
            }
			//品牌
			if($brand){
                $info['brand']=urldecode(trim($info['brand']));
				$where.=" and ( ec_user.brand like '%".urldecode($info['brand'])."%') ";
                $this->assign('brand',urldecode($info['brand']));
            }
			//按车型
            if($cartype){
                $info['cartype']=urldecode(trim($info['cartype']));
				$where.=" and ( ec_user.cartype like '%".urldecode($info['cartype'])."%') ";
                $this->assign('cartype',urldecode($info['cartype']));
            }
			
			//按手机号
            if($phone){
                $info['phone']=urldecode(trim($info['phone']));
				$where.=" and ( ec_user.phone like '%".urldecode($info['phone'])."%') ";
                $this->assign('phone',urldecode($info['phone']));
            }
			//用户名
            if($realname){
                $info['realname']=urldecode(trim($info['realname']));
				$where.=" and ( ec_user.realname like '%".urldecode($info['realname'])."%') ";
                $this->assign('realname',urldecode($info['realname']));
            }
			//经办人
            if($dealwith){
                $info['dealwith']=urldecode(trim($info['dealwith']));
				$where.=" and ( ec_admin.realname like '%".urldecode($info['dealwith'])."%') ";
                $this->assign('dealwith',urldecode($info['dealwith']));
            }
			//按时间查询
			if($starttime){
				$info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_user.addtime  >= ".urldecode(strtotime($info['starttime']))." ";
				$this->assign('starttime',urldecode($info['starttime']));
            }
			if($endtime){
				$info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_user.addtime  <= ".urldecode(strtotime($info['endtime']))." ";
                $this->assign('endtime',urldecode($info['endtime']));	
            }			
		}
		
		 $user=M('User');
        // 查询满足要求的总记录数
		$count = $user->where($where)
		    ->join('left join ec_admin on ec_admin.admin_id=ec_user.dealwith')
			->field('ec_user.*,ec_admin.realname as realname1')
            ->order('ec_user.user_id desc')
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
        $pageshow   = $Page->manageshow();

        // 进行分页数据查询
        $listinfo = $user->where($where)
		    ->join('left join ec_admin on ec_admin.admin_id=ec_user.dealwith')
			->field('ec_user.*,ec_admin.realname as realname1')
            ->order('ec_user.user_id desc')->limit($Page->firstRow.','.$Page->listRows)
            ->select();
			
		//会员类型 1普通会员，2特殊会员，3 黑名单会员',
		$this->assign('userflag',D("User")->get_userflag());	
		$this->assign('listinfo',$listinfo);
	     $this->display();
	}
	
	
	//黑名单
	public function heimingdan(){
	   $where= " 1 and ec_user.user_flag = 3 ";
		$info=I("info");
		
        if($info){
            @extract($info);
			//按车牌号
            if($carcode){
                $info['carcode']=urldecode(trim($info['carcode']));
				$where.=" and ( ec_user.carcode like '%".urldecode($info['carcode'])."%') ";
                $this->assign('carcode',urldecode($info['carcode']));
            }
			//品牌
			if($brand){
                $info['brand']=urldecode(trim($info['brand']));
				$where.=" and ( ec_user.brand like '%".urldecode($info['brand'])."%') ";
                $this->assign('brand',urldecode($info['brand']));
            }
			//按车型
            if($cartype){
                $info['cartype']=urldecode(trim($info['cartype']));
				$where.=" and ( ec_user.cartype like '%".urldecode($info['cartype'])."%') ";
                $this->assign('cartype',urldecode($info['cartype']));
            }
			
			//按手机号
            if($phone){
                $info['phone']=urldecode(trim($info['phone']));
				$where.=" and ( ec_user.phone like '%".urldecode($info['phone'])."%') ";
                $this->assign('phone',urldecode($info['phone']));
            }
			//用户名
            if($realname){
                $info['realname']=urldecode(trim($info['realname']));
				$where.=" and ( ec_user.realname like '%".urldecode($info['realname'])."%') ";
                $this->assign('realname',urldecode($info['realname']));
            }
			//经办人
            if($dealwith){
                $info['dealwith']=urldecode(trim($info['dealwith']));
				$where.=" and ( ec_admin.realname like '%".urldecode($info['dealwith'])."%') ";
                $this->assign('dealwith',urldecode($info['dealwith']));
            }
			//按时间查询
			if($starttime){
				$info['starttime']=urldecode(trim($info['starttime']));
                $where.=" and ec_user.addtime  >= ".urldecode(strtotime($info['starttime']))." ";
				$this->assign('starttime',urldecode($info['starttime']));
            }
			if($endtime){
				$info['endtime']=urldecode(trim($info['endtime']));
                $where.=" and ec_user.addtime  <= ".urldecode(strtotime($info['endtime']))." ";
                $this->assign('endtime',urldecode($info['endtime']));	
            }			
		}
		
		 $user=M('User');
        // 查询满足要求的总记录数
		$count = $user->where($where)
            ->order('ec_user.user_id desc')
			->join('left join ec_admin on ec_admin.admin_id=ec_user.dealwith')
			->field('ec_user.*,ec_admin.realname as realname1')
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
        $pageshow   = $Page->manageshow();

        // 进行分页数据查询
        $listinfo = $user->where($where)
            ->order('ec_user.user_id desc')
			->join('left join ec_admin on ec_admin.admin_id=ec_user.dealwith')
			->field('ec_user.*,ec_admin.realname as realname1')
			->limit($Page->firstRow.','.$Page->listRows)
            ->select();
			
		//会员类型 1普通会员，2特殊会员，3 黑名单会员',
		$this->assign('userflag',D("User")->get_userflag());	
		$this->assign('listinfo',$listinfo);
	    //dump($listinfo);
	 
	 
	 
	 $this->display();
	}
	
	  //添加会员
    public function adduser(){
		 $admin_id=session("admin.admin_id");
		//$admin_id=1;
       if (IS_POST){
            $info=I("info");
			$count=M("user")->where("phone = '".$info['phone']."' or carcode= '".$info['carcode']." '")->count();
			if($count>0){
				jump('当前手机号或车牌号已被注册，请重新注册！',U('user/adduser'));
			}
            $info['addtime']=SYS_TIME;
            $info['password']=MD5("123456");
			//$admin=M("Admin")->where("admin_id=".$admin_id)->find();
			$info['dealwith']=$admin_id;
			$info['avatar']=C('WEB_URL')."public/wap/images/touxiang_03.png";	
			$info['cleantime']=strtotime($info['cleantime']);
            $flag=M("User")->add($info);
            if($flag){
               jump('添加会员成功！',U('user/index'));
            }else{
               jump('添加会员失败！',U('user/index'));
            }
        }else{
			//会员状态 1启用，2禁用
			$this->assign('getuserable',D("User")->get_userable());
			//会员类型 1普通会员，2特殊会员，3 黑名单会员
			$this->assign('userflag',D("User")->get_userflag());
            $this->display();
        }
    }
	//编辑会员信息
	public function edituser(){
		$user_id =I("get.user_id");
		if(IS_POST){
			$info=I("info");
			$info['cleantime']=strtotime($info['cleantime']);
			
			$flag=M("User")->where(" user_id=".$user_id." ")->save($info);
			if($flag){
				jump('编辑会员成功！',U('user/index'));
			}else{
				jump('编辑会员失败！',U('user/index'));
			}
		}else{
			$user = M('User')->where("user_id=".$user_id)->find();	
			if($user['cleantime']==0){
				$user['cleantime']=" ";
			}
			
		    $this->assign('user',$user);
			//会员状态 1启用，2禁用
			$this->assign('getuserable',D("User")->get_userable());
			//会员类型 1普通会员，2特殊会员，3 黑名单会员
			$this->assign('userflag',D("User")->get_userflag());
			$this->display();
		}
		
	}
	
	//设置洗车次数 特殊
	public function cleancarcount_teshu(){
		$user_id=I('get.user_id');
		if(IS_POST){
			$info=I('info');
			$info['clean_starttime']=strtotime($info['clean_starttime']);
			$info['clean_endtime']=strtotime($info['clean_endtime']);
			$flag=M("User")->where("user_id=".$user_id." ")->save($info);
			if($flag){
				jump('洗车次数设置成功！',U('user/cleancarcount_teshu',array('user_id'=>$user_id)));
				
			}else{
				jump('洗车次数设置失败！',U('user/cleancarcount_teshu',array('user_id'=>$user_id)));
			}
		}else{
			$user=M("User")->where("user_id=".$user_id." ")->find();
			
			if($user['clean_starttime']==0){
				$user['clean_starttime']=" ";
			}
			if($user['clean_endtime']==0){
				$user['clean_endtime']=" ";
			}
			
			$this->assign('user',$user);
			$this->display();
		}
		
		
		
		
	}
	
	//设置洗车次数 黑名单
	public function cleancarcount_heimingdan(){
		$user_id=I('get.user_id');
		if(IS_POST){
			$info=I('info');
			$info['clean_starttime']=strtotime($info['clean_starttime']);
			$info['clean_endtime']=strtotime($info['clean_endtime']);
			$flag=M("User")->where("user_id=".$user_id." ")->save($info);
			if($flag){
				jump('洗车次数设置成功！',U('user/cleancarcount_heimingdan',array('user_id'=>$user_id)));
				
			}else{
				jump('洗车次数设置失败！',U('user/cleancarcount_heimingdan',array('user_id'=>$user_id)));
			}
		}else{
			
			$user=M("User")->where("user_id=".$user_id." ")->find();
			
			if($user['clean_endtime']==0&&$user['clean_starttime']==0){
				
				if($user['cleantime']==0){
				$user['clean_endtime']="  ";
				$user['clean_starttime']="  ";
			}else{
			$user['clean_starttime']=strtotime("-1 year",$user['cleantime']);
			$user['clean_endtime']=$user['cleantime'];
			}	
				
			}
			//dump($user);
			$this->assign('user_flag',$user_flag);
			$this->assign('user',$user);
			$this->display();
		}
		
		
		
		
	}
	
	  //查看会员信息
     public function chakan(){
		 $user_id =I("get.user_id");
		 $user = M('User')->where("user_id=".$user_id)->find();	
		$this->assign('user',$user);
	    //会员状态 1启用，2禁用
		$this->assign('getuserable',D("User")->get_userable());
		//会员类型 1普通会员，2特殊会员，3 黑名单会员
		$this->assign('userflag',D("User")->get_userflag());
		$this->display();
		 
	 }
	
	//移至普通会员
	 public function moveputong() {
		$user_id=I('get.user_id');
		$user_flag=I('get.user_flag');
			$flag= M('User')->where('user_id='.$user_id)->save(array('user_flag'=>1));
				if($user_flag==2){
					if ($flag){
						jump('移至普通会员成功',U('user/teshuhuiyuan'));
					}else{
					jump('移至普通会员失败',U('user/teshuhuiyuan'));
				         }
				}
        	    if($user_flag==3){
					if ($flag){
						jump('移至普通会员成功',U('user/heimingdan'));
					}else{
					jump('移至普通会员失败',U('user/heimingdan'));
				       }
				
				}
		
		
     }
	
	//移至特殊会员
	 public function moveteshu() {
		$user_id=I('get.user_id');
        $flag= M('User')->where('user_id='.$user_id)->save(array('user_flag'=>2));	
		if($flag){
			jump('移至特殊会员成功',U('user/index'));
		}
		
     }
	 //移至黑名单
	 public function moveheimingdan() {
			$user_id=I('get.user_id');
        $flag= M('User')->where('user_id='.$user_id)->save(array('user_flag'=>3));	
		if($flag){
			jump('移至黑名单成功',U('user/index'));
		}
     }
	//删除会员
	 public function deluser() {
		$user_id=I('get.user_id');
        $flag= M('User')->where('user_id='.$user_id)->delete();	
		
		jump('删除成功',U('user/index'));
     }
	
	//重置登录密码
	 public function chongzhi_denglu() {
		if(I('get.user_id')){
			$info['password']=MD5('123456');//重置登录密码
            $flag= M('User')->where('user_id='.I('get.user_id'))->save($info);	
		} 
		jump('重置密码为123456',U('user/index'));
     }
	


}
