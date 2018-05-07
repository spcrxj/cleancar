<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html> 
    <head> 
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8"> 
        <title>地址定位</title> 
        <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
        <script type="text/javascript" src="http://3gimg.qq.com/lightmap/components/geolocation/geolocation.min.js"></script>
    </head>

    <body>
        <script>
            var mapapijson;
            var geolocation = new qq.maps.Geolocation("XNYBZ-XKBHS-OJYOK-6DMZO-GOJMZ-FAFL3", "myapp");
            var options = {timeout: 4000};
            function showPosition(position) {
                var json = eval('(' + JSON.stringify(position, null, 4) + ')');
                sheng = json.province;
                shi = json.city;
                district = json.district;//区
                lat = json.lat;
                lng = json.lng;
                //alert(sheng);alert(shi);alert(district);alert(lat);alert(lng);
                //consloe.log(json);  
                location.href = "<?php echo U('index/index');?>&lat=" + lat + "&lng=" + lng;
            }
            function showErr() {
                location.href = "<?php echo U('index/index',array('lat'=>'34.153959','lng'=>'108.563261'));?>";
            }
            geolocation.getLocation(showPosition, showErr, options);
        </script>
    </body>
</html>