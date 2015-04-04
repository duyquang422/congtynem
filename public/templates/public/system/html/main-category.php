<div class="container">
    <div class="row">
        <div class="col-md-3">
            <div class='modules'>
                    <div class="price-filter">
                        <span><strong>Giá</strong> Từ: </span>
                        <span>thấp -> cao</span><input type="radio" name="price" id="asc" value="asc">
                        <span>cao -> thấp</span><input type="radio" name="price" id="desc" value="desc">
                    </div>
                <div class="promotion">
                    <input type="checkbox" name="discount" value="1">
                    <img src="<?php echo $this->imgUrl . '/discount.png'?>">
                    <input type="checkbox" name="promotion" value="1">
                    <img src="<?php echo $this->imgUrl . '/promotion.png'?>">
                    <input type="checkbox" name="gift" value="1">
                    <img src="<?php echo $this->imgUrl . '/gift.png'?>">
                    <input type="checkbox" name="new" value="2015">
                    <img src="<?php echo $this->imgUrl . '/new.png'?>">
                </div>
                <div class="manufacturers">
                    <strong>CHỌN HÃNG</strong><span> (chọn hãng mà bạn cần tìm)</span>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div>
                <ol class='breadcrumb'>
                    <li><a href="#">Home</a></li>
                    <li><a href="#">Library</a></li>
                    <li class="active">Data</li>
                </ol>
            </div>
            <div class='category-description'>
                <span>
                    Mua nệm cao su Vạn Thành, Liên Á, Kim Cương tại congtynem.com được giảm giá lên đến 20%,khuyến mãi giảm giá,tặng drap, áo nệm cao su, giao hàng miễn phí TP HCM. Vui lòng LH 1900 555 559.Xem ngay!
                </span>
            </div>
            <div class='clearfix'></div>
            <?php echo $this->layout()->content;?>
        </div>
    </div>
</div>