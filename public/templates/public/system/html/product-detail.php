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
                                <img id="zoom_01" src="public/files/products/images450x450/<?php echo $val['picture'] ?>" data-zoom-image="public/files/products/orignal/<?php echo $val['picture'] ?>" width="412" height="300"/>
                                <div id="gal1">
                                    <?php
                                    $photos = json_decode($val['photos']);
                                    if (!empty($photos)) {
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
                                                <span id="special_price_box">Giá: 
                                                    <?php
                                                    if ($val['val_sell'] > 0)
                                                        echo number_format($val['selloff'], 0);
                                                    else
                                                        echo number_format($val['price'], 0);
                                                    ?> VND</span>
                                            </div>
                                            <div id="special_price_area" class=" prod_pricebox_price_special">
                                                <?php
                                                if ($val['selloff'] > 0) {
                                                    ?>
                                                    <span id="product_special_price_label">Giá trước đây</span>
                                                    <span class="price_erase">
                                                        <span id="product_price_prefix" class="price-prefix-detail"></span>
                                                        <span id="price_box"> <?php echo $val['selloff'] ?> VND</span>
                                                    </span>
                                                    <div class="prod_saving">
                                                        <span id="product_saving_label">Tiết kiệm</span>
                                                        <span id="product_saving_percentage" class="price_highlight"> 28%</span>
                                                    </div>
                                                    <?php
                                                }
                                                ?>
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
                                        <a href="<?php echo $this->baseUrl($val['id'] . '.aspx') ?>"><button class="installment-btn" type="button">Mua Trả Góp<br><span>(Mua Ngay Với Trả góp 0%)</span></button></a>
                                        <button class="cartFastLaneHead" type="button" data-toggle="modal" data-target=".buy-now">Mua, Giao Tận Nơi<br><span>(Ngồi ở nhà, hàng tận tay)</span></button>
                                        <a href='#noidung3'><button class="buy-btn" type="button">Phương Thức Thanh Toán<br><span>(Nhanh chóng và tiện lợi)</span></button></a>
                                    </div>

                                    <!---------------------Modal MUA GIAO HÀNG TẬN NƠI-------------------->
                                    <div class="modal fade buy-now" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-lg">
                                            <div class="modal-content">
                                                <div class="ppu_header">
                                                    <p class="ppu_h_title">ĐẶT HÀNG - NGHE TƯ VẤN MIỄN PHÍ</p>
                                                    <p class="ppu_h_noti">(Không mua không sao)</p>
                                                </div>
                                                <div class="ppu_tabs_main">
                                                    <!-- clear html when click list maps, changer to div.ppu_ss_main -->
                                                    <!-- TAB MENU-->
                                                    <div class="ppu_tab">
                                                        <div class="ppu_tabshop current" key="1"><span>Đặt giữ hàng tại shop </span></div>
                                                        <div class="ppu_tabhome" key="2"><span>Giao hàng miễn phí tại nhà </span></div>
                                                    </div>
                                                    <!-- #1 TAB HOME-->
                                                    <div class="ppu_content" id="ppu-tab-home">
                                                        <div class="ppu_tab_content clearfix">
                                                            <!-- LEFT TAB-->
                                                            <div class="ppu_tab_left">
                                                                <div class="ppu_tab_left_content">
                                                                    <div class="clearfix">
                                                                        <div class="ppu_tab_proimg">
                                                                            <img src="public/files/products/images100x100/<?php echo $val['picture'] ?>" alt="">
                                                                        </div>

                                                                        <div class="ppu_tab_pro_info">
                                                                            <h3 class="ppu_tab_pro_name"><?php echo $val['name'] ?></h3>
                                                                            <p class="lineprice">
                                                                                <span class="ppu_tab_pro_price" data-currentid="36865" data-money="10990000">
                                                                                    <?php
                                                                                    if ($val['selloff'] == 0)
                                                                                        echo number_format($val['price'], 0);
                                                                                    else
                                                                                        echo number_format($val['selloff'], 0);
                                                                                    ?>

                                                                                </span><span>&nbsp;đ</span>
                                                                            </p>
                                                                            <div class="ppu_tab_pro_sales">
                                                                                <div class="ppu_tab_psales">Khuyến mãi đi kèm</div>
                                                                                <div class="ppu_tab_color_img">
                                                                                    <img class="ppu_tab_cimg_arow" src="public/files/products/images100x100/<?php echo $val['picture'] ?>">
                                                                                    <div class="ppu_tab_cimg_main">
                                                                                        <p style="font-size: 14px; line-height: 24px; color: red; font-family:tahoma,geneva,sans-serif;">Đặt ngay tặng kèm:</p>

                                                                                        <ul>
                                                                                            <li style="font-size: 14px; line-height: 24px; color: red; font-family:tahoma,geneva,sans-serif;">Phiếu mua hàng phụ kiện&nbsp;<b>500.000đ</b></li>
                                                                                        </ul>

                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="clearfix"></div>
                                                                        <div class="ppu_add_shop">
                                                                            <p class="ppu_add_shop_title">Chọn địa chỉ Shop</p>
                                                                            <div class="ppu_local_box clearfix">
                                                                                <div class="ppu_adds_city">
                                                                                    <select id="ddlCity" name="city" class="sl-item-2 list-city">
                                                                                        <option selected="selected" value="0">Chọn Tỉnh</option>
                                                                                        <option value="1">TP Hồ Chí Minh</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <div class="ppu_adds_list">
                                                                                <ul id="ddlShop">
                                                                                    <li title="156 Đặng Văn Bi - Q. Thủ Đức" class="item-shop item-shop-1" onclick="showMap(10.846783, 106.760974, 1,<?php echo $val['id']?>)">156 Đặng Văn Bi - Q. Thủ Đức<p></p></li>
                                                                                    <li title="974 Kha Vạn Cân - Q. Thủ Đức" class="item-shop item-shop-2" onclick="showMap(10.857691, 106.757349, 2,<?php echo $val['id']?>)">974 Kha Vạn Cân - Q. Thủ Đức<p></p></li>
                                                                                    <li title="263 Lê Văn Việt - Q. 9" class="item-shop item-shop-3" onclick="showMap(10.844651, 106.790530, 3,<?php echo $val['id']?>)">263 Lê Văn Việt - Q. 9<p></p></li>
                                                                                </ul>
                                                                            </div>
                                                                            <div class="ppu_tab_lmap_title lmap-1" style="display:none">
                                                                                <img src="<?php echo $this->imgUrl ?>/ppu_icon_map.png">
                                                                                <span id="chooseShopStoreID">Showroom 156 Đặng Văn Bi - Q. Thủ Đức</span>
                                                                                <span class="ppu_tab_lmap_close">
                                                                                    <img src="<?php echo $this->imgUrl ?>/ppu_close_map.png" onclick="hideMap()">
                                                                                </span>
                                                                            </div>
                                                                            <div class="ppu_tab_lmap_title lmap-2" style="display:none">
                                                                                <img src="<?php echo $this->imgUrl ?>/ppu_icon_map.png">
                                                                                <span id="chooseShopStoreID">Showroom 974 Kha Vạn Cân - Q. Thủ Đức</span>
                                                                                <span class="ppu_tab_lmap_close">
                                                                                    <img src="<?php echo $this->imgUrl ?>/ppu_close_map.png" onclick="hideMap()">
                                                                                </span>
                                                                            </div>
                                                                            <div class="ppu_tab_lmap_title lmap-3" style="display:none">
                                                                                <img src="<?php echo $this->imgUrl ?>/ppu_icon_map.png">
                                                                                <span id="chooseShopStoreID">Showroom 263 Lê Văn Việt - Q. 9</span>
                                                                                <span class="ppu_tab_lmap_close">
                                                                                    <img src="<?php echo $this->imgUrl ?>/ppu_close_map.png" onclick="hideMap()">
                                                                                </span>
                                                                            </div>
                                                                            <div id="map-google-<?php echo $val['id']?>" class="map-google" style="width: 400px;  height: 258px; position: absolute; display: none;"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- RIGHT TAB-->
                                                            <div class="ppu_tab_right">
                                                                <div class="ppu_tab_right_box">
                                                                    <input type="hidden" value="<?php echo $val['id'] ?>" name="id" id="id-<?php echo $val['id'] ?>">
                                                                    <input type="hidden" value="<?php echo $val['size'] ?>" name="size" id="size-<?php echo $val['id'] ?>">
                                                                    <input type="hidden" value="" name="address" id="diachigiaohang-<?php echo $val['id'] ?>">
                                                                    <span style="color:red">(*) Bạn buộc phải nhập thông tin vào!</span>
                                                                    <p class="pform-inline">
                                                                        <input name="full_name" id="full_name-<?php echo $val['id']?>" class="ppu_rtxt" type="text" placeholder="Họ tên bạn" data-rule-required="true">
                                                                        <i>*</i>
                                                                    </p>
                                                                    <p class="pform-inline">
                                                                        <input id="phoneMuaHang-<?php echo $val['id']?>" name="phone" id="phone" class="ppu_rtxt" type="text" placeholder="Số điện thoại" data-rule-required="true">
                                                                        <i>*</i>
                                                                    </p>
                                                                    <textarea name="address" id="address" class="ppu_rtextarea" placeholder="Địa chỉ giao hàng"></textarea>
                                                                    <div class="ppu_tab_tt_price">Tổng giá trị đơn hàng: <span class="textTotalMoney">
                                                                            <?php
                                                                            if ($val['selloff'] > 0)
                                                                                echo number_format($val['selloff'], 0);
                                                                            else {
                                                                                echo number_format($val['price'], 0);
                                                                            }
                                                                            ?>
                                                                        </span>&nbsp;đ</div>
                                                                    <a href="<?php echo $this->baseUrl('default/cart/add-item/priID/') . $val['id'] ?>">
                                                                        <div class="ppu_rbnt_addcart">
                                                                            Giỏ Hàng
                                                                        </div>
                                                                    </a>
                                                                    <button class="ppu_rbnt_submit" onclick="datMua(<?php echo $val['id'] ?>)"> Đặt Ngay</button>

                                                                </div>
                                                            </div>
                                                        </div>

                                                        <!-- BOTTOM TAB-->
                                                        <div class="ppu_bottom_noti">
                                                            <p>Chúng tôi sẽ liên hệ với bạn trong vòng <strong>1 tiếng</strong>  và cam kết giao hàng miễn phí trong <strong>1 ngày</strong>.</p>
                                                            <p class="ppu_bt_call">Tư vấn miễn phí: <strong>0917 311 001</strong></p>
                                                        </div>

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <p class="clr">
                                        Đặt mua qua ĐT (7:30 - 22:00): <strong style="color: red"><i class="icon-phone"></i> 1900.555.559</strong> (gọi miễn phí) - <strong style="color: red">(08)37.205.552</strong>
                                    </p>
                                    <ul class="policysale clr">
                                        <li>
                                            <span class="fa fa-check"></span>
                                            <i class="icon-poltick"></i>Nhận hàng miễn phí <strong>4 tiếng</strong>
                                            <a href="#" data-toggle="tooltip" title="<div style='width:320px'>»4 tiếng trong phạm vi bán kính 50Km có siêu thị Wean<br>»Các khu vực khác nhận hàng trong vòng 5 ngày</div>"><span class="fa fa-clock-o"></span></a>
                                        </li>
                                        <li>
                                            <span class="fa fa-check"></span>
                                            <i class="icon-poltick"></i>Đổi trả trong vòng <strong>14 ngày</strong> với chính sách đặc biệt thuận lợi 
                                            <a href="#" data-toggle="tooltip" title="<strong>Sản Phẩm Bị Lỗi</strong><br>»14 ngày đầu đổi trả miễn phí<br>»15 - 28 ngày trừ 20% giá mua"><span class="fa fa-clock-o"></span></a>
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
                                    <li role="presentation" class="active"><a href="#noidung1" aria-controls="home" role="tab" data-toggle="tab">Mô Tả Tính Năng</a></li>
                                    <li role="presentation"><a href="#noidung2" aria-controls="profile" role="tab" data-toggle="tab">Bảng Giá Cho Kích Thước</a></li>
                                    <li role="presentation"><a href="#noidung3" aria-controls="profile" role="tab" data-toggle="tab">Thanh Toán</a></li>
                                </ul>

                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div role="tabpanel" class="tab-pane active" id="noidung1">
                                        <?php echo $val['content'] ?> 
                                    </div>
                                    <div role="tabpanel" class="tab-pane" id="noidung2">
                                        <?php
                                        $itemPrice = $this->Price_pro;
                                        if (!empty($itemPrice)) {
                                            ?>
                                            <div class='tab_main'>
                                                <table class='tab_price'>
                                                    <thead>
                                                        <tr>
                                                            <th width="23%">Quy cách</th>
                                                            <th width="20%">Giá gốc (Vnd)</th>
                                                            <th width="20%">Giá bán (Vnd)</th>
                                                            <th width="18%">Giảm (%)</th>
                                                            <th>Mua hàng</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php
                                                        $i=4;
                                                        foreach ($itemPrice as $keyPri => $valPri) {
                                                            $size = $valPri['size'];
                                                            if ($valPri['unit_name'] == 1)
                                                                $unit_name = 'Meters';
                                                            if ($valPri['unit_name'] == 2)
                                                                $unit_name = 'Centimeters';
                                                            if ($valPri['unit_name'] == 3)
                                                                $unit_name = 'Millimeters';
                                                            $pri_pro = $valPri['price'];
                                                            $val_sell_pro = $valPri['val_sell'];
                                                            $sale_pro = $valPri['selloff'];
                                                            if (empty($sale_pro))
                                                                $sale_pro = $pri_pro;

                                                            if (!empty($valPri['val_sell']) || $valPri['val_sell'] != 0) {
                                                                $val_sell_pro = $valPri['val_sell'];
                                                                $sale_pro = $valPri['selloff'];
                                                            }
                                                            if ((!empty($item['val_sell']) || $item['val_sell'] != 0) && (empty($valPri['val_sell']) || $valPri['val_sell'] == 0)) {
                                                                $val_sell_pro = $item['val_sell'];
                                                                $sale_pro = $valPri['price'] - ($valPri['price'] * $item['val_sell'] / 100);
                                                            }
                                                            if ((empty($item['val_sell']) || $item['val_sell'] == 0) && (empty($valPri['val_sell']) || $valPri['val_sell'] == 0)) {
                                                                if (!empty($sale)) {
                                                                    $val_sell_pro = $sale;
                                                                    $sale_pro = $valPri['price'] - ($valPri['price'] * $sale / 100);
                                                                }
                                                            }
                                                            $linkCartPro = $this->baseUrl('default/cart/add-item/priID/') . $val['id'] . '/id/' . $valPri['id'] . '/size/' . $size . '/price/' . $valPri['price'] . '/selloff/' . $valPri['selloff'];
                                                            ?>
                                                            <tr>
                                                                <td class='size_pro'><?php echo $size ?></td>
                                                                <td><?php echo number_format($pri_pro, 0) ?></td>
                                                                <td class='sale_pro'><?php echo number_format($sale_pro, 0) ?></td>
                                                                <td><?php echo $val_sell_pro ?></td>
                                                                <td><a class='cart_pro' target="_blank" data-toggle="modal" data-target=".muahang-<?php echo $keyPri ?>">Mua hàng</a></td>
                                                            </tr>
                                                        <div class="modal fade muahang-<?php echo $keyPri ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                            <div class="modal-dialog modal-lg">
                                                                <div class="modal-content">
                                                                    <div class="ppu_header">
                                                                        <p class="ppu_h_title">ĐẶT HÀNG - NGHE TƯ VẤN MIỄN PHÍ</p>
                                                                        <p class="ppu_h_noti">(Không mua không sao)</p>
                                                                    </div>
                                                                    <div class="ppu_tabs_main">
                                                                        <!-- clear html when click list maps, changer to div.ppu_ss_main -->
                                                                        <!-- TAB MENU-->
                                                                        <div class="ppu_tab">
                                                                            <div class="ppu_tabshop current" key="1"><span>Đặt giữ hàng tại shop </span></div>
                                                                            <div class="ppu_tabhome" key="2"><span>Giao hàng miễn phí tại nhà </span></div>
                                                                        </div>
                                                                        <!-- #1 TAB HOME-->
                                                                        <div class="ppu_content" id="ppu-tab-home">
                                                                            <div class="ppu_tab_content clearfix">
                                                                                <!-- LEFT TAB-->
                                                                                <div class="ppu_tab_left">
                                                                                    <div class="ppu_tab_left_content">
                                                                                        <div class="clearfix">
                                                                                            <div class="ppu_tab_proimg">
                                                                                                <img src="public/files/products/images450x450/<?php echo $val['picture'] ?>" alt="">
                                                                                            </div>

                                                                                            <div class="ppu_tab_pro_info">
                                                                                                <ul>
                                                                                                    <li><?php echo $val['name'] ?></li>
                                                                                                    <li><?php echo 'Kích thước: ' . $valPri['size']?></li>
                                                                                                    <li>
                                                                                                        Giá chỉ 
                                                                                                        <?php
                                                                                                        if ($valPri['selloff'] == 0)
                                                                                                            echo '<strong style="color:red; font-size:17px">' . number_format($valPri['price'], 0). '</strong>';
                                                                                                        else
                                                                                                            echo '<strong style="color:red; font-size:17px">' .number_format($valPri['selloff'], 0) . '</strong>';
                                                                                                        ?>
                                                                                                        đ
                                                                                                    </li>
                                                                                                    <li style="color:red; text-decoration: underline">Quà tặng kèm theo</li>
                                                                                                </ul>
                                                                                            </div>
                                                                                            <div class="clearfix"></div>
                                                                                            <div class="ppu_add_shop">
                                                                                                <p class="ppu_add_shop_title">Chọn địa chỉ Shop</p>
                                                                                                <div class="ppu_local_box clearfix">
                                                                                                    <div class="ppu_adds_city">
                                                                                                        <select id="ddlCity" name="city" class="sl-item-2 list-city">
                                                                                                            <option selected="selected" value="0">Chọn Tỉnh</option>
                                                                                                            <option value="1">TP Hồ Chí Minh</option>
                                                                                                        </select>
                                                                                                    </div>
                                                                                                </div>
                                                                                                <div class="ppu_adds_list">
                                                                                                    <ul id="ddlShop">
                                                                                                        <li title="156 Đặng Văn Bi - Q. Thủ Đức" class="item-shop item-shop-<?php echo $a = $i++?>" onclick="showMap(10.846783, 106.760974,<?php echo $a . ',' . $valPri['id'] ?>)">156 Đặng Văn Bi - Q. Thủ Đức<p></p></li>
                                                                                                        <li title="974 Kha Vạn Cân - Q. Thủ Đức" class="item-shop item-shop-<?php echo $b = $i++?>" onclick="showMap(10.857691, 106.757349,<?php echo $b . ',' . $valPri['id']?> )">974 Kha Vạn Cân - Q. Thủ Đức<p></p></li>
                                                                                                        <li title="263 Lê Văn Việt - Q. 9" class="item-shop item-shop-<?php echo $c= $i++?>" onclick="showMap(10.844651, 106.790530,<?php echo $c . ',' . $valPri['id'] ?>)">263 Lê Văn Việt - Q. 9<p></p></li>
                                                                                                    </ul>
                                                                                                </div>
                                                                                                <div class="ppu_tab_lmap_title lmap-<?php echo $a?>" style="display:none">
                                                                                                    <img src="<?php echo $this->imgUrl ?>/ppu_icon_map.png">
                                                                                                    <span id="chooseShopStoreID">Showroom 156 Đặng Văn Bi - Q. Thủ Đức</span>
                                                                                                    <span class="ppu_tab_lmap_close">
                                                                                                        <img src="<?php echo $this->imgUrl ?>/ppu_close_map.png" onclick="hideMap()">
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div class="ppu_tab_lmap_title lmap-<?php echo $b ?>" style="display:none">
                                                                                                    <img src="<?php echo $this->imgUrl ?>/ppu_icon_map.png">
                                                                                                    <span id="chooseShopStoreID">Showroom 974 Kha Vạn Cân - Q. Thủ Đức</span>
                                                                                                    <span class="ppu_tab_lmap_close">
                                                                                                        <img src="<?php echo $this->imgUrl ?>/ppu_close_map.png" onclick="hideMap()">
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div class="ppu_tab_lmap_title lmap-<?php echo $c?>" style="display:none">
                                                                                                    <img src="<?php echo $this->imgUrl ?>/ppu_icon_map.png">
                                                                                                    <span id="chooseShopStoreID">Showroom 263 Lê Văn Việt - Q. 9</span>
                                                                                                    <span class="ppu_tab_lmap_close">
                                                                                                        <img src="<?php echo $this->imgUrl ?>/ppu_close_map.png" onclick="hideMap()">
                                                                                                    </span>
                                                                                                </div>
                                                                                                <div id="map-google-<?php echo $valPri['id']?>" class="map-google" style="width: 400px;  height: 290px; position: absolute; display: none;"></div>
                                                                                            </div>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- RIGHT TAB-->
                                                                                <div class="ppu_tab_right">
                                                                                    <div class="ppu_tab_right_box">
                                                                                        <input type="hidden" value="<?php echo $valPri['id'] ?>" name="id" id="id-<?php echo $valPri['id'] ?>">
                                                                                        <input type="hidden" value="<?php echo $valPri['size'] ?>" name="size" id="size-<?php echo $valPri['id'] ?>">
                                                                                        <input type="hidden" value="" name="address" id="diachigiaohang-<?php echo $valPri['id'] ?>">
                                                                                        <span style="color:red">(*) Bạn buộc phải nhập thông tin vào!</span>
                                                                                        <p class="pform-inline">
                                                                                            <input name="full_name" id="full_name-<?php echo $valPri['id'] ?>" class="ppu_rtxt" type="text" placeholder="Họ tên bạn" data-rule-required="true">
                                                                                            <i>*</i>
                                                                                        </p>
                                                                                        <p class="pform-inline">
                                                                                            <input id="phoneMuaHang-<?php echo $valPri['id']?>" name="phone" id="phone-<?php echo $valPri['id'] ?>" class="ppu_rtxt" type="text" placeholder="Số điện thoại" data-rule-required="true">
                                                                                            <i>*</i>
                                                                                        </p>
                                                                                        <textarea name="address" id="address" class="ppu_rtextarea" placeholder="Địa chỉ giao hàng"></textarea>
                                                                                        <div class="ppu_tab_tt_price">Tổng giá trị đơn hàng: <span class="textTotalMoney">
                                                                                                <?php
                                                                                                if ($valPri['selloff'] > 0)
                                                                                                    echo number_format($valPri['selloff'], 0);
                                                                                                else {
                                                                                                    echo number_format($valPri['price'], 0);
                                                                                                }
                                                                                                ?>
                                                                                            </span>&nbsp;đ</div>
                                                                                        <a href='<?php echo $linkCartPro ?>'>
                                                                                            <div class="ppu_rbnt_addcart">
                                                                                                Giỏ Hàng
                                                                                            </div>
                                                                                        </a>
                                                                                        <button class="ppu_rbnt_submit" onclick="datMua(<?php echo $valPri['id'] ?>)"> Đặt Ngay</button>

                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <!-- BOTTOM TAB-->
                                                                            <div class="ppu_bottom_noti">
                                                                                <p>Chúng tôi sẽ liên hệ với bạn trong vòng <strong>1 tiếng</strong>  và cam kết giao hàng miễn phí trong <strong>1 ngày</strong>.</p>
                                                                                <p class="ppu_bt_call">Tư vấn miễn phí: <strong>0917 311 001</strong></p>
                                                                            </div>

                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                    ?>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div role="tabpanel" class="tab-pane active" id="noidung3">
                                    </div>
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
                                                                                                html: true,
                                                                                                animation: true,
                                                                                                delay: {'show': 500, 'hide': 1000}
                                                                                            });
                                                                                        });
                                                                                        $("#zoom_01").elevateZoom({gallery: 'gal1', cursor: 'crosshair', galleryActiveClass: 'active', imageCrossfade: true});
                                                                                        //pass the images to Fancybox 
                                                                                        $("#zoom_01").bind("mouseover", function(e) {
                                                                                            var ez = $('#zoom_01').data('elevateZoom');
                                                                                            $.fancybox(ez.getGalleryList());
                                                                                            return false;
                                                                                        });
</script>

<div class="modal fade datmua" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="ppu_header">
                <p class="ppu_h_title">ĐẶT HÀNG - NGHE TƯ VẤN MIỄN PHÍ</p>
                <p class="ppu_h_noti">(Không mua không sao)</p>
            </div>
            <div class="ppu_ss_main">
                <input type="hidden" id="orderID" value="1805861">
                <img src="<?php echo $this->imgUrl ?>/ppu_ss_icon.png">
                <p class="ppu_ss_title">Đặt hàng thành công!</p>
                <div class="ppu_ss_infos">
                    <p>Cảm ơn bạn <b id="ten-nguoi-mua"></b> đã cho chúng tôi cơ hội được phục vụ!</p>
                    <p class="ppu_bt_call"><i>Tư vấn miễn phí: <strong><span class="popup-bfont popup-red">0917 311 001</span></strong></i></p>
                    <p>Chúng tôi sẽ liên hệ với bạn trong vòng <strong>1 tiếng</strong>  và cam kết giao hàng miễn phí trong <strong>1 ngày</strong>.</p>
                </div>
                <div class="popup-spt-bottom">
                </div>
            </div>
        </div>
    </div>
</div>