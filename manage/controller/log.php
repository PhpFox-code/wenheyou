<?php
namespace Controller;

class Log extends \Model\Authorize\Admin
{
    public function initialize()
    {
    	parent::initialize();
    	
        $this->view = view('layouts/main.php');
        
    }
    
    public function index()
    {
        $this->view->content = view('log/index.php');
    }
    
	public function index_part()
	{
	    $limit = 10;
        $page = \Core\URI::kv('page', 1);
        $start = ($page -1)* $limit;
        $rows = \DB\Log::fetch(null, $limit, $start, array('create_time'=> 'desc'));
        $rs = '';
        $v = new \Model\Validation();
        if(!empty($rows))
        {
            foreach ($rows as $row)
            {
                $view= view('log/index_part.php');
                $view->row = $row;
                $rs .= $view->__toString();
            }
            
            $v->set_data($rs);
        }
        else
        {
            $v->required(false)->message('没有更多了...');
        }
        echo json_encode($v->get_error());
        exit();
	}
	
	public function send()
	{
	    echo $this->view;
	}
}