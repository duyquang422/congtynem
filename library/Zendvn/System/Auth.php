<?php
class Zendvn_System_Auth{
	
	protected $_messageError = null;
	
	public function login($arrParam,$options = null){
		
		//1. Goi ket noi voi Zend Db
		$db = Zend_Registry::get('connectDb');
		
		//2.Khoi tao Zend Auth
		$auth = Zend_Auth::getInstance();
		
		//3 
		$authAdapter = new Zend_Auth_Adapter_DbTable($db);
		//Zend_Db_Adapter_Abstract $zendDb = null, $tableName = null, $identityColumn = null,
        //                        $credentialColumn = null, $credentialTreatment = null)
		$authAdapter->setTableName('users')
					->setIdentityColumn('email')
					->setCredentialColumn('password');
		$select = $authAdapter->getDbSelect();
		$select->where('status = 1');
		
		$encode  = new Zendvn_Encode();
		$email = $arrParam['email'];
		$password = $encode->password($arrParam['password']);
		$authAdapter->setIdentity($email);
		$authAdapter->setCredential($password);
			
		//Lay ket qua truy van cua Zend_Auth
		$result = $auth->authenticate($authAdapter);
		
		$flag = false;
		if(!$result->isValid()){
				$error = $result->getMessages();
				$this->_messageError['loginError'] = current($error);
		}else{			
			$omitColumns = array('password');
			$data = $authAdapter->getResultRowObject(null,$omitColumns);	
			$auth->getStorage()->write($data);	
			$flag = true;
		}
		
		return $flag;
	}
	
	public function getError(){
		return $this->_messageError;
	}
	
	public function logout($arrParam = null,$options = null){
		$auth = Zend_Auth::getInstance();
		$auth->clearIdentity();
	}
}