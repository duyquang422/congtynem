<?php
class Products_Form_ValidatePricePro{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;
	
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		$ssFilter	= $arrParam['ssFilter'];
		$lang		= $ssFilter['lang'];
		//Kiểm tra Name
		$validator 	= new Zend_Validate();
		
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true);
			if(!$validator->isValid($arrParam['code_pro'])){
				$messages = $validator->getMessages();
				$this->_messagesError['code_pro'] = 'Mã sản phẩm : ' . current($messages);
				$arrParam['code_pro'] = '';
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true);
			if(!$validator->isValid($arrParam['code_pro'])){
				$messages = $validator->getMessages();
				$this->_messagesError['code_pro'] = 'Code product : ' . current($messages);
				$arrParam['code_pro'] = '';
			}
		}
		
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true);
			if(!$validator->isValid($arrParam['size'])){
				$messages = $validator->getMessages();
				$this->_messagesError['size'] = 'Quy cách : ' . current($messages);
				$arrParam['size'] = '';
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true);
			if(!$validator->isValid($arrParam['size'])){
				$messages = $validator->getMessages();
				$this->_messagesError['size'] = 'Size : ' . current($messages);
				$arrParam['size'] = '';
			}
		}

		//Kiểm tra status
		if(empty($arrParam['units']) || !isset($arrParam['units'])){
			$arrParam['units'] = 2;
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