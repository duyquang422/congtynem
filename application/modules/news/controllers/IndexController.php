<?php
class News_IndexController extends Zendvn_Controller_Action{
	
	//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 15,
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
		$tblNews = new Zendvn_Models_NewsItem();
		$this->view->Items = $tblNews->listItem($this->_arrParam,array('task'=>'public-index'));
		$this->view->total = $tblNews->countItem($this->_arrParam,array('task'=>'public-index'));		
		$totalItem  = $tblNews->countItem($this->_arrParam,array('task'=>'public-index'));
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
		
		$tblcat = new Zendvn_Models_Menus();
		$menu	= $tblcat->listItem($this->_arrParam,array('task'=>'newss'));
		
		$this->view->Title	= str_replace("\\","",$menu['name']);
		$title_seo	= $this->view->Title;
		if(!empty($menu['title_seo'])) $title_seo = str_replace("\\","",$menu['title_seo']);
		$this->view->headTitle($title_seo,true);
		
		$description = str_replace("\\","",$menu['description_html']);
		$keywords	 = str_replace("\\","",$menu['keywords_html']);
		if(!empty($description))$this->view->headMeta(true)->setName('description',$description);
		if(!empty($keywords))$this->view->headMeta(true)->setName('keywords',$keywords);
		
	}	
	public function filterAction(){
		$ssFilter = new Zend_Session_Namespace($this->_namespace);
		if($this->_arrParam['type'] == 'search-news'){	
			if($this->_arrParam['key'] == 1){
				$ssFilter->keywords = $this->_arrParam['keywords'];
			}else{
				$ssFilter->keywords = '';
			}
		}		
		$this->_redirect($this->_actionMain);
		$this->_helper->viewRenderer->setNoRender();
	}
	public function categoryAction(){		
		$tblNews = new Zendvn_Models_NewsItem();
		$this->view->Items = $tblNews->listItem($this->_arrParam,array('task'=>'public-category'));
		$tblcat = new Zendvn_Models_Menus();
		$menu = $tblcat->listItem($this->_arrParam,array('task'=>'find-category'));
		$this->view->Category = str_replace("\\"," ",$menu['name']);
		$this->view->Title = str_replace("\\"," ",$menu['name']);
		if(!empty($menu['title_seo'])) $this->view->Title = $menu['title_seo'];
		$this->view->headTitle($this->view->Title,true);
		if(!empty($menu['description_html'])){
			$description = str_replace("\\"," ",$menu['description_html']);
			$this->view->headMeta(true)->setName('description',$description);
		}
		if(!empty($menu['keywords_html'])){
			$keywords	 = str_replace("\\"," ",$menu['keywords_html']);
			$this->view->headMeta(true)->setName('keywords',$keywords);
		}
		$totalItem  = $tblNews->countItem($this->_arrParam,array('task'=>'public-category'));
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
		$this->view->total = $tblNews->countItem($this->_arrParam,array('task'=>'public-category'));
	}
	public function detailAction(){
		$tblDetail 	= new Zendvn_Models_NewsItem();
		$this->view->Item 	 = $tblDetail->getItem($this->_arrParam,array('task'=>'public-detail'));
		$this->view->ItemCat = $tblDetail->listItem($this->_arrParam,array('task'=>'public-detail'));
		$menu_id 	= $this->view->Item['menu_id'];
		
		$tblCat		= new Zendvn_Models_Menus();
        $this->view->Cat = $tblCat->getItem($this->_arrParam,array('task'=>'news-detail','menu_id'=>$menu_id));
		$this->view->Title = str_replace("\\"," ",$this->view->Item['name']);
		if (!empty($this->view->Item['title_seo'])) $this->view->Title = str_replace("\\"," ",$this->view->Item['title_seo']);
		$this->_arrParam['Item'] = $this->view->Item;
		$tblHits = $tblDetail->saveItem($this->_arrParam,array('task'=>'public-detail'));
		$this->view->headTitle($this->view->Title,true);
		$description = $this->view->Item['description_html'];
		$keywords	 = $this->view->Item['keywords_html'];
		$this->view->headMeta(true)->setName('description',$description);
		$this->view->headMeta(true)->setName('keywords',$keywords);
		
		$captcha = new Zendvn_Captcha_Image();
		//9.Truy gia tri cua CAPTCHA ra VIEW
		$this->view->captcha = $captcha->render($this->view);
		$this->view->captcha_id = $captcha->getId();
		$captcha->removeImg($this->view->captcha_id,array('exception'=>true));
	}
	public function commentAction(){
		$tblComments = new Zendvn_Models_CommentsNews();
		$captcha = new Zendvn_Captcha_Image();
		//9.Truy gia tri cua CAPTCHA ra VIEW
		$this->view->captcha = $captcha->render($this->view);
		$this->view->captcha_id = $captcha->getId();		
		if($this->_request->isPost()){
			$validator = new News_Form_ValidateComment($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$tblComments->saveItem($arrParam,array('task'=>'add-comment'));
				//$this->_redirect($this->_currentController . '/success');
			}
			$captcha->removeImg($captchaID);
		}
		$captcha->removeImg($this->view->captcha_id,array('exception'=>true));
		$this->_helper->layout->disableLayout();		
	}
	public function successAction(){
		$this->_helper->layout->disableLayout();
	}
	
	public function advertAction(){		
		$tblAdvert = new Zendvn_Models_Advert();
		//$this->view->Item = $tblAdvert->getItem($this->_arrParam,array('task'=>'public-advert'));
		$this->view->Item = $tblAdvert->listItem($this->_arrParam,array('task'=>'public-advert'));
		$this->view->Title = $this->view->Item[0]['name'];
		$this->view->headTitle($this->view->Title,true);
		//$this->view->headMeta(true)->setName('description',$this->view->Item['name']);
	}
	public function businessAction(){
	   	$this->view->Title = 'Doanh nghiá»‡p';
	}
	public function businessCatAction(){
		$type = $this->_arrParam['type'];
		if($type == 1){
			$this->view->headTitle('Doanh nghiá»‡p tiÃªu biá»ƒu',true);
		}elseif ($type == 2){
			$this->view->headTitle('Doanh nghiá»‡p tiá»�m nÄƒng',true);
		}elseif ($type == 3){
			$this->view->headTitle('Doanh nghiá»‡p má»›i',true);
		}
		$tblBusiness = new Zendvn_Models_BusinessItem(); 
		$items = $tblBusiness->listItem($this->_arrParam,array('task'=>'public-category'));
	}
	public function uploadExelAction(){
		
	}
	public function testAction(){
		
	}
}