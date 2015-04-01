<?php
class Default_Form_ValidatePass{
//Chứa những thông báo lỗi của form
	protected $_messagesError;
	
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		
		//Kiểm tra Password
		if($options['task'] != 'edit'){
			$validator 	= new Zend_Validate();
			$validator	->addValidator(new Zendvn_Validate_StringLength(6,32),true)
						->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_Regex('#^[a-zA-Z0-9@!\#\$%\^&\*\-\+]+$#'),true);
			
			if(!$validator->isValid($arrParam['password'])){
				$messages = $validator->getMessages();
				$this->_messagesError['password'] = 'Password : ' . current($messages);
			}
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