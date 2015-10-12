<?php
namespace Db\Express;

class Area extends \DB\Master
{
    public static $table = 'vs_express_area';
    public static $key = 'area_id';
    
    
    public static $belongs_to = array(
        'city'=>array('model'=>'\Db\Express\City', 'city_id'),
    );
}