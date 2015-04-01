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
	
	$urlHome 		= array('module'=>'default','controller'=>'index','action'=>'index','lang'=>$langTmp);
   	$linkHome 		= $view->url($urlHome,'home');
   	
   	$urlPro 		= array('module'=>'products','controller'=>'index','action'=>'index','lang'=>$langTmp,'page'=>$page);
   	$linkPro 		= $view->url($urlPro,'products');
   	
   	$urlNews 		= array('module'=>'news','controller'=>'index','action'=>'index','lang'=>$langTmp,'page'=>$page);
   	$linkNews 		= $view->url($urlNews,'news');
   	
   	$urlPhotos 		= array('module'=>'photos','controller'=>'index','action'=>'index','lang'=>$langTmp,'page'=>$page);
   	$linkPhotos 	= $view->url($urlNews,'photos');
   	
   	$urlService 		= array('module'=>'services','controller'=>'index','action'=>'index','lang'=>$langTmp,'page'=>$page);
   	$linkService 		= $view->url($urlService,'service');
   	
   	$urlContact 	= array('module'=>'default','controller'=>'index','action'=>'contact','lang'=>$langTmp);
   	$linkContact 	= $view->url($urlContact,'contact');
   	
   	$urlAbout 		= array('module'=>'default','controller'=>'index','action'=>'about','lang'=>$langTmp);
   	$linkAbout 		= $view->url($urlAbout,'about');
   	
   	$urlBusiness 	= array('module'=>'business','controller'=>'index','action'=>'index','lang'=>$langTmp,'page'=>$page);
   	$linkBusiness 	= $view->url($urlBusiness,'business');
?>

<div class="box-category">
                            <div class="sub-category"><p>MENU MAIN</p></div>
                            <div class="cnt-box-category">
                                <ul class="nav-cat">
                                    
                                    <?php
				                    	$tblNews 	= new Zendvn_Models_CategoryNews();
				                    	$catNews 	= $tblNews->listItem($view->arrParam,array('task'=>'public'));
				                    	if(!empty($catNews)){
				                    		foreach ($catNews as $key => $item){
				                    			if($item['positions'] == 4 || $item['positions'] == 0){
					                    			$name 	= $item['name'];
					                    			$id 	= $item['id'];               			
					                    			$urlOptions = array('module'=>'news','controller'=>'index',
																						'action'=>'category',
									                    								'cid'=> $item['id'],
																						'name'=>$item['alias'],
									                    								'lang'=>$lang,
									                    								'page'=>$page);
									                $linkDetail = $view->url($urlOptions,'news-category');
				                    ?>
                                    <li class='list-nav'><a id="item-<?php echo $id?>" href="<?php echo $linkDetail?>"><?php echo $name ?></a></li>
                                    <?php
				                    			}
				                    		} 
				                    	}
				                    ?>
                                </ul>
                            </div>
                        </div>
<?php 
	$mod 	= $view->arrParam['module'];
	$action = $view->arrParam['action'];
?>
            
<script>
	$(document).ready(function(){
		var itemCls1 = '<?php echo $mod . "-" . $action ?>' ;
		var itemCls2 = '<?php echo $mod ?>' ;
		var itemCls3 = 'item-' + '<?php echo $view->arrParam['tid']?>';
		
		$('.list').removeClass('active');
		$('#' + itemCls1).addClass('active');
		$('#' + itemCls2).addClass('active');
		$('#' + itemCls3).addClass('active');
	})
</script> 