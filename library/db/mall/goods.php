<?php
namespace DB\Mall;
/**
 * 商品模块
 * Enter description here ...
 * @author EVEN
 *
 */
class Goods extends \DB\Master
{
    public static $table = 'vs_mall_goods';
    public static $key = 'goods_id';
    
    public static $belongs_to = array(
    	'store' => array('model'=>'\Db\Mall\Store', 'relation_key'=>'store_id'),
    	'category' => array('model'=>'\Db\Mall\Category', 'relation_key'=>'category_id'),
    );
	
    public static function get_stores()
    {
        $result = array();
    	$sql = 'select s.store_name, s.store_id from vs_mall_goods as g join vs_card_store as s on g.store_id = s.store_id group by g.store_id';
    	$rows = \DB\Mall\Goods::database()->fetch($sql);
    	foreach ($rows as $row)
    	{
    	    $result[$row->store_id] = $row->store_name;
    	}
    	return $result;
    }
}