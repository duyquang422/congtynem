<?php
class Default_Form_ValidateGroup{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;	
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;	
	public function __construct($arrParam = array(),$options = null){
		$ssFilter	= $arrParam['ssFilter'];
		$lang		= $ssFilter['lang'];
		
		//Kiểm tra group name
		$validator = new Zend_Validate();
		if($arrParam['action'] == 'add'){
			$options = array('table'=>'user_group','field'=>'group_name');
		}else if($arrParam['action'] == 'edit'){
			$clause = ' id !=' . $arrParam['id'];
			$options = array('table'=>'user_group','field'=>'group_name','exclude'=>$clause);
		}
		
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_StringLength(3,32),true)
						->addValidator(new Zendvn_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['group_name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['group_name'] = 'Tên nhóm : ' . current($messages);
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true)
						->addValidator(new Zend_Validate_StringLength(3,32),true)
						->addValidator(new Zend_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['group_name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['group_name'] = 'Group name : ' . current($messages);
			}
		}
		

		
		//Kiểm tra File upload
		$upload = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $upload->getFileInfo("avatar");
		$fileName = $fileInfo['avatar']['name'];				
		if(!empty($fileName)){		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'avatar');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'20000KB'),'avatar');
			if(!$upload->isValid('avatar')){
				$message = $upload->getMessages();
				$this->_messagesError['avatar'] = 'Hình đại diện : ' . current($message);
				if($lang == 'en') $this->_messagesError['avatar'] = 'Avatar : ' . current($message);			
			}
		}
		
		//Kiểm tra File upload
		$upload = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $upload->getFileInfo('ranking');
		$fileName = $fileInfo['ranking']['name'];		
		if(!empty($fileName)){		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'ranking');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'1000KB'),'ranking');
			if(!$upload->isValid('ranking')){
				$message = $upload->getMessages();
				$this->_messagesError['ranking'] = 'Ranking : ' . current($message);				
			}
		}	
		//Kiểm tra status
		if(empty($arrParam['status']) || !isset($arrParam['status'])){
			$arrParam['status'] = 0;
		}		
		$this->_arrData = $arrParam;
	}
	
	public function isError(){
		//kiểm tra nếu có lỗi trả v�? giá trị true
		if(count($this->_messagesError) > 0){
			return true;
		}else{
			return false;
		}
	}	
	public function getMessageError($options = null){
		if($options['upload'] == true){
			$this->_arrData['avatar'] = $this->uploadFile('avatar',null);
			$this->_arrData['ranking'] = $this->uploadFile('ranking',null);
		}
		return $this->_messagesError;
	}
	public function getData($options = null){
		if($options['upload'] == true){
			$this->_arrData['avatar'] = $this->uploadFile('avatar',null);
			$this->_arrData['ranking'] = $this->uploadFile('ranking',null);
		}
		return $this->_arrData;
	}
	public function uploadFile($filename = null, $options = null){
		//Duong dan den thu muc upload		
		$upload_dir = FILES_PATH . '/group';
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