<?php
namespace Core;
/**
 * 图片处理
 * @author EVEN
 *
 */
use Controller\Image;

class GD
{
	/**
	 * Create a JPEG thumbnail for the given png/gif/jpeg image and return the path to the new image .
	 *
	 * @param string $file the file path to the image
	 * @param int $width the width
	 * @param int $height the height
	 * @param int $quality of image thumbnail
	 * @return string
	 */
	public static function thumb($file, $width = 80, $height = 80, $quality = 80, $center = true)
	{
		
		if(!file_exists($file))
		{
		    return false;  
		} 
		$path_parts  = pathinfo($file);
		$dir = $path_parts['dirname'];
		$name = $path_parts['filename'] . "_{$width}-{$height}.jpg";
		
		$new_file = $dir.W_DS.$name;
		
		
		// If the thumbnail already exists, we can't write to the directory, or the image file is invalid
		if(file_exists($new_file))
		{
			return $new_file;
		}
		
		
		if( ! directory_is_writable($dir))
		{ 
		    return false;
		}
		
		$image = self::open($file);
		//dump($image, $file);exit();
		if(!$image)
		{
			return false;
		}
		
		
		// Resize the image and save it as a compressed JPEG
		$obj = self::resize($image, $width, $height, $center);
		
		if(imagejpeg($obj, $new_file, $quality))
		{
			return $new_file;
		}
		return false;
	}
	
	/**
	 * Open a resource handle to a (png/gif/jpeg) image file for processing .
	 *
	 * @param string $file the file path to the image
	 * @return resource
	 */
	protected static function open($file)
	{
		if(! is_file($file))
		{ 
		    return false;   
		}
		$ext = pathinfo($file, PATHINFO_EXTENSION);
		// Invalid file type?
		if( ! in_array($ext, array('jpg', 'jpeg', 'png', 'gif')))
		{ 
		    return false;
	    }
	    
		// Open the file using the correct function
		$function = 'imagecreatefrom'. ($ext == 'jpg' ? 'jpeg' : $ext);
		
		$image = $function($file);
		if($image)
		{
			return $image;
		}
	}
	
	/**
	 * Resize and crop the image to fix proportinally in the given dimensions .
	 *
	 * @param resource $image the image resource handle
	 * @param int $width the width
	 * @param int $height the height
	 * @param bool $center to crop from image center
	 * @return resource
	 */
	protected static function resize($image, $width, $height, $center = FALSE)
	{
		$x = imagesx($image);
		$y = imagesy($image);
		$small = min($x/$width, $y/$height);
		//var_dump($small);exit();
		// Default CROP from top left
		$sx = $sy = 0;
		// Crop from image center?
		if($center && $x != $y)
		{
			if($y/$height > $x/$width)
			{
				$sy = $y/4-($height/4);
			}
			else
			{
				$sx = $x/2-($width/2);
			}
		}
		$new = imagecreatetruecolor($width, $height);
		self::alpha($new);
		// Crop and resize image
		imagecopyresampled($new, $image, 0, 0, $sx, $sy, $width, $height, $x-($x-($small*$width)), $y-($y-($small*$height)));
		return $new;
	}
	
	/**
	 * Preserve the alpha channel transparency in PNG images
	 *
	 * @param resource $image the image resource handle
	 */
	protected static function alpha($image)
	{
		imagecolortransparent($image, imagecolorallocate($image, 0, 0, 0));
		imagealphablending($image, false);
		imagesavealpha($image, true);
	}
}