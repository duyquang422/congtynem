<?php
class Zendvn_Models_Users extends Zend_Db_Table{
	protected $_name = 'users';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		$ssFilter = $arrParam['ssFilter'];		
		$select = $db	->select()
						->from($this->_name . ' AS u',array('COUNT(u.id) AS totalItem'));		
		if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('u.user_name LIKE ?',$keywords,STRING);
		}
		if($ssFilter['groupId']>0){
				$select->where('u.group_id = ?',$ssFilter['groupId'],INTEGER);
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
						 ->joinLeft('user_group AS g','g.id = u.group_id',array('group_name','g.id AS group_id'));
			
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
				$select->where('u.user_name LIKE ?',$keywords,STRING);
			}
			if($ssFilter['groupId']>0){
				$select->where('u.group_id = ?',$ssFilter['groupId'],INTEGER);
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
		
		if($options['task'] == 'admin-add'){
			$row =  $this->fetchNew();
			$row->register_date = date("Y-m-d-G-i-s");
			$row->register_ip	= $_SERVER['REMOTE_ADDR'];
		}
		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$row =  $this->fetchRow($where);
			$row->visited_date 	= date("Y-m-d-G-i-s");
			$row->visited_ip	= $_SERVER['REMOTE_ADDR'];
		}
		$encode = new Zendvn_Encode();
		$row->user_name 	= $arrParam['user_name'];
		$row->password 		= $encode->password($arrParam['password']);
		$row->email 		= $arrParam['email'];
		$row->group_id 		= $arrParam['group_id'];
		$row->first_name 	= $arrParam['first_name'];
		$row->last_name 	= $arrParam['last_name'];
		$row->birthday 		= $arrParam['birthday'];
		$row->sign 			= $arrParam['sign'];
		$row->status 		= $arrParam['status'];
		if(!empty($arrParam['user_avatar'])) : $row->user_avatar 	= $arrParam['user_avatar'];endif;
		
		if($options['task'] == 'user-register'){
			$row =  $this->fetchNew();
			$encode  = new Zendvn_Encode();
			$row->last_name 	= $arrParam['last_name'];
			$row->password 		= $encode->password($arrParam['password']);
			$row->email 		= $arrParam['email'];
			$row->status 		= 1;
			$row->phone 		= $arrParam['phone'];
			$row->group_id		= 4; // Nhóm Thành viên
                        $row->birthday 		= $arrParam['birthday'];
			$row->register_date	= date("Y-m-d H:i:s");
			$row->register_ip	= $_SERVER['REMOTE_ADDR'];		
		}
		if($options['task'] == 'forgot'){
			$where 		= 'id = ' . $options['id'];
			$row 		=  $this->fetchRow($where);
			$row->token = $arrParam['token'];
		}
		if($options['task'] == 'active'){
			$encode  = new Zendvn_Encode();
			$where 			= 'id = ' . $options['id'];
			$row 			=  $this->fetchRow($where);
			$row->password 	= $encode->password($arrParam['password']);
			$row->token 	= '';
		}
		if($options['task'] == 'edit-pass'){
			$encode  	= new Zendvn_Encode();
			$where 		= 'id = ' . $arrParam['id'];
			$row 		=  $this->fetchRow($where);
			$row->password 	= $encode->password($arrParam['password']);
		}
		
		
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
			$row = $this->fetchRow($where);
			$upload_dir = FILES_PATH . '/users';
			$upload = new Zendvn_File_Upload();
			$upload->removeFile($upload_dir . '/orignal/' . $row['user_avatar']);
			$upload->removeFile($upload_dir . '/images100x100/' . $row['user_avatar']);
			$upload->removeFile($upload_dir . '/images450x450/' . $row['user_avatar']);
			$this->delete($where);
		}		
		if($options['task'] == 'admin-multi-delete'){
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);			
				$db = $this->getAdapter();
				$where = 'id IN (' . $ids . ')';
				$select = $db->select()
								->from('users',array("user_avatar"))
								->where($where);
				$result = $db->fetchAll($select);
				foreach ($result as $key => $value) {
					$upload_dir = FILES_PATH . '/users';
					$upload = new Zendvn_File_Upload();
					$upload->removeFile($upload_dir . '/orignal/' . $value['user_avatar']);
					$upload->removeFile($upload_dir . '/images100x100/' . $value['user_avatar']);
					$upload->removeFile($upload_dir . '/images450x450/' . $value['user_avatar']);
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