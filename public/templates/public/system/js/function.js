$(document).ready(function ($) {
        var menu = $('.header'),
        pos = menu.offset();
        $(window).scroll(function(){
            if($(this).scrollTop() > pos.top+menu.height() && menu.hasClass('default')){
                menu.fadeOut('fast', function(){
                    $(this).removeClass('default').addClass('fixed').fadeIn('fast');
//                    $('.tags-search').attr('style','display:none');
//                    $('.tl').attr('style','display:none');
                });
            } else if($(this).scrollTop() <= pos.top && menu.hasClass('fixed')){
                        menu.fadeOut('fast', function(){
                            $(this).removeClass('fixed').addClass('default').fadeIn('fast');
//                            $('.tags-search').attr('style','display:inline');
//                            $('.tl').attr('style','display:inline');
                        });
                    }
        });
        function slideHighlightProduct(){
            if(parseInt($(".spot-content").css('margin-left'))<=0 || parseInt($(".spot-content").css('margin-left'))>-1624){
                $(".spot-content").css("margin-left",function(index,value){
                    return parseInt(value) - 812;
                });
             }
                if(parseInt($(".spot-content").css('margin-left'))< -1624){
                    $(".spot-content").css("margin-left",0);
                }
        }
        $('.slidesjs-previous').click(function(){
            slideHighlightProduct();
        });
        setInterval(function(){
            if(parseInt($(".spot-content").css('margin-left'))<=0 || parseInt($(".spot-content").css('margin-left'))>-1624){
                $(".spot-content").css("margin-left",function(index,value){
                    return parseInt(value) - 812;
                });
             }
                if(parseInt($(".spot-content").css('margin-left'))< -1624){
                    $(".spot-content").css("margin-left",0);
                }
        },5000);
        $('.slidesjs-next').click(function(){
            if(parseInt($(".spot-content").css('margin-left'))== -1624 || parseInt($(".spot-content").css('margin-left'))<0){
                $(".spot-content").css("margin-left",function(index,value){
                    return parseInt(value) + 812;
                });
             }
                if(parseInt($(".spot-content").css('margin-left'))== 0){
                    $(".spot-content").css("margin-left",0);
                }
        });
    });