<?php
class Zendvn_Models_Members extends Zend_Db_Table{
	protected $_name = 'members';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		
		$ssFilter = $arrParam['ssFilter'];
		
		$select = $db	->select()
						->from($this->_name . ' AS n',array('COUNT(n.id) AS totalItem'));
		
		if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('n.name LIKE ?',$keywords,STRING);
		}
		if($ssFilter['cat_id']>0){
				$select->where('n.cat_id = ?',$ssFilter['cat_id'],INTEGER);
			}		
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
		$db = $this->getAdapter();
		
		$paginator = $arrParam['paginator'];
		$ssFilter = $arrParam['ssFilter'];
		
		if($options['task'] == 'admin-list'){
			$select = $db->select()
						 ->from($this->_name . ' AS n')
						 ->joinLeft('members_category AS c','c.id = n.cat_id','c.name as category_name')
						 ->joinLeft('users AS u','u.id = n.created_by','u.user_name as user_name');
						 							
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
				$select->where('n.name LIKE ?',$keywords,STRING);
			}
			if($ssFilter['category_id']>0){
				$select->where('n.cat_id = ?',$ssFilter['category_id'],INTEGER);
			}

			$result  = $db->fetchAll($select);
			
		}
		
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null){
			$filter = new Zend_Filter();
			$multiFilter = $filter	->addFilter(new Zend_Filter_StringToLower(array('encoding'=>'UTF-8')))
									->addFilter(new Zend_Filter_StringTrim())
						 			->addFilter(new Zend_Filter_Alnum(true))
//						  			->addFilter(new Zend_Filter_PregReplace(array('match'=>'#\s+#','replace'=>'-')))
						  			->addFilter(new Zend_Filter_Word_SeparatorToDash())
						  			->addFilter(new Zendvn_Filter_RemoveCircumflex());
			
			$info = new Zendvn_System_Info();
			$memberInfo = $info->getMemberInfo('id');
		
		if($options['task'] == 'admin-add'){
			$row =  $this->fetchNew();
			//$row->picture 		= $arrParam['picture'];
			$row->created		= date("Y-m-d-G-i-s");
			$row->created_by 	= $memberInfo;
		}
		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];			
			$row =  $this->fetchRow($where);
		}
		$row->name 				= $arrParam['name'];
		if(!empty($arrParam['picture'])):$row->picture	= $arrParam['picture'];endif;
		if(!empty($arrParam['avatar'])):$row->avatar	= $arrParam['avatar'];endif;
		$row->cat_id 			= $arrParam['cat_id'];
		$row->repres 			= $arrParam['repres'];
		$row->position 			= $arrParam['position'];
		$row->position2 		= $arrParam['position2'];
		$row->phone 			= $arrParam['phone'];
		$row->address 			= $arrParam['address'];
		$row->website 			= $arrParam['website'];
		$row->description_html 	= $arrParam['description_html'];
		$row->keywords_html 	= $arrParam['keywords_html'];
		$row->content 			= $arrParam['content'];
		$row->status 			= $arrParam['status'];
		$row->special 			= $arrParam['special'];
		$row->featured 			= $arrParam['featured'];
		$row->type 				= $arrParam['type'];
		if(empty($arrParam['alias'])){
			$row->alias 		= $filter->filter($arrParam['name']);
		}else{
			$row->alias = $arrParam['alias'];
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
			$upload_dir = FILES_PATH . '/news';
			$upload = new Zendvn_File_Upload();
			$upload->removeFile($upload_dir . '/orignal/' . $row['picture']);
			$upload->removeFile($upload_dir . '/images100x100/' . $row['picture']);
			$upload->removeFile($upload_dir . '/images450x450/' . $row['picture']);
			$upload->removeFile($upload_dir . '/orignal/' . $row['avatar']);
			$upload->removeFile($upload_dir . '/images100x100/' . $row['avatar']);
			$upload->removeFile($upload_dir . '/images450x450/' . $row['avatar']);
			$this->delete($where);
		}		
		if($options['task'] == 'admin-multi-delete'){
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);			
				$db = $this->getAdapter();
				$where = 'id IN (' . $ids . ')';
				$select = $db->select()
								->from($this->_name . ' AS n',array('picture','avatar'))
								->where($where);
				$result = $db->fetchAll($select);
				foreach ($result as $key => $value) {
					$upload_dir = FILES_PATH . '/news';
					$upload = new Zendvn_File_Upload();
					$upload->removeFile($upload_dir . '/orignal/' . $value['picture']);
					$upload->removeFile($upload_dir . '/images100x100/' . $value['picture']);
					$upload->removeFile($upload_dir . '/images450x450/' . $value['picture']);
					$upload->removeFile($upload_dir . '/orignal/' . $row['avatar']);
					$upload->removeFile($upload_dir . '/images100x100/' . $row['avatar']);
					$upload->removeFile($upload_dir . '/images450x450/' . $row['avatar']);
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
	
	public function changeFeatured($arrParam = null, $options = null){
		if($arrParam['id']>0){
			if($arrParam['type'] == 1){
				$featured 	= 1;
			}else{
				$featured 	= 0;
			}			
			$data = array('featured'=>$featured);
			$where = 'id = ' . $arrParam['id'];
			$this->update($data,$where);
		}		
	}
	
	
}