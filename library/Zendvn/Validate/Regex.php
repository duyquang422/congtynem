<?php
class Zendvn_Validate_Regex extends Zend_Validate_Regex
{
    const INVALID   = 'regexInvalid';
    const NOT_MATCH = 'regexNotMatch';
    const ERROROUS  = 'regexErrorous';

    protected $_messageTemplates = array(
        self::INVALID   => "Giá trị không hợp lệ",
//        self::NOT_MATCH => "'%value%' không chứa các phần tử '%pattern%'",
        self::NOT_MATCH => "Chỉ chấp nhận các ký tự chữ hoặc số",
        self::ERROROUS  => "Chuỗi '%value%' không được chấp nhận",
    );
}