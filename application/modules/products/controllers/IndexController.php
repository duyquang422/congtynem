<?php
class Products_IndexController extends Zendvn_Controller_Action{
	
	//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 40,
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
		$ssFilter = new Zend_Session_Namespace();
		//$ssFilter->unsetAll();
		if(empty($ssFilter->col)){
			$ssFilter->lang 		= '';
		}
		$this->_arrParam['ssFilter']['lang'] 		= $this->_arrParam['lang'];
		$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
		$this->_arrParam['ssFilter']['pubid'] 		= $ssFilter->pubid;
		$this->_arrParam['ssFilter']['menu_id'] 	= $ssFilter->menu_id;
		
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
		if (!empty($this->_arrParam['publisher'])){
			$tblPublisher	= new Zendvn_Models_Publisher();
			$publisher		= $tblPublisher -> listItem($this->_arrParam,array('task'=>'products'));
			$this->view->Publisher	= $publisher;
			$this->_arrParam['publisher']	= $publisher['name'];
		}
		$tblProduct = new Zendvn_Models_ProItem();
		$this->view->Items = $tblProduct->listItem($this->_arrParam,array('task'=>'public-index'));
		$this->view->total = $tblProduct->countItem($this->_arrParam,array('task'=>'public-index'));		
		$totalItem  = $tblProduct->countItem($this->_arrParam,array('task'=>'public-index'));
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
                
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
	public function proAction(){
		 $this->_helper->layout()->disableLayout(); 
		 $tblProduct = new Zendvn_Models_ProItem();
		 $task = $_POST['type'];
		 $cid	= $_POST['cid'];
		 $tblProduct = new Zendvn_Models_ProItem();
		 $this->view->Items = $tblProduct->listItem($this->_arrParam,array('task'=>$task,'cid'=>$cid));
	}
        public function listProductAction(){
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $tblProduct = new Zendvn_Models_ProItem();
            $listProduct = $tblProduct->listProduct($this->_arrParam);
            echo Zend_Json::encode($listProduct);
        }
	public function filterAction(){
		$ssFilter = new Zend_Session_Namespace();
		
		if($this->_arrParam['type'] == 'search'){			
		if($this->_arrParam['key'] == 1){
				$ssFilter->keywords = trim($this->_arrParam['keywords']);
				$ssFilter->menu_id 	= trim($this->_arrParam['menu_id']);
			}else{
				$ssFilter->keywords = '';
				$ssFilter->menu_id 	= '';
			}
		}		
		$this->_redirect($this->_actionMain);
		$this->_helper->viewRenderer->setNoRender();
	}
	public function categoryAction(){
		if (!empty($this->_arrParam['pid'])){
			$tblPublisher			= new Zendvn_Models_Publisher();
			$publisher				= $tblPublisher -> listItem($this->_arrParam,array('task'=>'products'));
			$this->view->Publisher	= $publisher;
			$this->_arrParam['publisher']	= $publisher['name'];
		}
		
		$tblProduct = new Zendvn_Models_ProItem();
		$this->view->Items = $tblProduct->listItem($this->_arrParam,array('task'=>'public-category'));
		
		$tblcat = new Zendvn_Models_Menus();
		$menu	= $tblcat->getItem($this->_arrParam,array('task'=>'pro'));
		
		$this->view->Title	= str_replace("\\","",$menu['name']);
		$this->view->Summary	= str_replace("\\","",$menu['summary']);
		$title_seo	= $this->view->Title;
		if(!empty($menu['title_seo'])) $title_seo = str_replace("\\","",$menu['title_seo']);
		$this->view->headTitle($title_seo,true);
		
		if (!empty($this->_arrParam['pid'])){
			$pub_name				= $publisher['name'];
			//$this->view->Publisher	= str_replace("\\","",$pub_name);
			$this->view->Title		= str_replace("\\","",$menu['name']);
			$this->view->Summary	= str_replace("\\","",$menu['summary']);
			$title_seo				= $this->view->Title;
			if(!empty($menu['title_seo'])) $title_seo = str_replace("\\","",$menu['title_seo']);
			$this->view->headTitle($pub_name . ' | ' .$title_seo,true);
		}
		
		$description = str_replace("\\","",$menu['description_html']);
		$keywords	 = str_replace("\\","",$menu['keywords_html']);
		if(!empty($description))$this->view->headMeta(true)->setName('description',$description);
		if(!empty($keywords))$this->view->headMeta(true)->setName('keywords',$keywords);
		
//		$menu = $tblcat->listItem($this->_arrParam,array('task'=>'find-category'));

		$this->view->total = $tblProduct->countItem($this->_arrParam,array('task'=>'public-category'));		
		$totalItem  = $tblProduct->countItem($this->_arrParam,array('task'=>'public-category'));
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}	
	public function detailAction(){
		$tblDetail = new Zendvn_Models_ProItem();
		$this->view->Item = $tblDetail->getItem($this->_arrParam,array('task'=>'public-detail'));
		$code_pro	= $this->view->Item['code'];
		$tblPrice	= new Zendvn_Models_PricePro();
		$this->view->Price_pro	= $tblPrice->listItem($this->_arrParam,array('task'=>'detail','code_detail'=>$code_pro));
		
		$menu_id	= $this->view->Item['menu_id'];
		$tblcat = new Zendvn_Models_Menus();
		$menu	= $tblcat->getItem($this->_arrParam,array('task'=>'detail','id'=>$menu_id));
		$this->view->Cat = $tblcat->getItem($this->_arrParam,array('task'=>'news-detail','menu_id'=>$menu_id));
		$this->view->menu = $menu;
		
		$this->view->Title = str_replace("\\","",$this->view->Item['name']);
		if (!empty($this->view->Item['title_seo'])) $this->view->Title = str_replace("\\"," ",$this->view->Item['title_seo']);
		$this->_arrParam['Item'] = $this->view->Item;
		$tblHits = $tblDetail->saveItem($this->_arrParam,array('task'=>'public-detail'));
		$description = str_replace("\\","",$this->view->Item['description_html']);
		$keywords	 = str_replace("\\","",$this->view->Item['keywords_html']);
		$this->view->headMeta(true)->setName('description',$description);
		$this->view->headMeta(true)->setName('keywords',$keywords);
		$this->view->headTitle($this->view->Title,true);
		
		$captcha = new Zendvn_Captcha_Image();
		//9.Truy gia tri cua CAPTCHA ra VIEW
		$this->view->captcha = $captcha->render($this->view);
		$this->view->captcha_id = $captcha->getId();
		if($this->_request->isPost()){
			$captchaID = $this->_arrParam['captchaID'];	
			$tblComment	= new Zendvn_Models_CommentsProducts();
			$validator = new Products_Form_ValidateComment($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$tblComment	->saveItem($arrParam,array('task'=>'add-comment'));
				$this->_redirect($this->_currentController . '/success');
				
			}
		}
		$captcha->removeImg($this->view->captcha_id,array('exception'=>true));
	}
	public function installmentAction(){
		$this->_helper->layout()->disableLayout();
	}
	public function orderDetailAction(){
		$tblDetail = new Zendvn_Models_ProItem();
		$this->view->Item = $tblDetail->getItem($this->_arrParam,array('task'=>'public-detail'));
		$code_pro	= $this->view->Item['code'];
		$tblPrice	= new Zendvn_Models_PricePro();
		$this->view->Price_pro	= $tblPrice->listItem($this->_arrParam,array('task'=>'detail','code_detail'=>$code_pro));
		
		$menu_id	= $this->view->Item['menu_id'];
		$tblcat = new Zendvn_Models_Menus();
		$menu	= $tblcat->getItem($this->_arrParam,array('task'=>'detail','id'=>$menu_id));
		$this->view->Cat = $tblcat->getItem($this->_arrParam,array('task'=>'news-detail','menu_id'=>$menu_id));
		$this->view->menu = $menu;
		
	}
	public function priceAction(){
		$this->view->Title = 'Bảng giá website';
		$this->view->headTitle($this->view->Title,true);
		$tblMenu				= new Zendvn_Models_Menus();
		$this->view->tblMenu 	= $tblMenu->listItem($this->_arrParam, array('task'=>'products-child'));
		
	}
	public function priceCategoryAction(){
		$tblProduct = new Zendvn_Models_Price();
		$this->view->Items = $tblProduct->listItem($this->_arrParam,array('task'=>'public-category'));
		
		$tblcat = new Zendvn_Models_Menus();
		$menu	= $tblcat->getItem($this->_arrParam,array('task'=>'pro'));
		$this->view->Title	= str_replace("\\","",$menu['name']);
		$title_seo	= $this->view->Title;
		if(!empty($menu['title_seo'])) $title_seo = str_replace("\\","",$menu['title_seo']);
		$menu = $tblcat->listItem($this->_arrParam,array('task'=>'find-category'));
		$this->view->headTitle($title_seo,true);
		$this->view->total = $tblProduct->countItem($this->_arrParam,array('task'=>'public-category'));		
		$totalItem  = $tblProduct->countItem($this->_arrParam,array('task'=>'public-category'));
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}
	public function priceDetailAction(){
		$tblDetail = new Zendvn_Models_Price();
		$this->view->Item = $tblDetail->getItem($this->_arrParam,array('task'=>'public-detail'));
		$this->view->Title = str_replace("\\","",$this->view->Item['name']);
		if (!empty($this->view->Item['title_seo'])) $this->view->Title = str_replace("\\"," ",$this->view->Item['title_seo']);
		$this->_arrParam['Item'] = $this->view->Item;
		$description = str_replace("\\","",$this->view->Item['description_html']);
		$keywords	 = str_replace("\\","",$this->view->Item['keywords_html']);
		$this->view->headMeta(true)->setName('description',$description);
		$this->view->headMeta(true)->setName('keywords',$keywords);
		$this->view->headTitle($this->view->Title,true);
	}
	public function viewCartAction(){
		$yourCart = new Zend_Session_Namespace('cart');
		if($this->_request->isPost()){
			$itemProduct = $this->_arrParam['itemProduct'];			
			if(count($itemProduct)>0)
				foreach($itemProduct as $key => $val){
					if($val == 0 ){
						unset($itemProduct[$key]);
				}
			}			
			$yourCart->cart = $itemProduct;
		}		
		$ssInfo = $yourCart->getIterator();
		$tblPricePro = new Zendvn_Models_PricePro();
		$this->_arrParam['cart'] = $ssInfo['cart'];	
			
		$this->view->Items = $tblPricePro->listItem($this->_arrParam,array('task'=>'view-cart'));
		
		$this->view->cart =  $ssInfo['cart'];
	}
	public function addItemAction(){
		$yourCart = new Zend_Session_Namespace('cart');
		$ssInfo = $yourCart->getIterator();		
		$filter = new Zend_Filter_Digits();
		$id = $filter->filter($this->_arrParam['priID']);
		//$this->_arrParam['ssFilter']['priID'] = $this->_arrParam['priID'];
		if(count($yourCart->cart) == 0){			
			$cart[$id] = 1;
			$yourCart->cart = $cart;
		}else{
			$tmp = $ssInfo['cart'];
			if(array_key_exists($id,$tmp) == true){
				$tmp[$id] = $tmp[$id] + 1;
			}else{
				$tmp[$id] = 1;
			}			
			$yourCart->cart = $tmp;			
		}
		$this->_helper->viewRenderer->setNoRender();
		$this->_redirect($this->_currentController . '/view-cart');
	}
	public function orderAction(){
		$yourCart = new Zend_Session_Namespace('cart');			
		$ssInfo = $yourCart->getIterator();		
		$tblPricePro = new Zendvn_Models_PricePro();
		$this->_arrParam['cart'] = $ssInfo['cart'];	
		$this->view->Items = $tblPricePro->listItem($this->_arrParam,array('task'=>'view-cart'));
		$this->view->cart =  $ssInfo['cart'];
		
		$info = new Zendvn_System_Info();
		$memberInfo = $info->getMemberInfo('id');
		if($memberInfo != ''){
			$tbltUser 			= new Zendvn_Models_Users();
			$this->view->User 	= $tbltUser->listItem($this->arrParam,array('user_id'=>$memberInfo,'task'=>'public'));
		}		
		if($this->_request->isPost()){
			
			$validator = new Products_Form_ValidateInvoice($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				if(count($this->view->cart) > 0){
					$tblInvoice = new Zendvn_Models_Invoice();
					$invoice_id = $tblInvoice->saveItem($this->_arrParam,array('task'=>'public-order'));			
					$tblInvoiceDetail = new Zendvn_Models_InvoiceDetail();
					$this->_arrParam['invoice_id'] = $invoice_id;
					$tblInvoiceDetail->saveItem($this->_arrParam);
					$link = $this->_actionMain . '/admin-invoice/index';
					//$mail = new Zendvn_Mail();
					//$success = $mail->sendOrder($this->_arrParam,array('link'=>$link));
					$yourCart->unsetAll();
					$this->_redirect($this->_currentController . '/note');
				}else{
					$this->_redirect($this->_currentController . '/error-cart');
				}
			}
		}
	}
	public function deleteAction(){
		$id = $this->_arrParam['id'];
		$yourCart = new Zend_Session_Namespace('cart');
		$cart = $yourCart->cart;
		unset($cart[$id]);
		$yourCart->cart = $cart;
		if(!empty($cart)){
			$this->_redirect($this->_currentController . '/view-cart');	
		}else{
			$yourCart->unsetAll();
			$this->_redirect($this->_actionMain);	
		}
	}
	public function noteAction(){
		
	}
	public function errorCartAction(){
		
	}
	
	public function commentAction(){
		$tblComments = new Zendvn_Models_CommentsProducts();
		$captcha = new Zendvn_Captcha_Image();
		//9.Truy gia tri cua CAPTCHA ra VIEW
		$this->view->captcha = $captcha->render($this->view);
		$this->view->captcha_id = $captcha->getId();		
		if($this->_request->isPost()){
			$validator = new Products_Form_ValidateComment($this->_arrParam);
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
		//header( "refresh:2","http://google.com");
	}
	
}