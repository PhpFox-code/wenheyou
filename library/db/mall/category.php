<?php
namespace DB\Mall;

/**
 * 商城店铺模块
 * @author EVEN
 *
 */
class Category extends \DB\Master
{
    public static $table = 'vs_mall_category';
    public static $key = 'category_id';
    
    public static $has_to = array(
    	'goods'=>array('model'=>'\Db\Mall\Goods', 'relataion_key'=>'category_id'),
    );
}