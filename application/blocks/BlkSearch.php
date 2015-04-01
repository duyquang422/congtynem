<?php
class Block_BlkSearch extends Zend_View_Helper_Abstract{
	public function blkSearch(){
		$view  = $this->view;
		$arrParam = $view->arrParam;
		include_once (BLOCK_PATH. '/BlkSearch/default.php');
		
	}
}