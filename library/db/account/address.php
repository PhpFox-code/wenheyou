<?php
namespace DB\Account;

class Address extends \DB\Master
{
    public static $table = 'vs_account_address';
    public static $key = 'address_id';
    
    public static $belongs_to = array(
    	'user' => array('model'=>'\Db\Account\User', 'relation_key'=>'user_id'),
    );
    
    public static function rollback_status($user_id)
    {
    	\DB\Account\Address::database()->update(self::$table, array('is_default'=>0), array('user_id'=>$user_id));
    }
}