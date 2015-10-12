<?php
namespace Model\Authorize;

class Admin extends \Core\Controller
{
    public function initialize()
    {
        $admin = self::login_admin();
        if (empty($admin))
        {
            redirect(\Core\URI::a2p(array('main'=>'index')));
        }
    }
    
    public static function login_admin()
    {
        static $admin = NULL;
        if(empty($admin))
        {
    	    $admin_id = \Core\Session::get('admin_id');
    	    if(!empty($admin_id))
    	    {
    	        $admin = \DB\Authorize\Admin::row(array('admin_id'=>$admin_id));
    	    }
        }
        return $admin;
    }
}