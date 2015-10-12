<?php
namespace Controller;

class User extends \Model\Authorize\Admin
{
    public function initialize()
    {
    	parent::initialize();
    	
        $this->view = view('layouts/main.php');
        
    }
    
    public function index()
    {
    	\Core\View::css('/manage/tablescroll/css/style.css');
    	\Core\View::script('/manage/tablescroll/js/jquery.tablescroll.js');
    	
        $status = \Core\URI::kv('status', 'nomal');
    	$where = NULL;
        if($status == 'destory')
        {
            $where = array('user_status'=>0);
        }
        if($status == 'nomal')
        {
            $where = array('user_status'=>1);
        }
        
        $page = \Core\URI::kv('page', 1);
        $limit = 50;
        $offset = ($page -1)*$limit;
        $this->view->content = view('user/index.php');
        $this->view->content->rows = \DB\Account\User::fetch($where, $limit, $offset, array('create_time'=>'desc'));
        $this->view->content->page = new \Model\Page($page, \DB\Account\User::count($where), $limit);
    }
    
	public function search()
	{
		\Core\View::css('/manage/tablescroll/css/style.css');
    	\Core\View::script('/manage/tablescroll/js/jquery.tablescroll.js');
    	
		$user_nickname = \Core\URI::kv('user_nickname');
		$page = \Core\URI::kv('page', 1);
        $limit = 50;
        $offset = ($page -1)*$limit;
		$where = array("user_nickname like '$user_nickname%'");

		$this->view->content = view('user/index.php');
        $this->view->content->rows = \DB\Account\User::fetch($where, $limit, $offset, array('create_time'=>'desc'));
        $this->view->content->page = new \Model\Page($page, \DB\Account\User::count($where), $limit);

	}
	

	
	public function get()
	{
	    $id = \Core\URI::kv('id');
	    $user = \DB\Account\User::row(array('user_id'=>$id));
	    if($user)
	    {
	        $this->view->content = view('user/get.php');
	        $this->view->content->row = $user;
	        
	    }
	    else
	    {
	        redirect(\Core\URI::a2p(array('user'=>'index')));
	    }
	}
	
	/**
	 * 积分流水
	 */
	public function record()
	{
        \Core\View::css('/manage/tablescroll/css/style.css');
        \Core\View::script('/manage/tablescroll/js/jquery.tablescroll.js');
	    $user_id = \Core\URI::kv('user_id');
	    $user = \DB\Account\User::row(array('user_id'=>$user_id));
		if($user)
	    {
	        $this->view->content = view('user/record.php');
	    }
	    else
	    {
	        redirect(\Core\URI::a2p(array('user'=>'index')));
	    }
	}
	
	public function record_part()
	{
	    $limit = 10;
        $page = \Core\URI::kv('page', 1);
        $offset = ($page -1)*$limit;
        
        $user_id = \Core\URI::kv('user_id');
	    $user = \DB\Account\User::row(array('user_id'=>$user_id));
	    
        $rows = \Db\Trade\Order::fetch(array('user_id'=>$user->user_id), $limit, $offset, array('create_time'=>'desc'));
        
        $rs = '';
        $v = new \Model\Validation();
        if(!empty($rows))
        {
            $view= view('user/record_part.php');
            $view->rows = $rows;
            $rs .= $view->__toString();
            
            $v->set_data($rs);
        }
        else
        {
            $v->required(false)->message('没有更多了...');
        }
        echo json_encode($v->get_error());
        exit();
	}
    
    /**
     * 更改用户状态
     */
    public function status()
    {
        $ids = \Core\URI::kv('ids');   
		$status = \Core\URI::kv('status', 0);   
        $v = new \Core\Validation();
        $v->required($ids)->message('参数不合法');
        if (!$v->has_error())
        {
            $id_arr = explode('-', $ids);
			foreach($id_arr as $id)
			{
				$item = \DB\Account\User::row(array('user_id'=>$id));
	            if(!empty($item))
	            {
	                $item->user_status = $status;
	                $item->update();
	            }
			}
        }
        echo json_encode($v->get_error());exit();
    }
    
    public function send()
    {
        echo $this->view;
    }
}