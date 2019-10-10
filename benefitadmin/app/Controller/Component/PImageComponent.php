<?php
class PImageComponent extends Component 
{
	 public $name = 'PImage';
	 
	/*
	 * PImageComponent: component to resize or crop images 
	 * @author: Wendy Perkins aka The Perkster
 	 * @website: http://www.perksterdesigns.com/  - Probably still not up to par
 	 * @license: MIT
 	 * @version: 0.8.3.1
	 */
	
	/*
	 * @param $cType - the conversion type: resize (default), resizeCrop (square), crop (from center) 
	 * @param $id - image filename
	 * @param $imgFolder  - the folder where the image is
	 * @param $newName - destination of new image
	 * @param $newWidth - the  max width or crop width
	 * @param $newHeight - the max height or crop height
	 * @param $quality - the quality of the image
	 * @param $bgcolor - this was from a previous option that was removed, but required for backward compatibility
	 */
	
	function resizeImage($cType, $id, $imgFolder, $newName = false, $newWidth, $newHeight = null, $quality, $bgcolor = false)
	{ 	
		$img = $imgFolder . $id;
		list($oldWidth, $oldHeight, $type) = getimagesize($img); 
		$ext = $this->image_type_to_extension($type);
		
		if(empty($newHeight)){
			$newHeight = floor(($oldHeight/$oldWidth)*$newWidth);
		}
		
		$dest = $newName;
		//debug("Run \"chmod 777 on '$dest' folder\"");
		//check to make sure that the file is writeable, if so, create destination image (temp image)
		//check to make sure that something is requested, otherwise there is nothing to resize.
		//although, could create option for quality only
		if ($newWidth OR $newHeight)
		{
			/*
			 * check to make sure temp file doesn't exist from a mistake or system hang up.
			 * If so delete.
			 */
				switch ($cType){
					default:
					case 'resize':
						# Maintains the aspect ration of the image and makes sure that it fits
						# within the maxW(newWidth) and maxH(newHeight) (thus some side will be smaller)
						$widthScale = 2;
						$heightScale = 2;
						
						if($newWidth){
							$widthScale = 	$newWidth / $oldWidth;
						}
						if($newHeight){
							$heightScale = $newHeight / $oldHeight;
						}
						
						$maxHeight = $newHeight;
						$maxWidth = $newWidth;
						$applyWidth = $maxWidth; 
						$applyHeight = $maxHeight;
						$startX = 0;
						$startY = 0;
						break;
					case 'resizeCrop':
						// -- resize to max, then crop to center
						$ratioX = $newWidth / $oldWidth;
						$ratioY = $newHeight / $oldHeight;
	
						if ($ratioX < $ratioY) { 
							$startX = round(($oldWidth - ($newWidth / $ratioY))/2);
							$startY = 0;
							$oldWidth = round($newWidth / $ratioY);
							$oldHeight = $oldHeight;
						} else { 
							$startX = 0;
							$startY = round(($oldHeight - ($newHeight / $ratioX))/2);
							$oldWidth = $oldWidth;
							$oldHeight = round($newHeight / $ratioX);
						}
						$applyWidth = $newWidth;
						$applyHeight = $newHeight;
						break;
					case 'crop':
						// -- a straight centered crop
						$startY = ($oldHeight - $newHeight)/2;
						$startX = ($oldWidth - $newWidth)/2;
						$oldHeight = $newHeight;
						$applyHeight = $newHeight;
						$oldWidth = $newWidth; 
						$applyWidth = $newWidth;
						break;
				}
				
				switch($ext)
				{
					case 'gif' :
						$oldImage = imagecreatefromgif($img);
						break;
					case 'png' :
						$oldImage = imagecreatefrompng($img);
						break;
					case 'jpg' :
					case 'jpeg' :
						$oldImage = imagecreatefromjpeg($img);
						break;
					default :
						//image type is not a possible option
						return false;
						break;
				}
				
				$newImage = imagecreatetruecolor($applyWidth, $applyHeight);
				if($bgcolor):
					
					//set up background color for new image
					sscanf($bgcolor, "%2x%2x%2x", $red, $green, $blue);
					$newColor = ImageColorAllocate($newImage, $red, $green, $blue); 
					imagefill($newImage,0,0,$newColor);
				else:
					imagealphablending( $newImage, false );
					imagesavealpha( $newImage, true );
				endif;
				
				//put old image on top of new image
				imagecopyresampled($newImage, $oldImage, 0,0 , $startX, $startY, $applyWidth, $applyHeight, $oldWidth, $oldHeight);
				
					switch($ext)
					{
						case 'gif' :
							imagegif($newImage, $dest, $quality);
							break;
						case 'png' :
							imagepng($newImage, $dest, 9);
							break;
						case 'jpg' :
						case 'jpeg' :
							imagejpeg($newImage, $dest, $quality);
							break;
						default :
							return false;
							break;
					}
				
				imagedestroy($newImage);
				imagedestroy($oldImage);
				chmod($dest,0777);
				if(!$newName){
					unlink($img);
					rename($dest, $img);
				}

				return true;

		} else {
			return false;
		}
	}

	function image_type_to_extension($imagetype)
	{
		if(empty($imagetype)) return false;
			switch($imagetype)
			{
				case IMAGETYPE_GIF    : return 'gif';
				case IMAGETYPE_JPEG    : return 'jpg';
				case IMAGETYPE_PNG    : return 'png';
				case IMAGETYPE_SWF    : return 'swf';
				case IMAGETYPE_PSD    : return 'psd';
				case IMAGETYPE_BMP    : return 'bmp';
				case IMAGETYPE_TIFF_II : return 'tiff';
				case IMAGETYPE_TIFF_MM : return 'tiff';
				case IMAGETYPE_JPC    : return 'jpc';
				case IMAGETYPE_JP2    : return 'jp2';
				case IMAGETYPE_JPX    : return 'jpf';
				case IMAGETYPE_JB2    : return 'jb2';
				case IMAGETYPE_SWC    : return 'swc';
				case IMAGETYPE_IFF    : return 'aiff';
				case IMAGETYPE_WBMP    : return 'wbmp';
				case IMAGETYPE_XBM    : return 'xbm';
				default                : return false;
			}
	}
}
?>