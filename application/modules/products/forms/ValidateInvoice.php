<?php
class Products_Form_ValidateInvoice{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;
	
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		//phone
		$validator 	= new Zend_Validate();
		$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
					->addValidator(new Zendvn_Validate_StringLength(10,15),true)
					->addValidator(new Zendvn_Validate_Int(), true);
		if(!$validator->isValid($arrParam['phone'])){
			$messages = $validator->getMessages();
			$this->_messagesError['phone'] = 'Điện thoại: '.current($messages);
		}		
		//Kiểm tra full_name
		$validator 	= new Zend_Validate();
		$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true);
		if(!$validator->isValid($arrParam['full_name'])){
			$messages = $validator->getMessages();
			$this->_messagesError['full_name'] = 'Họ tên: ' . current($messages);
			$arrParam['full_name'] = '';
		}				
		//Kiem tra address
		$validator 	= new Zend_Validate();
		$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true);
		if(!$validator->isValid($arrParam['address'])){
			$messages = $validator->getMessages();
			$this->_messagesError['address'] = 'Địa chỉ: ' . current($messages);
			$arrParam['address'] = '';
		}				
		//Kiểm tra Email
		$validator 	= new Zend_Validate();
		$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
					->addValidator(new Zendvn_Validate_EmailAddress(),true);					
		if(!$validator->isValid($arrParam['email'])){
			$messages = $validator->getMessages();
			$this->_messagesError['email'] = 'Email: ' . current($messages);
			$arrParam['email'] = '';
		}				
		//Kiểm tra status
		if(empty($arrParam['status']) || !isset($arrParam['status'])){
			$arrParam['status'] = 0;
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