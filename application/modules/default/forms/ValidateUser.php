<?php
class Default_Form_ValidateUser{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;
	
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		$ssFilter	= $arrParam['ssFilter'];
		$lang		= $ssFilter['lang'];
		
		//Kiểm tra User name
		$validator 	= new Zend_Validate();
		if($arrParam['action'] == 'add'){
			$options = array('table'=>'users','field'=>'user_name');
		}else if($arrParam['action'] == 'edit'){
			$clause = ' id !=' . $arrParam['id'];
			$options = array('table'=>'users','field'=>'user_name','exclude'=>$clause);
		}
		
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_StringLength(3,32),true)
						->addValidator(new Zendvn_Validate_Regex('#^[a-zA-Z0-9\-_\.\s]+$#'),true)
						->addValidator(new Zendvn_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['user_name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['user_name'] = 'Tên người sử dụng : ' . current($messages);
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true)
						->addValidator(new Zend_Validate_StringLength(3,32),true)
						->addValidator(new Zend_Validate_Regex('#^[a-zA-Z0-9\-_\.\s]+$#'),true)
						->addValidator(new Zend_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['user_name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['user_name'] = 'User name : ' . current($messages);
			}
		}
		
		//Kiểm tra File upload
		$upload = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $upload->getFileInfo('user_avatar');
		$fileName = $fileInfo['user_avatar']['name'];
		
		if(!empty($fileName)){		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'user_avatar');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'20000KB'),'user_avatar');
			if(!$upload->isValid('user_avatar')){
				$message = $upload->getMessages();
				$this->_messagesError['user_avatar'] = 'Hình đại diện : ' . current($message);
				if($lang == 'en') $this->_messagesError['user_avatar'] = 'Avatar : ' . current($message);
			}
		}
		
		//Kiểm tra Password
		if($arrParam['action'] == 'add'){
			$validator 	= new Zend_Validate();
			if($lang == 'vi'){
				$validator	->addValidator(new Zendvn_Validate_StringLength(6,32),true)
							->addValidator(new Zendvn_Validate_NotEmpty(),true)
							->addValidator(new Zendvn_Validate_Regex('#^[a-zA-Z0-9@!\#\$%\^&\*\-\+]+$#'),true);
				if(!$validator->isValid($arrParam['password'])){
					$messages = $validator->getMessages();
					$this->_messagesError['password'] = 'Mật khẩu : ' . current($messages);
				}
			}else{
				$validator	->addValidator(new Zend_Validate_StringLength(6,32),true)
							->addValidator(new Zend_Validate_NotEmpty(),true)
							->addValidator(new Zend_Validate_Regex('#^[a-zA-Z0-9@!\#\$%\^&\*\-\+]+$#'),true);
				if(!$validator->isValid($arrParam['password'])){
					$messages = $validator->getMessages();
					$this->_messagesError['password'] = 'Password : ' . current($messages);
				}
			}
			
		}		
		
		//Kiểm tra Email
		$validator 	= new Zend_Validate();
		if($arrParam['action'] == 'add'){
			$options = array('table'=>'users','field'=>'email');
		}else if($arrParam['action'] == 'edit'){
			$clause = ' id !=' . $arrParam['id'];
			$options = array('table'=>'users','field'=>'email','exclude'=>$clause);
		}
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_EmailAddress(),true)
						->addValidator(new Zendvn_Validate_Db_NoRecordExists($options),true);
						
			if(!$validator->isValid($arrParam['email'])){
				$messages = $validator->getMessages();
				$this->_messagesError['email'] = 'Email : ' . current($messages);
				$arrParam['email'] = '';
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true)
						->addValidator(new Zend_Validate_EmailAddress(),true)
						->addValidator(new Zend_Validate_Db_NoRecordExists($options),true);
						
			if(!$validator->isValid($arrParam['email'])){
				$messages = $validator->getMessages();
				$this->_messagesError['email'] = 'Email : ' . current($messages);
				$arrParam['email'] = '';
			}
		}
		
		
		//Kiểm tra Group_id
		if($arrParam['group_id'] == 0){
			$this->_messagesError['group_id'] = 'Nhóm : vui lòng chọn một nhóm';
			if($lang == 'en') $this->_messagesError['group_id'] = 'Group : select a group';
		}
		
		//Kiểm tra First name
		$validator 	= new Zend_Validate();
		
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_StringLength(2),true);
			if(!$validator->isValid($arrParam['first_name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['first_name'] = 'Họ : ' . current($messages);
				$arrParam['first_name'] = '';
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true)
						->addValidator(new Zend_Validate_StringLength(2),true);
			if(!$validator->isValid($arrParam['first_name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['first_name'] = 'First name : ' . current($messages);
				$arrParam['first_name'] = '';
			}
		}
		//Kiểm tra Last name
		$validator 	= new Zend_Validate();
		
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_StringLength(2),true);
			if(!$validator->isValid($arrParam['last_name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['last_name'] = 'Tên : ' . current($messages);
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true)
						->addValidator(new Zend_Validate_StringLength(2),true);
			if(!$validator->isValid($arrParam['last_name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['last_name'] = 'Last name : ' . current($messages);
			}
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
		if($options['upload'] == true){
			$this->_arrData['user_avatar'] = $this->uploadFile('user_avatar',null);
		}
		return $this->_messagesError;
	}
	public function getData($options = null){
		if($options['upload'] == true){
			$this->_arrData['user_avatar'] = $this->uploadFile('user_avatar',null);
		}
		return $this->_arrData;
	}
	public function uploadFile($filename = null, $options = null){
		//Duong dan den thu muc upload		
		$upload_dir = FILES_PATH . '/users';
		$upload = new Zendvn_File_Upload();
		$fileInfo = $upload->getFileInfo($filename);
		$fileName = $fileInfo[$filename]['name'];		
		if(!empty($fileName)){
			$fileName = $upload->upload($filename, $upload_dir . '/orignal',
							 array('task'=>'rename'),$filename . '_');
			$thumb = Zendvn_File_Images::create($upload_dir . '/orignal/' . $fileName);
			$thumb	->resize(100,100)	->save($upload_dir . '/images100x100/' . $fileName);			
			$thumb = Zendvn_File_Images::create($upload_dir . '/orignal/' . $fileName);
			$thumb	->resize(450,450)	->save($upload_dir . '/images450x450/' . $fileName);
						
			if($this->_arrData['action']=='edit')
			{	
				$upload->removeFile($upload_dir . '/orignal/'. $this->_arrData['current_stadium_' . $filename]);
				$upload->removeFile($upload_dir . '/images100x100/'. $this->_arrData['current_stadium_' . $filename]);
				$upload->removeFile($upload_dir . '/images450x450/'. $this->_arrData['current_stadium_' . $filename]);						
			}
		}		
		return $fileName;		
	}
}