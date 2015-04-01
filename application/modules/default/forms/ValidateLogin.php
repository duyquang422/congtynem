<?php
class Default_Form_ValidateLogin{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;
	
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		
		//Kiểm tra User name
		$validator 	= new Zend_Validate();
		$options 	= array('table'=>'users','field'=>'email');
		$validator->addValidator(new Zend_Validate_NotEmpty(),true)
				  ->addValidator(new Zend_Validate_EmailAddress(),true);
		if(!$validator->isValid($arrParam['email'])){
			$messages = $validator->getMessages();
			$this->_messagesError['email'] = 'Email : ' . current($messages);
			$arrParam['email'] = '';
		}
		//Kiểm tra Password
			$validator 	= new Zend_Validate();
			$validator	->addValidator(new Zend_Validate_StringLength(6,32),true)
						->addValidator(new Zend_Validate_NotEmpty(),true)
						->addValidator(new Zend_Validate_Regex('#^[a-zA-Z0-9@!\#\$%\^&\*\-\+]+$#'),true);
			if(!$validator->isValid($arrParam['password'])){
				$messages = $validator->getMessages();
				$this->_messagesError['password'] = 'Password : ' . current($messages);
			}
	
		
		
		
		$this->_arrData = $arrParam;
	}
	
	public function isError(){
		//kiểm tra nếu có lỗi trả về giá trị true
		if(count($this->_messagesError) > 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function getMessageError($options = null){
	
		return $this->_messagesError;
	}
	public function getData($options = null){
		
		return $this->_arrData;
	}
	
}