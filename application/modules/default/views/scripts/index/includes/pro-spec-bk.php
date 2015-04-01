<?php 
	include 'lang.php';
	$tblMenu	= new Zendvn_Models_Menus();
	$menu		= $tblMenu->listItem($this->arrParam,array('task'=>'special'));
	foreach ($menu as $key =>$val){
		$id		= $val['id'];
		$name 	= $val['name'];
		$urlOptions = array('module'=>'products','controller'=>'index',
													'action'=>'category',
                    								'cid'=> $val['id'],
													'name'=>$val['alias'],
                    								'lang'=>$lang,
                    								'page'=>$page);
        $linkCategory = $this->url($urlOptions,'products-category');
        if($key != 0) $mar_top = "mar-top-20";
        $id_pro	= 'pro_' . $id;
?>
<script type="text/javascript">
 $(document).ready( function(){
	 	var hit_pro	= 'hit_pro_' + '<?php echo $id?>';
	 	var new_pro	= 'new_pro_' + '<?php echo $id?>';
	 	var hot_pro	= 'hot_pro_' + '<?php echo $id?>';
		$('.' + hit_pro).click(function(event){
			event.preventDefault();
			var url,data,id_pro;
			url = '<?php echo $this->baseUrl("products/index/pro") ?>';
			data = {'type':'hit','cid':'<?php echo $id?>'};
			$(this).parents().next('.cnt-right').find('.box').hide();
			$(this).parents().next('.cnt-right').load(url,data);
			$(this).parents().find('a').removeClass('active');
			$(this).addClass('active');
		});
		$('.' + new_pro).click(function(event){
			event.preventDefault();
			var url,data,id_pro;
			url = '<?php echo $this->baseUrl("products/index/pro") ?>';
			data = {'type':'new','cid':'<?php echo $id?>'};
			$(this).parents().next('.cnt-right').find('.box').hide();
			$(this).parents().next('.cnt-right').load(url,data);
			$(this).parents().find('a').removeClass('active');
			$(this).addClass('active');
		});
		$('.' + hot_pro).click(function(event){
			event.preventDefault();
			var url,data,id_pro;
			url = '<?php echo $this->baseUrl("products/index/pro") ?>';
			data = {'type':'hot','cid':'<?php echo $id?>'};
			$(this).parents().next('.cnt-right').find('.box').hide();
			$(this).parents().next('.cnt-right').load(url,data);
			$(this).parents().find('a').removeClass('active');
			$(this).addClass('active');
		});				
	});

</script>
<div id='cnt_group' style="min-height:270px" class="group width-100 <?php echo $mar_top ?>">
                    	<div class="sub-right width-100">
                        	<a class='active' href="<?php echo $linkCategory?>"><?php echo $name?></a>
                        	<a class='hit_pro_<?php echo $id?>' id='<?php echo $id?>' href="#">Xem nhiều nhất</a>
                        	<a class='new_pro_<?php echo $id?>' id='<?php echo $id?>' href="#">Mới cập nhật</a>
                        	<a class='hot_pro_<?php echo $id?>' id='<?php echo $id?>' href="#">Hàng cao cấp</a>
                        </div>
                        <div id='<?php echo $id_pro?>' class="cnt-right mar-top-5 width-100">
                        <?php
                        	$tblPro	= new Zendvn_Models_ProItem();
                    		$items	= $tblPro->listItem($this->arrParam,array('task'=>'special','cid'=>$id));
                        	foreach ($items as $key => $value){
                        			$cutTring 	= new Zendvn_File_CutTring();
                    				$name		= str_replace("\\","",$value['name']);
//                    				$name		= $cutTring->cutTring(25, $name, null);
                    				
                    				$alt		= str_replace("\\","",$value['alt_seo']);
                    				if(!empty($value['alt_seo'])) $alt = str_replace("\\","",$value['name']);
                    				
				            		$summary	= str_replace("\\","",$value['summary']);
				            		$summary	= $cutTring->cutTring(120, $summary, null);
				            		$price 		= '<p class="price">' . number_format($value['price'],0) . ' VND</p>';
				            		
				            		$sale		= $value['sale'];
				            		$menu_id	= $value['menu_id'];
				            		include 'sale.php';
				            		
				            		$val_sell 	= '';
				            		$sale_off 	= '';
				            		if ($value['selloff'] != 0){
				            			$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
				            			$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
				            		}
			            			$price 		= '<p class="price">' . number_format($value['price'],0) . ' VND</p>';
                        			if($value['val_sell'] != 0){
				            			$price 	= '<p class="price  line-through">' . number_format($value['price'],0) . ' VND</p>';
				            		}
				            		if ($sale != 0){
				            			$sale_off 	= $value['price'] - ($value['price']*$sale/100);
				            			$sale_off	= '<p class="sale">' . number_format($sale_off,0) . ' VND</p>';
				            			$price 		= '<p class="price line-through">' . number_format($value['price'],0) . ' VND</p>';
				            			$val_sell 	= '<div class="icon-sale">'. $sale .'%</div>';
				            			if($value['val_sell'] != 0){
				            				$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
				            				$sale_off	= '<p class="sale">' . number_format($value['selloff'],0) . ' VND</p>';
				            			}
				            		}
				            		
				            		if(!empty($value['picture'])){
									    $linkImg	= FILES_URL . '/products/images450x450/' . $value['picture'];
									    $picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
								    }else{
									    $linkImg	= $this->imgUrl . '/no-image.jpg';
									    $picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
								    }
                    				
									$urlOptions = array('module'=>'products','controller'=>'index',
																		'action'=>'detail',
																		'tcat'=>$value['alias_name'],
																		'title'=>$value['alias'],
					                    								'cid'=> $value['menu_id'],
																		'id'=>$value['id'],
					                    								'lang'=>$lang);
					                $linkDetail = $this->url($urlOptions,'products-detail');
					                $linkCart = $this->baseUrl('/products/index/add-item/id/' . $value['id']);
					                $num = '';
					                if(($key+1)%4 == 0)$num = 'num-4';
                        ?>
                        	<div class="box width-21 <?php echo $num?>">
                            	<div class="cnt-box">
                                	<div class="bor-img">
                                    	<a href="<?php echo $linkDetail?>"><?php echo $picture?></a>
                                        <?php echo $val_sell?>
                                        <!-- <a title="<?php echo str_replace("\\","",$value['name'])?>" class="icon-cart" href="<?php echo $linkCart?>"><span></span></a> -->
                                    </div>
                                    <div class="desc">
                                    	<h2><a title="<?php echo str_replace("\\","",$value['name'])?>" href="<?php echo $linkDetail?>"><?php echo $name?></a></h2>
                                        <?php echo $price?>
                                        <?php echo $sale_off?>
                                    </div>
                                </div>
                            </div>
                            <?php 
                        		}
                        	?>
                        </div>
                    </div>
                    <?php }?>

                    
                    
                    
                    
                    
                    
                    
                    
                    