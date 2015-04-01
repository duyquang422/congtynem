<?php
class Zendvn_Validate_Between extends Zend_Validate_Between
{
	const NOT_BETWEEN        = 'notBetween';
    const NOT_BETWEEN_STRICT = 'notBetweenStrict';
    
    protected $_messageTemplates = array(
        self::NOT_BETWEEN        => "'%value%' phải lớn hơn '%min%' và nhỏ hơn '%max%'",
        self::NOT_BETWEEN_STRICT => "'%value%' không thuộc khoảng '%min%' và '%max%'"
    );
}