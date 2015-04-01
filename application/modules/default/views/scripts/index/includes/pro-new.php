<?php
	$tblSpec	= new Zendvn_Models_ProItem();
	$items		= $tblSpec->listItem($this->arrParam,array('task'=>'pro-new'));
	if (!empty($items)){
?>
<div class="group width-100 mar-top-20">
                    	<div class="sub-right width-100 icon-pro">
                        	<p>Sách mới</p>
                        </div>
                        <div class="cnt-right mar-top-5 width-100">
                        <?php
                        	foreach ($items as $key => $value){
                        			$cutTring 	= new Zendvn_File_CutTring();
                    				$name		= str_replace("\\","",$value['name']);
//                    				$name		= $cutTring->cutTring(25, $name, null);
                    				
                    				$alt		= str_replace("\\","",$value['alt_seo']);
                    				if(!empty($value['alt_seo'])) $alt = str_replace("\\","",$value['name']);
                    				
				            		$summary	= str_replace("\\","",$value['summary']);
				            		$summary	= $cutTring->cutTring(120, $summary, null);
				            		$price 		= '<p class="price float-left">' . number_format($value['price'],0) . ' VND</p>';
				            		
				            		$sale		= $value['sale'];
				            		
				            		$menu_id	= $value['menu_id'];
				            		include 'sale.php';
				            		
				            		$val_sell 	= '';
				            		$sale_off 	= '';
				            		if ($value['selloff'] != 0){
				            			$sale_off	= '<p class="sale float-right">' . number_format($value['selloff'],0) . ' VND</p>';
				            			$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
				            		}
			            			$price 		= '<p class="price float-left">' . number_format($value['price'],0) . ' VND</p>';
                        			if($value['val_sell'] != 0){
				            			$price 	= '<p class="price float-left line-through">' . number_format($value['price'],0) . ' VND</p>';
				            		}
				            		if ($sale != 0){
				            			$sale_off 	= $value['price'] - ($value['price']*$sale/100);
				            			$sale_off	= '<p class="sale float-right">' . number_format($sale_off,0) . ' VND</p>';
				            			$price 		= '<p class="price float-left line-through">' . number_format($value['price'],0) . ' VND</p>';
				            			$val_sell 	= '<div class="icon-sale">'. $sale .'%</div>';
				            			if($value['val_sell'] != 0){
				            				$val_sell 	= '<div class="icon-sale">'. $value['val_sell'] .'%</div>';
				            				$sale_off	= '<p class="sale float-right">' . number_format($value['selloff'],0) . ' VND</p>';
				            			}
				            		}
				            		
				            		if(!empty($value['picture'])){
									    $linkImg	= FILES_URL . '/products/images450x450/' . $value['picture'];
									    $picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
								    }else{
									    $linkImg	= $this->imgUrl . '/no-image.jpg';
									    $picture 	= '<img title="'. $value['name'] .'" src="'. $linkImg .'" alt="'. $alt .'" />';
								    }
                    				$lang = $this->arrParam['lang'];
				                    if(empty($lang)){
				                    	$lang = 'vi';
				                    }else{
				                    	$lang = $this->arrParam['lang'];
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
                                        <a title="<?php echo $value['name']?>" class="icon-cart" href="<?php echo $linkCart?>"><span></span></a>
                                    </div>
                                    <div class="desc">
                                    	<h2><a title="<?php echo $value['name']?>" href="<?php echo $linkDetail?>"><?php echo $name?></a></h2>
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