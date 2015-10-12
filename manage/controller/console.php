<?php
namespace Controller;

class Console extends \Model\Authorize\Admin
{
    public function initialize()
    {
        parent::initialize();
        $this->view = view('layouts/main.php');
    }
    
    public function index()
    {
        $this->view->content = view('console/index.php');
        echo $this->view;
    }
}