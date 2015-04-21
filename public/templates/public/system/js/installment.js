$(function(){
   //    ===========================INSTALLMENT=======================

    var price = parseInt(replaceAll($('#price').text().replace('đ', ''), ',', ''));
    var val = $('#tra-truoc-itm').val();
    $('#tratruoc-acs').text(numeral(val * price /100).format('0,0'));
    var stratruoc = parseInt(replaceAll($('#tratruoc-acs').text().replace('đ', ''), ',', ''));
    var sgop = $('#gop-itm').val();
    var slaixuat = $('#laixuat-acs').text();
    $('#gop-acs').text(numeral(parseInt(((price-stratruoc)/sgop) + (slaixuat * price / 100))).format('0,0'));
    var stragop = $('#gop-acs').text();
    
    $('#tratruoc').text(val + '%' + ' với ').after('<strong>'+ numeral(stratruoc).format('0,0') +' đ</strong>');
    $('#kyhan').text(sgop + ' tháng' + ' với ').after('<strong>'+ stragop +' đ/tháng</strong>');
    if($('.col3-itm').is('#laisuat-acs')== true)
            $('#laisuat').text(parseInt($('#laixuat-acs').text()));
       else
           $('#laisuat').text('0%');
//    
    $('#tra-truoc-itm').change(function(){
       var agop = parseInt($('#gop-itm').val());
       var value = $(this).val();
       var tratruoc = value * price / 100;
       
       if(value <= 30)
            $('#laixuat-acs').text(2.45);
       else
            $('#laixuat-acs').text(2.2);
        
        
        var laixuat = $('#laixuat-acs').text();
        
        
        $('#tratruoc-acs').text(numeral(tratruoc).format('0,0'));
        $('#gop-acs').text(numeral(parseInt(((price-tratruoc)/agop) + (laixuat * price / 100))).format('0,0'));
        
        var atienTraTruoc = parseInt(replaceAll($('#tratruoc-acs').text().replace('đ', ''), ',', ''));
        var atragop = parseInt(replaceAll($('#gop-acs').text().replace('đ', ''), ',', ''));
        $('#tong-acs').text(numeral(atragop * agop + atienTraTruoc).format('0,0'));
        
        $('#tratruoc + strong').remove();
        $('#kyhan + strong').remove();
        $('#laisuat + strong').remove();
        
        $('#tratruoc').text(value + '%' + ' với ').after('<strong>'+ numeral(atienTraTruoc).format('0,0') +' đ</strong>');
        $('#kyhan').text(agop + ' tháng' + ' với ').after('<strong>'+ numeral(atragop).format('0,0') +' đ/tháng</strong>');
        if($('.col3-itm').is('#laisuat-acs')== true)
            $('#laisuat').text(parseInt($('#laixuat-acs').text()));
       else
           $('#laisuat').text('0%');
    });
    
    $('#gop-itm').change(function(){
        var tragop = parseInt(replaceAll($('#gop-acs').text().replace('đ', ''), ',', ''));
        var tratruoc = parseInt(replaceAll($('#tratruoc-acs').text().replace('đ', ''), ',', ''));
        var value = parseInt($('#tra-truoc-itm').val());
        var tratruoc = value * price / 100;
        var laixuat = $('#laixuat-acs').text();
        var gop = parseInt($(this).val());
        var tienTraTruoc = parseInt(replaceAll($('#tratruoc-acs').text().replace('đ', ''), ',', ''));
        $('#gop-acs').text(numeral(parseInt(((price-tratruoc)/gop) + (laixuat * price / 100))).format('0,0'));
        var tragop = parseInt(replaceAll($('#gop-acs').text().replace('đ', ''), ',', ''));
        $('#tong-acs').text(numeral(tragop * gop + tienTraTruoc).format('0,0'));
        
        $('#tratruoc + strong').remove();
        $('#kyhan + strong').remove();
        $('#laisuat + strong').remove();
        $('#tratruoc').text(value + '%' + ' với ').after('<strong>'+ numeral(tienTraTruoc).format('0,0') +' đ</strong>');
        $('#kyhan').text(gop + ' tháng' + ' với ').after('<strong>'+ numeral(tragop).format('0,0') +' đ/tháng</strong>');
        if($('.col3-itm').is('#laisuat-acs')== true)
            $('#laisuat').text(parseInt($('#laixuat-acs').text()));
       else
           $('#laisuat').text('0%');
    });
    var bgop = $('#gop-itm').val();
    var btragop = parseInt(replaceAll($('#gop-acs').text().replace('đ', ''), ',', ''));
    var btratruoc = parseInt(replaceAll($('#tratruoc-acs').text().replace('đ', ''), ',', ''));
    $('#tong-acs').text(numeral(btragop * bgop + btratruoc).format('0,0')); 
    
    
    //    =====================UPLOAD NHIỀU HÌNH ẢNH BẰNG AJAX============

    $('.upload-hoso').hide();
    $('#photoimg').on('change', function(){
        var A=$("#imageloadstatus");
        var B=$("#imageloadbutton");
        $("#imageform").ajaxForm({target: '#preview',
        beforeSubmit:function(){
            A.show();
            B.hide();
        },
        success:function(){
            $('#imageform').hide();
            $('.datmua').modal('show');
            setTimeout(function(){
                   window.location = 'http://congtynem.com/vn';
               },5000);
        },
        error:function(){
            A.hide();
            B.show();
        } }).submit();
     });
});