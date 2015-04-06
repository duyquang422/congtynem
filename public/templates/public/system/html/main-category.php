<div class="container">
    <div class="row">
        <div class="col-md-3 filter">
            <div class="modules" id="modules">
                    <div class="price-filter">
                        <strong>Giá</strong> Từ:
                        thấp -> cao<input type="radio" name="price-order" value="asc">
                        cao -> thấp<input type="radio" name="price-order" value="desc">
                    </div>
                <div class="promotion-order">
                    <input type="checkbox" name="promotion[]" value="discount">
                    <img src="<?php echo $this->imgUrl . '/discount.png'?>">
                    <input type="checkbox" name="promotion[]" value="promotion">
                    <img src="<?php echo $this->imgUrl . '/promotion.png'?>">
                    <input type="checkbox" name="promotion[]" value="gift">
                    <img src="<?php echo $this->imgUrl . '/gift.png'?>">
                    <input type="checkbox" name="promotion[]" value="new">
                    <img src="<?php echo $this->imgUrl . '/new.png'?>">
                </div>
                <div class="manufacturers">
                    <strong>CHỌN HÃNG </strong>(Hãy chọn hãng mà bạn cần tìm)
                    <input type="checkbox" name="manufacturer[]" value="nệm edena">
                    <span>Nệm Edena</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm dunlopillo">
                    <span>Nệm Dunlopillo</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm wean">
                    <span>Nệm wean</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm dorufoam">
                    <span>Nệm Dorufoam</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm vạn thành">
                    <span>Nệm Vạn Thành</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm kim cương">
                    <span>Nệm Kim Cương</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm everon">
                    <span>Nệm Everon</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm liên á">
                    <span>Nệm Liên Á</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm hvh">
                    <span>Nệm HVH</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm cuscino">
                    <span>Nệm Cuscino</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm songhong">
                    <span>Nệm SongHong</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm havas">
                    <span>Nệm Havas</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm ưu việt">
                    <span>Nệm Ưu Việt</span>
                    <input type="checkbox" name="manufacturer[]" value="nệm hometex">
                    <span>Nệm Hometex</span>
                    <input type="checkbox" name="manufacturer[]" value="era">
                    <span>Nệm Era</span>
                </div>
                <div class="sizes">
                    <strong>GIÁ </strong>(Hãy chọn cho bản thân một giá tốt nhất)
                    <input type="radio" name="price" value="duoi 2 trieu">
                    <span>Dưới 2tr</span>
                    <input type="radio" name="price" value="3000000">
                    <span>Từ 2tr - 3tr</span>
                    <input type="radio" name="price" value="4000000">
                    <span>Từ 3tr - 4tr</span>
                    <input type="radio" name="price" value="5000000">
                    <span>Từ 4tr - 5tr</span>
                    <input type="radio" name="price" value="6000000">
                    <span>Từ 5tr - 6tr</span>
                    <input type="radio" name="price" value="tren 6 trieu">
                    <span>Trên 6tr</span>
                    <input type="radio" name="price" value="all">
                    <span>Tất cả</span>
                </div>
                <div class="warranty">
                    <strong>Bảo Hành </strong>(Sắp xếp theo lời gian bảo hành)
                    <input type="radio" name="warranty" value="5">
                    <span>Dưới 5 năm</span>
                    <input type="radio" name="warranty" value="7">
                    <span>5 năm - 7 năm</span>
                    <input type="radio" name="warranty" value="9">
                    <span>7 năm - 9 năm</span>
                    <input type="radio" name="warranty" value="11">
                    <span>9 năm - 11 năm</span>
                    <input type="radio" name="warranty" value="20">
                    <span>Trên 11 năm</span>
                </div>
                <div class="product-order">
                    <input type="checkbox" name="product[]" value="hot">
                    <img src="<?php echo $this->imgUrl . '/hot.png'?>">
                    <input type="checkbox" name="product[]" value="highlight">
                    <img src="<?php echo $this->imgUrl . '/highlight.png'?>">
                    <input type="checkbox" name="product[]" value="special">
                    <img src="<?php echo $this->imgUrl . '/special.png'?>">
                    <input type="checkbox" name="product[]" value="hits">
                    <img src="<?php echo $this->imgUrl . '/hits.png'?>">
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div>
                <ol class='breadcrumb'>
                    <li><a href="#">Home</a></li>
                    <li><a href="#"><?php ?></a></li>
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