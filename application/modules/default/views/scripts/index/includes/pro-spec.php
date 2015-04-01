<?php
	include 'lang.php';
	$tblPro	= new Zendvn_Models_ProItem();
	$nemCaoSu	= $tblPro->listItem($this->arrParam,array('task'=>'pro-cate'),226);
        $nemNhanTao     = $tblPro->listItem($this->arrParam,array('task'=>'pro-cate'),242);
        $nemLoxo    = $tblPro->listItem($this->arrParam,array('task'=>'pro-cate'),227);
        $nemBongEp     = $tblPro->listItem($this->arrParam,array('task'=>'pro-cate'),225);
        $nemDrap     = $tblPro->listItem($this->arrParam,array('task'=>'pro-cate'),224);
	if (!empty($nemCaoSu)){
?>
<div class='box-right-pro width-100'>
    <div class='sub-box-right'><span class='icon-right'><img src="<?php echo $this->imgUrl ?>/icon/icon-sub-right.png"></span>
        <ul class="btnCompany">
            <li class='nameCategory'><a href="<?php echo $this->baseUrl('san-pham/226-nem-cao-su-1.html')?>">NỆM CAO SU</a></li>
            <li><a href="<?php echo $this->baseUrl('san-pham/226-165-nem-cao-su-1.html')?>">LIÊN Á</a></li>
            <li class='kt'>|</li>
            <li><a href="<?php echo $this->baseUrl('san-pham/226-163-nem-cao-su-1.html')?>">VẠN THÀNH</a></li>
            <li class='kt'>|</li>
            <li><a href="<?php echo $this->baseUrl('san-pham/226-176-nem-cao-su-1.html')?>">KIM CƯƠNG</a></li>
            <li class='kt'>|</li>
            <li><a href="<?php echo $this->baseUrl('san-pham/226-166-nem-cao-su-1.html')?>">ĐỒNG PHÚ</a></li>
        </ul>
    </div>
                                                <div class='cnt-right width-100' id="listProduct" style="left:0px">
							<?php
								foreach ($nemCaoSu as $key => $value){
                                                                        if($key < 8){
									$cutTring 	= new Zendvn_File_CutTring();
									$name		= str_replace("\\","",$value['name']);
								//	$name		= $cutTring->cutTring(25, $name, null);
									
									$alt		= str_replace("\\","",$value['alt_seo']);
									if(empty($value['alt_seo'])) $alt = str_replace("\\","",$value['name']);
									
									$summary	= str_replace("\\","",$value['summary']);
									$summary	= $cutTring->cutTring(120, $summary, null);
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									
									$sale		= $value['sale'];
									$menu_id	= $value['menu_id'];
									include 'sale.php';
									
									$val_sell 	= '';
									$sale_off 	= '';
									if ($value['selloff'] != 0){
										$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
									}
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									if($value['val_sell'] != 0){
										$price 	= '<p class="price-right-pro  line-through">' . number_format($value['price'],0) . ' VND</p>';
									}
									if ($sale != 0){
										$sale_off 	= $value['price'] - ($value['price']*$sale/100);
										$sale_off	= '<p class="sale">' . number_format($sale_off,0) . ' VND</p>';
										$price 		= '<p class="price-right-pro line-through">' . number_format($value['price'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $sale .'%</div>';
										if($value['val_sell'] != 0){
											$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
											$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										}
									}
									if($value['price'] == 0) $price = '<p style="color:red; font-size:1em" class="price">Liên hệ</p>';
									
									if(!empty($value['picture'])){
										$linkImg	= FILES_URL . '/products/orignal/' . $value['picture'];
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}else{
										$linkImg	= $this->imgUrl . '/no-image.jpg';
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}
									
									$urlOptions = array('module'=>'products','controller'=>'index',
																'action'=>'detail',
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias']);
									$linkDetail = $this->url($urlOptions,'products-detail');
									$urlOptions2 = array('module'=>'products','controller'=>'index',
																'action'=>'order-detail',
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias'],
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'lang'=>$lang);
									$linkCart = $this->url($urlOptions2,'products-order-detail');
									$num = '';
									if(($key+1)%4 == 0){
										$col = 'col4';
									}else{
										$col = 'col1';
									}
							?>
							<div class='box-right width-22 <?php echo $col?>'>
								<div class='bor-img-right'>
									<a href="<?php echo $linkDetail?>"><?php echo $picture?></a>
								</div>
								<div class='desc-right'>
									<h2><a href="<?php echo $linkDetail?>"><?php echo $name?></a></h2>
									<?php echo $price?>
									<?php echo $sale_off?>
									<?php echo $val_sell?>
									<a class='icon-right-cart' href="<?php echo $linkCart?>">Mua hàng</a>
								</div>
							</div>
							<?php
                                                                        }
								} 
							?>
						</div>
					</div>
<?php
	} 
?>

<?php
if (!empty($nemNhanTao)){
?>
<div class='box-right-pro width-100'>
						<div class='sub-box-right'><span class='icon-right'><img src="<?php echo $this->imgUrl ?>/icon/icon-sub-right.png"></span>
                                                    <ul class="btnCompany">
                                                            <li class='nameCategory'><a href="<?php echo $this->baseUrl('san-pham/242-nem-cao-su-nhan-tao-1.html') ?>">NỆM CAO SU NHÂN TẠO</a></li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/242-170-nem-cao-su-nhan-tao-1.html') ?>">WEAN</a></li>
                                                        </ul>
                                                </div>
                                                <div class='cnt-right width-100' id="listProduct" style="left:0px">
							<?php
								foreach ($nemNhanTao as $key => $value){
                                                                        if($key < 8){
									$cutTring 	= new Zendvn_File_CutTring();
									$name		= str_replace("\\","",$value['name']);
								//	$name		= $cutTring->cutTring(25, $name, null);
									
									$alt		= str_replace("\\","",$value['alt_seo']);
									if(empty($value['alt_seo'])) $alt = str_replace("\\","",$value['name']);
									
									$summary	= str_replace("\\","",$value['summary']);
									$summary	= $cutTring->cutTring(120, $summary, null);
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									
									$sale		= $value['sale'];
									$menu_id	= $value['menu_id'];
									include 'sale.php';
									
									$val_sell 	= '';
									$sale_off 	= '';
									if ($value['selloff'] != 0){
										$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
									}
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									if($value['val_sell'] != 0){
										$price 	= '<p class="price-right-pro  line-through">' . number_format($value['price'],0) . ' VND</p>';
									}
									if ($sale != 0){
										$sale_off 	= $value['price'] - ($value['price']*$sale/100);
										$sale_off	= '<p class="sale">' . number_format($sale_off,0) . ' VND</p>';
										$price 		= '<p class="price-right-pro line-through">' . number_format($value['price'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $sale .'%</div>';
										if($value['val_sell'] != 0){
											$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
											$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										}
									}
									if($value['price'] == 0) $price = '<p style="color:red; font-size:1em" class="price">Liên hệ</p>';
									
									if(!empty($value['picture'])){
										$linkImg	= FILES_URL . '/products/orignal/' . $value['picture'];
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}else{
										$linkImg	= $this->imgUrl . '/no-image.jpg';
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}
									
									$urlOptions = array('module'=>'products','controller'=>'index',
																'action'=>'detail',
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias']);
									$linkDetail = $this->url($urlOptions,'products-detail');
									$urlOptions2 = array('module'=>'products','controller'=>'index',
																'action'=>'order-detail',
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias'],
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'lang'=>$lang);
									$linkCart = $this->url($urlOptions2,'products-order-detail');
									$num = '';
									if(($key+1)%4 == 0){
										$col = 'col4';
									}else{
										$col = 'col1';
									}
							?>
							<div class='box-right width-22 <?php echo $col?>'>
								<div class='bor-img-right'>
									<a href="<?php echo $linkDetail?>"><?php echo $picture?></a>
								</div>
								<div class='desc-right'>
									<h2><a href="<?php echo $linkDetail?>"><?php echo $name?></a></h2>
									<?php echo $price?>
									<?php echo $sale_off?>
									<?php echo $val_sell?>
									<a class='icon-right-cart' href="<?php echo $linkCart?>">Mua hàng</a>
								</div>
							</div>
							<?php
                                                                        }
								} 
							?>
						</div>
					</div>
<?php
	} 
?>

<?php
if (!empty($nemLoxo)){
?>
<div class='box-right-pro width-100'>
						<div class='sub-box-right'><span class='icon-right'><img src="<?php echo $this->imgUrl ?>/icon/icon-sub-right.png"></span>
                                                    <ul class="btnCompany">
                                                            <li class='nameCategory'><a href="<?php echo $this->baseUrl('san-pham/227-nem-lo-xo-1.html') ?>">NỆM LÒ XO</a></li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/227-165-nem-lo-xo-1.html') ?>">LIÊN Á</a></li>
                                                            <li class='kt'>|</li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/227-163-nem-lo-xo-1.html') ?>">VẠN THÀNH</a></li>
                                                            <li class='kt'>|</li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/227-170-nem-lo-xo-1.html') ?>">WEAN</a></li>
                                                            <li class='kt'>|</li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/227-177-nem-lo-xo-1.html') ?>">DUNLOPILLO</a></li>
                                                        </ul>
                                                </div>
                                                <div class='cnt-right width-100' id="listProduct" style="left:0px">
							<?php
								foreach ($nemLoxo as $key => $value){
                                                                        if($key < 4){
									$cutTring 	= new Zendvn_File_CutTring();
									$name		= str_replace("\\","",$value['name']);
								//	$name		= $cutTring->cutTring(25, $name, null);
									
									$alt		= str_replace("\\","",$value['alt_seo']);
									if(empty($value['alt_seo'])) $alt = str_replace("\\","",$value['name']);
									
									$summary	= str_replace("\\","",$value['summary']);
									$summary	= $cutTring->cutTring(120, $summary, null);
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									
									$sale		= $value['sale'];
									$menu_id	= $value['menu_id'];
									include 'sale.php';
									
									$val_sell 	= '';
									$sale_off 	= '';
									if ($value['selloff'] != 0){
										$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
									}
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									if($value['val_sell'] != 0){
										$price 	= '<p class="price-right-pro  line-through">' . number_format($value['price'],0) . ' VND</p>';
									}
									if ($sale != 0){
										$sale_off 	= $value['price'] - ($value['price']*$sale/100);
										$sale_off	= '<p class="sale">' . number_format($sale_off,0) . ' VND</p>';
										$price 		= '<p class="price-right-pro line-through">' . number_format($value['price'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $sale .'%</div>';
										if($value['val_sell'] != 0){
											$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
											$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										}
									}
									if($value['price'] == 0) $price = '<p style="color:red; font-size:1em" class="price">Liên hệ</p>';
									
									if(!empty($value['picture'])){
										$linkImg	= FILES_URL . '/products/orignal/' . $value['picture'];
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}else{
										$linkImg	= $this->imgUrl . '/no-image.jpg';
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}
									
									$urlOptions = array('module'=>'products','controller'=>'index',
																'action'=>'detail',
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias']);
									$linkDetail = $this->url($urlOptions,'products-detail');
									$urlOptions2 = array('module'=>'products','controller'=>'index',
																'action'=>'order-detail',
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias'],
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'lang'=>$lang);
									$linkCart = $this->url($urlOptions2,'products-order-detail');
									$num = '';
									if(($key+1)%4 == 0){
										$col = 'col4';
									}else{
										$col = 'col1';
									}
							?>
							<div class='box-right width-22 <?php echo $col?>'>
								<div class='bor-img-right'>
									<a href="<?php echo $linkDetail?>"><?php echo $picture?></a>
								</div>
								<div class='desc-right'>
									<h2><a href="<?php echo $linkDetail?>"><?php echo $name?></a></h2>
									<?php echo $price?>
									<?php echo $sale_off?>
									<?php echo $val_sell?>
									<a class='icon-right-cart' href="<?php echo $linkCart?>">Mua hàng</a>
								</div>
							</div>
							<?php
                                                                        }
								} 
							?>
						</div>
					</div>
<?php
	} 
?>


<?php
if (!empty($nemDrap)){
?>
<div class='box-right-pro width-100'>
						<div class='sub-box-right'><span class='icon-right'><img src="<?php echo $this->imgUrl ?>/icon/icon-sub-right.png"></span>
                                                    <ul class="btnCompany">
                                                            <li class='nameCategory'><a href="<?php echo $this->baseUrl('224-drap-1.html') ?>">DRAP</a></li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/224-179-drap-1.html') ?>">EDENA</a></li>
                                                            <li class='kt'>|</li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/224-163-drap-1.html') ?>">VẠN THÀNH</a></li>
                                                            <li class='kt'>|</li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/224-170-drap-1.html') ?>">WEAN</a></li>
                                                            <li class='kt'>|</li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/224-165-drap-1.html') ?>">LIÊN Á</a></li>
                                                        </ul>
                                                </div>
                                                <div class='cnt-right width-100' id="listProduct" style="left:0px">
							<?php
								foreach ($nemDrap as $key => $value){
                                                                        if($key < 8){
									$cutTring 	= new Zendvn_File_CutTring();
									$name		= str_replace("\\","",$value['name']);
								//	$name		= $cutTring->cutTring(25, $name, null);
									
									$alt		= str_replace("\\","",$value['alt_seo']);
									if(empty($value['alt_seo'])) $alt = str_replace("\\","",$value['name']);
									
									$summary	= str_replace("\\","",$value['summary']);
									$summary	= $cutTring->cutTring(120, $summary, null);
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									
									$sale		= $value['sale'];
									$menu_id	= $value['menu_id'];
									include 'sale.php';
									
									$val_sell 	= '';
									$sale_off 	= '';
									if ($value['selloff'] != 0){
										$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
									}
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									if($value['val_sell'] != 0){
										$price 	= '<p class="price-right-pro  line-through">' . number_format($value['price'],0) . ' VND</p>';
									}
									if ($sale != 0){
										$sale_off 	= $value['price'] - ($value['price']*$sale/100);
										$sale_off	= '<p class="sale">' . number_format($sale_off,0) . ' VND</p>';
										$price 		= '<p class="price-right-pro line-through">' . number_format($value['price'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $sale .'%</div>';
										if($value['val_sell'] != 0){
											$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
											$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										}
									}
									if($value['price'] == 0) $price = '<p style="color:red; font-size:1em" class="price">Liên hệ</p>';
									
									if(!empty($value['picture'])){
										$linkImg	= FILES_URL . '/products/orignal/' . $value['picture'];
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}else{
										$linkImg	= $this->imgUrl . '/no-image.jpg';
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}
									
									$urlOptions = array('module'=>'products','controller'=>'index',
																'action'=>'detail',
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias']);
									$linkDetail = $this->url($urlOptions,'products-detail');
									$urlOptions2 = array('module'=>'products','controller'=>'index',
																'action'=>'order-detail',
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias'],
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'lang'=>$lang);
									$linkCart = $this->url($urlOptions2,'products-order-detail');
									$num = '';
									if(($key+1)%4 == 0){
										$col = 'col4';
									}else{
										$col = 'col1';
									}
							?>
							<div class='box-right width-22 <?php echo $col?>'>
								<div class='bor-img-right'>
									<a href="<?php echo $linkDetail?>"><?php echo $picture?></a>
								</div>
								<div class='desc-right'>
									<h2><a href="<?php echo $linkDetail?>"><?php echo $name?></a></h2>
									<?php echo $price?>
									<?php echo $sale_off?>
									<?php echo $val_sell?>
									<a class='icon-right-cart' href="<?php echo $linkCart?>">Mua hàng</a>
								</div>
							</div>
							<?php
                                                                        }
								} 
							?>
						</div>
					</div>
<?php
	} 
?>

<?php
if (!empty($nemBongEp)){
?>
<div class='box-right-pro width-100'>
						<div class='sub-box-right'><span class='icon-right'><img src="<?php echo $this->imgUrl ?>/icon/icon-sub-right.png"></span>
                                                <ul class="btnCompany">
                                                            <li class='nameCategory'><a href="<?php echo $this->baseUrl('san-pham/225-nem-bong-ep-1.html') ?>">NỆM BÔNG ÉP</a></li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/225-179-nem-bong-ep-1.html') ?>">EDENA</a></li>
                                                            <li class='kt'>|</li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/225-163-nem-bong-ep-1.html') ?>">VẠN THÀNH</a></li>
                                                            <li class='kt'>|</li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/225-170-nem-bong-ep-1.html') ?>">WEAN</a></li>
                                                            <li class='kt'>|</li>
                                                            <li><a href="<?php echo $this->baseUrl('san-pham/225-165-nem-bong-ep-1.html') ?>">LIÊN Á</a></li>
                                                        </ul>
                                                </div>
                                                <div class='cnt-right width-100' id="listProduct" style="left:0px">
							<?php
								foreach ($nemBongEp as $key => $value){
                                                                        if($key < 8){
									$cutTring 	= new Zendvn_File_CutTring();
									$name		= str_replace("\\","",$value['name']);
								//	$name		= $cutTring->cutTring(25, $name, null);
									
									$alt		= str_replace("\\","",$value['alt_seo']);
									if(empty($value['alt_seo'])) $alt = str_replace("\\","",$value['name']);
									
									$summary	= str_replace("\\","",$value['summary']);
									$summary	= $cutTring->cutTring(120, $summary, null);
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									
									$sale		= $value['sale'];
									$menu_id	= $value['menu_id'];
									include 'sale.php';
									
									$val_sell 	= '';
									$sale_off 	= '';
									if ($value['selloff'] != 0){
										$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
									}
									$price 		= '<p class="price-right-pro">' . number_format($value['price'],0) . ' VND</p>';
									if($value['val_sell'] != 0){
										$price 	= '<p class="price-right-pro  line-through">' . number_format($value['price'],0) . ' VND</p>';
									}
									if ($sale != 0){
										$sale_off 	= $value['price'] - ($value['price']*$sale/100);
										$sale_off	= '<p class="sale">' . number_format($sale_off,0) . ' VND</p>';
										$price 		= '<p class="price-right-pro line-through">' . number_format($value['price'],0) . ' VND</p>';
										$val_sell 	= '<div class="icon-sale">'. $sale .'%</div>';
										if($value['val_sell'] != 0){
											$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
											$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
										}
									}
									if($value['price'] == 0) $price = '<p style="color:red; font-size:1em" class="price">Liên hệ</p>';
									
									if(!empty($value['picture'])){
										$linkImg	= FILES_URL . '/products/orignal/' . $value['picture'];
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}else{
										$linkImg	= $this->imgUrl . '/no-image.jpg';
										$picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
									}
									
									$urlOptions = array('module'=>'products','controller'=>'index',
																'action'=>'detail',
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias']);
									$linkDetail = $this->url($urlOptions,'products-detail');
									$urlOptions2 = array('module'=>'products','controller'=>'index',
																'action'=>'order-detail',
																'tcat'=>$value['alias_name'],
																'title'=>$value['alias'],
																'cid'=> $value['menu_id'],
																'id'=>$value['id'],
																'lang'=>$lang);
									$linkCart = $this->url($urlOptions2,'products-order-detail');
									$num = '';
									if(($key+1)%4 == 0){
										$col = 'col4';
									}else{
										$col = 'col1';
									}
							?>
							<div class='box-right width-22 <?php echo $col?>'>
								<div class='bor-img-right'>
									<a href="<?php echo $linkDetail?>"><?php echo $picture?></a>
								</div>
								<div class='desc-right'>
									<h2><a href="<?php echo $linkDetail?>"><?php echo $name?></a></h2>
									<?php echo $price?>
									<?php echo $sale_off?>
									<?php echo $val_sell?>
									<a class='icon-right-cart' href="<?php echo $linkCart?>">Mua hàng</a>
								</div>
							</div>
							<?php
                                                                        }
								} 
							?>
						</div>
					</div>
<?php
	} 
?>