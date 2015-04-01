<?php
class Zendvn_Models_Positions extends Zend_Db_Table{
	protected $_name = 'positions';
	protected $_primary = 'id';
	protected $_ids;
	
public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		
		$ssFilter = $arrParam['ssFilter'];
		
		$select = $db	->select()
						->from('positions AS a',array('COUNT(a.id) AS totalItem'));
		
		if($ssFilter['poisition']>0){
				$select->where('a.poisition = ?',$ssFilter['poisition'],INTEGER);
			}		
		//echo $select;
		$result = $db->fetchOne($select);
		return $result;
		
	}
	public function itemInSelectbox($arrParam = null, $options = null){
		$db = Zend_Registry::get('connectDb');
		if($options == null){
			$select = $db->select()
						 ->from('positions', array('id','name'));
			$result = $db->fetchPairs($select)	;
			$result[0] = ' -- Select an Item -- ';
			ksort($result);								 
		}
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
		$db = $this->getAdapter();
		
		if($options['task'] == 'admin-list'){
			$select = $db->select()
						 ->from('positions AS p',array('id','name','resize','price','selloff','order','status'))
						 ->order('id ASC');				 							
			$result  = $db->fetchAll($select);			
		}
		if($options['task'] == 'admin-load-positions'){
			$select = $db->select()
						 ->from('positions AS p',array('id','name','resize','price','selloff','order','status'))
						 ->order('id DESC')
						 ->where('id = ?',$arrParam['position_id']);				
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
		$row->name 			= $arrParam['name'];
		$row->resize 		= $arrParam['resize'];
		$row->price 		= $arrParam['price'];
		$row->selloff 		= $arrParam['selloff'];
		$row->status 		= $arrParam['status'];
		$row->order 		= $arrParam['order'];
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