<?php
namespace Controller;

class Debug extends \Core\Controller
{
    
    public function chenyuwen()
    {
    	$user_id = \Core\URI::kv('user_id', 1);
	    \Core\Session::set('user_id', $user_id);
	    echo "设置测试帐号:$user_id";
    }
    
    public function wuchao()
    {
    	$user_id = \Core\URI::kv('user_id', 5);
	    \Core\Session::set('user_id', $user_id);
	    echo "设置测试帐号:$user_id";
    }
    
    public function show()
    {
        echo 'rtyreyret';
    }
}