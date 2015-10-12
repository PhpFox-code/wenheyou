<!DOCTYPE html>
<html>
	<head>
	<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
	<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no">
	<title><?php echo \Core\View::$title; ?></title>
	<link rel="stylesheet" href="/manage/bootstrap/css/bootstrap.css">
	<link rel="stylesheet" href="/manage/bootstrap/css/bootstrap-theme.min.css">
  	<link rel="stylesheet" href="/manage/css/style.css">
	<script type="text/javascript" src="/manage/js/jquery-1.11.min.js"></script>
	<script type="text/javascript" src="/manage/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="/manage/js/jquery.form.js"></script>
	<script type="text/javascript" src="/manage/js/common.js"></script>
	<script type="text/javascript" src="/manage/js/kindeditor.js"></script>
  
	<?php
		echo \Core\View::css();
		echo \Core\View::script();
	?>

</head>
  <body>
    <div class="container" style="padding: 0px 15px; width: 100%;">
      <div class="row">
      <div class="col-md-2" id="nav-panel">
      		<?php $admin = \Model\Authorize\Admin::login_admin();?>
          <div class="manager">
              <div class="media" style="padding:18px 0px 0px 18px;">
                <a class="pull-left" href="<?php echo \Core\URI::a2p(array('account'=>'index'))?>">
                  <img class="img-circle" style="padding:2px; border:2px solid #ddd" width="64" height="64" alt="64x64" src=<?php echo !empty($admin->admin_avatar) ? $admin->admin_avatar : "/m/image/avatar.jpg"; ?>>
                </a>
                <div class="media-body">
                     <h4 class="media-heading"><?php echo $admin->admin_name ?></h4>
                	  欢迎您的到来 <br>
                	 <a href='/manage/main/out'>退出</a>
                </div>
              </div>

          </div>
          <ul id="nav" class="list-group">
			<?php $menu = \Core\Application::config()-> menu;
			echo \Model\Framework::get_menu($menu);
			?>
          </ul>
          <div>

          </div>  
      </div>

      <div class="col-md-10 col-md-offset-2">
      	 <div class="col-md-10 col-md-offset-2 content-title navbar-fixed-top">
            <div class="pull-left">
            <?php echo \Model\Framework::get_active_item($menu)?>
            </div>
        </div>
        <div class="content-body">
          	<div id="message" class="alert alert-warning alert-dismissible" role="alert" style="margin-bottom:10px; display: none;"></div>
	        <?php
				if (!empty($this->nav)) {echo $this->nav;}
			?>
	        <?php
				if (!empty($this->content)) {echo $this->content;}
			?>
		</div>
      </div>
	</div>
    </div>
  </body>
</html>