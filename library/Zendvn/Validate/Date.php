<?php
class Zendvn_Validate_Date extends Zend_Validate_Date{
	
    const INVALID        = 'dateInvalid';
    const INVALID_DATE   = 'dateInvalidDate';
    const FALSEFORMAT    = 'dateFalseFormat';

    /**
     * Validation failure message template definitions
     *
     * @var array
     */
    protected $_messageTemplates = array(
        self::INVALID        => "Giá trị này không được hỗ trợ",
        self::INVALID_DATE   => "'%value%' không phải là định dạng ngày",
        self::FALSEFORMAT    => "'%value%' yêu cầu theo định dạng '%format%'",
    );
}