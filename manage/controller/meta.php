<?php
namespace Controller;

/**
 * ajax 图片上传
 * @author EVEN
 *
 */
class Meta extends \Model\Authorize\Admin
{
    public function initialize()
    {
    	parent::initialize();
        $this->view = view('layouts/main.php');
    }
    
	/**
	 * 上传图片
	 */
	public function upload()
	{
        $file = \Ext\Uploader::get('ajax_upload');
		$v = new \Core\Validation();
		$v->required($file)->message('参数错误');
        if(!$v->has_error())
        {
            if($file->is_successed())
            {
                $to_path_file = '/'. time().'.'.$file->file_ext();
                $file->move(\Core\Application::config()->upload_dir .$to_path_file);
                echo json_encode(array(
                	'imgurl' => \Core\Application::config()->upload_url . $to_path_file,
                ));
                exit();
            }
            else 
            {
            	$v->required(false)->message($file->error_code());
            }
        }
		echo json_encode($v->get_error());	
		exit();
	}
	
	
    /**
     * 获取上传的文件
     */
    public function picture()
    {
        $file = \Ext\Uploader::get('file');
        if(!empty($file))
        {
            if($file->is_successed())
            {
                $to_path_file = '/'. time().'.'.$file->file_ext();
                $file->move(\Core\Application::config()->upload_dir . $to_path_file);
                echo json_encode(array(
                	'link' => \Core\Application::config()->upload_url.$to_path_file,
                ));
            }
            else 
            {
                echo $file->error_code();
            }
        }
		exit();
    }
}