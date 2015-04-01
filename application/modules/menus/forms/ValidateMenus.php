<?php
class Menus_Form_ValidateMenus{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;
	
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		$ssFilter	= $arrParam['ssFilter'];
		$lang		= $ssFilter['lang'];
		
		$id = $arrParam['id'];
		if(!isset($id)){
			$options 	= array('table'=>'menu','field'=>'name');
		}else{
			$clause = ' id !=' . $arrParam['id'];
   			$options = array('table'=>'menu','field'=>'name','exclude'=>$clause);				
		}
		//Kiểm tra Name
		$validator 	= new Zend_Validate();
		
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_StringLength(2,64),true);
//						->addValidator(new Zendvn_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['name'] = 'Tên chuyên mục : ' . current($messages);
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true)
						->addValidator(new Zend_Validate_StringLength(2,64),true);
//						->addValidator(new Zend_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['name'] = 'Category Name : ' . current($messages);
			}
		}
				
		//Kiểm tra File upload
		$upload = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $upload->getFileInfo('picture');
		$fileName = $fileInfo['picture']['name'];		
		if(!empty($fileName)){
		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'picture');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'1000KB'),'picture');
			if(!$upload->isValid('picture')){
				$message = $upload->getMessages();
				$this->_messagesError['picture'] = 'Picture : ' . current($message);
				
			}
		}
		//Kiểm tra status
		if(empty($arrParam['status']) || !isset($arrParam['status'])){
			$arrParam['status'] = 0;
		}
		
		//Kiểm tra special
		if(empty($arrParam['special']) || !isset($arrParam['special'])){
			$arrParam['special'] = 0;
		}
		
		//Kiểm tra type
		if($arrParam['type'] == 0){
			$this->_messagesError['type'] = 'Kiểu chuyên mục: vui lòng chọn kiểu chuyên mục';
			if($lang == 'en') $this->_messagesError['type'] = 'Type menu: Please select type menu';
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
		$upload_dir = FILES_PATH . '/category';
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