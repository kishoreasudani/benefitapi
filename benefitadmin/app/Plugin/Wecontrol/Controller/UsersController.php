<?php
class UsersController extends WecontrolAppController {
	public $name = 'Users';
	public $uses = array('Wecontrol.User','Wecontrol.City','Wecontrol.State','UserAddress','Wecontrol.Coin','Wecontrol.Running','Wecontrol.RunningHistory');
	public $components = array(
		'Auth' => array(
			'authenticate' => array(
				'Form' => array(
					'fields' => array( 'username' => 'username' ),
				),
			)
		),
		'Cookie',
		'Email',
		'Session',
		'RequestHandler',
		'Paginator','PImage', 'PhpExcel'
	);

	public $helpers = array('Wecontrol.General');	
	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow( 'index','change_status','delete_user','users_data','add','change_approved_status', 'edit', 'view_vouchers', 'download_sheet');			
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
		$this->loadModel("UserOrder");
		$this->User->bindModel(array(
			'hasOne' => array(
				'Coin' => array(
					'className' => 'Coin',
					'foreignKey' => 'user_id',
					'fields' => array('Coin.total_coins','Coin.total_used')
				),
				'Running' => array(
					'className' => 'Running',
					'foreignKey' => 'user_id',
					'fields' => array('Running.total_steps')
				)
			),
			'hasMany' => array(
				'RunningHistory' => array(
					'className' => 'RunningHistory',
					'foreignKey' => 'user_id',
					'conditions' => array('RunningHistory.created' => date(dateFormat)),
					'fields' => array('RunningHistory.steps')
				)
			),
		));
		if(!empty($this->params->query['data']['Search'])){
			if(!empty($this->params->query['data']['Search']['name'])){
				$conditions[] = array(
					'OR' => array(
						'User.first_name LIKE'=>"%".$this->params->query['data']['Search']['name']."%",
						'User.last_name LIKE'=>"%".$this->params->query['data']['Search']['name']."%",	 
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['email'])){
				$conditions[] = array(
					'OR' => array(
						'User.email LIKE'=>	"%".$this->params->query['data']['Search']['email']."%",
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['mobile'])){
				$conditions[] = array(
					'OR' => array(
						'User.mobile LIKE'=>"%".$this->params->query['data']['Search']['mobile']."%",
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['total_coins'])){
				$conditions[] = array(
					'OR' => array(
						'Coin.total_coins BETWEEN ? AND ?'=>array('0',$this->params->query['data']['Search']['total_coins']),
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['total_used'])){
				$conditions[] = array(
					'OR' => array(
						'Coin.total_used BETWEEN ? AND ?'=>array('0',$this->params->query['data']['Search']['total_used']),
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['status'])){
				$conditions[] = array(
					'AND' => array(
						'User.status'=>$this->params->query['data']['Search']['status'],
					)
				);
			}
			 
		}else{
			$conditions = "";
		}	
	  
		$this->Paginator->settings = array('order' => 'User.id asc','limit' => Configure::read('AdminListingLimit'));
		$listingData = $this->paginate('User',$conditions);
		$userVoucherList = array();
		$userVoucherList = $listingData;
		foreach($listingData as $key => $value){
			$userVoucherList[$key]['User']['count'] = $this->UserOrder->find('count', array('conditions' => array('user_id' => $value['User']['id'], 'reference_type' => 'voucher')));
		}
		$this->set('user_list',$userVoucherList);
		$this->Session->write('user_list', $userVoucherList);

	}

	public function edit( $id = null ) {
		$this->_is_user_login ();
		$id = base64_decode($id);
		$this->loadModel('City');
		 
		if(!empty($this->request->data)) {
			// prd($this->data);
			$message	=	array();
			$this->User->set($this->request->data);
			$this->User->setValidation('edit');		
			if($this->User->validates()) {				
				// save the information
				$this->Session->setFlash('User has been updated successfully.', 'default', null, 'success');
				if($this->User->save($this->request->data)) {
					$data = $this->Coin->findByUserId($this->request->data['User']['id']);
					if(isset($data) && !empty($data)){
						$this->Coin->updateAll(array('Coin.total_coins'=>"'".$this->request->data['Coin']['total_coins']."'"),array('Coin.user_id'=>$this->request->data['User']['id']));
					}
					else{
						$this->request->data['Coin']['user_id'] = $this->request->data['User']['id'];
						$this->Coin->save($this->request->data['Coin']);
					}
	            	$last_insert_id    	= $id;
		           	$dowloadPath   	= Configure::read('SiteSettings.Relative.UserImage').$id;
 
		            if(!empty($this->data['User']['image1']['name'])){
		                $fileName    = $this->data['User']['image1']['name'];
		                $fileType    = $this->data['User']['image1']['type'];
		                $fileTmpName = $this->data['User']['image1']['tmp_name'];
		                $fileError   = $this->data['User']['image1']['error'];
		                $fileSize    = $this->data['User']['image1']['size'];
		                $file_type   = explode('.', $fileName);
		                $ext_name    = array_reverse($file_type);
		                $ext         = strtolower($ext_name[0]);
						$fileNewName = strtolower($ext_name[1]).'_'.time().'.'.$ext;
	                   	if(!is_dir($dowloadPath)){
	                    	@mkdir($dowloadPath, 0777);
	                  	}
						@move_uploaded_file($fileTmpName, $dowloadPath.'/'.$fileNewName);
	                   	$result3 = $this->PImage->resizeImage(
							$cType = 'resize',
							$fileNewName, 
							$dowloadPath.DS,
							$dowloadPath.DS.$fileNewName,
							'200',
							'200',
							$quality = 100,
							$bgcolor = true
						);
	                    $this->User->updateAll(array('User.avatar'=>"'".$fileNewName."'"),array('User.id'=>$last_insert_id));
		            }
					//$this->Session->setFlash('Voucher has been updated successfully.', 'default', null, 'success');
					$success = true;
					$message = "User data has been updated successfully.";
				} else {
					$success = false;
					$message = "User data could not be updated. Please, try again.";	
				}
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
			$this->User->bindModel(array(
				'hasOne' => array(
					'Coin' => array(
						'className' => 'Coin',
						'foreignKey' => 'user_id',
						'fields' => array('Coin.total_coins')
					)
				)
			));
			$this->data = $this->User->findById($id); 
		}
	}

	public function add() {
		$this->_is_user_login ();
		if(!empty($this->request->data)) {
			$message	=	array();
			$this->User->set($this->request->data);
			$this->User->setValidation('add');		
			if($this->User->validates()) {	
			// save the information
				$this->request->data['User']['dob'] =  date('Y-m-d',strtotime($this->request->data['User']['dob']));
				$this->request->data['User']['status'] =  'active';
				$this->request->data['User']['password'] 	= $this->__get_password_encoded($this->data['User']['password']);
				$this->User->create();
				$this->User->save($this->request->data,false);
				// Mail goes to users
				$password = $this->request->data['User']['confirm_password'];
				$email = $this->request->data['User']['email'];
				$email_to = $email;
				$username = $this->request->data['User']['first_name'];			
		        $data = array('username' => $username , 'password'=>$password,'email'=>$email  );
		        $title = 'User Register';
		        $subject = 'User Register';
		        $this->__send_email('new_user_register',$title,$email_to,$subject,$data);
				$success =	true;
				$this->Session->setFlash('User has been added successfully.', 'default', null, 'success');
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
		} 

	}
	
	public function change_status() {
		//$this->_is_user_login ();
		$this->layout = false;
		if($this->request->is('ajax')) {
			if( !empty($this->request->data)) {				
					$this->request->data['User']['id'] = base64_decode( $this->request->data['User']['id'] );		
					$status = $this->request->data['User']['status'];
					$response = array();
					if($this->User->save($this->request->data)) {						
						$response = array('success' => true,'msg' =>' Status has been updated successfully.');
					}else{
						$response = array('success' => false,'msg' => 'Opps error please try again.');
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

	public function change_approved_status() {
		$this->layout = false;
		
		$moduleName = '';
		if($this->request->is('ajax')) {
			if( !empty($this->request->data)) {

				if(!empty($this->request->data['Article']) && $this->request->data['Article']['model'] == 'Article'){
					$moduleName = $this->request->data['Article']['model'];
				}else if(!empty($this->request->data['User']) && $this->request->data['User']['model'] == 'User'){
					$moduleName = $this->request->data['User']['model'];
				}
				if(!empty($moduleName)){

					$updateData[$moduleName]['id'] = base64_decode($this->request->data[$moduleName]['id']);		
					$updateData[$moduleName]['approved_status'] = $this->request->data[$moduleName]['status'];
					

					// prd($status);
					$response = array();
					//prd($updateData); die();
					if($this->$moduleName->save($updateData)) {						
						$response = array('success' => true,'msg' =>' status has been updated successfully.');
					}else{
						$response = array('success' => false,'msg' => 'Opps error please try again.');
					}
				}else{
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

	public function delete_user(){
		$this->layout = false;
		if($this->request->is('ajax')) {
			if(!empty($this->request->data['User'])) {
				$id = $this->data['User']['id'];		
				$response = array();
				if(!empty($id)) {
					$this->User->deleteAll(array('User.id' => $id), false);
					$this->loadModel("Wecontrol.UserLoginLogs");
					$this->loadModel("Wecontrol.Coin");
					$this->loadModel("Wecontrol.CoinHistory");
					$this->loadModel("Wecontrol.Running");
					$this->loadModel("Wecontrol.RunningHistory");
					$this->UserLoginLogs->deleteAll(array('UserLoginLogs.user_id' => $id), false);
					$this->Coin->deleteAll(array('Coin.user_id' => $id), false);
					$this->CoinHistory->deleteAll(array('CoinHistory.user_id' => $id), false);
					$this->Running->deleteAll(array('Running.user_id' => $id), false);
					$this->RunningHistory->deleteAll(array('RunningHistory.user_id' => $id), false);
					$response = array('success' => true,'msg' => 'User has been deleted successfully.');
				} else {
					$response = array('success' => false,'msg' => 'Oops error please try again.');
				}

			} else {
				$response = array('success' => false,'msg' => 'Invalid request.');
			}
			echo json_encode($response);
			die;
		} else {
			$this->redirect('/');
		}
	}
	
	public function view_vouchers($id = null){

		$id = base64_decode($id);
		$this->loadModel("UserOrder");
		$this->loadModel("Voucher");
		$this->UserOrder->bindModel(array(
			'belongsTo' => array(
				'Voucher' => array(
					'className' => 'Voucher',
					'foreignKey' => 'reference_id',
					'fields' => 'name, code'
				)
			)
		));
		$conditions = array('UserOrder.user_id' => $id, 'UserOrder.reference_type' => 'voucher');
		$this->Paginator->settings = array('order' => 'UserOrder.id asc','limit' => Configure::read('AdminListingLimit'));
		$listingData = $this->paginate('UserOrder',$conditions);
		$this->set('listingData', $listingData);
	}

	public function download_sheet($reset = null){

		// create new empty worksheet and set default font
		$this->PhpExcel->createWorksheet()->setDefaultFont('Calibri', 12);
		// define table cells
		$table = array(
			array('label' => __('Name')),
			array('label' => __('Email')),
			array('label' => __('Mobile')),
			array('label' => __('Total Coins')),
			array('label' => __('Used Coins')),
			array('label' => __('Total Steps')),
			array('label' => __("Vouchers Redeemed")),
			array('label' => __("Created"))
		);
		// add heading with different font and bold text
		$this->PhpExcel->addTableHeader($table, array('name' => 'Cambria', 'bold' => true));
		$userdata = $this->Session->read('user_list');
		// add data
		foreach ($userdata as $d) {
			$this->PhpExcel->addTableRow(array(
				$d['User']['first_name'].' '.$d['User']['last_name'],
				$d['User']['email'],
				$d['User']['mobile'],
				$d['Coin']['total_coins'],
				$d['Coin']['total_used'],
				$d['Running']['total_steps'],
				$d['User']['count'],
				$d['User']['created']
			));
		}
		$currentDate = date('d-m-Y');
		$filename = $currentDate.'_user_report.csv';
		// close table and output
		$this->PhpExcel->addTableFooter()->output($filename);

	}

}
