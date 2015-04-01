<?php
class Products_Form_ValidateComment{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;
		
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		
		//Kiểm tra title
		$validator 	= new Zend_Validate();
		$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
					->addValidator(new Zendvn_Validate_StringLength(5,250),true);
		if(!$validator->isValid($arrParam['title_com'])){
			$messages = $validator->getMessages();
			$this->_messagesError['title_com'] = 'Tiêu đề : ' . current($messages);
			$arrParam['title_com'] = '';
		}
		
		//Kiểm tra content
		$validator 	= new Zend_Validate();
		$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
					->addValidator(new Zendvn_Validate_StringLength(15,1050),true);
		if(!$validator->isValid($arrParam['content'])){
			$messages = $validator->getMessages();
			$this->_messagesError['content'] = 'Nội dung : ' . current($messages);
			$arrParam['content'] = '';
		}
		
		//Kiểm tra Email
		$validator 	= new Zend_Validate();
		if(empty($arrParam['user_id'])){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_EmailAddress(),true);
		} 					
		if(!$validator->isValid($arrParam['email'])){
			$messages = $validator->getMessages();
			$this->_messagesError['email'] = 'Email : ' . current($messages);
			$arrParam['email'] = '';
		}
		
		//Kiểm tra Full name
		$validator 	= new Zend_Validate();
		if(empty($arrParam['user_id'])){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_StringLength(5,50),true);
		} 					
		if(!$validator->isValid($arrParam['user_name'])){
			$messages = $validator->getMessages();
			$this->_messagesError['user_name'] = 'Tên : ' . current($messages);
			$arrParam['user_name'] = '';
		}
		
		//captcha
		$validator = new Zend_Validate();
		$validator->addValidator(new Zendvn_Validate_NotEmpty(),true)
				  ->addValidator(new Zendvn_Validate_Captcha($arrParam['captchaID']),true);
		if(!$validator->isValid($arrParam['captcha'])){
			$message = $validator->getMessages();
			$this->_messagesError['captcha'] = 'Mã bảo mật: ' . current($message);
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