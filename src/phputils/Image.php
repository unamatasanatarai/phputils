<?php
/**
 * Quick file for making Thumbnails using Imagine
 */
if (!defined('DS')){
	define('DS', DIRECTORY_SEPARATOR);
}
use \Imagine\Image\Box;
use \Imagine\Image\Point;
use \Imagine\Image\ImageInterface;

class Image{
	/**
	 * Make centered thumbnail
	 */
	static public function thumb($src, $width, $height, $fallback_image = ''){
		if (!is_file($src)){
			return $fallback_image;
		}
		$file = new File($src, false);
                $its = "_its/";
		if (!is_dir($file->folder()->path . DIRECTORY_SEPARATOR . $its)){
                    new Folder($file->folder()->path . DIRECTORY_SEPARATOR . $its, true);
                }
                $thumb_folder_name = "_its/{$width}_{$height}/";
		$folder = new Folder($file->folder()->path . DIRECTORY_SEPARATOR . $thumb_folder_name, true);
		$target_name = $file->name() . '.' . $file->ext();
		$target_path = $folder->path . DIRECTORY_SEPARATOR;
		if (is_file($target_path . $target_name)){
			return $thumb_folder_name . $target_name;
		}

		$imagine = new \Imagine\Gd\Imagine();
		$transformation = new \Imagine\Filter\Transformation();
// math for centering & thumbnailing
		$image = $imagine->open($src);
		$size  = $image->getSize();
		$rw    = $width / $size->getWidth();
		$rh    = $height / $size->getHeight();
		$ns    = max($rw, $rh);

		$nw    = floor($size->getWidth()*$ns);
		$nh    = floor($size->getHeight()*$ns);

		$transformation
			->resize(new Box($nw, $nh))
			->crop(new Point(ceil(($nw - $width) / 2),ceil(($nh-$height)/2)), new Box($width, $height))
	    	->save($target_path . $target_name, array('jpeg_quality' => 100, 'png_compression_level' => 9));

		$transformation->apply($imagine->open($src));


		return $thumb_folder_name . $target_name;
	}
}
