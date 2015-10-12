<?php
namespace Controller;

class Account extends \Model\Authorize\Admin
{
    public function initialize()
    {
    	parent::initialize();
    	
        $this->view = view('layouts/main.php');
        
    }
    
    public function index()
    {
        $this->view->content = view('account/index.php');
    }
    
    public function changepw()
    {
        $password = \Core\URI::kv('password');   
        $new_password = \Core\URI::kv('new_password');   
        $repeat_password = \Core\URI::kv('repeat_password');   
        $v = new \Core\Validation();
        $v->required($password)->message('密码');
        $v->required($new_password)->message('新密码不能为空');
        $v->filter_var($new_password == $repeat_password)->message('重复新密码不正确');
        if (!$v->has_error())
        {
            $authorize_id = \Core\Session::get('authorize_id');
            $row = \DB\Authorize::row(array('authorize_id'=>$authorize_id));
            $gen_password = \DB\Authorize::gen_password($password);
            if ($gen_password == $row->authorize_password)
            {
                $row->authorize_password = \DB\Authorize::gen_password($new_password);
                $row->save();
				$v->required(false)->message('密码修改成功，退出当前登录生效');
            }
            else 
            {
            	$v->required(false)->message('原始密码不正确');
            }
        }
        echo json_encode($v->get_error());exit();
    }
    
    
    public function send()
    {
        echo $this->view;
    }
}