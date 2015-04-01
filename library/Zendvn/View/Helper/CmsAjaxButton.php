<?php
 
class Zendvn_View_Helper_CmsAjaxButton extends Zend_View_Helper_Abstract{
	
	public function cmsAjaxButton($idType = null, $name= null, $title = null, $link = null, $id = null){
		$img 	= PUBLIC_URL . '/templates/admin/system/images'; 
		switch ($idType){
			case 'ajax-delete-item':
					$img 	.= '/icon_del.png';
					break;
			case 'ajax-active-item':
			case 'ajax-special-item':	
			case 'ajax-access-item':
					$img 	.=  '/icon/active.png';
					break;
			case 'ajax-featured-item':
					$img 	.=  '/icon/featured.png';
					break;
					
			case 'ajax-favorites-item':
					$img 	.=  '/icon/favorites.png';
					break;
				
			case 'ajax-inactive-item':
			case 'ajax-nospecial-item':
			case 'ajax-noaccess-item': 
					$img 	.= '/icon/inactive.png';
					break;
			case 'ajax-nofeatured-item': 
					$img 	.= '/icon/nofeatured.png';
					break;
					
			case 'ajax-nofavorites-item': 
					$img 	.= '/icon/nofavorites.png';
					break;
					
			default: 
					break;
		}
		
		if($link == null){
			$xhtml = '<img class="' . $name . '" src="' . $img . '" title="' . $title . '">';
		}else{
			$xhtml = ' <a id="' . $idType.'-'.$id. '" class="' . $idType . '" href="' . $link . '">
	                      <img src="' . $img  . '" title="' . $title .'" > 
	                   </a>';
		}
		return $xhtml;
	}
}