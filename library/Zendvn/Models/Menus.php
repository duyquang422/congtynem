<?php

class Zendvn_Models_Menus extends Zend_Db_Table {

    protected $_name = 'menus';
    protected $_primary = 'id';
    protected $_id;

    public function removeNode($id, $options = 'branch') {
        $this->_id = $id;

        if ($options == 'branch' || $options == null)
            $this->removeBranch();
    }

    public function listItem($arrParam = null, $options = null) {
        $paginator = $arrParam['paginator'];
        $ssFilter = $arrParam['ssFilter'];
        $db = $this->getAdapter();
        $select = $db->select()
                ->from($this->_name, array('id', 'name', 'alias','picture', 'picture1','picture2','picture3','parent', 'level', 'description', 'status'))
                ->where('lft > 0');
        // Order..............
        $order = 'lft ASC';
//			$ssFilter = $arrParam['ssFilter'];
//			if(!empty($ssFilter['col']) && !empty($ssFilter['order'])){
//				$order = $ssFilter['col'] . ' ' . $ssFilter['order'];
//			}
        $select->order($order);
        if($arrParam['controller']=="admin-category"){
            if ($paginator['itemCountPerPage'] > 0) {
                $page = $paginator['currentPage'];
                $rowCount = $paginator['itemCountPerPage'];
                $select->limitPage($page, $rowCount);
            }
        }
        //Filter
//			if(!empty($ssFilter['keywords'])){
//				$keywords = '%' . $ssFilter['keywords'] . '%';
//				$select->where('g.group_name LIKE ?',$keywords,STRING);
//			}
        $result = $db->fetchAll($select);
        return $result;
    }
    public function itemInSelectbox($arrParam = null, $options = null){
		$db = Zend_Registry::get('connectDb');
		if($options == null){
			$select = $db->select()
                                     ->from($this->_name, array('id','name','level','lft'))
                                     ->order('lft ASC');
			$result = $db->fetchAll($select);
			ksort($result);								 
		}
		return $result;
	}
    public function getItem($arrParam = null, $options = null){		
		if($options['task'] == 'admin-info' || $options['task'] == 'admin-edit'){
                    $db = Zend_Registry::get('connectDb');
                    //$db = Zend_Db::factory($adapter, $config);
			$select = $db->select()
						->from($this->_name, array('id', 'name','alias','picture','picture1','picture2','picture3','parent', 'level', 'description', 'status'))
						->where("id = ?",$arrParam['id']);
			$result = $db->fetchRow($select);
		}
		return $result;
	}
    public function countItem($arrParam = null, $options = null) {
        $db = $this->getAdapter();
//		$ssFilter = $arrParam['ssFilter'];		
        $select = $db->select()
                ->from($this->_name, array('COUNT(id) AS totalItem'));
//		if(!empty($ssFilter['keywords'])){
//				$keywords = '%' . $ssFilter['keywords'] . '%';
//				$select->where('g.group_name LIKE ?',$keywords,STRING);
//		}
        $result = $db->fetchOne($select);
        return $result;
    }
    public function changeStatus($arrParam = null, $options = null) {
        $cid = $arrParam['cid'];
        if (count($cid) > 0) {
            if ($arrParam['type'] == 1) {
                $status = 1;
            } else {
                $status = 0;
            }
            $ids = implode(',', $cid);
            $data = array('status' => $status);
            $where = 'id IN (' . $ids . ')';
            $this->update($data, $where);
        }
        if ($arrParam['id'] > 0) {
            if ($arrParam['type'] == 1) {
                $status = 1;
            } else {
                $status = 0;
            }
            $data = array('status' => $status);
            $where = 'id = ' . $arrParam['id'];
            $this->update($data, $where);
        }
    }
    protected function removeBranch() {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);
        //1. Lay thong cua node bi xoa
        $infoNodeRemove = $this->getNodeInfo($this->_id);

        //2. Tinh chieu dai cua nhanh chung muon xoa
        $widthNodeRemove = $this->widthNode($infoNodeRemove['lft'], $infoNodeRemove['rgt']);

        //3. Xoa nhanh
        $where = 'lft BETWEEN ' . $infoNodeRemove['lft'] . ' AND ' . $infoNodeRemove['rgt'];
        $db->delete($this->_name, $where);

        //4. Cap nhat lai cai gia tri left - right của cay
        $data = array('lft' => new Zend_Db_Expr('lft - ' . $widthNodeRemove));
        $where = 'lft > ' . $infoNodeRemove['rgt'];
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt - ' . $widthNodeRemove));
        $where = 'rgt > ' . $infoNodeRemove['rgt'];
        $db->update($this->_name, $data, $where);
    }

    public function updateNode($data) {
        $id = $data['id'];
        $newParentID = $data['parent'];
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);
        
        if ($id != 0 && $id > 0 && count($data) != 0) {
            $where = 'id = ' . $id;
            $row =  $this->fetchRow($where);
            if(!empty($data['picture'])):$row->picture	= $data['picture'];endif;
            if(!empty($data['picture1'])):$row->picture1	= $data['picture1'];endif;
            if(!empty($data['picture2'])):$row->picture2	= $data['picture2'];endif;
            if(!empty($data['picture3'])):$row->picture3	= $data['picture3'];endif;
            $row->name	= $data['name'];
            $row->alias	= $data['alias'];
            $row->description	= $data['description'];
            $row->status	= $data['status'];
            $row->save();

            $infoNode = $this->getNodeInfo($id);

            if ($newParentID > 0 && $newParentID != null) {
                if ($infoNode['parent'] != $newParentID) {
                     $this->moveNode($id, $newParentID);
                }
            }
        }
    }

    public function moveNode($id, $parent, $options = null) {
        $this->_id = $id;
        $this->_parent_id = $parent;

        if ($options['position'] == 'right' || $options == null)
            $this->moveRight();

        if ($options['position'] == 'left')
            $this->moveLeft();

        if ($options['position'] == 'before')
            $this->moveBefore($options['brother_id']);

        if ($options['position'] == 'after')
            $this->moveAfter($options['brother_id']);
    }

    public function moveUp($id) {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);
        $infoMoveNode = $this->getNodeInfo($id);
        
        $select = $db->select()->from($this->_name,'*')
                               ->where('parent = ' . $infoMoveNode['parent'])
                               ->where('lft < ' . $infoMoveNode['lft'])
                               ->order('lft DESC')
                               ->limit(1);
        $infoBrotherNode = $db->fetchRow($select);
        if (!empty($infoBrotherNode)) {
            $options = array('position' => 'before', 'brother_id' => $infoBrotherNode['id']);
            $this->moveNode($id, $infoMoveNode['parent'], $options);
        }
    }

    public function moveDown($id) {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);
        $infoMoveNode = $this->getNodeInfo($id);
        $select = $db->select()->from($this->_name,'*')
                               ->where('parent = ' . $infoMoveNode['parent'])
                               ->where('lft > ' . $infoMoveNode['lft'])
                               ->order('lft ASC')
                               ->limit(1);
        $infoBrotherNode = $db->fetchRow($select);
        if (!empty($infoBrotherNode)) {
            $options = array('position' => 'after', 'brother_id' => $infoBrotherNode['id']);
            $this->moveNode($id, $infoMoveNode['parent'], $options);
        }
    }

    protected function moveRight() {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);
        $infoMoveNode = $this->getNodeInfo($this->_id);

        $lftMoveNode = $infoMoveNode['lft']; // 3
        $rgtMoveNode = $infoMoveNode['rgt']; // 6

        /* ================================================
         *  1. Tach nhanh khoi cay
          /*================================================ */
        $data = array('lft' => new Zend_Db_Expr('lft - ' . $lftMoveNode),
            'rgt' => new Zend_Db_Expr('rgt - ' . $rgtMoveNode));
        $where = 'lft BETWEEN ' . $lftMoveNode . ' AND ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        //2. Tinh do dai cua nhanh chung ta cat
        $widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);

        //3. Cap nhat gia tri cac node nam ben phai cua node tach

        $data = array('lft' => new Zend_Db_Expr('lft - ' . $widthMoveNode));
        $where = 'lft > ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt - ' . $widthMoveNode));
        $where = 'rgt > ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        //4. Lay ra thong thong tin cua node cha ($infoParentNode)
        $infoParentNode = $this->getNodeInfo($this->_parent_id);
        $rgtParentNode = $infoParentNode['rgt'];


        //5. Cap nhat cac gia tri truoc khi gan nhanh vao

        $data = array('lft' => new Zend_Db_Expr('lft + ' . $widthMoveNode));
        $where = 'lft > ' . $rgtParentNode;
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + ' . $widthMoveNode));
        $where = 'rgt >= ' . $rgtParentNode;
        $db->update($this->_name, $data, $where);

        //6. Cap nhat level cho nhanh sap dc gan vao cay
        $levelMoveNode = $infoMoveNode['level'];
        $levelParentNode = $infoParentNode['level'];

        $data = array('level' => new Zend_Db_Expr('level - ' . $levelMoveNode . '+' . $levelParentNode . '+ 1'));
        $where = 'rgt <=0 ';
        $db->update($this->_name, $data, $where);


        //7. Cap nhat nhanh truoc khi gan vao node moi

        $data = array('lft' => new Zend_Db_Expr('lft + ' . $infoParentNode['rgt']));
        $where = 'rgt <= 0';
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + ' . $infoParentNode['rgt'] . '+' . $widthMoveNode . '- 1'));
        $where = 'rgt <= 0';
        $db->update($this->_name, $data, $where);

        //8. Gan vao node cha
        $data = array('parent' => $infoParentNode['id']);
        $where = 'id = ' . $infoMoveNode['id'];
        $db->update($this->_name, $data, $where);
    }

    protected function moveLeft() {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);

        $infoMoveNode = $this->getNodeInfo($this->_id);

        $lftMoveNode = $infoMoveNode['lft'];
        $rgtMoveNode = $infoMoveNode['rgt'];

        //1. Tach nhanh khoi cay
        $data = array('lft' => new Zend_Db_Expr('lft - ' . $lftMoveNode),
            'rgt' => new Zend_Db_Expr('rgt - ' . $rgtMoveNode));
        $where = 'lft BETWEEN ' . $lftMoveNode . ' AND ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        //2. Tinh do dai cua nhanh chung ta cat
        $widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);

        //3. Cap nhat gia tri cac node nam ben phai cua node tach

        $data = array('lft' => new Zend_Db_Expr('lft - ' . $widthMoveNode));
        $where = 'lft > ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt - ' . $widthMoveNode));
        $where = 'rgt > ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        //4. Lay ra thong thong tin cua node cha ($infoParentNode)
        $infoParentNode = $this->getNodeInfo($this->_parent_id);
        $lftParentNode = $infoParentNode['lft'];

        //5. Cap nhat cac gia tri truoc khi gan nhanh vao

        $data = array('lft' => new Zend_Db_Expr('lft + ' . $widthMoveNode));
        $where = 'lft > ' . $lftParentNode;
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + ' . $widthMoveNode));
        $where = 'rgt > ' . $lftParentNode;
        $db->update($this->_name, $data, $where);

        // 6. Cap nhat level cho nhanh sap dc gan vao cay
        $levelMoveNode = $infoMoveNode['level'];
        $levelParentNode = $infoParentNode['level'];

        $data = array('level' => new Zend_Db_Expr('level - ' . $levelMoveNode . '+' . $levelParentNode . '+ 1'));
        $where = 'rgt <=0';
        $db->update($this->_name, $data, $where);

        //7. Cap nhat nhanh truoc khi gan vao node moi

        $data = array('lft' => new Zend_Db_Expr('lft + ' . $infoParentNode['lft'] . ' + 1'));
        $where = 'rgt <=0';
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + ' . $infoParentNode['lft'] . '+' . $widthMoveNode));
        $where = 'rgt <=0';
        $db->update($this->_name, $data, $where);

        // 8. Gan vao node cha
        $data = array('parent' => $infoParentNode['id']);
        $where = 'id = ' . $infoMoveNode['id'];
        $db->update($this->_name, $data, $where);
    }

    protected function moveBefore($brother_id) {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);
        $infoMoveNode = $this->getNodeInfo($this->_id);
        $lftMoveNode = $infoMoveNode['lft'];
        $rgtMoveNode = $infoMoveNode['rgt']; 

        //1. Tach nhanh khoi cay
        
        $data = array('lft' => new Zend_Db_Expr('lft - ' . $lftMoveNode),
            'rgt' => new Zend_Db_Expr('rgt - ' . $rgtMoveNode));
        $where = 'lft BETWEEN ' . $lftMoveNode . ' AND ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);
         
        //2. Tinh do dai cua nhanh chung ta cat
        $widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);

        //3. Cap nhat gia tri cac node nam ben phai cua node tach  
        $data = array('lft' => new Zend_Db_Expr('lft - ' . $widthMoveNode));
        $where = 'lft > ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt - ' . $widthMoveNode));
        $where = 'rgt > ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);
        
        //4. Lay ra thong thong tin cua node cha ($infoParentNode)
        $infoParentNode = $this->getNodeInfo($this->_parent_id);
        $lftParentNode = $infoParentNode['lft'];

        //5. Lay gia tri cua node brother ($infoBrotherNode)
        $infoBrotherNode = $this->getNodeInfo($brother_id);
        $lftBrotherNode = $infoBrotherNode['lft'];

        //6. Cap nhat cac gia tri truoc khi gan nhanh vao
         
        $data = array('lft' => new Zend_Db_Expr('lft + ' . $widthMoveNode));
        $where = 'lft >= ' . $lftBrotherNode;
        $db->update($this->_name, $data, $where);
        
        $data = array('rgt' => new Zend_Db_Expr('rgt + ' . $widthMoveNode));
        $where = 'rgt > ' . $lftBrotherNode;
        $db->update($this->_name, $data, $where);
        
        //7. Cap nhat level cho nhanh sap dc gan vao cay
        $levelMoveNode = $infoMoveNode['level'];
        $levelParentNode = $infoParentNode['level'];
        
        $data = array('level' => new Zend_Db_Expr('level - ' . $levelMoveNode . '+' . $levelParentNode . '+ 1'));
        $where = 'rgt <=0';
        $db->update($this->_name, $data, $where);
        
        //8. Cap nhat nhanh truoc khi gan vao node moi
        
        $data = array('lft' => new Zend_Db_Expr('lft + ' . $lftBrotherNode));
        $where = 'rgt <= 0';
        $db->update($this->_name, $data, $where);
        
        $data = array('rgt' => new Zend_Db_Expr('rgt + ' . $lftBrotherNode . '+' . $widthMoveNode . '- 1'));
        $where = 'rgt <= 0';
        $db->update($this->_name, $data, $where);

        //9. Gan vao node cha
          /*================================================ */
        $data = array('parent' => $infoParentNode['id']);
        $where = 'id = ' . $infoMoveNode['id'];
        $db->update($this->_name, $data, $where);
    }

    protected function moveAfter($brother_id) {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);

        $infoMoveNode = $this->getNodeInfo($this->_id);

        $lftMoveNode = $infoMoveNode['lft']; // 3
        $rgtMoveNode = $infoMoveNode['rgt']; // 6
        // 1. Tach nhanh khoi cay
        $data = array('lft' => new Zend_Db_Expr('lft - ' . $lftMoveNode),
            'rgt' => new Zend_Db_Expr('rgt - ' . $rgtMoveNode));
        $where = 'lft BETWEEN ' . $lftMoveNode . ' AND ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        //2. Tinh do dai cua nhanh chung ta cat
        $widthMoveNode = $this->widthNode($lftMoveNode, $rgtMoveNode);

        //3. Cap nhat gia tri cac node nam ben phai cua node tach
        $data = array('lft' => new Zend_Db_Expr('lft - ' . $widthMoveNode));
        $where = 'lft > ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt - ' . $widthMoveNode));
        $where = 'rgt > ' . $rgtMoveNode;
        $db->update($this->_name, $data, $where);

        //4. Lay ra thong thong tin cua node cha ($infoParentNode)
        $infoParentNode = $this->getNodeInfo($this->_parent_id);

        //5. Lay gia tri cua node brother ($infoBrotherNode)
        $infoBrotherNode = $this->getNodeInfo($brother_id);
        $rgtBrotherNode = $infoBrotherNode['rgt'];

        //6. Cap nhat cac gia tri truoc khi gan nhanh vao
        $data = array('lft' => new Zend_Db_Expr('lft + ' . $widthMoveNode));
        $where = 'lft > ' . $rgtBrotherNode;
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + ' . $widthMoveNode));
        $where = 'rgt > ' . $rgtBrotherNode;
        $db->update($this->_name, $data, $where);

        //7. Cap nhat level cho nhanh sap dc gan vao cay
        $levelMoveNode = $infoMoveNode['level'];
        $levelParentNode = $infoParentNode['level'];

        $data = array('level' => new Zend_Db_Expr('level - ' . $levelMoveNode . '+' . $levelParentNode . '+ 1'));
        $where = 'rgt <= 0';
        $db->update($this->_name, $data, $where);

        //8. Cap nhat nhanh truoc khi gan vao node moi
        $data = array('lft' => new Zend_Db_Expr('lft + ' . $rgtBrotherNode . '+ 1'));
        $where = 'rgt <= 0';
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + ' . $rgtBrotherNode . '+' . $widthMoveNode));
        $where = 'rgt <= 0';
        $db->update($this->_name, $data, $where);

        //9. Gan vao node cha
        $data = array('parent' => $infoParentNode['id']);
        $where = 'id = ' . $infoMoveNode['id'];
        $db->update($this->_name, $data, $where);
    }

    public function widthNode($lftMoveNode, $rgtMoveNode) {
        $widthMoveNode = $rgtMoveNode - $lftMoveNode + 1;
        return $widthMoveNode;
    }

    public function insertNode($data, $options = null) {
        $this->_data = $data;
        $this->_parent_id = $data['parent'];

        if ($options['position'] == 'right' || $options == null)
            $this->insertRight();

        if ($options['position'] == 'left')
            $this->insertLeft();

        if ($options['position'] == 'before')
            $this->insertBefore($data['brother_id']);

        if ($options['position'] == 'after')
            $this->insertAfter($data['brother_id']);
    }

    protected function insertAfter($brother_id) {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);

        $parentInfo = $this->getNodeInfo($this->_parent_id);
        $brothderInfo = $this->getNodeInfo($brother_id);

        $data = array('lft' => new Zend_Db_Expr('lft + 2'));
        $where = 'lft > ' . $brothderInfo['rgt'];
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + 2'));
        $where = 'rgt > ' . $brothderInfo['rgt'];
        $db->update($this->_name, $data, $where);

        $data = $this->_data;
        $data['parent'] = $parentInfo['id']; //$this->_parent_id
        $data['lft'] = $brothderInfo['rgt'] + 1;
        $data['rgt'] = $brothderInfo['rgt'] + 2;
        $data['level'] = $parentInfo['level'] + 1;

        $data = array('name' => $data['name'],
            'url' => $data['url'],
            'parent' => $data['parent'],
            'alias' => $data['alias'],
            'picture' => $data['picture'],
            'picture1' => $data['picture1'],
            'picture2' => $data['picture2'],
            'picture3' => $data['picture3'],
            'description' => $data['description'],
            'status' => $data['status'],
            'lft' => $data['lft'],
            'rgt' => $data['rgt'],
            'level' => $data['level']
        );
        $db->insert($this->_name, $data);
    }

    protected function insertBefore($brother_id) {
        $db = Zend_Registry::get('connectDb');
//        $db = Zend_Db::factory($adapter, $config);
        $parentInfo = $this->getNodeInfo($this->_parent_id);

        $brothderInfo = $this->getNodeInfo($brother_id);

        $data = array('lft' => new Zend_Db_Expr('lft + 2'));
        $where = 'lft >= ' . $brothderInfo['lft'];
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + 2'));
        $where = 'rgt >= ' . ($brothderInfo['lft'] + 1);
        $db->update($this->_name, $data, $where);

        $data = $this->_data;
        $data['parent'] = $parentInfo['id']; //$this->_parent_id
        $data['lft'] = $brothderInfo['lft'];
        $data['rgt'] = $brothderInfo['lft'] + 1;
        $data['level'] = $parentInfo['level'] + 1;
        $data = array('name' => $data['name'],
            'url' => $data['url'],
            'parent' => $data['parent'],
            'alias' => $data['alias'],
            'picture' => $data['picture'],
            'picture1' => $data['picture1'],
            'picture2' => $data['picture2'],
            'picture3' => $data['picture3'],
            'description' => $data['description'],
            'status' => $data['status'],
            'lft' => $data['lft'],
            'rgt' => $data['rgt'],
            'level' => $data['level']
        );
        $db->insert($this->_name, $data);
    }

    protected function insertLeft() {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);
        $parentInfo = $this->getNodeInfo($this->_parent_id);

        $parentLeft = $parentInfo['lft'];

        $data = array('lft' => new Zend_Db_Expr('lft + 2'));
        $where = 'lft >= ' . ($parentLeft + 1);
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + 2'));
        $where = 'rgt > ' . ($parentLeft + 1);
        $db->update($this->_name, $data, $where);

        $data = $this->_data;
        $data['parent'] = $parentInfo['id']; //$this->_parent_id
        $data['lft'] = $parentLeft + 1;
        $data['rgt'] = $parentLeft + 2;
        $data['level'] = $parentInfo['level'] + 1;

        $data = array('name' => $data['name'],
            'url' => $data['url'],
            'parent' => $data['parent'],
            'alias' => $data['alias'],
            'picture' => $data['picture'],
            'picture1' => $data['picture1'],
            'picture2' => $data['picture2'],
            'picture3' => $data['picture3'],
            'description' => $data['description'],
            'status' => $data['status'],
            'lft' => $data['lft'],
            'rgt' => $data['rgt'],
            'level' => $data['level']
        );
        $db->insert($this->_name, $data);
    }

    protected function insertRight() {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter, $config);
        $parentInfo = $this->getNodeInfo($this->_parent_id);

        $parentRight = $parentInfo['rgt'];
        $data = array('lft' => new Zend_Db_Expr('lft + 2'));
        $where = 'lft > ' . $parentRight;
        $db->update($this->_name, $data, $where);

        $data = array('rgt' => new Zend_Db_Expr('rgt + 2'));
        $where = 'rgt >= ' . $parentRight;
        $db->update($this->_name, $data, $where);

        $data = $this->_data;
        $data['parent'] = $parentInfo['id']; //$this->_parent_id
        $data['lft'] = $parentRight;
        $data['rgt'] = $parentRight + 1;
        $data['level'] = $parentInfo['level'] + 1;
        $data = array('name' => $data['name'],
            'url' => $data['url'],
            'parent' => $data['parent'],
            'alias' => $data['alias'],
            'picture' => $data['picture'],
            'picture1' => $data['picture1'],
            'picture2' => $data['picture2'],
            'picture3' => $data['picture3'],
            'description' => $data['description'],
            'status' => $data['status'],
            'lft' => $data['lft'],
            'rgt' => $data['rgt'],
            'level' => $data['level']
        );
        $db->insert($this->_name, $data);
    }

    public function getNodeInfo($id) {
        $db = Zend_Registry::get('connectDb');
        //$db = Zend_Db::factory($adapter,$config);
        $select = $db->select()->from($this->_name, '*')
                ->where('id = ' . $id);
        $result = $db->fetchRow($select);
        return $result;
    }

}