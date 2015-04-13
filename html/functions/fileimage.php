<?php
//IMAGE AND FILE FUNCTIONS
//DIRECTIONS:
//Call the imageUpload function in the code and it will return any errors that occur. 
//If no errors are returned then the JPG image is uploaded successfully.
//WRITTEN BY MATTHEW FLEMING 2008

function imageUploadSized($width,$height,$folder,$filename)
{
	$uploaddir = "uploads/";
	if($_FILES['IMAGE']['type'] != "")
	{
		$uploadfile = $uploaddir . basename($_FILES['IMAGE']['name']);
		$imagetype = $_FILES['IMAGE']['type'];
		$entry = $_FILES['IMAGE']['name'];
		move_uploaded_file($_FILES['IMAGE']['tmp_name'], $uploadfile);
			
		if(($imagetype == "image/jpeg" OR $imagetype == "image/jpg" OR $imagetype == "image/pjpeg" || $imagetype == "image/png" || $imagetype == "image/gif"))
		{
			$image = new Imagick($uploadfile);
			$image->thumbnailImage($width, $height, false);
			$image->writeImage($folder.$filename);
			unlink($uploadfile);
			
			/*if(createImage($uploaddir,$entry,$width,$height,$filename))
				moveUploadedPhoto($filename,$folder);
			else
				$error = "$entry is not a valid .JPG file. New Image not uploaded.";*/
		}
		else
			$error = "$entry is not a valid .JPG file. New Image not uploaded.";
		if(file_exists("uploads/$entry"))
			unlink("uploads/$entry");
	}
	return $error;
}
function imageUpload($maxres,$folder,$filename)
{
	$uploaddir = "uploads/";
	if($_FILES['IMAGE']['type'] != "")
	{
		$uploadfile = $uploaddir . basename($_FILES['IMAGE']['name']);
		$imagetype = $_FILES['IMAGE']['type'];
		$entry = $_FILES['IMAGE']['name'];
		move_uploaded_file($_FILES['IMAGE']['tmp_name'], $uploadfile);
			
		if(($imagetype == "image/jpeg" OR $imagetype == "image/jpg" OR $imagetype == "image/pjpeg" || $imagetype == "image/png" || $imagetype == "image/gif"))
		{
			$w = getWidth($entry,$maxres);
			$h = getHeight($entry,$maxres);
			
			$image = new Imagick($uploadfile);
			$image->thumbnailImage($w, $h, false);
			$image->writeImage($folder.$filename);
			unlink($uploadfile);
		}
		else
			$error = "$entry is not a valid .JPG file. New Image not uploaded.";
		if(file_exists("uploads/$entry"))
			unlink("uploads/$entry");
	}
	return $error;
}
function getHeight($entry,$max)
{		 	
	$width = width($entry);
	$height = height($entry);
	$w = $width;
	$h = $height;
	if ($width > $max && $width >= $height)
	{
		$w = $max;
		$h = ($w / $width) * $height;
	}
	if ($height > $max && $height >= $width)
	{
		$h = $max;
		$w = ($h / $height) * $width;
	}
	return $h;
}
function getWidth($entry,$max)
{		 	
	$width = width($entry);
	$height = height($entry);
	$w = $width;
	$h = $height;
	if ($width > $max && $width >= $height)
	{
		$w = $max;
		$h = ($w / $width) * $height;
	}
	if ($height > $max && $height >= $width)
	{
		$h = $max;
		$w = ($h / $height) * $width;
	}
	return $w;
}
function width($image)
{
	$image = "uploads/".$image;
	$size = getimagesize($image);
	return $size[0];
}

function width2($image)
{
	$size = getimagesize($image);
	return $size[0];
}

function height($image)
{
	$image = "uploads/".$image;
	$size = getimagesize($image);
	return $size[1];
}

function height2($image)
{
	$size = getimagesize($image);
	return $size[1];
}

function createImage($uploaddir,$entry,$thumb_w,$thumb_h,$image)
{
	if($src_img = imagecreatefromjpeg($uploaddir.$entry))
	{
		$dst_img = imagecreatetruecolor($thumb_w,$thumb_h);
		imagecopyresampled($dst_img,$src_img,0,0,0,0,$thumb_w,$thumb_h,imagesx($src_img),imagesy($src_img));
		imagejpeg($dst_img, "$uploaddir/$image");
		return true;
	}
	else
		return false;
}
function moveUploadedPhoto($filename,$folder)
{
	$file = "uploads/".$filename;
	$newfile = $folder.$filename;
	copy($file,$newfile);
	unlink($file);
}
function moveUploadedFile($filename,$folder)
{
	$file = "uploads/".$filename;
	$newfile = $folder.$filename;
	copy($file,$newfile);
	unlink($file);
}
function fileUpload($folder, $filename, $fieldname)
{
	if($_FILES[$fieldname]['error'] == 0)
	{
		$uploadfile = $folder . $filename;
		if (!move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadfile))
			return false;
	}
	else
		return false;
}
function moveUploadedDocument($folder,$filename,$newfilename)
{
	$file = "uploads/".$filename;
	$newfile = $folder.$newfilename;
	copy($file,$newfile);
	unlink($file);
}
function getExtension($fn) {
	$fn = explode('.',$fn);
	return $fn[count($fn)-1];
}
function dirList ($directory) 
{

    // create an array to hold directory list
    $results = array();

    // create a handler for the directory
    $handler = opendir($directory);

    // keep going until all files in directory have been read
    while ($file = readdir($handler)) {

        // if $file isn't this directory or its parent, 
        // add it to the results array
        if ($file != '.' && $file != '..')
            $results[] = $file;
    }

    // tidy up: close the handler
    closedir($handler);

    // done!
    return $results;

}
function imageThumbCropper($filename, $thumb_width, $thumb_height)
{
	$image = imagecreatefromjpeg($filename);

	$width = imagesx($image);
	$height = imagesy($image);

	$original_aspect = $width / $height;
	$thumb_aspect = $thumb_width / $thumb_height;

	if($original_aspect >= $thumb_aspect) {
 	  // If image is wider than thumbnail (in aspect ratio sense)
  		$new_height = $thumb_height;
   		$new_width = $width / ($height / $thumb_height);
	} else {
   		// If the thumbnail is wider than the image
   		$new_width = $thumb_width;
   		$new_height = $height / ($width / $thumb_width);
	}

	$thumb = imagecreatetruecolor($thumb_width, $thumb_height);

	// Resize and crop
	imagecopyresampled($thumb,
                   $image,
                   0 - ($new_width - $thumb_width) / 2, // Center the image horizontally
                   0 - ($new_height - $thumb_height) / 2, // Center the image vertically
                   0, 0,
                   $new_width, $new_height,
                   $width, $height);
      imagejpeg($thumb, $filename, 80);
}
function cleanFilename($filename)
{
	$filename = ereg_replace("[^a-z0-9.]"," ",strtolower($filename));
	$filename = mysqlclean($filename);
	
	$filename = str_replace(" ","-",$filename);
	$filename = str_replace("----","-",$filename);
	$filename = str_replace("---","-",$filename);
	$filename = str_replace("--","-",$filename);
	return $filename;
}
function moveUploadedImage($fieldname="IMAGE")
{
	$uploadfile = "uploads/" . basename($_FILES[$fieldname]['name']);
	$imagetype = $_FILES[$fieldname]['type'];
	$entry = $_FILES[$fieldname]['name'];
	move_uploaded_file($_FILES[$fieldname]['tmp_name'], $uploadfile);
}
?>