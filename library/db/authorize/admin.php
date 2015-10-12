<?php
namespace Db\Authorize;

class Admin extends \Db\Master
{
    public static $table = 'vs_authorize_admin';
    public static $key = 'admin_id';
    
    /**
     * 加密
     */
    public static function gen_password($password, $fix= 'chenyuwen')
    {
        return md5(md5($password).$fix);
    }
    
    /**
     * 获取管理员级别
     */
    public function get_level()
    {
        if($this->admin_level == 0)
        {
            return '超级管理员';
        }
        else 
        {
            return '管理员';
        }
    }
   
}