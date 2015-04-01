<?php
class Zendvn_Models_Invoice extends Zend_Db_Table{
	protected $_name = 'invoice';
	protected $_primary = 'id';
	
	public function saveItem($arrParam = null, $options = null){		
		if($options['task'] == 'public-order'){	
			$row =  $this->fetchNew();
			$row->full_name 	= $arrParam['full_name'];
			$row->email 		= $arrParam['email'];
			$row->phone 		= $arrParam['phone'];
			$row->address 		= $arrParam['address'];
			$row->shipping 		= $arrParam['shipping'];
			$row->comment 		= $arrParam['comment'];
			$row->payment 		= $arrParam['payment'];
			$row->created 		= date("Y-m-d-G-i-s");
			$row->status 		= 0;			
			$id = $row->save();			
		}
		return $id;
	}
	public function listItem($arrParam = null, $options = null){
		if($options['task'] == 'admin-list'){
			$db 	= $this	-> getAdapter();
			$select = $db 	-> select()
							-> from($this->_name . ' AS in',array('id','full_name','email','phone','address'))
							-> order('id DESC');
			$result = $db   -> fetchAll($select);
		}
		return $result;
	}
	public function deleteItem($arrParam = null, $options = null){
		if($options['task'] == 'admin-delete'){
			$where = ' id = ' . $arrParam['id'];
			$row = $this->fetchRow($where);
			$this->delete($where);
		}
		if($options['task'] == 'admin-multi-delete'){
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);			
				$db = $this->getAdapter();
				$where = 'id IN (' . $ids . ')';
				$this->delete($where);
			}
		}
	}
}