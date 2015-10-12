<?php
namespace WX\Platform;
/**
 * 公众号平台通用模块
 * @author EVEN
 *
 */
class Common
{
    public $accesstoken = NULL;
    public $appid = NULL;
    public $appsecret = NULL;
    public $token = NULL;
    
    /**
     * 配置微信接口参数
     * 
     * @param array $config
     * @return \WX\Platform\Common
     */
    public static function init_config_params()
    {
        static $singleton = null;
        if(is_null($singleton))
        {
    	    $config = \Core\Application::config()->weixin;
    	    $model = get_called_class ();
    	    $singleton = new $model($config['appid'], $config['appsecret'], $config['token']);
        }
        return $singleton;
    }
    
    /**
     * 初始化
     */
    public function __construct($appid, $appsecret, $token)
    {
        $this->appsecret = $appsecret;
        $this->appid = $appid;
        $this->token = $token;
    }
    
    /**
     * 摇一摇，周边获取用户信息
     * @param bool $need_poi
     */
    public function shake_info($need_poi = false)
    {
       
        if(empty($_GET['ticket']))
        {
            return false;
        }
        $ticket = $_GET['ticket'];
        $host = "https://api.weixin.qq.com/shakearound/user/getshakeinfo?access_token=%s";
        $url = sprintf($host, $this->get_accesstoken());
        $params = array('ticket'=>$ticket);
        if($need_poi)
        {
            $params['need_poi'] = 1;
        }
	    $info = \Core\Curl::post($url, json_encode($params));
	    return json_decode($info->response , true);
    }
    
    /**
     * 获取token
     */
    public function get_accesstoken($key = 'access_token', $default = null)
    {
    	\Core\Cache::init_config_params();
    	$this->accesstoken = \Core\Cache::get('access_token');
    	if(empty($this->accesstoken))
    	{
	        $host = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=%s&secret=%s";
	        $url = sprintf($host, $this->appid, $this->appsecret);
		    $info = \Core\Curl::get($url);
		    $respone = json_decode($info->response , true);
		    if (isset($respone['access_token']))
		    {
		        $this->accesstoken = $respone;
		    }
		    \Core\Cache::set('access_token', $respone);
    	}
    	
    	if(!isset($this->accesstoken[$key]))
        {
            $this->accesstoken[$key] = $default;
        }
        return $this->accesstoken[$key];
    }
    
    /**
     * 获取关注用户的信息,未关注用户获取不到个人信息
     */
    public function subscribe_user_info($open_id)
    {
        $host = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=%s&openid=%s&lang=zh_CN";
        $url = sprintf ( $host, $this->get_accesstoken(), $open_id);
        $info = \Core\Curl::get($url);
        $response = json_decode ( $info->response, true );
        if (!empty($response ['subscribe'] ))
        {
            return $response;
        }
        return NULL;
    }
}