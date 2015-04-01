<?php
class Zendvn_Models_Collections extends Zend_Db_Table{
	protected $_name = 'collections';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		
		$ssFilter = $arrParam['ssFilter'];
		
		$select = $db	->select()
						->from($this->_name . ' AS p',array('COUNT(p.id) AS totalItem'));
		
		if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('p.name LIKE ?',$keywords,STRING);
		}
		if($ssFilter['menu_id']>0){
				$select->where('p.menu_id = ?',$ssFilter['menu_id'],INTEGER);
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
						 ->from($this->_name . ' AS p')
						 ->joinLeft('menu AS c','c.id = p.menu_id','c.alias as category_alias')
						 ->joinLeft('users AS u','u.id = p.created_by','u.user_name as user_name');
							
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
				$select->where('p.name LIKE ?',$keywords,STRING);
			}
			if($ssFilter['category_id']>0){
				$select1 = $db->select()
							 ->from('menu', array('id','name','parents'))
							 ->where('status = 1');
				$resultCategory = $db->fetchAll($select1);
				
				$system = new Zendvn_System_Recursive($resultCategory);
				$newArray = $system->buildArray($ssFilter['category_id']);
				$tmp[] = $ssFilter['category_id'];
				if(!empty($newArray)){
					foreach ($newArray as $key => $val){
						$tmp[] = $val['id'];
					}	 
				}	
				$ids = implode(',',$tmp);
				$this->_ids = $ids;
				$select->where('p.menu_id IN (' . $ids . ')');
			}
			$result  = $db->fetchAll($select);
			
		}
		if($options['task'] == 'public-index'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from($this->_name . ' AS p')
						 ->join('menu as c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
						 ->where('p.status = 1')
						 ->order(' id DESC');								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'public-category'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from('menu', array('id','name','parents'))
						 ->where('status = 1');
			$resultCategory = $db->fetchAll($select);	
			$system = new Zendvn_System_Recursive($resultCategory);
			$newArray = $system->buildArray($arrParam['cid']);
			$tmp[] = $arrParam['cid'];	
			if(!empty($newArray)){
				foreach ($newArray as $key => $val){
					$tmp[] = $val['id'];
				}	 
			}	
			$ids = implode(',',$tmp);
			$this->_ids = $ids;
			$paginator  = $arrParam['paginator'];
			$select = $db->select()
						 ->from($this->_name . ' AS p')
						 ->join('menu as c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
						 ->where('p.status = 1')
						 ->where('p.menu_id IN (' . $ids . ')')
						 ->order(' id DESC')
						 ->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'fav-detail'){
			
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name'))
							->where('p.status = 1')
							->where('p.id !=?',$arrParam['id'])
							->where('p.menu_id = ?',$arrParam['cid'])
							->order(' hits DESC')
							->limit(10);
			$result = $db->fetchAll($select);
		}
		
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null){
		$filter = new Zend_Filter();
		$multiFilter = $filter	->addFilter(new Zend_Filter_StringToLower(array('encoding'=>'UTF-8')))
									->addFilter(new Zend_Filter_StringTrim())
						 			->addFilter(new Zend_Filter_Alnum(true))
						  			//->addFilter(new Zend_Filter_PregReplace(array('match'=>'#\s+#','replace'=>'-')))
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
			//$row->picture 		= $arrParam['picture'];
			$row->modified		= date("Y-m-d-G-i-s");
			$row->modified_by 	= $memberInfo;			
			
		}
		
		$row->name 				= $arrParam['name'];
		$row->alt_seo 			= $arrParam['alt_seo'];
		$row->title_seo 		= $arrParam['title_seo'];
		$row->summary 			= $arrParam['summary'];
		$row->description_html 	= $arrParam['description_html'];
		$row->keywords_html 	= $arrParam['keywords_html'];
        if(!empty($arrParam['picture'])):$row->picture	= $arrParam['picture'];endif;
		$row->menu_id 			= $arrParam['menu_id'];
		$row->content 			= $arrParam['content'];
		$row->info 				= $arrParam['info'];
		$row->status 			= $arrParam['status'];
		$row->special 			= $arrParam['special'];
		$row->featured 			= $arrParam['featured'];
		$row->author 			= $arrParam['author'];
		$row->code 				= $arrParam['code'];
		if($arrParam['photos'][0] != ''){
			if (!empty($arrParam['curPhoto'])){
				$photos	=  array_merge($arrParam['curPhoto'],$arrParam['photos']);
				$row->photos = json_encode($photos);
			}else{
				$row->photos = json_encode($arrParam['photos']);
			}
		}
		if(empty($arrParam['alias'])){
			$row->alias 		= $filter->filter($arrParam['name']);
		}else{
			$row->alias = $arrParam['alias'];
		}
		if($options['task'] == 'delete-photo'){
			$where = 'id = ' . $options['id'];		
			$row =  $this->fetchRow($where);
			$row->photos	= json_encode($options['photos']);
		}
		if($options['task'] == 'public-detail'){
			$Item = $arrParam['Item'];
			$where = 'id = ' . $arrParam['id'];
			$row =  $this->fetchRow($where);
			$row->hits 		= $Item['hits'] + 1;
		}
		$row->save();
		
	}
	
	public function getItem($arrParam = null, $options = null){		
		if($options['task'] == 'admin-info' || $options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$result = $this->fetchRow($where)->toArray();
		}
		if($options['task'] == 'delete-photo'){
			$where = 'id = ' . $arrParam['id'];
			$result = $this->fetchRow($where)->toArray();
		}
		if($options['task'] == 'public-detail'){
			$select = $this->select($this->_name . ' AS p')
						   	->where('id = ?',$arrParam['id'],INTEGER);
			$result = $this->fetchRow($select)->toArray();
		}
		return $result;
	}
	public function deleteItem($arrParam = null, $options = null){
		if($options['task'] == 'delete-photo'){
			$upload_dir = FILES_PATH . '/photos';
			$upload = new Zendvn_File_Upload();
			$upload->removeFile($upload_dir . '/' . $arrParam['name_photo']);
		}
		if($options['task'] == 'admin-delete'){
			$where = ' id = ' . $arrParam['id'];
			$row = $this->fetchRow($where);
			$upload_dir = FILES_PATH . '/products';
			$upload = new Zendvn_File_Upload();
			$upload->removeFile($upload_dir . '/orignal/' . $row['picture']);
			$upload->removeFile($upload_dir . '/images100x100/' . $row['picture']);
			$upload->removeFile($upload_dir . '/images450x450/' . $row['picture']);
			$photos	= json_decode($row['photos']);
			if(!empty($photos)){
				foreach ($photos as $key => $value) {
					$upload_dir = FILES_PATH . '/photos/';
					$upload = new Zendvn_File_Upload();
					$upload->removeFile($upload_dir . $value);
				}
			}
			$this->delete($where);
		}
		if($options['task'] == 'admin-multi-delete'){
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);			
				$db = $this->getAdapter();
				$where = 'id IN (' . $ids . ')';
				$select = $db->select()
								->from($this->_name . ' AS p',array('picture','photos'))
								->where($where);
				$result = $db->fetchAll($select);
				foreach ($result as $key => $value) {
					$upload_dir = FILES_PATH . '/products';
					$upload = new Zendvn_File_Upload();
					$upload->removeFile($upload_dir . '/orignal/' . $value['picture']);
					$upload->removeFile($upload_dir . '/images100x100/' . $value['picture']);
					$upload->removeFile($upload_dir . '/images450x450/' . $value['picture']);
					$photos	= json_decode($value['photos']);
					if(!empty($photos)){
						foreach ($photos as $key => $val) {
							$upload_dir = FILES_PATH . '/photos/';
							$upload = new Zendvn_File_Upload();
							$upload->removeFile($upload_dir . $val);
						}
					}
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
	
	public function changeFavorites($arrParam = null, $options = null){
		if($arrParam['id']>0){
			if($arrParam['type'] == 1){
				$featured 	= 1;
			}else{
				$featured 	= 0;
			}			
			$data = array('favorites'=>$featured);
			$where = 'id = ' . $arrParam['id'];
			$this->update($data,$where);
		}		
	}
	
	
	
	
	
}