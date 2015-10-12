<?php
namespace Db\Trade;

class Cart extends \Db\Master
{
	public static $table = 'vs_trade_cart';
	public static $key = 'cart_id';
	
	public static $belongs_to = array(
	    'goods' => array('model'=>'\Db\Mall\Goods', 'relation_key'=>'goods_id'),
	);
	
	public static function remove($user_id, $status = 1)
	{
		self::database()->delete(self::$table, array('user_id'=>$user_id, 'cart_status'=>$status));
	}
	
	public static function count_cart($user_id)
	{
		$count = array(
            'total_fee' => 0,
        	'total_nums' => 0,
        );
		$rows = \Db\Trade\Cart::fetch(array('user_id'=>$user_id, 'cart_status'=>1));
        foreach ($rows as $row)
        {
        	$count['total_fee'] += $row->goods_nums * $row->goods_discount_price;
            $count['total_nums'] += $row->goods_nums;
        }
	    return $count;
	}
}