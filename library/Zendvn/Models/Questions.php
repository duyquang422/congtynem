<?php
class Zendvn_Models_Questions extends Zend_Db_Table{
	protected $_name = 'question';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		$ssFilter = $arrParam['ssFilter'];		
		$select = $db	->select()
						->from($this->_name . ' AS u',array('COUNT(u.id) AS totalItem'));		
		if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('u.title LIKE ?',$keywords,STRING);
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
						 ->from($this->_name . ' AS u')
						 ->joinLeft('answers AS a','u.id = a.ques_id',array('a.content as answer','a.user_name as user_reply','a.created as created_answer'))
						 ->joinLeft('users AS us','u.user_name = us.user_name',array('us.user_avatar as avatar'))
						 ->order(' id DESC');
			
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
				$select->where('u.title LIKE ?',$keywords,STRING);
			}
			$result  = $db->fetchAll($select);
		}
		
		if($options['task'] == 'index'){
			$paginator = $arrParam['paginator'];
			$select = $db->select()
						 	->from($this->_name . ' AS u')
						 	->joinLeft('answers AS a','u.id = a.ques_id',array('a.content as answer','a.user_name as user_reply','a.created as created_answer'))
						 	->joinLeft('users AS us','u.user_name = us.user_name',array('us.user_avatar as avatar'))
						 	->where('u.status = 1')
						 	->order(' id DESC')
							->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);
			
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
				$select->where('u.title LIKE ?',$keywords,STRING);
			}
			$result  = $db->fetchAll($select);
		}
		
		if($options['task'] == 'detail'){
			$select = $db->select()
						 	->from($this->_name . ' AS u')
						 	->joinLeft('users AS us','u.user_name = us.user_name',array('us.user_avatar as avatar'))
						 	->where('u.id = ?',$arrParam['id']);
			
			$result  = $db->fetchRow($select);
			
		}
		
		if($options['task'] == 'public'){
			$select = $db->select()
						 ->from($this->_name . ' AS u')
						 ->joinLeft('user_group AS g','g.id = u.group_id',array('group_name','g.id AS group_id'))
						 ->where('u.id = ?',$options['user_id']);
			$result  = $db->fetchRow($select);
		}
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null){
		$filter = new Zend_Filter();
		$multiFilter = $filter	->addFilter(new Zend_Filter_StringToLower(array('encoding'=>'UTF-8')))
								->addFilter(new Zend_Filter_StringTrim())
						 		->addFilter(new Zend_Filter_Alnum(true))
//						  		->addFilter(new Zend_Filter_PregReplace(array('match'=>'#\s+#','replace'=>'-')))
						  		->addFilter(new Zend_Filter_Word_SeparatorToDash())
						  		->addFilter(new Zendvn_Filter_RemoveCircumflex());
		if($options['task'] 	== 'new'){
			$row =  $this->fetchNew();
			$row->title 	= $arrParam['title'];
			$row->content	= $arrParam['content'];
			$row->user_name	= $arrParam['user_name'];
			$row->status	= 0;
			$row->created		= date("Y-m-d-G-i-s");
			$row->alias 		= $filter->filter($arrParam['title']);
			$row->save();
		}
		if ($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$row =  $this->fetchRow($where);
			$row->status	= 1;
		}
		
		$row->save();
	}
	
	public function getItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
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