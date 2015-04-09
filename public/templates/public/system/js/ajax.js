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