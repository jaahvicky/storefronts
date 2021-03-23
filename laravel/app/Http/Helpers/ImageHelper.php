<?php

namespace App\Http\Helpers;

class ImageHelper {

	const RESIZE_TYPE_BANNER = 1;
	const RESIZE_TYPE_SPECIAL = 2;

	private $resizeValues = [
		self::RESIZE_TYPE_BANNER => ['width' => 1920, 'height' => null],
		self::RESIZE_TYPE_SPECIAL => ['width' => 1920, 'height' => null]
	];

	public function resizeImageByType($image, $resizeType) {
		$img = \Image::make($image);
		$img->resize($this->resizeValues[$resizeType]['width'], $this->resizeValues[$resizeType]['height'], function ($constraint) {
			$constraint->aspectRatio();
		});
	}

	public function resizeImage($image, $width = null, $height = null) {
		$img = \Image::make($image);
		$img->resize($width, $height, function ($constraint) {
			$constraint->aspectRatio();
		});
		$img->save();
	}

}
