<script>
    $('document').ready(function() {
        $('.hover').hover(function() {
            $('.info-' + $(this).data('id')).attr('style', 'display:inline');
            $('.info-' + $(this).data('id') + ' .buy').attr('style', 'display:inline');
            $('.info-' + $(this).data('id') + '+ .nk_discount').attr('style', 'display:none');
        }, function() {
            $('.info-' + $(this).data('id')).attr('style', 'display:none');
            $('.info-' + $(this).data('id') + ' .buy').attr('style', 'display:none');
            $('.info-' + $(this).data('id') + '+ .nk_discount').attr('style', 'display:inline');
        });
    });
</script>
<div class="bg_white home_sanpham_right">
    <div class="show2"> 
        <div class="content _tab-01 tab_link-01_01"> 
            <ul>
                    <?php
//                       echo '<pre>';
//                       print_r($this->Items);
//                       echo '</pre>';
                     ?>
             <?php
             foreach ($this->Items as $key =>$val){ 
             ?>  
                  <li class="sp_pro relative hover" data-id="1">
                    <div class="khung relative">
                        <div class="ttprod">
                            <div class="float_l chitiet"><a href=""><span>Chi tiết</span></a></div>
                            <div class="bg_comparison_tr"><span id="ss_70095598_0" class="myicon btn-ss">So sánh</span></div>
                        </div>
                        <a href="" class="bnc_tooltips">
                            <img src="<?php echo $this->baseUrl('public/files/products/orignal/') . $val['picture'] ?>" alt="Tên Sản Phẩm">
                        </a>
                    </div>
                    <div class="thongtin">
                        <h3><a id="tenss_70095598" class="ten_sp tip" title="<?php echo $val['name'] ?>" ref=""><?php echo $val['name'] ?></a></h3>

                        <p class="gia_cu"><?php echo $val['selloff'] ?></p>
                        <p class="gia_moi"><?php echo $val['price'] ?></p>
                        <div class="clear"></div>
                    </div>
                    <div class="btn-function">
                        <div class="btnxemnhanh">
                            <a id="id_70095598" href="" title="Xem nhanh">
                                <span class="xemnhanh">Xem nhanh</span>
                                <span class="glyphicon glyphicon-eye-open"></span>
                            </a>
                        </div>
                        <div id="ss_70095598_0" class="myicon btn-ss btnxemnhanh" title="So sánh">
                            <a id="id_70095598" href="" title="Xem nhanh">
                                <span>So sánh</span>
                                <i class="glyphicon glyphicon-transfer"></i>
                            </a>
                        </div>
                    </div>
                    <div class="info info-1" style="display:none">
                        <span>
                            Mã sản phẩm: NCSVTV01<br>	
                            Nhà sản xuất: Nệm Vạn Thành<br>	
                            Số lần xem: 466<br>			
                            Bảo hành: 7 năm <br>
                        </span>
                    </div>
                </li>   
             <?php
             }
             ?>
    
            </ul>  
        </div>
    </div>
    <div class="clear"></div>
</div>