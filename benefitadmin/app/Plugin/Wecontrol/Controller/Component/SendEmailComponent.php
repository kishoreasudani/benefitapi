<?php
class SendEmailComponent extends Component {
	
	public $name = 'SendEmail';
	public function initialize(Controller $controller, $settings = array()) {
		$this->controller =$controller;
	}
	
	function send_survey_response($data,&$controllerObj){
		$setVals = $data;
		$to 		= 	$data['email_params']['to'];
		$template 	= 	'send_survey_response';
		$subject	= 	'Misrii - '.ucfirst($data['UserData']['type']).' survey response';
		$from 		= 	'Misrii <'.Configure::read('Email.Admin').'>';
		$body		=	'';
		$bcc 		= 	'misrii.official2016@gmail.com';
		$controllerObj->__sendMail($to, $from, $subject, null, $template , $body, $setVals,$bcc);
	}

	function forgot_password_link($data,&$controllerObj){
		
		$setVals = $data;		
		$to 		= 	$data['to'];
		$template 	= 	'admin_forgot_password';
		$subject	= 	'Misrii reset password link';
		$from 		= 	"Misrii Notifications <".Configure::read('Email.Admin').">";
		$replyTo 	= 	"Misrii Notifications <".Configure::read('Email.Admin').">";
		$body		=	'';
		$bcc 		= 	'misrii.official2016@gmail.com';
		$controllerObj->__sendMail($to, $from, $subject, $replyTo, $template , $body, $setVals,$bcc);
		
	}

	function __call($funName, $arg = array()){
		if($funName == "seller_survey"){
			$template 	= 	'seller_survey';
		}else{
			$template 	= 	'buyer_survey';
		}
		$data = $arg[0]['data'];
		$controllerObj = $arg[0]['controllerObj'];
		$setVals = $data;
		$to 		= 	$data['to'];
		$subject	= 	'Misrii - Thank You for joining Misrii Community.
		';
		$from 		= 	'Misrii <'.Configure::read('Email.Admin').'>';
		$body		=	'';
		$bcc 		= 	'misrii.official2016@gmail.com';
		$controllerObj->__sendMail($to, $from, $subject, null, $template , $body, $setVals,$bcc);		
	}
}
?>