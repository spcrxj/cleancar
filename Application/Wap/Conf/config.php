<?php

define(WEB_URL, 'http://127.0.0.1/cleancar/');
return array(
    //'配置项'=>'配置值'
    "URL_MODEL" => 0,
    'DEFAULT_MODULE' => 'wap', // 默认模块
    //数据库配置信息
    'DB_TYPE' => 'mysql', // 数据库类型 
    'DB_HOST' => '127.0.0.1', // 服务器地址
    'DB_NAME' => 'cleancar', // 数据库名
    'DB_USER' => 'root', // 用户名
    'DB_PWD' => 'root', // 密码
    'DB_PORT' => 3306, // 端口
    'DB_PARAMS' => array(), // 数据库连接参数
    'DB_PREFIX' => 'ec_', // 数据库表前缀 
    'DB_CHARSET' => 'utf8', // 字符集
    'DB_DEBUG' => false, // 数据库调试模式 开启后可以记录SQL日志
    //'SHOW_PAGE_TRACE'=>TRUE,//输出页面调试
    'LOG_RECORD' => false, //FALSE,//关闭log输出
);
