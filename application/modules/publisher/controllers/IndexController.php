<?php
class Services_IndexController extends Zendvn_Controller_Action{
	
	//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 12,
									'pageRange' => 4,
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
			$ssFilter->lang 		= '';
		}
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
							'content' => LANG_PATH . '/' . $language . '/admin/default.language.tmx',
							'locale' => $language,
							);
		$translate = new Zend_Translate($translate);
		Zend_Registry::set('Zend_Translate', $translate);
		
		//Truyen ra view
		$this->view->arrParam = $this->_arrParam;
		$this->view->currentController = $this->_currentController;
		$this->view->actionMain = $this->_actionMain;		
		$template_path = TEMPLATE_PATH . "/public/system";
		$this->loadTemplate($template_path,'template.ini','template');		
	}	
	public function indexAction(){	
		$tblService = new Zendvn_Models_ServiceItem();
		$this->view->Items = $tblService->listItem($this->_arrParam,array('task'=>'public-index'));	
		$this->view->total = $tblService->countItem($this->_arrParam,array('task'=>'public-index'));		
		$totalItem  = $tblService->countItem($this->_arrParam,array('task'=>'public-index'));
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
		
		$tblManage = new Zendvn_Models_Pages();
	   	$this->view->Item = $tblManage->getItem($this->_arrParam,array('task'=>'public-service'));
	   	$this->view->Title 	= $this->view->Item['title'];
	   	if(empty($this->view->Title)) $this->view->Title = 'Du lịch sắc màu';
	   	$description 	= $this->view->Item['description_html'];
	   	$keywords	 	= $this->view->Item['keywords_html'];
	   	$this->view->headTitle($this->view->Title,true);
	   	if(!empty($description)) $this->view->headMeta(true)->setName('description',$description);
	   	if(!empty($keywords)) $this->view->headMeta(true)->setName('keywords',$keywords);
	}	
	public function filterAction(){
		$ssFilter = new Zend_Session_Namespace($this->_namespace);
		if($this->_arrParam['type'] == 'search'){			
			if($this->_arrParam['key'] == 1){
				$ssFilter->keySearch = trim($this->_arrParam['keySearch']);
			}else{
				$ssFilter->keySearch = '';
			}
		}		
		$this->_redirect($this->_actionMain);
		$this->_helper->viewRenderer->setNoRender();
	}
	public function categoryAction(){
		$tblService = new Zendvn_Models_ServiceItem();
		$this->view->Items = $tblService->listItem($this->_arrParam,array('task'=>'public-category'));
		
		$tblcat = new Zendvn_Models_Menus();
		$menu	= $tblcat->getItem($this->_arrParam,array('task'=>'pro'));
		$this->view->Title	= str_replace("\\","",$menu['name']);
		$title_seo	= $this->view->Title;
		if(!empty($menu['title_seo'])) $title_seo = str_replace("\\","",$menu['title_seo']);
		$menu = $tblcat->listItem($this->_arrParam,array('task'=>'find-category'));
		$this->view->headTitle($title_seo,true);
		$this->view->total = $tblService->countItem($this->_arrParam,array('task'=>'public-category'));		
		$totalItem  = $tblService->countItem($this->_arrParam,array('task'=>'public-category'));
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}	
	public function detailAction(){		
		$tblDetail = new Zendvn_Models_ServiceItem();
		$this->view->Item = $tblDetail->getItem($this->_arrParam,array('task'=>'public-detail'));
		$this->view->Title = $this->view->Item['name'];
		$this->_arrParam['Item'] = $this->view->Item;
		$tblHits = $tblDetail->saveItem($this->_arrParam,array('task'=>'public-detail'));
		$this->view->headMeta()->appendName('description',$this->view->Item['name']);
		$this->view->headTitle($this->view->Title,true);
	}
	public function noteAction(){
		
	}
	public function errorCartAction(){
		
	}
}