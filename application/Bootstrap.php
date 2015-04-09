<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap {
	
	protected function _initSession(){
		Zend_Session::start();
	}
	protected function _initDb(){		
		$optionResources = $this->getOption('resources');
		$dbOption = $optionResources['db'];
		$dbOption['params']['username'] = 'root';
		$dbOption['params']['password'] = '';
		$dbOption['params']['dbname'] = 'congtynem';
		
		$adapter = $dbOption['adapter'];
		$config = $dbOption['params'];
		
		$db = Zend_Db::factory($adapter,$config);
		$db->setFetchMode(Zend_Db::FETCH_ASSOC);
		$db->query("SET NAMES 'utf8'");
		
		Zend_Registry::set('connectDb',$db);
		
		Zend_Db_Table::setDefaultAdapter($db);
		
		return $db;
		
	}
	
	protected function _initFrontcontroller(){
		$front = Zend_Controller_Front::getInstance();
		$front->addModuleDirectory(APPLICATION_PATH . '/modules');
		$front->setDefaultModule('default');
		$front->registerPlugin(new Zendvn_Plugin_Permission());	
		$front->registerPlugin(new Zendvn_System_Language());	
		return $front;
	}

	protected function _initLoadRouter(){		
		$config = new Zend_Config_Ini(CONFIG_PATH . '/app-router.ini','setup-router');
		$objRouter = new Zend_Controller_Router_Rewrite();
		//new Zend_Controller_Router_Route_Regex()
		$router = $objRouter->addConfig($config,'routers');		
		$front = Zend_Controller_Front::getInstance();
		$front->setRouter($router);
	}
}
