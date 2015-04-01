<?php
	$lang = $this->arrParam['lang'];
    if(empty($lang)){
    	$lang = 'vi';
    }else{
   		$lang = $this->arrParam['lang'];
    }
    $page = 1;
	$tblUnits	= new Zendvn_Models_Units();
	$items		= $tblUnits->listItem($this->arrParam,array('task'=>'public-index'));
	if (!empty($items)){
		$urlOptions = array('module'=>'products','controller'=>'index',
													'action'=>'index',
													'type'=>'special',
                    								'lang'=>$lang,
                    								'page'=>$page);
		$linkProSpecial 	= $this->url($urlOptions,'products-type');
?>
<div class="group width-100 mar-top-20">
                    	<div class="sub-right width-100 icon-pro">
                        	<p>Đơn vị phát hành</p>
                        </div>
                        <div class="cnt-right mar-top-5 width-100 group-units">
                        <?php
                        	foreach ($items as $key => $value){
                        			$cutTring 	= new Zendvn_File_CutTring();
                    				$name		= str_replace("\\","",$value['name']);
				            		
				            		if(!empty($value['picture'])){
									    $linkImg	= FILES_URL . '/units/images450x450/' . $value['picture'];
									    $picture 	= '<img title="'. $name .'" src="'. $linkImg .'" alt="'. $name .'" />';
								    }else{
									    $linkImg	= $this->imgUrl . '/no-image.jpg';
									    $picture 	= '<img title="'. $name .'" src="'. $linkImg .'" alt="'. $name .'" />';
								    }
                    				
									$alias	= $value['alias'];
		                			$id		= $value['id'];
		                			$urlOptions = array('module'=>'products','controller'=>'index',
																		'action'=>'index',
																		'units'=>$alias,
		                												'u_id'=>$id,
					                    								'lang'=>$lang,
					                    								'page'=>$page);
				                   	$linkProUnits 	= $this->url($urlOptions,'products-units');
					                $num = 'nums-0';
					                //if(($key+1)%6 == 0) $num = 'nums-6';
                        ?>
                        	<div class="box width-10 <?php echo $num?> units">
                            	<div class="cnt-box">
                                	<div class="bor-img">
                                    	<a href="<?php echo $linkProUnits?>"><?php echo $picture?></a>
                                    </div>
                                    <div class="desc">
                                    	<h2><a title="<?php echo $value['name']?>" href="<?php echo $linkProUnits?>"><?php echo $name?></a></h2>
                                    </div>
                                </div>
                            </div>
                            <?php 
                        		}
                        	?>
                        </div>
                    </div>
                    <?php }?>