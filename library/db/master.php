<?php
namespace DB;

class Master extends \Core\ORM
{
    
    /**
     * @return \Core\Database
     */
    public static function database()
    {
    	static $database = NULL;
    	if (is_null($database))
    	{
    	    $config = \Core\Application::config()->database['master'];
        	$database = new \Core\Database($config['db_target'], $config['user_name'], $config['password'], $config['params']);
    	}
        return $database;
    }
}