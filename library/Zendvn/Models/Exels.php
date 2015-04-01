<?php
class Zendvn_Models_Exels extends Zend_Db_Table{
	protected $_name = 'exels';
	protected $_primary = 'id';
	/*public function listItem($arrParam = null, $options = null){										
		$db = $this->getAdapter();
		if($options['task'] == 'admin-list'){
			$select = $db->select()
						 ->from('exels',array('id','title','description','header','footer','description_html','keywords_html'));
			$result  = $db->fetchAll($select);
		}
		return $result;
	}*/
	
	public function saveItem($arrParam = null, $options = null){
		$exels = $arrParam['files'];
		
		foreach ($exels as $key => $value) {
			if($options['task'] == 'admin-add'){
				$row =  $this->fetchNew();
			}
			foreach ($value as $val) {
				$row->name 		= $value[1];
				$row->code 		= $value[2];
				$row->posi		= $value[3];
			}
			$row->save();
		}
	}
	
	public function saveItem2($arrParam = null, $options = null){

		$exels = $arrParam['files'];
		
		foreach ($exels as $key => $value) {
			if($options['task'] == 'admin-add'){
				$row =  $this->fetchNew();
			}
			foreach ($value as $val) {
				
				$row->name 		= $value[2];
				$row->code 		= $value[3];
				$row->posi		= $value[4];
			}
			$row->save();
		}
	}
	public function delete($arrParam = null, $options = null){
		$upload = new Zendvn_File_Upload();
		$upload_dir = FILES_PATH . '/exels/';
		$filename = $arrParam['fileexel'];
		$upload->removeFile($upload_dir . $filename);	
	}
	
	/*public function sortItem($arrParam = null, $options = null){
		$items = $arrParam[$options['column']];
		if(count($items)>0){
			foreach ($items as $key => $val) {
				$where = 'id = ' . $key;				
				$data = array($options['column']=>$val);
				$this->update($data,$where);
			}
		}
	}*/
}