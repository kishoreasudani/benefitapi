<?php
class VouchersController extends WecontrolAppController {
	public $name = 'Vouchers';
	public $uses = array('Wecontrol.Voucher', 'Wecontrol.UserOrder','Vendor');
	var $components	=	array('Session', 'Email', 'SendEmail', 'RequestHandler', 'Paginator', 'General','PImage');
	var $helpers 	= 	array('Html', 'Form', 'Session', 'General');

	function beforeFilter(){
		parent::beforeFilter();
		$this->Auth->allow('index', 'vouchers_data', 'add_voucher', 'edit_voucher', 'view_voucher', 'delete_voucher','vendors','vendors_data','delete_vendors','add_vendor','edit_vendor','add_bulk_voucher');			
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

           // pr($this->request->data); die();

			$this->Vendor->set($this->request->data);
			$this->Vendor->setValidation('add');
			if($this->Vendor->validates())  {
				$this->request->data['Vendor']['status'] = 'active';

			    $tmpname = $this->request->data['Vendor']['logo']['tmp_name'];  
                $logoname = $this->request->data['Vendor']['logo']['name'];  
                $ext = pathinfo($logoname, PATHINFO_EXTENSION); 
                $this->request->data['Vendor']['logo']= 'logo_'.time().'.'.$ext;


                $backtmpname = $this->request->data['Vendor']['background_logo']['tmp_name'];  
                $backlogoname = $this->request->data['Vendor']['background_logo']['name'];  
                $backext = pathinfo($backlogoname, PATHINFO_EXTENSION); 
                $this->request->data['Vendor']['background_logo']= 'backlogo_'.time().'.'.$backext;



                $this->Vendor->create();
	            if($this->Vendor->save($this->request->data,false)) {
	            	$dowloadPath = Configure::read('SiteSettings.Relative.VendorLogo');
	            	@move_uploaded_file($tmpname, $dowloadPath.$this->request->data['Vendor']['logo']);

	            	@move_uploaded_file($backtmpname, $dowloadPath.$this->request->data['Vendor']['background_logo']);


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

        $olddata =  $this->Vendor->findById($id);
        $logo = $olddata['Vendor']['logo'];

        $backlogo = $olddata['Vendor']['background_logo'];

		if(!empty($this->data)) {
		
            $this->request->data['Vendor']['id'] = $id;
            $this->Vendor->set($this->request->data);
			$this->Vendor->setValidation('edit');
			if($this->Vendor->validates())  {

                $upload = "No";
                $backupload = "No";
                $extData =  array('jpeg','jpg','png','gif');

              if(isset($this->request->data['Vendor']['logo']['tmp_name']) && $this->request->data['Vendor']['logo']['tmp_name']!=''){
			    	$tmpname = $this->request->data['Vendor']['logo']['tmp_name'];  
                    $logoname = $this->request->data['Vendor']['logo']['name']; 
                    $ext = pathinfo($logoname, PATHINFO_EXTENSION); 
	                if(in_array($ext,$extData)){
	                	$upload = "Yes";
	                     $this->request->data['Vendor']['logo']= 'logo_'.time().'.'.$ext;
	                }

               }else{

               	   $this->request->data['Vendor']['logo']= $logo;
               }


               if(isset($this->request->data['Vendor']['background_logo']['tmp_name']) && $this->request->data['Vendor']['background_logo']['tmp_name']!=''){
                 	  $backtmpname = $this->request->data['Vendor']['background_logo']['tmp_name'];  
                      $backlogoname = $this->request->data['Vendor']['background_logo']['name'];

                      $ext = pathinfo($backlogoname, PATHINFO_EXTENSION); 
		              if(in_array($ext,$extData)){
		                	 $backupload = "Yes";
		                     $this->request->data['Vendor']['background_logo']= 'backlogo_'.time().'.'.$ext;
		              } 

               }else{
               	   $this->request->data['Vendor']['background_logo']= $backlogo;
               }
             
	            if($this->Vendor->save($this->request->data,false)) {

	            	if($upload=='Yes'){

	            		 $dowloadPath = Configure::read('SiteSettings.Relative.VendorLogo');
	            	     @move_uploaded_file($tmpname, $dowloadPath.$this->request->data['Vendor']['logo']);
	            	}

	            	if($backupload=='Yes'){
	            		 $dowloadPath = Configure::read('SiteSettings.Relative.VendorLogo');
	            	     @move_uploaded_file($backtmpname, $dowloadPath.$this->request->data['Vendor']['background_logo']);
	            	}

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
			$this->data = $olddata;
		}	
		$this->set('logo',$logo);
		$this->set('backlogo',$backlogo);


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
  
    public function add_voucher($vendor_id=null) {
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
		}else{

			$this->request->data['Voucher']['vendor_id'] = base64_decode($vendor_id);
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
	            if($this->Voucher->save($this->request->data,array('Voucher.id' => $id))) {
	            	
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



	public function add_bulk_voucher($vendor_id=null) {
		$this->_is_user_login (); 
		$message = "";	
		$vendor_id = base64_decode($vendor_id);
		if(!empty($this->data) && $vendor_id!='' && $vendor_id>0) {
			     $data = $this->request->data['Voucher']['csvFile'];
			   	if(isset($data['name']) && $data['name']!=''){
					 $ext = pathinfo($data['name'], PATHINFO_EXTENSION); 
					 if (strtolower($ext)=='csv') {      
					      $error = 0;             
	                     $count_rows = count(explode("\r\n", file_get_contents($data['tmp_name'])));
	                    // die();
	                      if($count_rows>=1){
	                      	  if (($handle = fopen($data['tmp_name'], "r")) !== FALSE) {
								  fgetcsv($handle);  
								
								   while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
							     	$voucherName = trim($data[0]); 
									$code = trim($data[1]);
									$amount = trim($data[2]);
									$coinsRequired =   trim($data[3]);
									$startDate =   trim($data[4]);	
									$etartDate =   trim($data[4]);	
									$tc =   trim($data[4]);	
									$description =   trim($data[4]);	

									if($voucherName !='' && $code!='' && $coinsRequired!='' &&  $startDate!='' && $etartDate!=''){
                                        $voucheData['Voucher']['vendor_id'] = $vendor_id;
                                        $voucheData['Voucher']['name'] = $voucherName;
                                        $voucheData['Voucher']['code'] = $code;
                                        $voucheData['Voucher']['coins_required'] = $coinsRequired;
                                        $voucheData['Voucher']['amount'] = $amount;
                                        $voucheData['Voucher']['descriptions'] = $description;
                                        $voucheData['Voucher']['terms_and_conditions'] = $tc;
										$voucheData['Voucher']['status'] = 'active';
										$voucheData['Voucher']['created_by'] = $this->Session->read('Auth.Admin.id');
										$voucheData['Voucher']['start_date'] = date('Y-m-d H:i',strtotime($startDate));
										$voucheData['Voucher']['end_date'] = date('Y-m-d H:i',strtotime($etartDate));

										 //prd($voucheData); die();
										$this->Voucher->create();
										$this->Voucher->save($voucheData,false); 
									}else{
										$error++;
									}
								}
								fclose($handle);
								  $error_message ='';
						          if($error>=1){
	                                 	$error_message = '<br/><span style="color:red">But there are  '.$error.' records invalid in sheet</span>';
	                                 }
	                                 $success = true;
	                                $message = 'Voucher are successfully import '.$error_message;
	                               
							}else{
								$success = false;
						        $message = "There are some problem in csv file.";		
							}                                       
	                      }else{
	                      	   $success = false;
						       $message = "Please fill data in csv file.";
	                      }
	                   				 	
					 }else{
		    		     $success = false;
						 $message = "Please upload only valid csv file.";
					 }

	    	    }else{
	    			$success = false;
					$message = "Please upload csv file first.";

	        	}
		
			echo json_encode(array('success'=>$success, 'message'=>$message));
			die;
		}	

    }



}