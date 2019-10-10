<?php
class UserOrder extends WecontrolAppModel {
	var $name 			= 'UserOrder';
	var $useTable 		= 'user_orders';
	var $actsAs 		= array('Multivalidatable');
	var $validationSets = array(
		
	);
}