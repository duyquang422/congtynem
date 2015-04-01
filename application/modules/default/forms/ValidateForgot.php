<?php
class Default_Form_ValidateForgot{
	
	protected $_messagesError = null;
	
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		
		// ======================= user_name =======================
		$options = array('table'=>'users','field'=>'user_name');
		$validator = new Zend_Validate();
		$validator->addValidator(new Zendvn_Validate_NotEmpty(),true)
					->addValidator(new Zendvn_Validate_Db_RecordExists($options),true);
		if(!$validator->isValid($arrParam['user_name'])){
			$message = $validator->getMessages();
			$this->_messagesError['user_name'] = 'Tên tài khoản: ' . current($message);
			$arrParam['user_name'] = '';
		}
			
		// ======================= email =======================		
		$validator = new Zend_Validate();
		$validator->addValidator(new Zendvn_Validate_NotEmpty(),true)
				  ->addValidator(new Zendvn_Validate_EmailAddress(),true);
		if(!$validator->isValid($arrParam['email'])){
			$message = $validator->getMessages();
			$this->_messagesError['email'] = 'Email: ' . current($message);
			$arrParam['email'] = '';
		}
		
		$this->_arrData = $arrParam;
	}
	
	public function isError(){
		if(count($this->_messagesError)>0){
			return true;
		}else{
			return false;
		}
	}
	
	public function getMessageError(){
		return $this->_messagesError;
	}
	
	public function getData($options = null){
		return $this->_arrData;
	}
	
	
}