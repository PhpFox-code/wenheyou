<?php
namespace DB;

class Log extends \DB\Master
{
    public static $table = 'vs_log';
    public static $key = 'log_id';
    
    public static function message($event, $info, $op_name = NULL)
    {
       
        $log = new \Db\Log();
        $log->op_name = $op_name;
        if(empty($log->op_name))
        {
             $authorize = \Model\Authorize\Admin::login_authorize();
             $log->op_name = $authorize->authorize_name;
        }
        $log->create_time = W_START_TIME;
        $log->op_event = $event;
        $log->op_info = $info;
        return $log->save();
    }
}