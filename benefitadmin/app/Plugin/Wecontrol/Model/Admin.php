<?php
class Admin extends AppModel {
	var $name 			= 'Admin';
	var $useTable 		= 'admins';
	var $actsAs 		= array('Multivalidatable');

	var $validationSets = array(
		'login' => array(
			'email'	=> array(	
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter email'						
						),
					'Email'	=> array(
						'rule'	=> 'Email',
						'message'=> 'A valid email is required'
						),					
			),
			'username'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter username'						
						),
									
			),
			'password' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter password'						
					),
			)
		),
		'send_mail' => array(
			'email1'	=> array(	
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter email'						
						),
					'Email'	=> array(
						'rule'	=> 'Email',
						'message'=> 'A valid email is required'
						),					
			)
		),
		'sign_up' => array(
			'u_email'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter email'						
					),
					'Email'	=> array(
						'rule'	=> 'Email',
						'message'=> 'A valid email is required'
					),	
					'checkUniqueEmail'	=>	array(
						'rule'		=> 'checkUniqueEmail',
						'message' 	=> 'Email is already in use. Please provide a different email'				
					)				
			),
			'u_first_name'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter first name'						
						),
									
			),
			'u_mobile'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter cell phone number'						
						)			
			),
			'u_last_name'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter last name'						
						),
									
			),
			'u_password' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter password'						
					),
			),
			'u_conf_password' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Please confirm password',
						
					),
					'validatePasswordConfirm' => array(
						'rule' => array('validatePasswordConfirm','password'),
						'message' => 'Password did not match',
						
					),
				),
		),
		'change_password' => array(
			'old_password' 	=> array(
				'notEmpty'	=>	array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Please enter old password'
				)
			),				
			'new_password' 	=> array(
				'notEmpty'	=>	array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Please enter new password'
				),
			),
			'confirm_password' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => 'Please enter confirm password',
					
				),
				'validateUserPasswordConfirm' => array(
					'rule' => array('validateUserPasswordConfirm','password'),
					'message' => 'Password did not match',
					
				),
			)
		),
		'admin_profile' => array(
			
			 'first_name'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter first name'						
						),
					'alpha' => array(
						"rule" => array('custom', "/^[a-zA-Z]+$/"),
						'message' => 'First name should be alphabetic.'
					)
									
			),
			'last_name' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter last name'						
					),
					'alpha' => array(
						"rule" => array('custom', "/^[a-zA-Z]+$/"),
						'message' => 'Last name should be alphabetic.'
					)
			),
			'role_type' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select role'						
					),
			),
			 
			 
			 
		),
		'forgotpass' => array(
			'email'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter email.'						
						),
					'Email'	=>	array(
						'rule' 		=> 'Email',
						'message' 	=> 'A valid email is required.'						
					),
			)
		),
		'reset_password' => array(
				'password' 	=> array(
					'notEmpty' =>array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter password.',
						
					),
				),
				'confirm_password' => array(
					'notEmpty' => array(
						'rule' => 'notEmpty',
						'message' => 'Please confirm password.',
						
					),				
					'validateResetPasswordConfirm' => array(
						'rule' => array('validateResetPasswordConfirm','password'),
						'message' => 'Password did not match.',

					),
					
				)
			)
		,
		'add' => array(
			'first_name' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter first name'
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'First name should be between 3 to 20 characters',
						'last' => true
					),
					'alpha' => array(
						"rule" => array('custom', "/^[a-zA-Z]+$/"),
						'message' => 'First name should be alphabetic.'
					)
					
			),
			'last_name' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter last name'
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'Last name should be between 3 to 20 characters',
						'last' => true
					),
					'alpha' => array(
						"rule" => array('custom', "/^[a-zA-Z]+$/"),
						'message' => 'Last name should be alphabetic.'
					)
					
			),
			'email'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter email'						
						),
					'Email'	=> array(
						'rule'	=> 'Email',
						'message'=> 'A valid email is required.'
						),
					'checkUniqueUserEmail'	=>	array(
						'rule'		=> 'checkUniqueUserEmail',
						'message' 	=> 'Email is already in use. Please provide a different email.'				
						)
			),
			'username'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter user name'						
						),
					 
					'checkUniqueUserName'	=>	array(
						'rule'		=> 'checkUniqueUserName',
						'message' 	=> 'Username is already in use. Please provide a different.'				
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'Username should be between 3 to 20 characters',
						'last' => true
					),
						
			),
			'password' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter password'						
					),
					'minLength' => array(
							'rule' => array('minLength', 5),
							'message' => 'Password must be more than 5 character',
							'last'		=> true
					),
			),
			'confirm_password'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter confrim password'						
					),
					'validateConfirmPassword' => array(
								'rule' => 'validateConfirmPassword',
								'required' => true,
								'message' => 'Password did not match.'
					),
					'minLength' => array(
							'rule' => array('minLength', 5),
							'message' => 'Password must be more than 5 character',
							'last'		=> true
					),
					
			)
		),
		'edit' => array(
			'email'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter email'						
						),
					'Email'	=> array(
						'rule'	=> 'Email',
						'message'=> 'Enter valid email.'
						),
					'checkUniqueUserEmail'	=>	array(
						'rule'		=> 'checkUniqueUserEmail',
						'message' 	=> 'Email already in use. Please provide a different email.'				
						)
			),
			'first_name'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter first name'						
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'First name should be between 3 to 20 characters',
						'last' => true
					),
					'alpha' => array(
						"rule" => array('custom', "/^[a-zA-Z]+$/"),
						'message' => 'First name should be alphabetic.'
					)
					
			),
			'last_name'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter last name'						
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'Last name should be between 3 to 20 characters',
						'last' => true
					),
					'alpha' => array(
						"rule" => array('custom', "/^[a-zA-Z]+$/"),
						'message' => 'Last name should be alphabetic.'
					)
					
			),
			'username'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter user name'						
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'Username should be between 3 to 20 characters',
						'last' => true
					),
					
			),
			
		),

	);

	function validateUserPasswordConfirm($data) {   
			
		if ($this->data['Admin']['new_password'] !==  $this->data['Admin']['confirm_password']){
			return false;
		}
		return true;
	}

	function validateResetPasswordConfirm($data) {   
			
		if ($this->data['Admin']['password'] !==  $this->data['Admin']['confirm_password']){
			return false;
		}
		return true;
	}
	function validatePasswordConfirm($data) {   
			
		if ($this->data['Admin']['u_password'] !==  $this->data['Admin']['u_conf_password']){
			return false;
		}
		return true;
	}

	function checkUniqueEmail($data, $fieldName, $type=null){

		$valid = false;
		$Admin = new Admin;
		if(isset($fieldName)) {

			
			$conditions = array('Admin.email'=>$data['u_email']);
			//$conditions['Admin.status <>'] = Configure::read('Status3.delete');
			if(isset($this->data['Admin']['id']) && $this->data['Admin']['id']!= ''):
				$conditions['Admin.id !='] = $this->data['Admin']['id'];
			endif;
			
			$d = $Admin->find('count', array('conditions'=>$conditions, 'recursive'=>'1'));
			
			if($d == 0) {
				$valid = true;
			}
		}
		return $valid;
	}

	function checkUniqueUserEmail($data, $fieldName, $type=null){

		$valid = false;
		$Admin = new Admin;
		if(isset($fieldName)) {

			
			$conditions = array('Admin.email'=>$data['email']);
			$conditions['Admin.status <>'] = 'deleted';
			if(isset($this->data['Admin']['id']) && $this->data['Admin']['id']!= ''):
				$conditions['Admin.id !='] = $this->data['Admin']['id'];
			endif;
			
			$d = $Admin->find('count', array('conditions'=>$conditions, 'recursive'=>'1'));
			
			if($d == 0) {
				$valid = true;
			}
		}
		return $valid;
	}

	function checkUniqueUserName($data, $fieldName, $type=null){

		$valid = false;
		$Admin = new Admin;
		if(isset($fieldName)) {

			
			$conditions = array('Admin.username'=>$data['username']);
			//$conditions['User.status <>'] = Configure::read('Status3.delete');
			if(isset($this->data['Admin']['id']) && $this->data['Admin']['id']!= ''):
				$conditions['Admin.id !='] = $this->data['Admin']['id'];
			endif;
			
			$d = $Admin->find('count', array('conditions'=>$conditions, 'recursive'=>'1'));
			
			if($d == 0) {
				$valid = true;
			}
		}
		return $valid;
	}

	function validateConfirmPassword() {   
		if(!empty($this->data['Admin']['password'])){		
			if ($this->data['Admin']['password'] ==  $this->data['Admin']['confirm_password']){
				return true;   
			}else{
				return false;  
			}
		}
	}

}