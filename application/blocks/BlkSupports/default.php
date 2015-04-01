<div class='box-left'>
	<div class='sub-box-left'><span class='icon'></span><p>HỖ TRỢ TRỰC TUYẾN</p></div>
	<div class='cnt-box-left support-left'>
			<?php
	     		$tblSupport = new Zendvn_Models_Supports();
	     		$support = $tblSupport->listItem($view->arrParam,array('task'=>'public')); 
	     		if(!empty($support)){
	     			foreach ($support as $key => $val){
	     				$name 	= $val['name'];
	     				$nick 	= $val['nick'];
	     				$manage = $val['manage'];
	     				$phone 	= $val['phone'];
	     	?>
	     		<?php
	     			if($val['type'] == 0){
	     				
	     		?>
                    <a href="ymsgr:sendIM?<?php echo $nick; ?>" title="<?php echo $name; ?>">
                    	<img src="<?php echo $view->imgUrl ?>/icon/yahoo.png"/>
                	</a>
	     		<?php }else{?>
                	<div class='sup-box'>
						<a href='href="skype:<?php echo $nick;?>?call'><img src="http://mystatus.skype.com/balloon/<?php echo $nick?>" /></a>
						<div>
							<p><?php echo $manage?></p>
							<p class='col-red'><?php echo $phone?></p>
						</div>
					</div>
	     		
	     		<?php 
	     					}
	     				}
	     			}
	     		?>
	</div>
</div>