<?php
class Zendvn_Models_Supports extends Zend_Db_Table{
	protected $_name = 'supports';
	protected $_primary = 'id';
		
	public function listItem($arrParam = null, $options = null){										
		$db = $this->getAdapter();		
		$paginator = $arrParam['paginator'];
		$ssFilter = $arrParam['ssFilter'];

		if($options['task'] == 'admin-list'){
			$select = $db->select()
						 ->from($this->_name . ' AS u',array('id','name','phone','status','nick','manage','type','order'));
			$result  = $db->fetchAll($select);
		}
		if($options['task'] == 'public'){
			$select = $db->select()
						 ->from($this->_name . ' AS u',array('id','name','phone','status','nick','manage','type','order'))
						 ->where('status = 1')
						 ->order('order ASC');
			$result  = $db->fetchAll($select);
		}
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null){		
		if($options['task'] == 'admin-add'){
			$row =  $this->fetchNew();
		}
		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];			
			$row =  $this->fetchRow($where);
		}
		$row->name 		= $arrParam['name'];
		$row->phone 	= $arrParam['phone'];
		$row->manage 	= $arrParam['manage'];
		$row->nick 		= $arrParam['nick'];
		$row->type	 	= $arrParam['type'];
		$row->status 		= $arrParam['status'];
		$row->save();		
	}	
	public function deleteItem($arrParam = null, $options = null){
		if($options['task'] == 'admin-delete'){
			$where = ' id = ' . $arrParam['id'];
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

	public function changeStatus($arrParam = null, $options = null){
		$cid = $arrParam['cid'];		
		if(count($cid)>0){
			if($arrParam['type'] == 1){
				$status = 1;
			}else{
				$status = 0;
			}			
			$ids = implode(',',$cid);
			$data = array('status'=>$status);
			$where = 'id IN (' . $ids . ')';
			$this->update($data,$where);
		}
		if($arrParam['id']>0){
			if($arrParam['type'] == 1){
				$status = 1;
			}else{
				$status = 0;
			}			
			$data = array('status'=>$status);
			$where = 'id = ' . $arrParam['id'];
			$this->update($data,$where);
		}		
	}
	public function sortItem($arrParam = null, $options = null){
		$items = $arrParam[$options['column']];
		if(count($items)>0){
			foreach ($items as $key => $val) {
				$where = 'id = ' . $key;				
				$data = array($options['column']=>$val);
				$this->update($data,$where);
			}
		}
	}
	public function getItem($arrParam = null, $options = null){		
		if($options['task'] == 'admin-info' || $options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$result = $this->fetchRow($where)->toArray();
		}
		return $result;
	}
	
}