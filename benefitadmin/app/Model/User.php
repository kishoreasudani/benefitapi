<?php class User extends AppModel {

	var $name 			= 'User';
	var $useTable 		= 'users';
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
				)
			),
			'password' 	=> array(
				'notEmpty'	=>	array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Please enter password'						
				)
			)
		),
		'register' => array(
			'email'	=> array(
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
			'first_name'	=> array(
				'notEmpty'	=>	array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Please enter first name'						
				)
			),
			'last_name'	=> array(
				'notEmpty'	=>	array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Please enter last name'						
				)
			),
			'password' 	=> array(
				'notEmpty'	=>	array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Please enter password'						
				)
			),
			'confirm_password' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => 'Please confirm password'
				),
				'validatePasswordConfirm' => array(
					'rule' => array('validatePasswordConfirm','password'),
					'message' => 'Password did not match'
				)
			),
			'mobile' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter mobile number'						
					),
					'numeric'	=>	array(
						'rule' 		=> 'numeric',
						'message' 	=> 'Please enter numeric value'						
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
				)
			)
		),
		'add_otp' => array(
			'otp_code'	=> array(
				'notEmpty'	=>	array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Please enter otp.'						
				),
				'numeric'	=>	array(
					'rule' 		=> 'numeric',
					'message' 	=> 'Please enter numeric value'						
				),
			)
		),
		'reset_password' => array(
			'password' 	=> array(
				'notEmpty' =>array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Please enter password.'
				)
			),
			'confirm_password' => array(
				'notEmpty' => array(
					'rule' => 'notEmpty',
					'message' => 'Please confirm password.'
				),
				'validateResetPasswordConfirm' => array(
					'rule' => array('validateResetPasswordConfirm','password'),
					'message' => 'Password did not match.'
				)
			)
		)
	);

	function validateResetPasswordConfirm($data) {   
			
		if ($this->data['User']['password'] !==  $this->data['User']['confirm_password']){
			return false;
		}
		return true;
	}
	function validatePasswordConfirm($data) {

		if ($this->data['User']['password'] !==  $this->data['User']['confirm_password']) {

			return false;
		}
		return true;
	}

	function checkUniqueEmail($data, $fieldName, $type = null) {

		$valid = false;
		$User = new User;
		if(isset($fieldName)) {

			$conditions = array('User.email' => $data['email']);
			if(isset($this->data['User']['id']) && $this->data['User']['id']!= ''):
				$conditions['User.id !='] = $this->data['User']['id'];
			endif;
			$d = $User->find('count', array('conditions'=>$conditions, 'recursive'=>'1'));
			if($d == 0) {

				$valid = true;
			}
		}
		return $valid;
	}
	public function beforeSave($options = array()) {    
	    
	    // password hashing
	    if (isset($this->data[$this->alias]['password'])) {

	        $this->data[$this->alias]['password'] = AuthComponent::password($this->data[$this->alias]['password']);
	    }
	    return true;
	}
}