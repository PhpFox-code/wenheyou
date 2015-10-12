<?php
namespace DB\Trade;

class Order extends \DB\Master
{
    public static $table = 'vs_trade_order';
    public static $key = 'order_id';
    
    public static $belongs_to = array(
        'user' => array('model'=>'\Db\Account\User', 'relation_key'=>'user_id'),
    );
    
    /**
     * 创建订单ID
     */
    public static function gen_orderid()
    {
        return W_START_TIME . rand(1000, 9999);
    }
    
    /**
     * 获取状态
     */
    public function get_status()
    {
        if($this->order_status == 0 && $this->pay_type == 0 && $this->pay_status == 0)
        {
            return '<span class="order_cash">待支付（微信支付）</span>';
        }
        elseif($this->order_status == 1 && $this->pay_type == 0 && $this->pay_status == 1 || $this->order_status == 1 && $this->pay_type == 1 && $this->pay_status == 0)
        {
            return '<span class="order_payed">待确认</span>';
        }
        elseif($this->order_status == 2)
        {
            return '<span class="order_passed">订单已确认</span>';
        }
        elseif($this->order_status == 3)
        {
            return '<span class="order_sending">配送中</span>';
        }
        elseif($this->order_status == 4)
        {
            return '<span class="order_done">已送达</span>';
        }
        elseif($this->order_status == 5)
        {
            return '已作废';
        }
    }
    
    /**
     * 获取支付状态
     */
    public function get_pay_type()
    {
        if($this->pay_type == 0)
        {
            return '在线支付';
        }
        else
        {
             return '货到付款';
        }
    }
    
    /**
     * 商品价格
     */
    public function order_amount()
    {
    	$fee = 0.00;
    	$cart = unserialize($this->cart_text);
    	foreach ($cart as $row)
    	{
    	    $fee += $row->goods_discount_price * $row->goods_nums;
    	}
    	return $fee;
    }
    
    /**
     * 总价格
     */
    public function total_amount()
    {
        $fee = $this->order_amount;
    	return $fee < 0 ? 0 : $fee;
    }
    
    /**
     * 从购物车创建订单
     */
    public function create_from_cart($cart, $pay_type, $pick_time, $user_name, $user_mobile, $address_province, $address_city, $address_area, $address_street, $order_remark)
    {
    	$user_id = '';
    	$nums = 0;
    	foreach ($cart as $key => $row)
    	{
    		if($key == 0)
    		{
    			$user_id = $row->user_id;
    		}
    		$nums += $row->goods_nums;
    	}
		$order_id = self::gen_orderid();
        $this->order_id = $order_id;
        $this->user_id = $user_id;
        $this->create_time = W_START_TIME;
        // 订单数量
        $this->order_nums = $nums;
        $this->user_name = $user_name;
        $this->user_mobile = $user_mobile;
        $this->address_province = $address_province;
        $this->address_city = $address_city;
        $this->address_area = $address_area;
        $this->address_street = $address_street;
        $this->cart_text = serialize($cart);
        $this->order_amount = $this->order_amount();
        $this->total_amount = $this->total_amount();
        $this->order_status = 0;
        $this->pick_time = $pick_time;
        
        $this->pay_type = $pay_type;
        if($this->pay_type == 1)
        {
        	$this->order_status = 1 ;
        }
        $this->pay_status = 0;
        $this->order_remark = $order_remark;
        $this->insert();
        // 清理购物车
        \Db\Trade\Cart::remove($user_id, 1);
        return $order_id;
    }
    
    /**
     * 订单作废,15天后自动回收
     */
    public static function gc()
    {
        $where = array('order_status'=>0, 'pay_status'=>0);
        $rows = \DB\Trade\Order::fetch($where, 10, 0, array('create_time'=>'desc'));
        foreach($rows as $row)
        {
            if($row->create_time < W_START_TIME - 15 * 3600 * 24)
            {
                $row->order_status = 2;
                $row->save();
            }
        }
    }
    
    /**
     * 支付状态确认
     */
    public function pay_status()
    {
    	if($this->pay_status > 0)
    	{
    		return true;
    	}
    	require_once W_LIBRARY_PATH . '/wx/pay/WxPayPubHelper/WxPayPubHelper.php';
    	
    	$out_trade_no = $this->order_id;

		//使用订单查询接口
		$orderQuery = new \OrderQuery_pub();
		//设置必填参数
		//appid已填,商户无需重复填写
		//mch_id已填,商户无需重复填写
		//noncestr已填,商户无需重复填写
		//sign已填,商户无需重复填写
		$orderQuery->setParameter("out_trade_no","$out_trade_no");//商户订单号 
		//非必填参数，商户可根据实际情况选填
		//$orderQuery->setParameter("sub_mch_id","XXXX");//子商户号  
		//$orderQuery->setParameter("transaction_id","XXXX");//微信订单号
		
		//获取订单查询结果
		$orderQueryResult = $orderQuery->getResult();

		if($orderQueryResult["return_code"] == 'SUCCESS')
		{
			//$this->mch_id = $notify->data['mch_id'];
			$this->trade_type = $orderQueryResult['trade_type'];
			$this->transaction_id = $orderQueryResult['transaction_id'];
			$this->bank_type = $orderQueryResult['bank_type'];
			$this->mch_id = $notify->data['mch_id'];
			$this->fee_type = $orderQueryResult['fee_type'];
			//$this->coupon_fee = $orderQueryResult['coupon_fee'];
			$this->pay_status = 1;
			if($this->order_status < 1)
			{
				$this->order_status = 1;
			}
			$this->pay_time = W_START_TIME;
			$this->update();
			return true;
		}
		else 
		{
			log_message(var_export($orderQueryResult, true));
		}	
		return false;
    }
    
    /**
     * 是否核销
     */
    public function is_check()
    {
    	if($this->order_status == 1)
    	{
    		return '是';
    	}
    	if($this->order_status == 0 && $this->pay_status == 1)
    	{
    		return '否';
    	}
    }
}