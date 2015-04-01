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
                            if($this->userInfo['member']['email']!=null){
                                echo '<a class="userInfo">Xin Chào:'. $this->userInfo['member']['email']. '</a>';
                                echo '<a href="'. $this->baseUrl(). '/default/public/logout" class="userInfo">Thoát</a>';
                            }
                            else{
                        ?>
                        <button type="button" class="btn btn-primary btn-lg login" data-toggle="modal" data-target="#myModal">
                            Đăng Nhập | Đăng Ký
                        </button>
                            <?php }?>
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
                                                    <form class="form-horizontal" id="form-login">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                                                            <div class="col-sm-10">
                                                                <input type="email" name="email" class="form-control" id="email-login" placeholder="Email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" name="password" class="form-control" id="password-login" placeholder="Password">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <div class="checkbox">
                                                                    <label>
                                                                        <input type="checkbox"> Nhớ Tôi
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <button type="button" class="btn btn-success" id="btn-login">Đăng Nhập</button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                                <div role="tabpanel" class="tab-pane" id="singIn">
                                                    <form class="form-horizontal">
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-2 control-label">Họ Và Tên:</label>
                                                            <div class="col-sm-10">
                                                                <input type="text" class="form-control" name="last_name" id="name" placeholder="Họ Và Tên">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-2 control-label">Email:</label>
                                                            <div class="col-sm-10">
                                                                <input type="email" class="form-control" name="email" id="email" placeholder="Đia Chỉ Email">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputEmail3" class="col-sm-2 control-label">Số Điện Thoại: </label>
                                                            <div class="col-sm-10">
                                                                <input type="email" class="form-control" name="phone" id="phone" placeholder="Số Điện Thoại">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword3" class="col-sm-2 control-label">Mật Khẩu:</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" class="form-control" name="password" id="password" placeholder="Mật Khẩu">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword3" class="col-sm-2 control-label">Nhập Lại Mật Khẩu:</label>
                                                            <div class="col-sm-10">
                                                                <input type="password" class="form-control" name="re-password" id="re-password" placeholder="Mật Khẩu">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <label for="inputPassword3" class="col-sm-2 control-label">Ngày Sinh:</label>
                                                            <div class="col-sm-10">
                                                                <input type="date" class="form-control" id="birthday" name="birthday" placeholder="Ngày Sinh">
                                                            </div>
                                                        </div>
                                                        <div class="form-group">
                                                            <div class="col-sm-offset-2 col-sm-10">
                                                                <button  type="button" class="btn btn-success" id="btn-register">Đăng Ký</button>
                                                            </div>
                                                        </div>
                                                    </form>
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
                            <a href="https://www.congtynem.com" itemprop="url" title="CONGTYNEM.COM - Mua sắm trực tuyến uy tín số 1 trong giao dịch, giá tốt nhất thị trường">
                                    <img itemprop="logo" src="<?php echo $this->imgUrl?>/logo.png" alt="CONGTYNEM.COM - Mua sắm trực tuyến uy tín số 1 trong giao dịch, giá tốt nhất thị trường" title="SENDO.VN - Mua sắm trực tuyến uy tín số 1 trong giao dịch, giá tốt nhất thị trường" width="207" height="85">
                                </a>
                        </div>
                        <div class="block-search-wrap">
                            <div class="block-search">
                                <div class="search-bar">
                                    <form method="GET" onsubmit="" action=" class="ng-pristine ng-valid">
                                        <div class="search-input-select">			
                                            <input id="search_keyword" name="search_keyword" value="" placeholder="Nhập từ khoá tìm kiếm" type="search" class="search-txt" autocomplete="off">
                                            <input id="mID" type="hidden" value="" name="mID"/>
                                            <div class="results"></div>
                                        </div>			
                                        <button class="search-btn" title="Tìm">Tìm kiếm</button>
                                    </form>
                                </div>
                                <div class="tags-search">
                                    <span>Top tìm kiếm:</span>
                                    <strong><a class="" href="" title="giày cao gót">nệm cao su</a></strong>
                                    <strong><a class="" href="" title="quần legging">nệm nhân tạo</a></strong>
                                    <strong><a class="" href="" title="đầm maxi">nệm giá rẻ</a></strong>
                                    <strong><a class="l-end" href="" title="quần yếm">nệm lò xo</a></strong>
                                    <strong><a class="end" href="" title="đầm suông">nệm vạn thành</a></strong>
                                    <a class="vm" rel="dofollow" href="" title="Xem thêm">Xem thêm »</a>
                                </div>
                            </div>
                        </div>
                        <div class="box-info">
                            <div class="box-link util-clearfix login-roi" id="Notify-controller">
                                <div class="box-l-c cart">            
                                    <a class="box-link-svg" rel="nofollow" href="javascript:void(0);" title="Giỏ hàng"> 
                                        <i class="icon-cart"></i>             
                                        <span class="tl">Giỏ hàng </span> 
                                        <b class="cart_qty">0</b>
                                    </a>
                                </div>
                                <div id="box_link_notify" class="box-l-c mess"> 
                                    <a class="box-link-svg" href="javascript:void(0);" rel="nofollow" title="Thông báo" data-item="0">
                                       <i class="icon-notify"></i>
                                        <span class="tl">Thông báo</span>
                                    </a>
                                </div>
                                <div class="box-l-c favorite ng-scope" id="boxFavorite" ng-controller="Wishlist" data-ng-init="getWishlist()">
                                    <a class="box-link-svg" rel="nofollow" href="javascript:void(0);" title="Sản phẩm quan tâm" onclick="get_wishlist()">
                                        <i class="icon-like"></i>
                                        <span class="tl">Yêu thích</span>
                                        <!-- ngIf: wishliststore_count > 0 --><div ng-if="wishliststore_count > 0" class="ng-scope">
                                            <span class="favorite-count ng-isolate-scope ng-binding" renderdata="" data="3">3</span>
                                        </div><!-- end ngIf: wishliststore_count > 0 -->
                                    </a>      
                                    <span class="bt-click2 none" data-ng-click="getWishlist()">&nbsp;</span>
                                </div>
                                <div class="box-l-c login " id="login-deafault"> 
                                    <a class="box-link-svg" title="Tổng Đài"> 
                                        <i class="icon-infomation"></i>
                                        <span class="tl">Thông Tin</span>
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
<script>
$('document').ready(function() {
    $('#btn-login').click(function(e) {
        var email = $('#email-login').val();
        var password = $('#password-login').val();
        $.ajax({
            url: "<?php echo $this->baseUrl()?>" + "/default/public/login?email=" + email + "&password=" + password,
            type: "GET",
            dataType: "json",
            success: function(data, status) {
                $('#email-login + span').remove();
                $('#password-login + span').remove();
                if (typeof(data.email) != "undefined") {
                    $('#email-login').after('<span style="color:red">(*) ' + data.email + '<span>');
                }
                if (typeof(data.password) != "undefined") {
                    $('#password-login').after('<span style="color:red">(*) ' + data.password + '<span>');
                }
                if (typeof(data.loginError) != "undefined")
                    $('#password-login').after('<span style="color:red">(*) ' + data.loginError + '<span>');
                if (data.success == 1)
                    window.location = '<?php echo $this->baseUrl()?>' + '/default/admin/index/';
            }
        });
    });
    $('#btn-register').click(function(e) {
        var name = $('#name').val();
        var email = $('#email').val();
        var phone = $('#phone').val();
        var password = $('#password').val();
        var rePassword = $('#re-password').val();
        $.ajax({
            url: "<?php echo $this->baseUrl()?>" + "/default/public/register?last_name="+ name +" &phone=" + phone + "&email=" + email + "&password=" + password + "&re-password=" + rePassword,
            type: "GET",
            dataType: "json",
            success: function(data, status) {
                console.log(data);
                $('#name + span').remove();
                $('#email + span').remove();
                $('#phone + span').remove();
                $('#password + span').remove();
                $('#re-password + span').remove();
                if (typeof(data.email) != "undefined") {
                    $('#email').after('<span style="color:red">(*) ' + data.email + '</span>');
                }
                if (typeof(data.password) != "undefined") {
                    $('#password').after('<span style="color:red">(*) ' + data.password + '</span>');
                }
                if (typeof(data.last_name) != "undefined"){
                    $('#name').after('<span style="color:red">(*) ' + data.last_name + '</span>');
                }
                if (typeof(data.re_password) != "undefined"){
                    $('#re-password').after('<span style="color:red">(*) ' + data.re_password + '</span>');
                }
                if (typeof(data.phone) != "undefined"){
                    $('#phone').after('<span style="color:red">(*) ' + data.phone + '</span>');
                }
                if(data.success==1)
                    $('#birthday').after('<span style="color:green">(*) Bạn Đã Đăng Ký Thành Công. Hãy Đăng Nhập Để Được Nhận Nhiều Ưu Đãi!<span>');
                //window.location = '<?php //echo $this->baseUrl()?>' + '/default/admin/index/';
            }
        });
    });
});
</script>