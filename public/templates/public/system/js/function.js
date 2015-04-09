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
        var id = $(this).data('id');
        var number = $(this).val();
        var price = parseInt($('.price-' + id).text());
        var selloff = parseInt($('.selloff' + id).text());
        if (selloff > 0)
            $('.total-amount-' + id).text(selloff * number);
        else
            $('.total-amount-' + id).text(price * number);
        $.ajax({
            url: 'cart/change-number',
            type: 'POST',
            cache: false,
            data: {
                id: $(this).data('id'),
                value: number
            },
            success: function(data) {
                console.log(data);
//                    $('.home_sanpham_right').html(data);
            }
        });
    });
});