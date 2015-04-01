<?php
class News_Form_ValidateNews{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;
		
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;
	
	public function __construct($arrParam = array(),$options = null){
		$ssFilter	= $arrParam['ssFilter'];
		$lang		= $ssFilter['lang'];
		$id = $arrParam['id'];
		if(!isset($id)){
			$options 	= array('table'=>'news_item','field'=>'name');
		}else{
			$clause = ' id !=' . $arrParam['id'];
   			$options = array('table'=>'news_item','field'=>'name','exclude'=>$clause);				
		}
		//Kiểm tra Name
		$validator 	= new Zend_Validate();
		if($lang == 'vi'){
			$validator	->addValidator(new Zendvn_Validate_NotEmpty(),true)
						->addValidator(new Zendvn_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['name'] = 'Tiêu đề: ' . current($messages);
				$arrParam['name'] = '';
			}
		}else{
			$validator	->addValidator(new Zend_Validate_NotEmpty(),true)
						->addValidator(new Zend_Validate_Db_NoRecordExists($options),true);
			if(!$validator->isValid($arrParam['name'])){
				$messages = $validator->getMessages();
				$this->_messagesError['name'] = 'Title: ' . current($messages);
				$arrParam['name'] = '';
			}
		}
		
		$upload = new Zend_File_Transfer_Adapter_Http();
		//Kiểm tra File video
		$fileInfo = $upload->getFileInfo('video');
		$fileName = $fileInfo['video']['name'];		
		if(!empty($fileName)){
			$upload->addValidator('Extension',true,array('flv','mp4','avi','mp3','swf','mov'),'video');
			$upload->addValidator('Size',true,array('min'=>'10KB','max'=>'500MB'),'video');
			if(!$upload->isValid('video')){
				$message = $upload->getMessages();
				$this->_messagesError['video'] = 'Video : ' . current($message);
			}
		}
		
		//Kiểm tra File download
		$fileInfo = $upload->getFileInfo('file_download');
		$fileName = $fileInfo['file_download']['name'];		
		if(!empty($fileName)){
			$upload->addValidator('Extension',true,array('zip','rar','ZIP','RAR','xlsx','xls','odt','doc'),'file_download');
			$upload->addValidator('Size',true,array('min'=>'5KB','max'=>'1000MB'),'file_download');
			if(!$upload->isValid('file_download')){
				$message = $upload->getMessages();
				$this->_messagesError['file_download'] = 'File download : ' . current($message);
			}
		}
				
		//Kiểm tra File upload
		$fileInfo = $upload->getFileInfo('picture');
		$fileName = $fileInfo['picture']['name'];		
		if(!empty($fileName)){
		
			$upload->addValidator('Extension',true,array('jpg','gif','png','jpeg'),'picture');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'20000KB'),'picture');
			if(!$upload->isValid('picture')){
				$message = $upload->getMessages();
				$this->_messagesError['picture'] = 'Hình ảnh : ' . current($message);
			}
		}
		
		//Kiểm tra category
		if(empty($arrParam['menu_id'])){
			$this->_messagesError['menu_id'] = 'Chuyên mục: vui lòng chọn chuyên mục';
			if($lang == 'en') $this->_messagesError['menu_id'] = 'Menu: Please select menu';
		}
		//Kiểm tra status
		if(empty($arrParam['status']) || !isset($arrParam['status'])){
			$arrParam['status'] = 0;
		}
		//Kiểm tra special
		if(empty($arrParam['special']) || !isset($arrParam['special'])){
			$arrParam['special'] = 0;
		}

		//Kiểm tra featured
		if(empty($arrParam['featured']) || !isset($arrParam['featured'])){
			$arrParam['featured'] = 0;
		}
		
		//Kiểm tra type
		if(empty($arrParam['type']) || !isset($arrParam['type'])){
			$arrParam['type'] = 0;
		}
		//Kiểm tra show
		if(empty($arrParam['show']) || !isset($arrParam['show'])){
			$arrParam['show'] = 0;
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
			$this->_arrData['video'] = $this->uploadFile('video',null);
			$this->_arrData['file_download'] = $this->uploadFile('file_download',null);
		}
		return $this->_messagesError;
	}
	public function getData($options = null){
		if($options['upload'] == true){
			$this->_arrData['picture'] = $this->uploadFile('picture',null);
			$this->_arrData['video'] = $this->uploadFile('video',null);
			$this->_arrData['file_download'] = $this->uploadFile('file_download',null);
		}
		return $this->_arrData;
	}
	public function uploadFile($filename = null, $options = null){
		if($filename == 'picture'){
			//Duong dan den thu muc upload		
			$upload_dir = FILES_PATH . '/news';
			$upload = new Zendvn_File_Upload();
			$fileInfo = $upload->getFileInfo($filename);
			$fileName = $fileInfo[$filename]['name'];
			if(!empty($fileName)){
				$fileName = $upload->upload($filename, $upload_dir . '/orignal',
								 array('task'=>'rename'),$filename . '_');
				$thumb = Zendvn_File_Images::create($upload_dir . '/orignal/' . $fileName);
				$thumb	->resize(61,106)	->save($upload_dir . '/images100x100/' . $fileName);			
				$thumb = Zendvn_File_Images::create($upload_dir . '/orignal/' . $fileName);
				$thumb	->resize(450,450)	->save($upload_dir . '/images450x450/' . $fileName);
							
				if($this->_arrData['action']=='edit')
				{	
					$upload->removeFile($upload_dir . '/orignal/'. $this->_arrData['current_stadium_' . $filename]);
					$upload->removeFile($upload_dir . '/images100x100/'. $this->_arrData['current_stadium_' . $filename]);
					$upload->removeFile($upload_dir . '/images450x450/'. $this->_arrData['current_stadium_' . $filename]);						
				}
			}
		}elseif($filename == 'video'){
			//Duong dan den thu muc upload		
			$upload_dir	= FILES_PATH . '/videos';
			$upload = new Zendvn_File_Upload();
			$fileInfo = $upload->getFileInfo($filename);
			$fileName = $fileInfo[$filename];
			$fileName = $fileInfo[$filename]['name'];
			
			if(!empty($fileName)){
				$fileName = $upload->upload($filename, $upload_dir, array('task'=>'rename'),$filename . '_');
				if($this->_arrData['action']=='edit'){	
					$current_video	= $this->_arrData['hide_video'];
					$upload->removeFile($upload_dir . '/'. $current_video);
				}
			}
		}elseif($filename == 'file_download'){
			//Duong dan den thu muc upload		
			$upload_dir	= FILES_PATH . '/documents';
			$upload = new Zendvn_File_Upload();
			$fileInfo = $upload->getFileInfo($filename);
			$fileName = $fileInfo[$filename];
			$fileName = $fileInfo[$filename]['name'];
			
			if(!empty($fileName)){
				$fileName = $upload->upload($filename, $upload_dir, array('task'=>'rename'),$filename . '_');
				if($this->_arrData['action']=='edit'){	
					$hide_file_down	= $this->_arrData['hide_file_down'];
					$upload->removeFile($upload_dir . '/'. $hide_file_down);
				}
			}
		}
		return $fileName;	
		
	}
}