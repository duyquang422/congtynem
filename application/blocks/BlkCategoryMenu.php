<?php
class Block_BlkCategoryMenu extends Zend_View_Helper_Abstract{
	public function blkCategoryMenu(){
		$view  = $this->view;
		$arrParam = $view->arrParam;
		include_once (BLOCK_PATH. '/BlkCategoryMenu/default.php');
		
	}
}