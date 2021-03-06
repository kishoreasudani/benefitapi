<?php
class Voucher extends WecontrolAppModel {
	var $name 			= 'Voucher';
	var $useTable 		= 'vouchers';
	var $actsAs 		= array('Multivalidatable');
	var $validationSets = array(
		/*Edit Template*/
		'add' => array(
			'name' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter name.'
					),
								
			),

			'vendor_id' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please select vendor.'
					),			
			    ),

			'code' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter voucher code.'
					),
					'isUnique'	=>	array(
						'rule'		=> 'isUnique',
						'message' 	=> 'Code is already in use. Please provide a different code'				
					)					
			),

			'coins_required' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter required coins.'
					),
					'decimal' => array(
						'rule'	=> 'decimal',
						'message'=>	'Coins should be numeric.'
					),					
			),
			'discount_type' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please select discount type.'
					),				
			),
			'amount' => array(
					'decimal' => array(
						'rule'	=> 'decimal',
						'message'=>	'Amount should be numeric.'
					),					
			),
			'min_purchase' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter minimum purchase amount.'
					),
					'decimal' => array(
						'rule'	=> 'decimal',
						'message'=>	'Amount should be numeric.'
					),				
			),
			
			'start_date' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter start date.'
					),				
			),
			'end_date' => array(
					'notEmpty' => array(
						'rule'	=> 'notEmpty',
						'message'=>	'Please enter end date.'
					),					
			),
		),
	);

}