<?php
class WecontrolAppController extends AppController {

	 
	var $uses 			= array('Wecontrol.Country','Wecontrol.AdminRolePermission','Wecontrol.Admin');	
	var $helpers 	= 	array('Html','Form','Session','General');
	public $components = array(

		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'fields'=>array('username'=>'username', 'password'=>'password'),
					'userModel'=>'Wecontrol.Admin'
				),
			)
		),
		'Cookie',
		'Email',
		'Session',
		'RequestHandler',
		'Paginator',	
		'PImage'
	);

  	public function beforeFilter() {  
  		AuthComponent::$sessionKey = 'Auth.Admin';	
  		$this->set('siteSetting', $this->__getSitePreference());
  		$userDetails =  $this->__getUserDetails($this->Session->read  ( 'Auth.Admin.id' ));
  		$this->set('userDetails', $userDetails);
  		$defaultDb = $this->__getSitePreference();
  		 
    }

    /** User Login Check... */
	public function _is_user_login () {
		
		$_redirect_page_url = $_SERVER["REQUEST_URI"];	
	 
		@$exp_redirect_url = explode( Configure::read( 'SiteSettings.WecontrolRedirect' ), $_redirect_page_url );
		 
		$_redirect = $exp_redirect_url[1];				
       
		if ( !$this->Session->check ( 'Auth.Admin' ) ) {
			if ( !empty ( $_redirect_page_url ) ) {			
				
				# Redirect...
				$this->redirect ( '/wecontrol/login?redirect='.$_redirect );
			} else {
				
				# Redirect...
				$this->redirect ( '/wecontrol' );
			}
		} 	
	}

	public function _is_user_logged_in () {
		
		if ( $this->Session->check  ( 'Auth.Admin' ) ) {			
			# Redirect...
			$this->redirect ( '/wecontrol/dashboard' );
		}
	}

	public function __send_notification_functio($device_tokens, $title, $message){

	   	

		$url = 'https://fcm.googleapis.com/fcm/send';
		$fields = array();
	   	foreach( $device_tokens as $key => $token ) {
	   		
	   	

			$fields = array (
			  "to" =>$token,
			  "priority" => "high",
			  "notification" => array(
			    "body" => $message,
			    "title" => $title
			  )
			);

		   	//header with content_type and api key
			$headers = array(
				'content-type:application/json',
				'Authorization:key='.Configure::read('PUSH_API_KEY')
			);
			
			//CURL request to route notification to FCM connection server (provided by Google)
			$ch = curl_init();

			
		   	curl_setopt($ch, CURLOPT_URL, $url);
		   	curl_setopt($ch, CURLOPT_POST, true);
		   	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		   	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		   	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		   	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		   	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
		   	$result = curl_exec($ch);
		  	
		   	if ($result !== FALSE) {
				$data = json_decode($result, true);
				
		   	}
	   		curl_close($ch);
	   	}

    }


	public function _countryList(){
		$country_data = array();
		$this->loadModel('Wecontrol.Country');
		$c_data= $this->Country->find( 'all', array( 'order' => array( 'Country.country_name ASC')));
		
		foreach ($c_data as $key => $value) {
			$country_data[$value['Country']['id']] = ucfirst($value['Country']['country_name']);
		}
		return $country_data;
	}
	public function _stateList(){
		$this->loadModel('Wecontrol.State');
		$state_data = array();
		$s_data= $this->State->find( 'all', array( 
			'order' => array( 'State.state_name ASC'),
			'conditions'=>array('State.country_id'=>1)
			));
		
		foreach ($s_data as $key => $value) {
			$state_data[$value['State']['id']] = ucfirst($value['State']['state_name']);
		}
		return $state_data;
	}
	public function _cityList(){
		$this->loadModel('City');
		$city_data = array();
		$c_data= $this->City->find( 'all', array( 'order' => array( 'City.city_name ASC')));
		
		foreach ($c_data as $key => $value) {
			$city_data[$value['City']['id']] = ucfirst($value['City']['city_name']);
		}
		return $city_data;
	}
	 
	 public function _created_by () {		
		return $this->Session->read  ( 'Auth.Admin.id' );
	}

	public function _modified_by () {		
		return $this->Session->read  ( 'Auth.Admin.id' );
	}

	public function _usersList(){
		$users_data = array();
		$this->loadModel('User');
		$u_data= $this->User->find( 'all', array( 
			'order' => array( 'User.first_name ASC'),
			'conditions'=>array('User.user_role_type' => 'user','User.status' => 'active')
			));
		
		foreach ($u_data as $key => $value) {
			$users_data[$value['User']['id']] = ucfirst($value['User']['first_name'].' '.$value['User']['last_name']);
		}
		return $users_data;
	}

	 
	public function errorRedirect($errorType, $options) {
		switch ($errorType) {
			case 'invalid-parameter' :
				$message = (!empty($options['message'])) ? $options['message'] : 'The required parameters to view this page are invalid.';
				$this->Session->setFlash($message, 'default', null, 'error');
				$this->redirect('/');
				break;
			case 'missing-parameter' :
				$message = (!empty($options['message'])) ? $options['message'] : 'The required parameters to view this page are missing.';
				$this->Session->setFlash($message, 'default', null, 'error');
				$this->redirect('/');
				break;
			case 'permission':
				$message = (!empty($options['message'])) ? $options['message'] : 'You don\'t have permissions to access this URL.';
				$this->Session->setFlash($message, 'default', null, 'error');
				$this->redirect($this->referer);
				break;
			case 'not-found' :
				$message = (!empty($options['message'])) ? $options['message'] : sprintf('The requested URL %s was not found on this server.', $this->here);
				$this->Session->setFlash($message, 'default', null, 'error');
				$this->redirect('/');
				break;
			case 'login-required' :
				$message = (!empty($options['message'])) ? $options['message'] : 'You are not logged in. Please login to continue.';
				$this->Session->setFlash($message, 'default', null, 'error');
				$this->redirect(array('controller' => 'pages', 'action' => 'login'));
				break;
			default :
				break;
		}
	}

	function __sendMail($to = array(), $from = null, $subject = null, $replyTo = null, $template = null, $body = null,$setVals = null,$bcc){	
			// pr($to);die;
			if(!is_array($to)){
				$to	=	(array)$to;
			}
			//prd($setVals);
			if(isset($setVals) && !empty($setVals)){
				foreach($setVals as $key=>$val){
					$this->set($key,$val);
				}
			}

			if(isset($setVals['file_path']) && !empty($setVals['file_path'])){
				$this->Email->attachments = array($setVals['file_name'] => $setVals['file_path'],'mimetype' => $setVals['mimetype']); 
			}
			$this->Email->to 			= $to;
			$this->Email->bcc 		= $bcc;
			$this->Email->subject 		= $subject;
			$this->Email->replyTo 		= $replyTo;
			$this->Email->from 			= $from;
			// echo $template.'<br>';
			// echo "and".'<br>';
			// echo $body;die;
			if(trim($template) != ''){
				$this->Email->template 		= $template;
			}
			$this->Email->sendAs 		= 'html';
			if(Configure::read('Environment') == 'local'){
				$this->Email->smtpOptions 	= Configure::read('SMTP.Options');
				$this->Email->delivery 		= 'smtp';	
			}else{
				$email_from = $from;
				$this->Email->from 			= 'Sun Genomics <'.$email_from.'>';
				$this->Email->replyTo 		= 'Sun Genomics <'.$email_from.'>';
			}
			if($to!=null){
				//echo $to;die;
				if($this->Email->send($body)){
					$this->Email->reset();
				}	
					
			}
	}

	function getExtension($str) {
		$i = strrpos($str,".");
		if (!$i) { return ""; }
		$l = strlen($str) - $i;
		$ext = substr($str,$i+1,$l);
		$ext = strtolower($ext);
		return $ext;
	}

	
	function upload_analyst_image($id = null ,$imgFields = null ){
	
		if(!empty($imgFields['name'])){
			
			$analystData = $this->User->find('first',array( 'conditions'=>array('User.id'=>$id) ) );
			
			$dir = Configure::read('Relative.analystImages');
			if(!is_dir($dir)) {	
				mkdir($dir,0777);					
			}

		
			
			$files_array = $imgFields;
			if(isset($files_array) && $files_array!= '' ) {							

				$filetype 		   = $imgFields['type'];
				$filesize 		   = $imgFields['size'];
				$filename 		   = $imgFields['name'];
				$filetmpname 	   = $imgFields['tmp_name'];						
				$filename 		   = substr(time(),-4).$filename;
				$image_dimension   = array();
				$image_dimension   = getimagesize( $filetmpname );
				$ext_name 		   = explode('.',$filename);
				$final_file_title  = $ext_name[0];
				
	            $directory  = Configure::read('Relative.analystImages');		           
				if(!is_dir($directory)) {	
					mkdir($directory,0777);					
				}		

			
				
			    //copy($tmpname, $dir.'/'.$newFileName);
			    move_uploaded_file($filetmpname, $directory.'/'.$filename);

			    if(!empty($image_dimension)){
					$newImageSize['w'] = $image_dimension[0];
					$newImageSize['h'] = $image_dimension[1];
					$timestamp = time();
					if(!empty($analystData['User']['avatar'])){
						$explode_name = explode('_', $analystData['User']['avatar']);
						$explode_name_ext = explode('.', $explode_name[1]);
					}
					foreach (Configure::read('imageSize') as $key => $value) {
						if(!empty($analystData['User']['avatar'])){

						 $oldImage 	= $directory.'/'.$id.'_'.@$explode_name_ext[0].'_'.$value['width'].'x'.$value['height'].'.'.@$explode_name_ext[1];
						
							if(file_exists($oldImage) && !is_dir($oldImage)){
								@unlink($oldImage);
							}
						}
						$newFileName = 	str_replace(' ', '-', $final_file_title);							
						$newFileName = $id.'_'.$timestamp.'_'.$value['width'].'x'.$value['height'].'.'.$ext_name[1];
						$saveFileName = $id.'_'.$timestamp.'.'.$ext_name[1];
						
						$result1 = $this->PImage->resizeImage(
								$cType = 'resize',
								$filename,
								$directory.'/', 
								$directory .'/'.$newFileName,
								$value['width'],
								$value['height'],
								$quality = 100,
								$bgcolor = false
						);	
					}
				}	
					$oldImageTemp 	= $directory.'/'.$filename;
				    if(file_exists($oldImageTemp) && !is_dir($oldImageTemp)){
						@unlink($oldImageTemp);
					}
					

			    $this->User->updateAll(array('User.avatar' => '"'.$saveFileName.'"'),array('User.id'=>$id));

			}
		}

	}
	function upload_admin_image($id = null ,$imgFields = null ){


	
		if(!empty($imgFields['name'])){
			
			$adminData = $this->Admin->find('first',array( 'conditions'=>array('Admin.id'=>$id) ) );
				
			$dir = Configure::read('Relative.adminImages');
			if(!is_dir($dir)) {	
				mkdir($dir,0777);					
			}
			$files_array = $imgFields;
			if(isset($files_array) && $files_array!= '' ) {							

				$filetype 		   = $imgFields['type'];
				$filesize 		   = $imgFields['size'];
				$filename 		   = $imgFields['name'];
				$filetmpname 	   = $imgFields['tmp_name'];						
				$filename 		   = substr(time(),-4).$filename;
				$image_dimension   = array();
				$image_dimension   = getimagesize( $filetmpname );
				$ext_name 		   = explode('.',$filename);
				$final_file_title  = $ext_name[0];
				
	            $directory  = Configure::read('Relative.adminImages');		           
				if(!is_dir($directory)) {	
					mkdir($directory,0777);					
				}
				 move_uploaded_file($filetmpname, $directory.'/'.$filename);

			    if(!empty($image_dimension)){
					$newImageSize['w'] = $image_dimension[0];
					$newImageSize['h'] = $image_dimension[1];
					$timestamp = time();
					
					if(!empty($adminData['Admin']['avatar'])){
						$explode_name = explode('_', $adminData['Admin']['avatar']);
						$explode_name_ext = explode('.', $explode_name[1]);
					}
					foreach (Configure::read('imageSize') as $key => $value) {
						if(!empty($adminData['Admin']['avatar'])){

						 $oldImage 	= $directory.'/'.$id.'_'.@$explode_name_ext[0].'_'.$value['width'].'x'.$value['height'].'.'.@$explode_name_ext[1];
						
							if(file_exists($oldImage) && !is_dir($oldImage)){
								@unlink($oldImage);
							}
						}
						
						$newFileName = 	str_replace(' ', '-', $final_file_title);							
						$newFileName = $id.'_'.$timestamp.'_'.$value['width'].'x'.$value['height'].'.'.$ext_name[1];
						$saveFileName = $id.'_'.$timestamp.'.'.$ext_name[1];
						//prd($newFileName);
							
						$result1 = $this->PImage->resizeImage(
								$cType = 'resize',
								$filename,
								$directory.'/', 
								$directory .'/'.$newFileName,
								$value['width'],
								$value['height'],
								$quality = 100,
								$bgcolor = false
						);
						
					}
				}	
				$oldImageTemp 	= $directory.'/'.$filename;
			    if(file_exists($oldImageTemp) && !is_dir($oldImageTemp)){
					@unlink($oldImageTemp);
				}					

			    $this->Admin->updateAll(array('Admin.avatar' => '"'.$saveFileName.'"'),array('Admin.id'=>$id));

			}
		}

	}
	function __getSitePreference(){
		$this->loadModel('Setting');
		$site_preference_data = $this->Setting->find('first');
		return $site_preference_data;
	}

	function __getUserDetails($userid = null ){
		$this->loadModel('Wecontrol.Admin');
		$userData = array();
		$userData =  $this->Admin->find('first',array(
			'conditions'=>array('Admin.id'=>$userid)
		));

		return $userData;
	}
	
	function __get_password_encoded($password=null){
		if(!empty($password)){
			$password	=	sha1($password);
		}
		return $password;
	}

	function __getUserdata(){

		$this->loadModel('User');
		$users =  $this->User->find('list',array(
			'conditions'=>array('User.status'=>'active'),
			'fields'=>array('User.id','User.full_name'),
			'recursive'=>-1
		));
		return $users;
	}

	public function _getAnalystList(){
		$users_data = array();
		$this->loadModel('User');
		$u_data= $this->User->find( 'all', array( 
			'conditions'=>array('User.type' => 'analyst','User.status' => 'active')
			));
		
		foreach ($u_data as $key => $value) {
			$users_data[$value['User']['id']] = ucwords($value['User']['first_name'].' '.$value['User']['last_name']);
		}
		return $users_data;
	}
	
	function __getCountry(){

		$this->loadModel('Country');
		$countryList =  $this->Country->find('list',array(
			'conditions'=>array( 'Country.id'=>array('38','101','231')),
			'fields'=>array('Country.id','Country.name'),
			'recursive'=>-1
		));
		return $countryList;
	}

	 public function __getCategory(){
	 	$this->loadModel('Category');
		$category_data = array();
		$c_data= $this->Category->find( 'all', array( 'order' => array( 'Category.name ASC')));
		
		foreach ($c_data as $key => $value) {
			$category_data[$value['Category']['id']] = ucfirst($value['Category']['name']);
		}
		return $category_data;
	}
	
	
	 public function __getState(){
		$state_data = array();
		$c_data= $this->State->find( 'all', array( 'order' => array( 'State.name ASC')));
		
		foreach ($c_data as $key => $value) {
			$state_data[$value['State']['id']] = ucfirst($value['State']['name']);
		}
		return $state_data;
	}

	 public function __getCity(){
		$city_data = array();
		$c_data= $this->City->find( 'all', array( 'order' => array( 'City.name ASC')));
		
		foreach ($c_data as $key => $value) {
			$city_data[$value['City']['id']] = ucfirst($value['City']['name']);
		}
		return $city_data;
	}

	 
}
