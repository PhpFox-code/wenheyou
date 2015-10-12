<?php
namespace Model;

class Common
{
	public static function get_upload_url($file='', $width=0, $height=0)
	{
		return preg_replace('/\/upload\/(\d+)\.(jpg|png|jpeg|gif)/i', "/upload/$1_{$width}x{$height}.$2", $file);
	}
}