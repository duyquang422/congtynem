<?php
class Products_AdminSizeController extends Zendvn_Controller_Action{
//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 10,
									'pageRange' => 3,
								  ); 
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
			$ssFilter->col 			= 's.id';
			$ssFilter->order 		= 'DESC';
			$ssFilter->lang 		= '';
		}
		$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
		$this->_arrParam['ssFilter']['col'] 		= $ssFilter->col;
		$this->_arrParam['ssFilter']['order'] 		= $ssFilter->order;	
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
		$this->view->Title = 'Quy cách :: Quản lý quy cách :: Danh sách';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Size :: Admin Size :: List';
		$this->view->headTitle($this->view->Title,true);		
		
		$tblSize = new Zendvn_Models_Size();
		$this->view->Items = $tblSize->listItem($this->_arrParam, array('task'=>'admin-list'));		
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
		$this->_redirect($this->_actionMain);
		$this->_helper->viewRenderer->setNoRender();
	}
	public function addAction(){
		$tmpLang = $this->_arrParam['ssFilter']['lang'];
		$lang ='';		
		if(!empty($tmpLang)){
			$lang = '/lang/' . $tmpLang;
		}
		$this->view->Title = 'Quy cách :: Quản lý quy cách :: Thêm mới';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Size :: Admin Size :: Add';
		$this->view->headTitle($this->view->Title,true);
		$tblSize = new Zendvn_Models_Size();			
		if($this->_request->isPost()){
			$validator = new Products_Form_ValidateSize($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$tblSize	->saveItem($arrParam,array('task'=>'admin-add'));
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
		$this->view->Title = 'Quy cách :: Quản lý quy cách :: Sửa';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Size :: Admin Size :: Edit';
		$this->view->headTitle($this->view->Title,true);
		$tblSize = new Zendvn_Models_Size();
		$this->view->Item = $tblSize->getItem($this->_arrParam,array('task'=>'admin-edit'));
		if($this->_request->isPost()){
			$validator = new Products_Form_ValidateSize($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$tblSize	->saveItem($arrParam,array('task'=>'admin-edit'));
				$this->_redirect($this->_actionMain . $lang);
			}
		}
	
	}
	public function deleteAction(){
		$this->view->Title = 'Size :: Admin Size :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost())
		{
			$tblSize = new Zendvn_Models_Size();
			$tblSize->deleteItem($this->_arrParam,array('task'=>'admin-delete'));
			$this->_redirect($this->_actionMain);
		}		
	}
	public function multiDeleteAction(){		
		if($this->_request->isPost()){
			$tblSize = new Zendvn_Models_Size();
			$tblSize->deleteItem($this->_arrParam,array('task'=>'admin-multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
	public function sortAction(){
		$tblUser = new Zendvn_Models_Size();
		$tblUser ->sortItem($this->_arrParam,array('column'=>'order'));
		$tblUser ->sortItem($this->_arrParam,array('column'=>'units'));
		$this->_redirect($this->_actionMain);
		$this ->_helper->viewRenderer->setNoRender();
	}
	public function statusAction(){
		$tblSize = new Zendvn_Models_Size();
		$tblSize->changeStatus($this->_arrParam,array('task'=>'status'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	
}	
