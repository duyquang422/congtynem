<?php
class Zendvn_Models_PricePro extends Zend_Db_Table{
	protected $_name = 'price_pro';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();		
		$ssFilter = $arrParam['ssFilter'];		
		$select = $db	->select()
						->from($this->_name . ' AS s',array('COUNT(s.id) AS totalItem'));	
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
		$ssFilter = $arrParam['ssFilter'];
		$db = $this->getAdapter();		
		if($options['task'] == 'admin-list'){
			$select = $db->select()
						 ->from($this->_name . ' AS p')
						 ->joinLeft('size AS s','p.size = s.name','s.units as unit_name');
			$order = 'id DESC';
			if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){
				$order = $ssFilter['col'] . ' ' . $ssFilter['order'];
			}
			$select->order($order);
			if(!empty($ssFilter['keywords'])){
				$keywords = '%' . $ssFilter['keywords'] . '%';
				$select->where('p.code_pro LIKE ?',$keywords,STRING);
			}					
			$result  = $db->fetchAll($select);		
		}
		if($options['task'] == 'public'){
			$select = $db->select()
						 ->from($this->_name . ' AS p')
						 ->order('id DESC')
                         ->where('status = 1');						
			$result  = $db->fetchAll($select);		
		}
		if($options['task'] == 'detail'){
			$select = $db	->select()
						 	->from($this->_name . ' AS p')
                         	->where('p.status = 1')
                        	->where('code_pro = ?',$options['code_detail'])
                        	->joinLeft('size AS s','p.size = s.name','s.units as unit_name');						
			$result  = $db->fetchAll($select);		
		}
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
				$select = $db	-> select()
							 	-> from($this->_name . ' AS p')
							 	-> join('products as pr','p.code_pro = pr.code',array('pr.val_sell AS sell_pro','pr.name AS name_pro','pr.menu_id AS menu_id'))
							 	-> where('p.status = 1')
							 	-> where('p.id IN (' . $ids . ')');
				$result = $db	-> fetchAll($select);
			}	
		}
		return $result;
	
	}
	
	public function saveItem($arrParam = null, $options = null){
			$info = new Zendvn_System_Info();
			$memberInfo = $info->getMemberInfo('id');
		
		if($options['task'] == 'admin-add'){
			$row =  $this->fetchNew();
		}
		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];			
			$row =  $this->fetchRow($where);
		}
		$row->code_pro 		= $arrParam['code_pro'];
		$row->size 			= $arrParam['size'];
		$row->price 		= $arrParam['price'];
		$row->val_sell 		= $arrParam['val_sell'];
		if(!empty($arrParam['val_sell'])){
			$row->selloff 		= $arrParam['price'] - ($arrParam['price'] * $arrParam['val_sell']/100);
		}else{
			$row->selloff = '';
		}
		$row->summary 		= $arrParam['summary'];
		$row->status 		= $arrParam['status'];

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
			$this->delete($where);
		}		
		if($options['task'] == 'admin-multi-delete'){
			$cid = $arrParam['cid'];
			if(count($cid)>0){				
				$ids = implode(',',$cid);			
				$db = $this->getAdapter();
				$where = 'id IN (' . $ids . ')';
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