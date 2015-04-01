<?php
	$tblNews 	= new Zendvn_Models_NewsItem();
	$items		= $tblNews->listItem($this->arrParam,array('task'=>'news'));
	if(!empty($items)){
		$linkNews	= $this->baseUrl('/vi-tintuc-1.html');
?>
<div class="width-68 float-left">
                            <div class="sub-right width-100">
                                <a class='active' href="<?php echo $linkNews?>">Có gì mới ?</a>
                            </div>
                            <div class="cnt-right">
                            	<?php
                            		foreach ($items as $key => $value) {
                            			$cutTring 	= new Zendvn_File_CutTring();
										$title 		= $value['name'];
										$title 		= str_replace("\\"," ",$title);
										$title 		= $cutTring -> cutTring(50, $title, null);
										$alt		= $value['name'];
										if(!empty($value['alt_seo'])) $alt = $value['alt_seo'];
										$alt 		= str_replace("\\"," ",$alt);
										
										$sumTmp 	= $value['summary'];
			                    		$sumTmp 	= str_replace("\\"," ",$sumTmp);
							            $summary 	= $cutTring->cutTring(160,$sumTmp,null);
										
										if(!empty($value['picture'])){
					                    	$linkImg	= FILES_URL . '/news/images450x450/' . $value['picture'];
					                    	$picture 	= '<img title="'. $title .'" src="'. $linkImg .'" width="110" alt="'.$alt.'" />';
					                    }else{
					                    	$linkImg	= $this->imgUrl . '/no-image.jpg';
					                    	$picture 	= '<img title="'. $title .'" src="'. $linkImg .'" width="110" alt="'.$alt.'" />';
					                    }
										
										$lang = $this->arrParam['lang'];
					                    if(empty($lang)){
					                    	$lang = 'vi';
					                    }else{
					                    	$lang = $this->arrParam['lang'];
					                    }
					                 	$urlOptions = array('module'=>'news','controller'=>'index',
																	'action'=>'detail',
																	'nname'=>$value['alias_name'],
																	'title'=>$value['alias'],
					                    							'nid'=> $value['menu_id'],
																	'id'=>$value['id'],
					                   								'lang'=>$lang);
					                   	$linkDetail = $this->url($urlOptions,'news-detail');
                            	?>
                                <!--------------------BOX CONTENT (Start) -------------------->
                                <div class="box-cnt col-0 dis-tab">
                                    <div class="box">
                                        <div class="bor-img">
                                            <a href="<?php echo $linkDetail?>"><?php echo $picture?></a>
                                        </div>
                                        <div class="desc">
                                            <h2><a href="<?php echo $linkDetail?>"><?php echo $title?></a></h2>
                                            <p><?php echo $summary?></p>
                                            <a class="read-more" href="<?php echo $linkDetail?>">...Chi tiết</a>
                                        </div>
                                    </div>
                                </div>
                                <!--------------------BOX CONTENT (End) ---------------------->
                                <?php
                            		} 
                                ?>
                                <div class="clear more mar-top-10"><a href="<?php echo $linkNews?>">Xem thêm</a></div>
                            </div>
                        </div>
<?php 
	}
?>