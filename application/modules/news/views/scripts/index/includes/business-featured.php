<?php
	$tblBusiness = new Zendvn_Models_BusinessItem(); 
	$items = $tblBusiness->listItem($this->arrParam,array('task'=>'featured'));
	if(!empty($items)){
?>
<div class="group">
	<div class="sub-content color-blue"><a class="color-blue" href="#">DOANH NGHIỆP TIÊU BIỂU</a></div>
		<?php
				foreach ($items as $key => $val){
					$tblCut 	= new Zendvn_File_CutTring();					
					$title 		= $val['name'];
					$title 		= $tblCut -> cutTring(50, $title, null);
					
					$address 	= $val['address'];
					$phone 		= $val['phone'];
					$website 	= $val['website'];
					
					
					if(!empty($val['picture'])){
                    	$linkImg	= FILES_URL . '/news/images450x450/' . $val['picture'];
                    	$picture 	= '<img title="'. $title .'" src="'. $linkImg .'" width="110" alt="'.$name.'" />';
                    }else{
                    	$linkImg	= FILES_URL . '/news/images450x450/no-image.jpg';
                    	$picture 	= '<img title="'. $title .'" src="'. $linkImg .'" width="110" alt="'.$name.'" />';
                    }
					
					$lang = $view->arrParam['lang'];
                    if(empty($lang)){
                    	$lang = 'vi';
                    }else{
                    	$lang = $view->arrParam['lang'];
                    }
//                    $urlOptions = array('module'=>'news','controller'=>'index',
//													'action'=>'detail',
//													'nname'=>$val['alias_name'],
//													'title'=>$val['alias'],
//                    								'nid'=> $val['cat_id'],
//													'id'=>$val['id'],
//                    								'lang'=>$lang);
//                    $linkDetail = $view->url($urlOptions,'news-detail');
                    
                    $line = '<div class="line mar-top-10"></div>';
                    if($key == 4)$line = '';
					
		?>
			<div class="box-cnt width-100 col-0">
                 <div class="cnt">
                      <div class="bor-img">
                          <a title="<?php echo $val['name']?>" href="<?php echo $linkDetail?>"><?php echo $picture?></a>
                      </div>
                      <div class="desc">
                          <h2><a title="<?php echo $val['name']?>" href="<?php echo $linkDetail?>"><?php echo $title?></a></h2>
                          <p>
                          		<p><strong>Địa chỉ: </strong> <?php echo $address?></p>
                          		<p><strong>Điện thoại: </strong> <?php echo $phone?></p>
                          		<p><strong>Website: </strong> <?php echo $website?></p>
                          </p>
                          <a title="<?php echo $val['name']?>" href="<?php echo $linkDetail?>" class="readmore">...Xem chi tiết</a>
                      </div>
                   </div>
            </div>
			<?php echo $line ?>
		<?php }?>
</div>
<?php } ?>