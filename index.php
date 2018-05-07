<?php

if (version_compare(PHP_VERSION, '5.3.0', '<'))
    die('require PHP > 5.3.0 !');

// 开启调试模式 建议开发阶段开启 部署阶段注释或者设为false
define('APP_DEBUG', true);

// 定义应用目录
define('APP_PATH', './Application/');


//永不超时
set_time_limit(0);
//设置与客户机断开是否会终止脚本的执行
ignore_user_abort(true);
//设置时区,定义系统时间
ini_set('date.timezone', 'PRC');
//设置session超时时间
ini_set('session.gc_maxlifetime', 144000);
//常量时间
define('SYS_TIME', time());
// 引入ThinkPHP入口文件
require './ThinkPHP/ThinkPHP.php';
