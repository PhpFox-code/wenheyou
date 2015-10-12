<?php
/**
 * 视图目录
 */
$config['view_dir'] = W_APPLICATION_PATH . '/view';


/**
 * 图片资源目录
 */
$config['upload_dir'] = realpath(W_APPLICATION_PATH . '/../public/upload');

/**
 * 图片资源url
 */
$config['upload_url'] = '/upload';

/**
 * 配置日志的存储绝对路径
 */
$config['log_dir'] = W_APPLICATION_PATH . '/storage/log';

/**
 * 缓存
 */
$config['cache'] = array (
	'cache_dir' =>  realpath(W_APPLICATION_PATH . '/storage/cache'), 
	'expires' => 6500, 
);

/**
 * 开启错误
 */
$config['open_error_log'] = true;

/**
 * 数据库连接
 */
$config['database']['master'] = array (
	'db_target' => 'mysql:host=55fe33341493b.sh.cdb.myqcloud.com;port=11684;dbname=wenheyou', 
	'user_name' => 'cdb_outerroot', 
	'password'  => '(**)!@#84224353', 
	'params'    => array ( PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8" ) 
);

/**
 * cookie的配置
 */
$config['cookie'] = array(
	'expire'  => null,
	'path'     => '/',
	'domain'   => '',
	'secure'   => false,
	'httponly' => true,
);

/**
 * cookie的配置
 */
$config['session'] = array(
	'expire'  => null,
	'path'     => '/',
	'domain'   => '',
	'secure'   => false,
	'httponly' => true,
);

/**
 * 老长沙服务号
 * @var unknown_type
 */
$config['weixin'] = array(
    // 公司企业号ID
    'appid'=>'wxc4ba426153bfe4f1',
    // 管理组凭证密钥
    'appsecret'=>'bc1ca1db9fcead9d3556b8facaa7788a',
    // 连接验证的token
    'token'=>'9375a8ca9094bffad9b23371e1cbdd7e',
);

/**
 * 配置菜单
 */
$config['menu'] = array(
	array('link'=>'/manage/goods/index', 'name'=>'商品管理', 'ico'=>'glyphicon-send', 'badge'=>'', 'is_active' => false),
    array('link'=>'/manage/order/index/status/pay', 'name'=>'订单管理', 'ico'=>'glyphicon-shopping-cart', 'badge'=>'', 'is_active' => false),
    array('link'=>'/manage/user/index', 'name'=>'用户中心', 'ico'=>'glyphicon-user', 'badge'=>'', 'is_active' => false),
	array('link'=>'/manage/admin/index', 'name'=>'角色分配', 'ico'=>'glyphicon-cog', 'badge'=>'', 'is_active' => false),
	array('link'=>'/manage/log/index', 'name'=>'操作日志', 'ico'=>'glyphicon-eye-open', 'badge'=>'', 'is_active' => false),
	array('link'=>'/manage/slide/index', 'name'=>'封面管理', 'ico'=>'glyphicon-picture', 'badge'=>'', 'is_active' => false),
);

/**
 * 路由白名单设置
 */
$config['route_maps'] = array(
	'(:let)/(:let)/(:any)'  => '/Controller/${1}::${2}/${3}',
	'(:let)/(:any)'         => '/Controller/${1}::${2}',
	'(:any)'                => '/Controller/Main::index',   //默认的控制器
);