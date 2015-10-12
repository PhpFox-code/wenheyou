<?php
namespace Controller;
/**
 * 交易中心
 * Enter description here ...
 * @author Yuwenc
 *
 */
class Trade extends \Core\Controller
{
	public function initialize()
    {
    	parent::initialize();
    	$this->view = view('layout/index.php');
    	\Core\View::$title = '文和友老长沙外卖';
    }
    
    public function send()
    {
    	echo $this->view;
    }
    
    public function index()
    {
    	//\Core\View::$title = '我的订单';
        $this->user = \Model\Authorize\Oauth::login_user();
        if(empty($this->user))
        {
        	redirect(\Core\URI::a2p(array('main'=>'home')));
        }
    	$this->view->content = view('trade/index.php');
    	$this->view->content->address = \DB\Account\Address::fetch(array('user_id'=>$this->user->user_id));
    	
    	$goods_id = \Core\URI::kv('id');
    	$nums = \Core\URI::kv('nums');
    	$nums = abs(intval($nums));
    	if(!empty($goods_id))
    	{
    		$goods = \DB\Mall\Goods::row(array('goods_id'=>$goods_id));
    		
    	    if(empty($goods) || $nums < 1)
	    	{
	        	redirect(\Core\URI::a2p(array('main'=>'index')));
	    	}
	    	else
	    	{
	    		$this->view->content->count = array(
		            'total_fee' => $goods->goods_discount_price * $nums,
		        	'total_nums' => $nums,
		        );
	    	}
    	}
    	else
    	{
    		$this->view->content->count = \Db\Trade\Cart::count_cart($this->user->user_id);
    		if($this->view->content->count['total_nums'] < 1)
    		{
    		    redirect(\Core\URI::a2p(array('main'=>'index')));
    		}
    	}
    }
        
    /**
     * 提交订单
     */
    public function confirm()
    {
    	//\Core\View::$title = '确认订单';
        $this->user = \Model\Authorize\Oauth::login_user();
        $v = new \Model\Validation();
        $v->required($this->user)->message('用户未登录', 1000);
        if(!$v->has_error())
        {
	    	$address_id = \Core\URI::kv('address_id');
	    	$pay_type  = \Core\URI::kv('pay_type', 0);
	    	$pick_time  = \Core\URI::kv('pick_time');
	    	$order_remark  = \Core\URI::kv('order_remark');
	    	if(empty($pick_time))
	    	{
	    		$pick_time = W_START_TIME;
	    	}
	    	else
	    	{
	    		$pick_time = strtotime($pick_time);
	    	}
	    	
	    	$goods_id = \Core\URI::kv('id');
	    	$nums = \Core\URI::kv('nums');
	    	$nums = abs(intval($nums));
    		if(!empty($goods_id))
    		{
    			$cart = array();
	    		$goods = \DB\Mall\Goods::row(array('goods_id'=>$goods_id));
	    		$v->required($goods)->message('商品不存在', 1000);
	    		$v->min_val($nums, 1)->message('数量不能小于1', 1000);
	    	    if(!$v->has_error())
	    	    {
	    	    	$row = new \Db\Trade\Cart();
		    		$row->user_id = $this->user->user_id;
		    		$row->goods_id = $goods->goods_id;
		    		$row->goods_nums = $nums;
		    		$row->goods_discount_price = $goods->goods_discount_price;
		    		$row->goods_original_price = $goods->goods_original_price;
		    		$row->cart_status = 1;
		    		$row->create_time = W_START_TIME;
		    		$row->goods = $goods;
		    		$cart[] = $row;
		    		//dump($cart);exit();
	    	    }
    		}
	    	else 
	    	{
	    		$cart = \Db\Trade\Cart::fetch(array('user_id'=>$this->user->user_id, 'cart_status'=>1));
	    		foreach ($cart as $c)
	    		{
	    			$c->goods->load();
	    		}
	    		$v->filter_var(!empty($cart))->message('购物车为空', 1000);
	    	}
	    	
	    	$address = \DB\Account\Address::row(array('user_id'=>$this->user->user_id, 'address_id'=>$address_id));
	    	$v->filter_var(!empty($address))->message('配送地址不存在', 1000);
	    	if(!$v->has_error())
	    	{
	    		$order = new \Db\Trade\Order();
	    		$order_id = $order->create_from_cart(
	    			$cart, 
	    			$pay_type, 
	    			$pick_time, 
	    			$address->user_name, 
	    			$address->user_mobile, 
	    			$address->address_province, 
	    			$address->address_city, 
	    			$address->address_area, 
	    			$address->address_street,
	    			$order_remark
	    		);
	    		$v->set_data($order_id);
	    	}
        }
        $v->send();
    }
    
    /**
     * 快速购买
     */
    /*
    public function confirm_nocart()
    {
    	$goods_id = \Core\URI::kv('id');
    	$nums = \Core\URI::kv('nums');
    	$nums = abs(intval($nums));
    	$goods = \DB\Mall\Goods::row(array('goods_id'=>$goods_id));
    	$v = new \Model\Validation();
    	$v->required($goods)->message('商品不存在', 10000);
    	$v->min_val($nums, 1)->message('数量不能小于1', 1000);
    	$v->max_val($nums, 10)->message('数量不能大于10', 1000);
    	$this->user = \Model\Authorize\Oauth::login_user();
    	$v->required($this->user)->message('用户未登录', 1000);
    	if(!$v->has_error())
    	{
    		$address_id = \Core\URI::kv('address_id');
	    	$pay_type  = \Core\URI::kv('pay_type', 0);
	    	$pick_time  = \Core\URI::kv('pick_time');
	    	$order_remark  = \Core\URI::kv('order_remark');
	    	if(empty($pick_time))
	    	{
	    		$pick_time = W_START_TIME;
	    	}
	    	else
	    	{
	    		$pick_time = strtotime($pick_time);
	    	}
	    	
    		$cart = new \Db\Trade\Cart();
    		$cart->user_id = $this->user->user_id;
    		$cart->goods_id = $goods->goods_id;
    		$cart->goods_nums = $nums;
    		$cart->goods_discount_price = $goods->goods_discount_price;
    		$cart->goods_original_price = $goods->goods_original_price;
    		$cart->cart_status = 1;
    		$cart->create_time = W_START_TIME;
	    	$address = \DB\Account\Address::row(array('user_id'=>$this->user->user_id, 'address_id'=>$address_id));
	    	$v->filter_var(!empty($address))->message('配送地址不存在', 1000);
	    	if(!$v->has_error())
	    	{
	    		$order = new \Db\Trade\Order();
	    		$order_id = $order->create_from_cart(
	    			$cart, 
	    			$pay_type, 
	    			$pick_time, 
	    			$address->user_name, 
	    			$address->user_mobile, 
	    			$address->address_province, 
	    			$address->address_city, 
	    			$address->address_area, 
	    			$address->address_street,
	    			$order_remark
	    		);
	    		$v->set_data($order_id);
	    	}
    	}
    	$v->send();
    }
    */
    
    /**
     * 订单详情
     */
    public function order()
    {
    	require_once W_LIBRARY_PATH . '/wx/pay/WxPayPubHelper/WxPayPubHelper.php';
	    //\Core\View::$title = '订单详情';
	    
	    $id = \Core\URI::kv('id');
		$row = \Db\Trade\Order::row(array('order_id'=>$id));
		$v = new \Model\Validation();
		$v->required($row)->message('订单不存在');
		//var_dump($row);exit();
	    if($v->has_error())
        {
            redirect(\Core\URI::a2p(array('main'=>'tab2')));
        }
        
        
        $this->view->content = view('trade/order.php');
        $this->view->content->row = $row;
        
        if($row->order_status == 0 && $row->pay_type == 0)
        {
            //使用jsapi接口
            $jsApi = new \JsApi_pub();
            //var_dump(isset($_GET['code']));exit();
            //=========步骤1：网页授权获取用户openid============
            //通过code获得openid
            if (!isset($_GET['code']))
            {
            	//触发微信返回code码
            	$url = $jsApi->createOauthUrlForCode(\WxPayConf_pub::JS_API_CALL_URL."?id=$id");
            	Header("Location: $url"); 
            	exit();
            }
            else
            {
            	//获取code码，以获取openid
                $code = $_GET['code'];
            	$jsApi->setCode($code);
            	$openid = $jsApi->getOpenId();
            }
            
            //=========步骤2：使用统一支付接口，获取prepay_id============
            //使用统一支付接口
            $unifiedOrder = new \UnifiedOrder_pub();
            //设置统一支付接口参数
            //设置必填参数
            //appid已填,商户无需重复填写
            //mch_id已填,商户无需重复填写
            //noncestr已填,商户无需重复填写
            //spbill_create_ip已填,商户无需重复填写
            //sign已填,商户无需重复填写
            $unifiedOrder->setParameter("openid","$openid");//商品描述
            $unifiedOrder->setParameter("body","文和友老长沙外卖");//商品描述
            //自定义订单号，此处仅作举例
            $timeStamp = time();
    		//$out_trade_no = \WxPayConf_pub::APPID."$timeStamp";
    		//$unifiedOrder->setParameter("out_trade_no","$out_trade_no");//商户订单号 
    
            $unifiedOrder->setParameter("out_trade_no","$id");//商户订单号 
            $unifiedOrder->setParameter("total_fee",$row->total_amount*100);//总金额
            $unifiedOrder->setParameter("notify_url",\WxPayConf_pub::NOTIFY_URL);//通知地址 
            $unifiedOrder->setParameter("trade_type","JSAPI");//交易类型
            //非必填参数，商户可根据实际情况选填
            //$unifiedOrder->setParameter("sub_mch_id","XXXX");//子商户号  
            //$unifiedOrder->setParameter("device_info","XXXX");//设备号 
            //$unifiedOrder->setParameter("attach","XXXX");//附加数据 
            //$unifiedOrder->setParameter("time_start","XXXX");//交易起始时间
            //$unifiedOrder->setParameter("time_expire","XXXX");//交易结束时间 
            //$unifiedOrder->setParameter("goods_tag","XXXX");//商品标记 
            //$unifiedOrder->setParameter("openid","XXXX");//用户标识
            //$unifiedOrder->setParameter("product_id","XXXX");//商品ID
            
            $prepay_id = $unifiedOrder->getPrepayId();
            //=========步骤3：使用jsapi调起支付============
            $jsApi->setPrepayId($prepay_id);
            
            $jsApiParameters = $jsApi->getParameters();
            $this->view->content->jsApiParameters = $jsApiParameters;
        }
    }
    
    /**
     * 支付完成回调通知
     */
    public function notice()
    {
    	require_once W_LIBRARY_PATH . '/wx/pay/WxPayPubHelper/WxPayPubHelper.php';
        //使用通用通知接口
		$notify = new \Notify_pub();
	
		//存储微信的回调
		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];	
		
		// 记录日志
		log_message($xml);
		
		$notify->saveData($xml);
		
		//验证签名，并回应微信。
		//对后台通知交互时，如果微信收到商户的应答不是成功或超时，微信认为通知失败，
		//微信会通过一定的策略（如30分钟共8次）定期重新发起通知，
		//尽可能提高通知的成功率，但微信不保证通知最终能成功。
		if($notify->checkSign() == FALSE){
			$notify->setReturnParameter("return_code","FAIL");//返回状态码
			$notify->setReturnParameter("return_msg","签名失败");//返回信息
		}else{
			$notify->setReturnParameter("return_code","SUCCESS");//设置返回码
		}
		$returnXml = $notify->returnXml();
		echo $returnXml;
		
		//以log文件形式记录回调信息
	
		if($notify->checkSign() == TRUE)
		{
			if ($notify->data["return_code"] == "FAIL") {
				//此处应该更新一下订单状态，商户自行增删操作
				log_message("【通信出错】:\n".$xml."\n");
			}
			elseif($notify->data["result_code"] == "FAIL"){
				//此处应该更新一下订单状态，商户自行增删操作
				log_message("【业务出错】:\n".$xml."\n");
			}
			else
			{
				//此处应该更新一下订单状态，商户自行增删操作
				log_message("【支付成功】:\n".$xml."\n");
				
				$row = \Db\Trade\Order::row(array('order_id'=>$notify->data['out_trade_no'], 'pay_status'=>0));
				if(!empty($row))
				{
					$row->mch_id = $notify->data['mch_id'];
					$row->trade_type = $notify->data['trade_type'];
					$row->transaction_id = $notify->data['transaction_id'];
					$row->bank_type = $notify->data['bank_type'];
					$row->mch_id = $notify->data['mch_id'];
					$row->pay_status = 1;
					$row->order_status = 1;
					$row->fee_type = $notify->data['fee_type'];
					$row->pay_time = W_START_TIME;
					$row->update();
				}
			}
		}
    }
    
    public function success()
    {
        echo view('trade/success.php');
        exit();
    }
}