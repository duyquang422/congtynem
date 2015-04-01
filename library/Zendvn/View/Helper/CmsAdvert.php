<?php
class Zendvn_View_Helper_CmsAdvert extends Zend_View_Helper_Abstract{
	
	public function cmsAdvert($class,$task,$mar_top = FALSE,$float = FALSE,$position, $options = null){
		$tblAdverts		= new Zendvn_Models_Advert();
		$adverts		= $tblAdverts->listItem($this->arrParam,array('task'=>$task,'position'=>$position));
		
        if(!empty($adverts)){
	    	foreach ($adverts as $keyAdv => $advItem) {
	        	$name 		= $advItem['name'];
	            $type 		= $advItem['type'];
	        	$typeName 	= 'image';
	        	$size 		= explode(',', $advItem['size']);
	        	$width 		= $size[0];
	        	$height 	= $size[1];
	        	if($type == 1)$typeName = 'flash';
				if(!empty($advItem['picture'])){
					if($type == 0){
						$src	= FILES_URL . '/adverts/orignal/' . $advItem['picture'];
					}elseif($type == 1){
						$src	= FILES_URL . '/flashs/' . $advItem['picture'];
					}
					
				}else{
					$src	= $this->imgUrl . '/no-image.jpg';
				}
		    	if(empty($advItem['url'])){
					$urlOptions = array('module'=>'news','controller'=>'index','action'=>'advert','id'=>$advItem['id'],
										'title'=>$advItem['alias'],'lang'=>$lang);
					$linkDetail = $this->url($urlOptions,'advert-detail');
				}else{
					$linkDetail = $advItem['url'];
				}
				if($float == true && $mar_top == false){
					$class = $class .' float-left';
					if(($keyAdv+1)%2 == 0) $class = $class .' float-right';
				}
	    		if($mar_top == true && $float == FALSE){
					if($keyAdv > 0) $class = $class .' mar-top-5';
				}
				if ($float == true && $mar_top == true){
					$num = 'num-'. ($keyAdv+1);
				}
		        $advert 	= '<div class="'. $class. ' ' .$num. '">'
		        					.$this->itemAdvert($name,$name,$linkDetail,$src,$class,$typeName,$width,$height) 
		        			. '<a target="_blank" title="'.$name.'" style="width:'.$width.'px;height:'.$height.'px" class="link-advert" href="'.$linkDetail.'"></a></div>';
		       	$xhtml[] =  $advert;
	    	}
	                            		
    	}else{
    		$xhtml[] =  '';
    	}
    	return $xhtml;
	}
	public function itemAdvert($title,$alt,$link,$src, $class, $type,$width,$height){
		$xhtml 		= '<a title="'.$title.'" href="'.$link.'"><img src="'.$src.'" alt="'.$alt.'" /></a>';
		if($type == 'flash'){
			$xhtml 	= '<object
					        classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
					        codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0"
					        id="Movie1"
					        width="'.$width.'" height="'.$height.'"
					      >
					        <param name="movie" value="'.$src.'">
					        <param name="bgcolor" value="#FFFFFF">
					        <param name="quality" value="high">
					        <param name="seamlesstabbing" value="false">
					        <param name="allowscriptaccess" value="samedomain">
					        <embed
					          type="application/x-shockwave-flash"
					          pluginspage="http://www.adobe.com/shockwave/download/index.cgi?P1_Prod_Version=ShockwaveFlash"
					          name="Movie1"
					          width="'.$width.'" height="'.$height.'"
					          src="'.$src.'"
					          bgcolor="#FFFFFF"
					          quality="high"
					          seamlesstabbing="false"
					          allowscriptaccess="samedomain"
					          wmode = "transparent"
					        >
					          <noembed>
					          </noembed>
					        </embed>
					</object>';
		}
		return $xhtml;
	}
}