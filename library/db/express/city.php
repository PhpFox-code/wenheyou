<?php
namespace Db\Express;

class City extends \DB\Master
{
    public static $table = 'vs_express_city';
    public static $key = 'city_id';
    
    public static $has_to = array(
        'area'=>array('model'=>'\Db\Express\Area', 'city_id'),
    );
    
    public static $belongs_to = array(
        'provinc'=>array('model'=>'\Db\Express\Province', 'province_id'),
    );
}