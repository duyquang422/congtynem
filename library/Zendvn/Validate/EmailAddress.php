<?php
/**
 * ZENDVN CMS
 * 
 * LICENSE 2011
 *
 * 
 * @copyright	Copyright (c) 2011-2012 Professional world Corporation (http://www.worldprovn.com)
 * @license		http://www.worldprovn.com/license.html
 * @forum		http://zend.vn/forum
 * @portal		http://zend.vn/public
 * @version 	$Id: EmailAddress.php Sep 27, 2011 2:16:47 PM  ANHNGA $
 * @since		1.0
 */

 
class Zendvn_Validate_EmailAddress extends Zend_Validate_EmailAddress
{
    const INVALID            = 'emailAddressInvalid';
    const INVALID_FORMAT     = 'emailAddressInvalidFormat';
    const INVALID_HOSTNAME   = 'emailAddressInvalidHostname';
    const INVALID_MX_RECORD  = 'emailAddressInvalidMxRecord';
    const INVALID_SEGMENT    = 'emailAddressInvalidSegment';
    const DOT_ATOM           = 'emailAddressDotAtom';
    const QUOTED_STRING      = 'emailAddressQuotedString';
    const INVALID_LOCAL_PART = 'emailAddressInvalidLocalPart';
    const LENGTH_EXCEEDED    = 'emailAddressLengthExceeded';
    
    protected $_messageTemplates = array(
        self::INVALID            => "Địa chỉ email ko hợp lệ",
        self::INVALID_FORMAT     => "Địa chỉ email của bạn không đúng chuẩn local-part@hostname",
        self::INVALID_HOSTNAME   => "không tìm thấy tên miền '%hostname%' trong địa chỉ '%value%'",
        self::INVALID_MX_RECORD  => "Tên miền '%hostname%' không hợp lệ trong địa chỉ '%value%'",
        self::INVALID_SEGMENT    => "Tên miền '%hostname%' không hợp lệ trong địa chỉ '%value%'",
        self::DOT_ATOM           => "'%localPart%' thì không đúng định đạng email",
        self::QUOTED_STRING      => "'%localPart%' thì không đúng định đạng email",
        self::INVALID_LOCAL_PART => "'%localPart%' thì không hợp lệ với '%value%'",
        self::LENGTH_EXCEEDED    => "Địa chỉ email của bạn vượt quá chiều dài cho phép",
    );
}