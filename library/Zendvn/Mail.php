<?php
class Zendvn_Mail{
	
	protected $_config = array(
		'auth'=>'login',
		'ssl'=>'ssl',
		'port'=> 465,
		'username'=>'truongdinhvu2406@gmail.com',
		'password'=>'dinhvu251287',
		'smtp'=>'smtp.gmail.com'
	);
	
	protected $_title = 'Nơi bạn đặt niềm tin mua sắm';
	
	protected $_from = 'truongdinhvu2406@gmail.com';
	
	public function sendContact($arrParam, $option=null){
		$smtpHost = new Zend_Mail_Transport_Smtp ($this->_config['smtp'], $this->_config);
		$MailObj = new Zend_Mail ('UTF-8');
		$fromEmail = $arrParam['email'];
		$fromFullName = $arrParam['fullname'];
		$to = 'phongmarketing@wean.vn';	
		$subject = "Thông tin liên hệ từ website congtynem.com";
		$emailMessage = 	"THÔNG TIN PHẢN HỒI\n" .
								"-----------------------------------------------------------------------\n" .
								"- Họ và tên: " . $arrParam['fullname'] . "\n" . 
								"- Email: " . $arrParam['email'] . "\n" .
								"- Tiêu đề: " . $arrParam['title'] . "\n" .
		 						"- Nội dung: " . $arrParam['message'];
						
		$MailObj->setBodyText ( $emailMessage );
		$MailObj->setFrom ( $fromEmail, $fromFullName );
		$MailObj->addTo ( $to );
		$MailObj->setSubject ( $subject );
		$MailObj->isMultiPart();
		$result = $MailObj->send ( $smtpHost );
		
		return $result;
	}
	public function sendOrder($arrParam, $option){
		$smtpHost 		= new Zend_Mail_Transport_Smtp ($this->_config['smtp'], $this->_config );
		$view 			= new Zend_View_Helper_BaseUrl();
		
		$link			= 'http://' . $_SERVER['HTTP_HOST'] . $view->baseUrl('/products/admin-invoice/index');
		
		$smtpHost 		= new Zend_Mail_Transport_Smtp ($this->_config['smtp'], $this->_config);
		$MailObj 		= new Zend_Mail ('UTF-8');
		$fromEmail 		= $arrParam['email'];
		$fromFullName = $arrParam['fullname'];
		$to 			= 'truongdinhvu2406@gmail.com';	
		$subject 		= "Thông tin liên hệ mua hàng từ website congtynem.com";
		$emailMessage = 	"THÔNG TIN PHẢN HỒI\n" .
								"-----------------------------------------------------------------------\n" .
								"- Email: " . $arrParam['email'] . "\n" .
		 						"- Nội dung: Có khách mua hàng, vui lòng vào xem giỏ hàng \n".
								"- Link giỏ hàng: " .$link;
						
		$MailObj->setBodyText ( $emailMessage );
		$MailObj->setFrom ( $fromEmail, $fromFullName );
		$MailObj->addTo ( $to );
		$MailObj->setSubject ( $subject );
		$MailObj->isMultiPart();
		$result = $MailObj->send ( $smtpHost );
		
		return $result;
	}
	
	public function sendRegister($arrParam, $option=null){
		$smtpHost 	= new Zend_Mail_Transport_Smtp ($this->_config['smtp'], $this->_config );
		$view 		= new Zend_View_Helper_BaseUrl();
		
		$arrParam['link_active'] = 'http://' . $_SERVER['HTTP_HOST'] . $view->baseUrl('/default/public/active/email/' . $arrParam['email']);
		
		$link_active = '<a href="'.$arrParam['link_active'].'">'.$arrParam['link_active'].'</a>';
		$from		= $this->_from;
		$name		= 'www.congtynem.com';
		$to			= $arrParam['email'];
		
		$subject	= "Chào mừng bạn đã đến với www.congtynem.com";
		$bodyHtml	= "";
		$bodyHtml 	.= "Chào bạn <strong>".$arrParam['user_name']."</strong>!<br /><br />";
		$bodyHtml 	.= "Bạn hay ai đó đã dùng tài khoản email này để đăng ký thành viên trên ".$name."<br />";
		$bodyHtml 	.= "Thông tin về tài khoản thành viên của bạn như sau:<br />";
		$bodyHtml 	.= "--------------------------------------------<br />";
		$bodyHtml 	.= "- Họ tên thành viên: ".$arrParam['first_name'].' '.$arrParam['last_name']."<br />";
		$bodyHtml 	.= "- Tên đăng nhập: ".$arrParam['user_name']."<br />";
		$bodyHtml 	.= "- Email: " . $arrParam['email']."<br />";
		$bodyHtml 	.= "- Mật khẩu: ". $arrParam['password']."<br />";
		$bodyHtml 	.= "--------------------------------------------<br />";
		$bodyHtml 	.= "Tài khoản của bạn hiện tại chưa được kích hoạt. Bạn không thể sử dụng tài khoản này để đăng nhập vào ";
		$bodyHtml 	.= "hệ thống cho đến khi bạn kích hoạt nó bằng cách bấm vào liên kết dưới đây:<br />" .$link_active."<br />";
		
		$bodyHtml 	.= "Cám ơn bạn đã tham gia cùng với chúng tôi! <br />";
		$bodyHtml 	.= "--------------------------------------------<br />";
	
		$bodyHtml 	.= "<span style='color:#f90;'>Website: www.congtynem.com</span>";
		$mail = new Zend_Mail('UTF-8');
		$mail->setBodyHtml($bodyHtml);
		$mail->setFrom($from, $name);
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->isMultiPart();
		return $mail->send($smtpHost);	
	}
	
	public function sendRegisterCourse($arrParam, $option=null){
		$smtpHost = new Zend_Mail_Transport_Smtp ($this->_config['smtp'], $this->_config );
		
		$link_active = '<a href="'.$arrParam['link_active'].'">'.$arrParam['link_active'].'</a>';
		$from		= $this->_from;
		$name		= 'ZendVN';
		$to			= $arrParam['email'];
		$subject	= "Chào mừng bạn đã đến với ZendVN - Vietnam Zend Framework - PHP script - Open Source!";
		$bodyHtml	= "";
		$bodyHtml 	.= "Thân chào <strong>".$arrParam['full_name']."</strong>!".BR.BR;
		$bodyHtml 	.= "Cảm ơn bạn đã đăng ký khóa học tại www.zend.vn".BR;
		$bodyHtml 	.= "Đây là những thông tin của bạn đã đăng ký. Chúng tôi sẽ liên hệ lại với bạn trong vòng 24 giờ.".BR.BR;
		$bodyHtml 	.= "Thông tin đăng ký:".BR;
		$bodyHtml 	.= "--------------------------------------------".BR;
		$bodyHtml 	.= "- Đăng ký khóa học: ".$arrParam['course_name'].BR;
		$bodyHtml 	.= "- Lớp học: ".$arrParam['class_name'].BR;
		$bodyHtml 	.= "- Họ và tên: " . $arrParam['full_name'].BR;
		$bodyHtml 	.= "- Email: " . $arrParam['email'].BR;
		$bodyHtml 	.= "- Ngày sinh: " . date('d-m-Y',strtotime($arrParam['birthday'])).BR;
		$bodyHtml 	.= "- Số CMND: " . $arrParam['passport'].BR;
		$bodyHtml 	.= "- Số ĐTDĐ: " . $arrParam['phone'].BR;
		$bodyHtml 	.= "- Thuộc đối tượng: " . $arrParam['discount']['name'] . '(giảm ' . $arrParam['discount']['percent'] . '%)' .BR;
		$bodyHtml 	.= "- Ghi chú: " . $arrParam['note'] .BR;
		$bodyHtml 	.= "- Địa chỉ thường trú: " . $arrParam['address'].BR;
		$bodyHtml 	.= "- Thành phố/tỉnh: " . $arrParam['city'].BR;
		$bodyHtml 	.= "- Địa chỉ tạm trú: " . $arrParam['address2'].BR;
		$bodyHtml 	.= "- Thành phố/tỉnh: " . $arrParam['city2'].BR;
		$bodyHtml 	.= "--------------------------------------------".BR.BR;
		$bodyHtml 	.= "Chúc bạn một ngày tốt đẹp".BR.BR;
		$bodyHtml 	.= "ZendVN group";
		$mail = new Zend_Mail('UTF-8');
		$mail->setBodyHtml($bodyHtml);
		$mail->setFrom($from, $name);
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->isMultiPart();
		return $mail->send($smtpHost);
	}

	public function mailForgotPass($arrParam){
		$view 		= new Zend_View_Helper_BaseUrl();
		$from		= $this->_from;
		$name		= 'Website congtynem.com';
		$to			= $arrParam['email'];
		
		$token		= $arrParam['token'];
		$linkActive	= $arrParam['link_active'] = 'http://' . $_SERVER['HTTP_HOST'] . $view->baseUrl('/default/public/active-pass/token/' . $token);
		$subject	= "Kích hoạt mật khẩu mới";
		$bodyHtml	= "";
		$bodyHtml 	.= "Chào bạn <strong>".$arrParam['user_name']."</strong>!<br /><br />";
		$bodyHtml 	.= "Chúng tôi đã nhận được thông tin yêu cầu cung cấp lại mật khẩu mới. <br/>";
		$bodyHtml	.= "<a href='".$linkActive."'>Nhấn vào đây để nhận mật khẩu mới</a>";
		
		$smtpHost = new Zend_Mail_Transport_Smtp($this->_config['smtp'],$this->_config);		
		$mail = new Zend_Mail('UTF-8');
		$mail->setBodyHtml($bodyHtml);
		$mail->setFrom($from, $name);
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->isMultiPart();
		
		return $mail->send($smtpHost);
	}

	public function sendMessageMember($arrParam){
		$from		= $this->_from;
		$name		= 'ChuyenLuyenTOEIC';
		$to			= $arrParam['email'];
		$subject	= $arrParam['subject'];
		$bodyHtml	= " " . $arrParam['content'] . " ";
	
		$smtpHost = new Zend_Mail_Transport_Smtp($this->_config['smtp'],$this->_config);
		$mail = new Zend_Mail('UTF-8');
		$mail->setBodyHtml($bodyHtml);
		$mail->setFrom($from, $name);
		$mail->addTo($to);
		$mail->setSubject($subject);
		$mail->isMultiPart();
		return $mail->send($smtpHost);
	}
}