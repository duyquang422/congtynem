<?php
class Zendvn_Models_PhotoItem extends Zend_Db_Table{
	protected $_name = 'photo_item';
	protected $_primary = 'id';
	protected $_ids;
	
	public function countItem($arrParam, $options = null){		
		if($options['task'] == 'public-index'){
			$db	= $this->getAdapter();
			$ssFilter = $arrParam['ssFilter'];
			$select = $db->select()
						 ->from($this->_name . ' AS p',array('COUNT(p.id) AS totalItem'))
						 ->where('p.status = 1');
			if(!empty($ssFilter['keySearch'])){
				$keywords = '%' . $ssFilter['keySearch'] . '%';
				$select->where('p.name LIKE ?',$keywords,STRING);
			}
			$result = $db->fetchOne($select);
		}
		
		if($options['task'] == 'public-category'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from($this->_name . ' AS p',array('COUNT(p.id) AS totalItem'))
						 ->where('p.status = 1')
						 ->where('p.cat_id IN (' . $this->_ids . ')');
			$result = $db->fetchOne($select);
		}
		return $result;					 
	}
	
	public function listItem($arrParam = null, $options = null){
		
		if($options['task']=='admin-list')
		{
			$select	= $this->select();
			$result	= $this->fetchAll($select)->toArray();
		}

		if($options['task'] == 'public-index'){
			$select	= $this	-> select()
						 	-> where('status=1')
						 	-> order('id desc');			
			$result = $this->fetchAll($select)->toArray();		
		}		
		return $result;	
	}
	public function getItem($arrParam, $options = null){
		if($options['task']=='admin-edit')
		{
			$select = $this->select()
						   ->where('id = ?',$arrParam['id'],INTEGER);
			$result = $this->fetchRow($select)->toArray();
		}	
		
		if($options['task']=='public-detail')
		{
			$select=$this->select()
						 ->where('alias=?',$arrParam['alias']);
			$result=$this->fetchRow($select)->toArray();		 
		}
		
		return $result;
	}
	
	public function deleteItem($arrParam = null, $options = null)
	{
		if($options['task'] == 'admin-multi-delete')
		{
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);			
				$db = $this->getAdapter();
				$where = 'id IN (' . $ids . ')';
				$select = $db->select()
								->from($this->_name . ' AS n')
								->where($where);
				$result = $db->fetchAll($select);
				
				
				$picIem=new Zendvn_Models_Pictures();
				foreach ($result as $key => $value)
				{
					$p_id=$value['id'];
					$picIem->deleteItem(array('id'=>$p_id),array('task'=>'photo-delete'));
				}
				
				$this->delete($where);
			}
		}
		
		
		if($options['task'] == 'admin-delete')
		{
			//Xoa bang Pictures
			$picIem=new Zendvn_Models_Pictures();
			$picIem->deleteItem($arrParam,array('task'=>'photo-delete'));
			
			$where = ' id = ' . $arrParam['id'];
			$this->delete($where);
		}
	}		
	
	public function saveItem($arrParam = null, $options = null){
		
		$info = new Zendvn_System_Info();
		$memberInfo = $info->getMemberInfo('id');
		if($options['task'] 	== 'admin-add'){
			$row 				= $this->fetchNew();
		}		
		
		if($options['task'] == 'admin-edit')
		{
			$where 	= 'id = ' . $arrParam['id'];			
			$row 	=  $this->fetchRow($where);
		}
		
		$filter = new Zend_Filter();
		$multiFilter = $filter	->addFilter(new Zend_Filter_StringToLower(array('encoding'=>'UTF-8')))
								->addFilter(new Zend_Filter_StringTrim())
						 		->addFilter(new Zend_Filter_Alnum(true))
//						  		->addFilter(new Zend_Filter_PregReplace(array('match'=>'#\s+#','replace'=>'-')))
						  		->addFilter(new Zend_Filter_Word_SeparatorToDash())
						  		->addFilter(new Zendvn_Filter_RemoveCircumflex());		

		
		$row->alias				= $multiFilter->filter($arrParam['name']);
		$row->name				= $arrParam['name'];
		$row->summary 			= $arrParam['summary'];
		$row->description_html 	= $arrParam['description_html'];
		$row->keywords_html 	= $arrParam['keywords_html'];
		$row->status 			= $arrParam['status'];
		$p_id= $row->save();
		
		
		$picO=new Zendvn_Models_Pictures();
		//Xoa cac anh truoc khi update
		if($options['task']=='admin-edit')
		{
			$picO->deleteItem(array('p_id'=>$p_id),array('task'=>'update-delete'));
		}
		
		$pictures=$arrParam['picture'];
		foreach ($pictures as $pic)
		{
			$picO->saveItem(array('p_id'=>$p_id,'img'=>$pic),array('task'=>'admin-add'));
		}	
	}
	
	
	public function sortItem($arrParam = null, $options = null)
	{
		$items = $arrParam[$options['column']];
		if(count($items)>0){
			foreach ($items as $key => $val) {
				$where = 'id = ' . $key;				
				$data = array($options['column']=>$val);
				$this->update($data,$where);
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