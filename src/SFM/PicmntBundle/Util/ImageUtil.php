<?php

namespace SFM\PicmntBundle\Util;

use Symfony\Component\DependencyInjection\ContainerInterface;

class ImageUtil{

    private $container;
    private $uploadPath;
    private $thumbsPath;
    


    public function __construct(ContainerInterface $container ){
	$this->container = $container;

	$imageUtilsConfig = $container->getParameter('image_utils');
	$this->uploadPath = $imageUtilsConfig['upload_path'];
	$this->thumbsPath = $imageUtilsConfig['thumbs_path'];
    }




    public function resizeImage($imageFile, $maxSize){
	$imageFile = $this->uploadPath.$imageFile;
	$width = $maxSize;
	$height = $maxSize;

	list($widthOrig, $heightOrig) = getimagesize($imageFile);

	if ($widthOrig > $maxSize or $heightOrig > $maxSize){

	    $ratioOrig = $widthOrig/$heightOrig;
      
	    if ($width/$height > $ratioOrig) {
		$width = $height * $ratioOrig;
	    }
	    else{
		$height = $width / $ratioOrig;
	    }

	    $image_p = imagecreatetruecolor($width, $height);

	    if (exif_imagetype($imageFile) == 2){ //jpeg
		$image = imagecreatefromjpeg($imageFile);      
	    }
	    elseif (exif_imagetype($imageFile) == 3){ //PNG
		$image = imagecreatefrompng($imageFile);
	    }
	    imagecopyresampled($image_p,$image, 0,0,0,0,$width, $height, $widthOrig, $heightOrig);
      
	    imagejpeg($image_p,$imageFile,90);
	}
    }



    public function createImageSmall($imageFile, $imageFileDest, $maxSize){
	$imageFile = $this->uploadPath.$imageFile;
	$imageFileDest = $this->thumbsPath.$imageFileDest;
	$width = $maxSize;
	$height = $maxSize;

	list($widthOrig, $heightOrig) = getimagesize($imageFile);

	if ($widthOrig > $maxSize or $heightOrig > $maxSize){

	    $ratioOrig = $widthOrig/$heightOrig;
      
	    if ($width/$height > $ratioOrig) {
		$width = $height * $ratioOrig;
	    }
	    else{
		$height = $width / $ratioOrig;
	    }

	    $image_p = imagecreatetruecolor($width, $height);

	    if (exif_imagetype($imageFile) == 2){ //jpeg
		$image = imagecreatefromjpeg($imageFile);      
	    }
	    elseif (exif_imagetype($imageFile) == 3){ //PNG
		$image = imagecreatefrompng($imageFile);
	    }

	    imagecopyresampled($image_p,$image, 0,0,0,0,$width, $height, $widthOrig, $heightOrig);

	    imagejpeg($image_p,$imageFileDest,60);
	}
    }


    public function getExtension($mimeType)
    {
	if ($mimeType= 'image/png' ){
	    return '.png';
	}
	return '.jpg';
    }
}

