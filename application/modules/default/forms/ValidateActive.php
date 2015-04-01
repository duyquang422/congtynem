<?php
class Default_Form_ValidateActive{
	
	protected $_messagesError = null;
	
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		
		//Kiểm tra Password
		$validator 	= new Zend_Validate();
		$validator	->addValidator(new Zendvn_Validate_StringLength(6,32),true)
					->addValidator(new Zendvn_Validate_NotEmpty(),true)
					->addValidator(new Zendvn_Validate_Regex('#^[a-zA-Z0-9@!\#\$%\^&\*\-\+]+$#'),true);
		if(!$validator->isValid($arrParam['password'])){
			$messages = $validator->getMessages();
			$this->_messagesError['password'] = 'Mật khẩu : ' . current($messages);
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