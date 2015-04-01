<?php
class Zendvn_File_Upload extends Zend_File_Transfer_Adapter_Http{
	
	public function upload($file_name,$upload_dir,$options = null,$prefix = 'file_'){
				
		if($options == null){
			$this->setDestination($upload_dir,$file_name);
			$info 			= $this->getFileInfo($file_name);
			$newFileName 	= $info[$file_name]['name'];
			$this->receive($file_name);
		}
		
		if($options['task'] == 'rename' ){
                        $this->setDestination($upload_dir,$file_name);
			$info = $this->getFileName($file_name);
			preg_match('#\.([^\.]+)$#',$info,$matches);
			$fileExtension  = $matches[1];
			$newFileName 	= $prefix . time() . '.' . $fileExtension;
		
			$options = array('target' => $upload_dir . '/' . $newFileName,'overwrite'=>true);
			$this->addFilter('Rename',$options,$file_name);
			$this->receive($file_name);
		}
		
		return $newFileName;
	}
	public function removeFile($filename){
	  	@unlink($filename);
	}
}