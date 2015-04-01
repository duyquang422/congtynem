<?php
class Zendvn_Models_UserGroup extends Zend_Db_Table{
	protected $_name = 'user_group';
	protected $_primary = 'id';
	
	public function itemInSelectbox($arrParam = null, $options = null){
		$db = Zend_Registry::get('connectDb');
		if($options == null){
			$select = $db->select()
						 ->from($this->_name . ' AS g', array('id','group_name'));
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
						->from($this->_name . ' AS g',array('COUNT(g.id) AS totalItem'));		
		if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('g.group_name LIKE ?',$keywords,STRING);
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
		$paginator = $arrParam['paginator'];
		$ssFilter = $arrParam['ssFilter'];
		$db	= $this->getAdapter();
		if($options['task'] == 'admin-list'){
			$select = $db	->select()
							->from($this->_name . ' AS g',array('id','group_name','status','group_acp','order','created'))
							->joinLeft('users AS u','g.id = u.group_id','COUNT(u.id) AS members')
							->group('g.id');							
			// Order..............
			$order = 'id DESC';
			$ssFilter = $arrParam['ssFilter'];
			if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){
				$order = $ssFilter['col'] . ' ' . $ssFilter['order'];
			}
			$select->order($order);

			//Phân trang
			if($paginator['itemCountPerPage']>0){
				$page = $paginator['currentPage'];
				$rowCount = $paginator['itemCountPerPage'];
				$select->limitPage($page,$rowCount);
			}

			//Filter
			if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('g.group_name LIKE ?',$keywords,STRING);
			}
			$result  = $db->fetchAll($select);
		}
		return $result;	
	}	
	public function saveItem($arrParam = null, $options = null){	
		$info = new Zendvn_System_Info();
		$memberInfo = $info->getMemberInfo('id');
		if($options['task'] 	== 'admin-add'){
			$row 				= $this->fetchNew();
			$row->created		= date("Y-m-d-G-i-s");
			$row->created_by 	= $memberInfo;	
		}		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];			
			$row =  $this->fetchRow($where);
			$row->modified 		= date("Y-m-d-G-i-s");
			$row->modified_by 	= $memberInfo;
		}
		$row->group_name 	= $arrParam['group_name'];
		if(!empty($arrParam['avatar'])):$row->avatar	= $arrParam['avatar'];endif;
		if(!empty($arrParam['ranking'])):$row->ranking	= $arrParam['ranking'];endif;
		$row->group_acp 	= $arrParam['group_acp'];
		$row->group_default = $arrParam['group_default'];
		$row->status 		= $arrParam['status'];
		$row->order 		= $arrParam['order'];	
		$row->save();	
	}
	
	public function getItem($arrParam = null, $options = null){		
		if($options['task'] == 'admin-info' || $options['task'] == 'admin-edit'){
			$db = $this->getAdapter();
			$select = $db->select()
						->from($this->_name . ' AS g')
						->joinLeft("users AS u","g.created_by = u.id",array("u.user_name AS user_name"))
						->where("g.id = ?",$arrParam['id']);
			//$where = 'id = ' . $arrParam['id'];
			$result = $db->fetchRow($select);
		}
		return $result;
	}
	
	public function deleteItem($arrParam = null, $options = null){
		if($options['task'] == 'admin-delete'){
			$where = ' id = ' . $arrParam['id'];
			$row = $this->fetchRow($where);
			$upload_dir = FILES_PATH . '/group';
			$upload = new Zendvn_File_Upload();
			$upload->removeFile($upload_dir . '/orignal/' . $row['avatar']);
			$upload->removeFile($upload_dir . '/images100x100/' . $row['avatar']);
			$upload->removeFile($upload_dir . '/images450x450/' . $row['avatar']);
			$upload->removeFile($upload_dir . '/orignal/' . $row['ranking']);
			$upload->removeFile($upload_dir . '/images100x100/' . $row['ranking']);
			$upload->removeFile($upload_dir . '/images450x450/' . $row['ranking']);
			$this->delete($where);
		}		
		if($options['task'] == 'admin-multi-delete'){
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);			
				$db = $this->getAdapter();
				$where = 'id IN (' . $ids . ')';
				$select = $db->select()
								->from($this->_name . ' AS g',array("avatar","ranking"))
								->where($where);
				$result = $db->fetchAll($select);
				foreach ($result as $key => $value) {
					$upload_dir = FILES_PATH . '/group';
					$upload = new Zendvn_File_Upload();
					$upload->removeFile($upload_dir . '/orignal/' . $value['avatar']);
					$upload->removeFile($upload_dir . '/images100x100/' . $value['avatar']);
					$upload->removeFile($upload_dir . '/images450x450/' . $value['avatar']);
					$upload->removeFile($upload_dir . '/orignal/' . $row['ranking']);
					$upload->removeFile($upload_dir . '/images100x100/' . $row['ranking']);
					$upload->removeFile($upload_dir . '/images450x450/' . $row['ranking']);
				}
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
	public function changeAcp($arrParam = null, $options = null){
		if($arrParam['id']>0){
			if($arrParam['type'] == 1){
				$group_acp = 1;
			}else{
				$group_acp = 0;
			}			
			$data = array('group_acp'=>$group_acp);
			$where = 'id = ' . $arrParam['id'];
			$this->update($data,$where);
		}
	}
}