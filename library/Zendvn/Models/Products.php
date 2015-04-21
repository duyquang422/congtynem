<?php
class Zendvn_Models_Products extends Zend_Db_Table{
	protected $_name = 'products';
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
		if(!empty($ssFilter['code'])){
				$code = '%' . $ssFilter['code'] . '%';
				$select->where('p.code LIKE ?',$code,STRING);
			}
		if(!empty($ssFilter['publisher'])){
			$publisher = '%' . $ssFilter['publisher'] . '%';
			$select->where('p.publisher LIKE ?',$publisher,STRING);
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
						 ->joinLeft('menus AS c','c.id = p.menu_id','c.name as category_name')
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
			if(!empty($ssFilter['code'])){
				$code = '%' . $ssFilter['code'] . '%';
				$select->where('p.code LIKE ?',$code,STRING);
			}
			if(!empty($ssFilter['publisher'])){
				$publisher = '%' . $ssFilter['publisher'] . '%';
				$select->where('p.publisher LIKE ?',$publisher,STRING);
			}
			$result  = $db->fetchAll($select);
			
		}
                
                if($options['task'] == 'new-product'){
			$select = $db->select()
						 ->from($this->_name . ' AS p',array('p.id','name','picture','photos','warranty','price','selloff','val_sell','publisher'))
						 ->joinLeft('menus AS c','c.id = p.menu_id','c.name as category_name')
                                                 ->where('p.status = ?',1)
                                                 ->order('p.id DESC')
                                                 ->limit(6);
			$result  = $db->fetchAll($select);
		}
                if($options['task'] == 'highlights-product'){
			$select = $db->select()
						 ->from($this->_name . ' AS p')
						 ->joinLeft('menus AS c','c.id = p.menu_id','c.name as category_name')
                                                 ->order('id DESC')
                                                 ->where('p.status = ?',1)
                                                 ->where('special = ?',1)
                                                 ->limit(6);
			$result  = $db->fetchAll($select);
		}
                if($options['task'] == 'nemcaosu-product'){
                        $select = $db->select()
						 ->from($this->_name . ' AS p')
						 ->joinLeft('menus AS c','c.id = p.menu_id',array('c.name as category_name','c.parent'))
                                                 ->order('id DESC')
                                                 ->where('p.status = ?','1')
                                                 ->where('c.id = ?',103)
                                                 ->orWhere('c.parent = ?',103)
                                                 ->limit(6);
			$result  = $db->fetchAll($select);
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
		$row->warranty	 		= $arrParam['warranty'];
		$row->price 			= $arrParam['price'];
		//$row->selloff 			= $arrParam['selloff'];
		$row->val_sell 			= $arrParam['val_sell'];
		if(!empty($arrParam['val_sell'])){
			$row->selloff 		= $arrParam['price'] - ($arrParam['price'] * $arrParam['val_sell']/100);
		}else{
			$row->selloff 		= '';
		}
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
		//$row->units 			= $arrParam['units'];
		$row->publisher 		= $arrParam['publisher'];
		//$row->weight 			= $arrParam['weight'];
//		$row->pages 			= $arrParam['pages'];
		//$row->author 			= $arrParam['author'];
//		$row->translator 		= $arrParam['translator'];
//		$row->size 				= $arrParam['size'];
		//$row->year 				= $arrParam['year'];
		$row->code 				= $arrParam['code'];
//		$row->board 			= $arrParam['board'];
		if(empty($arrParam['alias'])){
			$row->alias 		= $filter->filter($arrParam['name']);
		}else{
			$row->alias = $arrParam['alias'];
		}
		
		if($arrParam['photos'][0] != ''){
			if (!empty($arrParam['curPhoto'])){
				$photos	=  array_merge($arrParam['curPhoto'],$arrParam['photos']);
				$row->photos = json_encode($photos);
			}else{
				$row->photos = json_encode($arrParam['photos']);
			}
		}
		if($options['task'] == 'delete-photo'){
			$where = 'id = ' . $options['id'];		
			$row =  $this->fetchRow($where);
			$row->photos	= json_encode($options['photos']);
		}
		$row->save();
		
	}
	
	public function getItem($arrParam = null, $options = null){		
		if($options['task'] == 'admin-info' || $options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$result = $this->fetchRow($where)->toArray();
		}
                if($options['task'] == 'installment-info'){
                    $db = Zend_Registry::get('connectDb');
                    $select = $db->select()->from($this->_name,array('id','name','price','selloff','picture','publisher'))->where('id = ?', $arrParam['id']);
                    $result = $db->fetchRow($select);
		}
		if($options['task'] == 'delete-photo'){
			$where = 'id = ' . $arrParam['id'];
			$result = $this->fetchRow($where)->toArray();
		}
		return $result;
	}
	public function deleteItem($arrParam = null, $options = null){
		if($options['task'] == 'delete-photo'){
			$upload_dir = FILES_PATH . '/photos';
			$upload = new Zendvn_File_Upload();
			$upload->removeFile($upload_dir . '/orignal/' . $arrParam['name_photo']);
                        $upload->removeFile($upload_dir . '/images50x50/' . $arrParam['name_photo']);
                        $upload->removeFile($upload_dir . '/images350x350/' . $arrParam['name_photo']);
		}
		if($options['task'] == 'admin-delete'){
			$where = ' id = ' . $arrParam['id'];
			$row = $this->fetchRow($where);
			$upload_dir = FILES_PATH . '/products';
			$upload = new Zendvn_File_Upload();
			$upload->removeFile($upload_dir . '/orignal/' . $row['picture']);
			$upload->removeFile($upload_dir . '/images100x100/' . $row['picture']);
			$upload->removeFile($upload_dir . '/images450x450/' . $row['picture']);
			$this->delete($where);
		}		
		if($options['task'] == 'admin-multi-delete'){
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);			
				$db = $this->getAdapter();
				$where = 'id IN (' . $ids . ')';
				$select = $db->select()
								->from($this->_name . ' AS p',array("picture"))
								->where($where);
				$result = $db->fetchAll($select);
				foreach ($result as $key => $value) {
					$upload_dir = FILES_PATH . '/products';
					$upload = new Zendvn_File_Upload();
					$upload->removeFile($upload_dir . '/orignal/' . $value['picture']);
					$upload->removeFile($upload_dir . '/images100x100/' . $value['picture']);
					$upload->removeFile($upload_dir . '/images450x450/' . $value['picture']);
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