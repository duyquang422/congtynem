<?php
class Zendvn_Models_Link extends Zend_Db_Table{
	protected $_name = 'link_connect';
	protected $_primary = 'id';
	
	public function itemInSelectboxx($arrParam = null, $options = null){
		$db = Zend_Registry::get('connectDb');
		if($options == null){
			$select = $db->select()
						 ->from($this->_name, array('id','name'));
			$result = $db->fetchPairs($select)	;
			$result[0] = ' -- Select an Item -- ';
			ksort($result);								 
		}
		return $result;
	}
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		$ssFilter = $arrParam['ssFilter'];		
		$select = $db	->select()
						->from($this->_name . ' AS c',array('COUNT(c.id) AS totalItem'));		
		if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('c.name LIKE ?',$keywords,STRING);
		}
		$result = $db->fetchOne($select);
		return $result;		
	}
	
	public function sortItem($arrParam = null, $options = null){			
		$items = $arrParam['items'];
		if(count($items)>0){
			foreach ($items as $key => $val) {
				$where = 'id = ' . $key;				
				$data = array('order'=>$val);
				$this->update($data,$where);
			}
		}
	}
	
	public function listItem($arrParam = null, $options = null){
		$ssFilter = $arrParam['ssFilter'];
		$db	= $this->getAdapter();
		if($options['task'] == 'admin-list'){
			$select = $db	->select()
							->from($this->_name . ' AS c');							
			// Order..............
			$order = 'id DESC';
			$ssFilter = $arrParam['ssFilter'];
			if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){
				$order = $ssFilter['col'] . ' ' . $ssFilter['order'];
			}
			$select->order($order);
						
			//Filter
			if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('c.name LIKE ?',$keywords,STRING);
			}
			$result  = $db->fetchAll($select);
			$recursive = new Zendvn_System_Recursive($result);
			$result = $recursive -> buildArray(0);
		}
		if($options['task'] == 'public'){
			$select = $db	->select()
							->from($this->_name . ' AS c')
							->where('status = 1');
			$result  = $db->fetchAll($select);
		}
		return $result;	
	}	
	public function saveItem($arrParam = null, $options = null){	
		$info = new Zendvn_System_Info();
		$memberInfo = $info->getMemberInfo('id');
		
		if($options['task'] 	== 'admin-add'){
			$row 				= $this->fetchNew();
		}		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];			
			$row =  $this->fetchRow($where);
		}
		
		$row->name 		= $arrParam['name'];
		$row->url 		= $arrParam['url'];
		$row->status 	= $arrParam['status'];
		$row->save();	
	}
	
	public function getItem($arrParam = null, $options = null){
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$result = $this->fetchRow($where)->toArray();
		}
		if($options['task'] == 'admin-info'){
			$db = $this->getAdapter();
			$select = $db->select()
						 ->from($this->_name . ' AS c',array('id','name','status','order','parents','created_by','picture'))
						 ->joinLeft('link_website AS c2','c.parents = c2.id',array('name as parent_name'))
						 ->order('c.order ASC')
						 ->where('c.id =?',$arrParam['id']);
			$result = $db->fetchRow($select);
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
	
		
}