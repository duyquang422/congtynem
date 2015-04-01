<?php
class Zendvn_Models_Sales extends Zend_Db_Table{
	protected $_name = 'sales';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		$ssFilter = $arrParam['ssFilter'];		
		$select = $db	->select()
						->from($this->_name . ' AS s',array('COUNT(s.id) AS totalItem'));
		
						
		if($options['task'] == 'admin'){
			$select->where('s.status = 0');
		}
		//echo $select;
		$result = $db->fetchOne($select);
		return $result;
		
	}	
	public function listItem($arrParam = null, $options = null){										
		$db = $this->getAdapter();		
		$paginator = $arrParam['paginator'];
		$ssFilter = $arrParam['ssFilter'];

		if($options['task'] == 'admin-list'){
			$select = $db->select()
						 ->from($this->_name . ' AS s')
						 ->order('id DESC');
			
			if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){
				$select->order($ssFilter['col'] . ' ' . $ssFilter['order']);			
			}
			$result  = $db->fetchAll($select);
									 
			if($paginator['itemCountPerPage']>0){
				$page = $paginator['currentPage'];
				$rowCount = $paginator['itemCountPerPage'];
				$select->limitPage($page,$rowCount);
			}
			
			if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('s.name LIKE ?',$keywords,STRING);
			}
			$result  = $db->fetchAll($select);
		}
		
		if($options['task'] == 'public'){
			$select = $db->select()
						 ->from($this->_name . ' AS u')
						 ->joinLeft('user_group AS g','g.id = u.group_id',array('group_name','g.id AS group_id'))
						 ->where('u.id = ?',$options['user_id']);
			$result  = $db->fetchRow($select);
		}
		
		if($options['task'] == 'user'){
			$select = $db->select()
						 ->from($this->_name . ' AS u')
						 ->joinLeft('user_group AS g','g.id = u.group_id',array('group_name','g.id AS group_id'))
						 ->where('u.id = ?',$options['id']);
			$result  = $db->fetchRow($select);
		}
		
		if($options['task'] == 'news'){
			$select = $db->select()
						 ->from($this->_name . ' AS u')
						 ->joinLeft('user_group AS g','g.id = u.group_id',array('group_name','g.id AS group_id'))
						 ->where('u.id = ?',$options['id']);
			$result  = $db->fetchRow($select);
		}
		if($options['task'] == 'forgot'){
			$select = $db->select()
						 ->from($this->_name . ' AS u')
						 ->where('u.user_name = ?',$arrParam['user_name']);
			$result  = $db->fetchRow($select);
		}
		if($options['task'] == 'active'){
			$select = $db->select()
						 ->from($this->_name . ' AS u')
						 ->where('u.token = ?',$arrParam['token']);
			$result  = $db->fetchRow($select);
		}
		
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null){
		
		if($options['task'] == 'public-add'){
			$row =  $this->fetchNew();
		}
		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$row =  $this->fetchRow($where);
		}
		$encode = new Zendvn_Encode();
		$row->name 		= strip_tags($arrParam['name']);
		$row->email 	= $arrParam['email'];
		$row->phone 	= strip_tags($arrParam['phone']);
		//$row->title 	= $arrParam['title'];
		$row->content 	= strip_tags($arrParam['content']);
		$row->status 	= 0;
		
		
		$row->save();
		
	}
	
	public function getItem($arrParam = null, $options = null){		
		if($options['task'] == 'admin-info' || $options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$result = $this->fetchRow($where)->toArray();
		}
		if($options['task'] == 'forgot'){
			$where = 'user_name = ' . $arrParam['user_name'];
			$result = $this->fetchRow($where)->toArray();
		}
		if($options['task'] == 'info'){
			$where = 'id = ' . $options['id'];
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
}