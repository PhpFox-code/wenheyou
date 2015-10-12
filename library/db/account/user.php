<?php
namespace DB\Account;

class User extends \DB\Master
{
    public static $table = 'vs_account_user';
    public static $key = 'user_id';
    
    public static $has_to = array(
    	'identify' => array('model'=>'\Db\Account\Identify', 'relation_key'=>'user_id'),
    	'address' => array('model'=>'\Db\Account\Address', 'relation_key'=>'user_id'),
    );
    
    /**
     * 获取性别
     */
    public function get_gender()
    {
        if($this->user_gender == 'male')
        {
            return '男';
        }
        if($this->user_gender == 'female')
        {
            return '女';
        }
    }
}