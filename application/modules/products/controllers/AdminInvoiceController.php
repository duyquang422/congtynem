<?php
class Products_AdminInvoiceController extends Zendvn_Controller_Action{
	
	//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
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
		$this->view->Title = 'Đơn hàng :: Quản lý đơn hàng :: Danh sách';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Invoice :: Admin Invoice :: List';
		$this->view->headTitle($this->view->Title,true);		
		$tblInvoice = new Zendvn_Models_InvoiceDetail();
		$this->view->Items = $tblInvoice->listItem($this->_arrParam, array('task'=>'admin-list'));
	}
	public function deleteAction(){
		$this->view->Title = 'Invoice :: Admin Invoice :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost())
		{
			$tblInvoice = new Zendvn_Models_InvoiceDetail();
			$tblInvoice->deleteItem($this->_arrParam,array('task'=>'admin-delete'));
			$this->_redirect($this->_actionMain);
		}		
	}
	public function multiDeleteAction(){		
		if($this->_request->isPost()){
			$tblInvoice = new Zendvn_Models_InvoiceDetail();
			$tblInvoice->deleteItem($this->_arrParam,array('task'=>'admin-multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
	public function infoAction(){
		$this->view->Title = 'Invoice :: Admin Invoice :: Information';
		$this->view->headTitle($this->view->Title,true);
		$tblInvoice = new Zendvn_Models_InvoiceDetail();
		$this->view->Item = $tblInvoice->listItem($this->_arrParam,array('task'=>'admin-info'));
		$tblCategory = new Zendvn_Models_Menus();
		$this->view->tblCategory = $tblCategory->itemInSelectbox();
		
		$this->_arrParam['Item'] = $this->view->Item;
		$tblHits = $tblInvoice->saveItem($this->_arrParam,array('task'=>'admin-info'));
	}
}




