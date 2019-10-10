<?php
class Faq extends AppModel {
	var $name 			= 'Faq';
	var $useTable 		= 'faqs';
	var $actsAs 		= array('Multivalidatable');

	var $validationSets = array(
		
		'add' => array(			
			'question' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter question'						
					),
					'between' => array(
						'rule' => array('lengthBetween', 3, 20),
						'message' => 'Question should be between 3 to 20 characters'
					),
					 
			),
			'answer' 	=> array(
					'notEmpty'	=>	array(
						'rule' 		=> 'notEmpty',
						'message' 	=> 'Please enter answer'						
					),
					'minLength' => array(
						'rule' => array('minLength', 3),
						'message' => 'Answer should be minimum 3 characters long.'
					),
					'maxLength' => array(
						'rule' => array('maxLength', 1000),
						'message' => 'Answer should be minimum 1000 characters long.'
					),
			),	
		),
		
	);

	function checkUniqueName($data, $fieldName, $type=null){

		$valid = false;
		$ClSiteFaq = new ClSiteFaq;
		if(isset($fieldName)) {
			$conditions = array('ClSiteFaq.question'=>$data['question']);
			if(isset($this->data['ClSiteFaq']['id']) && $this->data['ClSiteFaq']['id']!= ''):
				$conditions['ClSiteFaq.id !='] = $this->data['ClSiteFaq']['id'];
			endif;
			$d = $ClSiteFaq->find('count', array('conditions'=>$conditions, 'recursive'=>'1'));
			if($d == 0) {
				$valid = true;
			}
		}
		return $valid;
	}
}
?>