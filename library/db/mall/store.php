<?php
namespace DB\Mall;

/**
 * 商城店铺模块
 * @author EVEN
 *
 */
class Store extends \DB\Master
{
    public static $table = 'vs_mall_store';
    public static $key = 'store_id';
    
    public static $has_to = array(
    	'goods'=>array('model'=>'\Db\Mall\Goods', 'relataion_key'=>'category_id'),
    );
}