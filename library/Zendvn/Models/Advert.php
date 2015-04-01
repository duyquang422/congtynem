<?php
class Zendvn_Models_Advert extends Zend_Db_Table{
	protected $_name = 'adverts';
	protected $_primary = 'id';
	protected $_ids;
	
public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		
		$ssFilter = $arrParam['ssFilter'];
		
		$select = $db	->select()
						->from('adverts AS a',array('COUNT(a.id) AS totalItem'));
		
		if($ssFilter['position']>0){
				$select->where('a.position = ?',$ssFilter['position'],INTEGER);
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
		
		if($options['task'] == 'admin-list'){
			$select = $db->select()
						 ->from('adverts AS a')
						 ->joinLeft('positions AS p','a.position = p.id',array('resize','price','selloff'))
						 ->order('id DESC');				 							
			$result  = $db->fetchAll($select);			
		}
		if($options['task'] == 'home'){
			$position	= $options['position'];
			$select = $db->select()
						 ->from('adverts AS a')
						 ->joinLeft('positions AS p','a.position = p.id',array('p.name AS position_name','p.resize AS size'))
						 ->order('order ASC')
						 ->where('a.status = 1')
						 ->where('p.name = ?',$position);				 							
			$result  = $db->fetchAll($select);	
		}
		if($options['task'] == 'public-advert'){
			$id = $arrParam[id];
			$select = $db->select()
						 ->from('adverts AS a',array('id','name','special','picture','start','end','summary','order','status','position','content'))
						 ->joinLeft('positions AS p','a.position = p.id',array('resize','price','selloff'))
						 ->where('a.status = 1')
						 ->where('a.id = ?',$id);				 							
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
		$row->name 			= $arrParam['name'];
		$row->type 			= $arrParam['type'];
		if(!empty($arrParam['picture'])):$row->picture	= $arrParam['picture'];endif;
		$row->position 	= $arrParam['position'];
		$row->start 		= $arrParam['start'];
		$row->end 			= $arrParam['end'];
		$row->summary 		= $arrParam['summary'];
		$row->url 			= $arrParam['url'];
		$row->status 		= $arrParam['status'];
		$row->special 		= $arrParam['special'];
		$row->order 		= $arrParam['order'];
		if(empty($arrParam['alias'])){
			$row->alias 	= $filter->filter($arrParam['name']);
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
			$this->delete($where);
		}		
		if($options['task'] == 'admin-multi-delete'){
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);			
				$db = $this->getAdapter();
				$where = 'id IN (' . $ids . ')';
				$select = $db->select()
								->from('adverts AS p',array("picture"))
								->where($where);
				$result = $db->fetchAll($select);
				foreach ($result as $key => $value) {
					$upload_dir = FILES_PATH . '/news';
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
}