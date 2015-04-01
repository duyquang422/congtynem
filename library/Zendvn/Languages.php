<?php
class Zendvn_Languages{
	
	protected $_path;
	
	protected $_langPath;
	
	protected $_area;
	
	protected $_lang;
	
	protected $_langFile = array();
	
	protected $_cacheObj;
	
	//private $_zAction;
	
	public function __construct($language = null,$options = null){
		//$this->_zAction = $zAction;
		
		$this->_cacheObj = Zendvn_Cache::factory(array('cache_dir'=>'/languages'));
		
		$this->setArea();
		if($options['area'] != '') $this->setArea($options['area']);
		
		$this->setPath(LANGUAGES_PATH);
		if($options['path'] != '') $this->setPath($options['path']);	
		
		if($options['langFile'] != '') $this->setLangFile($options['langFile']);
		
		if($language == nul || empty($language)){			
			$this->_lang = $this->getLangDefault();
		}else{
			$this->_lang = $language;
		}
		
		
	}
	
	public function getDataLanguage($area = 'public'){
		$info = new Zendvn_System_Info();
		$accessArea = ($area == 'public')?'public':'admin';
		return $info->getLanguage($accessArea,'database');
	}
	
	public function getInterfaceLanguage($area = 'public'){
		$info = new Zendvn_System_Info();
		$accessArea = ($area == 'public')?'public':'admin';
		return $info->getLanguage($accessArea,'interface');
	}
	
	public function getLangDefault(){
//		$db = Zend_Db_Table::getDefaultAdapter();
//		$select = $db->select()
//					 ->from('languages',array('code'))					 
//					 ->where('area = ?',$this->getArea())
//					 ->where('default_lang = 1',null,1);
//		
//		$result = $db->fetchOne($select);
//		
//		if(empty($result)){
//			$lang = APPLICATION_LANGUAGE_DEFAULT;
//		}else{
//			$lang = $result;
//		}
//		return $lang;
					
	}
	
	public function listLanguage(){
		$db = Zend_Db_Table::getDefaultAdapter();
		$select = $db->select()
					 ->from('languages',array('code','name'))
					 ->where("status = 'active'");
		$result = $db->fetchPairs($select);	
		return $result;
	}
	
	public function setLangFile($file = array()){
		$this->_langFile = $file;
	}
	
	public function getLangFile(){
		return $this->_langFile;
	}
	
	public function setArea($value = 'admin'){
		$this->_area = $value;
	}
	
	public function getArea(){
		return $this->_area;
	}
	
	public function setPath($value = null){
		$this->_path = $value;	
	}
	
	public function generate(){
		
		$this->_langPath = $this->_path . '/' . $this->_lang . '/' . $this->_area;
		$cacheName = 'lang_' . md5($this->_langPath);
		
		//if(!$this->_cacheObj->load($cacheName)){
			if(!file_exists($this->_langPath)){
				$this->_lang = APPLICATION_LANGUAGE_DEFAULT;
				$this->_langPath = $this->_path . '/' . $this->_lang . '/' . $this->_area;
			}
			
			$files = scandir($this->_langPath);
			
			//Zend_Translate::setCache($cache);
			$translate = new Zend_Translate(array(
								        		'adapter' => 'tmx',
								        		'locale'  => $this->_lang,
								        		'content'  => $this->_langPath . '/system',
												'scan' => Zend_Translate::LOCALE_FILENAME
												)
											);
			
			if(count($this->_langFile)>0){
				foreach ($this->_langFile as $val){
					$translate->addTranslation($this->_langPath . '/' . $val, $this->_lang); 
				}
			}
			
			//$this->_cacheObj->save($translate,$cacheName,array('lang_admin'));
		/*}else {
			//echo '<br>' . 'Dang su dung Cache';
			$translate = $this->_cacheObj->load($cacheName);
		}*/
		
		return $translate;
	}
	
	
}