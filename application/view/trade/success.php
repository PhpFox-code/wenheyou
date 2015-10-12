<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<meta name="viewport" content="width=device-width, initial-scale=1" />
<meta name="apple-mobile-web-app-capable" content="yes">
<meta name="apple-mobile-web-app-status-bar-style" content="black">
<meta name="format-detection" content="telephone=no">
<meta http-equiv="Cache-Control" content="no-cache">
<meta http-equiv="Pragma" content="no-cache">
<title>下单成功</title>
<meta name="description" content="">
<meta name="keywords" content="">
<link href="/css/base.css" rel="stylesheet">
<link rel="stylesheet" href="/css/style.css">
</head>
<body>
	<div class="success">
		<div class="success_main">
			<div class="success_content">
				<div><i></i></div>
				<h3>订单提交成功</h3>
				<p>我们将在5分钟内为您确认订单</p>
				<p>请密切光柱订单状态</p>
			</div>
			<div class="button_n">
		    	<a href="<?php echo \Core\URI::a2p(array('account'=>'order_list'))?>">我的订单</a>
		    </div>
		    <h2><a href="<?php echo \Core\URI::a2p(array('main'=>'tab2'))?>">继续购买</a></h2>
		</div>
	</div>
</body>
</html>