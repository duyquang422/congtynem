<div class="box-right mar-top-20">                	
     <div class="sub-right bag-title-right-green"><p>Hỗ trợ trực tuyến</p></div>
     <div class="cnt-box-right">
	     <div class="support">
	     	<?php
	     		$tblSupport = new Zendvn_Models_Supports();
	     		$support = $tblSupport->listItem($view->arrParam,array('task'=>'public')); 
	     		if(!empty($support)){
	     			foreach ($support as $key => $val){
	     				$name 	= $val['name'];
	     				$nick 	= $val['nick'];
	     				$manage = $val['manage'];
	     	?>
	     	<?php
				if($type == 0){ 
			?>	
			<a class='online' href="ymsgr:sendIM?<?php echo $nick; ?>" title="<?php echo $name; ?>">
				<img width='85' src="http://opi.yahoo.com/online?u=<?php echo $nick;?>&m=g&t=14" alt="Chuyên luyện Toeic" />
				<p class="name-support color-blue"><?php echo $name ?></p>
				<p class="jobs"><?php echo $manage ?></p>
			</a> 
			<?php 
				}else{
			?>
			<script type="text/javascript" src="http://download.skype.com/share/skypebuttons/js/skypeCheck.js"></script>
			<a class='online' href="skype:<?php echo $nick;?>?call">
				<img src="http://mystatus.skype.com/balloon/<?php echo $nick;?>" style="border: none;" width="150" height="60" alt="My status" />
				<p class="name-support color-blue"><?php echo $name ?></p>
				<p class="jobs"><?php echo $manage ?></p>
			</a>
			<?php }?>
			<?php }}?>
	     </div>
     </div>
</div>