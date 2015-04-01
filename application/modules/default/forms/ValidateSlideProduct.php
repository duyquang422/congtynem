<?php
class Default_Form_ValidateSlideProduct{
	//Chứa những thông báo lỗi của form
	protected $_messagesError;	
	//Mảng chứa dữ liệu sau khi kiểm tra
	protected $_arrData;	
	public function __construct($arrParam = array(),$options = null){
		$ssFilter	= $arrParam['ssFilter'];
		$lang		= $ssFilter['lang'];	
		//Kiểm tra File upload
		$upload = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $upload->getFileInfo("picture");
		$fileName = $fileInfo['picture']['name'];				
		if(!empty($fileName)){		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'picture');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'20000KB'),'picture');
			if(!$upload->isValid('picture')){
				$message = $upload->getMessages();
				$this->_messagesError['picture'] = 'Hình đại diện : ' . current($message);
				if($lang == 'en') $this->_messagesError['picture'] = 'picture : ' . current($message);			
			}
		}
                
                //Kiểm tra File upload
		$upload = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $upload->getFileInfo("picture1");
		$fileName = $fileInfo['picture1']['name'];				
		if(!empty($fileName)){		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'picture1');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'20000KB'),'picture1');
			if(!$upload->isValid('picture1')){
				$message = $upload->getMessages();
				$this->_messagesError['picture1'] = 'Hình đại diện : ' . current($message);
				if($lang == 'en') $this->_messagesError['picture1'] = 'picture1 : ' . current($message);			
			}
		}
                
                //Kiểm tra File upload
		$upload = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $upload->getFileInfo("picture2");
		$fileName = $fileInfo['picture2']['name'];				
		if(!empty($fileName)){		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'picture2');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'20000KB'),'picture2');
			if(!$upload->isValid('picture2')){
				$message = $upload->getMessages();
				$this->_messagesError['picture2'] = 'Hình đại diện : ' . current($message);
				if($lang == 'en') $this->_messagesError['picture2'] = 'picture2 : ' . current($message);			
			}
		}
                
                //Kiểm tra File upload
		$upload = new Zend_File_Transfer_Adapter_Http();
		$fileInfo = $upload->getFileInfo("picture3");
		$fileName = $fileInfo['picture3']['name'];				
		if(!empty($fileName)){		
			$upload->addValidator('Extension',true,array('jpg','gif','png'),'picture3');
			$upload->addValidator('Size',true,array('min'=>'2KB','max'=>'20000KB'),'picture3');
			if(!$upload->isValid('picture3')){
				$message = $upload->getMessages();
				$this->_messagesError['picture3'] = 'Hình đại diện : ' . current($message);
				if($lang == 'en') $this->_messagesError['picture3'] = 'picture3 : ' . current($message);			
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
                        $this->_arrData['picture1'] = $this->uploadFile('picture1',null);
                        $this->_arrData['picture2'] = $this->uploadFile('picture2',null);
                        $this->_arrData['picture3'] = $this->uploadFile('picture3',null);
		}
		return $this->_messagesError;
	}
	public function getData($options = null){
		if($options['upload'] == true){
			$this->_arrData['picture'] = $this->uploadFile('picture',null);
                        $this->_arrData['picture1'] = $this->uploadFile('picture1',null);
                        $this->_arrData['picture2'] = $this->uploadFile('picture2',null);
                        $this->_arrData['picture3'] = $this->uploadFile('picture3',null);
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
			$thumb	->resize(375,375)	->save($upload_dir . '/images375x375/' . $fileName);			
			$thumb = Zendvn_File_Images::create($upload_dir . '/orignal/' . $fileName);
			$thumb	->resize(40,40)	->save($upload_dir . '/images40x40/' . $fileName);
						
			if($this->_arrData['action']=='index')
			{	
				$upload->removeFile($upload_dir . '/orignal/'. $this->_arrData['current_stadium_' . $filename]);
				$upload->removeFile($upload_dir . '/images40x40/'. $this->_arrData['current_stadium_' . $filename]);
				$upload->removeFile($upload_dir . '/images375x254/'. $this->_arrData['current_stadium_' . $filename]);						
			}
		}
		return $fileName;		
	}
	
}