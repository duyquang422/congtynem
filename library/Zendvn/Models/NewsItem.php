<?php
class Zendvn_Models_NewsItem extends Zend_Db_Table{
	protected $_name = 'news_item';
	protected $_primary = 'id';
	protected $_ids;
	
	public function countItem($arrParam, $options = null){		
		if($options['task'] == 'public-index'){
			$db	= $this->getAdapter();
			$ssFilter = $arrParam['ssFilter'];
			$keywords = $arrParam['keywords'];
			$select = $db->select()
						 ->from($this->_name . ' AS p',array('COUNT(p.id) AS totalItem'))
						 ->where('p.status = 1');
						 
			if(!empty($keywords)){
				$keywords = '%' . $keywords . '%';
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
			$keywords = $arrParam['keywords'];
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias as alias_name','name as category_name'))
							->where('p.status = 1')
							->order(' id DESC')
							->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);

			if(!empty($keywords)){
				$keywords = '%' . $keywords . '%';
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
						 ->from($this->_name . ' AS p')
						 ->join('menu as c','c.id = p.menu_id',array('c.alias as alias_name','name as category_name'))
						 ->where('p.status = 1')
						 ->where('p.menu_id IN (' . $ids . ')')
						 ->order(' id DESC')
						 ->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);								 
			$result = $db->fetchAll($select);
		}
		
		if($options['task'] == 'featured'){			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p',array('id','name','alias','menu_id','special','picture','summary','type'))
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name'))
							->where('p.status = 1')
							->where('p.featured = 1')
							->where('p.special = 0')
							->where('p.type != 2')
							->order(' id DESC')
							->limit(6);
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'video'){			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p',array('id','name','special','featured','status','show','youtube','video','type'))
							->where('p.status = 0')
							->where('p.type != 2')
							->order(' id DESC');
			$result = $db->fetchRow($select);
		}
		if($options['task'] == 'new'){			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p',array('id','name','alias','menu_id','special','picture','summary','type'))
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name'))
							->where('p.status = 1')
							->where('p.featured = 0')
							->where('p.type != 2')
							->order(' id DESC')
							->limit(6);
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'footer'){			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p',array('id','name','alias','summary','menu_id','special','picture','type'))
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name'))
							->where('p.status  = 1')
							->where('p.featured = 0')
							->where('p.type != 2')
							->order(' id DESC')
							->limit(4);
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'news'){			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name'))
							->where('p.status = 1')
							->order(' id DESC')
							->limit(3);
			$result = $db->fetchAll($select);
		}
        if($options['task'] == 'public-detail'){
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name','c.name as category_name'))
							->where('p.status = 1')
							->where('p.menu_id = ?',$arrParam['nid'])
							->where('p.id != ?',$arrParam['id'])
                            ->order(' id DESC')
							->limit(10);
			$result = $db->fetchAll($select);
		}
		
		if($options['task'] == 'public-news'){			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p',array('id','name','summary','menu_id','picture'))
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.name AS category_name'))
							//->where('p.status = 1')
							->where("menu_id = 1")
							->order(' id DESC')
							->limit(6);
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