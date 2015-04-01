<?php
class Zendvn_Models_slideImage extends Zend_Db_Table{
	protected $_name = 'slide_image';
    protected $_primary = 'id';

    public function listItem($id) {
        $db = $this->getAdapter();
        $select = $db->select()
                ->from($this->_name,'*')
                ->where('id = ?',$id);
        $result = $db->fetchRow($select);
        return $result;
    }
        public function saveItem($arrParam = null,$id, $options = null){	
		if($options['task'] 	== 'admin-add'){
			$row = $this->fetchNew();	
		}		
		if($options['task'] == 'admin-edit'){
			$where = 'id = ' . $id;			
			$row =  $this->fetchRow($where);
		}
		if(!empty($arrParam['picture'])):$row->picture	= $arrParam['picture'];endif;
		if(!empty($arrParam['picture1'])):$row->picture1	= $arrParam['picture1'];endif;
                if(!empty($arrParam['picture2'])):$row->picture2	= $arrParam['picture2'];endif;
		if(!empty($arrParam['picture3'])):$row->picture3	= $arrParam['picture3'];endif;	
                if(!empty($arrParam['picture4'])):$row->picture4	= $arrParam['picture4'];endif;
		$row->save();	
	}
}