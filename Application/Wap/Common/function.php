<?php
function mbs_substr($str, $length, $tail = '...')
{
    $len = mb_strlen($str, 'utf-8');//获取字符串的长度
    if ($len > $length) {
        return mb_substr($str, 0, $length, 'utf-8') . $tail;
    } else {
        return $str;
    }
}
//页面跳转
function jump($message,$url){
	header("Content-type: text/html; charset=utf-8");
	echo "<script>alert('".$message."');location.href='".$url."';</script>";
	exit();
}