<?php

/*
 *  空控制器 
 * 张伟松
 * 2017年7月19日17:05:56
 * 
 */

namespace Wap\Controller;

use Think\Controller;

class EmptyController extends Controller {

    //空方法，防止报错
    public function _empty() {
        $this->redirect(U("index/index"));
    }

}
