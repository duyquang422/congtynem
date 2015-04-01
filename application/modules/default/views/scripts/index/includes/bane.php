<!--------------------SLIDE (Start) ---------------------->
            <div class="slide width-100 float-left">
                <div id="jslidernews2" class="slide-show float-left width-100 lof-slidecontent">
                	<div class="main-slider-content width-100">
						<ul class="sliders-wrap-inner">
							<?php
								$tblImage = new Zendvn_Models_Slide();
								$img = $tblImage->listItem($this->arrParam,array('task'=>'public'));
								if (!empty($img)){
									foreach ($img as $key => $val){
										$title 	= $val['name'];
										$url 	= $val['url']; 
										if(!empty($val['picture'])){
					                    	$linkImg	= FILES_URL . '/slide/orignal/' . $val['picture'];
					                    	$picture 	= '<a target="_blank" href="'. $url .'"><img title="" src="'. $linkImg .'" alt="'.$title.'" /></a>';
					                    }else{
					                    	$linkImg	= $this->imgUrl . '/no-image.jpg';
					                    	$picture 	= '<a target="_blank" href="'. $url .'"><img title="" src="'. $linkImg .'" alt="'.$title.'" /></a>';
					                    }
							?>
							<li><?php echo $picture?></li>
							<?php
									}
								} 
							?>
						</ul>
					</div>
                </div>
            </div>
            <!--------------------SLIDE (End) ------------------------->