<?php
/**
 * @File Exists.php
 * @Auth http://anhnga2607.wordpress.com
 *
 * @Copyright 2011, ANHNGA
 *
 * @Date: 15-07-2011 16:14:19
 * 
 */
 
class Zendvn_File_Exists{
	
	/**
	 * 
	 * Kiem tra su ton tai cua hinh anh tren server
	 * @param files_path $file
	 */
	public static function checkFileExists($file, $url){
		
		if(empty($file)) return false;
		if(!is_file($url.$file)) false;
		return true;
//		try {
//			fclose(fopen($file, "r"));
//			return true;
//		} catch (Exception $e) {
//			return false;
//		}
	}
	
}