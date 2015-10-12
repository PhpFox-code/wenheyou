<?php
namespace Controller;

class Main extends \Core\Controller
{
    
    /**
     * 输出界面
     */
    public function index()
    {
        echo view('main/login.php');
    }
    
    /**
     * 登录
     */
    public function login()
    {
        $account =  \Core\URI::kv('user_account');
        $password = \Core\URI::kv('user_password');
        $v = new \Core\Validation();
        $v->filter_var(filter_var($account, FILTER_VALIDATE_EMAIL))->message('邮箱帐号错误');
        if ($v->has_error())
        {
            \Core\Cookie::set('error', $v->get_error('message'));
        }
        else 
        {
            $gen_password = \DB\Authorize\Admin::gen_password($password);
            $row = \DB\Authorize\Admin::row(array('admin_account'=>$account, 'admin_password'=>$gen_password));
            //var_dump(!empty($row->admin_account));exit();
            if (!empty($row->admin_account))
            {
                
                \Db\Log::message('登录', '', $row->admin_name);
                \Core\Session::set('admin_id', $row->admin_id);
                redirect(\Core\URI::a2p(array('order'=>'index')));
            }
        }
        redirect(\Core\URI::a2p(array('main'=>'index')));
    }
    
    /**
     * 退出登录
     */
    public function out()
    {
    	$admin = \Model\Authorize\Admin::login_admin();
        \Db\Log::message('退出', '退出系统', $admin->admin_name);
        \Core\Session::destory();
        redirect(\Core\URI::a2p(array('main'=>'index')));
    }
}