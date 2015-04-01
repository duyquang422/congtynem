<?php
class Zendvn_Captcha_Image extends Zend_Captcha_Image{
	
	/*public function __construct(){		
		//2. Thiet lap duong dan den thu muc chua hinh anh se duoc tao
		$this->setImgDir(CAPTCHA_PATH . '/img');		
		//3. Thiet lap duong dan URL den thu muc chua hinh anh
		$this->setImgUrl(CAPTCHA_URL . '/img');		
		//4. Thiet lap chieu dai chuoi hien thi trong hinh
		$this->setWordlen(6);		
		//5. Thiet lap duong dan den FONT hien thi trong CAPTCHA
		$this->setFont(CAPTCHA_PATH . '/font/GondolaSD.ttf');		
		//6. Thiet lap kich co cua FONT
		$this->setFontSize(30);		
		//7. Thiet lap kich thuoc cho hinh duoc tao ra
		$this->setWidth(240);
		$this->setHeight(70);
		$this->setTimeout(100);
		//8. Tao ra CAPTCHA
		$this->generate();
		
		$thisSession = new Zend_Session_Namespace('Zend_Form_Captcha_' . $this->getId());
		$thisSession->word = $this->getWord();
	}*/
	
	public function __construct($width=200,$height=60, $options = array()){				
		$wordlen 	= !empty($options['wordlen'])?$options['wordlen']:'4';
		$fsize 		= !empty($options['fsize'])?$options['fsize']:'32';
		$dot 		= !empty($options['dot'])?$options['dot']:'5';
		$line 		= !empty($options['line'])?$options['line']:'5';
		
		//2. Thiet lap duong dan den thu muc chua hinh anh se duoc tao
		$this->setImgDir(CAPTCHA_PATH . '/img');		
		//3. Thiet lap duong dan URL den thu muc chua hinh anh
		$this->setImgUrl(CAPTCHA_URL . '/img');		
		//4. Thiet lap chieu dai chuoi hien thi trong hinh
		$this->setWordlen($wordlen);
		//5. Thiet lap duong dan den FONT hien thi trong CAPTCHA
		$file = array('ARIAL.TTF','BlaxSlabXXL.ttf','BRITANIC.TTF','GondolaSD.ttf','theworldisyours.ttf','vni-tekon.ttf');
		Zend_Captcha_Word::$VN = array("B","A","C","D","E","F","G","H","K","L","2","3","4","5","6","7","8","9");
		Zend_Captcha_Word::$CN = array("B","A","C","D","E","F","G","H","K","L","2","3","4","5","6","7","8","9");
		$filex = array_rand($file);
		$this->setFont(CAPTCHA_PATH .'/font/'.$file[2]);		
		//6. Thiet lap kich co cua FONT
		$this->setFontSize($fsize);
		//7. Thiet lap kich thuoc cho hinh duoc tao ra
		$this->setWidth($width);
		$this->setHeight($height);
		$this->setTimeout(100);
		$this->setDotNoiseLevel($dot);
		$this->setLineNoiseLevel($line);
		//8. Tao ra CAPTCHA
		$this->generate();
		
		$thisSession = new Zend_Session_Namespace('Zend_Form_Captcha_' . $this->getId());
		$thisSession->word = $this->getWord();
	}

	
	public function removeImg($captcha_id,$options=false){
		if($options['exception']==true){
			$pathname = CAPTCHA_PATH . '/img/';
			$fileList = scandir($pathname);
			$imgCaptcha = $captcha_id . $this->getSuffix(); 
			   
			foreach ($fileList as $file) {
				if($imgCaptcha!=$file){
					$file  = CAPTCHA_PATH . '/img/' . $file;
					@unlink($file);
				}
			}
		}else{
			$file  = CAPTCHA_PATH . '/img/' . $captcha_id . $this->getSuffix();
			@unlink($file);
	  	}
	 }
} 
