<?php
class Zendvn_Models_ProItem extends Zend_Db_Table{
	protected $_name = 'products';
	protected $_primary = 'id';
	protected $_ids;
	
	public function countItem($arrParam, $options = null){		
		if($options['task'] == 'public-index'){
			$db	= $this->getAdapter();
			$ssFilter = $arrParam['ssFilter'];
			$select = $db->select()
						 ->from($this->_name . ' AS p',array('COUNT(p.id) AS totalItem'))
						 ->where('p.status = 1');
			if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('p.name LIKE ?',$keywords,STRING);
			}
			if(!empty($arrParam['publisher'])){
				$publisher = '%' . $arrParam['publisher'] . '%';
				//				$keywords 		= str_replace("d","đ",$keywords);
				//				$keywords 		= str_replace("D","Đ",$keywords);
				$select->where('p.publisher LIKE ?',$publisher,STRING);
			}
			if($ssFilter['menu_id']>0){
				$select1 = $db->select()
							 ->from('menu', array('id','name','parents'))
							 ->where('status = 1');
				$resultCategory = $db->fetchAll($select1);
				
				$system = new Zendvn_System_Recursive($resultCategory);
				$newArray = $system->buildArray($ssFilter['menu_id']);
				$tmp[] = $ssFilter['menu_id'];
				if(!empty($newArray)){
					foreach ($newArray as $key => $val){
						$tmp[] = $val['id'];
					}	 
				}	
				$ids = implode(',',$tmp);
				$this->_ids = $ids;
				$select->where('p.menu_id IN (' . $ids . ')');
			}
			$type = $arrParam['type'];
			if(!empty($type)){
				if($type == 'special'){
					$select->where('p.special = 1');
				}
				if($type == 'begin'){
					$select->where('p.featured = 1');
				}
			}
			$u_id = $arrParam['u_id'];
			if(!empty($u_id)){
				$select4 = $db->select()
						 ->from('units_iss AS u')
						 ->where('id = ?',$u_id);
				$result4 = $db->fetchRow($select4);
				$name_units	= $result4['name'];
//				$name_units = '%' . $name_units . '%';
				$select->where('p.units = ?',$name_units);
			}
			$result = $db->fetchOne($select);
		}
		
		if($options['task'] == 'public-category'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from($this->_name . ' AS p',array('COUNT(p.id) AS totalItem'))
						 ->where('p.status = 1')
						 ->where('p.menu_id IN (' . $this->_ids . ')');
			if(!empty($arrParam['publisher'])){
				$publisher = '%' . $arrParam['publisher'] . '%';
				//				$keywords 		= str_replace("d","đ",$keywords);
				//				$keywords 		= str_replace("D","Đ",$keywords);
				$select->where('p.publisher LIKE ?',$publisher,STRING);
			}			 
			$result = $db->fetchOne($select);
		}
		return $result;					 
	}
        public function listProduct($arrParam = null){
            $db = Zend_Registry::get('connectDb');
            //$db = Zend_Db::factory($adapter, $config);
            $keywords = '%' . $arrParam['search_keyword'] . '%';
            $select = $db->select()->from($this->_name,array('id','name','picture'))
                                   ->where('status = ?',1)
                                   ->where('name LIKE ?',$keywords,STRING)
                                   ->order('id DESC')
                                   ->limit(15);
            $result = $db->fetchAll($select);
            return $result;
        }
        
//        --------------------Tung--------------------
    public function product($id){
            $db = Zend_Registry::get('connectDb');
            //$db = Zend_Db::factory($adapter, $config);
            
            $select = $db->select()
                         ->from('products','*')
                        ->where('id = ?',$id);
                         
            $result = $db->fetchRow($select);
            return $result;
    }
   
    public function sanphamtuongtu($menuId){
            $db = Zend_Registry::get('connectDb');
            //$db = Zend_Db::factory($adapter, $config);
            
            $select = $db->select()
                         ->from('products','*')
                         ->where('menu_id = ?',$menuId)
                         ->limit(10);
            
            $result = $db->fetchAll($select);
            return $result;
    }
    //xuat du lieu cho category
   public function category($menu_id){
            $db = Zend_Registry::get('connectDb');
            //$db = Zend_Db::factory($adapter, $config);
            
            $select = $db->select()
                         ->from('products','*')
                         ->where('menu_id = ?',$menu_id);
            
            $result = $db->fetchAll($select);
            return $result;
            
    }
    
    public function listItem($arrParam = null, $options = null,$filterPro = null){
		$ssFilter = $arrParam['ssFilter'];
		$paginator = $arrParam['paginator'];
		if($options['task'] == 'view-cart'){
			if(count($arrParam['cart'])>0){
				$i = 1;
				foreach ($arrParam['cart'] as $key => $val){
					if($i  == 1 ){
						$ids .=  $key;
					}else{
						$ids .=  ',' . $key;
					}
					$i ++;
				}				
				$db = Zend_Registry::get('connectDb');
				$select = $db->select()
							 ->from($this->_name . ' AS p')
							 ->join('menu as c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
							 ->where('p.status = 1')
							 ->where('p.id IN (' . $ids . ')');
				$result = $db->fetchAll($select);
			}
		}
		if($options['task'] == 'public-index'){
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
							->where('p.status = 1')
							->order(' id DESC')
							->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);
			if(!empty($ssFilter['keywords'])){
				
				$keywords = '%' . $ssFilter['keywords'] . '%';
//				$keywords 		= str_replace("d","đ",$keywords);
//				$keywords 		= str_replace("D","Đ",$keywords);
				$select->where('p.name LIKE ?',$keywords,STRING);
			}
			if(!empty($arrParam['publisher'])){
				$publisher = '%' . $arrParam['publisher'] . '%';
				//				$keywords 		= str_replace("d","đ",$keywords);
				//				$keywords 		= str_replace("D","Đ",$keywords);
				$select->where('p.publisher LIKE ?',$publisher,STRING);
			}
			if($ssFilter['menu_id']>0){
				$select1 = $db->select()
							 ->from('menu', array('id','name','parents'))
							 ->where('status = 1');
				$resultCategory = $db->fetchAll($select1);
				
				$system = new Zendvn_System_Recursive($resultCategory);
				$newArray = $system->buildArray($ssFilter['menu_id']);
				$tmp[] = $ssFilter['menu_id'];
				if(!empty($newArray)){
					foreach ($newArray as $key => $val){
						$tmp[] = $val['id'];
					}	 
				}	
				$ids = implode(',',$tmp);
				$this->_ids = $ids;
				$select->where('p.menu_id IN (' . $ids . ')');
			}
			
			$type = $arrParam['type'];
			if(!empty($type)){
				if($type == 'special'){
					$select->where('p.special = 1');
				}
				if($type == 'begin'){
					$select->where('p.featured = 1');
				}
			}
			$u_id = $arrParam['u_id'];
			if(!empty($u_id)){
				$select4 = $db->select()
						 ->from('units_iss AS u')
						 ->where('id = ?',$u_id);
				$result4 = $db->fetchRow($select4);
				$name_units	= $result4['name'];
//				$name_units = '%' . $name_units . '%';
				$select->where('p.units = ?',$name_units);
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
						 ->join('menu as c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
						 ->where('p.status = 1')
						 ->where('p.menu_id IN (' . $ids . ')')
						 ->order(' id DESC')
						 ->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);		
			if(!empty($arrParam['publisher'])){
				$publisher = '%' . $arrParam['publisher'] . '%';
				//				$keywords 		= str_replace("d","đ",$keywords);
				//				$keywords 		= str_replace("D","Đ",$keywords);
				$select->where('p.publisher LIKE ?',$publisher,STRING);
			}						 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'public-menu'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from('menu', array('id','name','parents'))
						 ->where('status = 1');
			$resultCategory = $db->fetchAll($select);	
			$system = new Zendvn_System_Recursive($resultCategory);
			$newArray = $system->buildArray($options['cid']);
			$tmp[] = $options['cid'];	
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
						 ->order(' id DESC');		
			if(!empty($options['publisher'])){
				$publisher = '%' . $options['publisher'] . '%';
				//				$keywords 		= str_replace("d","đ",$keywords);
				//				$keywords 		= str_replace("D","Đ",$keywords);
				$select->where('p.publisher LIKE ?',$publisher,STRING);
			}						 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'fav-detail'){
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
						 ->limit(15);								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'public-hit'){
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
						 ->order(' hits DESC')
						 ->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'public-new'){
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
		if($options['task'] == 'public-hot'){
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
						 ->order(' price DESC')
						 ->limitPage($paginator['currentPage'],$paginator['itemCountPerPage']);								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'hit'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from('menu', array('id','name','parents'))
						 ->where('status = 1');
			$resultCategory = $db->fetchAll($select);	
			$system = new Zendvn_System_Recursive($resultCategory);
			$newArray = $system->buildArray($options['cid']);
			$tmp[] = $options['cid'];	
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
						 ->order(' hits DESC')
						 ->limit(8);								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'new'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from('menu', array('id','name','parents'))
						 ->where('status = 1');
			$resultCategory = $db->fetchAll($select);	
			$system = new Zendvn_System_Recursive($resultCategory);
			$newArray = $system->buildArray($options['cid']);
			$tmp[] = $options['cid'];	
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
						 ->limit(8);								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'hot'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from('menu', array('id','name','parents'))
						 ->where('status = 1');
			$resultCategory = $db->fetchAll($select);	
			$system = new Zendvn_System_Recursive($resultCategory);
			$newArray = $system->buildArray($options['cid']);
			$tmp[] = $options['cid'];	
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
						 ->order(' price DESC')
						 ->limit(8);								 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'special'){
			$db	= $this->getAdapter();
			$select = $db->select()
						 ->from('menu', array('id','name','parents'))
						 ->where('status = 1');
			$resultCategory = $db->fetchAll($select);	
			$system = new Zendvn_System_Recursive($resultCategory);
			$newArray = $system->buildArray($options['cid']);
			$tmp[] = $options['cid'];	
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
						 ->where('p.special = 1')
						 ->where('p.menu_id IN (' . $ids . ')')
						 ->order('rand()')
						->limit(8);							 
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'pro-spec'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
				
			$db	= $this->getAdapter();
			$select = $db	->select()
			->from($this->_name . ' AS p')
			->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
			->where('p.status = 1')
			//->where('p.featured = 1')
			->where('p.special = 1')
			->order('rand()')
			->limit(28);
			$result = $db->fetchAll($select);
		}
                if($options['task'] == 'pro-cate'){
                    echo $strWhere;
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
				
			$db	= $this->getAdapter();
			$select = $db	->select()
			->from($this->_name . ' AS p')
			->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
			->where('p.status = 1')
			//->where('p.featured = 1')
			->where('p.menu_id =' . $filterPro)
			->order('rand()')
			->limit(28);
			$result = $db->fetchAll($select);
//                        echo $select;
		}
		if($options['task'] == 'price'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
				
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p', array('name','code'))
							->where('p.status = 1');
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'pro-new'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
		
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
							->where('p.status = 1')
							->order(' id DESC')
							->limit(6);
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'pro-hit'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
		
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
							->where('p.status = 1')
							->order(' hits DESC')
							->limit(6);
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'pro-fav'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
							->where('p.status = 1')
							//->where('p.featured = 1')
							->where('p.special = 0')
							->order(' hits DESC')
							->limit(8);
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'public-search'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p',array('name'))
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
							->where('p.status = 1')
							->order(' name DESC');
			$result = $db->fetchAll($select);
		}
		if($options['task'] == 'pro-left'){
			$ssFilter = $arrParam['ssFilter'];
			$paginator = $arrParam['paginator'];
			
			$db	= $this->getAdapter();
			$select = $db	->select()
							->from($this->_name . ' AS p')
							->joinLeft('menu AS c','c.id = p.menu_id',array('c.alias AS alias_name','c.sale_off AS sale'))
							->where('p.status = 1')
							->where('p.featured = 1')
							->order('rand()')
							->limit(8);
			$result = $db->fetchAll($select);
		}
		
		
		return $result;	
	}
	public function getItem($arrParam, $options = null){		
		if($options['task'] == 'public-detail'){
			$select = $this->select($this->_name . ' AS p')
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