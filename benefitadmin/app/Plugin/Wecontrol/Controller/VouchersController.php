<?php
class VouchersController extends WecontrolAppController {
	public $name = 'Vouchers';
	public $uses = array('Wecontrol.Voucher', 'Wecontrol.UserOrder','Vendor');
	var $components	=	array('Session', 'Email', 'SendEmail', 'RequestHandler', 'Paginator', 'General','PImage');
	var $helpers 	= 	array('Html', 'Form', 'Session', 'General');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index', 'vouchers_data', 'add_voucher', 'edit_voucher', 'view_voucher', 'delete_voucher','vendors','vendors_data','delete_vendors','add_vendor','edit_vendor');			
	}



	public function vendors() {	
		# Check login status...
 		$this->_is_user_login ();
	}

	public function vendors_data($reset = null) {
		$this->layout = false;
		$conditions = array();
		if(!empty($this->params->query['data']['Search'])){
			if(!empty($this->params->query['data']['Search']['name'])){
				$conditions[] = array(
					'OR' => array(
						'Vendor.name LIKE'=>"%".$this->params->query['data']['Search']['name']."%",	 
					)
				);
			}
			
		   if(!empty($this->params->query['data']['Search']['status'])){
				$conditions[] = array(
					'AND' => array(
						'Vendor.status'=>	$this->params->query['data']['Search']['status'],
					)
				);
			}
		}else{
			$conditions = "";
		}	
		$this->Paginator->settings = array('order' => 'Vendor.name asc','limit' => Configure::read('AdminListingLimit'));
		$listingData = $this->paginate('Vendor',$conditions);
		$userVoucherList = array();
		$userVoucherList = $listingData;
		foreach($listingData as $key => $value){
			$userVoucherList[$key]['Vendor']['count'] = $this->Voucher->find('count', array('conditions' => array('vendor_id' => $value['Vendor']['id'])));
		}
        $this->set('listingData',$userVoucherList);		

	}


	public function add_vendor( ) {
		$this->_is_user_login (); 
		$message = "";	
		if(!empty($this->data)) {
			$this->Vendor->set($this->request->data);
			$this->Vendor->setValidation('add');
			if($this->Vendor->validates())  {
				$this->request->data['Vendor']['status'] = 'active';
                $this->Vendor->create();
	            if($this->Vendor->save($this->request->data,false)) {
	            	$success = true;
					$message = "The Vendor has been saved.";
					//$this->Session->setFlash('The Vendor has been saved.', 'default', null, 'success');
	            } else {
					$success = false;
					$message = "Vendor could not be saved. Please, try again.";	
				}
			} else {
				if(!empty($this->Vendor->validationErrors)) {
					$success =	false;
					foreach($this->Vendor->validationErrors as $error_key=>$error_value) {

						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Vendor'.$error_key]	=	$error_value;
					}
				}
	         }	
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}	
    }


    public function edit_vendor($id=null) {
    	$this->set('vendorid',$id);
        $id = base64_decode($id);
		$this->_is_user_login (); 
		$message = "";	
		if(!empty($this->data)) {
			$this->Vendor->set($this->request->data);
            $this->request->data['Vendor']['id'] = $id;

			$this->Vendor->setValidation('edit');
			if($this->Vendor->validates())  {
	            if($this->Vendor->save($this->request->data,false)) {
	            	$success = true;
					$message = "The Vendor has been updated.";
					//$this->Session->setFlash('The Vendor has been saved.', 'default', null, 'success');
	            } else {
					$success = false;
					$message = "Vendor could not be saved. Please, try again.";	
				}
			} else {
				if(!empty($this->Vendor->validationErrors)) {
					$success =	false;
					foreach($this->Vendor->validationErrors as $error_key=>$error_value) {

						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Vendor'.$error_key]	=	$error_value;
					}
				}
	         }	
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}else{
			$this->data = $this->Vendor->findById($id);
		}	
    }


	public function index($vendor_id=null) {	
		# Check login status...
 		$this->_is_user_login ();
 		$this->set('vendor_id',base64_decode($vendor_id));

 		$vendorsList =  $this->Vendor->find('list',array('fields'=>array('Vendor.id','Vendor.name'),'order'=>array('Vendor.name'=>'ASC')));
		$this->set('vendorsList',$vendorsList);
	}


	public function vouchers_data($checkVendor = null) {
		$this->layout = false;
		$conditions = array();

		if(!empty($this->params->query['data']['Search'])){
			if(!empty($this->params->query['data']['Search']['name'])){
				$conditions[] = array(
					'OR' => array(
						'Voucher.name LIKE'=>"%".$this->params->query['data']['Search']['name']."%",	 
					)
				);
			}
			if(!empty($this->params->query['data']['Search']['code'])){
				$conditions[] = array(
					'AND' => array(
						'Voucher.code LIKE'=>	"%".$this->params->query['data']['Search']['code']."%",
					)
				);
			}

		   if(!empty($this->params->query['data']['Search']['status'])){
				$conditions[] = array(
					'AND' => array(
						'Voucher.status'=>	$this->params->query['data']['Search']['status'],
					)
				);
			}

		   $checkVendor = $this->params->query['data']['Search']['vendor'];
		   if(!empty($checkVendor) && $checkVendor>0){
				$conditions[] = array(
					'AND' => array(
						'Voucher.vendor_id'=>$checkVendor,
					)
				);
			}




		}else{

			if(!empty($checkVendor) && $checkVendor>0){
				$conditions[] = array(
					'AND' => array(
						'Voucher.vendor_id'=>$checkVendor,
					)
				);
			}
			
		}	
		$this->Paginator->settings = array('order' => 'Voucher.id DESC','limit' => Configure::read('AdminListingLimit'));
		$listingData = $this->paginate('Voucher',$conditions);
		$userVoucherList = array();
		$userVoucherList = $listingData;
		foreach($listingData as $key => $value){
			$userVoucherList[$key]['Voucher']['count'] = $this->UserOrder->find('count', array('conditions' => array('reference_id' => $value['Voucher']['id'], 'reference_type' => 'voucher')));
		}
        $this->set('listingData',$userVoucherList);		
	}

	public function view_voucher($id = null){
		$id = base64_decode($id);
		$pages = $this->Voucher->find('first',array(
					'conditions'=>array('Voucher.id'=>$id),
					'recursive'=>1
		));
		$pages['Voucher']['created_by'] = $this->Admin->findById($pages['Voucher']['created_by']);
		$pages['Voucher']['modified_by'] = $this->Admin->findById($pages['Voucher']['modified_by']);
		$this->set('pages',$pages);
    }
    
    public function delete_voucher($id = null){
		$this->layout = false;
		if($this->request->is('ajax')) {		
				$response = array();
				if(!empty($id)) {
					$this->Voucher->deleteAll(array('Voucher.id' => $id), false);
					$response = array('success' => true,'msg' => 'Voucher has been deleted successfully.');
				} else {
					$response = array('success' => false,'msg' => 'Oops error please try again.');
				}
			echo json_encode($response);
            die;
		} else {
			$this->redirect('/');
		}
    }


    public function delete_vendors($id = null){
		$this->layout = false;
		if($this->request->is('ajax')) {		
				$response = array();
				if(!empty($id)) {
					$this->Vendor->deleteAll(array('Vendor.id' => $id), false);
					$response = array('success' => true,'msg' => 'Vendor has been deleted successfully.');
				} else {
					$response = array('success' => false,'msg' => 'Oops error please try again.');
				}
			echo json_encode($response);
            die;
		} else {
			$this->redirect('/');
		}
    }



    
    public function add_voucher( ) {
		$this->_is_user_login (); 
		$message = "";	
		if(!empty($this->data)) {
			$this->Voucher->set($this->request->data);
			$this->Voucher->setValidation('add');
			if($this->Voucher->validates())  {


				$this->request->data['Voucher']['status'] = 'active';
				$this->request->data['Voucher']['created_by'] = $this->Session->read('Auth.Admin.id');
                $this->request->data['Voucher']['start_date'] = date('Y-m-d H:i',strtotime($this->request->data['Voucher']['start_date']));
                $this->request->data['Voucher']['end_date'] = date('Y-m-d H:i',strtotime($this->request->data['Voucher']['end_date']));
                $this->Voucher->create();
	            if($this->Voucher->save($this->request->data,false)) {
	            	$last_insert_id    	= $this->Voucher->getLastInsertID();
		           	$dowloadPath   	= Configure::read('SiteSettings.Relative.VoucherImage');
		            if(!empty($this->data['Voucher']['image1']['name']) && !empty($this->data['Voucher']['image_bg']['name'])){
		                $fileName    = $this->data['Voucher']['image1']['name'];
		                $fileType    = $this->data['Voucher']['image1']['type'];
		                $fileTmpName = $this->data['Voucher']['image1']['tmp_name'];
		                $fileError   = $this->data['Voucher']['image1']['error'];
		                $fileSize    = $this->data['Voucher']['image1']['size'];
		                $file_type   = explode('.', $fileName);
		                $ext_name    = array_reverse($file_type);
		                $ext         = strtolower($ext_name[0]);
		                $fileNewName = strtolower($ext_name[1]).'_'.time().'.'.$ext;
	                   	if(!is_dir($dowloadPath)){
	                    	@mkdir($dowloadPath, 0777);
	                  	}
	                   	@move_uploaded_file($fileTmpName, $dowloadPath.'/'.$fileNewName);
	                   	// $result3 = $this->PImage->resizeImage(
						// 	$cType = 'resizeCrop',
						// 	$fileNewName, 
						// 	$dowloadPath.DS,
						// 	$dowloadPath.DS.$fileNewName,
						// 	'1208',
						// 	'400',
						// 	$quality = 100,
						// 	$bgcolor = true
						// );
						$fileName_bg    = $this->data['Voucher']['image_bg']['name'];
		                $fileType_bg    = $this->data['Voucher']['image_bg']['type'];
		                $fileTmpName_bg = $this->data['Voucher']['image_bg']['tmp_name'];
		                $fileError_bg   = $this->data['Voucher']['image_bg']['error'];
		                $fileSize_bg    = $this->data['Voucher']['image_bg']['size'];
		                $file_type_bg   = explode('.', $fileName_bg);
		                $ext_name_bg    = array_reverse($file_type_bg);
		                $ext_bg         = strtolower($ext_name_bg[0]);
		                $fileNewName_bg = strtolower($ext_name_bg[1]).'_'.time().'.'.$ext_bg;
	                   	if(!is_dir($dowloadPath)){
	                    	@mkdir($dowloadPath, 0777);
	                  	}
	                   	@move_uploaded_file($fileTmpName_bg, $dowloadPath.'/'.$fileNewName_bg);
	                   	// $result3 = $this->PImage->resizeImage(
						// 	$cType = 'resizeCrop',
						// 	$fileNewName_bg, 
						// 	$dowloadPath.DS,
						// 	$dowloadPath.DS.$fileNewName_bg,
						// 	'1208',
						// 	'400',
						// 	$quality = 100,
						// 	$bgcolor = true
						// );		
	                    $this->Voucher->updateAll(array('Voucher.image'=>"'".$fileNewName."'", 'Voucher.bg_image'=>"'".$fileNewName_bg."'"),array('Voucher.id'=>$last_insert_id));
		            }
					$success = true;
					$message = "The voucher has been saved.";
					$this->Session->setFlash('The voucher has been saved.', 'default', null, 'success');
				} else {
					$success = false;
					$message = "Voucher could not be saved. Please, try again.";	
				}
			} else {
				if(!empty($this->Voucher->validationErrors)) {
					$success =	false;
					foreach($this->Voucher->validationErrors as $error_key=>$error_value) {

						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Voucher'.$error_key]	=	$error_value;
					}
				}
	         }	




			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}	

		$vendorsList =  $this->Vendor->find('list',array('fields'=>array('Vendor.id','Vendor.name'),'order'=>array('Vendor.name'=>'ASC')));
		$this->set('vendorsList',$vendorsList);

    }
    
    public function edit_voucher($id = null ) {
    	$this->set('voucherid',$id);
        $id = base64_decode($id);
		$this->_is_user_login (); 
		$message = "";	
		if(!empty($this->data)) {
			$this->Voucher->set($this->request->data);
			$this->Voucher->setValidation('add');
			
			if($this->Voucher->validates())  {
				$this->request->data['Voucher']['status'] = 'active';
				$this->request->data['Voucher']['modified_by'] = $this->Session->read('Auth.Admin.id');
                $this->Voucher->create();
	            if($this->Voucher->save($this->request->data,array('Voucher.id' => $id))) {
	            	$last_insert_id    	= $id;
		           	$dowloadPath   	= Configure::read('SiteSettings.Relative.VoucherImage');
		            if(!empty($this->data['Voucher']['image1']['name']) && !empty($this->data['Voucher']['image_bg']['name'])){
		                $fileName    = $this->data['Voucher']['image1']['name'];
		                $fileType    = $this->data['Voucher']['image1']['type'];
		                $fileTmpName = $this->data['Voucher']['image1']['tmp_name'];
		                $fileError   = $this->data['Voucher']['image1']['error'];
		                $fileSize    = $this->data['Voucher']['image1']['size'];
		                $file_type   = explode('.', $fileName);
		                $ext_name    = array_reverse($file_type);
		                $ext         = strtolower($ext_name[0]);
		                $fileNewName = strtolower($ext_name[1]).'_'.time().'.'.$ext;
	                   	if(!is_dir($dowloadPath)){
	                    	@mkdir($dowloadPath, 0777);
	                  	}
	                   	@move_uploaded_file($fileTmpName, $dowloadPath.'/'.$fileNewName);
	                   	// $result3 = $this->PImage->resizeImage(
						// 	$cType = 'resizeCrop',
						// 	$fileNewName, 
						// 	$dowloadPath.DS,
						// 	$dowloadPath.DS.$fileNewName,
						// 	'1208',
						// 	'400',
						// 	$quality = 100,
						// 	$bgcolor = true
						// );
						$fileName_bg    = $this->data['Voucher']['image_bg']['name'];
		                $fileType_bg    = $this->data['Voucher']['image_bg']['type'];
		                $fileTmpName_bg = $this->data['Voucher']['image_bg']['tmp_name'];
		                $fileError_bg   = $this->data['Voucher']['image_bg']['error'];
		                $fileSize_bg    = $this->data['Voucher']['image_bg']['size'];
		                $file_type_bg   = explode('.', $fileName_bg);
		                $ext_name_bg    = array_reverse($file_type_bg);
		                $ext_bg         = strtolower($ext_name_bg[0]);
		                $fileNewName_bg = strtolower($ext_name_bg[1]).'_'.time().'.'.$ext_bg;
	                   	if(!is_dir($dowloadPath)){
	                    	@mkdir($dowloadPath, 0777);
	                  	}
	                   	@move_uploaded_file($fileTmpName_bg, $dowloadPath.'/'.$fileNewName_bg);
	                   	// $result3 = $this->PImage->resizeImage(
						// 	$cType = 'resizeCrop',
						// 	$fileNewName_bg, 
						// 	$dowloadPath.DS,
						// 	$dowloadPath.DS.$fileNewName_bg,
						// 	'1208',
						// 	'400',
						// 	$quality = 100,
						// 	$bgcolor = true
						// );
	                    $this->Voucher->updateAll(array('Voucher.image'=>"'".$fileNewName."'", 'Voucher.bg_image'=>"'".$fileNewName_bg."'"),array('Voucher.id'=>$last_insert_id));
		            }
					$this->Session->setFlash('Voucher has been updated successfully.', 'default', null, 'success');
					$success = true;
					$message = "The voucher has been updated successfully.";
				} else {
					$success = false;
					$message = "Voucher could not be updated. Please, try again.";	
				}
			} else {
				if(!empty($this->Voucher->validationErrors)) {
					$success =	false;
					foreach($this->Voucher->validationErrors as $error_key=>$error_value) {
						$error_key = str_replace('_', ' ', $error_key);
						$error_key = ucwords($error_key);
						$error_key = str_replace(' ', '', $error_key);
						$message['Voucher'.$error_key]	=	$error_value;
					}
				}
	         }	
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}else{
			$this->data = $this->Voucher->findById($id);
			$this->request->data['Voucher']['start_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['Voucher']['start_date']));
			$this->request->data['Voucher']['end_date'] = date('Y-m-d H:i:s',strtotime($this->request->data['Voucher']['end_date']));
		}

	   $vendorsList =  $this->Vendor->find('list',array('fields'=>array('Vendor.id','Vendor.name'),'order'=>array('Vendor.name'=>'ASC')));
		$this->set('vendorsList',$vendorsList);
	}
}