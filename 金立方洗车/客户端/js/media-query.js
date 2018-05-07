window.onload = function(){
/*    var newSlideSize = function slideSize(){
        var w = Math.ceil($(".swiper-container").width()/3);
        $(".swiper-container,.swiper-wrapper,.swiper-slide").height(w);
    };
    newSlideSize();
    $(window).resize(function(){
        newSlideSize();
    });*/

    var mySwiper = new Swiper('.swiper-container',{
        pagination: '.swiper-container .pagination',
        loop:true,
        autoplay:8000,
        paginationClickable: true,
        onSlideChangeStart: function(){
            //回调函数
        }
    });
/*    cTab("#tab1","#con1");
    cTab("#tab2","#con2");*/
	var mySwiper = new Swiper('.rmpp_bg_ct',{
        pagination: '.rmpp_bg_ct .pagination',
        loop:true,
        autoplay:8000,
        paginationClickable: true,
        onSlideChangeStart: function(){
            //回调函数
        }
    });
    var mySwiper = new Swiper('.xsth_ct',{
        pagination: '.xsth_ct .pagination',
        loop:true,
        autoplay:8000,
        paginationClickable: true,
        onSlideChangeStart: function(){
            //回调函数
        }
    });
	 var mySwiper = new Swiper('.bhcksy_lunbo_ct',{
        pagination: '.bhcksy_lunbo_ct .pagination',
        loop:true,
        autoplay:8000,
        paginationClickable: true,
        onSlideChangeStart: function(){
            //回调函数
        }
    });
};
$(function(){
	$('.head_nav span').click(function(){
		$(this).siblings('ul').slideToggle();
		
	})
})