<?php
	$params = $this->arrParam;

	//=========== Loại pỏ những param ko phải liên quan ví dụ phân trang, session ==========
	unset($params['paginator']);
	unset($params['ssFilter']);
	
 	$link = array();
 	if(!empty($params)){
	 	foreach ($params as $k => $v){
		  	$link[$k] = $params[$k];
		 }
 	}
 	$linkVi = array_merge($link, array('lang' => 'vi'));
 	$linkVi = $this->url($linkVi); 

 	$linkEn = array_merge($link, array('lang' => 'en'));
 	$linkEn = $this->url($linkEn);
	 
?>
<ul class="icon-lang">
	<li>
		<a href="<?php echo $linkVi;?>">
			<img src="<?php echo $this->imgUrl;?>/lang-vi.png" alt="ngôn ngữ việt nam" />
		</a>
	</li>
	<li>
		<a href="<?php echo $linkEn;?>">
			<img src="<?php echo $this->imgUrl;?>/lang-en.png" alt="ngôn ngữ tiếng anh" />
		</a>
	</li>
</ul>