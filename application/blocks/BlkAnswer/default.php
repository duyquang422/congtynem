<?php
	$ssFilter = $view->arrParam['ssFilter'];
	$langTmp = $ssFilter['lang'];
	if($langTmp == ''){
		$langTmp = 'vi';
	}else{
		$langTmp = $ssFilter['lang'];
	}
	
	$page = 1;
	
	$lang = $view->arrParam['lang'];
    if(empty($lang)){
    	$lang = 'vi';
    }else{
    	$lang = $view->arrParam['lang'];
    }
	$urlQuestion 	= array('module'=>'default','controller'=>'index','action'=>'questions','lang'=>$langTmp);
   	$linkQuestion 	= $view->url($urlQuestion,'question'); 
?>
<div class="box-category mar-top-10">
	<a class="advert" href="<?php echo $linkQuestion?>"><img src="<?php echo $view->imgUrl;?>/hoi-dap.png" alt=""  /></a>
</div>
<?php
	$tblQuestions = new Zendvn_Models_Questions();
	$questions = $tblQuestions->listItem($view->arrParam,array('task'=>'index'));
	if(!empty($questions)){
?>
<div class="box-category mar-top-10">
                            <div class="sub-category"><p>HỎI - ĐÁP</p></div>
                            <div class="cnt-box-category">
                                <div class="list">
                                	<?php
                                		foreach ($questions as $key => $val){ 
                                			$title = $val['title'];
                                			$urlimage   	= FILES_URL . '/users/images100x100/'. $val['avatar'];
	  										$imgimage  		= '<img title="'. $title .'" src="' . $urlimage . '" alt="'. $title .'" />';
	  										$urlOptions = array('module'=>'default','controller'=>'index',
																		'action'=>'answers-detail',
																		'title'=>$val['alias'],
																		'id'=>$val['id'],
						                   								'lang'=>$lang);
						                   	$linkDetail = $view->url($urlOptions,'default');
                                	?>
                                    <div class="row-list">
                                        <a class="img" href="<?php echo $linkDetail?>"><?php echo $imgimage?></a>
                                        <h3><a href="<?php echo $linkDetail?>"><?php echo $title ?></a></h3>
                                    </div>
                                    <?php }?>
                                </div>
                            </div>
                        </div>
<?php }?>