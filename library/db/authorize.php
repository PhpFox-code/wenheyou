<?php
namespace Db;

class Authorize extends \Db\Master
{
    public static $table = 'vs_authorize';
    public static $key = 'authorize_id';
    
    /**
     * 加密
     */
    public static function gen_password($password, $fix= 'chenyuwen')
    {
        return md5(md5($password).$fix);
    }
    
    public function get_level()
    {
        if($this->authorize_level == 0)
        {
            return '超级管理员';
        }
        else 
        {
            return '管理员';
        }
    }
   
}