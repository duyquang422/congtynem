<?php

class Zendvn_Models_InvoiceDetail extends Zend_Db_Table {

    protected $_name = 'invoice_detail';
    protected $_primary = 'id';

    public function countItem($arrParam = null, $options = null) {
        $db = $this->getAdapter();

        $ssFilter = $arrParam['ssFilter'];

        $select = $db->select()
                ->from($this->_name . ' AS in', array('COUNT(in.id) AS totalItem'))
                ->where('hits = 0');
        $result = $db->fetchOne($select);
        return $result;
    }

    public function listItem($arrParam = null, $options = null) {
        $db = $this->getAdapter();
        if ($options['task'] == 'admin-list') {
            $select = $db->select()
                    ->from($this->_name . ' AS ind')
                    ->joinLeft('invoice AS in', 'ind.invoice_id = in.id', array('in.email AS email', 'in.phone AS phone', 'in.address AS address',
                        'in.full_name AS full_name', 'in.created AS created', 'in.comment AS comment'
                    ))
                    ->joinLeft('products AS p', 'ind.product_id = p.id', array('p.name as name', 'p.selloff as selloff'))
                    ->order('ind.id DESC');
            $result = $db->fetchAll($select);
            foreach($result as $val){
                if($val['name']==null)
                    $tmp[] = $val['product_id'];
            }
            if(count($tmp)>0){
                foreach ($tmp as $id){
                    $select = $db->select()->from('price_pro as pp','pp.id')
                                           ->joinLeft('products as p', 'pp.code_pro = p.code',array('p.name as name'))
                                           ->where('pp.id = ?', $id);
                    $temp[] = $db->fetchRow($select);
                }
                foreach ($result as $key => $value){
                    foreach ($temp as $val){
                        if($val['id'] == $value['product_id'])
                            $result[$key]['name'] = $val['name']; 
                    }
                }
            }
        }
        if ($options['task'] == 'admin-info') {
            $select = $db->select()
                    ->from($this->_name . ' AS ind')
                    ->joinLeft('invoice AS in', 'in.id = ind.invoice_id', array('in.email AS email', 'in.phone AS phone', 'in.address AS address',
                        'in.full_name AS full_name', 'in.created AS created',
                        'in.comment AS comment', 'in.shipping AS shipping'
                    ))
                    ->joinLeft('price_pro AS pr', 'pr.id = ind.product_id', array(
                        'pr.code_pro AS code_price',
                        'pr.size AS size',
                        'pr.price AS pro_pri',
                        'pr.selloff AS selloff_pri',
                        'pr.val_sell AS val_sell_pri',
                    ))
                    ->joinLeft('products AS p', 'p.code = pr.code_pro', array(
                        'p.name as name_pro',
                        'p.val_sell as val_sell_pro',
                        'p.menu_id as menu_id_pro',
                    ))
                    ->joinLeft('menu AS m', 'm.id = p.menu_id', array('m.sale_off as sale_off_menu'))
                    ->where('ind.id = ?', $arrParam['id']);
            $result = $db->fetchRow($select);
        }
        return $result;
    }

    public function saveItem($arrParam = null, $options = null) {
        $db = $this->getAdapter();
        if ($options == null) {
            if (isset($arrParam['id'])) {
                $id = $arrParam['id'];
                echo $id;
                $select = $db->select()
                        ->from('products', array('id', 'price', 'size', 'selloff'))
                        ->where('id = ' . $id);
                $result = $db->fetchRow($select);
                if($result == null){
                    $select = $db->select()
                        ->from('price_pro', array('id', 'price', 'size', 'selloff'))
                        ->where('id = ' . $id);
                    $result = $db->fetchRow($select);
                }
                $row = $this->fetchNew();
                $row->product_id = $result['id'];
                $row->quantity = 1;
                $row->price = $result['price'];
                if ($result['size'] != null)
                    $row->size = $result['size'];
                else
                    $row->size = 'mặc định';
                if(isset($arrParam['tratruoc']))
                    $row->tratruoc = $arrParam['tratruoc'];
                if(isset($arrParam['kyhantragop']))
                    $row->kyhantragop = $arrParam['kyhantragop'];
                if(isset($arrParam['laisuat']))
                    $row->laisuat = $arrParam['laisuat'];
                $row->invoice_id = $arrParam['invoice_id'];
                $row->save();
            }
            else {
                if (count($arrParam['cart']) > 0) {
                    $i = 1;
                    foreach ($arrParam['cart'] as $key => $val) {
                        if ($i == 1) {
                            $ids .= $key;
                        } else {
                            $ids .= ',' . $key;
                        }
                        $i++;
                    }
                    $select = $db->select()
                            ->from('products', array('id', 'price', 'size', 'selloff'))
                            ->where('id IN (' . $ids . ')');
                    $result = $db->fetchAll($select);
                    if (count($cart) > 0) {
                        foreach ($result as $key => $val) {
                            $val['cart'] = $cart[$val['id']];
                            $tmp[] = $val;
                        }
                    }
                    foreach ($tmp as $key_1 => $info) {
                        $price = $info['cart']['price'];
                        $size = $info['cart']['size'];
                        $row = $this->fetchNew();
                        $row->product_id = $info['id'];
                        if ($info['cart']['number'] > 0)
                            $row->quantity = $info['cart']['number'];
                        else {
                            $row->quantity = 1;
                        }
                        if (isset($info['cart']['price']))
                            $row->price = $price;
                        else
                            $row->price = $info['price'];
                        if (isset($info['cart']['size']))
                            $row->size = $size;
                        else
                            $row->size = 'mặc định';
                        $row->invoice_id = $arrParam['invoice_id'];
                        $row->save();
                    }
                }
                if (count($arrParam['arrId']) > 0) {
                    foreach ($arrParam['arrId'] as $key => $val) {
                        if ($key == 0)
                            $arrId .= $val;
                        else
                            $arrId .= ',' . $val;
                    }
                    $select2 = $db->select()
                            ->from('price_pro as pp', array('pp.id', 'pp.price', 'pp.size', 'pp.selloff'))
                            ->joinLeft('products as p', 'pp.code_pro = p.code', array('p.id as idParent','p.name'))
                            ->where('pp.id IN (' . $arrId . ')');
                    $result2 = $db->fetchAll($select2);
                    foreach ($result2 as $key => $val) {
                        $price = $val['price'];
                        $size = $val['size'];
                        $row = $this->fetchNew();
                        $row->product_id = $val['id'];
                        $row->quantity = $cart[$val['idParent']][$val['id']]['number'];
                        $row->price = $price;
                        $row->size = $size;
                        $row->invoice_id = $arrParam['invoice_id'];
                    $row->save();
                    }
                }
            }
        }
        if ($options['task'] == 'admin-info') {
            $Item = $arrParam['Item'];
            $where = 'id = ' . $arrParam['id'];
            $row = $this->fetchRow($where);
            $row->hits = $Item['hits'] + 1;
            $row->save();
        }
    }

    public function deleteItem($arrParam = null, $options = null) {
        if ($options['task'] == 'admin-delete') {
            $where = ' id = ' . $arrParam['id'];
            $row = $this->fetchRow($where);
            $this->delete($where);
        }
        if ($options['task'] == 'admin-multi-delete') {
            $cid = $arrParam['cid'];
            if (count($cid) > 0) {
                $ids = implode(',', $cid);
                $db = $this->getAdapter();
                $where = 'id IN (' . $ids . ')';
                $this->delete($where);
            }
        }
    }

    public function getItem($arrParam = null, $options = null) {
        if ($options['task'] == 'admin-info' || $options['task'] == 'admin-edit') {
            $where = 'id = ' . $arrParam['id'];
            $result = $this->fetchRow($where)->toArray();
        }
        return $result;
    }

}