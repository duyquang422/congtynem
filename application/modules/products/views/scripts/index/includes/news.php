<?php
	$tblNews	= new Zendvn_Models_NewsItem();
	$news		= $tblNews->listItem($this->arrParam,array('task'=>'news'));
?>                
                    <div class="group-4 width-100 mar-top-20">
                        <div class="cnt-group-4 bag-gray">
                            <div class="sub-group bag-sub-green"><a href="#"><span class="icon icon-project"></span>Tin tức chuyên ngành thiết kế</a></div>
                            
                            <?php
                            	if(!empty($news)){
                            		foreach ($news as $key => $value) {
                            			$cutTring 	= new Zendvn_File_CutTring();
										$title 		= $value['name'];
										$title 		= str_replace("\\"," ",$title);
										$title 		= $cutTring -> cutTring(50, $title, null);
										$alt		= $value['name'];
										if(!empty($value['alt_seo'])) $alt = $value['alt_seo'];
										$alt 		= str_replace("\\"," ",$alt);
										
										$sumTmp 	= $value['summary'];
			                    		$sumTmp 	= str_replace("\\"," ",$sumTmp);
							            $summary 	= $cutTring->cutTring(280,$sumTmp,null);
										
										if(!empty($value['picture'])){
					                    	$linkImg	= FILES_URL . '/news/images450x450/' . $value['picture'];
					                    	$picture 	= '<img title="'. $title .'" src="'. $linkImg .'" width="110" alt="'.$alt.'" />';
					                    }else{
					                    	$linkImg	= FILES_URL . '/news/images450x450/no-image.jpg';
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
					                    
					                    $line = '<div class="line mar-top-10"></div>';
					                    if($key == 4)$line = '';
                            ?>
                            <div class="box width-100">
                                <div class="box-cnt">
                                    <div class="bor-img">
                                        <a title="<?php echo $title?>" href="<?php echo $linkDetail?>"><?php echo $picture?></a>
                                    </div>
                                    <div class="desc">
                                        <div class="cnt-desc">
                                            <h2 class="title-img"><a title="<?php echo $title?>" href="<?php echo $linkDetail?>"><?php echo $title?></a></h2>
                                            <p><?php echo $summary?></p>
                                            <a title='<?php echo $title?>' href="<?php echo $linkDetail?>" class="btn-readmore">...Xem thêm</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="line"></div>
                            </div>
                            <?php 
                            		}
                            	}
                            ?>
                            
                        </div>
                    </div>