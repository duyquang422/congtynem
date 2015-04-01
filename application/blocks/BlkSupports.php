<?php
class Block_BlkSupports extends Zend_View_Helper_Abstract{
	public function blkSupports(){
		$view  = $this->view;
		$arrParam = $view->arrParam;
		include_once (BLOCK_PATH. '/BlkSupports/default.php');
		
	}
}