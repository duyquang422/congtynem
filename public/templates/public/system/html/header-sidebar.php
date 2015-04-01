<script>
    $('document').ready(function(){
        var focus = 0;
        function hover(x){
                    $('.sidebar__' + focus ).removeClass('active');
                    $('.sidebar__listItem-' + focus).removeClass('active');
                    $('.sidebar__' + x ).addClass('active');
                    $('.sidebar__listItem-' + x).addClass('active');
                    focus = x;
            }
        $('.sidebar__listItem-0').hover(function(){
            hover(0);
        });
        $('.sidebar__listItem-1').hover(function(){
            hover(1);
        });
        $('.sidebar__listItem-2').hover(function(){
            hover(2);
        });
        $('.sidebar__listItem-3').hover(function(){
            hover(3);
        });
        $('.sidebar__listItem-4').hover(function(){
            hover(4);
        });
        $('.sidebar__listItem-5').hover(function(){
            hover(5);
        });
        $('.sidebar__listItem-6').hover(function(){
            hover(6);
        });
        $('.sidebar__listItem-7').hover(function(){
            hover(7);
        });
        $('.sidebar__listItem-8').hover(function(){
            hover(8);
        });
        $('.sidebar__listItem-9').hover(function(){
            hover(9);
        });
        $('.sidebar__listItem-10').hover(function(){
            hover(10);
        });
        $('.sidebar__listItem-11').hover(function(){
            hover(11);
        });
        $('.sidebar__listItem-12').hover(function(){
            hover(12);
        });
        $('.sidebar__listItem-13').hover(function(){
            hover(13);
        });
    });
</script>
<div class="container-fluid">
    <div class="header__bottom__menu">
            <div class="header__bottom__menu__wrapper layout__wrapper cf">
                <div class="header__menu">
                    <div class="header_container">
                        <div class="column-1 column">
                            <a href="http://www.lazada.vn/" title="Tất cả danh mục">
                                <div class="header__menu__title">
                                    <span>Tất cả danh mục</span>
                                    <i class="icon icon-arrow-down-white"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="header__menu__container" style="display:none">
                        <div class="header_container">
                            <!-- First Level Menu -->
                            <div class="sidebar column-1 column">
                                <ul class="sidebar__list">
                                    <li class="sidebar__listItem sidebar__listItem-0 active sidebar__listItem_color-orange sidebarIcon__icon-cat_hightlights">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/daily-deals/" class="active" data-id="0">Khuyến mãi tại Lazada</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-1 sidebar__listItem_color-violet sidebarIcon__icon-cat_cameras">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/may-anh-may-quay-phim-moi/?ref=CA" class="" data-id="1">Máy ảnh &amp; Máy quay phim</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-2 sidebar__listItem_color-violet sidebarIcon__icon-cat_tv">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/tv-video-am-thanh-moi/?ref=CE" class="" data-id="2">Tivi, Video &amp; Âm thanh</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-3 sidebar__listItem_color-violet sidebarIcon__icon-cat_mobiles">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/dien-thoai-may-tinh-bang/?ref-MT" class="" data-id="3">Điện thoại &amp; Tablet</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-4 sidebar__listItem_color-violet sidebarIcon__icon-cat_appliances">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/do-gia-dung-moi/?ref=HA" class="" data-id="4">Đồ gia dụng</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-5 sidebar__listItem_color-brick sidebarIcon__icon-cat_laptops">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/may-vi-tinh-laptop-moi/?ref=MT" class="" data-id="5">Máy vi tính &amp; Laptop</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-6 sidebar__listItem_color-olive sidebarIcon__icon-cat_home">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/nha-cua-doi-song/?ref=HL" class="" data-id="6">Nhà cửa &amp; Đời sống</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-7 sidebar__listItem_color-brick sidebarIcon__icon-cat_watches">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/dong-ho-moi/?ref=WA1" class="split" data-id="7">Đồng hồ</a><span class="splitter">|</span><a href="/trang-suc-nu/?ref=WA2" class="split" data-id="7">Nữ trang</a><span class="splitter">|</span><a href="/mat-kinh-thoi-trang/?ref=WA3" class="split" data-id="7">Mắt kính</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-8 sidebar__listItem_color-purple sidebarIcon__icon-cat_health">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/cham-soc-sac-dep-suc-khoe/?ref=HB" class="" data-id="8">Sức khỏe &amp; sắc đẹp</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-9 sidebar__listItem_color-green sidebarIcon__icon-cat_toys">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/tre-so-sinh-tre-em-do-choi/?ref=TKB" class="" data-id="9">Mẹ &amp; Bé</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-10 sidebar__listItem_color-blue sidebarIcon__icon-cat_sports">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/the-thao-da-ngoai/?ref=SP" class="" data-id="10">Thể thao &amp; Dã ngoại</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-11 sidebar__listItem_color-black sidebarIcon__icon-cat_clothing">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/thoi-trang-nu/?ref=FA" class="" data-id="11">Thời trang &amp; Phụ kiện</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-12 sidebar__listItem_color-blue sidebarIcon__icon-cat_sports">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/oto-xe-may-thiet-bi-dinh-vi/" class="" data-id="12">Phụ kiện ô tô, xe máy</a>                      </li>
                                    <li class="sidebar__listItem sidebar__listItem-13 sidebar__listItem_color-olive sidebarIcon__icon-cat_travel">
                                        <i class="icon__round"><i class="icon icon__sidebar"></i></i>
                                        <a href="/ba-lo-tui-du-lich/?ref=BA" class="" data-id="13">Ba lô và túi xách</a>                      </li>
                                </ul>
                            </div>

                            <!-- Second Level Menu -->
                            <div style="height: 532px;" class="sidebarSecond column-1 column">


                                <div class="sidebarSecond__content sidebar__0 active">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/daily-deals/?ref=PRC_top"><img style="float:left; margin-right:5px" src="http://static.lazada.vn/cms/big-sale1.png"><span style="display: block; padding-top: 10px; color: rgb(55, 55, 55); font-size: 14px; font-weight: bold; overflow: hidden; float: left;">Giá tốt<br> mỗi ngày »</span><span style="font-size:9px;display:block;clear:both;">Daily Deals mới. Khám phá ngay!!!</span></a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="undefined"><div style="border-bottom: 1px solid darkgray;width: 159px;color: black;"></div></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/daily-deals/?ref=PRC_promote_text"><span style="color:#f37021;font-weight: bold">Khuyến mãi đặc biệt</span></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/lazada-yeu-ha-noi/?ref=PRC11">Lazada yêu Hà Nội <img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dong-ho/stuhrling-original/?ref=PRC12">Stuhrling - Giảm sốc <img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/ta-giay-cho-be/?ref=PRC13">Tã giấy - Giảm 35% <img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/voucher-giam-gia-tivi/?ref=PRC_13A">Tivi tài trợ đến  600k</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dien-gia-dung-gia-soc/?ref=PRC14">Máy lạnh, máy giặt, tủ lạnh giá sốc</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/loi-ich-cao-gia-sieu-re/?ref=PRC15">Lợi ích cao, giá siêu rẻ</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/o-to-xe-may-thiet-bi-dinh-vi/?ref=PRC16">Giá sốc trong ngày - Giảm đến 50%</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/the-thao-da-ngoai/?ref=PRC18">Sản phẩm thể thao - giảm đến 50%</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/khoi-hanh-suon-se-vui-ve-ca-nam/?ref=PRC18">Khởi hành suôn sẻ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/"><div style="border-bottom: 1px solid darkgray;width: 159px;color: black;"></div></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/tra-gop-0-phan-tram/?ref=PRC__bottom">Trả góp lãi suất 0%</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__1">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-anh-du-lich/?ref=CAC11">Máy ảnh du lịch</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-anh-cao-cap/?ref=CAC12">Máy ảnh cao cấp</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-anh-chup-lay-ngay/?ref=CAC13">Máy ảnh chụp lấy ngay</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-anh-khong-guong-lat/?ref=CAC14">Máy ảnh không gương lật</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-anh-slr/?ref=CAC15">Máy ảnh DSLR/SLR</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/cac-loai-may-anh-khac/?ref=CAC16">Các loại máy ảnh khác</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-quay-phim/?ref=CAC17">Máy quay phim</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/phu-kien-may-anh-may-quay-phim/?ref=CAC18">Phụ kiện</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/chan-may-anh-tripod/?ref=CAC19">Chân máy ảnh Tripod</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/den-flash/?ref=CAC110">Đèn flash</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/ong-kinh/?ref=CAC112">Ống kính</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/kinh-loc/?ref=CAC111">Kính lọc</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/pin-may-anh/?ref=CAC113">Pin</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/tui-dung-may-anh-moi/?ref=CAC114">Túi đựng máy ảnh</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__2">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/he-thong-am-thanh/?ref=CEC11">Hệ thống âm thanh</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/tai-nghe-he-thong-am-thanh/?ref=CEC12">Tai nghe (Có dây, bluetooth)</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/mua-loa-di-dong//?ref=CEC13">Loa máy tính</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/thiet-bi-am-thanh-gia-dinh/?ref=CEC14">Dàn loa, Đầu Karaoke...</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-nghe-nhac-ipod/?ref=CEC15">Máy MP3 và iPod</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phu-kien-am-thanh-moi/?ref=CEC16">Phụ kiện âm thanh</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/tivi-chi-danh-cho-khach-hang-tphcm/?ref=CEC17">Tivi giá đặc biệt dành cho khách hàng TP.HCM <img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/tv-video-am-thanh-moi/?ref=CEC18">TV &amp; Đầu đĩa</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phu-kien-dien-tu/?ref=CEC19">Phụ kiện (Cáp, Remote, TV Box, Micro...)</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/tivi/?ref=CEC110">Tivi</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dvd-players/?ref=CEC111">Đầu đĩa DVD, Blu-ray &amp; HD</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-chieu/?ref=CEC112">Máy chiếu</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/game-moi/?ref=CEC113">Game (Chuột, bàn phím, đĩa game...)</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-game/?ref=CEC114">Máy chơi Game</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/gadget/?ref=CEC115">Thiết bị điện tử tiện ích</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/cac-thiet-bi-dien-tu-khac/?ref=CEC116">Khác (Bút Trình Chiếu, Máy Trợ Giảng, Thiêt Bị Dẫn Đường...)</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dong-ho-thong-minh/?ref=CEC117">Đồng hồ thông minh</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/thuoc-la-dien-tu/?ref=CEC118">Thuốc lá điện tử</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__3">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/deal-soc-tai-lazada/?ref=MTC11">Deal sốc chỉ có tại Lazada!<img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/smartphone/?ref=MTC12">Smartphones</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dien-thoai-pho-thong/?ref=MTC13">Điện Thoại Phổ Thông</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-tinh-bang/?ref=MTC14">Máy tính bảng</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-tinh-bang-ho-tro-chuc-nang-thoai/?ref=MTC15">Máy tính bảng (hỗ trợ chức năng thoại)</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-tinh-bang-khong-ho-tro-chuc-nang-thoai/?ref=MTC16">Máy tính bảng (không hỗ trợ chức năng thoại)</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/phu-kien-dien-thoai/?ref=MTC17">Phụ kiện điện thoại</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/vo-bao-dien-thoai/?ref=MTC18">Vỏ &amp; bao điện thoại</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/pin-va-bo-sac/?ref=MTC19">Pin &amp; Bộ sạc</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/the-nho-dien-thoai/?ref=MTC110">Thẻ nhớ</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/phu-kien-may-tinh-bang/?ref=MTC111">Phụ kiện máy tính bảng</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dien-thoai-ban/?ref=MTC112">Điện Thoại Bàn</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dien-thoai-may-tinh-bang/apple--apple-iphone--nokia--sam-sung--samsung--asus--oppo/">Thương hiệu nổi bật</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dien-thoai-may-tinh-bang/samsung/?ref=MTC115">Điện thoại SamSung</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dien-thoai-may-tinh-bang/asus/?ref=MTC116">Điện thoại Asus (Zenfone...)</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dien-thoai-may-tinh-bang/blackberry/?ref=MTC117">BlackBerry</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dien-thoai-may-tinh-bang/htc/?ref=MTC118">HTC</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dien-thoai-may-tinh-bang/apple/?ref=MTC119">Apple (iPhone, iPad)</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dien-thoai-may-tinh-bang/nokia/?ref=MTC120">Điện thoại Nokia</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__4">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/do-gia-dung-nha-bep/?ref=HAC11">Đồ gia dụng nhà bếp</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-xay-ep-trai-cay/?ref=HAC12">Máy xay &amp; ép trái cây</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/cac-loai-noi-dien/?ref=HAC13">Các loại nồi điện</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/noi-ap-suat/?ref=HAC14">Nồi áp suất điện</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/am-sieu-toc-binh-thuy-dien/?ref=HAC15">Ấm siêu tốc</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/do-gia-dung-lon/?ref=HAC16">Đồ gia dụng lớn</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/lo-vi-song-lo-nuong/?ref=HAC18">Lò vi sóng &amp; Lò nướng</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/tu-lanh/?ref=HAC19">Tủ lạnh</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-giat/?ref=HAC110">Máy giặt</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/huong-dan-lua-chon-do-gia-dung/?ref=HAC122">Hướng dẫn mua hàng <img src="http://static.lazada.vn/cms/fern.png"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dung-cu-thiet-bi-gia-dinh-moi/?ref=HAC111">Dụng cụ &amp; Thiết bị gia đình</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-hut-bui-cam-tay-moi/?ref=HAC112">Máy hút bụi cầm tay</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-hut-bui-co-tui-khong-tui-moi/?ref=HAC113">Máy hút bụi có túi &amp; không túi</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/choi-cay-lau-san-moi/?ref=HAC114">Chổi &amp; Cây lau sàn</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/thiet-bi-cham-soc-quan-ao-moi/?ref=HAC115">Thiết bị chăm sóc quần áo</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/ban-ui-moi/?ref=HAC116">Bàn ủi</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-may-moi/?ref=HAC117">Máy may</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/quat-may-nong-lanh-moi/?ref=HAC118">Quạt &amp; Máy nóng lạnh</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/quat-moi/?ref=HAC119">Quạt</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-lanh-moi/?ref=HAC120">Máy lạnh</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-nuoc-nong-moi/?ref=HAC121">Máy nước nóng</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__5">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/deal-soc-may-tinh-laptop/?ref=CLC11">Deal sốc chỉ có tại Lazada!<img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/laptop/?ref=CLC12">Laptop</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-tinh-de-ban-moi/?ref=CLC13">Máy tính để bàn</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/phu-kien-may-tinh-moi/?ref=CLC14">Phụ kiện máy tính (Chuột, bàn phím, usb, túi xách...)</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/o-cung-gan-ngoai/?ref=CLC15">Ổ Cứng Gắn Ngoài</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/usb/?ref=CLC16">USB</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/chuot-may-tinh/?ref=CLC17">Chuột</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/ban-phim/?ref=CLC18">Bàn phím</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/man-hinh-vi-tinh/?ref=CLC19">Màn hình</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/linh-kien-may-tinh/?ref=CLC110">Linh kiện máy tính (Ram, Bo mạch, Quạt...)</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/thiet-bi-mang/?ref=CLC111">Thiết bị mạng (USB 3G, Router Wifi...)</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-in-muc-in/?ref=CLC112">Máy in &amp; Mực in</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/may-vi-tinh-laptop/asus--apple--dell--lenovo--hp--acer/">Thương Hiệu Nổi Bật</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/laptop/asus/?ref=CLC114">Laptop Asus</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/laptop/acer/?ref=CLC115">Laptop Acer</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/laptop/dell/?ref=CLC116">Laptop Dell</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/laptop/hp/?ref=CLC117">Laptop HP</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/laptop/lenovo/?ref=CLC118">Laptop Lenovo</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/laptop/apple/?ref=CLC119">Laptop Macbook</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/laptop/sony/?ref=CLC120">Laptop Sony</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__6">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/lazada-at-home/?ref=HL1top">Lazada @ Home</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/tham-quan-mua-sam/?ref=HLC111">Tham quan mua sắm</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/hang-ban-chay-gia-cuc-tot/?ref=HLC11">Khuyến mãi đặc biệt <img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/do-dung-bep-phong-an/?ref=HLC12">Bếp &amp; phòng ăn</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/do-dung-nau-bep/?ref=HLC12A">Đồ dùng nấu bếp</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/do-dung-ban-an/?ref=HLC12B">Đồ dùng bàn ăn</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phu-kien-dung-cu-nha-bep/?ref=HLC12C">Phụ kiện &amp; dụng cụ nhà bếp</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/tan-trang-nha-cua/?ref=HLC14">Tân trang nhà cửa</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dung-cu-thiet-bi/?ref=HLC14B">Dụng cụ &amp; thiết bị</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dung-cu-cam-tay-2/?ref=HLC14A">Dụng cụ cầm tay</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/do-dung-phong-ngu-gia-dinh/?ref=HLC15">Chăn ra gối nệm</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/ngoai-troi-san-vuon/?ref=HLC16">Ngoài trời &amp; sân vườn</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/san-pham-trang-tri-nha-cua/?ref=HLC17">Trang trí nhà cửa</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/do-dung-phu-kien-phong-tam/?ref=HLC18">Đồ dùng phòng tắm</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/tu-dung-va-sap-xep-do/?ref=HLC19">Tủ đựng &amp; sắp xếp đồ</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/van-phong-pham-gia-dinh/?ref=HLC110">Văn phòng phẩm</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/loi-ich-cao-gia-sieu-re/?ref=HLC112">100 sản phẩm bán chạy</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/nha-cua-doi-song/luminarc--edena--skil--makita--akemi--moriitalia/?ref=HLC113">Thương hiệu hàng đầu</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/nha-cua-doi-song/luminarc/?ref=HLC114">Luminarc</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/nha-cua-doi-song/edena/">Edena</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/nha-cua-doi-song/moriitalia/">Moriitalia</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/nha-cua-doi-song/skil/">Skil</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__7">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/san-pham-ban-chay/dong-ho-uu-dai-dac-biet/?ref=WAC11">Deal sốc chỉ có ở Lazada!<img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dong-ho-uu-dai-dac-biet/?ref=WAC12">Khuyến mãi đặc biệt</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dong-ho-moi/invicta/?ref=WAC14">Xả hàng giá tốt <img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dong-ho/officina-del-attimo/?ref=WAC13">Hàng mới về<img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dong-ho-nam-gioi/?ref=WAC15">Đồng hồ nam</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dong-ho-casual-nam-gioi/?ref=WAC16">Đồng hồ thời trang</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dong-ho-business-nam-gioi/?ref=WAC17">Đồng hồ doanh nhân</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dong-ho-thoi-trang-danh-cho-nam-gioi/?ref=WAC18">Đồng hồ cá tính</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dong-ho-cao-cap-danh-cho-nam-gioi/?ref=WAC19">Đồng hồ cao cấp</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dong-ho-the-thao-nam-gioi/?ref=WAC110">Đồng hồ thể thao</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phu-kien-dong-ho-danh-cho-nam-gioi/?ref=WAC111">Dây đồng hồ</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dong-ho-nu-moi/?ref=WAC112">Đồng hồ nữ</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dong-ho-danh-cho-tre-em/?ref=WAC113">Đồng hồ trẻ em</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/mat-kinh-thoi-trang/?ref=WAC114">Mắt kính</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/kinh-mat-nu/?ref=WAC115">Mắt kính nữ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/kinh-mat-nam-thoi-trang/?ref=WAC116">Mắt Kính nam</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/trang-suc-nu/?ref=WAC117">Trang sức</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/trang-suc-nu/?ref=WAC118">Trang sức nữ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/trang-suc-thoi-trang-nam/?ref=WAC119">Trang sức nam</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/cac-phu-kien-thoi-trang/?ref=WAC120">Trang sức đôi</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__8">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/trang-diem/?ref=HBC11">Trang điểm</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/cham-soc-mat/?ref=HBC12">Chăm sóc mặt</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/cham-soc-da-mat/?ref=HBC14">Chăm sóc da mặt</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/cham-soc-da-vung-mat/?ref=HBC13">Chăm sóc da vùng mắt</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/cham-soc-toc-moi/?ref=HBC15">Chăm sóc tóc</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/nuoc-hoa/?ref=HBC16">Nước hoa</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/nuoc-hoa-cho-nu/?ref=HBC18">Nước hoa dành cho nữ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/nuoc-hoa-cho-nam/?ref=HBC17">Nước hoa dành cho nam</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/bo-nuoc-hoa/?ref=HBC19">Bộ quà tặng</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/san-pham-tam-cham-soc-co-the/?ref=HBC110">Tắm &amp; Chăm sóc cơ thể</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/danh-cho-nam-gioi-moi/?ref=HBC111">Dành cho nam giới</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/cham-soc-ca-nhan-suc-khoe/?ref=HBC113">Chăm sóc cá nhân &amp; sức khỏe</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/thiet-bi-cham-soc-suc-khoe-sac-dep/?ref=HBC112">Dụng cụ chăm sóc sức khỏe &amp; sắc đẹp</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/thuc-pham-chuc-nang-kiem-soat-can-nang/?ref=HBC114">Thực phẩm chức năng &amp; kiểm soát cân nặng mới</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/san-pham-ho-tro-tinh-duc/?ref=HBC115">Sản phẩm hỗ trợ tình dục</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/thiet-bi-y-te-2/?ref=HBC116">Thiết bị y tế</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/do-dinh-hinh/?ref=HBC117">Đồ định hình</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__9">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/xa-hang-cuoi-nam-tkb/">Xả hàng cuối năm</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/do-choi-khuyen-mai-dac-biet/">Khuyến mãi giá tốt <span style="color: red; font-size: 8px;">HOT</span></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/khuyen-mai-gia-tot/?ref=TKBC12">Sản phẩm bán chạy</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/lan-dau-lam-me-2/?ref=TKBC13">Lần đầu làm mẹ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/cham-soc-ba-me-mang-thai-moi/?ref=TKBC111">Chăm sóc bà mẹ mang thai</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/tre-so-sinh-moi/?ref=TKBC14">Trẻ sơ sinh</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/do-dung-bu-sua-an-dam-moi/?ref=TKBC15">Đồ dùng bú sữa &amp; ăn dặm</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/ta-dung-cu-ve-sinh-moi/?ref=TKBC16">Tã và dụng cụ vệ sinh</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/sua-thuc-an-dam/?ref=TKBC17">Sữa &amp; thức ăn dặm</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/xe-ghe-moi/?ref=TKBC18">Xe đẩy, địu, ghế ăn</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/do-dung-phong-ngu-moi/?ref=TKBC19">Đồ dùng phòng ngủ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/tam-cham-soc-co-the-tre-so-sinh-moi/?ref=TKBC110">Tắm &amp; chăm sóc trẻ sơ sinh</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/quan-ao-tre-so-sinh-moi/?ref=TKBC112">Quần áo trẻ sơ sinh</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/do-choi-moi/?ref=TKBC113">Đồ chơi</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/lap-rap-xay-dung-moi/?ref=TKBC114">Đồ chơi lắp ráp &amp; xây dựng</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/do-choi-giao-duc-moi/?ref=TKBC115">Đồ chơi giáo dục</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/do-choi-go-moi/?ref=TKBC116">Đồ chơi gỗ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/thu-cong-nghe-thuat-moi/?ref=TKBC118">Thủ công &amp; Nghệ thuật</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/xe-mo-hinh-dieu-khien-tu-xa-moi/?ref=TKBC119">Xe mô hình và điều khiển</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/">Khuyến Mãi</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/pigeon/?ref=TKBC121">Pigeon - tặng sữa tắm gội</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/gia-re-cho-me/?ref=TKBC124">Xe đẩy tặng địu em bé</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/cubic_fun/?ref=TKBC123">Cubic Fun tặng đồ chơi</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/ta-giay-cho-be/?ref=TKBC122">Tã giấy tặng kem chống hâm</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__10">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/dung-cu-the-thao-gia-tot/?ref=SPC11">Khuyễn mãi đặc biệt<img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/yoga-the-hinh/?ref=SPC12">Yoga &amp; Thể hình</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/yoga/?ref=SPC13">Yoga</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-tap-the-hinh/?ref=SPC14">Máy Tập Thể Hình</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/may-tap-the-luc/?ref=SPC15">Máy Tập Thể Lực</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/giay-trang-phuc-the-thao/?ref=SPC16">Giày và trang phục</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/do-the-thao-nu/?ref=SPC17">Dành Cho Nữ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/do-the-thao-nam/?ref=SPC18">Dành Cho Nam</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/cac-mon-tap-luyen-ca-nhan/?ref=SPC19">Tập Luyện Cá Nhân</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/tennis/?ref=SPC110">Tennis</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/bong-ban/?ref=SPC111">Bóng Bàn</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/cau-long/?ref=SPC112">Cầu Lông</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/golf/?ref=SPC113">Golf</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/boi-loi/?ref=SPC114">Bơi Lội</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/boxing/?ref=SPC115">Boxing</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/cac-mon-tap-luyen-doi-khang/?ref=SPC16">Thể Thao Đồng Đội</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/bong-da/?ref=SPC117">Bóng Đá</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/bong-ro/?ref=SPC118">Bóng Rổ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/bong-chuyen/?ref=SPC119">Bóng Chuyền</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/hoat-dong-da-ngoai/?ref=SPC120">Hoạt Động Dã Ngoại</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/da-ngoai-leo-nui/?ref=SPC121">Dã Ngoại &amp; Leo Núi</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/mon-xe-dap/?ref=SPC122">Xe Đạp</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/mon-the-thao-duoi-nuoc/?ref=SPC123">Thể Thao Dưới Nước</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__11">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/thoi-trang-nu/?ref=FAC11">Thời trang nữ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/tui-xach-nu/?skus[]=HU179FAADMX6VNAMZ&amp;skus[]=LA097FAACAR3VNAMZ&amp;skus[]=ME066OTAEIW3VNAMZ&amp;skus[]=SO624FAAF52RVNAMZ&amp;ref=FAC14">Túi xách nữ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/do-ngu-nu">Trang phục lót</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/trang-phuc-nu/">Trang phục nữ</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/giay-nu-thoi-trang/?skus[]=SE556FAAGJTFVNAMZ&amp;skus[]=MO059FAAFPBQVNAMZ&amp;skus[]=GA029FAAGKW9VNAMZ&amp;skus[]=GI829FAACLXYVNAMZ&amp;ref=FAC18">Giày nữ</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/giay-cao-got-thoi-trang-nu-moi/?skus[]=SO624FAAFZAIVNAMZ&amp;skus[]=SE556FAAG2RUVNAMZ&amp;skus[]=MO059FAAFPJPVNAMZ&amp;skus[]=LZ900FAAEVCAVNAMZ&amp;ref=FAC18">Giày cao gót</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/giay-nu-de-bang-moi/?ref=FAC19">Giày đế bằng</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/giay-de-xuong-thoi-trang-nu-moi/?ref=FAC110">Giày đế xuồng</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/xang-dan-dep-thoi-trang-nu-moi/?skus[]=GI829FAACIM4VNAMZ&amp;skus[]=SE556FAAG2RSVNAMZ&amp;skus[]=ME066FAAF68OVNAMZ&amp;skus[]=LZ900FAAEL11VNAMZ&amp;ref=FAC111">Xăng đan &amp; Dép</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/thoi-trang-nam/?skus[]=BL989FAACNOUVNAMZ&amp;skus[]=NG472FAADMVRVNAMZ&amp;skus[]=MS519FAADDG3VNAMZ&amp;skus[]=KI017FAABZN0VNAMZ&amp;ref=FAC113">Thời trang nam</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/trang-phuc-nam/?skus[]=5C204FAAE9PPVNAMZ&amp;skus[]=HU968FAACMIZVNAMZ&amp;skus[]=NG472FAAFEC8VNAMZ&amp;skus[]=VI461FAAFEA2VNAMZ&amp;ref=FAC114">Trang phục nam</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/tui-xach-nam/?skus[]=HU179FAADMW1VNAMZ&amp;skus[]=CA639FAACE6WVNAMZ&amp;skus[]=LA097FAADMRCVNAMZ&amp;skus[]=EL261FAAF77TVNAMZ&amp;ref=FAC115">Túi xách nam</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phu-kien-thoi-trang-nam/?skus[]=AR585FAACPQTVNAMZ&amp;skus[]=AR585FAACBGUVNAMZ&amp;skus[]=AS925FAAC67XVNAMZ&amp;skus[]=AN995FAAC1COVNAMZ&amp;ref=FAC117">Phụ kiện thời trang</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/giay-nam-thoi-trang/?skus[]=ON948FAADKGJVNAMZ&amp;skus[]=HU179FAACTEUVNAMZ&amp;skus[]=GI039FAAG27WVNAMZ&amp;skus[]=KE099FAAC3OZVNAMZ&amp;ref=FAC119">Giày nam</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/giay-casual-thoi-trang-nam-moi/?skus[]=AN995FAABXZOVNAMZ&amp;skus[]=EL261FAACBY3VNAMZ&amp;skus[]=GA348FAACWM5VNAMZ&amp;skus[]=AQ273FAAFCVZVNAMZ&amp;ref=FAC120">Giày Casual</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/giay-de-bang-nam-thoi-trang/?skus[]=MS519FAAELGQVNAMZ&amp;skus[]=AQ667FAAGEDTVNAMZ&amp;skus[]=TH702FAAFUXWVNAMZ&amp;skus[]=SO624FAAFUDZVNAMZ&amp;ref=FAC21">Giày đế bằng</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/xang-dan-dep-thoi-trang-nam-moi/?skus[]=GA029FAAERXGVNAMZ&amp;skus[]=CO706FAAD7AJVNAMZ&amp;skus[]=DS304FAADLXIVNAMZ&amp;skus[]=TH702FAAG7WUVNAMZ&amp;ref=FAC122">Xăng đan &amp; Dép</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/phong-cach/?ref=FAC121">Thời trang phong cách</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phong-cach-don-gian/?ref=FAC122">Phong cách Basics</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/hoa-tiet/?ref=FAC124">Phong cách họa tiết</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phong-cach-pop/?ref=FAC123">Phong cách Pop</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__12">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/giam-gia/oto-xe-may-thiet-bi-dinh-vi/?ref=ANC11">Khuyến mãi HOT<img src="//static.lazada.vn/cms/Flame-rev.gif"></a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/xe-dep-ruoc-nang/">Xe đẹp rước nàng</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phu-kien-oto-xe-may-hot/">Phụ kiện Ô tô Xe máy HOT nhất</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/o-to-xe-may-xa-hang/?ref=ANC21">Xả hàng đón Tết - Mua ngay kẻo hết</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/xe-may/?ref=ANC">Xe máy</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/mu-bao-hiem/">Mũ bảo hiểm</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/catalog/?q=khóa+chống+trộm+xe+máy">Khóa chống trộm xe máy</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/tai-dat/">Đồ bảo hộ mô tô, xe máy</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/linh-kien-thay-the-o-to-xe-may/">Phụ tùng xe máy</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/o-to-xe-may/?ref=ANC">Ô tô</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/dung-cu-cam-tay-o-to-xe-may/">Dụng cụ khẩn cấp cho xe</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/thiet-bi-dinh-vi/">Thiết bị định vị, dẫn đường</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/thiet-bi-ho-tro-khoi-dong-pin-cam-tay/">Hỗ trợ khởi động &amp; pin cầm tay</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/banh-xe-vo-lop-o-to-xe-may/">Bơm lốp xe</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/den-phu-kien-o-to-xe-may/">Đèn &amp; Phụ kiện</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/thiet-bi-dien-tu/">Camera hành trình &amp; Thiết bị điện tử</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phu-kien-xe-hoi/">Đồ chơi xe hơi</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/ngoai-that-o-to-xe-may/">Chăm sóc xe hơi</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/phu-kien-trong-o-to-xe-may/">Nội thất ô tô</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/xit-thom-xe-hoi/">Thế giới mùi thơm</a>                              </li>
                                    </ul>
                                </div>


                                <div class="sidebarSecond__content sidebar__13">
                                    <ul class="sidebarSecond__list">
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/ba-lo-tui-xach-du-lich/?ref=ANC11">Ba lô &amp; túi xách du lịch</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/ba-lo-du-lich/?ref=ANC12">Ba lô</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/ba-lo-tui-dung-laptop/?ref=ANC13">Túi đựng balô &amp; Laptop</a>                              </li>
                                        <li class="sidebarSecond__itemTitle">
                                            <a href="/vali-du-lich/?ref=ANC14">Vali du lịch</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/va-li-du-lich-xach-tay/?ref=ANC15">Vali du lịch xách tay</a>                              </li>
                                        <li class="sidebarSecond__itemSecond">
                                            <a href="/hanh-ly-xach-tay/?ref=ANC16">Hành lý xách tay</a>                              </li>
                                    </ul>
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
                                <h3>Máy ảnh &amp; Máy quay phim</h3>
                            </li>
                        </ul>
                    </div>
                    <div style="display:none" id="active-segments-roots" data-active-segment="" data-active-root=""></div>
                </div>
            </div>
        </div>
</div>
<script type="text/javascript">
$(function(){
    $('.header__menu__title').hover(function(){
        $('.header__menu__container').attr('style','display:inline');
        $('.header__menu__overlayBG').attr('style','display:inlineheader__bottom__menu');
    });
    $('.header__menu__container').mouseleave(function(){
        $('.header__menu__container').attr('style','display:none');
        $('.header__menu__overlayBG').attr('style','display:none');
    });
});
</script>