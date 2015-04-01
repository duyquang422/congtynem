<?php
class Zendvn_Validate_GreaterThan extends Zend_Validate_GreaterThan{
	
     protected $_messageTemplates = array(
        self::NOT_GREATER => "'%value%' phải lớn hớn '%min%'",
    );
    
    
}