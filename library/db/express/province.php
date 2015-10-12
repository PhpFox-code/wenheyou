<?php
namespace Db\Express;

class Province extends \DB\Master
{
    public static $table = 'vs_express_province';
    public static $key = 'province_id';
    
    public static $has_to = array(
        'city'=>array('model'=>'\Db\Express\City', 'provinc_id'),
    );
}