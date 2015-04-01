<?php
	include 'ResizeImage.php';
	$dir = '/new-travel/public/files/photos/';
	// Define a destination
	$targetFolder = $dir . 'orignal'; // Relative to the root
	$verifyToken = md5('unique_salt' . $_POST['timestamp']);

if (!empty($_FILES) && $_POST['token'] == $verifyToken) {
	$tempFile = $_FILES['Filedata']['tmp_name'];
	$targetPath = $_SERVER['DOCUMENT_ROOT'] .'/'. $targetFolder;
	$file_name=uniqid()."_".$_FILES['Filedata']['name'];
	$targetFile = rtrim($targetPath,'/') . '/' . $file_name;
	
	//$thumb = Zendvn_File_Images::create($targetFolder . '/' . $file_name);
	//$thumb	->resize(200,200)	->save($targetFolder . '/images200x200/' . $file_name);
	
	// Validate the file type
	$fileTypes = array('jpg','jpeg','gif','png','JPG','JPEG','GIF','PNG'); // File extensions
	$fileParts = pathinfo($_FILES['Filedata']['name']);
	
	if (in_array($fileParts['extension'],$fileTypes)) {
		move_uploaded_file($tempFile,$targetFile);
		
		$resizeOb=new ResizeImage();
		$resizeOb->load($targetPath."/".$file_name);
		$resizeOb->resize(200, 200);
		$targetFolder = $dir . 'images200x200'; // Relative to the root
		$resizeOb->save($_SERVER['DOCUMENT_ROOT'].$targetFolder."/".$file_name);
		
		$fileReturn=$targetFolder."/".$file_name;
		$html="<input type='hidden' name='picture[]' value='$file_name'/>";
		$html.="<img width='100' height='100' src='$fileReturn'/>";
		$del="<span class='img-del' id='' title='$file_name'>xóa</span>";
		$html.=$del;
		echo "<div class='img-row' id='img-$file_name' title='$file_name'>$html</div>";
	}else
	{
		echo 'Invalid file type.';
	}
}

?>