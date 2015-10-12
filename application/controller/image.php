<?php
namespace Controller;
/**
 * 获取素材文件
 * @author EVEN
 *
 */
class Image extends \Core\Controller
{
	/**
	 * 获取任意尺寸图片
	 * demo:
	 * http://wenheyou.vstry.com/image/get?path=/upload/1440605685.jpg&size=350-150
	 */
    public function get()
    {
    	$path = \Core\URI::kv('path');
    	$size = \Core\URI::kv('size');
        $width = 0;
        $height = 0;
        if(!empty($size))
        {
            $size_arr = explode('-', $size);
            $width = $size_arr[0];
            $height = $size_arr[1];
        }
        
        $file_path = $path;
        $thumb_path = preg_replace('/\/upload\/(\d+)\.(jpg|png|jpeg|gif)/i', "/upload/$1_$width-$height.$2" , $file_path);
        if(file_exists('.' .$thumb_path)){
            redirect($thumb_path);
        }else{
            if(file_exists('.' .$file_path))
            {
    	        //dump($width, $height, $size, $size_arr);exit();
    	        if(!empty($width) && !empty($height))
    	        {
    	        	$thumb_path = \Core\GD::thumb('.' . $file_path, $width, $height);
    	        }
    	        header('Content-type: image/jpeg');
            	$file = file_get_contents($thumb_path);
            	echo $file;
    			//header('Content-Disposition: attachment; filename="' . basename($thumb_path) . '"');
    			//header('X-Accel-Redirect: '.$thumb_path);
    			
            }
            else 
            {
            	header('HTTP/1.1 404 Not Found');
                exit();
            }
        }
        //header('Content-type: image/jpeg');
        /*
        header('Content-type: application/octet-stream');
        
        header('Content-Disposition: attachment; filename="' . basename($file_path) . '"');
        
        //让Xsendfile发送文件
        header('X-Accel-Redirect: '.$file_path);
        */
        
    }
}