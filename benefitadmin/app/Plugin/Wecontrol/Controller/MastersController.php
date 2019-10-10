<?php
class MastersController extends WecontrolAppController {
	public $name = 'Masters';
	public $uses = array('Wecontrol.NotifyTemplate', 'Wecontrol.Setting', 'Wecontrol.Blog', 'Wecontrol.DailyLimit');
	var $components	=	array('Session','Email','SendEmail','RequestHandler','Paginator','General');
	var $helpers 	= 	array('Html','Form','Session','General');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('change_status','email_templates','email_templates_data','edit_template','setting', 'view_template', 'vouchers_data', 'blogs', 'blogs_data', 'add_blog', 'view_blog', 'edit_blog', 'delete_blog', 'change_order', 'dailylimits', 'dailylimits_data', 'add_limit');			
	}
	// -------------------------------------------------------------------------Settings--------------------------------------------------------------------------------
	public function setting() {
		$this->_is_user_login ();
		if(!empty($this->data)){			
			$this->request->data['Setting']['id'] = 1;
			$this->Setting->save($this->request->data,false);
			$this->Session->setFlash('Settings has been updated successfully.', 'default', null, 'success');
		}else{
			$this->data = $this->Setting->findById(1);
		}
	}
	// ----------------------------------------------------------------------End of Settings-----------------------------------------------------------------------------

	// ----------------------------------------------------------------------Email Templates-----------------------------------------------------------------------------
	public function email_templates() {	
		# Check login status...
 		$this->_is_user_login ();
	}

	public function email_templates_data($reset = null) {
		$this->layout = false;
		$conditions = array();
		if(!empty($this->params->query['data']['Search'])){
			if(!empty($this->params->query['data']['Search']['title'])){
				$conditions[] = array(
					'OR' => array(
						'NotifyTemplate.title LIKE'=>"%".$this->params->query['data']['Search']['title']."%",	 
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['subject'])){
				$conditions[] = array(
					'AND' => array(
						'NotifyTemplate.subject LIKE'=>	"%".$this->params->query['data']['Search']['subject']."%",
					)
				);
			}
		   if(!empty($this->params->query['data']['Search']['status'])){
				$conditions[] = array(
					'AND' => array(
						'NotifyTemplate.status'=>	$this->params->query['data']['Search']['status'],
					)
				);
			}
		}else{
			$conditions = "";
		}	
		$conditions[] = array('NotifyTemplate.notify_type' => 'email');	
		$this->Paginator->settings = array('order' => 'NotifyTemplate.created asc','limit' => Configure::read('AdminListingLimit'));
		$listingData = $this->paginate('NotifyTemplate',$conditions);
		$this->set('listingData',$listingData);		
	}

	public function edit_template( $id = null ) {
		$this->_is_user_login ();
		$id = base64_decode($id);
		if(!empty($this->request->data)) {
			$message	=	array();
			$this->NotifyTemplate->set($this->request->data);
			$this->NotifyTemplate->setValidation('edit');		
			if($this->NotifyTemplate->validates()) {				
				// save the information
				$this->Session->setFlash('Template has been updated successfully.', 'default', null, 'success');
				$this->request->data['NotifyTemplate']['modified_by'] = $this->_modified_by (); 
				$this->NotifyTemplate->save($this->request->data);
				$success =	true;
				$message = "Template data has been updated successfully.";
			}else{
				if(!empty($this->NotifyTemplate->validationErrors)) {
					$success =	false;
					foreach($this->NotifyTemplate->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['NotifyTemplate'.$error_key]	=	$error_value;
					}
				}
			}
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}else{
			$this->data = $this->NotifyTemplate->findById($id);
		}
	}

	public function view_template($id = null){
		$id = base64_decode($id);
		$pages = $this->NotifyTemplate->find('first',array('conditions'=>array('NotifyTemplate.id'=>$id), 'recursive'=>1));
		$user_name[] = $this->Admin->find('first',array('conditions'=>array('Admin.id'=>$pages['NotifyTemplate']['modified_by']), 'fields' =>array('Admin.first_name, Admin.last_name')));
		$this->set('pages',$pages);
		$this->set('user_name',$user_name);
	}
	// ------------------------------------------------------------------------End of Email Templates------------------------------------------------------------

	// --------------------------------------------------------------------------General Functions---------------------------------------------------------------
	public function change_status() {
		$this->_is_user_login ();
		$this->layout = false;
		// $modelname = Inflector::classify( $this->params['controller']);
		if($this->request->is('ajax')) {
			if($this->request->is('post')) {
				$modelname = $this->data['changestatus']['modelName'];
				$this->loadModel($modelname);
				$id = base64_decode($this->request->data['changestatus']['id'] );		
				$status = $this->request->data['changestatus']['status'];
				$response = array();
			 	$updateStatus = array();
				$updateStatus['id'] = base64_decode($this->data['changestatus']['id']);
				$updateStatus['status'] = $this->data['changestatus']['status'];
			 
				if($this->$modelname->save($updateStatus,false)){
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
	// ---------------------------------------------------------------------End of General Functions---------------------------------------------------------------

	// -----------------------------------------------------------------------------Blogs--------------------------------------------------------------------------

	public function blogs() {	
		# Check login status...
 		$this->_is_user_login ();
	}

	public function blogs_data($reset = null) {
		$this->layout = false;
		$conditions = array();
		if(!empty($this->params->query['data']['Search'])){
			if(!empty($this->params->query['data']['Search']['title'])){
				$conditions[] = array(
					'OR' => array(
						'Blog.title LIKE'=>"%".$this->params->query['data']['Search']['title']."%",	 
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['summary'])){
				$conditions[] = array(
					'AND' => array(
						'Blog.summary LIKE'=>	"%".$this->params->query['data']['Search']['summary']."%",
					)
				);
			}
		   if(!empty($this->params->query['data']['Search']['status'])){
				$conditions[] = array(
					'AND' => array(
						'Blog.status'=>	$this->params->query['data']['Search']['status'],
					)
				);
			}
		}else{
			$conditions = "";
		}		
		$this->Paginator->settings = array('order' => 'Blog.display_order asc','limit' => Configure::read('AdminListingLimit'));
		$BlogData = $this->paginate('Blog',$conditions);
		$this->set('BlogData',$BlogData);		
	}

	public function add_blog() {
		$this->_is_user_login (); 
		$success = true;
		$message = array();
		if(!empty($this->request->data) && isset($this->request->data)) {	
			$this->Blog->set($this->data);
			$this->Blog->setValidation('add');
			if($this->Blog->validates()) {
				$this->request->data['Blog']['created'] = date('Y-m-d H:i:s');
				$display_order = $this->Blog->find('first',array(
					'order'=>array('Blog.id DESC'),
					'fields'=>array('Blog.display_order')
				));
				if(isset($display_order) && !empty($display_order)){
					$displayOrder = $display_order['Blog']['display_order']+1;
				}else{
					$displayOrder = 1;
				}
				$this->request->data['Blog']['display_order'] = $displayOrder;
				$this->request->data['Blog']['slug'] = $this->General->parseSlug($this->request->data['Blog']['title']);
				$this->request->data['Blog']['publish_date'] = date('Y-m-d',strtotime($this->request->data['Blog']['publish_date']));
				$this->Blog->create();
				$this->Blog->save($this->request->data,false);   
				$success = true;
				$message = "Blog has been saved successfully.";
				$this->Session->setFlash('Blog has been saved successfully.', 'default', null, 'success');
			}else{
				if(!empty($this->Blog->validationErrors)) {
					$success = false;
					foreach($this->Blog->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Blog'.$error_key]	=	$error_value;
					}
				}
			}	
		echo json_encode(array('success'=>$success, 'message'=>$message));
		die;
		}
	}

	public function edit_blog($id = null) {
		$this->_is_user_login ();
		$id = base64_decode($id); 
		$success = true;
		$message = array();
		if(!empty($this->request->data) && isset($this->request->data)) {	
			$this->Blog->set($this->data);
			$this->Blog->setValidation('add');
			if($this->Blog->validates()) {
				$this->request->data['Blog']['last_updated_by'] = $this->_modified_by();
				$this->request->data['Blog']['created'] = date('Y-m-d H:i:s');
				$display_order = $this->Blog->find('first',array(
					'order'=>array('Blog.id DESC'),
					'fields'=>array('Blog.display_order')
				));
				if(isset($display_order) && !empty($display_order)){
					$displayOrder = $display_order['Blog']['display_order']+1;
				}else{
					$displayOrder = 1;
				}
				$this->request->data['Blog']['display_order'] = $displayOrder;
				$this->request->data['Blog']['publish_date'] = date('Y-m-d',strtotime($this->request->data['Blog']['publish_date']));
				$this->Blog->create();
				$this->Blog->save($this->request->data,false);   
				$this->Session->setFlash('Blog has been updated successfully.', 'default', null, 'success');
				$success = true;
				$message = "Blog has been updated successfully.";
			}else{
				if(!empty($this->Blog->validationErrors)) {
					$success = false;
					foreach($this->Blog->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Blog'.$error_key]	=	$error_value;
					}
				}
			}	
		echo json_encode(array('success'=>$success, 'message'=>$message));
		die;
		}
		$this->data = $this->Blog->findById($id);
	}

	public function delete_blog($id = null){
		$this->layout = false;
		if($this->request->is('ajax')) {
            //prd($this->request->data);		
				$response = array();
				if(!empty($id)) {
					$this->Blog->deleteAll(array('Blog.id' => $id), false);
					$response = array('success' => true,'message' => 'Blog has been deleted successfully.');
				} else {
					$response = array('success' => false,'message' => 'Oops error please try again.');
				}
			echo json_encode($response);
            die;
		} else {
			$this->redirect('/');
		}
	}
	
	public function change_order(){
		$this->layout = false;
		$data = json_decode($this->data['Blog']['serializedData'] , false );
		if(isset($data)){
			if(!empty($data)){
			 foreach($data as $key => $ids){
			  $this->Blog->updateAll(
			   array('Blog.display_order' => $key),
			   array('Blog.id' => $ids->id)
			  );
			 }
			}
		}
		$this->autoRender = false;
	}

	public function view_blog($id = null){
		$id = base64_decode($id);
		$pages = $this->Blog->find('first',array(
					'conditions'=>array('Blog.id'=>$id),
					'recursive'=>1
		));
		$pages['Blog']['last_updated_by'] = $this->Admin->findById($pages['Blog']['last_updated_by']);
		$this->set('pages',$pages);
	}

	// ------------------------------------------------------------------------------End of Blogs------------------------------------------------------------------

	// ------------------------------------------------------------------------------Daily Limits------------------------------------------------------------------

	public function dailylimits() {	
		# Check login status...
 		$this->_is_user_login ();
	}

	public function dailylimits_data($reset = null) {
		$this->layout = false;
		$conditions = array();
		if(!empty($this->params->query['data']['Search'])){
			if(!empty($this->params->query['data']['Search']['limit'])){
				$conditions[] = array(
					'OR' => array(
						'Blog.limit LIKE'=>"%".$this->params->query['data']['Search']['effective_date']."%",	 
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['date'])){
				$conditions[] = array(
					'AND' => array(
						'Blog.effective_date LIKE'=>	"%".$this->params->query['data']['Search']['effective_date']."%",
					)
				);
			}
		   if(!empty($this->params->query['data']['Search']['end_date'])){
				$conditions[] = array(
					'AND' => array(
						'Blog.end_date'=>	$this->params->query['data']['Search']['end_date'],
					)
				);
			}
		}else{
			$conditions = "";
		}		
		$this->Paginator->settings = array('order' => 'DailyLimit.effective_date asc','limit' => Configure::read('AdminListingLimit'));
		$DailyLimitData = $this->paginate('DailyLimit',$conditions);
		$this->set('DailyLimitData',$DailyLimitData);		
	}

	public function add_limit() {
		$this->_is_user_login (); 
		$success = true;
		$message = array();
		if(!empty($this->request->data) && isset($this->request->data)) {	
			$this->DailyLimit->set($this->data);
			$this->DailyLimit->setValidation('add');
			$last_date = $this->DailyLimit->find('first', array('order' => 'DailyLimit.effective_date desc'));
			$this->request->data['DailyLimit']['effective_date'] = date('Y-m-d',strtotime($this->request->data['DailyLimit']['effective_date']));
			if($last_date['DailyLimit']['effective_date']>$this->request->data['DailyLimit']['effective_date']){
				$this->DailyLimit->validationErrors['effective_date'][] = 'Please enter latest affective date';
			}
			if($this->DailyLimit->validates()) {
				$this->request->data['DailyLimit']['created'] = date('Y-m-d H:i:s');
				$this->request->data['DailyLimit']['created_by'] = $this->Session->read('Auth.Admin.id');
				$last_id = $this->DailyLimit->find('first', array('order' => 'DailyLimit.effective_date desc'));
				if(isset($last_id) && !empty($last_id))
				{
					$date = date('Y-m-d', strtotime('-1 day', strtotime($this->request->data['DailyLimit']['effective_date'])));
					$this->DailyLimit->updateAll(array('DailyLimit.end_date' => '"'.$date.'"'), array('DailyLimit.id' => $last_id['DailyLimit']['id'])); 
				}
				$this->DailyLimit->create();
				$this->DailyLimit->save($this->request->data,false);   
				$success = true;
				$message = "Daily limit has been saved successfully.";
				$this->Session->setFlash('Daily limit has been saved successfully.', 'default', null, 'success');
			}else{
				if(!empty($this->DailyLimit->validationErrors)) {
					$success = false;
					foreach($this->DailyLimit->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['DailyLimit'.$error_key]	=	$error_value;
					}
				}
			}	
		echo json_encode(array('success'=>$success, 'message'=>$message));
		die;
		}
	}

	//-------------------------------------------------------------------------End of Daily Limits------------------------------------------------------------------
}