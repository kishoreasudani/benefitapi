<?php
class Category extends AppModel {
	var $name 			= 'Category';
	var $useTable 		= 'categories';
	var $actsAs 		= array('Multivalidatable');

}