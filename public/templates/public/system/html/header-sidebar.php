<script>
    $('document').ready(function() {
        var focus = 0;
        function hover(x) {
            $('.sidebar__' + focus).removeClass('active');
            $('.sidebar__listItem-' + focus).removeClass('active');
            $('.sidebar__' + x).addClass('active');
            $('.sidebar__listItem-' + x).addClass('active');
            focus = x;
        }
        $('.sidebar__listItem-0').hover(function() {
            hover(0);
        });
        $('.sidebar__listItem-1').hover(function() {
            hover(1);
        });
        $('.sidebar__listItem-2').hover(function() {
            hover(2);
        });
        $('.sidebar__listItem-3').hover(function() {
            hover(3);
        });
        $('.sidebar__listItem-4').hover(function() {
            hover(4);
        });
        $('.sidebar__listItem-5').hover(function() {
            hover(5);
        });
        $('.sidebar__listItem-6').hover(function() {
            hover(6);
        });
        $('.sidebar__listItem-7').hover(function() {
            hover(7);
        });
        $('.sidebar__listItem-8').hover(function() {
            hover(8);
        });
        $('.sidebar__listItem-9').hover(function() {
            hover(9);
        });
        $('.sidebar__listItem-10').hover(function() {
            hover(10);
        });
        $('.sidebar__listItem-11').hover(function() {
            hover(11);
        });
        $('.sidebar__listItem-12').hover(function() {
            hover(12);
        });
        $('.sidebar__listItem-13').hover(function() {
            hover(13);
        });
    });
</script>
<div class="container">
    <div class="header__bottom__menu">
        <div class="header__bottom__menu__wrapper layout__wrapper cf">
            <div class="header__menu" id='header__menu'>
                <div class="header_container">
                    <div class="column-1 column">
                        <a href="http://www.congtynem.com/vn" title="Tất cả danh mục">
                            <div class="header__menu__title">
                                <span>Tất cả danh mục</span><i class="fa fa-arrow-circle-o-down"></i>
                                <i class="icon icon-arrow-down-white"></i>
                            </div>
                        </a>
                    </div>
                </div>
                <div class="header__menu__container" style="display:none">
                    <div class="header_container">
                        <div class="sidebar column-1 column">
                            <ul class="sidebar__list" id="sidebar__list">
                                <?php
                                $i = 0;
                                foreach ($this->menu as $key => $val) {
                                    if ($val['level'] == 1) {
                                        $html .= '<li class="hover-sidebar sidebar__listItem sidebar__listItem-' . $i . ' sidebar__listItem_color-orange sidebarIcon__icon-cat_' . $i . '" data-id="' . $i . '">';
                                        $html .= '<i class="icon__round"><i class="icon icon__sidebar"></i></i>';
                                        $html .= '<a href="' . $this->baseUrl($val['alias'] . '-' . $val['id'] . '.aspx') . '" data-id="' . $i . '">' . $val['name'] . '</a>';
                                        $html .= '</li>';
                                        $i++;
                                    }
                                }
                                echo $html
                                ?>
                            </ul>
<!--                             Second Level Menu -->
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
                                                            <a href="<?php echo $this->baseUrl($val['alias'] . '-' . $val['id'] . '.aspx') ?>"><?php echo $val['name'] ?></a>
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
                    </div>
                </div>
                <div class="header__menu__overlayBG"></div>
            </div>
            <div class="header__breadcrumb">
                <div class="header__breadcrumb__wrapper">
                    <ul>
                        <li class="last-child">
                            <h3>Chuyên Mục</h3>
                        </li>
                    </ul>
                </div>
                <div style="display:none" id="active-segments-roots" data-active-segment="" data-active-root=""></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(function() {
        $('.header__menu__title').hover(function() {
            $('.header__menu__container').attr('style', 'display:inline');
            $('.header__menu__overlayBG').attr('style', 'display:inline');
        });
        $('.header__menu__container').mouseleave(function() {
            $('.header__menu__container').attr('style', 'display:none');
            $('.header__menu__overlayBG').attr('style', 'display:none');
        });
        $('.header__menu__overlayBG').hover(function(){
            $('.header__menu__container').hide();
        });
    });
</script>