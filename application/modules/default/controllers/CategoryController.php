<?php
class CategoryController extends Zendvn_Controller_Action {
	//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 20,
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
			$ssFilter->keywords 	= '';
		}
		$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
		
		
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
        public function indexAction() {
            $this->_helper->layout->setLayout('category');
            //lấy thông tin người đăng bài
            //Hiển thị chi tiết sản Phẩm
            $tblProduct = new Zendvn_Models_ProItem();
            $this->view->Items = $tblProduct->category($this->_arrParam['id']);
            
                //SEO
                $tblcat = new Zendvn_Models_Menus();
		$menu	= $tblcat->listItem($this->_arrParam,array('task'=>'products'));
		$this->view->Title	= str_replace("\\","",$menu['name']);
		$title_seo	= $this->view->Title;
		if(!empty($menu['title_seo'])) $title_seo = str_replace("\\","",$menu['title_seo']);
		$this->view->headTitle($title_seo,true);
		if (!empty($this->_arrParam['publisher'])){
			$pub_name				= $publisher['name'];
			//$this->view->Publisher	= str_replace("\\","",$pub_name);
			$this->view->Title		= str_replace("\\","",$menu['name']);
			$title_seo				= $this->view->Title;
			if(!empty($menu['title_seo'])) $title_seo = str_replace("\\","",$menu['title_seo']);
			$this->view->headTitle($pub_name . ' | ' .$title_seo,true);
		}
		$description = str_replace("\\","",$menu['description_html']);
		$keywords	 = str_replace("\\","",$menu['keywords_html']);
		if(!empty($description))$this->view->headMeta(true)->setName('description',$description);
		if(!empty($keywords))$this->view->headMeta(true)->setName('keywords',$keywords);
        }
        public function filterAjaxAction(){
            $this->_helper->layout->disableLayout();
            $product = new Zendvn_Models_ProItem();
            $this->view->Items = $product->filterAjax($this->_arrParam);
            }       
}