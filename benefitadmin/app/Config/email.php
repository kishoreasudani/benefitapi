<?php
class EmailConfig {

	/*public $smtp = array(
		'transport' => 'Smtp',
		'port'=>'465',
		'timeout'=>'10',
		'host' => '',
		'username'=>'',
		'password'=>'',
		'client' => null,
	);*/

	public $smtp = array(
		'transport' => 'Smtp',
		'port'=>'465',
		'timeout'=>'10',
		'host' => 'ssl://smtp.gmail.com',
		'username'=>'user1.guts@gmail.com',
		'password'=>'wedig@123',
		'client' => null,
	);
}