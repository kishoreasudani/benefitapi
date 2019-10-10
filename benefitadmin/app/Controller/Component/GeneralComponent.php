<?php class GeneralComponent extends Component {

	public $name = 'General';
	
	function parseSlug($string) {

		return strtolower(Inflector::slug($string, '-'));
	}

	function __check_validation($validate_data=array()) {

		$message = array();
		return $message;
		if(!empty($validate_data) && isset($validate_data['TemplateVariable']) && !empty($validate_data['TemplateVariable'])) {

			foreach($validate_data['TemplateVariable'] as $template_variable_key=>$template_variable_value) {

				if(isset($template_variable_value['value'])) {

					switch($template_variable_value['variable_type']) {
						case 'checkbox':
							if(!empty($template_variable_value['value'])) {

								$message['error_template_'.$template_variable_key] = "This field can not be left empty.";
								foreach($template_variable_value['value'] as $variable_options_key => $variable_options_value) {

									if(!empty($variable_options_value)) {

										unset($message['error_template_'.$template_variable_key]);
									}
								}
							}
						break;
						default:
							if(empty($template_variable_value['value'])) {

								$message['error_template_'.$template_variable_key]	=	"This field can not be left empty.";
							}
					}
				}
			}
		}
		return $message;
	}


	function getImageDimensionByWH($image_size, $SH = null, $SW = null) {

		if(!empty($image_size)) {

			$IW = $image_size['0'];
			$IH = $image_size['1'];
		} else {

			return;
		}

		$W = ''; /* Width */
		$H = ''; /* Height*/
		$R = ''; /* Ratio */

		$data = array();
		if($IW == $IH) {

			/*Square Mode*/
			$W = $IW;
			$H = $IH;
			if($IW < $SW) {

				$W = $IW;
				$H = $IH;
			} else {

				$W = $SW;
				$H = $SH;
			}
		} else if($IW > $IH) {

			/*Landscape Mode*/
			if($IW == $SW) {

				$W = $SW;
				$H = $IH;
			} else if($IW < $SW) {

				$W = $IW;
				if($IH > $SH) {

					$R = $IH/$SH;
					$W = $IW/$R;
					$H = $IH/$R;
				} else {

					$H = $IH;
				}
			} else if($IW > $SW) {

				$W = $SW;
				$R = $IW/$SW;
				$H = $IH/$R;
			}
		} else if($IW < $IH) {

			/*Portrait Mode*/
			if($IW == $SW) {

				$W = $SW;
				$H = $IH;
			} else if($IH < $SH) {

				$W = $IW;
				$H = $IH;
			} else if( $IH > $SH) {

				$R = $IH/$SH;
				$W = $IW/$R;
				$H = $IH/$R;
			} else {

				$W = $IW;
				$H = $IH;
			}
		}
		$data['w'] = intval($W);
		$data['h'] = intval($H);
		return $data;
	}

	function __getImageSize($image_size, $SW = null, $SH = null) {

		if(!empty($image_size)) {

			$IW = $image_size['w'];
			$IH = $image_size['h'];
		} else {

			return;
		}
		$W = ''; /* Width */
		$H = ''; /* Height*/
		$R = ''; /* Ratio */

		$data = array();
		if($IW == $IH) {

			/*Square Mode*/
			$W = $IW;
			$H = $IH;
			if($IW < $SW) {

				$W = $IW;
				$H = $IH;
			} else {

				$W = $SW;
				$H = $SH;
			}
		} else if($IW > $IH) {

			/*Landscape Mode*/
			if($IW == $SW) {

				$W = $SW;
				$H = $IH;
			} else if($IW < $SW) {

				$W = $IW;
				if($IH > $SH) {

					$R = $IH/$SH;
					$W = $IW/$R;
					$H = $IH/$R;
				} else {

					$H = $IH;
				}
			} else if($IW > $SW) {

				$W = $SW;
				$R = $IW/$SW;
				$H = $IH/$R;
			}
		} else if($IW < $IH) {

			/*Portrait Mode*/
			if($IW == $SW) {

				$W = $SW;
				$H = $IH;
			} else if($IH < $SH) {

				$W = $IW;
				$H = $IH;
			} else if( $IH > $SH) {

				$R = $IH/$SH;
				$W = $IW/$R;
				$H = $IH/$R;
			} else {

				$W = $IW;
				$H = $IH;
			}
		}
		$data['w'] = intval($W);
		$data['h'] = intval($H);
		return $data;
	}

	function get_padded_string($string,$prefix) {

		return $prefix.str_pad($string,4,0,STR_PAD_LEFT);
	}

	// Function to get the client IP address
    function get_client_ip() {
        $ipaddress = '';
        if (getenv('HTTP_CLIENT_IP'))
            $ipaddress = getenv('HTTP_CLIENT_IP');
        else if(getenv('HTTP_X_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
        else if(getenv('HTTP_X_FORWARDED'))
            $ipaddress = getenv('HTTP_X_FORWARDED');
        else if(getenv('HTTP_FORWARDED_FOR'))
            $ipaddress = getenv('HTTP_FORWARDED_FOR');
        else if(getenv('HTTP_FORWARDED'))
           $ipaddress = getenv('HTTP_FORWARDED');
        else if(getenv('REMOTE_ADDR'))
            $ipaddress = getenv('REMOTE_ADDR');
        else
            $ipaddress = 'UNKNOWN';
        return $ipaddress;
    }
} ?>