<?php

/*
 *  实例 
 * 张伟松
 * 2017年7月19日15:39:25
 */

namespace Wap\Controller;

use Think\Controller;

class DemoController extends Controller {

    //空方法，防止报错
    public function _empty() {
        $this->index();
    }

    //默认首页
    public function index() {
        $count = M("user")->count();
        $pagesize = 2;
        $Page = new \Think\Page($count, $pagesize);
        // 进行分页数据查询
        $listinfo = M("user")
                ->order("user_id ASC")
                ->limit($Page->firstRow . ',' . $Page->listRows)
                ->select();

        if (IS_AJAX) {
            $this->ajaxReturn($listinfo);
        } else {
            $this->assign('listinfo', $listinfo);
            $this->display();
        }
    }

    //上传

    public function upload() {
        $this->display();
    }

}
