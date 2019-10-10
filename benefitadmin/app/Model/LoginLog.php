<?php
class LoginLog extends AppModel {
	var $name 			= 'LoginLog';
	var $useTable 		= 'login_logs';
	var $actsAs 		= array('Multivalidatable');
	var $useDbConfig	= 'mongo';
	var $validationSets = array(
		
	);
}