<?php
class AdminContactController extends Zendvn_Controller_Action{
//Mang tham so nhan duoc o moi Action
	//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_namespace;
	
	public function init(){
		//Mang tham so nhan duoc o moi Action
		$this->_arrParam = $this->_request->getParams();
		
		//Duong dan cua Controller
		$this->_currentController = '/' . $this->_arrParam['module'] 
									 . '/' . $this->_arrParam['controller'];
		
		//Duong dan cua Action chinh		
		$this->_actionMain = '/' . $this->_arrParam['module'] 
							 . '/' . $this->_arrParam['controller']	. '/index';	
		
		//Luu cac du lieu filter vao SESSION
		//Dat ten SESSION
		$this->_namespace = $this->_arrParam['module'] . '-' . $this->_arrParam['controller'];
		$ssFilter = new Zend_Session_Namespace($this->_namespace);
		//$ssFilter->unsetAll();
		if(empty($ssFilter->col)){
			$ssFilter->keywords 	= '';
			$ssFilter->lang 		= '';
		}
		$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
		$this->_arrParam['ssFilter']['lang'] 		= $this->_arrParam['lang'];
		
		/*====================================================
		 * Load Zendvn Translate for Controller
		 *====================================================*/
		/*$this->_langObj->setLangFile(array('default.language.tmx'));		
		Zend_Registry::set('Zend_Translate', $this->_langObj->generate());*/
		
		$info = new Zendvn_System_Info();
		$language = $info->getLanguage('admin');
		if(empty($language)){
			$language = 'vi';
		}
		$translate = array(
							'adapter' => 'tmx',
							'content' => LANG_PATH . '/' . $language . '/admin/menu.tmx',
							'locale' => $language,
							);
		$translate = new Zend_Translate($translate);
		Zend_Registry::set('Zend_Translate', $translate);
		
		//Truyen ra view
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;
		
		$template_path = TEMPLATE_PATH . "/admin/system";
		$this->loadTemplate($template_path,'template.ini','template');
	}
	public function indexAction(){
		$this->view->Title = 'Liên hệ :: Quản trị liên hệ :: Danh sách';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Contact :: Admin Contact :: List';
		$this->view->headTitle($this->view->Title,true);
		
		$tblContact = new Zendvn_Models_Contact();
		$this->view->Items = $tblContact->listItem($this->_arrParam, array('task'=>'admin-list'));
	}
	public function filterAction(){
		$ssFilter = new Zend_Session_Namespace($this->_namespace);
		if($this->_arrParam['type'] == 'search'){
			if($this->_arrParam['key'] == 1){
				$ssFilter->keywords = trim($this->_arrParam['keywords']);
			}else{
				$ssFilter->keywords = '';
			}
		}		
		if($this->_arrParam['type'] == 'order'){
			$ssFilter->col = $this->_arrParam['col'];
			$ssFilter->order = $this->_arrParam['by'];
		}
		if($this->_arrParam['type'] == 'cat'){
			$ssFilter->order     = $this->_arrParam['by'];
		}		
		$this->_redirect($this->_actionMain);
		$this->_helper->viewRenderer->setNoRender();
	}
	public function addAction(){
		$tmpLang = $this->_arrParam['ssFilter']['lang'];
		$lang ='';		
		if(!empty($tmpLang)){
			$lang = '/lang/' . $tmpLang;
		}
		$this->view->Title = 'Liên hệ :: Quản trị liên hệ :: Thêm mới';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Contact :: Admin Contact :: Add';
		$this->view->headTitle($this->view->Title,true);	
		$tblContact = new Zendvn_Models_Contact();			
		if($this->_request->isPost()){
			$validator = new Default_Form_ValidateInfoContact($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				
				$arrParam = $validator->getData(array('upload'=>true));
				$tblContact	->saveItem($arrParam,array('task'=>'admin-add'));
				$this->_redirect($this->_actionMain . $lang);
			}
		}
		$this->render('edit');
	}
	public function editAction(){
		$tmpLang = $this->_arrParam['ssFilter']['lang'];
		$lang ='';		
		if(!empty($tmpLang)){
			$lang = '/lang/' . $tmpLang;
		}
		$this->view->Title = 'Liên hệ :: Quản trị liên hệ :: Sửa';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Contact :: Admin Contact :: Edit';
		$this->view->headTitle($this->view->Title,true);
		$tblContact = new Zendvn_Models_Contact();
		$this->view->Item = $tblContact->getItem($this->_arrParam,array('task'=>'admin-edit'));
		if($this->_request->isPost()){
			$validator = new Default_Form_ValidateInfoContact($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$tblContact	->saveItem($arrParam,array('task'=>'admin-edit'));
				$this->_redirect($this->_actionMain . $lang);
			}
		}
	}
	public function deleteAction(){
		$this->view->Title = 'Contact :: Admin Contact :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost())
		{
			$tblContact = new Zendvn_Models_Contact();
			$tblContact->deleteItem($this->_arrParam,array('task'=>'admin-delete'));
			$this->_redirect($this->_actionMain);
		}		
	}
	public function multiDeleteAction(){		
		if($this->_request->isPost()){
			$tblContact = new Zendvn_Models_Contact();
			$tblContact->deleteItem($this->_arrParam,array('task'=>'admin-multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
	public function sortAction(){
		$tblUser = new Zendvn_Models_Contact();
		$this->_redirect($this->_actionMain);
		$this ->_helper->viewRenderer->setNoRender();
	}
	public function statusAction(){
		$tblContact = new Zendvn_Models_Contact();
		$tblContact->changeStatus($this->_arrParam,array('task'=>'status'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function specialAction(){
		$tmpLang = $this->_arrParam['ssFilter']['lang'];
		$lang ='';		
		if(!empty($tmpLang)){
			$lang = '/lang/' . $tmpLang;
		}
		$tblContact = new Zendvn_Models_Contact();
		$tblContact->changeSpecial($this->_arrParam,array('task'=>'special'));
		$this->_redirect($this->_actionMain . $lang);
		$this->_helper->viewRenderer->setNoRender();
	}
	public function featuredAction(){
		$tblContact = new Zendvn_Models_Contact();
		$tblContact->changeFeatured($this->_arrParam,array('task'=>'featured'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function infoAction(){
		$this->view->Title = 'Contact :: Admin Contact :: Information';
		$this->view->headTitle($this->view->Title,true);
		$tblCategory = new Zendvn_Models_Contact();
		$this->view->Item = $tblCategory->getItem($this->_arrParam,array('task'=>'admin-info'));
	}
	
}	
