<?php
class Zendvn_Validate_NotEmpty extends Zend_Validate_NotEmpty
{
	const INVALID  = 'notEmptyInvalid';
    const IS_EMPTY = 'isEmpty';
    
     protected $_messageTemplates = array(
        self::IS_EMPTY => "Giá trị này không được rỗng",
        self::INVALID  => "Giá trị này phải là kiếu số thực, chuỗi, mảng hoặc kiểu số nguyên",
    );
}