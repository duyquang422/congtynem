<?php
class Zendvn_Models_Phone extends Zend_Db_Table{
	protected $_name = 'phone';
	protected $_primary = 'id';
        public function saveItem($arrParam = null, $options = null){
		$row =  $this->fetchNew();
		$row->id 	= $arrParam['id'];
		$row->phone 		= $arrParam['phone'];
                $row->ngaygiotuvan	= date("Y-m-d H:i:s");
                $row->status	= 0;
		$row->save();	
	}
        public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();		
		$select = $db	->select()
						->from($this->_name . ' AS g',array('COUNT(g.id) AS totalItem'));		
		$result = $db->fetchOne($select);
		return $result;		
	}
        public function countNew($arrParam = null, $options = null){
		$db = $this->getAdapter();		
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
		$paginator = $arrParam['paginator'];
		$ssFilter = $arrParam['ssFilter'];
		$db	= $this->getAdapter();
		if($options['task'] == 'admin-list'){
			$select = $db	->select()
							->from($this->_name,array('id','phone','ngaygiotuvan','status'));
			$order = 'id DESC';
			$select->order($order);
			//Phân trang
			if($paginator['itemCountPerPage']>0){
				$page = $paginator['currentPage'];
				$rowCount = $paginator['itemCountPerPage'];
				$select->limitPage($page,$rowCount);
			}
			$result  = $db->fetchAll($select);
		}
		return $result;	
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
        public function deleteItem($arrParam = null, $options = null){
		if($options['task'] == 'admin-delete'){
			$where = ' id = ' . $arrParam['id'];
//			$row = $this->fetchRow($where);
			$this->delete($where);
		}		
		if($options['task'] == 'admin-multi-delete'){
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);
				$where = 'id IN (' . $ids . ')';
				$this->delete($where);
			}
		}
	}
}
?>
