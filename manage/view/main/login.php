<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<meta name="viewport" content="initial-scale=1, width=device-width, maximum-scale=1, minimum-scale=1, user-scalable=no">
		<title>
			登录页面
		</title>
		<link rel="stylesheet" href="/manage/bootstrap/css/bootstrap.css">
		<link rel="stylesheet" href="/manage/bootstrap/css/bootstrap-theme.min.css">
	</head>
	<body>
		<div class="container-fluid" style="padding: 0px 15px; width: 100%; position: absolute; top: 50%; margin-top: -100px;">
			<div class="row" style="background: url(/manage/image/bg_login.gif) center 10px no-repeat;">
				<div class="col-md-6">
					<h1 style="line-height:40px; text-align: right; padding-right: 20px;">
						<b style="color:red;font-size:38px">WENHEYOU&nbsp;</b>后台管理系统
						<br>
						<small>
							<a target="_blank" href="mailto:279537592@qq.com">
								LOOKFEEL
							</a> 为文和友倾情打造&nbsp;
						</small>
					</h1>
				</div>
				<div class="col-md-3">
					<form role="form" style="padding: 20px 0px 0px 10px;" method="post" action="<?php echo \Core\URI::a2p(array('main'=>'login')); ?>">
						<div class="form-group">
							<input type="email" name="user_account" class="form-control" placeholder="Enter email">
						</div>
						<div class="form-group">
							<input type="password" name="user_password" class="form-control"  placeholder="Password">
						</div>
						<button type="submit" class="btn btn-default">
							登录
						</button>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>