<?php
	$tblCategoryMenu = new Zendvn_Models_CatItem();
	$tblMenu = $tblCategoryMenu->listItem($this->_arrParam,null);
	$newArr = array();
	if(!empty($tblMenu)){
		foreach ($tblMenu as $key => $val){
			if($val['parents']==0){
				$newArr[$val["id"]] = $val; 
			}else{
				$newArr[$val["parents"]]['child'][] = $val;
			}
		}
	}
	$filter = new Zend_Filter();
	$multiFilter = $filter->addFilter(new Zendvn_Filter_RemoveCircumflex())
						  ->addFilter(new Zend_Filter_StringToLower(array('encoding'=>'UTF-8')))
						  ->addFilter(new Zend_Filter_Alnum(true))
						  ->addFilter(new Zend_Filter_PregReplace(array('match'=>'#\s+#','replace'=>'-')))
						  ->addFilter(new Zend_Filter_Word_SeparatorToDash());
?>
<div align="center" class="menu_product">
<h2>TOUR DU LỊCH</h2>
<dl>
	<?php
		foreach ($newArr as $key => $val){
			if(!empty($val['name'])){
				$link = $view->baseUrl('/products/index/category/cid/'
						. $val['id'] . '/name/'
						. $multiFilter->filter($val['name']));
			echo '<dt><a href="'.$link.'">'. $val['name'] .'</a></dt>';
			}
			if(!empty($val['child'])){
				$child = '<dd><ul id="nav">';
				foreach ($val['child'] as $keyChild => $valChild){
					$link = $view->baseUrl('/products/index/category/cid/' 
												 . $valChild['id'] . '/name/' 
												 . $multiFilter->filter($valChild['name']));
					$child .= '<li id="'.$valChild['id'].'"><a href="'. $link .'">'.$valChild['name'].'</a></li>';
				}
				$child .= '</ul></dd>';
				echo $child;
			}
		}
	?>
</dl>
</div>