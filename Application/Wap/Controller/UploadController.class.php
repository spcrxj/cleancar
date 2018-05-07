<?php

namespace Wap\Controller;

use Think\Controller;

//上传相关操作
class UploadController extends Controller {

    //发表主题的图片上传插件
    //===============================
    /**
     * __mkdirs
     *
     * 循环建立目录的辅助函数
     *
     * @param dir    目录路径
     * @param mode    文件权限
     */
    function __mkdirs($dir, $mode = 0777) {
        if (!is_dir($dir)) {
            __mkdirs(dirname($dir), $mode);
            @mkdir($dir, $mode);
            return true;
        }
        return true;
    }

    /**
     * ImageShrink
     *
     * 大图信息缩放辅助函数
     *
     * @param imgfile    	获取大图路径
     * @param minx    		文件最大x
     * @param miny    		文件最小y
     * @param filename    	文件名称
     */
    function ImageShrink($imgfile, $minx, $miny, $filename) {

        //获取大图信息
        $imgarr = getimagesize($imgfile);
        $maxx = $imgarr[0]; //宽
        $maxy = $imgarr[1]; //长
        $maxt = $imgarr[2]; //格式
        $maxm = $imgarr['mime']; //mime类型
        if ($maxx < $minx) {//宽度不够不用缩放
            return $imgfile;
        }

        //大图资源
        switch ($maxt) {
            case 1:
                $maxim = imagecreatefromgif($imgfile);
                break;
            case 2:
                $maxim = imagecreatefromjpeg($imgfile);
                break;
            case 3:
                $maxim = imagecreatefrompng($imgfile);
                break;
        }

        //缩放判断
        if (($minx / $maxx) > ($miny / $maxy)) {
            $scale = $miny / $maxy;
        } else {
            $scale = $minx / $maxx;
        }

        //对所求值进行取整
        $minx = floor($maxx * $scale);
        $miny = floor($maxy * $scale);

        //添加小图
        $minim = imagecreatetruecolor($minx, $miny);
        //缩放函数
        imagecopyresampled($minim, $maxim, 0, 0, 0, 0, $minx, $miny, $maxx, $maxy);
        //判断图片类型
        switch ($maxt) {
            case 1:
                $imgout = "imagegif";
                break;
            case 2:
                $imgout = "imagejpeg";
                break;
            case 3:
                $imgout = "imagepng";
                break;
        }
        //变量函数
        $imgout($minim, $filename);
        //释放资源
        imagedestroy($maxim);
        imagedestroy($minim);
        return $filename;
    }

    //图片上传
    public function headimg() {
        $return = "";
        $base64_image_content = $_POST['filed'];
        //保存base64字符串为图片
        //匹配出图片的格式
        $picurl_421 = WEB_HOST . 'uploadfile/head/';
        $save_path = dirname(dirname(dirname(dirname(__FILE__)))) . '/uploadfile/head/';
        if (preg_match('/^(data:\s*image\/(\w+);base64,)/', $base64_image_content, $result)) {
            $file_ext = $result[2];
            //创建上传目录
            $filepath = $save_path . date("Ymd") . '/';
            $this->__mkdirs($filepath);
            $filename = date("YmdHis") . '_' . rand(10000, 99999);
            if (file_put_contents($filepath . $filename . '.' . $file_ext, base64_decode(str_replace($result[1], '', $base64_image_content)))) {
                //$return=$picurl_421.$filepath.$filename.'.'.$file_ext;

                $return = $this->ImageShrink($filepath . $filename . '.' . $file_ext, 800, 800, $filepath . $filename . '_800.' . $file_ext);
                $return = str_replace($save_path, $picurl_421, $return);
            } else {
                $return = "";
            }
        }
        echo $return;
        exit();
    }

    //get取值
    function httpGet($url) {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_TIMEOUT, 500);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, true);
        curl_setopt($curl, CURLOPT_URL, $url);
        $res = curl_exec($curl);
        curl_close($curl);
        return $res;
    }

}
