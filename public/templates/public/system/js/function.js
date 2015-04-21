$(document).ready(function() {
    var menu = $('.header');
    var modules = $('#modules');
    var footer = $('.footer');
    posFooter = footer.offset();
    filter = modules.offset();
    pos = menu.offset();
    $(window).scroll(function() {

//          ===========================MENU FLOATTING=============================
        if ($(this).scrollTop() > pos.top + menu.height() && menu.hasClass('default')) {
            menu.fadeOut('fast', function() {
                $(this).removeClass('default').addClass('fixed').fadeIn('fast');
                $('#header-top .logo').hide();
                $('#header__menu').prependTo('.header-content').attr('style', 'top:17px; left: 60px');
            });
        } else if ($(this).scrollTop() <= pos.top && menu.hasClass('fixed')) {
            menu.fadeOut('fast', function() {
                $(this).removeClass('fixed').addClass('default').fadeIn('fast');
                $('#header__menu').prependTo('.layout__wrapper ').attr('style', 'top:0px; left: 0px');
                $('#header-top .logo').show();
            });
        }

//        ==============================FILTER FLOATTING======================
        if ($(this).scrollTop() > filter.top + modules.height() && modules.hasClass('modules')) {
            $('#modules').removeClass('modules').addClass('filter-scroll').fadeIn('fast');
        }
        if ($(this).scrollTop() < 380)
            $('#modules').removeClass('filter-scroll').addClass('modules').fadeIn('fast');
        if (parseInt($('#modules').offset().top) + 600 > $('.footer').offset().top)
            $('#modules').removeClass('filter-scroll').addClass('filter-scroll-after').fadeIn('fast');
        if ($(this).scrollTop() > 960 && $('#modules').hasClass('filter-scroll-after') && $(this).scrollTop() < 1000)
            $('#modules').removeClass('filter-scroll-after').addClass('filter-scroll').fadeIn('fast');
    });

//        ============================HIGHLIGHT PRODUCT===========================
    function slideHighlightProduct() {
        if (parseInt($(".spot-content").css('margin-left')) <= 0 || parseInt($(".spot-content").css('margin-left')) > -1624) {
            $(".spot-content").css("margin-left", function(index, value) {
                return parseInt(value) - 812;
            });
        }
        if (parseInt($(".spot-content").css('margin-left')) < -1624) {
            $(".spot-content").css("margin-left", 0);
        }
    }
    $('.slidesjs-previous').click(function() {
        slideHighlightProduct();
    });
    setInterval(function() {
        if (parseInt($(".spot-content").css('margin-left')) <= 0 || parseInt($(".spot-content").css('margin-left')) > -1624) {
            $(".spot-content").css("margin-left", function(index, value) {
                return parseInt(value) - 812;
            });
        }
        if (parseInt($(".spot-content").css('margin-left')) < -1624) {
            $(".spot-content").css("margin-left", 0);
        }
    }, 5000);
    $('.slidesjs-next').click(function() {
        if (parseInt($(".spot-content").css('margin-left')) == -1624 || parseInt($(".spot-content").css('margin-left')) < 0) {
            $(".spot-content").css("margin-left", function(index, value) {
                return parseInt(value) + 812;
            });
        }
        if (parseInt($(".spot-content").css('margin-left')) == 0) {
            $(".spot-content").css("margin-left", 0);
        }
    });

//        ===========================SIDEBAR MENU==============================
    var focus = 0;
    $('.hover-sidebar').hover(function() {
        $('.sidebar__' + focus).removeClass('active');
        $('.floor__home-' + focus).removeClass('active');
        $('.sidebar__' + $(this).data('id')).addClass('active');
        $('.floor__home-' + $(this).data('id')).addClass('active');
        $('.sidebarSecond ').show();
        focus = $(this).data('id');
    });
    $('.sidebar').mouseleave(function() {
        $('.sidebarSecond ').hide();
    });
    $('.floor__home-0').addClass('active');
//        =========================PRODUCT HOVER====================================
    $('body').delegate('.hover', 'mouseover', function() {
        $('.info-' + $(this).data('id')).show();
    });
    $('body').delegate('.hover', 'mouseleave', function() {
        $('.info-' + $(this).data('id')).hide();
    });

//        ==========================CART==============================
    $('.number').change(function() {
        var priId = $(this).data('id');
        var number = $(this).val();
        var price = parseInt($('.price-' + priId).text());
        var selloff = parseInt($('.selloff' + priId).text());
        var quantity = $('#snumber-' + priId).val();
        var id = parseInt($(this).attr('data-sId'));
        $.ajax({
            url: 'cart/change-number',
            type: 'POST',
            cache: false,
            data: {
                priId: priId,
                value: number,
                id: id,
                quantity : quantity
            },
            success: function(data) {
                    location.reload(true);
            }
        });
    });

    $('#cart_expand').click(function() {
        $('body').append("<div class='cart-overlay'></div>");
        $('.cart-overlay').css({
            'background': '#222222',
            'opacity': '0.5',
            'width': $(document).width(),
            'height': $(document).height(),
            'z-index': 99,
            'position': 'absolute',
            'top': '0px',
            'left': '0px'
        });
        $('#cart_expand .box-link-svg').addClass('after-click-cart');
        $('#cart_mini').show(500);
    });
    $('.close').click(function() {
        $('.cart-overlay').remove();
        $('#cart_mini').hide(500);
        $('#cart_expand .box-link-svg').removeClass('after-click-cart');
    });
    
    $('.ppu_rtextarea').hide();
    $('.ppu_tabshop').addClass('current');
    $('.ppu_tabshop').click(function(){
       $(this).addClass('current');
       $('.ppu_tabhome').removeClass('current');
       $('.ppu_rtextarea').hide();
       $('.ppu_add_shop').show();
    });
    $('.ppu_tabhome').click(function(){
       $(this).addClass('current');
       $('.ppu_tabshop').removeClass('current');
       $('.ppu_rtextarea').show();
       $('.ppu_add_shop').hide();
    });
    var focus = 0;
    $('.item-shop').click(function(){
       var id = $(this).data('id');
       $('.item-shop-' + focus).removeClass('active');
       $('.item-shop-' + id).addClass('active');
       focus = $(this).data('id');
    });
    
    $('#ddlShop').hide();
    $('#ddlCity').change(function(){
        var value = $(this).val();
        if(value == 1)
            $('#ddlShop').show();
        else
            $('#ddlShop').hide();
    });
    
//    =====================UPLOAD NHIỀU HÌNH ẢNH BẰNG AJAX============

    $('#photoimg').on('change', function(){
        var A=$("#imageloadstatus");
        var B=$("#imageloadbutton");
        $("#imageform").ajaxForm({target: '#preview',
        beforeSubmit:function(){
            A.show();
            B.hide();
        },
        success:function(data){
            A.hide();
            B.show();
        },
        error:function(){
            A.hide();
            B.show();
        } }).submit();
     });
});

    function replaceAll(str, src, dst) {
        while (str.indexOf(src) !== -1) {
            str = str.replace(src, dst);
        }
        return str;
    }

    function number_format(number, decimals, dec_point, thousands_sep) {
        var n = number, c = isNaN(decimals = Math.abs(decimals)) ? 2 : decimals;
        var d = dec_point == undefined ? "," : dec_point;
        var t = thousands_sep == undefined ? "." : thousands_sep, s = n < 0 ? "-" : "";
        var i = parseInt(n = Math.abs(+n || 0).toFixed(c)) + "", j = (j = i.length) > 3 ? j % 3 : 0;
        return s + (j ? i.substr(0, j) + t : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + t) + (c ? d + Math.abs(n - i).toFixed(c).slice(2) : "");
    }
    
    var focus = 'first';
    function changePhoto(id,i){
        $('.product-'+ id + ' ul li').attr('style','display:none');
        $('.product-'+ id + ' .photo-'+ focus +'-lg').hide();
        $('.product-'+ id + ' .photo-'+ i +'-lg').show();
        focus = i;
    }
    
    var focus = 0;
    function showMap(x,y,id,productId) {
    var address = $('#ddlShop .item-shop-' + id).attr('title');
    $('#diachigiaohang-'+productId).val(address);
    $('.item-shop-' + focus).removeClass('active');
    $('.item-shop-'+ id).addClass('active');
    $('#map-google-' + productId).fadeIn();
    $('.lmap-'+ focus).hide();
    $('.lmap-'+ id).show();
    var map;
    var myLatlng = new google.maps.LatLng(x, y);
    var myOptions = {
        zoom: 16,
        center: myLatlng,
        mapTypeId: google.maps.MapTypeId.ROADMAP
    }
    map = new google.maps.Map(document.getElementById("map-google-" + productId), myOptions);
   var infowindow = new google.maps.InfoWindow(
    {   
        size: new google.maps.Size(100,50),
        position: myLatlng
    });  
    var marker = new google.maps.Marker({
      position: myLatlng, 
      map: map,
      title:"Công Ty TNHH SV & TM WEAN"
  });
  focus = id;
} 
function hideMap(){
    $('.map-google').hide('500');
    $('.lmap-'+ focus).hide();
}