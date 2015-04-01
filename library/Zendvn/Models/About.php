<?php
class Zendvn_Models_About extends Zend_Db_Table{
	protected $_name = 'about';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		
		
		$select = $db	->select()
						->from($this->_name . ' AS n',array('COUNT(n.id) AS totalItem'));
		
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
						 ->from($this->_name . ' AS n',array('id','title','picture','content','status','featured'));
			$result  = $db->fetchAll($select);
			
		}
		if($options['task'] == 'admin-index'){
			$select = $db->select()
						 ->from($this->_name . ' AS n')
						 ->where('status = 1')
						 ->order('id DESC');
			$result  = $db->fetchAll($select);
		}
		if($options['task'] == 'public-index'){
			$select = $db->select()
						 ->from($this->_name . ' AS a')
						 ->where('status = 1')
						 ->order('id DESC');
			$result  = $db->fetchAll($select);
		}
		if($options['task'] == 'public-detail'){
			$select = $db->select()
						 ->from($this->_name . ' AS a')
						 ->where('status = 1')
						 ->where('id != ?',$arrParam['id'])
						 ->order('id DESC');
			$result  = $db->fetchAll($select);
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
		$info = new Zendvn_System_Info();
		$memberInfo = $info->getMemberInfo('id');
		
		if($options['task'] == 'admin-add'){
			$row =  $this->fetchNew();
		}
		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];			
			$row =  $this->fetchRow($where);
		}
		$row->title 			= $arrParam['title'];
		$row->title_seo 		= $arrParam['title_seo'];
		$row->description_html 	= $arrParam['description_html'];
		if(!empty($arrParam['picture'])):$row->picture	= $arrParam['picture'];endif;
		$row->content 			= $arrParam['content'];
		$row->summary 			= $arrParam['summary'];
		$row->status 			= $arrParam['status'];
		$row->featured 			= $arrParam['featured'];
		
		if(empty($arrParam['alias'])){
			$row->alias 		= $filter->filter($arrParam['title']);
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
			$upload_dir = FILES_PATH . '/about';
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
								->from($this->_name . ' AS n',array("picture"))
								->where($where);
				$result = $db->fetchAll($select);
				foreach ($result as $key => $value) {
					$upload_dir = FILES_PATH . '/about';
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
	
	
	
	
	
	
	
}