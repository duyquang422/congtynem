<?php
class IndexController extends Zendvn_Controller_Action {
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
	   //$this->_forward('index','index','news');
           //data product
	   $tblPro		= new Zendvn_Models_Products();
	   $this->view->Items	= $tblPro->listItem($this->_arrParam,array('task'=>'new-product'));
           $this->view->highLightsProduct = $tblPro->listItem($this->_arrParam,array('task'=>'highlights-product'));
	   $this->view->nemcaosuProduct = $tblPro->listItem($this->_arrParam,array('task'=>'nemcaosu-product'));
	   $title 				= str_replace("\\"," ",$this->view->menu['name']);
           
           //get product in cart
           $yourCart = new Zend_Session_Namespace('cart');
           $ssInfo = $yourCart->getIterator();
           $tblPricePro = new Zendvn_Models_PricePro();
            $this->_arrParam['cart'] = $ssInfo['cart'];
            $this->view->cart = $ssInfo['cart'];
            $this->view->cartProduct = $tblPricePro->listItem($this->_arrParam, array('task' => 'view-cart'));
           
           //get Images Slide
           $image = new Zendvn_Models_SlideImage();
	   $this->view->image	= $image->listItem(1);
           
           //data menu sidebar
           $category = new Zendvn_Models_Menus();
           $this->view->menu = $category->listItem($this->_arrParam);
           
           
           //seo
	   if(!empty($this->view->menu['title_seo'])){
	   		$title 		= str_replace("\\"," ",$this->view->menu['title_seo']);
	   }
	   $description 	= str_replace("\\"," ",$this->view->menu['description_html']);
	   $keywords	 	= str_replace("\\"," ",$this->view->menu['keywords_html']);
	   
	   $this->view->headTitle($title,true);
	   
	   if(!empty($description)) $this->view->headMeta(true)->setName('description',$description);
	   
	   if(!empty($keywords)) $this->view->headMeta(true)->setName('keywords',$keywords);
                $info = new Zendvn_System_Info();
                $this->view->userInfo = $info->getInfo();
            if($this->_request->isPost()){
			$validator = new Default_Form_ValidateSlideProduct($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$tblGroup = new Zendvn_Models_SlideImage();
				$arrParam = $validator->getData(array('upload'=>true));
				$tblGroup->saveItem($arrParam,1,array('task'=>'admin-edit'));
				$this->_redirect();
			}
		}
	}
	public function rssAction() {
		$tblProduct = new Zendvn_Models_ProItem();
		$this->view->Items = $tblProduct->listItem($this->_arrParam,array('task'=>'public-index'));	
		$this->_helper->layout()->disableLayout(); 
	}
	public function aboutAction() {	
		$tblAbout = new Zendvn_Models_About();
		$this->view->Items = $tblAbout->listItem($this->_arrParam,array('task'=>'public-index'));
	   	
		$tblMenu	= new Zendvn_Models_Menus();
	    $this->view->menu	= $tblMenu->listItem($this->_arrParam,array('task'=>'about'));
	    $title 				= str_replace("\\"," ",$this->view->menu['name']);
	    if(!empty($this->view->menu['title_seo'])){
	   		$title 		= str_replace("\\"," ",$this->view->menu['title_seo']);
	    }
	    $description 	= str_replace("\\"," ",$this->view->menu['description_html']);
	    $keywords	 	= str_replace("\\"," ",$this->view->menu['keywords_html']);
	    $this->view->headTitle($title,true);
	    if(!empty($description)) $this->view->headMeta(true)->setName('description',$description);
	    if(!empty($keywords)) $this->view->headMeta(true)->setName('keywords',$keywords);
	}
	public function aboutDetailAction() {	
		$tblAbout = new Zendvn_Models_About();
		$this->view->Item = $tblAbout->getItem($this->_arrParam,array('task'=>'admin-info'));
		$this->view->Title = str_replace("\\","",$this->view->Item['title']);
		if (!empty($this->view->Item['title_seo'])) $this->view->Title = str_replace("\\"," ",$this->view->Item['title_seo']);
		$this->view->headTitle($this->view->Title,true);
		$description 	= str_replace("\\"," ",$this->view->Item['description_html']);
		if(!empty($description)) $this->view->headMeta(true)->setName('description',$description);
	}
	public function helpAction() {	
		$tblHelp = new Zendvn_Models_Help();
		$this->view->Item = $tblHelp->getItem($this->_arrParam,array('task'=>'admin-edit')); 
	   	$this->view->Title = $this->view->Item['title'];
	   	$this->view->headTitle($this->view->Title,true);
	}
	public function viewAction() {
		$template_path = TEMPLATE_PATH . "/public/system";
		$this->loadTemplate($template_path,'template.ini','template');
	}	
	public function contactAction(){
		$this->view->Title = 'Liên hệ';
		$this->view->headTitle($this->view->Title,true);
		$captcha = new Zendvn_Captcha_Image();
		//9.Truy gia tri cua CAPTCHA ra VIEW
		$this->view->captcha = $captcha->render($this->view);
		$this->view->captcha_id = $captcha->getId();
		
		if($this->_request->isPost()){
			$captchaID = $this->_arrParam['captchaID'];		
			$validator = new Default_Form_ValidateContact($this->_arrParam);
			if($validator->isError() == true){				
				$this->view->messageError = $validator->getMessageError();
				$this->view->Item = $validator->getData();		
			}
			else{
				$arrParam = $validator->getData();
				// Gui email
				$mail = new Zendvn_Mail();
				$success = $mail->sendContact($arrParam,null);
				if($success){
					$this->_helper->flashMessenger->addMessage('Chúng tôi đã nhận được liên hệ của bạn. Chúng tôi sẽ gửi email hồi đáp trong vòng 24h nữa. Chúc bạn một ngày tốt đẹp.');
					$this->_helper->_redirector('contact');
				}else{
					$this->_helper->flashMessenger->addMessage('Lỗi! Không thể gửi email được, vui lòng liên hệ BQT để được trợ giúp!');
					$this->_helper->_redirector('contact');
				}
			}
			$captcha->removeImg($captchaID);
		}
		$this->view->messages = $this->_helper->flashMessenger->getMessages();
		$captcha->removeImg($this->view->captcha_id,array('exception'=>true));
	}
	public function captchaImageAction(){
		$this->_helper->layout->disableLayout();
		$captcha = new Zendvn_Captcha_Image();
		$captchaID = $this->_request->getParam('captchaID',0);
		$captcha->removeImg($captchaID);
				
		$this->view->captcha = $captcha->render($this->view);
		$this->view->captcha_id = $captcha->getId();
	}
	
	public function questionsAction(){
		$this->view->Title = 'Gửi câu hỏi';
		$this->view->headTitle($this->view->Title,true);
		
		if($this->_request->isPost()){
			$validator = new Default_Form_ValidateQuestions($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$tblQuestion = new Zendvn_Models_Questions();
				$arrParam = $validator->getData(array('upload'=>true));
				$tblQuestion -> saveItem($arrParam,array('task'=>'new'));
				$this->_redirect($this->_currentController . '/questions/status/success');
				
			}
		}
		//header("Location: http://dulichsacmau.com");
	}
	
	public function questionsAnswersAction(){
		$this->view->Title = 'Chia sẻ';
		$this->view->headTitle($this->view->Title,true);
		$tblQuestions = new Zendvn_Models_Questions();
		
		$this->view->Items = $tblQuestions->listItem($this->_arrParam, array('task'=>'index'));
		$totalItem  = $tblQuestions->countItem($this->_arrParam);		
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}
	
	public function answersDetailAction(){
		$tblQuestions  	= new Zendvn_Models_Questions();
		$tblAnswers	 	= new Zendvn_Models_Answers();
		$tblUser		= new Zendvn_Models_Users();
		$this->view->Answer = $tblAnswers->listItem($this->_arrParam, array('task'=>'answer'));
		$this->view->Item 	= $tblQuestions->getItem($this->_arrParam, array('task'=>'admin-edit'));
		$this->view->User 	= $tblQuestions->listItem($this->_arrParam, array('task'=>'detail'));
		
		$this->view->Title = $this->view->Item['title'];
		$this->view->headTitle($this->view->Title,true);
		
	}
        public function uploadAjaxAction() {
            $this->_helper->layout->disableLayout();
            $this->_helper->viewRenderer->setNoRender();
            $imgUrl = TEMPLATE_PATH .'/public/system/images/';
        if ($_FILES["file"]["error"] > 0) {
            echo "Error: " . $_FILES["file"]["error"] . "<br>";
        } else {
            echo "Upload: " . $_FILES["file"]["name"] . "<br>";
            echo "Type: " . $_FILES["file"]["type"] . "<br>";
            echo "Size: " . ($_FILES["file"]["size"] / 1024) . " kB<br>";
            echo "Stored in: " . $_FILES["file"]["tmp_name"];

            // Save file
            move_uploaded_file($_FILES["file"]["tmp_name"], $imgUrl . $_FILES["file"]["name"]);
            echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
        }
    }
    public function testAction(){
        $this->_helper->layout->disableLayout();
//        $this->_helper->viewRenderer->setNoRender();
        if($this->_request->isPost()){
            echo '<pre>';
            print_r($this->_arrParam);
            echo '</pre>';
			$validator = new Default_Form_ValidateSlideProduct($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$tblGroup = new Zendvn_Models_slideImage();
				$arrParam = $validator->getData(array('upload'=>true));
                                $this->view->Item	= $validator->getData();
				$tblGroup->saveItem($arrParam,1,array('task'=>'admin-edit'));
				//$this->_redirect();
			}
		}
    }
    public function infoUserFacebookAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $app_id = "237595173077700";
        $app_secret = "ed61d15b704c6e4479e8b4e09a22756e";
        $redirect_uri = urlencode("http://congtynem.com/vn/default/index/info-user-facebook"); 
        
        $code = $_GET['code'];
        $facebook_access_token_uri = "https://graph.facebook.com/oauth/access_token?client_id=$app_id&redirect_uri=$redirect_uri&client_secret=$app_secret&code=$code";    
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, $facebook_access_token_uri);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

        $response = curl_exec($ch); 
        curl_close($ch);
        
        $access_token = str_replace('access_token=', '', explode("&", $response));
        $ch = curl_init(); 
        curl_setopt($ch, CURLOPT_URL, "https://graph.facebook.com/me?access_token=$access_token[0]");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);    

        $response = curl_exec($ch); 
        curl_close($ch);

        $user = json_decode($response);
        $session = new Zend_Session_Namespace('facebookInfoUser');
        $session->facebookInfoUser = $user;
        $this->_redirect();
    }
    public function logoutFacebookAction(){
        $this->_helper->layout->disableLayout();
        $this->_helper->viewRenderer->setNoRender();
        $session = new Zend_Session_Namespace('facebookInfoUser');
        unset($session->facebookInfoUser);
        $this->_redirect();
    }
}
