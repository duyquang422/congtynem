<?php
class Units_AdminUnitsController extends Zendvn_Controller_Action{
//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 20,
									'pageRange' => 10,
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
							 
		$this->_paginator['currentPage'] = $this->_request->getParam('page',1);
		$this->_arrParam['paginator'] = $this->_paginator;
		
		//Luu cac du lieu filter vao SESSION
		//Dat ten SESSION
		$this->_namespace = $this->_arrParam['module'] . '-' . $this->_arrParam['controller'];
		$ssFilter = new Zend_Session_Namespace($this->_namespace);
		//$ssFilter->unsetAll();
		if(empty($ssFilter->col)){
			$ssFilter->keywords 	= '';
			$ssFilter->col 			= 'p.id';
			$ssFilter->order 		= 'DESC';
			$ssFilter->category_id 		= 0;
			$ssFilter->lang 		= '';
		}
		$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
		$this->_arrParam['ssFilter']['col'] 		= $ssFilter->col;
		$this->_arrParam['ssFilter']['order'] 		= $ssFilter->order;
		$this->_arrParam['ssFilter']['category_id'] = $ssFilter->category_id;
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
		$this->view->Title = 'Đơn vị phát hành :: Quản lý Đơn vị phát hành :: Danh sách';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Units Issued :: Admin Units Issued :: List';
		$this->view->headTitle($this->view->Title,true);		
		
		$tblPublisher = new Zendvn_Models_Units();
		$this->view->Items = $tblPublisher->listItem($this->_arrParam, array('task'=>'admin-list'));
		$totalItem  = $tblPublisher->countItem($this->_arrParam);
		
		
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
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
			$ssFilter->category_id  = $this->_arrParam['category_id'];
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
		$this->view->Title = 'Đơn vị phát hành :: Quản lý Đơn vị phát hành :: Thêm mới';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Units Issued :: Admin Units Issued :: Add';
		$this->view->headTitle($this->view->Title,true);	
		$tblPublisher = new Zendvn_Models_Units();			
		if($this->_request->isPost()){
			$validator = new Units_Form_ValidateUnits($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$tblPublisher	->saveItem($arrParam,array('task'=>'admin-add'));
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
		$this->view->Title = 'Đơn vị phát hành :: Quản lý Đơn vị phát hành :: Sửa';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Units Issued :: Admin Units Issued :: Edit';
		$this->view->headTitle($this->view->Title,true);
		$tblGroupCategory = new Zendvn_Models_Menus();
		$this->view->tblGroupCategory = $tblGroupCategory->itemInSelectbox($this->_arrParam, array('task'=>'Publisher'));
		$tblPublisher = new Zendvn_Models_Units();
		$this->view->Item = $tblPublisher->getItem($this->_arrParam,array('task'=>'admin-edit'));
		if($this->_request->isPost()){
			$validator = new Units_Form_ValidateUnits($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$tblPublisher	->saveItem($arrParam,array('task'=>'admin-edit'));
				$this->_redirect($this->_actionMain . $lang);
			}
		}
	}
	public function deleteAction(){
		$this->view->Title = 'Units Issued :: Admin Units Issued :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost())
		{
			$tblPublisher = new Zendvn_Models_Units();
			$tblPublisher->deleteItem($this->_arrParam,array('task'=>'admin-delete'));
			$this->_redirect($this->_actionMain);
		}		
	}
	public function multiDeleteAction(){		
		if($this->_request->isPost()){
			$tblPublisher = new Zendvn_Models_Units();
			$tblPublisher->deleteItem($this->_arrParam,array('task'=>'admin-multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
	public function sortAction(){
		$tblUser = new Zendvn_Models_Units();
		$tblUser ->sortItem($this->_arrParam,array('column'=>'order'));
		$tblUser ->sortItem($this->_arrParam,array('column'=>'menu_id'));
		$this->_redirect($this->_actionMain);
		$this ->_helper->viewRenderer->setNoRender();
	}
	public function statusAction(){
		$tblPublisher = new Zendvn_Models_Units();
		$tblPublisher->changeStatus($this->_arrParam,array('task'=>'status'));
		//$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function specialAction(){
		$tblPublisher = new Zendvn_Models_Units();
		$tblPublisher->changeSpecial($this->_arrParam,array('task'=>'special'));
		//$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function featuredAction(){
		$tblNews = new Zendvn_Models_Units();
		$tblNews->changeFeatured($this->_arrParam,array('task'=>'featured'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function infoAction(){
		$this->view->Title = 'Đơn vị phát hành :: Quản lý Đơn vị phát hành :: Thông tin';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Units Issued :: Admin Units Issued :: Information';
		$this->view->headTitle($this->view->Title,true);
		$tblCategory = new Zendvn_Models_Units();
		$this->view->Item = $tblCategory->getItem($this->_arrParam,array('task'=>'admin-info'));
		$menu_id	= $this->view->Item['menu_id'];
		$tblGroupCategory 	= new Zendvn_Models_Menus();
		$tblMenu			= $tblGroupCategory->getItem($this->_arrParam, array('task'=>'info','menu_id'=>$menu_id));
		$this->view->menu	= $tblMenu['name'];
	}
	
}	
