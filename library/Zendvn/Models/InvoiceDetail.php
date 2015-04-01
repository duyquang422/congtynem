<?php
class Zendvn_Models_InvoiceDetail extends Zend_Db_Table{
	protected $_name = 'invoice_detail';
	protected $_primary = 'id';
	
	public function countItem($arrParam = null, $options = null){
		$db = $this->getAdapter();
		
		$ssFilter = $arrParam['ssFilter'];
		
		$select = $db	->select()
						->from($this->_name . ' AS in',array('COUNT(in.id) AS totalItem'))
						->where('hits = 0');
		$result = $db->fetchOne($select);
		return $result;
		
	}
	
	public function listItem($arrParam = null, $options = null){
		$db 	= $this	-> getAdapter();
		if($options['task'] == 'admin-list'){
			$select = $db 	-> select()
							-> from($this->_name . ' AS ind')
							-> joinLeft('invoice AS in','in.id = ind.invoice_id',
										array('in.email AS email','in.phone AS phone','in.address AS address',
											  'in.full_name AS full_name','in.created AS created','in.comment AS comment'
											  ))
							-> joinLeft('price_pro AS pr','pr.id = ind.product_id',array(
																						'pr.code_pro AS code_price',
																						'pr.size AS size',
																						'pr.price AS pro_pri',
																						'pr.selloff AS selloff_pri',
																						'pr.val_sell AS val_sell_pri',
																						))
							-> joinLeft('products AS p','p.code = pr.code_pro',array(
																					'p.name as name_pro',
																					'p.val_sell as val_sell_pro',
																					'p.menu_id as menu_id_pro',
																					))
							-> joinLeft('menu AS m','m.id = p.menu_id',array('m.sale_off as sale_off_menu'))
							-> order('id DESC');
			$result = $db -> fetchAll($select);
		}
		if($options['task'] == 'admin-info'){
			$select = $db 	-> select()
							-> from($this->_name . ' AS ind')
							-> joinLeft('invoice AS in','in.id = ind.invoice_id',
										array('in.email AS email','in.phone AS phone','in.address AS address',
											  'in.full_name AS full_name','in.created AS created',
											  'in.comment AS comment','in.shipping AS shipping'
											  ))
							-> joinLeft('price_pro AS pr','pr.id = ind.product_id',array(
																						'pr.code_pro AS code_price',
																						'pr.size AS size',
																						'pr.price AS pro_pri',
																						'pr.selloff AS selloff_pri',
																						'pr.val_sell AS val_sell_pri',
																						))
							-> joinLeft('products AS p','p.code = pr.code_pro',array(
																					'p.name as name_pro',
																					'p.val_sell as val_sell_pro',
																					'p.menu_id as menu_id_pro',
																					))
							-> joinLeft('menu AS m','m.id = p.menu_id',array('m.sale_off as sale_off_menu'))
							->where('ind.id = ?',$arrParam['id']);
			$result = $db -> fetchRow($select);
			
		}
		return $result;
	}
	public function saveItem($arrParam = null, $options = null){		
		if($options == null){
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
				$db = $this->getAdapter();
				$select = $db->select()
							 ->from('price_pro as p')							
							 ->where('p.id IN (' . $ids . ')');
				$result = $db->fetchAll($select);
				$tmp = array();				
				$cart = $arrParam['cart'];			
				foreach ($result as $key => $val){					
					$val['quantity'] = $cart[$val['id']];
					$tmp[] = $val;
				}				
			}
	
			foreach ($tmp as $key_1 => $info){
				$row =  $this->fetchNew();
				$row->product_id 	= $info['id'];
				$row->quantity 		= $info['quantity'];
				$row->price 		= $info['price'];
				$row->invoice_id	= $arrParam['invoice_id'];
				$row->save();
			}
			
		}
		if($options['task'] == 'admin-info'){
			$Item = $arrParam['Item'];
			$where = 'id = ' . $arrParam['id'];
			$row =  $this->fetchRow($where);
			$row->hits 		= $Item['hits'] + 1;
			$row->save();
		}
	}
	public function deleteItem($arrParam = null, $options = null){
		if($options['task'] == 'admin-delete'){
			$where = ' id = ' . $arrParam['id'];
			$row = $this->fetchRow($where);
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
	public function getItem($arrParam = null, $options = null){		
		if($options['task'] == 'admin-info' || $options['task'] == 'admin-edit'){
			$where = 'id = ' . $arrParam['id'];
			$result = $this->fetchRow($where)->toArray();
		}
		return $result;
	}
}