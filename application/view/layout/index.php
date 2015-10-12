<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="apple-mobile-web-app-status-bar-style" content="black">
	<meta name="format-detection" content="telephone=no">
	<meta http-equiv="Cache-Control" content="no-cache">
	<meta http-equiv="Pragma" content="no-cache">
	<title><?php echo \Core\View::$title?></title>
	<meta name="description" content="">
	<meta name="keywords" content="">
	<script type="text/javascript" src="/js/require.js"></script>
	<script type="text/javascript" src="/js/prefixfree.js"></script>
	<link href="/css/base.css" rel="stylesheet">
	<link rel="stylesheet" href="/css/style.css">
	<script>
		requirejs.config({
			appDir: '/',
		    baseUrl: "/js",	//如果是pc版本请替换mobile为web
		    urlArgs: "ver=" + (new Date().getTime()),		//若正式环境请删除该行
		    paths: {
		    	'jquery': 'http://upcdn.b0.upaiyun.com/libs/jquery/jquery-1.10.2.min',
		    	'cute': 'cute',
		    	'template': 'core/template',
		    	'form': 'core/form',
		    	'dialog': 'ui/dialog',
		    	'select': 'ui/select',
		    	'tabs': 'ui/tabs',
		    	'iscroll': 'plugin/iscroll',
		    	'datepicker': 'plugin/datepicker/datepicker',
		        'swiper': 'plugin/swiper/swiper.jquery.min'
		    },
		    map:{
		    	'*': {
		    		'css': 'core/css'
		    	}
		    },
		    skipDataMain: true,
		    waitSeconds: 15,
		    shim: {
		    	'cute': ['jquery'],
		    	'common': {
		    		deps: ['cute']
		    	},
		    	'datepicker': {
		    		deps: [
		    		'jquery',
		    		'iscroll',
		    		'css!plugin/datepicker/css.css',
		    		]
		    	},
		    	'swiper': {
		    		deps: [
		    		'jquery',
		    		'css!plugin/swiper/swiper.css',
		    		]
		    	}
		    },
		    deps: ['init'],
		    callback: function(){
		    	TKJ.config = $.extend(TKJ.config,{
		    		SITEURL: "http://wx.zhonghuilv.com",
		    		SITENAME: "中惠旅",
		    		COOKIEPRE: "zhl_",
		    		UPLOAD: "/upload"
		    	});
		    	Cute.Class.namespace("TKJ.user");
		    	TKJ.user.info = {
		    		user_id: parseInt("123") || 0,
		    		nickname: '特伦C',
		    		face_url: '/upload/user_face/xxx.jpg'
		    	};
		    }
		});
	</script>
</head>
<body>
<?php if(!empty($this->content)):?>
<?php echo $this->content?>
<?php endif;?>
</body>
</html>