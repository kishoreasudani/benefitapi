<?php
class PagesController extends WecontrolAppController {
	public $name = 'Pages';
	public $uses = array( 'Wecontrol.User','Wecontrol.Page','Wecontrol.Settlement', 'Wecontrol.Faq');
	var $components	=	array('Session','Email','SendEmail','RequestHandler','Paginator','General');
	var $helpers 	= 	array('Html','Form','Session','General');

	function beforeFilter(){
		parent::beforeFilter();	

		$this->Auth->allow('index_page', 'change_order',
							'change_password', 'add_page','edit_page','static_page','load_page','delete_page','setting','view_page','change_status', 'delete_faq', 'change_static_page_status', 'change_status_faq', 'load_faq', 'edit_faq', 'add_faq', 'faqs'
						 );
	
	}
	function edit_profile(  ) {
		$this->_is_user_login (); 
		$userid = $this->Session->read('Auth.User.id');
		if(!empty($this->request->data)) {
			
			$message	=	array();
			$this->User->set($this->request->data);
			$this->User->setValidation('edit_user_profile');

			if($this->User->validates()) {				
				// save the information
				$this->request->data['User']['id'] = $userid;
				if(!empty($this->request->data['User']['password1'])){
					$this->request->data['User']['password'] = 	$this->Auth->password($this->request->data['User']['password1']);	
				}
				$this->User->save($this->request->data,false);
				 $this->Session->setFlash('User profile has been updated successfully.', 'default', null, 'success'); 
				$success =	true;
				$message = "User profile has been updated successfully.";
			}else{
				if(!empty($this->User->validationErrors)) {

					$success =	false;
					foreach($this->User->validationErrors as $error_key=>$error_value) {

						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['User'.$error_key]	=	$error_value;
					}
				}
			}
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}else{ 	
			
			$this->data = $this->User->findById($userid);	

		} 
	}
	public function change_status() {

		$this->layout = false;

		$moduleName = '';
		if($this->request->is('ajax')) {
			if( !empty($this->request->data)) {

				if(!empty($this->request->data['Page']) && $this->request->data['Page']['model'] == 'Page'){
					$moduleName = $this->request->data['Page']['model'];
				}

				if(!empty($moduleName)){
					$this->request->data[$moduleName]['id'] = base64_decode( $this->request->data[$moduleName]['id'] );		
					$status = $this->request->data[$moduleName]['status'];
					
					$response = array();
					if($this->$moduleName->save($this->request->data)) {						
						$response = array('success' => true,'msg' =>' status has been updated successfully.');
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

	public function edit_page($id = null) {
		$this->_is_user_login (); 
		$this->set('id',$id);
		$p_id = base64_decode($id);
		$success = false; 
		$message = "";	
		if(!empty($this->data)) {

			$this->Page->set($this->request->data);
			$this->Page->setValidation('edit');
			
			if($this->Page->validates())  {
			
                
	            if($this->Page->save($this->request->data,false)) {
	            	
		           	$dowloadPath   	= Configure::read('SiteSettings.Relative.StaticPagesImage').$p_id;
		            if(!empty($this->data['Page']['file']['name'])){

		                $fileName    = $this->data['Page']['file']['name'];
		                $fileType    = $this->data['Page']['file']['type'];
		                $fileTmpName = $this->data['Page']['file']['tmp_name'];
		                $fileError   = $this->data['Page']['file']['error'];
		                $fileSize    = $this->data['Page']['file']['size'];
		                $file_type   = explode('.', $fileName);
		                $ext_name    = array_reverse($file_type);
		                $ext         = strtolower($ext_name[0]);
		                $fileNewName = strtolower($ext_name[1]).'_'.time().'.'.$ext;
		                
	                   	if(!is_dir($dowloadPath)){
	                    	@mkdir($dowloadPath, 0777);
	                  	}
	                   	@move_uploaded_file($fileTmpName, $dowloadPath.'/'.$fileNewName);
	                    $this->Page->updateAll(array('Page.banner_image'=>"'".$fileNewName."'"),array('Page.id'=>$p_id));
	                }
					
					$this->Session->setFlash('Page has been updated successfully.', 'default', null, 'success');
					$response['type'] = 'success';
					$message = "The page has been saved.";
				} else {
					$response['type'] = 'error';
					$message = "The page could not be saved. Please, try again.";	
					
				}
			} else {

			if(!empty($this->Page->validationErrors)) {
					
					$response['type'] = 'validationError';
					$errorKeys = array();
					foreach($this->Page->validationErrors as $key=>$loop){
	             		$keyNames =  'Page'.Inflector::Camelize($key);
	             		$errorKeys[$keyNames] = $loop[0];
	             	}
	             	$response['data'] = $errorKeys;
	             }
			
			}	
			echo json_encode($response);
		die;
		}else{
			$this->data = $this->Page->findById($p_id);
		}
		
	}
	
	public function add_page($id = null) {

		$this->_is_user_login ();
		 
		if(!empty($this->request->data)) {
			
			$message	=	array();
			$this->Page->set($this->request->data);
			$this->Page->setValidation('add');		
			
			if($this->Page->validates()) {	

				// save the information
				$this->request->data['Page']['slug'] = $this->General->parseSlug($this->request->data['Page']['title']);
			 
				$this->request->data['Page']['status'] =  'active';

				$this->request->data['Page']['created_by'] = $this->_created_by ();
				$this->Page->create();
				$this->Page->save($this->request->data,false);
				$success =	true;
				$this->Session->setFlash('Page has been added successfully.', 'default', null, 'success');
				 
			}else{
				if(!empty($this->Page->validationErrors)) {

					$success =	false;
					foreach($this->Page->validationErrors as $error_key=>$error_value) {

						$error_key = str_replace('_', ' ', $error_key);


						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Page'.$error_key]	=	$error_value;
					}
				}
			}
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		} 
	}


	public function static_page() {

		$this->_is_user_login ();
		
	}

	public function load_page($reset = null) {

		$this->layout = false;
		$conditions = array();
		if(!empty($this->params->query['data']['Search'])){
			if(!empty($this->params->query['data']['Search']['title'])){
				$conditions[] = array(
					'AND' => array(
						'Page.title LIKE'=>	"%".$this->params->query['data']['Search']['title']."%",
						
					)
				);

			}
			
			if(!empty($this->params->query['data']['Search']['status'])){
				$conditions[] = array(
					'AND' => array(
						'Page.status'=> $this->params->query['data']['Search']['status'],
						
					)
				);
				
			}
			
		}else{
			$conditions = "";
		}
		$conditions['Page.status <>'] = 'deleted';	
		$this->Paginator->settings = array('order' => 'Page.id desc','limit' => Configure::read('AdminListingLimit'));
		$PageData = $this->paginate('Page',$conditions);
		$this->set('PageData',$PageData);	
					
	}

	public function delete_page( $id = null){

		$this->layout =  false;
		if( isset($id) && !empty($id) && $this->request->is("ajax") && $this->request->is("DELETE") ){
			$status = 'deleted';
			$this->Page->updateAll(array('Page.status'=>"'".$status."'"),array('Page.id'=>$id));
					
			$response = array('success' => true,'message' => 'Page has been deleted successfully.');
		}else{
			$response = array('success' => false,'message' => 'Invalid request.');
		}
		echo json_encode($response);
		die;	
	}

	public function setting($id = null) {
		
		$this->_is_user_login ();
		$this->loadModel('Setting');
		$success = null;
		$message = array();
		$id = json_encode($id);
		if(!empty($this->data)){
			//pr($this->data);	
			$this->Setting->set($this->data);
			$this->Setting->setValidation('add');
			if($this->Setting->validates()) {	
				$this->data['Setting']['id'] = 1;
				$this->Setting->save($this->data);
				$this->Session->setFlash('Settings has been updated successfully.', 'default', null, 'success');
			} 
		}else{
			$this->data = $this->Setting->findById(1);
		}

	}


	public function view_page($pageid = null){
		$pageid = base64_decode($pageid);

		$pages = $this->Page->find('first',array(
					'conditions'=>array('Page.id'=>$pageid),
					'recursive'=>1
		));
		$this->set('pages',$pages);
		
	}

	public function faqs() {	
		$this->_is_user_login ();
		//$this->_is_permitted('Faq');
	}
	
	public function add_faq($check = null) {
		//$this->_is_user_login (); 
		$success = true;
		$message = array();
		if(!empty($this->data)) {	
			$this->Faq->set($this->data);
			$this->Faq->setValidation('add');
			if($this->Faq->validates()) {
				$this->request->data['Faq']['created_by'] = $this->Session->read('Auth.Admin.id');
			$display_order = $this->Faq->find('first',array(
			 		'order'=>array('Faq.id DESC'),
			 		'fields'=>array('Faq.display_order')
			 	));
			 	if(isset($display_order) && !empty($display_order)){
			 		$displayOrder = $display_order['Faq']['display_order']+1;
			 	}else{
			 		$displayOrder = 1;
			 	}
				$this->request->data['Faq']['display_order'] = $displayOrder;
                $this->Faq->create();
                $this->Faq->save($this->request->data,false);   
                //$this->Session->setFlash('Feedback has been saved successfully.', 'default', null, 'success');
                $success = true;
				$message = "Faqs has been saved successfully.";
			}else{
				if(!empty($this->Faq->validationErrors)) {
					$success = false;
					foreach($this->Faq->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Faq'.$error_key]	=	$error_value;
					}
				}
			}	
		echo json_encode(array('success'=>$success, 'message'=>$message));
		die;
		}
	}

	public function edit_faq( $id = null ) {
		$this->_is_user_login (); 
		$success = true;
		$message = array();
		if(!empty($this->data)) {	
			$this->Faq->set($this->data);
			$this->Faq->setValidation('add');
			if($this->Faq->validates()) {
				//$date_data['id'] = $this->request->data['Faq']['id'];
				$this->request->data['Faq']['modified_by'] = $this->Session->read('Auth.Admin.id');
                $this->Faq->save($this->request->data,false);   
               	//$this->Session->setFlash('Faq has been updated successfully.', 'default', null, 'success');
                $success = true;
				$message = "FAQ has been saved successfully.";
			}else{
				if(!empty($this->Faq->validationErrors)) {
					$success = false;
					foreach($this->Faq->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Faq'.$error_key]	=	$error_value;
					}
				}
			}	
		echo json_encode(array('success'=>$success, 'message'=>$message));
		die;
		}else{
			$this->data = $this->Faq->findById($id);
		}
	}

	public function load_faq($reset = null) {
		$this->layout = false;
		$conditions = array();
		if(!empty($this->params->query['data']['Search'])){
			if(!empty($this->params->query['data']['Search']['question'])){
				$conditions[] = array(
					'AND' => array(
						'Faq.question LIKE'=>	"%".$this->params->query['data']['Search']['question']."%",
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['answer'])){
				$conditions[] = array(
					'AND' => array(
						'Faq.answer LIKE'=>	"%".$this->params->query['data']['Search']['answer']."%",	
					)
				);	
			}
			if(!empty($this->params->query['data']['Search']['status'])){
				$conditions[] = array(
					'AND' => array(
						'Faq.status'=> $this->params->query['data']['Search']['status'],		
					)
				);	
			}	
		}else{
			$conditions = "";
		}
		$conditions['Faq.status <>'] = 'deleted';	
		$this->Paginator->settings = array('order' => 'Faq.display_order asc','limit' => Configure::read('AdminListingLimit'));
		$FaqData = $this->paginate('Faq',$conditions);
		$this->set('FaqData',$FaqData);		
	}

	public function change_status_faq() {
		$this->layout = false;
		if($this->request->is('ajax')) {
			if($this->request->is('post') && !empty($this->request->data['Faq'])) {
				$this->request->data['Faq']['id'] = base64_decode( $this->request->data['Faq']['id'] );		
				$status = $this->request->data['Faq']['status'];	
				$response = array();
				if($this->Faq->save($this->request->data)) {
					//$this->Session->setFlash('Status has been updated successfully.', 'default', null, 'success');
					$response = array('success' => true,'message' => 'Status has been updated successfully.');
				}else{
					$response = array('success' => false,'message' => 'Opps error please try again.');
				}	
			}else{
				$response = array('success' => false,'message' => 'Invalid request.');
			}
			echo json_encode($response);
			die;
		}else{
			$this->redirect('/');
		}
	}

	public function change_static_page_status() {
		$this->layout = false;
		if($this->request->is('ajax')) {
			if($this->request->is('post') && !empty($this->request->data['ClStaticPage'])) {
				$this->request->data['ClStaticPage']['id'] = base64_decode( $this->request->data['ClStaticPage']['id'] );		
				$status = $this->request->data['ClStaticPage']['status'];
				$response = array();
				if($this->ClStaticPage->save($this->request->data)) {
					//$this->Session->setFlash('Status has been updated successfully.', 'default', null, 'success');
					$response = array('success' => true,'message' => 'Status has been updated successfully.');
				}else{
					$response = array('success' => false,'message' => 'Opps error please try again.');
				}	
			}else{
				$response = array('success' => false,'message' => 'Invalid request.');
			}
			echo json_encode($response);
			die;
		}else{
			$this->redirect('/');
		}	
	}
	 
	public function delete_faq( $id = null){
		$this->layout =  false;
		if( isset($id) && !empty($id) && $this->request->is("ajax") && $this->request->is("DELETE") ){
			$status = 'deleted';
			$this->Faq->deleteAll(array('Faq.id'=>$id));		
			$response = array('success' => true,'message' => 'FAQ has been deleted successfully.');
		}else{
			$response = array('success' => false,'message' => 'Invalid request.');
		}
		echo json_encode($response);
		die;	
	}

	public function change_order(){
		$this->layout = false;
		$data = json_decode($this->data['Faq']['serializedData'] , false );
		if(isset($data)){
			if(!empty($data)){
			 foreach($data as $key => $ids){
			  $this->Faq->updateAll(
			   array('Faq.display_order' => $key),
			   array('Faq.id' => $ids->id)
			  );
			 }
			}
		}
		$this->autoRender = false;
	}
}
?>