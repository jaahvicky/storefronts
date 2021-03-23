<?php

namespace App\Http\Controllers\BackOffice;

use App;
use Exception;
use Imagick;
use Input;
use Request;
use Response;
use URL;
use View;

class UploadController extends BaseController {

	public static $INVALID_REQUEST = 1;
	public static $ERROR_UPLOAD_FILE = 2;
	public static $FILE_INVALID = 3;
   
   	public function __construct(){
       //parent::__construct();
    }

	public function upload() {
           
		$contentType = array('Content-Type' => 'application/json');
		if (Request::header('Content-Type') != 'application/json') {
			$contentType = array('Content-Type' => 'text/plain'); //Fix for IE 7/8/9 which does not accept json.
		}

		if (!Input::hasFile('file')) {
			return Response::json(array('errorURL' => URL::route('fileupload-error', array('code' => self::$ERROR_UPLOAD_FILE))), 200, $contentType);
		}

		if (!Input::file('file')->isValid()) {
			return Response::json(array('errorURL' => URL::route('fileupload-error', array('code' => self::$FILE_INVALID))), 200, $contentType);
		}

		$file = Input::file('file');
		$filename = 'file_' . time() . '.' . $file->getClientOriginalExtension();
                \Storage::disk('public')->put($filename,  \File::get($file));
                
//		if (Input::has('imageResize')) {
//			$dimens = explode(',', Input::get('imageResize'));
//			$width = (int)$dimens[0];
//			$height = (int)$dimens[1];
//			
//			$resizeResult = $this->resizeImage($filename, $width, $height);
//			if ($resizeResult !== true) {
//				return Response::json(['error' => $resizeResult->getMessage()], 200, $contentType);
//			}
//		}
//       
		$size = $this->rotateImageToHorizontal($filename);         
                
		return Response::json(array(
					'url' => \Storage::url($filename),
					'path' => 'storage',
					'size'=> $size,
					'filename' => $filename,
                                        'fullUrl' => asset(\Storage::url($filename))
						), 200, $contentType
		);
	}

	private function resizeImage($file, $width, $height = 0) {
		try {
			$width = $width === 0 ? null : $width;
			$height = $height === 0 ? null : $height;
			\ImageHelper::resizeImage($file, $width, $height);
		} catch (Exception $e) {
			return $e;
		}

		return true;
	}

	private function rotateImageToHorizontal($filename){
		$file_orginalname =  $filename;
		$filename = asset(\Storage::url($filename));
		$dimens = getimagesize($filename);
		$width = (int)$dimens[0];
		$height = (int)$dimens[1];
		if($width < $height){
			 $exif = exif_read_data($filename);
			if(!empty($exif['Orientation'])) {
		        switch($exif['Orientation']) {
		            case 8:
		                $degree = 90;
		                break;
		            case 3:
		                $degree = 180;
		                break;
		            case 6:
		                $degree = -90;
		                break;
		            case 1:
		                $degree = -90;
		                break;
		            default:
		             	$degree = 0;
		             	break;
		        }
		      $system = explode(".", $filename);
              $num = sizeof($system) - 1; 
                 
              if (preg_match("/jpg|jpeg/", $system[$num])) {
                 $src_img = imagecreatefromjpeg($filename);
              }elseif (preg_match("/png/", $system[$num])) {
                  $src_img = imagecreatefrompng($filename);
              }elseif (preg_match("/gif/", $system[$num])) {
                  $src_img = imagecreatefromgif($filename);
              }

		      $rotate = imagerotate($src_img,$degree,0);
		      
		      if (preg_match("/png/", $system[$num])) {
                    imagepng($rotate, 'storage/'.$file_orginalname);
               } elseif(preg_match("/gif/", $system[$num])) {
                    imagegif($rotate, 'storage/'.$file_orginalname);
               } elseif(preg_match("/jpg|jpeg/", $system[$num])) {
                  imagejpeg($rotate, 'storage/'.$file_orginalname);
               }
               

		      imagedestroy($src_img); 
		      imagedestroy($rotate);  
		      return ['width'=> $width, 'height'=>$height, 'degree'=> $degree, 'extension'=> $system[$num],'explode'=>  $system];
		    }else{
		    	return ['width'=> $width, 'height'=>$height, 'ori'=> $exif];
		    }
			
		}else{
			return [$dimens];
		}
		
	}
}
