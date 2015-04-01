<?php
class Zendvn_System_Language extends Zend_Controller_Plugin_Abstract
{

	public function preDispatch(Zend_Controller_Request_Abstract $request){   		    
		$params = $request->getParams();
		
	
		$params['type'] = 'interface';
		if(empty($params['lang'])){
			$params['lang'] = 'vi';
		}
			
		$info = new Zendvn_System_Info();
		$info->setLanguage('change', $params,'admin');
    }
    
}