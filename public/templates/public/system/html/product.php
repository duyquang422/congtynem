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
        var focus = 0;
        function hoverSlide(x) {
            $('.img-' + focus).attr('style', 'display:none');
            $('.img-' + x).attr('style', 'display:inline');
            focus = x;
        }
        $('.hover-img-slide-0').hover(function() {
            hoverSlide(0);
        });
        $('.hover-img-slide-1').hover(function() {
            hoverSlide(1);
        });
        $('.hover-img-slide-2').hover(function() {
            hoverSlide(2);
        });
        $('.hover-img-slide-3').hover(function() {
            hoverSlide(3);
        });
        $('.cart-left').hover(function() {
            $('#edit').attr('style', 'display:inline');
        }, function() {
            $('#edit').attr('style', 'display:none');
        });
    });
</script>
<div class="container">
    <div class="row">
        <div class="promotion">
            <div class="col-md-2">
                <div class="today-box">
                    <div class="today-box-advertise">
                        <span>Khuyến Mãi Trong Ngày</span>
                    </div>
                    <div class="today-box-advertise-logo">
                        <img src="<?php echo $this->imgUrl . '/new-product-logo.jpg' ?>" height="415" width="200"/>
                    </div>
                </div>
            </div>
            <div class="col-md-10">
                <div class="wrapper-product">
                    <div class="best_of_best">
                        <i class="fa fa-star fa-lg"></i>
                        <span class="font16"><b>BEST</b>&nbsp;OF&nbsp;<b>BEST</b></span>
                        <a class="more" href="/vi/best-100.html"><i class="fa fa-angle-double-right"></i>Xem thêm</a>
                    </div>
                    <ul class="overview isBest">
                        <?php
                        $i = 0;
                        foreach ($this->Items as $key => $val) {
                            ?>
                            <li class="slide_item hover" data-id='<?php echo $key ?>'>
                                <div class="thumb_img">
                                    <a href="">
                                        <img src="public/files/products/images450x450/<?php echo $val['picture'] ?>" width="176px" height="177px" style="margin-bottom:30px">
                                    </a>
                                </div>
                                <div class="slide_price">
                                    <h3 class="slide_item_title"><a href=""><?php echo $val['name'] ?></a>
                                    </h3>
                                    <?php
                                    if ($val['selloff'] > 0)
                                        echo '<div class="sm_old_price">' . $val['selloff'] . '</div>';
                                    ?>
                                    <div class="sm_new_price"><?php echo $val['price'] ?> VNĐ</div>
                                </div>
                                <a href="<?php echo $this->baseUrl($val['alias'] . '-' . $val['id'] . '.html') ?>">
                                    <div class="info info-<?php echo $key ?>" style="display:none">
                                        <span>
                                            Mã sản phẩm: <?php echo $val['code'] ?><br>	
                                            Nhà sản xuất: <?php echo $val['publisher'] ?><br>	
                                            Số lần xem: <?php echo $val['hits'] ?><br>			
                                            Bảo hành: <?php echo $val['warranty'] ?> <br>
                                        </span>
                                    </div>
                                </a>
                                <div class="btn-function">
                                    <div class="btnxemnhanh">
                                        <a title="Xem nhanh" data-toggle="modal" data-target=".product-info-<?php echo $key ?>">
                                            <span class="xemnhanh">Xem nhanh</span>
                                            <i class="fa fa-eye"></i>
                                        </a>
                                    </div>
                                    <div class="myicon btn-ss btnxemnhanh" title="So sánh">
                                        <a href="" title="Xem nhanh">
                                            <span>So sánh</span>
                                            <i class="fa fa-exchange"></i>
                                        </a>
                                    </div>
                                </div>
                            </li>

                            <div class="modal fade product-info-<?php echo $key ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="info-product-detail">
                                            <div class="info-product-left">
                                                <div class="info-title">
                                                    <h3><?php echo $val['name'] ?></h3>
                                                </div>
                                                <div class="prdMedia">
                                                    <div class="prd-moreImages">
                                                        <ul class="prd-moreImagesList  product-<?php echo $val['id'] ?>">
                                                            <?php
                                                            $photos = json_decode($val['photos']);
                                                            if(!empty($photos)){
                                                                foreach ($photos as $i => $v) {
                                                                    if ($i < count($photos) / 2) {
                                                                        echo '<li class="photo-' . $i . '" onmouseover="changePhoto(' . $val['id'] . ',' . $i . ')"><img src="public/files/photos/images50x50/' . $v . '"></li>';
                                                                    }
                                                                }
                                                            }
                                                            ?>
                                                        </ul>
                                                    </div>
                                                    <div class="productImage">
                                                        <div class="svn product-<?php echo $val['id'] ?>">
                                                            <ul>
                                                                <?php
                                                                $photos = json_decode($val['photos']);
                                                                echo '<li class="photo-first-lg"><img src="public/files/products/images450x450/' . $val['picture'] . '" width="350" height="270"></li>';
                                                                if(!empty($photos)){
                                                                    foreach ($photos as $i => $v) {
                                                                        echo '<li class="photo-' . $i . '-lg" style="display:none"><img src="public/files/photos/images350x350/' . $v . '" width="350" height="270"></li>';
                                                                    }
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                        <div class="agn ">
                                                            <ul class="prd-moreImagesList product-<?php echo $val['id'] ?>">
                                                                <?php
                                                                $photos = json_decode($val['photos']);
                                                                if(!empty($photos)){
                                                                    foreach ($photos as $i => $v) {
                                                                        if ($i >= count($photos) / 2) {
                                                                            echo '<li class="photo-' . $i . '" onmouseover="changePhoto(' . $val['id'] . ',' . $i . ')"><img src="public/files/photos/images50x50/' . $v . '"></li>';
                                                                        }
                                                                    }
                                                                }
                                                                ?>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="info-product-right">
                                                <div class="btn-purchase">
                                                    <div class="btn-muangay">
                                                        <a href="<?php echo $this->baseUrl('default/cart/add-item/priID/') . $val['id'] ?>">
                                                            <button type="button">                                                                
                                                                <i class="fa fa-shopping-cart"></i>Mua Ngay
                                                            </button>
                                                        </a>
                                                    </div>
                                                    <div class="btn-chitiet">
                                                        <a href="<?php echo $this->baseUrl($val['alias'] . '-' . $val['id'] . '.html') ?>"><button type="button"><i class="fa fa-arrow-circle-o-right"></i>Xem Chi Tiết</button></a>
                                                    </div>
                                                </div>
                                                <div class="pro_des">
                                                    Lượt xem : <span><?php echo $val['hits'] ?></span>
                                                    &nbsp;&nbsp;|&nbsp;Ngày đăng : <span><?php echo $val['created'] ?></span>
                                                </div>
                                                <div class="pro_detail_content">
                                                    <div class="dt_pro_info dt_active" id="dt_info">
                                                        <ul>
                                                            <li>Giá Khuyến Mãi: <span><?php echo $val['saleoff'] ?></span></li>
                                                            <li>Giá Sản Phẩm: <span><?php echo $val['price'] ?></li>
                                                            <li>Tiết Kiệm Được</li>
                                                            <li>Mã Sản Phẩm: <span><?php echo $val['code'] ?></li>
                                                            <li>Số Lượng</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php
                            $i++;
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
        <div class="slide_product">
            <div class="col-md-9">
                <div class="wrapper-product-highlights">
                    <div class="scj_title_v2">Sản phẩm nổi bật</div>
                    <div class="spot-box">
                        <div class="spot-content" style="margin-left:0px">
                            <ul>
                                <?php
                                foreach ($this->highLightsProduct as $key => $val) {
                                    ?>
                                    <li>
                                        <a target="_self" href="">
                                            <img src="public/files/products/images450x450/<?php echo $val['picture'] ?>" alt="laneige" border="0">
                                        </a>
                                    </li>

                                    <?php
                                }
                                ?>
                            </ul>
                        </div>
                        <a class="slidesjs-previous slidesjs-navigation" title="Previous"></a>
                        <a class="slidesjs-next slidesjs-navigation" title="Next"></a>

                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="md-banner">
                    <a href="">
                        <img src="public/templates/public/system/images/quang-cao.gif" alt="nature_mar" border="0" height="318" width="290">
                    </a>
                </div>
            </div>
        </div>
        <div class="new-product">
            <div class="col-md-12">
                <div class="category_title">
                    <span class="catName">
                        <span class="catBg">
                            <span class="catIcon cat_1"></span>
                        </span>


                        <!-- ----------------TUNG-------------- -->
                        <div class="navicate navicatetivi">
                            <h2><a href="tivi" class="tivi">nệm cao su</a></h2>
                            <h4><a href="tivi-samsung" class="">nệm khách sạn</a></h4>
                            <h4><a href="tivi-sony" class="">nệm lò xo</a></h4>
                            <h4><a href="tivi-lg" class="">nệm y tế</a></h4>
                            <h4><a href="tivi-toshiba" class="">nệm em bé</a></h4>
                            <h4><a href="tivi-tcl" class="">gối</a></h4>
                            <h4><a href="tivi-panasonic" class="">sofa</a></h4>
                            <h4><a href="/tag/tivi-hd" class="lower">khác</a></h4>                
                        </div>


                    </span>

                </div>
            </div>
            <div>
                <div class="col-md-5">
                    <div class="cart-left">
                        <div class="featurePro">
                            <div class="scj_internet_only"></div>

                            <div class="scj_discount"><span class="dis2">790K                            <br><span class="off_text">OFF</span></span></div>
                            <?php
                            $files = array();
                            $dir = opendir(FILES_PATH . '/slide/images40x40');
                            while ($f = readdir($dir)) {
                                if (eregi("\.jpg|\.gif|\.png", $f))
                                    array_push($files, $f);
                            }
                            closedir($dir);
                            $data = array();
                            $html = '';
                            if (!empty($files)) {
                                foreach ($files as $k => $v) {
                                    $html .= '<a href="">';
                                    if ($k == 0)
                                        $html .= '<div class="slideImage img-' . $k . '">';
                                    else
                                        $html .= '<div class="slideImage img-' . $k . '" style="display:none">';
                                    $html .= '<img class="lazy" src="public/files/slide/images375x375/' . $v . '" alt="image 1" style="height: 375px">';
                                    $html .='</div>';
                                    $html .= '</a>';
                                }
                            }
                            echo $html;
                            ?>
                        </div>
                        <ul class="p_gallery">
                            <?php
                            $files = array();
                            $dir = opendir(FILES_PATH . '/slide/images40x40');
                            while ($f = readdir($dir)) {
                                if (eregi("\.jpg|\.gif|\.png", $f))
                                    array_push($files, $f);
                            }
                            closedir($dir);
                            $data = array();
                            $html = '';
                            if (!empty($files)) {
                                foreach ($files as $k => $v) {
                                    ?>
                                    <li>
                                        <a class="pgallery hover-img-slide-<?php echo $k ?>" href="http://image.scj.vn/item_images/54/112954L.jpg">
                                            <img src="public/files/slide/images40x40/<?php echo $v ?>">
                                        </a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                        <div class="featurePrice">
                            <h3 class="slide_item_title"><a href="/vi/san-pham/dien-tu/dien-thoai-di-dong/dien-thoai-di-dong-in/dien-thoai-aimica-a10_-dien-thoai-kook-mini.html">Điện thoại Aimica A10+ điện thoại Kook mini</a>
                            </h3>
                            <div class="cat-price">

                                <span class="new-price">3.990.000đ</span>
                            </div>

                        </div>
                        <button type="button" data-toggle="modal" data-target=".edit-slideshow" id="edit" style="display:none"><i class="fa fa-pencil-square-o"></i></button>
                        <div class="modal fade edit-slideshow" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content">
                                    <?php
                                    //hình ảnh mô tả
                                    $inputInfo = array('name' => 'picture');
                                    $imgArr = !empty($this->image['picture']) ? array(FILES_URL . '/slide/images375x375/' . $this->image['picture']) : '';
                                    $image = $this->cmsUserAvatar($inputInfo, $imgArr);
                                    if (!empty($this->image['picture'])) {
                                        $urlimage = FILES_URL . '/slide/images375x375/' . $this->image['picture'];
                                        $imgimage = '<span><img src="' . $urlimage . '" width="" height="40"></span>';
                                        $picture = $imgimage . "<br/>" . $this->formFile('picture', array('style' => 'margin-left:173px'));
                                    } else {
                                        $picture = $this->formFile('picture', array('style' => 'margin-left:5px'));
                                    }
                                    $current_stadium_picture = $this->formHidden('current_stadium_picture', $this->image['picture']);

                                    //hình ảnh mô tả
                                    $inputInfo = array('name' => 'picture1');
                                    $imgArr = !empty($this->image['picture1']) ? array(FILES_URL . '/slide/images375x375/' . $this->image['picture1']) : '';
                                    $image = $this->cmsUserAvatar($inputInfo, $imgArr);
                                    if (!empty($this->image['picture1'])) {
                                        $urlimage = FILES_URL . '/slide/images375x375/' . $this->image['picture1'];
                                        $imgimage = '<span><img src="' . $urlimage . '" width="" height="40"></span>';
                                        $picture1 = $imgimage . "<br/>" . $this->formFile('picture1', array('style' => 'margin-left:173px'));
                                    } else {
                                        $picture1 = $this->formFile('picture1', array('style' => 'margin-left:5px'));
                                    }
                                    $current_stadium_picture1 = $this->formHidden('current_stadium_picture1', $this->image['picture1']);

                                    //hình ảnh mô tả
                                    $inputInfo = array('name' => 'picture2');
                                    $imgArr = !empty($this->image['picture2']) ? array(FILES_URL . '/slide/images375x375/' . $this->image['picture2']) : '';
                                    $image = $this->cmsUserAvatar($inputInfo, $imgArr);
                                    if (!empty($this->image['picture2'])) {
                                        $urlimage = FILES_URL . '/slide/images375x375/' . $this->image['picture2'];
                                        $imgimage = '<span><img src="' . $urlimage . '" width="" height="40"></span>';
                                        $picture2 = $imgimage . "<br/>" . $this->formFile('picture2', array('style' => 'margin-left:173px'));
                                    } else {
                                        $picture2 = $this->formFile('picture2', array('style' => 'margin-left:5px'));
                                    }
                                    $current_stadium_picture2 = $this->formHidden('current_stadium_picture2', $this->image['picture2']);

                                    //hình ảnh mô tả
                                    $inputInfo = array('name' => 'picture3');
                                    $imgArr = !empty($this->image['picture3']) ? array(FILES_URL . '/slide/images375x375/' . $this->image['picture3']) : '';
                                    $image = $this->cmsUserAvatar($inputInfo, $imgArr);
                                    if (!empty($this->image['picture3'])) {
                                        $urlimage = FILES_URL . '/slide/images375x375/' . $this->image['picture3'];
                                        $imgimage = '<span><img src="' . $urlimage . '" width="" height="40"></span>';
                                        $picture3 = $imgimage . "<br/>" . $this->formFile('picture3', array('style' => 'margin-left:173px'));
                                    } else {
                                        $picture3 = $this->formFile('picture3', array('style' => 'margin-left:5px'));
                                    }
                                    $current_stadium_picture3 = $this->formHidden('current_stadium_picture3', $this->image['picture3']);

                                    $Input = array(
                                        array('Label' => $this->translate('Hình Ảnh'), 'input' => $picture),
                                        array('Label' => $this->translate('Hình Ảnh'), 'input' => $picture1),
                                        array('Label' => $this->translate('Hình Ảnh'), 'input' => $picture2),
                                        array('Label' => $this->translate('Hình Ảnh'), 'input' => $picture3)
                                    );
                                    ?>
                                    <form name="appForm" method="post" action="<?php echo $this->baseUrl('/default/index/index') ?>" enctype="multipart/form-data">
                                        <?php
                                        echo $current_stadium_picture;
                                        echo $current_stadium_picture1;
                                        echo $current_stadium_picture2;
                                        echo $current_stadium_picture3;
                                        echo $this->partialLoop('rows.php', $Input);
                                        ?>
                                        <button type="submit">Thay Ảnh</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-7">
                    <div class="cart-right">
                        <ul class="overview">
                            <?php
                            foreach ($this->nemcaosuProduct as $key => $val) {
                                ?>
                                <li class="cart_item hover" data-id='<?php echo $i + 1 + $key ?>'>
                                    <div class="scj_internet_only"></div>
                                    <div class="thumb_img">
                                        <a href="">
                                            <img class="lazy" src="public/files/products/images450x450/<?php echo $val['picture'] ?>">        
                                        </a>
                                    </div>
                                    <div class="cat-des">
                                        <h3 class="slide_item_title"><a href=""><?php echo $val['name'] ?></a>
                                        </h3>
                                        <div class="cat-price">
                                            <span class="sm_old_price"><?php echo $val['saleoff'] ?></span>
                                            <span class="sm_new_price"><?php echo $val['price'] ?></span>
                                        </div>
                                    </div>
                                    <a href="<?php echo $this->baseUrl($val['alias'] . '-' . $val['id'] . '.html') ?>">
                                        <div class="info info-<?php echo $i + 1 + $key ?>" style="display:none">
                                            <span>
                                                Mã sản phẩm: <?php echo $val['code'] ?><br>	
                                                Nhà sản xuất: <?php echo $val['publisher'] ?><br>	
                                                Số lần xem: <?php echo $val['hits'] ?><br>			
                                                Bảo hành: <?php echo $val['warranty'] ?> <br>
                                            </span>
                                        </div>
                                    </a>
                                    <div class="btn-function">
                                        <div class="btnxemnhanh">
                                            <a href="" title="Xem nhanh" data-toggle="modal" data-target=".product-info-<?php echo $i + 1 + $key ?>">
                                                <span class="xemnhanh">Xem nhanh</span>
                                                <i class="fa fa-eye"></i>
                                            </a>
                                            <div class="modal product-info-<?php echo $i + 1 + $key ?>" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                                                <div class="modal-dialog modal-lg">
                                                    <div class="modal-content">
                                                        <div class="info-product-detail">
                                                            <div class="info-product-left">
                                                                <div class="info-title">
                                                                    <h3><?php echo $val['name'] ?></h3>
                                                                </div>
                                                                <div class="prdMedia">
                                                                    <div class="prd-moreImages">
                                                                        <ul class="prd-moreImagesList">
                                                                            <li><img src="/congtynem/public/templates/public/system/images/picture_2.jpg"></li>
                                                                            <li><img src="/congtynem/public/templates/public/system/images/picture_3.jpg"></li>
                                                                            <li><img src="/congtynem/public/templates/public/system/images/picture_4.jpg"></li>
                                                                        </ul>
                                                                    </div>
                                                                    <div class="productImage">
                                                                        <img src="/congtynem/public/files/products/images450x450/picture_1427858623.jpg" width="340px" height="340">
                                                                        <ul class="prd-moreImagesList" style="margin-left: 175px; margin-top: 15px;">
                                                                            <li><img src="/congtynem/public/templates/public/system/images/picture_2.jpg"></li>
                                                                            <li><img src="/congtynem/public/templates/public/system/images/picture_3.jpg"></li>
                                                                            <li><img src="/congtynem/public/templates/public/system/images/picture_4.jpg"></li>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <div class="info-product-right">
                                                                    <div class="btn-purchase">
                                                                        <div class="btn-muangay">
                                                                            <button type="button"><i class="fa fa-shopping-cart"></i>Mua Ngay</button>
                                                                        </div>
                                                                        <div class="btn-chitiet">
                                                                            <button type="button"><i class="fa fa-arrow-circle-o-right"></i>Xem Chi Tiết</button>
                                                                        </div>
                                                                    </div>
                                                                    <div class="pro_des">
                                                                        Lượt xem : <span><?php echo $val['hits'] ?></span>
                                                                        &nbsp;&nbsp;|&nbsp;Ngày đăng : <span><?php echo $val['created'] ?></span>
                                                                    </div>
                                                                    <div class="pro_detail_content">
                                                                        <div class="dt_pro_info dt_active" id="dt_info">
                                                                            <ul>
                                                                                <li>Giá Khuyến Mãi: <span><?php echo $val['saleoff'] ?></span></li>
                                                                                <li>Giá Sản Phẩm: <span><?php echo $val['price'] ?></li>
                                                                                <li>Tiết Kiệm Được</li>
                                                                                <li>Mã Sản Phẩm: <span><?php echo $val['code'] ?></li>
                                                                                <li>Số Lượng</li>
                                                                            </ul>
                                                                        </div>
                                                                    </div>
                                                                    <div class="pro-summary">
                                                                        <span><?php //echo $val['summary']    ?></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="myicon btn-ss btnxemnhanh" title="So sánh">
                                                <a href="" title="Xem nhanh">
                                                    <span>So sánh</span>
                                                    <i class="fa fa-exchange"></i>
                                                </a>
                                            </div>
                                        </div>
                                </li>
                                <?php
                            }
                            ?>
                        </ul>
                    </div>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>