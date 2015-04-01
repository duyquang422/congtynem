<?php

if (!empty($_FILES)) {
    //echo $_FILES['Filedata']['tmp_name'];
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] . $_REQUEST['folder'] . '/';
	$name = reset(explode(".",$_FILES['Filedata']['name']));
	$ext = end(explode(".",$_FILES['Filedata']['name']));
    $type = $_POST["type"];
	$filename = $type."_".time().".".$ext;
    echo json_encode($filename);
	
	$targetFile =  str_replace('//','/',$targetPath) . $filename;
	
	//$fileTypes  = str_replace('*.','',$_REQUEST['fileext']);
	//$fileTypes  = str_replace(';','|',$fileTypes);
	//$typesArray = split('\|',$fileTypes);
	//$fileParts  = pathinfo($_FILES['Filedata']['name']);
	
	//if (in_array($fileParts['extension'],$typesArray)) {
		// Uncomment the following line if you want to make the directory if it doesn't exist
		// mkdir(str_replace('//','/',$targetPath), 0755, true);
		if(file_exists($targetFile)){
		 
    	   $filename = $type."_".time().".".rand(1,1000).".".$ext;
		  
		  $targetFile =  str_replace('//','/',$targetPath) . $filename;
		}
        
		move_uploaded_file($tempFile,$targetFile);
        //str_replace($_SERVER['DOCUMENT_ROOT'],'',$targetFile);
		//echo "1";
	//} else {
	 	//echo 'Invalid file type.';
	//}
}
?>