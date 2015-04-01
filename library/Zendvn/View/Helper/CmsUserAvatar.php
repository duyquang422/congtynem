<?php
/**
 * ZENDVN CMS
 * 
 * LICENSE 2011
 *
 * 
 * @copyright	Copyright (c) 2011-2012 Professional world Corporation (http://www.worldprovn.com)
 * @license		http://www.worldprovn.com/license.html
 * @forum		http://zend.vn/forum
 * @portal		http://zend.vn/public
 * @version 	$Id: CmsUserAvatar.php Aug 25, 2011 11:20:28 PM  ANHNGA $
 * @since		1.0
 */

 
class Zendvn_View_Helper_CmsUserAvatar extends Zend_View_Helper_Abstract{
	
	/**
	 * Hien thi hinh anh cho thanh vien
	 * $inputInfo = array('idtag'=>'id','class'=>'class','name'=>'name')
	 * $imgArr = array('url1','url2')
	 */
	public function cmsUserAvatar($inputInfo = array(), $imgArr = array()){
		
		$xhtml = '';
		if(!empty($imgArr)){
			foreach ($imgArr as $k => $v){
				if(Zendvn_File_Exists::checkFileExists($v,'')){
					$xhtml .= '<img src="'.$v.'" style="max-width:145px;max-height:89px" />';
				}
			}
		}
		if(!empty($inputInfo)){
			$idtag = !empty($inputInfo['idtag'])?'id="'.$inputInfo['idtag'].'"':'';
			$class = !empty($inputInfo['class'])?'class="'.$inputInfo['class'].'"':'';
			$name = !empty($inputInfo['name'])?$inputInfo['name']:'image';
			$xhtml .= '<input type="file" '.$class.$idtag.' name="'.$name.'" style="margin-top:2px;">';
		}
		
		$xhtml = '
			<div class="upload_image" style="width:250px; margin-left: 175px; margin-top: 1px;">    	
		        '.$xhtml.'
		    </div>
		';
		return $xhtml;
	}
}