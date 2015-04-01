<?php
class Zendvn_Models_ServiceItem extends Zend_Db_Table{
	protected $_name = 'services';
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
						 ->where('p.menu_id IN (' . $this->_ids . ')');
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
							->from($this->_name . " AS p",array('id','name','alias','menu_id','status','order','special','summary','hits','picture'))
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name'))
							->where('p.status = 1')
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
						 ->from($this->_name . ' AS p',array('id','name','alias','picture','menu_id','summary'))
						 ->join('menu as pc','pc.id = p.menu_id',array('alias as alias_name','name as category_name'))
						 ->where('p.status = 1')
						 ->where('p.menu_id IN (' . $ids . ')')
						 ->order(' id DESC')
						 ->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'favorites'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p',array('id','name','alias','menu_id','status','order','special','summary','hits','picture'))
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name'))
							->where('p.status = 1')
							->order(' hits DESC')
							->limit(2);
			if(!empty($ssFilter['keySearch'])){
				$keywords = '%' . $ssFilter['keySearch'] . '%';
				$select->where('p.name LIKE ?',$keywords,STRING);
			}				
			
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'fav-detail'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p',array('id','name','alias','menu_id','status','order','special','summary','hits','picture'))
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name'))
							->where('p.status = 1')
							->where('p.id !=?',$arrParam['id'])
							->order(' id DESC')
							->limit(10);			
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'featured'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . " AS p",array('id','name','alias','menu_id','status','order','special','summary','hits','picture','featured'))
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name'))
							->where('p.status = 1')
							->where('p.featured = 1')
							->order(' id DESC')
							->limit(6);
			if(!empty($ssFilter['keySearch'])){
				$keywords = '%' . $ssFilter['keySearch'] . '%';
				$select->where('p.name LIKE ?',$keywords,STRING);
			}				
			
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