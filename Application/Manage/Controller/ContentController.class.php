<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/17 0017
 * Time: 下午 3:05
 */

namespace Manage\Controller;
use Think\Controller;
class ContentController extends Controller
{
    function __construct() {
        //继承父类
        parent::__construct();
    }

    //默认首页
    public function index() {
        $this->display();
    }
//contentList
    public function contentList()
    {
        $where="1";
        $info=I("info");
        if ($info){
            @extract($info);
            if($title){
                $info['title']=urldecode($info['title']);
                $where.=" and title like '%".trim(urldecode($info['title']))."%' ";
                $this->assign('title',urldecode($info['title']));
            }
            if($keywords){
                $info['keywords']=urldecode($info['keywords']);
                $where.=" and keywords like '%".trim(urldecode($info['keywords']))."%' ";
                $this->assign('keywords',urldecode($info['keywords']));
            }
            if($classtype){
                $where.=" and classtype = ".$classtype." ";
                $this->assign('classtype',$classtype);
            }
        }
        $model= M('content');
        // 查询满足要求的总记录数
        $count = $model->where($where)->count();
        $pagesize=I('pagesize')?I('pagesize'):15;
        $Page = new \Think\Page($count,$pagesize);
        //分页跳转的时候保证查询条件
        if($info){
            foreach($info as $key=>$val) {
                $Page->parameter['info['.$key.']']   =   urlencode($val);
            }
        }
        $Page->paramete['pagesize']=$pagesize;
        $pageshow   = $Page->manageshow();
        // 进行分页数据查询
        $content = $model->where($where)->order('addtime desc')->limit($Page->firstRow.','.$Page->listRows)->select();
        foreach($content as $k => $v){
            if($v['classtype']==1){
                $content[$k]['classtype']='单页';
            }else if($v['classtype']==2){
                $content[$k]['classtype']='文章';
            }else if($v['classtype']==3) {
                $content[$k]['classtype']='其他';
            }
        }
        $this->assign('contentinfo', $content);
        $this->assign('pageshow',$pageshow);
        $this->display();
    }
//   add   a   new  record：
    public function addContent()
    {
        $this->display("addcontent");
    }
    // add process
    public function addContentPro()
    {
        $data['title']=$_POST['info']['title'];
        $data['image']=$_POST['info']['image'];
        $data['classtype']=$_POST['info']['classtype'];
        $data['keywords']=$_POST['info']['keywords'];
        $data['description']=$_POST['info']['description'];
        $data['content']=$_POST['info']['content'];
        $data['addtime']=time();
        $User = M("content"); // 实例化User对象
        $res=$User->data($data)->add();
        if($res) {
            jump('添加成功！',U('content/contentList'));
        }else {
              jump('添加失败！',U('content/addContent'));
        }
    }
    //delete a record；
    public function delContent($content_id,$class_type)
    {
        if($class_type!="单页")
        {
            $model= M('content');
            $delinfo=$model->where("id='{$content_id}'")->delete();
            if($delinfo) {
                jump('删除成功！',U('content/contentList'));
            }else {
                jump('删除失败！',U('content/contentList'));
            }
        }else
            {
                jump('单页不能删除！Sorry!',U('content/contentList'));
            }
    }
    //edit content；
    public function editContent($content_id)
    {
        $model= M('content');
        $editcontent=$model->where("id='{$content_id}'")->select();
        $this->assign('editcontent', $editcontent);
        $this->display();
    }
  // update Process function
    public  function editPro()
    {
        $id=$_POST['id'];
        $User = M("content"); // 实例化User对象
        $User->title =$_POST['info']['title'];
        $User->classtype =$_POST['info']['classtype'];
        $User->image =$_POST['info']['image'];
        $User->keywords =$_POST['info']['keywords'];
        $User->description =$_POST['info']['description'];
        $User->content =$_POST['info']['content'];
        $User->addtime =time();
        $res=$User->where("id='{$id}'")->save(); // 根据条件更新记录
        if ($res)
        {
            jump('修改成功！',U('content/contentList'));
        }else{
            jump('修改失败！',U('content/editContent'));
        }
    }
}