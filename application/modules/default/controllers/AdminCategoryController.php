<?php
class AdminCategoryController extends Zendvn_Controller_Action{
	
	//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array(
					'itemCountPerPage' => 20,
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
			$ssFilter->col 			= 'g.id';
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
            $this->view->Title = 'Quản Lý Chuyên Mục Hoặc Menu';
            $this->view->headTitle($this->view->Title,true);
            $category = new Zendvn_Models_Menus();
            $this->view->Items = $category->listItem($this->_arrParam);
            $totalItem  = $category->countItem($this->_arrParam);
            $paginator = new Zendvn_Paginator();
            $this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
        }
        public function statusAction(){
		$category = new Zendvn_Models_Menus();
		$category->changeStatus($this->_arrParam);
		$this->_redirect($this->_actionMain);
		$this->_helper->viewRenderer->setNoRender();
	}
        public function deleteAction(){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
		if($this->_request->isGet())
		{
			$category = new Zendvn_Models_Menus();
			$category->removeNode($this->_arrParam['id']);
			$this->_redirect($this->_actionMain);	
		}		
	}
        public function multiDeleteAction(){	
		if($this->_request->isPost()){
			$category= new Zendvn_Models_Menus();
			$category->removeNode($this->_arrParam,array('task'=>'admin-multi-delete'));
			$this->_redirect($this->_actionMain);	
		}
		$this->_helper->viewRenderer->setNoRender();
	}
        public function addAction(){
		$this->view->Title = 'Người sử dụng :: Quản lý nhóm :: Thêm mới';
		$this->view->headTitle($this->view->Title,true);
                $category = new Zendvn_Models_Menus();
                $this->view->itemSelectbox = $category->itemInSelectbox();
                if($this->_request->isPost()){
			$validator = new Default_Form_ValidateCategory($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$tblCategory = new Zendvn_Models_Menus();
				$arrParam = $validator->getData(array('upload'=>true));
                                $arrParam['brother_id'] =$this->_arrParam['brother_id'];
				$tblCategory -> insertNode($arrParam,array('position'=>'before'));
				$this->_redirect($this->_actionMain);
			}
		}
		$this->render('edit');
	}
        public function editAction(){
		$this->view->Title = 'Chỉnh Sửa Chuyên Mục';
		$this->view->headTitle($this->view->Title,true);
		$category = new Zendvn_Models_Menus();
		$this->view->Item = $category->getItem($this->_arrParam, array('task'=>'admin-edit'));
                $this->view->itemSelectbox = $category->itemInSelectbox();
		if($this->_request->isPost()){
			$validator = new Default_Form_ValidateCategory($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item   = $validator->getData();
			}else{
				$tblGroup = new Zendvn_Models_Menus();
				$arrParam = $validator->getData(array('upload'=>true));
				$tblGroup ->updateNode($arrParam);
				$this->_redirect($this->_actionMain);
			}
		}
	}
        public function moveUpAction(){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            if($this->_request->isGet()){
                $menu = new Zendvn_Models_Menus();
                $menu->moveUp($this->_arrParam['id']);
                $this->_redirect($this->_actionMain);
            }
        }
            public function moveDownAction(){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();        
            if($this->_request->isGet()){
                $menu = new Zendvn_Models_Menus();
                $menu->moveDown($this->_arrParam['id']);
                $this->_redirect($this->_actionMain);
            }
        }
}