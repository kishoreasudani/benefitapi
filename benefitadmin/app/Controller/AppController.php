<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @package       app.Controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       http://www.opensource.org/licenses/mit-license.php MIT License
 */

App::uses('Controller', 'Controller');

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package		app.Controller
 * @link		http://book.cakephp.org/2.0/en/controllers.html#the-app-controller
 */
class AppController extends Controller {

	var $uses = array('Country', 'Setting','User');
	public $components = array (
		'Auth' => array (
			'authorize' => 'controller'
		),
		'Cookie',
		'Email',
		'RequestHandler',
		'Session'
	);
	public $helpers = array('Html', 'Form', 'Session', 'Cache', 'General');
	public function beforeFilter() {

		$controller_name = $this->params['controller'];
		$action = $this->params['action'];
	}

	/** User Login Check... */
	public function _is_portal_user_login () {

		$_redirect_page_url = $_SERVER["REQUEST_URI"];
		@$exp_redirect_url = explode( Configure::read( 'SiteSettings.rootFolder' ), $_redirect_page_url);
		$_redirect = $exp_redirect_url[1];
		if (!$this->Session->check ('Auth.FrontEndUserMindStock')) {

			if ( !empty ( $_redirect_page_url ) ) {

				# Redirect...
				$this->redirect ( '/users?redirect='.$_redirect );
			} else {

				# Redirect...
				$this->redirect ( '/' );
			}
		}
	}

	function __check_session() {

		if(!$this->Session->check ( 'Auth.FrontEndUserMindStock' )) {

			$this->Session->setFlash('Please login to continue.', 'default', null, 'error');
			$this->redirect(array('controller'=>'users', 'action'=>'index'));
			die;
		}
	}

	public function _is_portal_user_logged_in () {

		if($this->Session->check('Auth.FrontEndUserMindStock')) {

			# Redirect...
			$this->redirect('/');
		}
	}

	public function _getAdminDetails() {

		$data = array();
		$a_data = $this->User->find( 'first', array( 'conditions' => array( 'User.id' => 1)));
		return $a_data;
	}

	public function _userDetails() {

		$this->loadModel('User');
		$userdata = $this->User->find('first', array('conditions' => array('User.id' => $this->Session->read('Auth.FrontEndUserMindStock.id'))));
		return $userdata;
	}
	public function _countryList() {

		$country_data = array();
		$c_data = $this->Country->find('all', array('order' => array('Country.country_name ASC')));

		foreach ($c_data as $key => $value) {

			$country_data[$value['Country']['id']] = ucfirst($value['Country']['country_name']);
		}
		return $country_data;
	}

	public function _stateList() {

		$this->loadModel('State');
		$state_data = array();
		$s_data= $this->State->find( 'all', array( 'order' => array( 'State.state_name ASC')));
		foreach ($s_data as $key => $value) {

			$state_data[$value['State']['id']] = ucfirst($value['State']['state_name']);
		}
		return $state_data;
	}
	public function _cityList() {

		$this->loadModel('City');
		$city_data = array();
		$c_data= $this->City->find( 'all', array( 'order' => array( 'City.city_name ASC')));
		foreach ($c_data as $key => $value) {

			$city_data[$value['City']['id']] = ucfirst($value['City']['city_name']);
		}
		return $city_data;
	}

	function __send_email($email_template = null, $title = null, $email_to = null, $subject = null, $data = null,$attachments = null) {

		$email = new CakeEmail();
		if(Configure::read('Environment' ) == 'local') {

			$email->config('smtp');
		}
		$email->template($email_template);
		if (!empty($attachments) && $attachments != '' && is_array($attachments)) {

			$email->attachments($attachments);
		}
		$email->viewVars(array(
			'title' => $title,
			'data'  => $data
		));
		$email->emailFormat('html');
		$email->to($email_to);
		$email->from(array(Configure::read('Email.Admin') => 'Mind Stock'));
		$email->subject($subject);

		// if ( $this->Session->check  ( 'Auth.FrontEndUserMindStock' ) ) {

		// 	$uData = $this->User->find( 'first', array(
		// 		'conditions' => array( 'User.id' => $this->Session->read  ( 'Auth.FrontEndUserMindStock' )  ),
		// 		'fields'=>array('User.id','User.email_notifications')
		// 	));
		// 	if( $uData['User']['email_notifications'] == 'yes' ) {

		// 		$email->send();
		// 	}
		// } else {

		// 	$email->send();
		// }
		$email->send();
		return;
	}
	function beforeRender() {

		if($this->name == 'CakeError') {

			$this->layout = 'error_layout';
		}
	}

	public function _created_by () {		
		return $this->Session->read  ( 'Auth.FrontEndUserMindStock.id' );
	}

	public function _modified_by () {		
		return $this->Session->read  ( 'Auth.FrontEndUserMindStock.id' );
	}
}