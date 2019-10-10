<?php
class Coin extends WecontrolAppModel {
	var $name 			= 'Coin';
	var $useTable 		= 'coins';
	var $actsAs 		= array('Multivalidatable');

}