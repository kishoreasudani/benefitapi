<?php
class Vendor extends AppModel {
	var $name 			= 'Vendor';
	var $useTable 		= 'vendors';
	var $actsAs 		= array('Multivalidatable');
	
	var $validationSets = array(

		/*add Category*/
		'add' => array(
			'name' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter vendor name.'
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'Name is already exists.'
					),
					
			),
			'logo' => array(
		            'rule1'=>array(
		            'rule' => array('extension',array('jpeg','jpg','png','gif')),
		            'required' => 'true',
		            'allowEmpty' => false,
		            'message' => 'Select a valid logo',
		            'on' => 'create',
		            'last'=>true
		      ),
		     'rule2'=>array(
		        'rule' => array('extension',array('jpeg','jpg','png','gif')),
		        'message' => 'Select a valid logo',
		        'on' => 'update',
		       ),
		    ),

		    'background_logo' => array(
		            'rule1'=>array(
		            'rule' => array('extension',array('jpeg','jpg','png','gif')),
		            'required' => 'true',
		            'allowEmpty' => false,
		            'message' => 'Select a valid background logo',
		            'on' => 'create',
		            'last'=>true
		      ),
		     'rule2'=>array(
		        'rule' => array('extension',array('jpeg','jpg','png','gif')),
		        'message' => 'Select a valid background logo',
		        'on' => 'update',
		       ),
		    ),
		    'description' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter voucher description.'
					)
								
			),

		),


	   /*Edit category*/
		'edit' => array(			
			'name' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter vendor name.'						
					),
					'isUnique' => array(
						'rule'	=> 'isUnique',
						'message'=>	'Name is already exists.'
					),
			),
			 'description' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter voucher description.'
					)				
			),
		)
	
			
	);
}