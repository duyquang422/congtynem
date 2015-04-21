<?php

class Default_Form_ValidateRegister {

//Chứa những thông báo lỗi của form
    protected $_messagesError;
    //Mảng chứa dữ liệu sau khi kiểm tra
    protected $_arrData;

    public function __construct($arrParam = array(), $options = null) {
        //Kiểm tra Email
        $validator = new Zend_Validate();

        if ($options['task'] == 'edit') {
            $clause = ' id !=' . $arrParam['id'];
            $options = array('table' => 'users', 'field' => 'email', 'exclude' => $clause);
        } else {
            $options = array('table' => 'users', 'field' => 'email');
        }
        $validator->addValidator(new Zendvn_Validate_NotEmpty(), true)
                ->addValidator(new Zendvn_Validate_EmailAddress(), true)
                ->addValidator(new Zendvn_Validate_Db_NoRecordExists($options), true);

        if (!$validator->isValid($arrParam['email'])) {
            $messages = $validator->getMessages();
            $this->_messagesError['email'] = 'Email : ' . current($messages);
            $arrParam['email'] = '';
        }

        //Kiểm tra Last name
        $validator = new Zend_Validate();
        $validator->addValidator(new Zend_Validate_NotEmpty(), true)
                ->addValidator(new Zend_Validate_StringLength(2), true);
        if (!$validator->isValid($arrParam['last_name'])) {
            $messages = $validator->getMessages();
            $this->_messagesError['last_name'] = 'Last name : ' . current($messages);
            $arrParam['last_name'] = '';
        }
        
        //Kiểm tra re-password
        $validator = new Zend_Validate();
        $validator->addValidator(new Zend_Validate_NotEmpty(), true)
                  ->addValidator(new Zendvn_Validate_ConfirmPassword($arrParam['password']), true);
        if (!$validator->isValid($arrParam['re-password'])) {
            $messages = $validator->getMessages();
            $this->_messagesError['re_password'] = 'Password : ' . current($messages);
            $arrParam['re_password'] = '';
        }
        
        //Kiểm tra phone
        $validator = new Zend_Validate();
        $validator->addValidator(new Zend_Validate_NotEmpty(), true)
                ->addValidator(new Zendvn_Validate_Phone(), true);
        if (!$validator->isValid($arrParam['phone'])) {
            $messages = $validator->getMessages();
            $this->_messagesError['phone'] = 'phone : ' . current($messages);
            $arrParam['phone'] = '';
        }
        //kiểm tra password
        $validator = new Zend_Validate();
        $validator->addValidator(new Zendvn_Validate_StringLength(6, 32), true)
                ->addValidator(new Zendvn_Validate_NotEmpty(), true)
                ->addValidator(new Zendvn_Validate_Regex('#^[a-zA-Z0-9@!\#\$%\^&\*\-\+]+$#'), true);
        if (!$validator->isValid($arrParam['password'])) {
            $messages = $validator->getMessages();
            $this->_messagesError['password'] = 'Mật khẩu : ' . current($messages);
        }


        $this->_arrData = $arrParam;
    }

    public function isError() {
        //kiểm tra nếu có lỗi trả về giá trị true
        if (count($this->_messagesError) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public function getMessageError($options = null) {
        return $this->_messagesError;
    }

    public function getData($options = null) {
        return $this->_arrData;
    }

}