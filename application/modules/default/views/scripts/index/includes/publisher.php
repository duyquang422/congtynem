<?php
	include 'lang.php';
	$tblPublisher	= new Zendvn_Models_Publisher();
	$publisher		= $tblPublisher->listItem($this->arrParam,array('task'=>'public'));
	if (!empty($publisher)){
?>
<div class='lisher width-100'>
	<?php
		foreach ($publisher as $key => $value){
			$name		= str_replace("\\"," ",$value['name']);
			$alias_pub	= $value['alias'];
			if(!empty($value['picture'])){
				$linkImg	= FILES_URL . '/publisher/orignal/' . $value['picture'];
				$picture 	= '<img title="'. $name .'" src="'. $linkImg .'" alt="'.$name.'" />';
			}else{
				$linkImg	= $this->imgUrl . '/no-image.jpg';
				$picture 	= '<img title="'. $name .'" src="'. $linkImg .'" width="110" alt="'.$name.'" />';
			}
			if(($key+1)%4){
				$col = 'col-1';
			}else{
				$col = 'col-4';
			}
			$urlOptions = array('module'=>'products','controller'=>'index',
													'action'=>'index',
													'publisher'=>$alias_pub,
													'page'=>$page,
													'lang'=>$lang);
			$linkDetail = $this->url($urlOptions,'products-pub');
	?>
						<div class='box-lisher width-22 <?php echo $col?>'>
							<a href="<?php echo $linkDetail?>"><?php echo $picture?></a>
						</div>
	<?php
		} 
	?>
</div>
<?php 
	}
?>