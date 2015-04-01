<div class="home__floor layout__container">
    <!-- First Level Menu -->
    <div class="sidebar column-1 column">
        <ul class="sidebar__list" id="sidebar__list">
            <?php
            $i = 0;
            foreach ($this->menu as $key => $val) {
                if ($val['level'] == 1) {
                    $html .= '<li class="hover-sidebar sidebar__listItem sidebar__listItem-' . $i . ' sidebar__listItem_color-orange sidebarIcon__icon-cat_' . $i . '" data-id="'. $i .'">';
                    $html .= '<i class="icon__round"><i class="icon icon__sidebar"></i></i>';
                    $html .= '<a href="" data-id="' . $i . '">' . $val['name'] . '</a>';
                    $html .= '</li>';
                    $i++;
                }
            }
            echo $html
            ?>
        </ul>
        <!-- Second Level Menu -->
        <div class="sidebarSecond column-1 column" style="display: none">
            <?php
            $i = 0;
            foreach ($this->menu as $key => $val) {
                if ($val['level'] == 1) {
                    $parent = $val['id'];
                    ?>
                    <div class="sidebarSecond__content sidebar__<?php echo $i ?>" style="border-left-width: 5px; border-left-style: solid; border-left-color: rgb(223, 31, 38);">
                        <ul class="sidebarSecond__list">
                            <?php
                            foreach ($this->menu as $key => $val) {
                                if ($val['level'] == 2 && $val['parent'] == $parent) {
                                    ?>
                                    <li class="sidebarSecond__itemSecond">
                                        <a href=""><?php echo $val['name'] ?></a>
                                    </li>
                                    <?php
                                }
                            }
                            ?>
                        </ul>
                    </div>
                    <?php
                    $i++;
                }
            }
            ?>
        </div>
    </div>
    <!-- Homepage Floors for each category item -->
    <div class="column-3 column">
        <?php
        $i = 0;
        foreach ($this->menu as $key => $val) {
            if ($val['level'] == 1) {
                ?>
                <div class="floor__layout floor__home-<?php echo $i ?> floor__home">
                    <div class="column-2 column">
                        <div class="row__height-2" data-placeholder="1">
                            <a class="widget widget-banner_2x2 tracking-banner" href="" style="-webkit-transition-delay: 0.08s; transition-delay: 0.08s;">
                                <div class="widget__text"></div>
                                <img src="<?php echo 'public/files/category/images587x354/' . $val['picture'] ?>" alt="MasterCard" class="image-<?php echo $i ?> slide" width="737" height="352">
                            </a>
                        </div>
                        <div class="widgetContainer">
                            <div class="column-1 column">
                                <div class="row__height-1" data-placeholder="2">
                                    <a class="widget widget-banner_2x2 tracking-banner" href="" style="-webkit-transition-delay: 0.1s; transition-delay: 0.1s;">
                                        <div class="widget__text">
                                        </div>
                                        <img src="<?php echo 'public/files/category/images194x177/' . $val['picture1'] ?>" class="widget__image" width='246' height="177">
                                    </a>
                                </div>
                            </div>
                            <div class="column-1 column">
                                <div class="row__height-1" data-placeholder="3">
                                    <a class="widget widget-banner_1x1 tracking-banner" href="" style="-webkit-transition-delay: 0.14s; transition-delay: 0.14s;">
                                        <span class="widget__text">
                                        </span>
                                        <img src="<?php echo 'public/files/category/images194x177/' . $val['picture2'] ?>" alt="Flash sale 20%" class="widget__image"  width='197' height="177">
                                    </a>
                                </div>
                            </div>
                            <div class="column-1 column">
                                <div class="row__height-1" data-placeholder="4">
                                    <a class="widget widget-banner_1x1 tracking-banner" style="-webkit-transition-delay: 0.06s; transition-delay: 0.06s;">
                                        <div class="x-timer"></div><span class="widget__text">
                                        </span>
                                        <img src="<?php echo 'public/files/category/images194x177/' . $val['picture3'] ?>" alt="Flash sale" class="widget__image"  width='197' height="177">
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $i++;
            }
        }
        ?>
    </div>

    <!-- Side info for home floor -->
    <div class="right column-1 column column_r_hide">


        <div class="popup__link" data-popup="usp">
            <div class="right__block">
                <div class="icon-news"><img src="<?php echo $this->imgUrl ?>/news.png" width="30px"></div>
                <div class="right__block__title">Tin Tức</div>
                <div class="right__block__wrapper">
                    <div class="right__block__item"><a href="#">» Nệm Mousse ép là gì ? -Cấu tạo của Mousse ép</a><img src="<?php echo $this->imgUrl ?>/news.gif"></div>
                    <div class="right__block__item"><a>» Nên chọn mua nệm loại nào phụ hợp cho bạn</a></div>
                    <div class="right__block__item right__block__item-small"><a>» Nhân Viên Tư Vấn Bán Hàng Online</a><img src="<?php echo $this->imgUrl ?>/news.gif"></div>
                    <div class="right__block__item right__block__item-small"><a>» Nệm WEAN tưng bừng khai trương showroom mới</a><img src="<?php echo $this->imgUrl ?>/news.gif"></div>
                    <div class="right__block__item right__block__item-small"><a>» Hướng dẫn cách giặt và sử dụng ruột gối</a></div>
                    <span class="usp__link pseudo" style="float:right; margin-top: -15px;"><a href="#">Xem thêm</a></span>
                </div>
            </div>
        </div>
        <div class="right__block">
            <div class="right__block__title">TƯNG BỪNG MUA SẮM CÙNG WEAN</div>
            <div class="x-timer">
                <span class="d-box">
                    <span class="d-val">07</span>
                    <span class="d-lbl">Ngày</span>  
                </span>
                <span class="d-box">
                    <span class="d-val">11</span>
                    <span class="d-lbl">Giờ</span>        
                </span>
                <span class="d-box">
                    <span class="d-val">56</span>
                    <span class="d-lbl">Phút</span>   
                </span>
                <span class="d-box">
                    <span class="d-val">53</span>
                    <span class="d-lbl">Giây</span>   
                </span>
            </div>
            <img src="<?php echo $this->imgUrl ?>/9741579853795933596.jpg" width="200px"/>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('document').ready(function() {
        var focus = 0;
        $('.hover-sidebar').hover(function() {
            $('.sidebar__' + focus).removeClass('active');
            $('.floor__home-' + focus).removeClass('active');
            $('.sidebar__' + $(this).data('id')).addClass('active');
            $('.floor__home-' + $(this).data('id')).addClass('active');
            $('.sidebarSecond ').attr('style','display:inline');
            focus = $(this).data('id');
        });
        $('.sidebar').mouseleave(function(){
            $('.sidebarSecond ').attr('style','display:none');
        });
        $('.floor__home-0').addClass('active');
        
    });
</script>