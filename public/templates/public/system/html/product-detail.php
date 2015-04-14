<div class="container">
    <div class="prodinfo">
        <div class="row">
            <?php
            $val = $this->Items;
            ?>
            <div class="col-md-12">
                <div class="prd-header-wrapper">
                    <div class="prod_header">
                        <div class="prod_header_main">
                            <div class="prod_header_title">
                                <h3 style="color: red"><?php echo $val['name'] ?></h3>
                            </div>
                            <div id="prod_brand">
                                <div class="prod_header_brand_action">
                                    Thương hiệu: <a href=""><?php echo $val['publisher'] ?></a> |
                                </div>
                                <div class="prod_header_brand_action">
                                    <a href="#">Thêm nệm cao su từ Wean</a>
                                </div>
                            </div>
                            <div class="prod_header_reviews">
                                <div class="review">
                                    <span><a href="#">(5 Đánh Giá Và Nhận Xét)</a></span>
                                </div>
                                <div class="prod_header_reviews_link action_link">
                                    <span class="glyphicon glyphicon-pencil"></span>
                                    <span><a href="#">Mời bạn đánh giá sản phẩm này</a></span>
                                </div>
                            </div>
                        </div>
                        <div class="prod_header_secondary">
                            <div class="product__header__wishlist">
                                <span class="fa fa-thumbs-o-up"></span>
                                <a href=""> Tôi Thích Sản Phẩm Này</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="col-md-10">
                    <div class="prd-main-wrapper">
                        <div class="cod-md-12">
                          <div class="images-zoom">
                            <img id="zoom_01" src="public/files/products/images450x450/<?php echo $val['picture']?>" data-zoom-image="public/files/products/orignal/<?php echo $val['picture']?>" width="412" height="300"/>
                                <div id="gal1">
                                  <?php
                                  $photos = json_decode($val['photos']);
                                  if(!empty($photos)){
                                       foreach ($photos as $i => $v) {
                                  ?>
                                  <a href="#" data-image="public/files/photos/images350x350/<?php echo $v ?>" data-zoom-image="public/files/photos/orignal/<?php echo $v ?>">
                                    <img id="zoom_01" src="public/files/photos/images50x50/<?php echo $v ?>" />
                                  </a>
                                  <?php
                                       }
                                  }
                                  ?>
                                </div>
                            </div>
                            <div class="prod_content_wrapper">
                                <div class="prod_l_content">
                                    <div class="prod_brief">
                                        <div class="prod_brief_warranty">
                                            <span style="font-size: 18px; font-weight: bold;">Thông Tin Sản Phẩm</span>                    
                                        </div>
                                    </div>
                                    <div class="prod_content">
                                        <div class="prod_details" itemprop="description">
                                            <ul class="prd-attributesList ui-listBulleted">
                                                <li class="fa fa-qrcode"><span> <strong>Mã sản phẩm:</strong> <?php echo $val['code'] ?></span></li>
                                                <li class="fa fa-home"><span> <strong>Nhà sản xuất: </strong><?php echo $val['publisher'] ?></span></li>
                                                <li class="fa fa-eye"><span> <strong>Số lần xem: </strong> <?php echo $val['hits'] ?></span></li><br>

                                                <li class="fa fa-wrench"><span> <strong>Bảo hành: </strong><?php echo $val['warranty'] ?></span></li>          
                                        </div>
                                    </div>
                                    <div id="product-price-box" class="prod_pricebox price_details">
                                        <div class="prod_pricebox_price">
                                            <div class="prod_pricebox_price_final">
                                                <span id="product_price" class="hidden">5789000.00</span>
                                                <span id="special_price_box">Giá: <?php echo $val['price'] ?> VND</span>
                                            </div>
                                            <div id="special_price_area" class=" prod_pricebox_price_special">
                                                <span id="product_special_price_label">Giá trước đây</span>
                                                <span class="price_erase">
                                                    <span id="product_price_prefix" class="price-prefix-detail"></span>
                                                    <span id="price_box"> <?php echo $val['selloff'] ?> VND</span>
                                                </span>
                                                <div class="prod_saving">
                                                    <span id="product_saving_label">Tiết kiệm</span>
                                                    <span id="product_saving_percentage" class="price_highlight"> 28%</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="manual_installments_buy">
                                            <a href="">Đặc biệt hỗ trợ trả góp 0%</a>
                                        </div>
                                        <label class="infopromotion">Khuyến mãi đến  <strong>200.000₫</strong> (Còn hơn 1 tháng)</label>
                                        <ul class="promotion-list"><li>Tặng Bộ Gối Cao Cấp (KM Hãng) (giá trị đến 430.000₫)</li>
                                            <li class="showbpglr"><span class="fa fa-eye"></span>Xem bộ ảnh sản phẩm khuyến mãi</li>
                                        </ul>
                                    </div>
                                    <div class="product-purchase-btn">
                                        <button class="ordered-on-demand" type="button">Đặt Hàng Theo Yêu Cầu<br><span>(Có ngay sản phẩm theo như ý)</span></button>
                                        <button class="installment-btn" type="button">Mua Trả Góp<br><span>(Mua Ngay Với Trả góp 0%)</span></button>
                                        <button class="cartFastLaneHead" type="button">Mua, Giao Tận Nơi<br><span>(Ngồi ở nhà, hàng tận tay)</span></button>
                                        <button class="buy-btn" type="button">Phương Thức Thanh Toán<br><span>(Nhanh chóng và tiện lợi)</span></button>
                                    </div>
                                    <p class="clr">
                                        Đặt mua qua ĐT (7:30 - 22:00): <strong style="color: red"><i class="icon-phone"></i> 1900.555.559</strong> (gọi miễn phí) - <strong style="color: red">(08)37.205.552</strong>
                                    </p>
                                    <ul class="policysale clr">
                                        <li>
                                            <span class="fa fa-check"></span>
                                            <i class="icon-poltick"></i>Nhận hàng miễn phí <strong>4 tiếng</strong>
                                            <a href="#" data-toggle="tooltip" title="4 tiếng trong phạm vi bán kính 50Km có siêu thị Wean<br>Các khu vực khác nhận hàng trong vòng 5 ngày"><span class="fa fa-clock-o"></span></a>
                                        </li>
                                        <li>
                                            <span class="fa fa-check"></span>
                                            <i class="icon-poltick"></i>Đổi trả trong vòng <strong>14 ngày</strong> với chính sách đặc biệt thuận lợi 
                                            <a href="#" data-toggle="tooltip" title="<strong>Sản Phẩm Bị Lỗi</strong><br>»14 ngày đầu đổi trả miễn phí<br>» 15 - 28 ngày trừ 20% giá mua"><span class="fa fa-clock-o"></span></a>
                                        </li>
                                        <li>
                                            <span class="fa fa-check"></span>
                                            <i class="icon-poltick"></i>Hoàn tiền hoặc trả hàng trong <strong>14 ngày</strong> nếu ở đâu bán rẻ hơn
                                            <a href="#" data-toggle="tooltip" title="Chúng tôi sẽ trả lại sản phẩm nếu ở đâu rẻ hơn"><span class="fa fa-clock-o"></span></a>
                                        </li>
                                        <li>
                                            <span class="fa fa-check"></span>
                                            <i class="icon-poltick"></i>Bảo hành chính hãng <strong>12 tháng</strong> 
                                            <a href="#" data-toggle="tooltip" title="Chúng tôi sẽ bảo hành tận nơi mà không tốn một chi phí nào"><span class="fa fa-clock-o"></span></a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div role="tabpanel">

                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs" role="tablist">
                                    <li role="presentation" class="active"><a href="#noidung1" aria-controls="home" role="tab" data-toggle="tab">Mô Tả</a></li>
                                    <li role="presentation"><a href="#noidung2" aria-controls="profile" role="tab" data-toggle="tab">Tính Năng</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="noidung1">
                                        <?php echo $val['info'] ?> 
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="noidung2"><?php echo $val['content'] ?> </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2">
                    <div class="prod_r_content">
                        <?php include_once 'includes/similar-product.php'; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div> 
<script type="text/javascript">
    $(function() {
        $('[data-toggle="tooltip"]').tooltip({
            html: true
        });
    });
    $("#zoom_01").elevateZoom({ gallery: 'gal1', cursor: 'pointer', galleryActiveClass: 'active', imageCrossfade: true, loadingIcon: '' });
    //pass the images to Fancybox 
    $("#zoom_01").bind("click", function (e) { var ez = $('#zoom_01').data('elevateZoom'); $.fancybox(ez.getGalleryList()); return false; });
</script>