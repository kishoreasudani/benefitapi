<?php
class DailyLimit extends WecontrolAppModel {
	var $name 			= 'DailyLimit';
	var $useTable 		= 'daily_limits';
	var $actsAs 		= array('Multivalidatable');
    var $validationSets = array(
		/*add Category*/

		'add' => array(
			'effective_date' => array(
				'isUnique' => array(
					'rule'	=> 'isUnique',
					'message'=>	'Limit for this day has already been added, choose another day.'
                ),
                'notEmpty' => array(
                    'rule'	=> 'notEmpty',
                    'message'=>	'Please select effective date.'
                ),
					
            ),
            'limit' => array(
                'notEmpty' => array(
                    'rule'	=> 'notEmpty',
                    'message'=>	'Please enter limit.'
                ),
                
        ),

		)
	
			
	);
}