function huycm(friId,id){
        $.ajax({
           url: 'cart/delete',
           type: 'POST',
           data: {
               friId: friId,
               id: id
           },
           cache: false,
           success: function(){
           $flag =confirm('Bạn có muốn xóa sản phẩm này khỏi giỏ hàng không?')
			if($flag==true){
                            if(id>0){
				$('.yourCart tr#' + id).fadeOut('slow');
                                $('#cart_loader #gio_hang_sp_' + id).fadeOut('slow');
                                var divname = '#gio_hang_sp_' + id;
                                 var price = parseInt(replaceAll($(divname).find('h2').text().replace('đ', ''), ',', '')) * parseInt($('.sluong_' + id).text());
                            }
                            else{
                                $('.yourCart tr#' + friId).fadeOut('slow');
                                $('#cart_loader #gio_hang_sp_' + friId).fadeOut('slow');
                                var divname = '#gio_hang_sp_' + friId;
                                var price = parseInt(replaceAll($(divname).find('h2').text().replace('đ', ''), ',', '')) * parseInt($('.sluong_' + friId).text());
                            }
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
                if (data.success == 1){
                    window.location = 'default/admin/index';
                }
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
            url: "default/public/register",
            type: "post",
            dataType: "json",
            data: {
                last_name : name,
                phone: phone,
                email: email,
                password: password,
                re_password : rePassword,
                birthday: birthday
            },
            success: function(data, status) {
                console.log(data);
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
                if(data.success==1){
                    $('.register-success').modal("show");
                    setTimeout(function(){
                        $('.register-success').modal("hide");
                    },5000);
                }
            }
        });
    };
    
    function datMua(id){
        var full_name = $('#full_name-'+ id).val();
        var phone = $('#phoneMuaHang-' + id).val();
        var id = $('#id-' + id).val();
        var size = $('#size-' +id).val();
        var address = $('#diachigiaohang-' + id).val();
        $.ajax({
           type: "post",
           url: "default/cart/order-detail",
           cache: false,
           data: {
               id: id,
               size: size,
               full_name: full_name,
               phone: phone,
               address: address
           },
           beforeSend: function(jqXHR, setting){
               if(full_name == ""){
                   $('#full_name-'+ id +' i + span').remove();
                   $('#full_name-'+ id +' + i').after('<span style="color:red"><br>(*)Họ và Tên không được rỗng</span>');
                   return false;
               }
               else{
                   $('#full_name-'+ id +' span').remove();
               }
               if(phone == ""){
                   $('#phoneMuaHang-'+ id + ' + i span').remove();
                   $('#phoneMuaHang-'+ id +' + i').after('<span style="color:red"><br>(*)Số điện Thoại Không được rỗng</span>');
                   return false;
               }
               else{
                   $('#phoneMuaHang-'+ id + ' + i span').remove();
               }
               if(full_name != "" && phone != "")
                   return true;
           },
           success: function(data, status){
       console.log(data);
               $('.datmua').modal('show');
               $('#ten-nguoi-mua').text(full_name);
               setTimeout(function(){
                   location.reload(true);
               },5000);
           }
        });
    }
    
    function datMuaNhieu(){
        var full_name = $('#full_name').val();
        var phone = $('#phoneMuaHang').val();
        var address = $('#address').val();
        $.ajax({
           type: "post",
           url: "cart/order-detail",
           cache: false,
           data: {
               full_name: full_name,
               phone: phone,
               address: address
           },
           beforeSend: function(jqXHR, setting){
               if(full_name == ""){
                   $('#full_name i + span').remove();
                   $('#full_name + i').after('<span style="color:red"><br>(*)Họ và Tên không được rỗng</span>');
                   return false;
               }
               else{
                   $('#full_name span').remove();
               }
               if(phone == ""){
                   $('.pform-inline span').remove();
                   $('#phoneMuaHang + i').after('<span style="color:red"><br>(*)Số điện Thoại Không được rỗng</span>');
                   return false;
               }
               else{
                   $('.pform-inline span').remove();
               }
               if(full_name != "" && phone != "")
                   return true;
           },
           success: function(data, status){
       console.log(data);
               $('.datmua').modal('show');
               $('#ten-nguoi-mua').text(full_name);
               setTimeout(function(){
                   location.reload(true);
               },5000);
           }
        });
    }
   
   function traGop(){
       var id = parseInt($('#id').val());
       var full_name = $('#full_name').val();
       var phone = $('#phoneMuaHang').val();
       var address = $('#diachigiaohang-' + id).val();
       var traTruoc = parseInt($('#tratruoc').text());
       var kyHanTraGop = parseInt($('#kyhan').text());
       if($('.col3-itm').is('#laisuat-acs')== true)
            var laiSuat = parseInt($('#laixuat-acs').text());
       else
           var laiSuat = 0;
       $.ajax({
           type: "post",
           url: "default/cart/order-detail",
           cache: false,
          data: {
              id : id,
              address: address,
              tratruoc: traTruoc,
              kyhantragop: kyHanTraGop,
              laisuat: laiSuat,
              full_name: full_name,
              phone: phone
          },
          beforeSend: function(jqXHR, setting){
               if(full_name == ""){
                   $('#full_name i + span').remove();
                   $('#full_name + i').after('<span style="color:red"><br>(*)Họ và Tên không được rỗng</span>');
                   return false;
               }
               else{
                   $('#full_name span').remove();
               }
               if(phone == ""){
                   $('.pform-inline span').remove();
                   $('#phoneMuaHang + i').after('<span style="color:red"><br>(*)Số điện Thoại Không được rỗng</span>');
                   return false;
               }
               else{
                   $('.pform-inline span').remove();
               }
               if(full_name != "" && phone != "")
                   return true;
           },
           success: function(data, status){
                console.log(data);
           }
       });
   }