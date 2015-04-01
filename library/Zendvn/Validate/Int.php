<?php
class Zendvn_Validate_Int extends Zend_Validate_Int
{
	const INVALID = 'intInvalid';
    const NOT_INT = 'notInt';
    
     protected $_messageTemplates = array(
        self::INVALID => "Giá trị này phải là kiểu số nguyên",
        self::NOT_INT => "'%value%' không phải là kiểu số nguyên",
    );
}