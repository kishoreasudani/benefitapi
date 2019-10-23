<?php $config = array();
define('siteSlug', 'BeneFit');
define('projectTitle', 'BeneFit');
define( 'dateFormat', 'M d, Y' );
define( 'dateTimeFormat', 'M d, Y H:i A' );
Configure::write('AdminListingLimit','10');
Configure::write('Email',array('Admin'=>'user1.guts@gmail.com'));

Configure::write ( 'DateTimeFormat','M d, Y H:i A' );
Configure::write ( 'DateFormat','M d, Y' );
Configure::write('SMTP.Options', array(
	'port'		=> '465',
	'timeout'	=> '130',
	'host' 		=> 'ssl://smtp.gmail.com',
	'username'	=> 'user1.guts@gmail.com',
	'password'	=> 'wedig@123',
));

Configure::write('UserAdmin.role',array(
	'admin' => 'Admin',
	'editor' => 'Editor',
		
));

Configure::write('Voucher.discount_type',array(
	'fixed_amount' => 'Fixed Amount',
	'percentage' => 'Percentage',
		
));

Configure::write('General.status',array(
	'active' => 'Active',
	'inactive' => 'Inactive'
));

Configure::write('GenderType',array(
	'male' => 'Male',
	'female' => 'Female',
	'other' => 'Other'
));

Configure::write('UserCreated.type',array(
	'user' => 'user',
	'admin' => 'admin'
));

Configure::write('Approved.status', array(
	'approved'    		=>'Approved',
	'pending'    		=> 'Pending',
	'rejected'     	=>  'Rejected'	
));

Configure::write('Event.availability_status', array(
	'available' => array('label' => 'Available', 'slug' => 'available'),
	'unavailable' => array('label' => 'Unavailable', 'slug' => 'unavailable')
));

Configure::write('Event.homepage_data_limit', 6);

Configure::write('General.yesno',array(
	'yes' => 'Yes',
	'no' => 'No'
));

Configure::write('BudgetType',array(
	'budget_slab_10000_50000' => 'Budget Slab(10000 - 50000)',
	'budget_slab_50000_250000' => 'Budget Slab(50000 - 250000)',
	'budget_slab_250000_1000000' => 'Budget Slab(250000 - 1000000)'
));

Configure::write('CommercialsType',array(
	'fixed_cost' => 'Fixed Cost',
	'variable_cost' => 'Variable Cost'
	
));

Configure::write('RoleType',array(
	'analyst' => 'Analyst',
	'client' => 'Client'	
));


Configure::write('imageSize', array(
					'1' => array('width' => 80, 'height' => 80),		
					'2' => array('width' => 180, 'height' => 180),		
					'3' => array('width' => 300, 'height' => 300),		
					'4' => array('width' => 600, 'height' => 600),		
));

Configure::write('CategoryType',array(
		'Client' => 'Client',
		'Analyst' => 'Analyst',
));

Configure::write('verification',array(
		'yes' => array('key' => 'yes', 'label' => 'Yes'),
		'no' => array('key' => 'no', 'label' => 'No'),
		'pending' => array('key' => 'pending', 'label' => 'Pending'),
));

Configure::write('Environment', 'local'); // local OR live

Configure::write('SiteSettings.AdminFolderName','wecontrol/');

Configure::write('SiteSettings.siteUrl', Configure::read('SiteSettings.actionUrl').Configure::read('SiteSettings.AdminFolderName'));

define('BASE_PATH', Configure::read('SiteSettings.siteUrl'));
 
define( 'LOGIN_SUCCESS', 'Logged in successfully. Awesome!!!');
define( 'LOGOUT_SUCCESS', 'Logged out successfully. Welcome!!!');
define( 'LOGIN_ERROR', 'Email and Password mismatch, Please try again');

Configure::write('GetImage', '/mindstock/');
Configure::write('GetImagesUrl', 'http://'.$_SERVER['HTTP_HOST'].Configure::read('GetImage'));
 

Configure::write('Absolute.adminImages',Configure::read('GetImagesUrl').'data/admin/');
Configure::write('Relative.adminImages', $_SERVER['DOCUMENT_ROOT'] . Configure::read('GetImage') . 'data/admin/' );

Configure::write('SiteSettings.Relative.StaticPagesImage',$_SERVER['DOCUMENT_ROOT'].Configure::read('SiteSettings.applicationFolder').'data/static_pages/');
Configure::write('SiteSettings.Absolute.StaticPagesImage',Configure::read('SiteSettings.actionUrl').'/data/static_pages/');

Configure::write('SiteSettings.Relative.excel',$_SERVER['DOCUMENT_ROOT'].Configure::read('SiteSettings.applicationFolder').'data/excelFiles/'); 

Configure::write('SiteSettings.Relative.VoucherImage',$_SERVER['DOCUMENT_ROOT'].Configure::read('SiteSettings.applicationFolder').'data/vouchers/');
Configure::write('SiteSettings.Absolute.VoucherImage',Configure::read('SiteSettings.actionUrl').'/data/vouchers/');

Configure::write('SiteSettings.Relative.UserImage',$_SERVER['DOCUMENT_ROOT'].Configure::read('SiteSettings.applicationFolder').'data/user/');
Configure::write('SiteSettings.Absolute.UserImage',Configure::read('SiteSettings.actionUrl').'/data/user/');
Configure::write('PUSH_API_KEY', 'AAAASFrQQrw:APA91bGE5PPExpSsEP2qPOxG2SP2o4yFRNaMr__BHpa2XOIS-RfO5ZQhCnhkzfnrrzt1uEOpq-jsh5HZmia1VPL0UcYWQ-NUML8X6ygCzqauelj7ixTA7evubpvUea3VZUmBdl4SFFWV');


Configure::write('SiteSettings.Relative.VendorLogo',$_SERVER['DOCUMENT_ROOT'].Configure::read('SiteSettings.applicationFolder').'data/vouchers/');
Configure::write('SiteSettings.Absolute.VendorLogo',Configure::read('SiteSettings.actionUrl').'/data/vouchers/');


/************************************* Messages *************************************/

/* 
	Common Message
*/

define( 'MsgName', 'Please enter name.' );

/* 
	Code
*/
define( 'MsgCode', 'Please enter code.' );