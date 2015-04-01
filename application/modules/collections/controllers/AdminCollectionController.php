<?php
class Collections_AdminCollectionController extends Zendvn_Controller_Action{
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
			$ssFilter->col 			= 'p.id';
			$ssFilter->order 		= 'DESC';
			$ssFilter->category_id 		= 0;
			$ssFilter->lang 		= '';
		}
		$this->_arrParam['ssFilter']['keywords'] 	= $ssFilter->keywords;
		$this->_arrParam['ssFilter']['col'] 		= $ssFilter->col;
		$this->_arrParam['ssFilter']['order'] 		= $ssFilter->order;
		$this->_arrParam['ssFilter']['category_id'] = $ssFilter->category_id;
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
		$this->view->Title = 'Bộ sưu tập :: Quản trị bộ sưu tập :: Danh sách';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Collections :: Admin Collection :: List';
		$this->view->headTitle($this->view->Title,true);
		$tblCollection = new Zendvn_Models_Collections();
		$this->view->Items = $tblCollection->listItem($this->_arrParam, array('task'=>'admin-list'));
		$totalItem  = $tblCollection->countItem($this->_arrParam);
		
		$tblGroupCategory = new Zendvn_Models_Menus();
		$this->view->tblGroupCategory = $tblGroupCategory->itemInSelectbox($this->_arrParam, array('task'=>'collections'));
				
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
		if($this->_arrParam['type'] == 'cat'){
			$ssFilter->category_id  = $this->_arrParam['category_id'];
			$ssFilter->order     = $this->_arrParam['by'];
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
		
		$this->view->Title = 'Bộ sưu tập :: Quản trị bộ sưu tập :: Thêm';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Collections :: Admin Collection :: Add';
		$this->view->headTitle($this->view->Title,true);	
		$tblGroupCategory = new Zendvn_Models_Menus();
		$this->view->tblGroupCategory = $tblGroupCategory->itemInSelectbox($this->_arrParam, array('task'=>'collections'));
		$tblCollection = new Zendvn_Models_Collections();
		
		if($this->_request->isPost()){
			$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
			$max_file_size = 1024*10000; //100 kb
			
			$path = FILES_PATH . '/photos/'; // Upload directory
			$count = 0;
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
				            if(move_uploaded_file($_FILES["photos"]["tmp_name"][$f], $path.$name)) {
				            	$count++; // Number of successfully uploaded files
				            }
				        }
				    }
			}
			$validator = new Collections_Form_ValidateCollection($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$arrParam['photos'] = $photos;
				$tblCollection	->saveItem($arrParam,array('task'=>'admin-add'));
				$this->_redirect($this->_actionMain . $lang);
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
		
		$tblUnits				= new Zendvn_Models_Units();
		$this->view->Units 		= $tblUnits->listItem($this->arrParam,array('task'=>'admin-add'));
		
		$this->view->Title = 'Bộ sưu tập :: Quản trị bộ sưu tập :: Sửa';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Collections :: Admin Collection :: Edit';
		$this->view->headTitle($this->view->Title,true);
		$tblGroupCategory = new Zendvn_Models_Menus();
		$this->view->tblGroupCategory = $tblGroupCategory->itemInSelectbox($this->_arrParam, array('task'=>'collections'));
		$tblCollection = new Zendvn_Models_Collections();
		$this->view->Item = $tblCollection->getItem($this->_arrParam,array('task'=>'admin-edit'));
		if(!empty($this->view->Item['photos'])){
			$curPhoto	= json_decode($this->view->Item['photos']);
		}
		if($this->_request->isPost()){
			$valid_formats = array("jpg", "png", "gif", "zip", "bmp");
			$max_file_size = 1024*10000; //100 kb
			
			$path = FILES_PATH . '/photos/'; // Upload directory
			$count = 0;
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
				            if(move_uploaded_file($_FILES["photos"]["tmp_name"][$f], $path.$name)) {
				            	$count++; // Number of successfully uploaded files
				            }
				        }
				    }
			}
			$validator = new Collections_Form_ValidateCollection($this->_arrParam);
			if($validator->isError() == true){
				$this->view->errors = $validator->getMessageError();
				$this->view->Item	= $validator->getData();
			}else{
				$arrParam = $validator->getData(array('upload'=>true));
				$arrParam['photos'] = $photos;
				$arrParam['curPhoto'] = $curPhoto;
				
				$tblCollection	->saveItem($arrParam,array('task'=>'admin-edit'));
				$this->_redirect($this->_actionMain . $lang);
			}
		}
	}
	public function deletePhotoAction(){
		$this->_helper->layout()->disableLayout();
		$tblCollection = new Zendvn_Models_Collections();
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
		$this->view->Title = 'Collections :: Admin Collection :: Delete';
		$this->view->headTitle($this->view->Title,true);
		if($this->_request->isPost())
		{
			$tblCollection = new Zendvn_Models_Collections();
			$tblCollection->deleteItem($this->_arrParam,array('task'=>'admin-delete'));
			$this->_redirect($this->_actionMain);
		}	
		$this->_helper->viewRenderer->setNoRender();	
	}
	public function multiDeleteAction(){		
		if($this->_request->isPost()){
			$tblCollection = new Zendvn_Models_Collections();
			$tblCollection->deleteItem($this->_arrParam,array('task'=>'admin-multi-delete'));
			$this->_redirect($this->_actionMain);
		}
		$this->_helper->viewRenderer->setNoRender();
	}
	public function sortAction(){
		$tblUser = new Zendvn_Models_Collections();
		$tblUser ->sortItem($this->_arrParam,array('column'=>'order'));
		$tblUser ->sortItem($this->_arrParam,array('column'=>'menu_id'));
		$tblUser ->sortItem($this->_arrParam,array('column'=>'price'));
		$tblUser ->sortItem($this->_arrParam,array('column'=>'selloff'));
		$this->_redirect($this->_actionMain);
		$this ->_helper->viewRenderer->setNoRender();
	}
	public function statusAction(){
		$tblCollection = new Zendvn_Models_Collections();
		$tblCollection->changeStatus($this->_arrParam,array('task'=>'status'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function specialAction(){
		$tblCollection = new Zendvn_Models_Collections();
		$tblCollection->changeSpecial($this->_arrParam,array('task'=>'special'));
		$this->_helper->viewRenderer->setNoRender();
	}
	public function featuredAction(){
		$tblNews = new Zendvn_Models_Collections();
		$tblNews->changeFeatured($this->_arrParam,array('task'=>'featured'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function favoritesAction(){
		$tblNews = new Zendvn_Models_Collections();
		$tblNews->changeFavorites($this->_arrParam,array('task'=>'favorites'));
		$this->_redirect($this->_actionMain);		
		$this->_helper->viewRenderer->setNoRender();
	}
	public function infoAction(){
		$this->view->Title = 'Bộ sưu tập :: Quản trị bộ sưu tập :: Thông tin';
		if($this->_arrParam['lang'] == 'en') $this->view->Title = 'Collections :: Admin Collection :: Information';
		$this->view->headTitle($this->view->Title,true);
		$tblCategory = new Zendvn_Models_Collections();
		$this->view->Item = $tblCategory->getItem($this->_arrParam,array('task'=>'admin-info'));
		$menu_id	= $this->view->Item['menu_id'];
		$tblGroupCategory 	= new Zendvn_Models_Menus();
		$tblMenu			= $tblGroupCategory->getItem($this->_arrParam, array('task'=>'info','menu_id'=>$menu_id));
		$this->view->menu	= $tblMenu['name'];
	}
	
}	
