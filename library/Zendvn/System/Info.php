<?php
class Zendvn_System_Info{
	private $_ss;
	//Ham khoi tao cua lop
	public function __construct(){
		$ns = new Zend_Session_Namespace('info');
		//$ns->setExpirationSeconds(1800);
		$this->_ss = new Zend_Session_Namespace('info');
		$this->_ss->setExpirationSeconds(999999);
	}
	
	//Tao thong cua nguoi dang nhap
	public function createInfo(){
		$auth = Zend_Auth::getInstance();
		$infoAuth = $auth->getIdentity();
		
		$this->setMemberInfo($infoAuth);
		$this->setGroupInfo($infoAuth);
		$this->setAclInfo();
	}
	
	//Huy thong tin nguoi khi logout
	public function destroyInfo(){
		$ns = new Zend_Session_Namespace('info');
		$ns->unsetAll();
	}
	
	//Thiet lap thong tin cua User khi ho login
	public function setMemberInfo($infoAuth){
		$db = Zend_Registry::get('connectDb');
		$select  = $db->select()
					  ->from('users')
					  ->where('id = ? ',$infoAuth->id,INTEGER);
		$result  = $db->fetchRow($select);	
		
		$ns = new Zend_Session_Namespace('info');
		$ns->member = $result;
				  
					  
	}
	
	//Thiet lap thong tin cua nhom chua User khi ho login
	public function setGroupInfo($infoAuth){
		$db = Zend_Registry::get('connectDb');
		$select  = $db->select()
					  ->from('user_group')
					  ->where('id = ? ',$infoAuth->group_id,INTEGER);
		$result  = $db->fetchRow($select);	
		$ns = new Zend_Session_Namespace('info');
		$ns->group = $result;
	
	}
	
	//Thiet lap thong phan quyen cua nhom
	public function setAclInfo(){
		$acl = new Zendvn_System_Acl();
		$acl->createPrivilegeArray();
		$acl->createRole();
	}
	
	//Lay thong phan quyen cua nhom
	public function getAclInfo($part = null){
		$ns = new Zend_Session_Namespace('info');
		$nsInfo = $ns->getIterator();
		
		if($part == null){
			$info = $nsInfo['acl'];
		}else{
			$info = $nsInfo['acl'];
			$info = $info[$part];
		}
		
		return $info;
	}
	
	//Lay thong tin cua user da su he thong
	public function getMemberInfo($part = null){
		$ns = new Zend_Session_Namespace('info');
		$nsInfo = $ns->getIterator();
		
		if($part == null){
			$info = $nsInfo['member'];
		}else{
			$info = $nsInfo['member'];
			$info = $info[$part];
		}
		
		return $info;
	}
	
	//Lay thong tin cua nbhom ma user da su he thong
	public function getGroupInfo($part = null){
		$ns = new Zend_Session_Namespace('info');
		$nsInfo = $ns->getIterator();
		
		if($part == null){
			$info = $nsInfo['group'];
		}else{
			$info = $nsInfo['group'];
			$info = $info[$part];
		}
		
		return $info;
		
	}
	
	//Lay tat ca cac thong tin cua user da dang nhap
	public function getInfo(){
		$ns = new Zend_Session_Namespace('info');
		$info = $ns->getIterator();
		return $info;
	}
	
	public function getLanguage($area = 'public',$part = 'interface'){
		$info = $this->_ss->language;
		$info = $info[$area][$part];
		return $info;
	}
	
	
	public function setLanguage($options = null,$arrParam = null,$area = 'public'){
		if($options ==  null){
			$lang = new Zendvn_Languages();
			$publicLang = array('interface'=>$lang->getLangDefault(),
						  		'database'=>$lang->getLangDefault());
			$adminLang = array('interface'=>$lang->getLangDefault(),
						  		'database'=>$lang->getLangDefault());
			$this->_ss->language = array('admin' => $adminLang,'public' =>$publicLang);
		}else{
			$info = $this->_ss->language;
			$info[$area][$arrParam['type']] = $arrParam['lang'];
			$this->_ss->language = $info;
		}
	}
}