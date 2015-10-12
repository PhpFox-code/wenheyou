<?php
namespace DB\Account;

/**
 * 身份识别
 * @author EVEN
 *
 */
class Identify extends \DB\Master
{
    public static $table = 'vs_account_identify';
    public static $key = 'identify_id';
    
    public static $belongs_to = array(
    	'user' => array('model'=>'\Db\Account\user', 'relation_key'=>'user_id'),
    );
}