<?php
class Zendvn_Models_MembersItem extends Zend_Db_Table{
	protected $_name = 'members';
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
		
		if($options['task'] == 'public-index'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->where('p.status = 1')
							->where('p.featured = 0')
							->where('p.special = 0')
							->order(' id DESC')
							->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);
			if(!empty($ssFilter['keySearch'])){
				$keywords = '%' . $ssFilter['keySearch'] . '%';
				$select->where('p.name LIKE ?',$keywords,STRING);
			}
			
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'public-category'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from('members_category', array('id','name','parents'))
						 ->where('status = 1')
						 ->order(' order ASC');
			$resultCategory = $db->fetchAll($select);	
			$system = new Zendvn_System_Recursive($resultCategory);
			$newArray = $system->buildArray($arrParam['tid']);
			
			$tmp[] = $arrParam['tid'];	
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
						 ->join('members_category as c','c.id = p.cat_id',array('c.alias as alias_name','name as category_name'))
						 ->where('p.status = 1')
						 ->where('p.special = 0')
						 ->where('p.cat_id IN (' . $ids . ')')
						 ->order(' id DESC')
						 ->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'group'){			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->join('members_category as c','c.id = p.cat_id',array('c.alias as alias_name','name as category_name'))
							->where('p.status = 1')
							->where('p.type = 1')
							->order(' id DESC')
							->limit(5);
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'featured-index'){			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->join('members_category as c','c.id = p.cat_id',array('c.alias as alias_name','name as category_name'))
							->where('p.status = 1')
							->where('p.type = 0')
							->order(' id DESC')
							->limit(10);
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'special'){		
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->join('members_category as c','c.id = p.cat_id',array('c.alias as alias_name','name as category_name'))
							->where('p.status  = 1')
							->where('p.type = 0')
							->where('p.special = 1')
							->order(' order ASC');
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'new'){			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->join('members_category as c','c.id = p.cat_id',array('c.alias as alias_name','name as category_name'))
							->where('p.status = 1')
							->where('p.type = 2')
							->order(' id DESC')
							->limit(5);
			$result = $db->fetchAll($select);
		}
        if($options['task'] == 'public-detail'){
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('members_category AS c','c.id = p.cat_id',array('c.alias AS alias_name'))
							->where('p.status = 1')
							->where('p.cat_id = ?',$arrParam['nid'])
							->where('p.id != ?',$arrParam['id'])
                            ->order(' id DESC')
							->limit(10);
			$result = $db->fetchAll($select);
		}
		
		return $result;	
	}
	public function getItem($arrParam, $options = null){		
		if($options['task'] == 'public-detail'){
			$select = $this->select()
						   ->where('id = ?',$arrParam['id'],INTEGER);
			$result = $this->fetchRow($select)->toArray();
		}		
		return $result;
	}
	public function saveItem($arrParam = null, $options = null){
		$Item = $arrParam['Item'];
		$where = 'id = ' . $arrParam['id'];
		$row =  $this->fetchRow($where);
		$row->hits 		= $Item['hits'] + 1;
		$row->save();
	
	}
}