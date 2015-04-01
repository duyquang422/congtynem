<?php
class Zendvn_Validate_Phone extends Zend_Validate_Abstract{
	
	const INVALID = 'inValid';
	
    protected $_messageTemplates = array(
        self::INVALID => "Số điện thoại hợp lệ có dạng số và chấp nhận dấu cách",
        
    );
    
    public function isValid($value){
    	$g1 = '084-[0-9]{2}-[0-9]{2}\.[0-9]{6}';//so dt ban 084-08-05.123456
    	$g2 = '0[1-9 ]{12}';//so dt đd 0988 306 222 | 01689 456 789
    	
//    	$pattern = '#^('.$g1.'|'.$g2.')$#';
    	$pattern = '#^0[1-9]{1}[ 0-9]{8,12}$#';
//    	$pattern = '#^084-[0-9]{2}-[0-9]{2}\.[0-9]{6}$#';
    	
    	if(preg_match($pattern,$value)!=1){
    		$this->_error('inValid');
    		return false;
    	}    	
    	return true;
    	
    }
}