<?php
namespace Controller;
/**
 * 首页列表页面
 * Enter description here ...
 * @author Yuwenc
 *
 */
class Main extends \Model\Authorize\Oauth
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
		$this->view->content = view('main/index.php');
	}
	
	public function min_index()
	{
		$this->view->content = view('main/min_index.php');
		$this->view->content->rows = \DB\Mall\Goods::fetch(array('goods_status'=>1, 'is_recommend'=>1), null, NULL, array('goods_order'=>'desc'));
	}
	
	public function tab1()
	{
		$this->view->content = view('main/tab1.php');
		$this->view->content->count = \Db\Trade\Cart::count_cart($this->user->user_id);
	}
	
	public function tab1_part()
	{
		$limit = 5;
        $page = \Core\URI::kv('page', 1);
        $start = ($page -1)* $limit;
        
        
        $rows = \DB\Mall\Goods::fetch(array('goods_status'=>1, 'category_id'=>1), $limit, $start, array('goods_order'=>'desc'));
        
        $v = new \Model\Validation();
        if(!empty($rows))
        {
        	$view= view('main/tab1_part.php');
        	$view->rows = $rows;
        	$view->user = $this->user;
        	$rs = $view->__toString();
            $v->set_data($rs);
        }
        else
        {
            $v->required(false)->message('没有更多了...');
        }
        $v->send();
	}
	
	public function tab2()
	{
		$this->view->content = view('main/tab2.php');
		$this->view->content->count = \Db\Trade\Cart::count_cart($this->user->user_id);
	}
	
	public function tab2_part()
	{
		$limit = 5;
        $page = \Core\URI::kv('page', 1);
        $start = ($page -1)* $limit;
        
        
        $rows = \DB\Mall\Goods::fetch(array('goods_status'=>1, 'category_id'=>2), $limit, $start, array('goods_order'=>'desc'));
        
        $v = new \Model\Validation();
        if(!empty($rows))
        {
        	$view= view('main/tab2_part.php');
        	$view->rows = $rows;
        	$view->user = $this->user;
        	$rs = $view->__toString();
            $v->set_data($rs);
        }
        else
        {
            $v->required(false)->message('没有更多了...');
        }
        $v->send();
	}
	
	public function tab3()
	{
		$this->view->content = view('main/tab3.php');
		$this->view->content->count = \Db\Trade\Cart::count_cart($this->user->user_id);
	}
	
	public function tab3_part()
	{
		$limit = 5;
        $page = \Core\URI::kv('page', 1);
        $start = ($page -1)* $limit;
        
        
        $rows = \DB\Mall\Goods::fetch(array('goods_status'=>1, 'category_id'=>3), $limit, $start, array('goods_order'=>'desc'));
        
        $v = new \Model\Validation();
        if(!empty($rows))
        {
        	$view= view('main/tab3_part.php');
        	$view->rows = $rows;
        	$view->user = $this->user;
        	$rs = $view->__toString();
            $v->set_data($rs);
        }
        else
        {
            $v->required(false)->message('没有更多了...');
        }
        $v->send();
	}
	
	
	public function get()
	{
		$this->view->content = view('main/get.php');
		$id = \Core\URI::kv('id');
		$this->view->content->row = new \DB\Mall\Goods($id);
		$this->view->content->user_id = $this->user->user_id;
		$this->view->content->count = \Db\Trade\Cart::count_cart($this->user->user_id);

	}
}