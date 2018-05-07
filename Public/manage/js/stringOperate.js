/*
 * 字符串操作类，主要用于字符串的添加和删除。例如：在字符串 "a,b,c"中添加字符串"d",或者直接删除某个字符串。
 * 主要提供将给定字符串添加到某个字符串，中间用逗号分隔
 */

/*
<script type="text/javascript">  
//StringOperate.baforeInsert = true;  
//StringOperate.isRepeat= true;  
//StringOperate.isDeleteAll = false;  
    function add(){  
        var val = StringOperate.add($("input[name='inputResult']").val(),$("input[name='inputString']").val());  
        $("input[name='inputResult']").val(val);  
    }  
    function del(){  
        var val = StringOperate.remove($("input[name='inputResult']").val(),$("input[name='inputString']").val());  
        $("input[name='inputResult']").val(val);  
    }  
</script> 
*/
var StringOperate ={
		separator    : "|",//字符串分隔符
		baforeInsert : false,//字符串追加方式，默认false是在后面添加，true在追加到前面
		isRepeat     : false,//追加的字符串是否可重复添加
		isDeleteAll  : true,//删除所有匹配的字符串
		
		//左边添加分隔符
		lInsertSeparator : function(operateString){
			if(operateString.indexOf(this.separator)  == 0)
				return operateString;
			return this.separator + operateString;
		},
		//右边添加分隔符
		rInsertSeparator : function(operateString){
			if(operateString.lastIndexOf(this.separator)  == (operateString.length - this.separator.length))
				return operateString;
			return operateString + this.separator; 
		},
		//去除左边分隔符
		lSeparatorTrim   : function(operateString){
			if(operateString.indexOf(this.separator)  == 0)
				return operateString.substring(1);
			return operateString;
		},
		//去除右边的分隔符
		rSeparatorTrim   : function(operateString){
			if(operateString.lastIndexOf(this.separator)  == (operateString.length - this.separator.length))
				return operateString.substring(0,operateString.length-1);
			return operateString;
		},
		//追加字符串，将str字符串 追加到operateString中
		add : function(operateString, str){
			if( str  && str != ""){
				if(this.isRepeat){//重复追加
					if(this.baforeInsert){//追加在开头
						 return this.rSeparatorTrim(this.lSeparatorTrim(str + this.separator + operateString));
					}
					return this.rSeparatorTrim(this.lSeparatorTrim(operateString + this.separator + str));
				}else{
					//开头和结尾都添加分隔符
					operateString =	this.lInsertSeparator(this.rInsertSeparator(operateString));
					if(operateString.indexOf(this.separator + str + this.separator) == -1){
						if(this.baforeInsert){
							return this.rSeparatorTrim(this.lSeparatorTrim(str + operateString));
						}else{
							return this.rSeparatorTrim(this.lSeparatorTrim(operateString + str));
						}
					}
					return this.rSeparatorTrim(this.lSeparatorTrim(operateString));
				}
			}
		},
		//删除指定字符串
		remove_old : function(operateString, str){
			if(operateString && str && operateString != "" && str != ""){
				//开头和结尾都添加分隔符
				operateString =	this.lInsertSeparator(this.rInsertSeparator(operateString));
				if(this.isDeleteAll){
					var outstr=operateString.split(this.separator);
					removeByValue(outstr, str);
					//alert(outstr);
					operateString = joinByValue(outstr,this.separator);

					//operateString = operateString.replace(new RegExp(this.separator,"g"),this.separator + this.separator);
					//删除所有匹配的字符串
					//operateString =	 operateString.replace(new RegExp(this.separator + str +this.separator,"g"),this.separator);
					//operateString =  operateString.replace(new RegExp(this.separator+"{2,}","g"),this.separator);
				}else{
					operateString =	 operateString.replace(new RegExp(this.separator + str + this.separator),this.separator);
				}
				return this.rSeparatorTrim(this.lSeparatorTrim(operateString));
			}
		},
		//删除指定字符串
		remove : function(operateString, str){
			if(operateString && str && operateString != "" && str != ""){
				var outstr=operateString.split(this.separator);
				removeByValue(outstr, str);
				//console.log(outstr);
				operateString=outstr.join(this.separator);
				return operateString;
			}
		}
		
		
};


function removeByValue(arr, val) {
	for(var i=0; i<arr.length; i++) {
		if(arr[i] == val) {
			arr.splice(i, 1);
			break;
		}
	}
}
//var somearray = ["mon", "tue", "wed", "thur"]
//removeByValue(somearray, "tue");

function joinByValue(arr,separator) {
	var str="";
	for(var i=0; i<arr.length; i++) {
		if(arr[i]!=""){
			if(str==""){
				str=arr[i];
			}else{
				str=separator+arr[i]
			}
		}
	}
	return str;
}