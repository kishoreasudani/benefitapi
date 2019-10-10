<?php
class AdminsController extends WecontrolAppController {
	public $name = 'Admins';
	public $uses = array('Wecontrol.Admin','Wecontrol.AdminLoginLog');
	public $helpers = array('Wecontrol.General');	

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('login','logout','create_password','index','change_status','forgot_password','forgot_pass','reset_password','reset_pass','delete_Admin','add','edit','getCity','edit_profile','change_password','users_data','delete_admin','uploadUserAvatar');			
	}

	function create_password($pass = null ){
		$this->layout = false;
		$password = '';
		if(!empty($pass)){
			$password = $this->Auth->password($pass);
		}		
		echo json_encode(array('password'=>$password)); die;
	}

	public function index() {	
		# Check login status...
 		$this->_is_user_login ();	
	}
	
	public function users_data($reset = null) {
		$this->layout = false;
		$conditions = array();
		$this->Admin->virtualFields['full_name'] = "CONCAT(first_name,' ',last_name)";
		if(!empty($this->params->query['data']['Search'])){
			if(!empty($this->params->query['data']['Search']['name'])){
				$conditions[] = array(
					'OR' => array(
						'Admin.first_name LIKE'=>	"%".$this->params->query['data']['Search']['name']."%",
						'Admin.last_name LIKE'=>	"%".$this->params->query['data']['Search']['name']."%",
						'Admin.full_name LIKE'=>	"%".$this->params->query['data']['Search']['name']."%",
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['email'])){
				$conditions[] = array(
					'AND' => array(
						'Admin.email LIKE'=>	"%".$this->params->query['data']['Search']['email']."%",
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['status'])){
				$conditions[] = array(
					'AND' => array(
						'Admin.status'=>$this->params->query['data']['Search']['status'],
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['user_role'])){
				$conditions[] = array(
					'AND' => array(
						'Admin.admin_role'=>$this->params->query['data']['Search']['user_role'],
					)
				);
			}
		}else{
			$conditions = "";
		}	
		$conditions[] = array('Admin.status <>'=>'deleted');		
		$this->Paginator->settings = array('order' => 'Admin.id desc','limit' => Configure::read('AdminListingLimit'));
		$admin_list = $this->paginate('Admin',$conditions);
		$this->set('admin_list',$admin_list);
	}

	public function forgot_password() {	
		$this->layout = "open";	
		# Check login status...
	}
	 
	function login() {
		$this->layout = "open";	
		$response = array();
		$this-> _is_user_logged_in ();
		# Set redirect page url...
		$redirect_page_url = '';
		$this->loadModel('Wecontrol.LoginLog');
		if ( !empty ( $_REQUEST['redirect'] ) ) {
			$redirect_page_url = $_REQUEST['redirect'];
		}
		$this->set ( 'redirect_page_url', $redirect_page_url );	
		if($this->request->is('ajax')) {
			if(isset($this->request->data) && !empty($this->request->data)) {
				# Delete old session...
				$this->Session->delete ( 'Auth.Admin' );
				$this->Admin->set($this->request->data);
				$this->Admin->setValidation('login');
				if($this->Admin->validates()) {	
					if( $this->Auth->login() ) {
							$AdminData = $this->Admin->find('first', array('conditions'=>array('Admin.id'=>$this->Auth->User('id'))));
							if(isset($AdminData) && !empty($AdminData)){
								$data['id'] 		   = $this->Auth->User('id');
								$data['last_login']    = date('Y-m-d H:i:s');
								$data['last_login_ip'] = $this->RequestHandler->getClientIp();
								$this->Admin->updateAll(
								    array('Admin.last_login' => "'".$data['last_login']."'",'Admin.last_login_ip' => "'".$data['last_login_ip']."'"),
								    array('Admin.id' => $data['id'])
								);
								/*Save data in mongo db*/
								$loginLogs =array();
								$loginLogs['type'] 		    = 'admin';
								$loginLogs['item_id'] 		= $this->Auth->User('id');
								$loginLogs['ip_address']    = $this->RequestHandler->getClientIp();
								$this->LoginLog->create();
								$this->LoginLog->save($loginLogs,false);
								if ( !empty ( $this->data['Admin']['redirect_page_url'] ) ) {									
									$redirect =  $this->data['Admin']['redirect_page_url'];
								} else {
									$redirect = 'dashboard';
								}
								//$this->Session->write('Auth.BackEndUser',$this->Session->read ( 'Auth.User' ));
								 
								$refer_url = $this->referer('/', true);
								$parse_url_params = Router::parse($refer_url);						
								$response = array('success' => true,'validationErrors'=>false, 'msg' => 'Logged in, Redirecting...','redirect_url' => $redirect);
							}else{
								$response = array('success' => false,'validationErrors'=>false,'msg' => 'You can\'t access to this panel');
								$this->Session->delete('Auth.Admin');
							}
					} else {
    					$response = array('success' => false,'validationErrors'=>false,'msg' => 'Email and Password did not match.');
    				}					
				} else {
					if(!empty($this->Admin->validationErrors)) {
						foreach($this->Admin->validationErrors as $error_key=>$error_value) {
							$error_key = str_replace('_', ' ', $error_key);
							$error_key = ucwords($error_key);
							$error_key = str_replace(' ', '', $error_key);
							$message['Admin'.$error_key]	=	$error_value;
						}
						$response = array('success' => false, 'validationErrors'=>true, 'msg' => $message);
					}
				}	
				echo json_encode($response);
				die;
			}
		}	
	}
	
	public function logout() {		
		$this->autoRender = false;
		$this->Auth->logout();
		$this->Session->delete('Auth.Admin');
		$this->redirect('/wecontrol');		
	}
 
	public function forgot_pass(){
		$this->layout  = false;
		$response = array();
		if($this->request->is('ajax')) {
			if(isset($this->request->data) && !empty($this->request->data)) {			
				$this->Admin->set($this->request->data);
				$this->Admin->setValidation('forgotpass');
				if($this->Admin->validates()) {					
					$email = $this->request->data['Admin']['email'];
					$AdminData = $this->Admin->find('first',array(
								'conditions' => array('Admin.email' =>  $email,'Admin.status'=>'active'),
								'fields' => array('Admin.id' , 'Admin.email'),
					));
					if(count($AdminData)) {
						//email code here
						$Admin_information = $this->Admin->find('first',array(
							'conditions' => array('Admin.email' => $this->data['Admin']['email'])
						));
						$characters = 'abcdefghijklmnopqrstuvwxyz0123456789';
						$secret_key = '';
						$secretKey_encode = '';
						for ($i = 0; $i < 18; $i++) {
							$secret_key .= $characters[rand(0, strlen($characters) - 1)];
						}
						$secretKey_encode = base64_encode($secret_key);
						$this->Admin->updateAll(
									array('Admin.secret_key' =>"'".$secretKey_encode."'"),
									array('Admin.id'=>$Admin_information['Admin']['id'])
								);
						$passwordLink = Configure::read('SiteSettings.actionUrl').'wecontrol/admins/reset_password/'.$secretKey_encode;
						$email_to = $Admin_information['Admin']['email'];
						$username = ucwords($Admin_information['Admin']['first_name']);			
				        $data = array('username' => $username , 'passwordLink'=>$passwordLink  );
				        $title = 'Reset Password';
				        $subject = 'Reset Password';
				        $this->__send_email('forgot_password_link',$title,$email_to,$subject,$data);					
						$response = array('success' => true,'validationErrors'=>false, 'msg' => 'We have sent you an email to  your registered email address. Please follow the instructions.');
					} else {
						$response = array('success' => false,'validationErrors'=>false, 'msg' => 'Email does not exist.');
					}
				} else {
					if(!empty($this->Admin->validationErrors)) {
						foreach($this->Admin->validationErrors as $error_key=>$error_value) {
							$error_key = str_replace('_', ' ', $error_key);
							$error_key = ucwords($error_key);
							$error_key = str_replace(' ', '', $error_key);
							$message['Admin'.$error_key]	=	$error_value;
						}
						$response = array('success' => false, 'validationErrors'=>true, 'msg' => $message);
					}
				}	
				echo json_encode($response);
				die;
			}
		}
	}

	public function reset_password( $key = null ){
		$this->layout = "open";	
		$this->set('secretkey',$key);
		if( isset($key) && !empty($key) ) {
			$Admin_information = $this->Admin->find('count',array(
											'conditions' => array('Admin.secret_key' => $key)
									));
			if($Admin_information <= 0) {
				$this->Session->delete('Auth.FrontEndAdmin');
				$this->Session->setFlash('Sorry your link has been expired. <br/> Reset your password again.', 'default', null, 'error');
				$this->redirect(array('controller'=>'Admins','action'=>'index'));
			}
		} else{
			$this->Session->setFlash('Sorry your link has been expired. <br/> Reset your password again.', 'default', null, 'error');
			$this->redirect(array('controller'=>'Admins', 'action'=>'index'));
		}
	}

	public function reset_pass( $skey = null ){
		$this->layout  = false;
		$this->set('secretkey',$skey);
		if(isset($this->request->data) && !empty($this->request->data)) {
			$this->Admin->set($this->request->data);
			$this->Admin->setValidation('reset_password');
			if($this->Admin->validates()) {
				if( isset($skey) && !empty($skey) ) {
				$Admin_information = $this->Admin->find('first',array(
											'conditions' => array('Admin.secret_key' => $skey)
									));
				}
				if( isset($Admin_information['Admin']['email']) && !empty($Admin_information['Admin']['email']) ) {
					$newpassword = $this->Auth->password($this->request->data['Admin']['password']);
					$secret_key = '';
					$this->Admin->updateAll(
							array('Admin.password'=> '"'.$newpassword.'"','Admin.secret_key'=>'"'.$secret_key.'"'),
							array('Admin.id'=> $Admin_information['Admin']['id'])
							);
					$response = array('success' => true,'validationErrors'=>false, 'msg' => 'Your password has been reset. Please login to continue.');
				} else {
					$response = array('success' => false,'validationErrors'=>false, 'msg' => 'Sorry your link has been expired. <br/> Reset your password again');
				}
			}  else {
					if(!empty($this->Admin->validationErrors)) {
						foreach($this->Admin->validationErrors as $error_key=>$error_value) {
							$error_key = str_replace('_', ' ', $error_key);
							$error_key = ucwords($error_key);
							$error_key = str_replace(' ', '', $error_key);
							$message['Admin'.$error_key]	=	$error_value[0];
						}
						$response = array('success' => false, 'validationErrors'=>true, 'msg' => $message);
					}
				}
				echo json_encode($response);
				die;
		}
	}

	function edit_profile(  ) {
		$this->_is_user_login (); 
		$userid = $this->Session->read('Auth.Admin.id');
		if(!empty($this->request->data)) {
			$message	=	array();
			$this->Admin->set($this->request->data);
			$this->Admin->setValidation('admin_profile');
			if($this->Admin->validates()) {				
				// save the information
				$this->request->data['Admin']['id'] = $userid;
				// if(!empty($this->request->data['Admin']['password1'])){
				// 	$this->request->data['Admin']['password'] = 	$this->Auth->password($this->request->data['Admin']['password1']);	
				// }
				$this->Admin->save($this->request->data,false);
				 $this->Session->setFlash('Admin profile has been updated successfully.', 'default', null, 'success'); 
				$success =	true;
				$message = "Admin profile has been updated successfully.";
			}else{
				if(!empty($this->Admin->validationErrors)) {
					$success =	false;
					foreach($this->Admin->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Admin'.$error_key]	=	$error_value;
					}
				}
			}
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}else{ 	
			$this->data = $this->Admin->findById($userid);
		} 
	}

	public function change_password() {
		$this->_is_user_login (); 
		$userid = $this->Session->read('Auth.Admin.id');
		if(!empty($this->request->data)) {
			$message	=	array();
			$this->Admin->set($this->data);
			$this->Admin->setValidation('change_password');
			if(!empty($this->request->data['Admin']['old_password'])){
				$old_password = $this->Auth->password($this->request->data['Admin']['old_password']);
				$is_exist = $this->Admin->find('count',array(
					'conditions'=>array('Admin.password'=>$old_password,'Admin.id'=>$userid)
				));
				if($is_exist == 0){
					$this->Admin->validationErrors['old_password'][]= 'The old password does not match the current password!';
				}
			}
			if($this->Admin->validates()) {				
				// save the information
				$this->request->data['Admin']['id'] = $userid;
				$this->request->data['Admin']['password'] = 	$this->Auth->password($this->request->data['Admin']['new_password']);
				$this->Admin->save($this->request->data,false);
				 $this->Session->setFlash('Password has been updated successfully.', 'default', null, 'success'); 
				$success =	true;	 
			}else{
				if(!empty($this->Admin->validationErrors)) {
					$success =	false;
					foreach($this->Admin->validationErrors as $error_key=>$error_value) {

						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Admin'.$error_key]	=	$error_value;
					}
				}
			}
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}	

	}

	public function edit( $id = null ) {
		$this->_is_user_login ();
		$id = base64_decode($id);
		$this->loadModel('City');
		if(!empty($this->request->data)) {
			$message	=	array();
			$this->Admin->set($this->request->data);
			$this->Admin->setValidation('edit');		
			if(!empty($this->request->data['Admin']['password1']) && empty($this->request->data['Admin']['confirm_password'])){
				$this->Admin->validationErrors['confirm_password'][] = 'Please enter confirm password';
			}
			if(!empty($this->request->data['Admin']['password1']) && !empty($this->request->data['Admin']['confirm_password']) && $this->request->data['Admin']['confirm_password']!=$this->request->data['Admin']['password1']){
				$this->Admin->validationErrors['confirm_password'][] = 'Please enter correct confirm password';
			}
			if(!empty($this->request->data['Admin']['password1'])){
				$len = strlen($this->request->data['Admin']['password1']);
				if($len < 5){
					$this->Admin->validationErrors['password1'][] = 'Maximum length should be greater than 5.';
				}
			}
			if($this->Admin->validates()) {				
				// save the information
				$this->Session->setFlash('Admin has been updated successfully.', 'default', null, 'success');
				$this->Admin->save($this->request->data);
				#save avatar
				if(!empty($this->request->data['Admin']['image1']['name']) && isset($this->request->data['Admin']['image1']['name'])){
					$this->upload_admin_image($id, $this->request->data['Admin']['image1']);
				} 
				$success =	true;
				$message = "Admin data has been updated successfully.";
			}else{
				if(!empty($this->Admin->validationErrors)) {
					$success =	false;
					foreach($this->Admin->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Admin'.$error_key]	=	$error_value;
					}
				}
			}
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}else{ 		
			$this->data = $this->Admin->findById($id);
		}
	}

	public function add() {
		$this->_is_user_login ();
		if(!empty($this->request->data)) {
			$message	=	array();
			$this->Admin->set($this->request->data);
			$this->Admin->setValidation('add');		
			if($this->Admin->validates()) {	
				// save the information
				$this->request->data['Admin']['status'] =  'active';
				$this->request->data['Admin']['password'] 	= $this->Auth->password($this->data['Admin']['password']);
				$this->Admin->create();
				$this->Admin->save($this->request->data,false);
				$adminId = $this->Admin->getLastInsertID();
                #save avatar
				if(!empty($this->request->data['Admin']['image1']['name']) && isset($this->request->data['Admin']['image1']['name'])){
					$this->upload_admin_image($adminId, $this->request->data['Admin']['image1']);
				} 
				$success =	true;
				$this->Session->setFlash('Admin has been added successfully.', 'default', null, 'success'); 
			}else{
				if(!empty($this->Admin->validationErrors)) {
					$success =	false;
					foreach($this->Admin->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Admin'.$error_key]	=	$error_value;
					}
				}
			}
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		} 
	}

	
	public function change_status() {
		//$this->_is_user_login ();
		$this->layout = false;
		$moduleName = '';
		if($this->request->is('ajax')) {
			if( !empty($this->request->data)) {
				if(!empty($this->request->data['Admin']) && $this->request->data['Admin']['model'] == 'Admin'){
					$moduleName = $this->request->data['Admin']['model'];
				}
				if(!empty($moduleName)){
					$this->request->data[$moduleName]['id'] = base64_decode( $this->request->data[$moduleName]['id'] );		
					$status = $this->request->data[$moduleName]['status'];
					$response = array();
					if($this->$moduleName->save($this->request->data)) {						
						$response = array('success' => true,'msg' => $moduleName.' status has been updated successfully.');
					}else{
						$response = array('success' => false,'msg' => 'Opps error please try again.');
					}
				} else{
					$response = array('success' => false,'msg' => 'Invalid request.');
				}					
			}else{
				$response = array('success' => false,'msg' => 'Invalid request.');
			}
			echo json_encode($response);
			die;
		}else{
			$this->redirect('/');
		}
		
	}

	public function delete_admin( $id = null , $user_id = null ){
		$this->layout =  false;
		if( isset($id) && !empty($id) && $this->request->is("ajax") && $this->request->is("DELETE") ){
		 	$deleted = "deleted";
			$this->Admin->updateAll( array('Admin.status'=>'"'.$deleted.'"'),array('Admin.id'=>$id));
			$response = array('success' => true,'message' => 'User has been deleted successfully.');
		}else{
			$response = array('success' => false,'message' => 'Invalid request.');
		}
		echo json_encode($response);
		die;	
	}




	public function uploadUserAvatar(){


		if(isset($this->data) && isset($_FILES['avatar'])){

			$this->loadModel('User');

            $user_id = $this->data['id'];
            $photo_tmp = $_FILES['avatar']['tmp_name'];
            $photo_name = $_FILES['avatar']['name'];
            $dir = Configure::read('SiteSettings.Relative.UserImage').$user_id;
            if(!is_dir($dir)){
               mkdir($dir,0777,true);
            }

           // unlink($dir.'/'.$photo_name);
           // rmdir($dir); die();

            move_uploaded_file($photo_tmp, $dir.'/'.$photo_name);

             $data["User"]['id'] = $user_id;
             $data["User"]['avatar'] = $photo_name;
             $this->User->save($data);
            echo json_encode(array('statusCode'=>200,'message'=>'image successfully upload','recordCount'=>0,'body'=>0));
		}
		
	die();
	}

}
