<?php class SendEmailComponent extends Component {
	
	public $name = 'SendEmail';
	public function initialize(Controller $controller, $settings = array()) {

		$this->controller = $controller;
	}

	function forgot_password_link($data,&$controllerObj){
		
		$setVals 	= $data;		
		$to 		= 	$data['to'];
		$template 	= 	'forgot_password';
		$subject	= 	'Event Management - Reset Password';
		$from 		= 	"Event Management<".Configure::read('Email.Admin').">";
		$replyTo 	= 	"Event Management<".Configure::read('Email.Admin').">";
		$body		=	'';
		$bcc 		= 	'user1.guts@gmail.com';
		$controllerObj->__sendMail($to, $from, $subject, $replyTo, $template , $body, $setVals,$bcc);
		
	}
	function admin_forgot_password_link($data,&$controllerObj){
		
		$setVals 	= $data;		
		$to 		= 	$data['to'];
		$template 	= 	'admin_forgot_password';
		$subject	= 	'Event Management - Reset Password';
		$from 		= 	"Event Management <".Configure::read('Email.Admin').">";
		$replyTo 	= 	"Event Management <".Configure::read('Email.Admin').">";
		$body		=	'';
		$bcc 		= 	'user1.guts@gmail.com';
		$controllerObj->__sendMail($to, $from, $subject, $replyTo, $template , $body, $setVals,$bcc);
		
	}
} ?>