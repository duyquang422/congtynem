<?php
class Zendvn_Validate_StringLength extends Zend_Validate_StringLength
{
    const INVALID   = 'stringLengthInvalid';
    const TOO_SHORT = 'stringLengthTooShort';
    const TOO_LONG  = 'stringLengthTooLong';

    /**
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID   => "Giá trị này phải là kiêu chuỗi",
        self::TOO_SHORT => "Giá trị này phải có ít nhất %min% ký tự",
        self::TOO_LONG  => "Giá trị bạn nhập vào quá lớn so với thực tế",
    );
   
}