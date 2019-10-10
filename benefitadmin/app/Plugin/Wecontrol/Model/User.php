<?php
class User extends WecontrolAppModel {
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
		'add' => array(
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
			'confirm_pass'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter confirm password'						
					),
					'validateConfirmPassword' => array(
								'rule' => 'validateConfirmPassword',
								'required' => true,
								'message' => 'Password did not match'
					),
					'minLength' => array(
							'rule' => array('minLength', 5),
							'message' => 'Password must be more than 5 character',
							'last'		=> true
					),
					
			),
			'first_name' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter first name'						
					),
			),
			'last_name' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter last name'						
					),
			),
			'user_name' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter user name'						
					),
			),
			'type' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select user type'						
					),
			),
			'about_me' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter about me'						
					),
			),
			'gender' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select gender'						
					),
			),
			'state_id' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select state'						
					),
			),
			'city_id' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select city'						
					),
			),
		    'invested_amount' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter invested amount'						
					),
			),
			 'budget' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select budget'						
					),
			),
			 'category_id' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select category'						
					),
			),
			 'commercials_type' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select commercial status'						
					),
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
			'user_role_type' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select role'						
					),
			),
			'avatar' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please select image'						
					),
			)
			
		),
		'edit' => array(
			'first_name'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter first name'						
					),
					
			),
			'last_name'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter last name'						
					),
					
			),
		),
		'edit_user' => array(
			'email'	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter email'						
						),
					'Email'	=> array(
						'rule'	=> 'Email',
						'message'=> 'Enter valid email'
						),
					'checkUniqueEmail'	=>	array(
						'rule'		=> 'checkUniqueEmail',
						'message' 	=> 'Email already in use. Please provide a different email'				
						)
			),
			'first_name'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter first name'						
					),
					
			),
			'last_name'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter last name'						
					),
					
			)
		),
		'edit_user_profile' => array(
			
			'first_name'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter first name'						
					),
					
			),
			'last_name'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter last name'						
					),
					
			),
			'username'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter username'						
					),
					
			),
			'mobile'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter mobile'						
					),
					
			),
			'password1'=> array(
					'minLength'	=>	array(
						'rule' 		=> array('minLength',5),
						'allowEmpty' => true,
						'message' 	=> 'Password length must be minimum 5 characters'						
					),					
			),

		),
		'edit_password' => array(

			'old_password'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter old password'						
					),
				

			),
			'password1'=> array(
					'notEmpty'	=>	array(
					'rule' 		=> 'notEmpty',
					'message' 	=> 'Please enter password'						
				),
				'minLength'	=>	array(
					'rule' 		=> array('minLength',5),
					'allowEmpty' => true,
					'message' 	=> 'Password length must be minimum 5 characters'						
				),
					
			),
			'confirm_password1'=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter confirm password'						
					),
					'minLength'	=>	array(
						'rule' 		=> array('minLength',5),
						'allowEmpty' => true,
						'message' 	=> 'Password length must be minimum 5 characters'						
					),
					'compare'    => array(
        			'rule'      => array('validate_passwords'),
        			'message' => 'The passwords you entered do not match.',
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
	);
	public function validate_passwords() {
	    return $this->data[$this->alias]['password1'] === $this->data[$this->alias]['confirm_password1'];
	}

	function checkUniqueEmail($data, $fieldName, $type=null){

		$valid = false;
		$User = new User;
		if(isset($fieldName)) {

			
			$conditions = array('User.email'=>$data['email']);
			//$conditions['User.status <>'] = Configure::read('Status3.delete');
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

	function validateConfirmPassword() {   
		if(!empty($this->data['User']['password'])){		
			if ($this->data['User']['password'] ===  $this->data['User']['confirm_pass']){
				return true;   
			}else{
				return false;  
			}
		}
	}

}