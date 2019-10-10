<?php
class LoginLog extends WecontrolAppModel {
	var $name 			= 'LoginLog';
	var $useTable 		= 'admins';
	var $actsAs 		= array('Multivalidatable');
	var $validationSets = array(
		
	);
}