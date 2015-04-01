<?php
class Zendvn_Models_Answers extends Zend_Db_Table{
	protected $_name = 'answers';
	protected $_primary = 'id';
	
	public function listItem($arrParam = null, $options = null){										
		$db = $this->getAdapter();		
		$paginator = $arrParam['paginator'];
		$ssFilter = $arrParam['ssFilter'];

		if($options['task'] == 'answer'){
			$select = $db->select()
						 ->from($this->_name . ' AS u')
						 ->where('ques_id = ?',$arrParam['id']);
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
		$info = new Zendvn_System_Info();
		$memberInfo = $info->getMemberInfo('id');
		$tbltUser 	= new Zendvn_Models_Users();
		$user 		= $tbltUser->listItem($this->arrParam,array('id'=>$memberInfo,'task'=>'user'));
		if($options['task'] 	== 'answer'){
			$row =  $this->fetchNew();
			$row->ques_id 	= $arrParam['id'];
			$row->content	= $arrParam['answer'];
			$row->user_name	= $user['user_name'];
			$row->created		= date("Y-m-d-G-i-s");
		}
		
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
			$upload_dir = FILES_PATH . '/questions';
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
								->from('questions',array("user_avatar"))
								->where($where);
				$result = $db->fetchAll($select);
				foreach ($result as $key => $value) {
					$upload_dir = FILES_PATH . '/questions';
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