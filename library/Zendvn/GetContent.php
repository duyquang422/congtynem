<?php
/**
 * ============================================================
 * 
 * WORLDPROVN.COM LICENSE
 *
 * @copyright	Copyright (c) 2011-2012 ZENDVN
 * @license		http://worldprovn.com/license.html
 * @version		Oct 18, 2011 12:55:47 AM $KHOANGUYEN$
 * @since		2011-10-12
 *
 * ============================================================
 */


class Zendvn_GetContent{
	private $_dir_image_local;
	private $_url_image;
	
	public function __construct($uploadDir, $uploadUrl){
//		$this->_dir_image_local = FILES_PATH . '/uploaded';
//		$this->_url_image = FILES_URL . '/uploaded';
		$this->_dir_image_local = $uploadDir;
		$this->_url_image = $uploadUrl;
	}
	
	public function getContent($content = null){
		$item_image_url_pattern = '#src="([^"]*)"#ismU'; 
		preg_match_all($item_image_url_pattern, $content, $item_image_url_matches);	
		foreach($item_image_url_matches[1] as $item_image_url_array){
			//	Đường dẫn cho browser
			$this->_http_link[] = $this->_url_image .'/'. basename($item_image_url_array);
			//	Tạo đường dẫn để lưu tập tin
			$directory = $this->_dir_image_local .'/'. basename($item_image_url_array);
			
			$this->fn_copy_file($item_image_url_array, $directory);
		}
		return $this->fn_edit_link($content, $item_image_url_matches[1], $this->_http_link);	
	}
	public function fn_copy_file($file_url, $destination) {
		/**
		 * Kiểm tra hình do mình post hay copy
		 * Hình có đường dẫn trên domain của mình thi không save
		 */
		if($this->checkHost($file_url)){
			return false;
		}
		//	Kiểm tra file có tồn tại trên url hay không
		$headers = @get_headers($file_url);
		if (!preg_match('#\s200\s#', $headers[0])){
			return false;
		}		
		//	Kiểm tra file đã tồn tại trên local hay chưa
		if(file_exists($destination)){
			return false;
		}
		return @copy($file_url, $destination);
		
	}
	/**
	 * kiem tra host hinh copy voi host minh
	 * neu khac tra ve false, giong tra ve true
	 */ 
	public function checkHost($file_url){
		$pattern = '#(?:f|ht)tp(?:s)?\://(?:www\.)?([^/]+)#';
		preg_match($pattern, $file_url, $matches);
		if($matches[1] == $_SERVER['HTTP_HOST']){
			return true;
		}
		return false;
	}
	/**
	 *	Chỉnh sửa lại đường dẫn trong link
	 *	ex: $new_link = 'http://abc.com';
	 *	neu link tren host minh thi chuyen qua link tiep theo
	 * */	
	public function fn_edit_link($content, $link, $new_link){
		if(empty($link)) return;
		for($i = 0; $i< count($link); $i++){
			if($this->checkHost($link[$i])){
				$i++;
			}
			/**
			 * Replace href the a truoc the img neu href khac voi src
			 * ex: <a href="abc/123.jpg"><img src="abc/234.jpg"></a>
			 * result: <a href="abc/234.jpg"><img src="abc/234.jpg"></a>
			 */
			$pattern = '#<a(\s.*) href="(.*)"(\s.*)?><img(\s.*)? src="' . $link[$i] . '"(\s.*)?><\/a>#';
			preg_match_all($pattern, $content, $matches);
			$link[$i] = (empty($matches[2][0]))?$link[$i]:$matches[2][0];
			
			$content = str_replace($link[$i], $new_link[$i], $content);
		}
		$new_content = trim($content);
		$new_content = $content;	
		return $new_content;
	}
}
	