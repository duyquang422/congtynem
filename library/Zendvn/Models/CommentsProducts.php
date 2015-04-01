<?php
class Zendvn_Models_CommentsProducts extends Zend_Db_Table{
	protected $_name = 'comment_pro';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		
		$ssFilter = $arrParam['ssFilter'];
		
		$select = $db	->select()
						->from($this->_name . ' AS p',array('COUNT(p.id) AS totalItem'));
		
						
		if($options['task'] == 'admin'){
			$select->where('p.status = 0');
		}
		//echo $select;
		$result = $db->fetchOne($select);
		return $result;
		
	}
	
	public function listItem($arrParam = null, $options = null){
		$paginator = $arrParam['paginator'];
		$ssFilter = $arrParam['ssFilter'];
		$db = $this->getAdapter();
		if($options['task'] == 'admin-list'){
			$select = $db	->select()
							->from($this->_name . ' AS n',array('id','user_name','email','created','status','order','title','content','special'))
							->joinLeft("products AS u","u.id = n.pro_id",array("u.name AS product_name"))
							->order('id DESC');	
													
			$result  = $db->fetchAll($select);
			if($paginator['itemCountPerPage']>0){
				$page = $paginator['currentPage'];
				$rowCount = $paginator['itemCountPerPage'];
				$select->limitPage($page,$rowCount);
			}
			$result  = $db->fetchAll($select);
		}
		if($options['task'] == 'list'){
			$select = $db->select()
						 ->from($this->_name . ' AS n',array('id','user_name','created','status','title','content','special','pro_id'))
						 ->joinLeft('products AS u','u.id = n.pro_id',array('u.name AS product_name'))
						 ->where('n.pro_id = ?', $arrParam['id'])
						 ->where('n.status = 1')
						 ->order('n.id DESC')
						 ->limit(15);

			$result  = $db->fetchAll($select);
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

	public function saveItem($arrParam = null, $options = null){
		$info = new Zendvn_System_Info();
		$memberInfo = $info->getMemberInfo('id');
		if($options['task'] == 'add-comment'){
			$row =  $this->fetchNew();
			$row->created		= date("Y-m-d-G-i-s");
			$row->user_name 	= $arrParam['user_name'];
			$row->email 		= $arrParam['email'];
			$row->title			= $arrParam['title_com'];
			$row->content		= $arrParam['content'];
			$row->pro_id		= $arrParam['id'];
			$row->special		= 0;
			$row->status		= 0;
			$row->save();
		}
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];			
			$row =  $this->fetchRow($where);
			$row->title			= $arrParam['title_com'];
			$row->content		= $arrParam['content'];
			$row->order			= $arrParam['order'];
			$row->status		= $arrParam['status'];
			$row->save();
		}
		
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