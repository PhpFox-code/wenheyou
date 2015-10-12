<?php
namespace Controller;
/**
 * 个人中心
 * @author Yuwenc
 *
 */
class Account extends \Model\Authorize\Oauth
{
	public function initialize()
    {
    	parent::initialize();
    	$this->view = view('layout/index.php');
        $this->user = \Model\Authorize\Oauth::login_user();
        \Core\View::$title = '文和友老长沙外卖';
    }
    
    public function send()
    {
    	echo $this->view;
    }
    
    public function index()
    {
    	 
        $this->view->content = view('account/index.php');
        $this->view->content->user = $this->user;
        $this->view->content->address = \DB\Account\Address::row(array('user_id'=>$this->user->user_id, 'is_default'=>1));
        $where = array(
    		'user_id'=>$this->user->user_id,
    	    'order_status != 4',
    	    'order_status != 5',
        );
        $this->view->content->order_nums = \Db\Trade\Order::count($where);
    }
    
    
    public function order_list()
    {
    	//\Core\View::$title = '我的订单';
    	$this->view->content = view('account/order_list.php');
    	$where = array(
    		'user_id'=>$this->user->user_id,
    	    'order_status != 4',
    	    'order_status != 5',
        );
    	$this->view->content->rows = \Db\Trade\Order::fetch(array('user_id'=>$this->user->user_id), null, null, array('order_status'=>'asc', 'create_time'=>'desc'));
    }

    /*
    public function order_detail()
    {
    	\Core\View::$title = '订单详情';
    	$order_id = \Core\URI::kv('id');
    	$this->view->content = view('account/order_detail.php');
    	$this->view->content->row = \Db\Trade\Order::row(array('user_id'=>$this->user->user_id, 'order_id'=>$order_id));
    }
    */
    
    /**
     * 取消订单
     */
    public function order_delete()
    {
    	$id = \Core\URI::kv('id');
    	$order = \Db\Trade\Order::row(array('order_id'=>$id, 'user_id'=>$this->user->user_id));
    	$v = new \Model\Validation();
    	$v->required($id)->message('参数错误', 1000);
    	$v->required($order)->message('订单不存在', 1000);
    	if(!$v->has_error())
    	{
    	    if($order->order_status == 1 || $order->order_status == 0)
    		{
    			$order->order_status = 5;
    			$order->destory_time = W_START_TIME;
    			// 如果已经支付，进行退款
    			if($order->pay_status == 1 && $order->pay_type ==0)
    			{
    				$order->refund_status = 1;
    				$order->refund_time = W_START_TIME;
    			}
    			$order->update();
    			$v->set_data(\Core\URI::a2p(array('trade'=>'order', 'id'=>$order->id)));
    		}
    		else 
    		{
    			$v->required(false)->message('订单已处理,不能取消', 1000);
    		}
    	}
    	$v->send();
    }
    
    /**
     * 催单
     */
    public function order_hurry()
    {
        $v = new \Model\Validation();
        $order_id = \Core\URI::kv('id');
        $order = \Db\Trade\Order::row(array('order_id'=>$order_id, 'user_id'=>$this->user->user_id));
        $time_start = \Core\Cookie::get('time_start');
        $v->required($order)->message('订单不存在', 1000);
        if(!$v->has_error())
        {
	        if(empty($time_start))
	        {
	            \Core\Cookie::set('time_start', W_START_TIME);
	            //@todo 更新催单时间
	            $order->hurry_status = 1;
	            $order->hurry_time = W_START_TIME;
	            $order->update();
	            $v->set_data(\Core\URI::a2p(array('trade'=>'order', 'id'=>$order->id)));
	        }
	        else 
	        {
	            if(W_START_TIME - $time_start > 600)
	            {
	                //@todo 更新催单时间
	                $order->hurry_status = 1;
	            	$order->hurry_time = W_START_TIME;
	            	$order->update();
	            	$v->set_data(\Core\URI::a2p(array('trade'=>'order', 'id'=>$order->id)));
	            }
	            $v->required(false)->message('已经收到，正在加急处理', 1000);
	        }
        }
        $v->send();
    }
}