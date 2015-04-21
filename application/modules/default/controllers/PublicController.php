<?php
class PublicController extends Zendvn_Controller_Action{
	
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
		
		$template_path = TEMPLATE_PATH . "/login/system";
		$this->loadTemplate($template_path,'template.ini','template');
	}
	
	public function errorAction(){
		$this->view->Title = 'Message: Error!';
		$this->view->headTitle($this->view->Title,true);
		$error[] = 'Chuc nang nay khong ton tai.';
		$this->view->messageError = $error;
	}
	public function noAccessAction(){
		$this->view->Title = 'No Access';
		$this->view->headTitle($this->view->Title,true);
		$error[] = 'Ban khong quyen truy cap vao chuc nang nay.';
		$this->view->messageError = $error;
		$this->_helper->viewRenderer('error');
		$this->_redirect();
	}
	
	public function loginAction(){
                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender();
		$this->view->Title = 'Login';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isGet()){
			$yourCart = new Zend_Session_Namespace('cart');			
			$yourCart->unsetAll();
			$validator = new Default_Form_ValidateLogin($this->_arrParam);
			if($validator->isError() == true){
				$this->view->messageError = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
                                echo Zend_Json::encode($this->view->messageError);
                                
			}
                        else{
				$auth = new Zendvn_System_Auth();
				if($auth->login($this->_arrParam)){
                                        $info = new Zendvn_System_Info();
                                        $info->createInfo();
                                        echo Zend_Json::encode(array('success'=>1));
                                        
				}else{
					$error = $auth->getError();
					$this->view->messageError = $error;
                                        echo Zend_Json::encode($this->view->messageError);
				}
			}
		}
		
	}
	public function forgotPassAction(){
		$template_path = TEMPLATE_PATH . "/public/system";
		$this->loadTemplate($template_path,'template.ini','template');
		$this->view->Title = 'Quên mật khẩu';
		$this->view->headTitle($this->view->Title,true);
		
		
		if($this->_request->isPost()){
			$validator = new Default_Form_ValidateForgot($this->_arrParam);
			if($validator->isError() == true){
				$this->view->messageError = $validator->getMessageError();
				$this->view->Item = $validator->getData();
			}else{
				$tblUser	= new Zendvn_Models_Users();
				$item		= $tblUser->listItem($this->_arrParam,array('task'=>'forgot'));
				$id = $item['id'];
				$time		= time();
				$token		= md5($time);
				$this->_arrParam['token'] = $token;
				$tblUser->saveItem($this->_arrParam,array('task'=>'forgot','id'=>$id));
				// Send mail
				$mail = new Zendvn_Mail();
				$mail->mailForgotPass($this->_arrParam,null);
			}
			$this->_redirect('/default/public/forgot-pass/status/1');
		}
	}
	public function activePassAction(){
		$template_path = TEMPLATE_PATH . "/public/system";
		$this->loadTemplate($template_path,'template.ini','template');
		$this->view->Title = 'Nhập mật khẩu mới';
		$this->view->headTitle($this->view->Title,true);
		
		$tblUser	= new Zendvn_Models_Users();
		$item		= $tblUser->listItem($this->_arrParam,array('task'=>'active'));
		$this->view->email = $item['email'];
		$id = $item['id'];
		if($this->_request->isPost()){
			$validator = new Default_Form_ValidateActive($this->_arrParam);
			if($validator->isError() == true){
				$this->view->messageError = $validator->getMessageError();
				$this->view->Item = $validator->getData();
			}else{
				$tblUser->saveItem($this->_arrParam,array('task'=>'active','id'=>$id));
				$this->_redirect('/default/public/forgot-success');
			}
		}
		
	}
	public function forgotSuccessAction(){
		$template_path = TEMPLATE_PATH . "/public/system";
		$this->loadTemplate($template_path,'template.ini','template');
		$this->view->Title = 'Đổi mật khẩu thành công';
		$this->view->headTitle($this->view->Title,true);
		
	}
	public function logoutAction(){
		$this->view->Title = 'Logout';
		$this->view->headTitle($this->view->Title,true);
		$auth = new Zendvn_System_Auth();
		$auth->logout();
		
		$info = new Zendvn_System_Info();
		$info->destroyInfo();
		//$linkHome 		= $this->baseUrl('vi-trang-chu.html');
		$this->_redirect();
		
		//$this->_helper->viewRenderer('error');
	}
	
	public function registerAction(){
                $this->_helper->layout->disableLayout();
                $this->_helper->viewRenderer->setNoRender();
		if($this->_request->isGet()){
			$validator = new Default_Form_ValidateRegister($this->_arrParam);
			if($validator->isError() == true){				
				$this->view->messageError = $validator->getMessageError();
                                echo Zend_Json::encode($this->view->messageError);
			}else{
				$tblUser 	= new Zendvn_Models_Users();
				$tblUser->saveItem($this->_arrParam,array('task'=>'user-register'));
                                echo Zend_Json::encode(array('success'=>1));
			}
		}
	}
	public function editPassAction(){
		$template_path = TEMPLATE_PATH . "/public/system";
		$this->loadTemplate($template_path,'template.ini','template');
		$this->view->Title = 'Thay đổi mật khẩu';
		$this->view->headTitle($this->view->Title,true);
		
		$tblUser 			= new Zendvn_Models_Users();
		
		$info 				= new Zendvn_System_Info();
		$memberInfo 		= $info->getMemberInfo('id');
		if (!empty($memberInfo)){
			$this->view->Item	= $tblUser->getItem($this->_arrParam,array('task'=>'info','id'=>$memberInfo));
		}
		$this->_arrParam['id'] = $memberInfo;
		if($this->_request->isPost()){
			$validator = new Default_Form_ValidatePass($this->_arrParam);
			if($validator->isError() == true){				
				$this->view->messageError = $validator->getMessageError();
				$this->view->Item = $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$tblUser->saveItem($arrParam,array('task'=>'edit-pass'));
				$this->_redirect('/default/public/edit-pass/status/1');
			}
		}
	}
	public function noticeAction(){
			$template_path = TEMPLATE_PATH . "/public/system";
			$this->loadTemplate($template_path,'template.ini','template');
	}
}




