<?php class GeneralHelper extends AppHelper {

	var $helpers = array('Html', 'Session','Time','Form');

	function __getuserDetails($user_id=null) {

		App::import("Model", "User");
		$user_order_list = array();
		$User = new User();
		$user_order_list = $User->find( 'first', array( 'conditions' => array( 'User.id' => $user_id)));
		if(!empty($user_order_list)) {

			return $user_order_list;
		}
	}
	function getPageDetails($slug=null) {

		App::import("Model", "StaticPage");
		$PageDetails = array();
		$StaticPage = new StaticPage();
		$PageDetails = $StaticPage->find( 'first', array( 'conditions' => array( 'StaticPage.slug' => $slug )));
		if(!empty($PageDetails)) {

			return $PageDetails;
		}
	}

	function get_city_name( $city_id = null ) {

		App::import("Model", "City");
		$City = new City();
		$cityName = $City->find( 'first', array( 'conditions' => array( 'City.id' => $city_id)));
		if(!empty($cityName)) {

			return ucfirst($cityName['City']['name']);
		}
	}

	function get_state_name( $state_id = null ) {

		App::import("Model", "State");
		$State = new State();
		$stateName = $State->find( 'first', array( 'conditions' => array( 'State.id' => $state_id)));
		if(!empty($stateName)) {

			return ucfirst($stateName['State']['name']);
		}
	}

	function get_country_name( $country_id = null ) {

		App::import("Model", "Country");
		$Country = new Country();
		$countryName = $Country->find( 'first', array( 'conditions' => array( 'Country.id' => $country_id)));
		if(!empty($countryName)) {

			return ucfirst($countryName['Country']['name']);
		}
	}
}; ?>