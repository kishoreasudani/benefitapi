<?php
//App::uses('AppController', 'Controller');
class DashboardController extends WecontrolAppController {
	public $name = 'Dashboard';
	var $uses = array('Wecontrol.User', 'Wecontrol.Voucher', 'Wecontrol.Blog', 'Wecontrol.UserOrder', 'Wecontrol.CoinHistory', 'Wecontrol.RunningHistory', 'Wecontrol.UserLoginLogs');
	var $components = array('Session','Cookie','RequestHandler','Email','Paginator','SendEmail',
			'Auth' => array(
				'authenticate' => array(
					'Form' => array(
						'fields' => array( 'username' => 'username' )
					),
				)
			)
		);
	var $helpers = array('Html', 'Form', 'Session', 'Wecontrol.General' );

	function beforeFilter(){
		parent::beforeFilter();	
		$this->Auth->allow('index', 'getChartData');						
	}
	
	public function index(){

		$this->_is_user_login ();
	
		$usersListing = $this->User->find('all',array(
			'conditions'=>array('User.status'=>'active'),
			'order'=>array('User.created DESC'),
			'limit'=>5
			));

		$vouchersListing = $this->Voucher->find('all',array(
			'order'=>array('Voucher.created DESC'),
			'limit'=>5
			));

		$blogsListing = $this->Blog->find('all',array(
			'order'=>array('Blog.created DESC'),
			'limit'=>5
			));

		$this->loadModel("Voucher");
		$voucherlist = $this->Voucher->find('list', array('fields' => array('name')));
		$userVoucherList = array();
		$i = 0;
		foreach($voucherlist as $key => $value){
			$userVoucherList[$i]['count'] = $this->UserOrder->find('count', array('conditions' => array('reference_id' => $key, 'reference_type' => 'voucher')));
			$userVoucherList[$i]['voucher'] = $value;
			$i++;
		}
		usort($userVoucherList, function($a, $b) {
			return $b['count'] - $a['count'];
		});

		$users = array();
		$users['today_users'] = $this->User->find('count', array('conditions'=>array('DATE(User.created)'=>date('Y-m-d'))));
		$users['this_week_users'] = $this->User->find('count', array('conditions'=>array('DATE(User.created) >='=>date('Y-m-d', strtotime('Monday This Week')))));
		$users['this_month_users'] = $this->User->find('count', array('conditions'=>array('DATE(User.created) >='=>date('Y-m-d', strtotime('first day of this month')))));
		$users['6_month_users'] = $this->User->find('count', array('conditions'=>array('DATE(User.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(User.created) >='=>date('Y-m-d', strtotime('-6 months')))));
		$users['this_year_users'] = $this->User->find('count', array('conditions'=>array('DATE(User.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(User.created) >='=>date('Y-m-d', strtotime('1 january this year')))));
		
		$vouchers = array();
		$vouchers['today_users'] = $this->UserOrder->find('count', array('conditions'=>array('DATE(UserOrder.created)'=>date('Y-m-d'), 'reference_type' => 'voucher')));
		$vouchers['this_week_users'] = $this->UserOrder->find('count', array('conditions'=>array('DATE(UserOrder.created) >='=>date('Y-m-d', strtotime('Monday This Week')), 'reference_type' => 'voucher')));
		$vouchers['this_month_users'] = $this->UserOrder->find('count', array('conditions'=>array('DATE(UserOrder.created) >='=>date('Y-m-d', strtotime('first day of this month')), 'reference_type' => 'voucher')));
		$vouchers['6_month_users'] = $this->UserOrder->find('count', array('conditions'=>array('DATE(UserOrder.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(UserOrder.created) >='=>date('Y-m-d', strtotime('-6 months')), 'reference_type' => 'voucher')));
		$vouchers['this_year_users'] = $this->UserOrder->find('count', array('conditions'=>array('DATE(UserOrder.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(UserOrder.created) >='=>date('Y-m-d', strtotime('1 january this year')), 'reference_type' => 'voucher')));
		$vouchers['total'] = $this->Voucher->find('count');

		$coins = array();
		$coins['today_users'] = $this->CoinHistory->find('count', array('conditions'=>array('DATE(CoinHistory.created)'=>date('Y-m-d'))));
		$coins['this_week_users'] = $this->CoinHistory->find('count', array('conditions'=>array('DATE(CoinHistory.created) >='=>date('Y-m-d', strtotime('Monday This Week')))));
		$coins['this_month_users'] = $this->CoinHistory->find('count', array('conditions'=>array('DATE(CoinHistory.created) >='=>date('Y-m-d', strtotime('first day of this month')))));
		$coins['6_month_users'] = $this->CoinHistory->find('count', array('conditions'=>array('DATE(CoinHistory.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(CoinHistory.created) >='=>date('Y-m-d', strtotime('-6 months')))));
		$coins['this_year_users'] = $this->CoinHistory->find('count', array('conditions'=>array('DATE(CoinHistory.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(CoinHistory.created) >='=>date('Y-m-d', strtotime('1 january this year')))));
		
		$steps = array();
		$steps['today_users'] = $this->RunningHistory->find('count', array('conditions'=>array('DATE(RunningHistory.created)'=>date('Y-m-d'))));
		$steps['this_week_users'] = $this->RunningHistory->find('count', array('conditions'=>array('DATE(RunningHistory.created) >='=>date('Y-m-d', strtotime('Monday This Week')))));
		$steps['this_month_users'] = $this->RunningHistory->find('count', array('conditions'=>array('DATE(RunningHistory.created) >='=>date('Y-m-d', strtotime('first day of this month')))));
		$steps['6_month_users'] = $this->RunningHistory->find('count', array('conditions'=>array('DATE(RunningHistory.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(RunningHistory.created) >='=>date('Y-m-d', strtotime('-6 months')))));
		$steps['this_year_users'] = $this->RunningHistory->find('count', array('conditions'=>array('DATE(RunningHistory.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(RunningHistory.created) >='=>date('Y-m-d', strtotime('1 january this year')))));
		
		$active_users = array();
		$active_users['today_users'] = $this->UserLoginLogs->find('count', array('conditions'=>array('DATE(UserLoginLogs.created)'=>date('Y-m-d')), 'fields'=>'DISTINCT user_id'));
		$active_users['this_week_users'] = $this->UserLoginLogs->find('count', array('conditions'=>array('DATE(UserLoginLogs.created) >='=>date('Y-m-d', strtotime('Monday This Week'))), 'fields'=>'DISTINCT user_id'));
		$active_users['this_month_users'] = $this->UserLoginLogs->find('count', array('conditions'=>array('DATE(UserLoginLogs.created) >='=>date('Y-m-d', strtotime('first day of this month'))), 'fields'=>'DISTINCT user_id'));
		$active_users['6_month_users'] = $this->UserLoginLogs->find('count', array('conditions'=>array('DATE(UserLoginLogs.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(UserLoginLogs.created) >='=>date('Y-m-d', strtotime('-6 months'))), 'fields'=>'DISTINCT user_id'));
		$active_users['this_year_users'] = $this->UserLoginLogs->find('count', array('conditions'=>array('DATE(UserLoginLogs.created) <'=>date('Y-m-d', strtotime('today')), 'DATE(UserLoginLogs.created) >='=>date('Y-m-d', strtotime('1 january this year'))), 'fields'=>'DISTINCT user_id'));
		
		$cities = $this->User->find('all', array('fields' => 'DISTINCT City'));
		$city = array();
		foreach($cities as $key => $value){
			$city[$value['User']['City']] = $value['User']['City'];
		}
		
		$this->set(compact('usersListing', 'vouchersListing', 'blogsListing', 'userVoucherList', 'users', 'vouchers', 'coins', 'steps', 'active_users', 'city'));
		
	}

	public function getChartData($selectVal = null){
		 
		$success = null;
		if($this->request->is('ajax') && $this->request->is('POST')){
			$pie_data = array();
			if(isset($selectVal) && !empty($selectVal)){
				$pie_data['total_users'] = $this->User->find('count', array('conditions' => array('City' => $selectVal)));
				$this->UserLoginLogs->bindModel(array(
					'belongsTo' => array(
						'User' => array(
							'className' => 'User',
							'foreignKey' => 'user_id'
						)
					)
				));
				$pie_data['active_users'] = $this->UserLoginLogs->find('count', array('conditions'=>array('DATE(UserLoginLogs.created) >='=>date('Y-m-d', strtotime('Monday This Week')), 'User.City' => $selectVal), 'fields'=>'DISTINCT user_id'));
				$success = true;
			}
			else{
				$pie_data['total_users'] = $this->User->find('count');
				$pie_data['active_users'] = $this->UserLoginLogs->find('count', array('conditions'=>array('DATE(UserLoginLogs.created) >='=>date('Y-m-d', strtotime('Monday This Week'))), 'fields'=>'DISTINCT user_id'));
				$success = true;
			}
			 
			$this->set(compact('pie_data'));
			
			$response = array('success' => $success, 'activeusers' => $pie_data['active_users'],'totalusers'=>$pie_data['total_users']);
			echo json_encode($response);
			die;
		}else{
			$this->redirect('/');
		}
	}

 
}