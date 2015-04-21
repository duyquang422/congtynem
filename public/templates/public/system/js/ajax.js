function huycm($id){
        $.ajax({
           url: 'cart/delete',
           type: 'POST',
           data: {
               id: $id
           },
           cache: false,
           success: function(){
           $flag =confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng không?')
			if($flag==true){
				$('.yourCart tr#' + $id).fadeOut('slow');
                                $('#cart_loader #gio_hang_sp_' + $id).fadeOut('slow');
                                var divname = '#gio_hang_sp_' + $id;
                                var price = parseInt(replaceAll($(divname).find('h2').text().replace('đ', ''), ',', '')) * parseInt($('.sluong_' + $id).text());
                                var total = parseInt(replaceAll($('#gio_hang_tong').text().replace('đ', ''), ',', '')) - price;
                                $('#gio_hang_tong').text(number_format(total, 0, ',', ',') + ' đ');
			}
           }
        });
}

function changesize(id){
//        alert(id);
        var price = $('.form-control-' + id).val();
        var size = $('.form-control-' + id + ' option[value="'+ price + '"').text();
        $('#number-' + id).val(1);
        var number = parseInt($('#number-' + id).val());
        $('.price-' + id).text(price);
        $('.total-amount-' + id).text(price);
        $.ajax({
            url: 'cart/change-size',
            type: 'POST',
            cache: false,
            data: {
                id: id,
                price: price,
                size: size
            },
            success: function(data) {
                console.log(data);
//                    $('.home_sanpham_right').html(data);
            }
        });

}

   function login() {
        var email = $('.email-login').val();
        var password = $('.password-login').val();
        $.ajax({
            url: "default/public/login?email=" + email + "&password=" + password,
            type: "GET",
            dataType: "json",
            success: function(data, status) {
                $('#email-login + span').remove();
                $('#password-login + span').remove();
                if (typeof(data.email) != "undefined") {
                    $('#email-login').after('<span style="color:red">(*) ' + data.email + '<span>');
                }
                if (typeof(data.password) != "undefined") {
                    $('#password-login').after('<span style="color:red">(*) ' + data.password + '<span>');
                }
                if (typeof(data.loginError) != "undefined")
                    $('#password-login').after('<span style="color:red">(*) ' + data.loginError + '<span>');
                if (data.success == 1)
                    window.location = 'default/admin/index';
            }
        });
    };
   function signIn() {
        var name = $('.name').val();
        var email = $('.email').val();
        var phone = $('.user-phone').val();
        var password = $('.password').val();
        var rePassword = $('.re-password').val();
        var birthday = $('.birthday').val();
        $.ajax({
            url: "default/public/register?last_name="+ name +" &phone=" + phone + "&email=" + email + "&password=" + password + "&re-password=" + rePassword + "&birthday=" + birthday,
            type: "GET",
            dataType: "json",
            success: function(data, status) {
                console.log(data);
                console.log(status);
                $('#name + span').remove();
                $('#email + span').remove();
                $('#phone + span').remove();
                $('#password + span').remove();
                $('#re-password + span').remove();
                if (typeof(data.email) != "undefined") {
                    $('#email').after('<span style="color:red">(*) ' + data.email + '</span>');
                }
                if (typeof(data.password) != "undefined") {
                    $('#password').after('<span style="color:red">(*) ' + data.password + '</span>');
                }
                if (typeof(data.last_name) != "undefined"){
                    $('#name').after('<span style="color:red">(*) ' + data.last_name + '</span>');
                }
                if (typeof(data.re_password) != "undefined"){
                    $('#re-password').after('<span style="color:red">(*) ' + data.re_password + '</span>');
                }
                if (typeof(data.phone) != "undefined"){
                    $('#phone').after('<span style="color:red">(*) ' + data.phone + '</span>');
                }
                if(data.success==1)
                    $('#birthday').after('<span style="color:green">(*) Bạn Đã Đăng Ký Thành Công. Hãy Đăng Nhập Để Được Nhận Nhiều Ưu Đãi!<span>');
                //window.location = '<?php //echo $this->baseUrl()?>' + '/default/admin/index/';
            }
        });
    };