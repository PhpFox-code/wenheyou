<?php
namespace Controller;

class Slide extends \Model\Authorize\Admin
{
    public function initialize()
    {
    	parent::initialize();
        $this->view = view('layouts/main.php');
    }
    
    /**
     * 列表
     */
    public function index()
    {
        $this->view->content = view('slide/index.php');
        $this->view->content->rows = \DB\Mall\Slide::fetch(null, 0, 0, array('slide_order'=>'desc'));
//        $data = array();
//        foreach ($rows as $row)
//        {
//            $data[$row->group_name][] = $row;
//        }
//        $this->view->content->rows = $data;
    }
    
    /**
     * 添加视图
     */
    public function add()
    {
    	\Core\View::script('/manage/js/ajaxfileupload.js');
        $this->view->content = view('slide/add.php');
    }
    
    /**
     * 保存
     */
    public function save()
    {
        $slide_pic = \Core\URI::kv('ajax_image');     
        $slide_target = \Core\URI::kv('slide_target');   
        $slide_link = \Core\URI::kv('slide_link');   
        $slide_title = \Core\URI::kv('slide_title');   
        $slide_order = \Core\URI::kv('slide_order');   
        $v = new \Core\Validation();
        $v->required($slide_pic)->message('图片不能为空');
        $v->required($slide_target)->message('打开方式不能为空');
        $v->required($slide_order)->message('排序值不能为空');
        if (!$v->has_error())
        {
            $slide_id = \Core\URI::kv('slide_id', null);
            $link = new \DB\Mall\Slide($slide_id);
            $link->slide_pic = $slide_pic;
            $link->slide_target = $slide_target;
            $link->slide_link = $slide_link;
            $link->slide_title = $slide_title;
            $link->slide_order = $slide_order;
            $link->save();
        }
        else 
        {
            \Core\Cookie::set('message', $v->get_error('message'));
        }
        $errors = $v->get_error();
		echo json_encode($errors);exit();
    }

    /**
     * 获取某列数据
     */
	public function get()
	{
    	\Core\View::script('/manage/js/ajaxfileupload.js');
	    $slide_id = \Core\URI::kv('id');
        $v = new \Core\Validation();
        $v->required($slide_id)->message('参数错误');
        
        if(!$v->has_error())
        {
            $this->view->content = view('slide/get.php');
            $this->view->content->data = new \DB\Mall\Slide($slide_id);;
        }
	}
    
    /**
     * 删除友情连接
     */
    public function delete()
    {
        $ids = \Core\URI::kv('ids');
        $v = new \Core\Validation();
        $v->required($ids)->message('参数错误');
        
        if(!$v->has_error())
        {
        	$id_arr = explode('-', $ids);
			foreach($id_arr as $id)
			{
	            $slide = new \DB\Mall\Slide($id);
	            $slide->delete();
			}
        }
        echo json_encode($v->get_error());exit();
    }
    
    /**
     * 输出视图
     */
    public function send()
    {
        echo $this->view;
    }
}