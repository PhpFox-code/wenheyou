<?php
namespace Controller;

class Active extends \Model\Authorize\Oauth
{
	public function initialize()
	{
		parent::initialize();
		$this->view = view('layout/index.php');
        $this->user = \Model\Authorize\Oauth::login_user();
	}
	
	public function send()
	{
		echo $this->view;
	}
	
	public function index()
	{
		$this->view->content = view('active/index.php');
	}
}