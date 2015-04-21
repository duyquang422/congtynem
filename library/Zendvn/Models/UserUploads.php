<?php
class Zendvn_Models_UserUploads extends Zend_Db_Table{
	protected $_name = 'user_uploads';
	protected $_primary = 'id';
        public function insert($filename){
           $invoice = new Zend_Session_Namespace('invoice');
           $invoice_id = $invoice->getIterator();
           $id = $invoice_id['id'];
           $db = Zend_Registry::get('connectDb');
           $data = array(
               image_name => $filename,
               invoice_id => $id
           );
           $db->insert($this->_name, $data);
        }
}