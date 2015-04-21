<?php
class Products_AdminProductController extends Zendvn_Controller_Action{
//Mang tham so nhan duoc o moi Action
	protected $_arrParam;
	
	//Duong dan cua Controller
	protected $_currentController;
	
	//Duong dan cua Action chinh
	protected $_actionMain;
	
	//Thong so phan trang
	protected $_paginator = array(
									'itemCountPerPage' => 50,
									'pageRange' => 20,
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
			$ssFilter->code 	= '';
			$ssFilter->col 			= 'p.id';
			$ssFilter->order 		= 'DESC';
			$ssFilter->category_id 	= 0;
			$ssFilter->publisher 	= '';
			$ssFilter->lang 		= '';
		}
		$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
		$this->_arrParam['ssFilter']['code'] 		= $ssFilter->code;
		$this->_arrParam['ssFilter']['col'] 		= $ssFilter->col;
		$this->_arrParam['ssFilter']['order'] 		= $ssFilter->order;
		$this->_arrParam['ssFilter']['category_id'] = $ssFilter->category_id;
		$this->_arrParam['ssFilter']['publisher'] 	= $ssFilter->publisher;
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
		$this->view->Title = 'Sản phẩm :: Quản trị sản phẩm :: Danh sách';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Products :: Admin Product :: List';
		$this->view->headTitle($this->view->Title,true);
		
		$tblPublisher 			= new Zendvn_Models_Publisher();
		$this->view->Publisher 	= $tblPublisher->listItem($this->arrParam,array('task'=>'admin-add'));
		
		$tblProduct = new Zendvn_Models_Products();
		$this->view->Items = $tblProduct->listItem($this->_arrParam, array('task'=>'admin-list'));
		$totalItem  = $tblProduct->countItem($this->_arrParam);
		
		$Category = new Zendvn_Models_Menus();
		$this->view->tblGroupCategory = $Category->itemInSelectbox($this->_arrParam, array('task'=>'products'));

		
		$paginator = new Zendvn_Paginator();
		$this->view->panigator = $paginator->createPaginator($totalItem,$this->_paginator);
	}
	public function filterAction(){
		$ssFilter = new Zend_Session_Namespace($this->_namespace);
		if($this->_arrParam['type'] == 'search'){
			if($this->_arrParam['key'] == 1){
				$ssFilter->keywords 	= trim($this->_arrParam['keywords']);
				$ssFilter->publisher    = trim($this->_arrParam['publisher']);
				$ssFilter->code    		= trim($this->_arrParam['code']);
			}else{
				$ssFilter->keywords = '';
				$ssFilter->publisher = '';
				$ssFilter->code = '';
			}
		}		
		if($this->_arrParam['type'] == 'order'){
			$ssFilter->col = $this->_arrParam['col'];
			$ssFilter->order = $this->_arrParam['by'];
		}
		if($this->_arrParam['type'] == 'cat'){
			$ssFilter->category_id  	= $this->_arrParam['category_id'];
			$ssFilter->order     		= $this->_arrParam['by'];
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
		$tblPublisher 			= new Zendvn_Models_Publisher();
		$this->view->Publisher 	= $tblPublisher->listItem($this->arrParam,array('task'=>'admin-add'));
		
		$tblUnits				= new Zendvn_Models_Units();
		$this->view->Units 		= $tblUnits->listItem($this->arrParam,array('task'=>'admin-add'));
		
		$this->view->Title = 'Sản phẩm :: Quản trị sản phẩm :: Thêm';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Products :: Admin Product :: Add';
		$this->view->headTitle($this->view->Title,true);	
		$tblGroupCategory = new Zendvn_Models_Menus();
		$this->view->tblGroupCategory = $tblGroupCategory->itemInSelectbox($this->_arrParam);
		$tblProduct = new Zendvn_Models_Products();
		if($this->_request->isPost()){
		$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
			$max_file_size = 1024*10000; //100 kb
			
			$path = FILES_PATH . '/photos/'; // Upload directory
			foreach ($_FILES['photos']['name'] as $f => $name) { 
					$photos[] = $name; 
				    if ($_FILES['photos']['error'][$f] == 4) {
				        continue; // Skip file if any error found
				    }	       
				    if ($_FILES['photos']['error'][$f] == 0) {	           
				        if ($_FILES['photos']['size'][$f] > $max_file_size) {
				            $message[] = "$name is too large!.";
				            continue; // Skip large files
				        }
						elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
							$message[] = "$name is not a valid format";
							continue; // Skip invalid file formats
						}
				        else{ // No error found! Move uploaded files 
                                           $resize = new Zendvn_File_ResizeImages();
				           $filename = $_FILES["photos"]["tmp_name"][$f];
				           $filename = move_uploaded_file($filename, $path.'orignal/'.$name);
                                           $resize->load($path.'orignal/'.$name);
                                           $resize->resize(85,65);
                                           $resize->save($path.'images50x50/'.$name);
                                           $resize->load($path.'orignal/'.$name);
                                           $resize->resize(440,350);
                                           $resize->save($path.'images350x350/'.$name);
				        }
				    }
			}
			$validator = new Products_Form_ValidateProduct($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$arrParam['photos'] = $photos;
				$tblProduct	->saveItem($arrParam,array('task'=>'admin-add'));
				//$this->_redirect($this->_actionMain . $lang);
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
		$tblPublisher 	= new Zendvn_Models_Publisher();
		$this->view->Publisher 	= $tblPublisher->listItem($this->arrParam,array('task'=>'admin-add'));
		
		$tblUnits   = new Zendvn_Models_Units();
		$this->view->Units = $tblUnits->listItem($this->arrParam,array('task'=>'admin-add'));
		
		$this->view->Title = 'Sản phẩm :: Quản trị sản phẩm :: Sửa';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Products :: Admin Product :: Edit';
		$this->view->headTitle($this->view->Title,true);
		$tblGroupCategory = new Zendvn_Models_Menus();
		$this->view->tblGroupCategory = $tblGroupCategory->itemInSelectbox($this->_arrParam);
		$tblProduct = new Zendvn_Models_Products();
		$this->view->Item = $tblProduct->getItem($this->_arrParam,array('task'=>'admin-edit'));
		if(!empty($this->view->Item['photos'])){
			$curPhoto	= json_decode($this->view->Item['photos']);
		}
		if($this->_request->isPost()){
			$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
			$max_file_size = 1024*10000; //100 kb
			
			$path = FILES_PATH . '/photos/'; // Upload directory
			foreach ($_FILES['photos']['name'] as $f => $name) { 
					$photos[] = $name; 
				    if ($_FILES['photos']['error'][$f] == 4) {
				        continue; // Skip file if any error found
				    }	       
				    if ($_FILES['photos']['error'][$f] == 0) {	           
				        if ($_FILES['photos']['size'][$f] > $max_file_size) {
				            $message[] = "$name is too large!.";
				            continue; // Skip large files
				        }
						elseif( ! in_array(pathinfo($name, PATHINFO_EXTENSION), $valid_formats) ){
							$message[] = "$name is not a valid format";
							continue; // Skip invalid file formats
						}
				        else{ // No error found! Move uploaded files 
                                           $resize = new Zendvn_File_ResizeImages();
				           $filename = $_FILES["photos"]["tmp_name"][$f];
				           $filename = move_uploaded_file($filename, $path.'orignal/'.$name);
                                           $resize->load($path.'orignal/'.$name);
                                           $resize->resize(85,65);
                                           $resize->save($path.'images50x50/'.$name);
                                           $resize->load($path.'orignal/'.$name);
                                           $resize->resize(440,350);
                                           $resize->save($path.'images350x350/'.$name);
				        }
				    }
			}
			$validator = new Products_Form_ValidateProduct($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$arrParam['photos'] = $photos;
				$arrParam['curPhoto'] = $curPhoto;
				$tblProduct	->saveItem($arrParam,array('task'=>'admin-edit'));
				$this->_redirect($this->_actionMain . $lang);
			}
		}
	}
	public function deletePhotoAction(){
		$this->_helper->layout()->disableLayout();
		$tblCollection = new Zendvn_Models_Products();
		$task 		= $_POST['type'];
		$id			= $_POST['id'];
		$name_photo	= $_POST['name_photo'];
		$item 		=  $tblCollection->getItem($this->_arrParam,array('task'=>$task,'id'=>$id));
		$photos		= json_decode($item['photos']);
		foreach ($photos as $key => $value) {
			if($value != $name_photo){
				$newPhotos[] = $value;
			}
		}
		$tblCollection->deleteItem($this->_arrParam,array('task'=>$task,'id'=>$id,'photos'=>$photos));
		$tblCollection->saveItem($this->_arrParam,array('task'=>$task,'id'=>$id,'photos'=>$newPhotos));
	}
	public function deleteAction(){
		$this->view->Title = 'Products :: Admin Product :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost())
		{
			$tblProduct = new Zendvn_Models_Products();
			$tblProduct->deleteItem($this->_arrParam,array('task'=>'admin-delete'));
			$this->_redirect($this->_actionMain);
		}		
	}
	public function multiDeleteAction(){		
		if($this->_request->isPost()){
			$tblProduct = new Zendvn_Models_Products();
			$tblProduct->deleteItem($this->_arrParam,array('task'=>'admin-multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
	public function sortAction(){
		$tblUser = new Zendvn_Models_Products();
		$tblUser ->sortItem($this->_arrParam,array('column'=>'order'));
		$tblUser ->sortItem($this->_arrParam,array('column'=>'menu_id'));
		$tblUser ->sortItem($this->_arrParam,array('column'=>'price'));
		$tblUser ->sortItem($this->_arrParam,array('column'=>'selloff'));
		$this->_redirect($this->_actionMain);
		$this ->_helper->viewRenderer->setNoRender();
	}
	public function statusAction(){
		$tblProduct = new Zendvn_Models_Products();
		$tblProduct->changeStatus($this->_arrParam,array('task'=>'status'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function specialAction(){
		$tblProduct = new Zendvn_Models_Products();
		$tblProduct->changeSpecial($this->_arrParam,array('task'=>'special'));
		$this->_helper->viewRenderer->setNoRender();
	}
	public function featuredAction(){
		$tblNews = new Zendvn_Models_Products();
		$tblNews->changeFeatured($this->_arrParam,array('task'=>'featured'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function favoritesAction(){
		$tblNews = new Zendvn_Models_Products();
		$tblNews->changeFavorites($this->_arrParam,array('task'=>'favorites'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function infoAction(){
		$this->view->Title = 'Sản phẩm :: Quản trị sản phẩm :: Thông tin';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Products :: Admin Product :: Information';
		$this->view->headTitle($this->view->Title,true);
		$tblCategory = new Zendvn_Models_Products();
		$this->view->Item = $tblCategory->getItem($this->_arrParam,array('task'=>'admin-info'));
		$menu_id	= $this->view->Item['menu_id'];
		$tblGroupCategory 	= new Zendvn_Models_Menus();
		$tblMenu			= $tblGroupCategory->getItem($this->_arrParam, array('task'=>'info','menu_id'=>$menu_id));
		$this->view->menu	= $tblMenu['name'];
	}
	
}	
