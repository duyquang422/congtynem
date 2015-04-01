<?php
class Block_BlkCategoryNews extends Zend_View_Helper_Abstract{
	public function blkCategoryNews(){
		$view  = $this->view;
		$arrParam = $view->arrParam;
		include_once (BLOCK_PATH. '/BlkCategoryNews/default.php');
		
	}
}