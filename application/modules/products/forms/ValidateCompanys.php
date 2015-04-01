<?php
class Products_Form_ValidateSlide{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;
	
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		$ssFilter	= $arrParam['ssFilter'];
		$lang		= $ssFilter['lang'];
		$id = $arrParam['id'];
		if(!isset($id)){
			$options 	= array('table'=>'slide','field'=>'name');
		}else{
			$clause = ' id !=' . $arrParam['id'];
   			$options = array('table'=>'slide','field'=>'name','exclude'=>$clause);				
		}
		//Kiểm tra Name
		$validator 	= new Zend_Validate();
		
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['name'] = 'Tên slide : ' . current($messages);
				$arrParam['name'] = '';
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true)
						->addValidator(new Zend_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['name'] = 'Slide Name : ' . current($messages);
				$arrParam['name'] = '';
			}
		}		
				
		//Kiểm tra File upload
		$upload = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $upload->getFileInfo('picture');
		$fileName = $fileInfo['picture']['name'];		
		if(!empty($fileName)){
		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'picture');
			$upload->addValidator('Size',true,array('min'=>'10KB','max'=>'5000KB'),'picture');
			if(!$upload->isValid('picture')){
				$message = $upload->getMessages();
				$this->_messagesError['picture'] = 'Picture : ' . current($message);
				
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
			$this->_arrData['picture'] = $this->uploadFile('picture',null);
		}
		return $this->_messagesError;
	}
	public function getData($options = null){
		if($options['upload'] == true){
			$this->_arrData['picture'] = $this->uploadFile('picture',null);
		}
		return $this->_arrData;
	}
	public function uploadFile($filename = null, $options = null){
		//Duong dan den thu muc upload		
		$upload_dir = FILES_PATH . '/slide';
		$upload = new Zendvn_File_Upload();
		$fileInfo = $upload->getFileInfo($filename);
		$fileName = $fileInfo[$filename]['name'];		
		if(!empty($fileName)){
			$fileName = $upload->upload($filename, $upload_dir . '/orignal',
							 array('task'=>'rename'),$filename . '_');
			$thumb = Zendvn_File_Images::create($upload_dir . '/orignal/' . $fileName);
			$thumb	->resize(180,50)	->save($upload_dir . '/images100x100/' . $fileName);			
			$thumb = Zendvn_File_Images::create($upload_dir . '/orignal/' . $fileName);
			$thumb	->resize(497,257)	->save($upload_dir . '/images450x450/' . $fileName);
						
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