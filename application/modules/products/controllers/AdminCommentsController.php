<?php
class Products_AdminCommentsController extends Zendvn_Controller_Action{
	
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 8,
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
							 
		$this->_paginator['currentPage'] = $this->_request->getParam('page',1);
		$this->_arrParam['paginator'] = $this->_paginator;
		
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
		$this->view->Title = 'Bình luận sản phẩm :: Quản lý bình luận :: Danh sách';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Comments products :: Admin Comments :: List';
		$this->view->headTitle($this->view->Title,true);		
		$comment = new Zendvn_Models_CommentsProducts();
        $this->view->Items = $comment->listItem($this->_arrParam, array('task'=>'admin-list'));
		$totalItem  = $comment->countItem($this->_arrParam);
				
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
		$this->_redirect($this->_actionMain);
		$this->_helper->viewRenderer->setNoRender();
	}	
	
	public function editAction(){
		$tmpLang = $this->_arrParam['ssFilter']['lang'];
		$lang ='';		
		if(!empty($tmpLang)){
			$lang = '/lang/' . $tmpLang;
		}
		$this->view->Title = 'Bình luận sản phẩm :: Quản lý bình luận :: Sửa';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Comments products :: Admin Comments :: Edit';
		$this->view->headTitle($this->view->Title,true);
		$comment = new Zendvn_Models_CommentsProducts();
		$this->view->Item = $comment -> getItem($this->_arrParam, array('task'=>'admin-edit'));
		if($this->_request->isPost()){
			$comment -> saveItem($this->_arrParam,array('task'=>'admin-edit'));
			$this->_redirect($this->_actionMain . $lang);
		}
	}	
	public function infoAction(){
		$this->view->Title = 'Comments Products :: Admin Comments :: Information';
		$this->view->headTitle($this->view->Title,true);
		$comment = new Zendvn_Models_CommentsProducts();
		$this->view->Item = $comment->getItem($this->_arrParam,array('task'=>'admin-info'));
	}
	public function statusAction(){	
		$comment = new Zendvn_Models_CommentsProducts();
		$comment -> changeStatus($this->_arrParam);
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function deleteAction(){
		$this->view->Title = 'Comments Products :: Admin Comments :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost())
		{
			$comment = new Zendvn_Models_CommentsProducts();
			$comment -> deleteItem($this->_arrParam,array('task'=>'admin-delete'));
			$this->_redirect($this->_actionMain);
		}		
	}
	
	public function multiDeleteAction(){		
		if($this->_request->isPost()){
			$comment = new Zendvn_Models_CommentsProducts();
			$comment -> deleteItem($this->_arrParam,array('task'=>'admin-multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
	
	public function sortAction(){
		$comment = new Zendvn_Models_CommentsProducts();
		$comment -> sortItem($this->_arrParam,array('column'=>'order'));
		$this->_redirect($this->_actionMain);
		$this->_helper->viewRenderer->setNoRender();
	}
}




