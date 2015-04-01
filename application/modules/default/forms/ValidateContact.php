<?php
class Default_Form_ValidateContact{
	
	//CHUA NHUNG THONG BAO LOI CUA FORM
	protected $_messagesError = null;
	
	//MANG CHUA DU LIEU SAU KHI KIEM TRA
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		//email
		$validator = new Zend_Validate();
		$validator->addValidator(new Zendvn_Validate_NotEmpty(),true)
				  ->addValidator(new Zendvn_Validate_EmailAddress(),true);
		if(!$validator->isValid($arrParam['email'])){
			$message = $validator->getMessages();
			$this->_messagesError['email'] = 'Email: ' . current($message);
		}

		//captcha
		$validator = new Zend_Validate();
		$validator->addValidator(new Zendvn_Validate_NotEmpty(),true)
				  ->addValidator(new Zendvn_Validate_Captcha($arrParam['captchaID']),true);
		if(!$validator->isValid($arrParam['captcha'])){
			$message = $validator->getMessages();
			$this->_messagesError['captcha'] = 'Mã bảo mật: ' . current($message);
		}
		
		//fullname
		$validator = new Zend_Validate();
		$validator->addValidator(new Zendvn_Validate_NotEmpty(),true)
				  ->addValidator(new Zendvn_Validate_StringLength(5, 100));
		if(!$validator->isValid($arrParam['fullname'])){
			$message = $validator->getMessages();
			$this->_messagesError['fullname'] = 'Họ tên: ' . current($message);
		}
		
		//title
		$validator = new Zend_Validate();
		$validator->addValidator(new Zendvn_Validate_NotEmpty(),true)
				  ->addValidator(new Zendvn_Validate_StringLength(10, 200));
		if(!$validator->isValid($arrParam['title'])){
			$message = $validator->getMessages();
			$this->_messagesError['title'] = 'Tiêu đề: ' . current($message);
		}
		
		//message
		$validator = new Zend_Validate();
		$validator->addValidator(new Zendvn_Validate_NotEmpty(),true)
				  ->addValidator(new Zendvn_Validate_StringLength(15));
		if(!$validator->isValid($arrParam['message'])){
			$message = $validator->getMessages();
			$this->_messagesError['message'] = 'Nội dung: ' . current($message);
		}
		// TRUYEN CAC GIA TRI DUNG VAO MANG $_arrData
		$this->_arrData = $arrParam;
	}
	//Kiem tra Error 
	//return true neu co loi xuat hien
	public function isError(){		
		if(count($this->_messagesError)>0){
			return true;
		}else{
			return false;
		}
	}
	
	//Tra ve mot mang cac loi
	public function getMessageError(){
		return $this->_messagesError;
	}
	
	//Tra ve mot mang du lieu sau khi kiem tra
	public function getData($options = null){
		return $this->_arrData;
	}
	
}