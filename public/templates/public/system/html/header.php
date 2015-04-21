<div class="container-fluid">
    <div class="col-md-12">
        <nav class="navbar navbar-default">
            <div class="col-md-12">
                <div class="header_top">
                    <div class="contact-navigation">
                        <!-- <p class="hotcontact">Điện thoại: (08) 3720 555 2    -   Email: weancpn@gmail.com    -    Hotline: 0917 311 001</p> -->
                    </div>
                    <div class="header_navigation">
                        <div class="customer-care">
                            <div class="btn-group">
                                <button type="button" class="btn btn-default dropdown-toggle  btn-sm" data-toggle="dropdown" aria-expanded="false">
                                    Chăm Sóc Khách Hàng <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu">
                                    <li><a href="#">Trung Tâm Hỗ Trợ</a></li>
                                    <li><a href="#">Đơn Hàng Và Thanh Toán</a></li>
                                    <li><a href="#">Giao Hàng Và Nhận Hàng</a></li>
                                    <li><a href="#">Đổi Trả Hàng Và Hoàn Tiền</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="btn-group">
                            <div class="dropdown">
                                <button class="btn btn-default dropdown-toggle testVoice" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-expanded="true">
                                    Kiểm Tra Đơn Hàng
                                    <span class="caret"></span>
                                </button>
                                <form class="dropdown-menu" role="menu" aria-labelledby="dropdownMenu1">
                                    <label>KIỂM TRA ĐƠN HÀNG</label>
                                    <div class="form-group">
                                        <label for="Kiểm Tra Đơn Hàng">Vui Lòng Nhập Mã Đơn Hàng:</label>
                                        <input type="text" class="form-control" placeholder="Mã Đơn Hàng">
                                    </div>
                                    <div class="form-group">
                                        <label for="exampleInputEmail1">Vui Lòng Nhập Vào Email: </label>
                                        <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email">
                                    </div>
                                    <button type="submit" class="btn btn-warning">KẾT QUẢ</button>
                                </form>
                            </div>
                        </div>
                        <?php
                        $session = new Zend_Session_Namespace('facebookInfoUser');
                        $facebookUserInfo = $session->getIterator();
                        $name = $facebookUserInfo['facebookInfoUser']->name;
                        if (!empty($name)) {
                            echo '<a class="userInfo">Xin Chào: ' . $name . '</a>';
                            echo '<a href="' . $this->baseUrl() . '/default/index/logout-facebook" class="userInfo">Thoát</a>';
                        } else if ($this->userInfo['member']['email'] != null) {
                            echo '<a class="userInfo">Xin Chào:' . $this->userInfo['member']['email'] . '</a>';
                            if ($this->userInfo['acl']['role'] == 'Supper admin')
                                echo '<a class="userInfo" href="default/admin">Trang Quản Trị</a>';
                            echo '<a href="' . $this->baseUrl() . '/default/public/logout" class="userInfo">Thoát</a>';
                        }
                        else {
                            ?>
                            <button type="button" class="btn btn-primary btn-lg login" data-toggle="modal" data-target="#myModal">
                                Đăng Nhập | Đăng Ký
                            </button>
                        <?php }
                        ?>
                        </ul>
                        <!-- Modal -->
                        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title" id="myModalLabel">Đăng Nhập Hoặc Đăng Ký</h4>
                                    </div>
                                    <div class="modal-body">
                                        <div role="tabpanel">
                                            <!-- Nav tabs -->
                                            <ul class="nav nav-tabs" role="tablist">
                                                <li role="presentation" class="active"><a href="#login" aria-controls="home" role="tab" data-toggle="tab">LOGIN</a></li>
                                                <li role="presentation"><a href="#singIn" aria-controls="profile" role="tab" data-toggle="tab">SIGN IN</a></li>
                                            </ul>

                                            <!-- Tab panes -->
                                            <div class="tab-content">
                                                <div role="tabpanel" class="tab-pane active" id="login">
                                                    <div class="img-buy">
                                                        <form class="form-horizontal" id="form-login">
                                                            <div class="form-group">
                                                                <div class="col-sm-10">
                                                                    <div class="ang" id="email-login">
                                                                        <input type="email" name="email" class="form-control email-login" placeholder="Email">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-10">
                                                                    <div class="ang" id="password-login">
                                                                        <input type="password" name="password" class="form-control password-login" placeholder="Password">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-offset-2 col-sm-10">
                                                                    <div class="remember">
                                                                        <label>
                                                                            <input type="checkbox"> Nhớ Tôi
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="btn-register">
                                                                <div class="col-sm-offset-2 col-sm-10">
                                                                    <button type="button" class="btn btn-success" id="btn-login" onClick="login()">Đăng Nhập</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="facebook-login">
                                                        <div class="title"><strong>Đăng Nhập Bằng Facebook</strong></div>
                                                        <a href="https://www.facebook.com/dialog/oauth?client_id=237595173077700&redirect_uri=http://congtynem.com/vn/default/index/info-user-facebook">
                                                            <img src="<?php echo $this->imgUrl . '/facebookicon_login.png' ?>"/>
                                                        </a>
                                                    </div>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="singIn">
                                                    <div class="img-buy">
                                                        <form class="form-horizontal">
                                                            <div class="form-group">
                                                                <div class="col-sm-10">
                                                                    <div class="ang" id="name">
                                                                        <input type="text" class="form-control user name" name="last_name" placeholder="Họ Và Tên">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-10">
                                                                    <div class="ang" id="email">
                                                                        <input type="email" class="form-control email" name="email" placeholder="Đia Chỉ Email">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-10">
                                                                    <div class="ang" id="phone">
                                                                        <input type="number" class="form-control user-phone" name="phone" placeholder="Số Điện Thoại">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-10">
                                                                    <div class="ang" id="password">
                                                                        <input type="password" class="form-control password" name="password" placeholder="Mật Khẩu">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-10">
                                                                    <div class="ang" id="re-password">
                                                                        <input type="password" class="form-control re-password" name="re-password" placeholder="Mật Khẩu">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <div class="col-sm-10">
                                                                    <div class="ang" id="birthday">
                                                                        <input type="date" class="form-control" name="birthday" placeholder="Ngày Sinh">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="btn-register">
                                                                <div class="col-sm-offset-2 col-sm-10">
                                                                    <button  type="button" class="btn btn-success" id="btn-register" onClick="signIn()">Đăng Ký</button>
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                    <div class="facebook-login">
                                                        <div class="title"><strong>Đăng Nhập Bằng Facebook</strong></div>
                                                        <a href="https://www.facebook.com/dialog/oauth?client_id=237595173077700&redirect_uri=http://congtynem.com/vn/default/index/info-user-facebook">
                                                            <img src="<?php echo $this->imgUrl . '/facebookicon_login.png' ?>"/>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="col-md-12 header default">
                <div class="header-wrapper">
                    <div class="header-content util-clearfix">
                        <div class="logo">
                            <a href="https://www.congtynem.com/vn" itemprop="url" title="CONGTYNEM.COM - Mua sắm trực tuyến uy tín số 1 trong giao dịch, giá tốt nhất thị trường">
                                <img itemprop="logo" src="<?php echo $this->imgUrl ?>/logo.png" alt="CONGTYNEM.COM - Mua sắm trực tuyến uy tín số 1 trong giao dịch, giá tốt nhất thị trường" title="SENDO.VN - Mua sắm trực tuyến uy tín số 1 trong giao dịch, giá tốt nhất thị trường" width="207" height="85">
                            </a>
                        </div>
                        <div class="block-search-wrap">
                            <div class="block-search">
                                <div class="search-bar">
                                    <form method="GET" onsubmit="" action=" class="ng-pristine ng-valid">
                                          <div class="search-input-select">			
                                            <input id="search_keyword" name="search_keyword" value="" placeholder="Nhập từ khoá tìm kiếm" type="search" class="search-txt" autocomplete="off">
                                            <input id="mID" type="hidden" value="" name="mID"/>
                                            <div class="results" style='display: none'></div>
                                        </div>			
                                        <button class="search-btn" title="Tìm">Tìm kiếm</button>
                                    </form>
                                </div>
                                <div class="tags-search">
                                    <span>Top tìm kiếm:</span>
                                    <strong><a class="" href="" title="nệm cao su">Nệm cao su</a></strong>
                                    <strong><a class="" href="" title="nệm nhân tạo">Nệm nhân tạo</a></strong>
                                    <strong><a class="" href="" title="nệm giá rẻ">Nệm giá rẻ</a></strong>
                                    <strong><a class="l-end" href="" title="nệm lò xo">Nệm lò xo</a></strong>
                                    <strong><a class="end" href="" title="nệm vạn thành">Nệm vạn thành</a></strong>
                                    <a class="vm" rel="dofollow" href="" title="Xem thêm">Xem thêm »</a>
                                </div>
                            </div>
                        </div>
                        <div class="box-info">
                            <div class="box-link util-clearfix login-roi" id="Notify-controller">
                                <div class="cart-mini" id="cart_mini" style="display: none;">	
                                    <h3 class="title">Giỏ hàng mini</h3>
                                    <span class="close" title="Đóng lại"></span>
                                    <div id="cart_loader">
                                        <ul>
                                            <?php
                                            $sum = 0;
                                            $i=0;
                                            if (!empty($this->Item)) {
                                                foreach ($this->Item as $key => $val) {
                                                    foreach ($this->cart[$val['id']] as $idPro => $valCart) {
                                                        if($idPro > 0)
                                                                echo '<li id="gio_hang_sp_'. $idPro. '">';
                                                            else
                                                                echo '<li id="gio_hang_sp_'. $val['id']. '">';
                                                        ?>
                                                            <a href="<?php echo $this->baseUrl($val['alias'] . '-' . $val['id'] . '.html') ?>" target="_blank" title="<?php echo $val['name'] ?>"><img src="public/files/products/images450x450/<?php echo $val['picture'] ?>" class="cart-img"></a>
                                                            <h3><a href="<?php echo $this->baseUrl($val['alias'] . '-' . $val['id'] . '.html') ?>" title="<?php echo $val['name'] ?>" target="_blank"><?php echo $val['name'] ?></a></h3>
                                                            <h2>
                                                                <?php
                                                                if ($idPro > 0){
                                                                    if($valCart['selloff']>0){
                                                                        echo number_format($valCart['selloff'],0);
                                                                        $sum = $sum + $valCart['selloff'] * $valCart['number'];
                                                                    }
                                                                    else{
                                                                        echo number_format($valCart['price'],0);
                                                                        $sum = $sum + $valCart['price'] * $valCart['number'];
                                                                    }
                                                                }
                                                                else{
                                                                    if($val['selloff']>0){
                                                                        echo number_format($val['selloff'],0);
                                                                        $sum = $sum + $val['selloff'] * $this->cart[$val['id']]['number'];
                                                                    }
                                                                    else{
                                                                        echo number_format($val['price'],0);
                                                                        $sum = $sum + $val['price'] * $this->cart[$val['id']]['number'];
                                                                    }
                                                                    
                                                                }
                                                               echo '</h2>'; 
                                                                if (!isset($this->cart[$val['id']][$idPro]['size']))
                                                                    echo ' <p>(Size : Mặc định)</p>';
                                                                else
                                                                    echo ' <p>(Size : ' . $this->cart[$val['id']][$idPro]['size'] . ')</p>';
                                                                
                                                                if($idPro >0 )
                                                                    echo '<a href="javascript:;" class="cart-less">x</a><span class="sluong_'.$idPro.'">'.$valCart['number'] .'</span>';
                                                                else
                                                                    echo '<a href="javascript:;" class="cart-less">x</a><span class="sluong_'.$val['id'].'">'. $this->cart[$val['id']]['number'] .'</span>';
                                                                    
                                                                if($idPro > 0)
                                                                    echo '<a onclick="huycm('.$val['id']. ','.$idPro.');" href="javascript:;" title="Hủy đặt mua" class="cart-remove">Hủy</a>';
                                                                else
                                                                    echo '<a onclick="huycm('.$val['id'].');" href="javascript:;" title="Hủy đặt mua" class="cart-remove">Hủy</a>';
                                                                ?>
                                                                <div class="clearfix"></div>
                                                        </li>
                                                        <?php
                                                        $i++;
                                                    } 
                                                }
                                            }
                                            else
                                                echo '<span style="color:green">Không có sản phẩm nào trong giỏ hàng</span>';
                                            ?>
                                        </ul>
                                        <p class="total">Tổng đơn hàng : <b id="gio_hang_tong"><?php echo number_format($sum, 0) ?></b></p>
                                    </div>
                                    <a href="default/cart" class="cart-enter">Vào giỏ hàng</a>
                                </div>
                                <div class="box-l-c cart" id="cart_expand">            
                                    <a class="box-link-svg" title="Giỏ hàng"> 
                                        <i class="icon-cart icon-giohang"></i>             
                                        <?php
                                        if ($i> 0) {
                                            echo '<b class="cart_qty">' . $i . '</b>';
                                        }
                                        ?>
                                    </a>
                                </div>
                                <div id="box_link_notify" class="box-l-c mess"> 
                                    <a class="box-link-svg" href="javascript:void(0);" rel="nofollow" title="Thông báo" data-item="0">
                                        <i class="icon-cart icon-tuvan"></i>

                                    </a>
                                </div>
                                <div class="box-l-c favorite ng-scope" id="boxFavorite" ng-controller="Wishlist" data-ng-init="getWishlist()">
                                    <a class="box-link-svg" rel="nofollow" href="javascript:void(0);" title="Sản phẩm quan tâm" onclick="get_wishlist()">
                                        <i class="icon-cart icon-spyeuthich"></i>

                                        <!-- ngIf: wishliststore_count > 0 --><div ng-if="wishliststore_count > 0" class="ng-scope">
                                            <span class="favorite-count ng-isolate-scope ng-binding" renderdata="" data="3">3</span>
                                        </div><!-- end ngIf: wishliststore_count > 0 -->
                                    </a>      
                                    <span class="bt-click2 none" data-ng-click="getWishlist()">&nbsp;</span>
                                </div>
                                <div class="box-l-c login " id="login-deafault"> 
                                    <a class="box-link-svg" title="Tổng Đài"> 
                                        <i class="icon-cart icon-giaohang"></i>

                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>   
</div><!-- /.container-fluid -->



<div class="modal fade register-success" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="ppu_header">
            <p class="ppu_h_title">HÃY MUA HÀNG ĐỂ NHẬN NGAY CHƯƠNG TRÌNH ƯU ĐÃI CỰC LỚN</p>
            <p class="ppu_h_noti">(Nhanh tay kẻo hết)</p>
        </div>
        <div class="ppu_ss_main">
                <input type="hidden" id="orderID" value="1805861">
            <img src="<?php echo  $this->imgUrl?>/ppu_ss_icon.png">
            <p class="ppu_ss_title">Đăng ký thành công!</p>
            <div class="ppu_ss_infos">
                    <p>Cảm ơn bạn <b id="ten-nguoi-mua"></b> đã cho chúng tôi cơ hội được phục vụ!</p>
                                <p class="ppu_bt_call"><i>Tư vấn miễn phí: <strong><span class="popup-bfont popup-red">0917 311 001</span></strong></i></p>
            </div>
            <div class="popup-spt-bottom">
            </div>
        </div>
    </div>
  </div>
</div>