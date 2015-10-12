<?php
namespace Controller;

class admin extends \Model\Authorize\Admin
{
    public function initialize()
    {
    	parent::initialize();
    	
        $this->view = view('layouts/main.php');
        $this->admin = \Model\Authorize\Admin::login_admin();
        if($this->admin->admin_level != 0)
        {
            $this->view->content = view('admin/denied.php');
            $this->send();
            exit();
        }
        
    }
    
    public function index()
    {
        $this->view->content = view('admin/index.php');
        $this->view->content->rows = \DB\Authorize\Admin::fetch(null, NULL, null, array('create_time'=>'desc'));
    }
    
    public function send()
    {
        echo $this->view;
    }
    
   /**
     * 添加视图
     */
    public function add()
    {
    	\Core\View::script('/manage/js/ajaxfileupload.js');
        $this->view->content = view('admin/add.php');
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
	            $admin = new \DB\Authorize\Admin($id);
	            if($admin->admin_level != 0)
	            {
	                \Db\Log::message('删除', "删除角色:".$admin->admin_name, $this->admin->admin_name);
	                $admin->delete();
	            }
			}
        }
        echo json_encode($v->get_error());exit();
    }
    
    /**
     * 保存
     */
    public function save()
    {
        $admin_avatar = \Core\URI::kv('ajax_image');   
        $admin_name = \Core\URI::kv('admin_name');   
        $admin_account = \Core\URI::kv('admin_account');   
        $admin_password = \Core\URI::kv('admin_password');   
        $admin_mobile = \Core\URI::kv('admin_mobile');   
        $v = new \Core\Validation();
        $v->required($admin_avatar)->message('头像不能为空');
        $v->required($admin_name)->message('姓名称不能为空');
        $v->required($admin_account)->message('帐号不能为空');
        $v->required($admin_password)->message('密码不能为空');
        $v->required($admin_mobile)->message('手机号码不能为空');
        if (!$v->has_error())
        {
        	
            $id = \Core\URI::kv('id', null);
            $link = new \Db\Authorize\Admin($id);
            $link->admin_avatar = $admin_avatar;
            $link->admin_name = $admin_name;
            $link->admin_account = $admin_account;
            $link->admin_mobile = $admin_mobile;
            
            // ID
            if(empty($id))
            {
                $link->admin_password = \Db\Authorize\Admin::gen_password($admin_password);
            }
            else 
            {
                if($link->admin_password != $admin_password)
                {
                    $link->admin_password = \Db\Authorize\Admin::gen_password($admin_password);
                }
            }
            
            $link->create_time = W_START_TIME;
            $link->save();
            if(empty($id))
            {
                \Db\Log::message('添加', "添加角色:".$admin_name, $this->admin->admin_name);
            }
            else 
            {
                \Db\Log::message('更新', "更新角色:".$admin_name, $this->admin->admin_name);
            }
        }
		echo json_encode($v->get_error());exit();
    }

    /**
     * 获取某列数据
     */
	public function get()
	{
    	\Core\View::script('/manage/js/ajaxfileupload.js');
	    $id = \Core\URI::kv('id');
        $v = new \Core\Validation();
        $v->required($id)->message('参数错误');
        
        if(!$v->has_error())
        {
            $this->view->content = view('admin/get.php');
            $this->view->content->row = new \DB\Authorize\Admin($id);;
        }
	}
}