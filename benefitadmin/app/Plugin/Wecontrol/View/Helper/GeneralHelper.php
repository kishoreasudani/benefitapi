<?php
/**
 * Application level View Helper
 *
 * This file is application-wide helper file. You can put all
 * application-wide helper-related methods here.
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       app.View.Helper
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Helper', 'View');

/**
 * Application helper
 *
 * Add your application-wide methods in the class below, your helpers
 * will inherit them.
 *
 * @package       app.View.Helper
 */
class GeneralHelper extends Helper {


	

	function get_state_name( $state_id = null ) {

		App::import("Model", "State");
		$State = new State();
		$stateName = $State->find( 'first', array( 'conditions' => array( 'State.id' => $state_id)));

		if(!empty($stateName)) {

			return ucfirst($stateName['State']['name']);
		}
	}
	function GetDoorBuilding( $order_id = null ) {

		App::import("Model", "OrderPickupAddress");
		$OrderPickupAddress = new OrderPickupAddress();
		$data = $OrderPickupAddress->find( 'first', array( 'conditions' => array( 'OrderPickupAddress.order_id' => $order_id)));

		if(!empty($data)) {

			return ucfirst($data['OrderPickupAddress']['doorman_building']);
		}
	}

	function get_user_name( $user_id = null ) {

		App::import("Model", "Wecontrol.User");
		$User = new User();
		$userName = $User->find( 'first', array( 'conditions' => array( 'User.id' => $user_id)));

		if(!empty($userName)) {

			return ucfirst($userName['User']['first_name'].' '.$userName['User']['last_name']);
		}
	}
	

	function getArticleCount( $user_id = null ) {

		App::import("Model", "Wecontrol.Article");
		$Article = new Article();
		$articleCount = $Article->find( 'count', array( 'conditions' => array( 'user_id' => $user_id)));

		return $articleCount;
	}

	function getAddressCount( $user_id = null ) {

		App::import("Model", "Wecontrol.UserAddress");
		$UserAddress = new UserAddress();
		$addressCount = $UserAddress->find( 'count', array( 'conditions' => array( 'UserAddress.user_id' => $user_id)));

		return $addressCount;
	}


	

	function get_admin_name( $user_id = null ) {

		App::import("Model", "Wecontrol.Admin");
		$Admin = new Admin();
		$userName = $Admin->find( 'first', array( 'conditions' => array( 'Admin.id' => $user_id)));

		if(!empty($userName)) {

			return ucfirst($userName['Admin']['first_name'].' '.$userName['Admin']['last_name']);
		}
	}
	function get_city_name( $city_id = null ) {

		App::import("Model", "Wecontrol.City");
		$City = new City();
		$cityName = $City->find( 'first', array( 'conditions' => array( 'City.id' => $city_id)));

		if(!empty($cityName)) {

			return ucfirst($cityName['City']['name']);
		}
	}
	function get_category( $category_id = null ) {

		App::import("Model", "Wecontrol.Category");
		$Category = new Category();
		$categoryName = $Category->find( 'first', array( 'conditions' => array( 'Category.id' => $category_id)));

		if(!empty($categoryName)) {

			return ucfirst($categoryName['Category']['name']);
		}
	}
	function get_county_name( $county_id = null ) {

		App::import("Model", "Wecontrol.County");
		$County = new County();
		$countyName = $County->find( 'first', array( 'conditions' => array( 'County.id' => $county_id)));

		if(!empty($countyName)) {

			return ucfirst($countyName['County']['name']);
		}
	}
	function get_country_name( $country_id = null ) {

		App::import("Model", "Wecontrol.Country");
		$Country = new Country();
		$countryName = $Country->find( 'first', array( 'conditions' => array( 'Country.id' => $country_id)));

		if(!empty($countryName)) {

			return ucfirst($countryName['Country']['name']);
		}
	}
	
	
	
	function create_time_range($start='00:00', $end='24:00', $interval = '15 mins', $format = '12') {
		$this->layout = false;
	    $startTime = strtotime($start); 
	    $endTime   = strtotime($end);
	    $returnTimeFormat = ($format == '12')?'g:i A':'G:i';

	    $current   = time(); 
	    $addTime   = strtotime('+'.$interval, $current); 
	    $diff      = $addTime - $current;

	    $times = array(); 
	    while ($startTime < $endTime) { 
	        $times[date($returnTimeFormat, $startTime)] = date($returnTimeFormat, $startTime); 
	        $startTime += $diff; 
	    } 
	    $times[date($returnTimeFormat, $startTime)] = date($returnTimeFormat, $startTime);
	    return $times; 
	}

	
}
