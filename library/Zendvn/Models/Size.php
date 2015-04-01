<?php
class Zendvn_Models_Size extends Zend_Db_Table{
	protected $_name = 'size';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();		
		$ssFilter = $arrParam['ssFilter'];		
		$select = $db	->select()
						->from($this->_name . ' AS s',array('COUNT(s.id) AS totalItem'));	
		//echo $select;
		$result = $db->fetchOne($select);
		return $result;
		
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
	
	public function listItem($arrParam = null, $options = null){
		$ssFilter = $arrParam['ssFilter'];
		$db = $this->getAdapter();		
		if($options['task'] == 'admin-list'){
			$select = $db->select()
						 ->from($this->_name . ' AS s');
			$order = 'id DESC';
			if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){
				$order = $ssFilter['col'] . ' ' . $ssFilter['order'];
			}
			$select->order($order);
			if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('s.name LIKE ?',$keywords,STRING);
			}					
			$result  = $db->fetchAll($select);		
		}
		if($options['task'] == 'public'){
			$select = $db->select()
						 ->from($this->_name . ' AS s')
						 ->order('id DESC')
                         ->where('status = 1');						
			$result  = $db->fetchAll($select);		
		}
		if($options['task'] == 'price'){
			$select = $db->select()
						 ->from($this->_name . ' AS s',array('name'))
                         ->where('status = 1');						
			$result  = $db->fetchAll($select);		
		}
		
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null){
			$info = new Zendvn_System_Info();
			$memberInfo = $info->getMemberInfo('id');
		
		if($options['task'] == 'admin-add'){
			$row =  $this->fetchNew();
		}
		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];			
			$row =  $this->fetchRow($where);
		}
		$row->name 			= $arrParam['name'];
		$row->units 		= $arrParam['units'];
		$row->note 			= $arrParam['note'];
		$row->order 		= $arrParam['order'];
		$row->status 		= $arrParam['status'];

		$row->save();
		
	}
	
	public function getItem($arrParam = null, $options = null){		
		if($options['task'] == 'admin-info' || $options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$result = $this->fetchRow($where)->toArray();
		}
		return $result;
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
				$status 	= 1;
			}else{
				$status  	= 0;
			}			
			$data = array('status'=>$status);
			$where = 'id = ' . $arrParam['id'];
			$this->update($data,$where);
		}		
	}
	public function changeSpecial($arrParam = null, $options = null){
		if($arrParam['id']>0){
			if($arrParam['type'] == 1){
				$special 	= 1;
			}else{
				$special 	= 0;
			}			
			$data = array('special'=>$special);
			$where = 'id = ' . $arrParam['id'];
			$this->update($data,$where);
		}		
	}
	
}