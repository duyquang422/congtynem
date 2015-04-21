<?php
class Zendvn_Models_UserUploads extends Zend_Db_Table{
	protected $_name = 'user_uploads';
	protected $_primary = 'id';
        public function insert($filename){
           $db = Zend_Registry::get('connectDb');
           $data = array(
               image_name => $filename
           );
           $db->insert($this->_name, $data);
        }
}