<?php
class Zendvn_Validate_Db_NoRecordExists extends Zend_Validate_Db_NoRecordExists
{
	const ERROR_NO_RECORD_FOUND = 'noRecordFound';
    const ERROR_RECORD_FOUND    = 'recordFound';

    /**
     * @var array Message templates
     */
    protected $_messageTemplates = array(
        self::ERROR_NO_RECORD_FOUND => '%value% chưa tồn tại',
        self::ERROR_RECORD_FOUND    => '%value% đã tồn tại',
    );
}