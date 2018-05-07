<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=no">
	<title>商家活动列表</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link href="/cleancar/Public/manage/http/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.staticfile.org/font-awesome/4.4.0/css/font-awesome.css?v=4.4.0" rel="stylesheet">
    <link href="/cleancar/Public/manage/css/plugins/bootstrap-table/bootstrap-table.min.css" rel="stylesheet">
    <link href="/cleancar/Public/manage/css/style.min.css" rel="stylesheet">
    <link href="/cleancar/Public/manage/css/index.css" rel="stylesheet">	
	<script type="text/javascript" src="/cleancar/Public/manage/js/jquery.js"></script>
    <script src="/cleancar/Public/manage/js/jquery.min.js"></script>
    
	<style>
		.tablelist{border:solid 1px #cbcbcb; width:100%; clear:both;}
		.tablelist th{background:url(../images/th.gif) repeat-x; height:34px; line-height:34px; border-bottom:solid 1px #b6cad2; text-indent:11px; text-align:center;}
		.tablelist td{line-height:35px; text-indent:11px; border-right: dotted 1px #c7c7c7;text-align:center;}
		.tablelink{color:#056dae;}
		.tablelist tbody tr.odd{background:#f5f8fa;}
		.tablelist tbody tr:hover{background:#e5ebee;}
	</style>
</head>
<body class="gray-bg">


<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-sm-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>商家活动列表</h5>
                </div>
				
                <div class="ibox-content">
				<form name="seachform" id="seachform" action="<?php echo U('seller/seller_activelist',array('id'=>$id,'seller_id'=>$seller_id));?>" method="post">
                   <div class="row khcrj">
                   		<div class="col-sm-12">
                            <div class="chaxun form-group">
                                <button class="btn btn-primary " type="submit" onclick="$('#flag').val('chaxun');$('#seachform').submit();">
                                    <i class="fa fa-search"></i>&nbsp;&nbsp;<span class="bold"  >查询</span>
                                </button>
                            </div>
                        </div>
                   		<div class="col-sm-12">
                           <dl class="riqi form-group">
                                <dt class="control-label ">日期</dt>
                               <dd>
                                   <input name="info[starttime]" placeholder="活动开始日期" class="laydate-icon form-control layer-date" id="start"   value="<?php echo ($starttime); ?>" >
					               <input name="info[endtime]" placeholder="活动结束日期"   class="laydate-icon form-control layer-date" id="end"    value="<?php echo ($endtime); ?>" >
                                </dd>
                            </dl>
                            <dl class="shoujihao form-group">
                                <dt>商家名称</dt>
                                <dd>
                                    <input type="text" class="form-control" name="info[sellername]" maxlength="20" value="<?php echo ($sellername); ?>">
                                </dd>
                            </dl>
                        </div>
						
                    </div>
					 <input name="flag" id="flag" type="hidden" value="no">
				</form>
                    <div class="table-responsive">
                    	<table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>商家</th>
                                    <th>活动名称</th>
                                    <th>活动图片</th>
                                    <th>活动开始时间</th>
                                    <th>活动结束时间</th>
									<th>活动添加时间</th>
                                    <th>参加报名人数</th>
									<th>操作</th>
                                </tr>
                            </thead>
                            <tbody>
						    <?php if(is_array($activelist)): $i = 0; $__LIST__ = $activelist;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$active): $mod = ($i % 2 );++$i;?><tr>
                                    <td><?php echo ($active["sellername"]); ?></td>
                                    <td><?php echo ($active["activity_title"]); ?></td>
                                    <td><img style="height: 30px;width:30px;" src="<?php echo ($active["activity_image"]); ?>" /></td>
                                    <td><?php echo (date("Y-m-d H:i:s",$active["activity_starttime"])); ?></td>
                                    <td><?php echo (date("Y-m-d H:i:s",$active["activity_endtime"])); ?></td>
									<td><?php echo (date("Y-m-d H:i:s",$active["activity_addtime"])); ?></td>
									<td><?php echo ($active["activity_num"]); ?></td>
									<td>  
										<a href="<?php echo U('seller/delactive',array('id'=>$active['id']));?>" onclick="{if(confirm('确认删除?')){return true;}return false;}"><button class="btn btn-primary " type="button">
                                         <span class="bold" >删除</span>
                                        </button></a>
										<a href="<?php echo U('seller/editactive',array('id'=>$active['id'],'seller_id'=>$active['seller_id']));?>" ><button class="btn btn-primary " type="button">
                                         <span class="bold" >编辑</span>
                                        </button></a>
										<a href="<?php echo U('seller/sell_active',array('id'=>$active['id']));?>" data-toggle="modal" data-target="#myModal"><button class="btn btn-primary " type="button">
                                         <span class="bold" style="color:#fff;">报名列表</span>
                                       </a>
                                    </td>
                                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                            </tbody>
                        </table>
                    </div> 
                    <div class="fixed-table-pagination" style="display: block;">
       	            <?php echo ($pageshow); ?>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- 模态框（Modal） -->
	<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	   <div class="modal-dialog" style="width:900px;">
		    <div class="modal-content">
			</div><!-- /.modal-content -->
		</div><!-- /.modal -->
	</div>
	
<script src="/cleancar/Public/manage/http/js/jquery.min.js"></script>
<script src="/cleancar/Public/manage/http/js/bootstrap.min.js"></script>
<script src="/cleancar/Public/manage/js/plugins/layer/laydate/laydate.js"></script>
<script>
	$(function(){
		$('#myModal').on('hidden.bs.modal', function (e) {
			window.location.reload();  
		})
	});
</script>
<script>

    var start = {
        elem: "#start", //需显示日期的元素选择器
        format: "YYYY-MM-DD hh:mm:ss", //日期格式
        min: "2017-01-01 23:59:59",
        max: "2099-06-16 23:59:59",
		istime: false, //是否开启时间选择
        istime: true,  //是否显示清空
        istoday: false,  //是否显示今天
        choose: function (datas) {
            end.min = datas;
            end.start = datas
        }
    };
    var end = {
        elem: "#end",
        format: "YYYY-MM-DD hh:mm:ss",
        min: laydate.now(),
        max: "2099-06-16 23:59:59",
		istime: false, //是否开启时间选择
        istime: true,
        istoday: false,
        choose: function (datas) {
            start.max = datas
        }
    };
    laydate(start);
    laydate(end);
</script>
<script type="text/javascript" src="/cleancar/Public/manage/http/js/stats.js" charset="UTF-8"></script>
</body>

</html>