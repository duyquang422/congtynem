<?php
class Default_Form_ValidateQuestions{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;
		
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		
		//Kiểm tra Name
		$validator 	= new Zend_Validate();
		$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true);
		if(!$validator->isValid($arrParam['title'])){
			$messages = $validator->getMessages();
			$this->_messagesError['title'] = 'Title : ' . current($messages);
			$arrParam['title'] = '';
		}
		
		//Kiểm tra content
		$validator 	= new Zend_Validate();
		$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true);
		if(!$validator->isValid($arrParam['content'])){
			$messages = $validator->getMessages();
			$this->_messagesError['content'] = 'Content : ' . current($messages);
			$arrParam['content'] = '';
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