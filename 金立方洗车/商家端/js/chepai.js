/*车牌选择*/
	var areaCont, areaList = $("#areaList");
	var province = 	["京", "津", "渝", "沪", "冀", "晋", "辽", "吉", "黑", "苏", "浙", "皖", "闽", "赣", "鲁", "豫", "鄂", "湘", "粤", "琼", "川", "贵", "云", "陕", "甘", "青", "蒙", "桂", "宁", "新", "藏", "使", "领", "警", "学", "港", "澳"];
	function intProvince() {
		areaCont = "";
		for (var i=0; i<province.length; i++) {
			areaCont += '<li>' + province[i] + '</li>';
		}
		areaList.html(areaCont);
	}
	intProvince();
	/*关闭选项*/
	function clockArea() {
		$(".zhezhao").fadeOut();
		$(".chepai").animate({"bottom": "-100%"});
	}
	
	$(function() {
		/*打开选项*/
		$("#expressArea").click(function() {
			$(".zhezhao").fadeIn();
			$(".chepai").animate({"bottom": 0});
		});
		/*关闭选项*/
		$(".zhezhao").click(function() {
			clockArea();
		});
		$(".chepai ul li").click(function(){
			var _this=$(this).text();
			$('#expressArea').text(_this);
			clockArea();
		});
		
	});
	