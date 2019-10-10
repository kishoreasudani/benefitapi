<?php
class ApiController extends AppController {

		var $name = 'api';
		var $components = 	array('Session','Cookie','RequestHandler','SendEmail');
		var $helpers     	= array('Time','Text');
		//var $uses = array('ContactUs','User','Country');


	public function uploadUserAvatar(){

			echo "fdssd"; die();
		if(isset($_POST) && isset($_FILE['avatar'])){
			$this->loadModel('User');
            $user_id = $_POST['id'];
            $photo_tmp = $_FILE['avatar']['tmp_name'];
            $photo_name = $_FILE['avatar']['name'];
            $dir = Configure::read('SiteSettings.Relative.UserImage');
            if(!is_dir($dir.$user_id)){
               mkdir($dir.$user_id,777);
            }
            move_uploaded_file($photo_name, $dir.$photo_tmp);

             $data["User"]['id'] = $user_id;
             $data["User"]['avatar'] = $photo_name;
             $this->User->save($data);
             echo json_encode(array('statusCode'=>200,'message'=>'image successfully upload'));
		}
	}

 


	   
    }

?>
