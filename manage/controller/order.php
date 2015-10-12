<?php
namespace Controller;
/**
 * 订单管理
 * @author EVEN
 *
 */
class Order extends \Model\Authorize\Admin
{
    public function initialize()
    {
    	parent::initialize();
    	
        $this->view = view('layouts/main.php');
        $this->view->nav = view('order/nav.php');
    }
    
    public function index()
    {
    	\Core\View::css('/manage/daterange/font-awesome.min.css');
    	\Core\View::css('/manage/daterange/daterangepicker-bs3.css');
    	\Core\View::script('/manage/daterange/moment.js');
    	\Core\View::script('/manage/daterange/daterangepicker.js');
    	
    	\Core\View::css('/manage/tablescroll/css/style.css');
    	\Core\View::script('/manage/tablescroll/js/jquery.tablescroll.js');
		
        $active = \Core\URI::kv('active', 'queue');
        if($active == 'wait_confirm')
        {
            $where = array('order_status'=>0);
        }
        if($active == 'queue')
        {
            $where = array('order_status'=>1);
        }
        if($active == 'check')
        {
            $where = array('order_status'=>2);
        }
    	if($active == 'release')
        {
            $where = array('order_status'=>3);
        }
    	if($active == 'success')
        {
            $where = array('order_status'=>4);
        }
        if($active == 'wait_refund')
        {
            $where = array('order_status'=>5, 'pay_status'=>1, 'refund_status'=>1);
        }
        if($active == 'refund')
        {
            $where = array('order_status'=>5, 'pay_status'=>1, 'refund_status'=>2);
        }
        if($active == 'destory')
        {
            $where = array('order_status'=>5);
        }
        $this->view->content = view('order/index.php');
        
        $reservation = urldecode(\Core\URI::kv('reservation'));
        
        if(!empty($reservation))
        {
        	$range = explode(' - ', $reservation);
        	$time_start = strtotime($range[0]);
        	$time_end = strtotime('+1 day', strtotime($range[1]));
        	$where[] = "create_time >= $time_start";
        	$where[] = "create_time <= $time_end";
        }
        
        $page = \Core\URI::kv('page', 1);
        $limit = 30;
        $offset = ($page -1)*$limit;
        $this->view->content->rows = \DB\Trade\Order::fetch($where, $limit, $offset, array('hurry_time'=>'desc','create_time'=>'desc'));
        $this->view->content->page = new \Model\Page($page, \DB\Trade\Order::count($where), $limit);
    }
    
    /**
     * 订单 详情
     */
    public function detail()
    {
        \Core\View::css('/manage/datetimepicker/css/bootstrap-datetimepicker.min.css');
        \Core\View::script('/manage/datetimepicker/js/bootstrap-datetimepicker.js');
        \Core\View::script('/manage/datetimepicker/js/locales/bootstrap-datetimepicker.zh-CN.js');
        
        $this->view->content = view('order/detail.php');
        $order_id = \Core\URI::kv('order_id');
        $v = new \Core\Validation();
        $v->required($order_id)->message('参数错误');
        if($v->has_error())
        {
            \Core\Cookie::set('message', $v->get_error('message'));
            redirect(\Core\URI::a2p(array('order'=>'index')));
        }
        $this->view->content->row = new \Db\Trade\Order($order_id);
    }
    
    
    /**
     * 搜索用户考勤
     */
    public function search()
    {
    	\Core\View::css('/manage/daterange/font-awesome.min.css');
    	\Core\View::css('/manage/daterange/daterangepicker-bs3.css');
    	\Core\View::script('/manage/daterange/moment.js');
    	\Core\View::script('/manage/daterange/daterangepicker.js');
    	
    	\Core\View::css('/manage/tablescroll/css/style.css');
    	\Core\View::script('/manage/tablescroll/js/jquery.tablescroll.js');
    	
        $order_id = \Core\URI::kv('order_id');
        $page = \Core\URI::kv('page', 1);

        $this->view->content = view('order/index.php');
        $limit = 12;
        $offset = ($page -1)*$limit;
        
        $where = array("order_id like '$order_id%' or user_mobile like '$order_id%'");
        $this->view->content->rows = \Db\Trade\Order::fetch($where, $limit, $offset, array('hurry_time'=>'desc', 'create_time'=>'desc'));
        $this->view->content->page = new \Model\Page($page, \DB\Trade\Order::count($where), $limit);
        $this->view->content->order_id = $order_id;

    }
    
    /**
     * 确认订单
     */
    public function confirm()
    {
    	$v = new \Model\Validation();
    	$order_id = \Core\URI::kv('id');
    	$order = \Db\Trade\Order::row(array('order_id'=>$order_id));
    	$v->required($order)->message('订单不存在', 1000);
    	if(!$v->has_error())
    	{
    		if($order->order_status == 1)
    		{
    			$order->order_status = 2;
    			$order->confirm_time = W_START_TIME;
    			$order->update();
    		}
    		else 
    		{
    			$v->required(false)->message('当前状态无法确认订单', 1000);
    		}
    	}
    	$v->send();
    }
    
    /**
     * 订单发货
     */
    public function release()
    {
    	$v = new \Model\Validation();
    	$order_id = \Core\URI::kv('id');
    	$order = \Db\Trade\Order::row(array('order_id'=>$order_id));
    	$v->required($order)->message('订单不存在', 1000);
    	if(!$v->has_error())
    	{
    		if($order->order_status == 2)
    		{
    			$order->order_status = 3;
    			$order->release_time = W_START_TIME;
    			$order->update();
    		}
    		else 
    		{
    			$v->required(false)->message('当前状态无法发货', 1000);
    		}
    	}
    	$v->send();
    }
    
    /**
     * 订单发货
     */
    public function success()
    {
    	$v = new \Model\Validation();
    	$order_id = \Core\URI::kv('id');
    	$order = \Db\Trade\Order::row(array('order_id'=>$order_id));
    	$v->required($order)->message('订单不存在', 1000);
    	if(!$v->has_error())
    	{
    		if($order->order_status == 3)
    		{
    			$order->order_status = 4;
    			$order->success_time = W_START_TIME;
    			$order->update();
    		}
    		else 
    		{
    			$v->required(false)->message('当前状态无法发货', 1000);
    		}
    	}
    	$v->send();
    }
    
    /**
     * 订单退款
     */
    public function refund()
    {
    	$v = new \Model\Validation();
    	$order_id = \Core\URI::kv('id');
    	$order = \Db\Trade\Order::row(array('order_id'=>$order_id));
    	$v->required($order)->message('订单不存在', 1000);
    	if(!$v->has_error())
    	{
    		if($order->order_status == 5 && $order->refund_status == 1)
    		{
    			$order->refund_status = 2;
    			$order->refund_check_time = W_START_TIME;
    			$order->update();
    		}
    		else 
    		{
    			$v->required(false)->message('当前状态无法退款', 1000);
    		}
    	}
    	$v->send();
    }
    
    /**
     * 订单作废
     */
    public function destory()
    {
    	$v = new \Model\Validation();
    	$order_id = \Core\URI::kv('id');
    	$order = \Db\Trade\Order::row(array('order_id'=>$order_id));
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
    		}
    		else 
    		{
    			$v->required(false)->message('当前状态无法作废订单', 1000);
    		}
    	}
    	$v->send();
    }
    
    public function get()
    {
    	$v = new \Model\Validation();
    	$order_id = \Core\URI::kv('id');
    	$order = \Db\Trade\Order::row(array('order_id'=>$order_id));
    	$v->required($order)->message('订单不存在', 1000);
    	if(!$v->has_error())
    	{
    		$view = view('order/get.php');
    		$view->rows = unserialize($order->cart_text);
    		//var_dump($view->rows);exit();
    		$v->set_data($view->__toString());
    	}
    	$v->send();
    }
    
    public function send()
    {
        echo $this->view;
    }
}