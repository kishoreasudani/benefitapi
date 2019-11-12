<?php

class NotificationsController extends WecontrolAppController {
	public $name = 'Notifications';
	public $uses = array('Wecontrol.UserNotification', 'Wecontrol.UserNotification');
	public  $helpers     =  array('Html','Form','Session', 'Cache');
	public $components = array('Cookie','Email','Session','RequestHandler','Paginator');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index', 'notification_data', 'send_notifications', 'delete_notification', 'user_notifications', 'user_notifications_data', 'add_notification', 'delete_user_notification','delete_multiple_notification');			
	}

	public function index() {
		# Check login status...
		$this->_is_user_login ();
	}

	public function notification_data($reset = null) {

		$this->layout = false;
		$conditions = array();
		$this->UserNotification->bindModel(array(
			'belongsTo' => array(
				'Admin' => array(
					'className' => 'Admin',
					'foreignKey' => 'sender_id',
					'fields' => array('Admin.first_name', 'Admin.last_name')
				),
				'User' => array(
					'className' => 'User',
					'foreignKey' => 'receiver_id',
					'fields' => array('User.first_name', 'User.last_name')
				)
			)
		));
		if(!empty($this->params->query['data']['Search'])){
			
			if(!empty($this->params->query['data']['Search']['name'])){
				$conditions[] = array(
					'AND' => array(
						'UserNotification.notification LIKE'=>	"%".$this->params->query['data']['Search']['name']."%",
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['receiver'])){
				$conditions[] = array(
					'OR' => array(
						'User.first_name LIKE'=>"%".$this->params->query['data']['Search']['receiver']."%",
						'User.last_name LIKE'=>"%".$this->params->query['data']['Search']['receiver']."%",	 
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['sender'])){
				$conditions[] = array(
					'OR' => array(
						'Admin.first_name LIKE'=>"%".$this->params->query['data']['Search']['sender']."%",
						'Admin.last_name LIKE'=>"%".$this->params->query['data']['Search']['sender']."%",	 
					)
				);
			}
			
		}

		//$this->loadModel('Notification');
		
		
		$this->Paginator->settings = array('limit' => Configure::read('AdminListingLimit'),'order'=>'UserNotification.created DESC');
		$notification_data = $this->paginate('UserNotification',$conditions);
		$this->set('notification_data',$notification_data);
		// /prd($notification_data);

	}
	
	public function send_notifications() {
		$this->_is_user_login (); 
		$this->loadModel('Wecontrol.User');
		$user_list = $this->User->find('list', array('conditions'=>array('status'=>'Active'),'fields'=>array('id','first_name')));
		$this->set('user_list',$user_list);
		$success = true;
		$message = array();
		if(!empty($this->request->data) && isset($this->request->data)) {	
			//prd($this->request->data);
			$this->UserNotification->set($this->data);
			$this->UserNotification->setValidation('add');
			if($this->UserNotification->validates()) {
				$this->request->data['UserNotification']['sender_id'] = $this->_modified_by ();
				$this->request->data['UserNotification']['created'] = date('Y-m-d H:i:s');
				foreach($this->UserNotification->data['UserNotification']['receiver_id'] as $key => $value)
				{	
					
					$this->request->data['UserNotification']['receiver_id'] = $value;
					$this->UserNotification->create();
					$this->UserNotification->save($this->request->data,false);
					$fcm_user_id=$this->request->data['UserNotification']['receiver_id'];
					$device_token = $this->UserDevice->find('first', array('conditions'=>array('user_id'=>$fcm_user_id),'fields'=>array('device_token'), 'order' => 'CREATED desc'));
					// prd($device_token);
					$this->__send_notification_functio($device_token['UserDevice'],$title,$this->request->data['UserNotification']['message']);
				}  						
				$success = true;
				$message = "Push Notification has been send successfully.";
				$this->Session->setFlash('Push Notification has been send successfully.', 'default', null, 'success');
			}else{
				if(!empty($this->UserNotification->validationErrors)) {
					$success = false;
					foreach($this->UserNotification->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['UserNotification'.$error_key]	=	$error_value;
					}
				}
			}	
		echo json_encode(array('success'=>$success, 'message'=>$message));
		die;
		}
	}

	public function delete_notification(){
		$this->layout =  false;
		$id = $this->request->data['UserNotification']['id'];
		if( isset($id) && !empty($id) && $this->request->is("ajax") && $this->request->is("DELETE") ){
			$this->UserNotification->deleteAll( array('UserNotification.id'=>$id));
			//$this->Notification->deleteAll( array('Notification.id'=>$id));
			$response = array('success' => true,'message' => 'Notification has been deleted successfully.');			
									
		}else{
			$response = array('success' => false,'message' => 'Invalid request.');
		}
		echo json_encode($response);
		die;	
	}



	public function delete_multiple_notification(){
		$this->layout = false;
		if($this->request->is('ajax')) {	
		       $deleteData = 	$this->request->data['deleteData'];
				$response = array();
				if(!empty($deleteData)) {
					foreach ($deleteData as $key => $value) {
						$this->UserNotification->deleteAll(array('UserNotification.id' => $value), false);
					}
					$response = array('success' => true,'msg' => 'Notifications has been deleted successfully.');
				} else {
					$response = array('success' => false,'msg' => 'Oops error please try again.');
				}
			echo json_encode($response);
            die;
		} else {
			$this->redirect('/');
		}
    }
	
	public function add_notification() {

		$this->_is_user_login (); 
		$success = true;
		$message = array();
		if(!empty($this->request->data) && isset($this->request->data)) {
			$user_list = $this->User->find('list', array('conditions'=>array('status'=>'Active'),'fields'=>array('id','first_name')));
			// prd($user_list);
			$this->UserNotification->set($this->request->data);
			$this->UserNotification->setValidation('add');
			if($this->UserNotification->validates()) {
				$this->request->data['UserNotification']['sender_id'] = $this->_modified_by ();
				$this->request->data['UserNotification']['created'] = date('Y-m-d H:i:s');
				$this->request->data['UserNotification']['type'] = 'common';
				foreach($user_list as $key => $value)
				{	
					
					$this->request->data['UserNotification']['receiver_id'] = $key;
					$this->UserNotification->create();
					$this->UserNotification->save($this->request->data,false);
					//$title = 'Jenesse 4 Hope';
					//	$fcm_user_id=$this->request->data['Notification']['user_id'];
					//	$device_token = $this->User->find('list', array('conditions'=>array('user_type'=>'Registered','status'=>'Active','id'=>$fcm_user_id,'push_notification'=>'On'),'fields'=>array('id','device_token')));
				}				
				$success = true;
				$message = "User Notification has been send successfully.";
				$this->Session->setFlash('User Notification has been send successfully.', 'default', null, 'success');
			}else{
				if(!empty($this->UserNotification->validationErrors)) {
					$success = false;
					foreach($this->UserNotification->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['UserNotification'.$error_key]	=	$error_value;
					}
				}
			}	
		echo json_encode(array('success'=>$success, 'message'=>$message));
		die;
		}
	}
	
}