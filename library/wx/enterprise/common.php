<?php
namespace WX\Enterprise;

/**
 * 加载微信对称加密
 */
require_once W_LIBRARY_PATH .'/wx/enterprise/sdk/php/WXBizMsgCrypt.php';

/**
 * 通用基础类
 * @author chenyuwen
 *
 */
class Common
{    
    /**
     * 公司企业号ID
     * @var string
     */
    protected $corpid = null;
    
    /**
     * 管理组凭证密钥
     * @var string
     */
    protected $corpsecret = null;
        
    /**
     * 应用ID
     * @var int
     */
    public $corpagentid = null;
    
    /**
     * 对称加密
     * @var int
     */
    public $encodingaeskey = null;
    
    /**
     * 绑定服务端连接验证的密钥
     * @var string
     */
    protected $token = '';
    
    /**
     * 授权的密钥
     * @var array
     */
    protected $enterprise_accesstoken = null;
    
    /**
     * 接收到的消息
     * @var mix
     */
    protected $receive;
    
    /**
     * 是否开启日志
     * @var string
     */
    protected $open_log = false;
    
    /**
     * 初始化
     * @param int $corp_agent_id
     * @param string $corp_id
     * @param string $corp_secret
     * @param string $token
     * @param string $open_log
     */
    public function __construct()
    {
        $config = \Core\Application::config()->enterprise;
        $this->corpid             = $config['corpid'];
        $this->corpsecret         = $config['corpsecret'];
        $this->corpagentid        = $config['corpagentid'];
        $this->token              = $config['token'];
        $this->encodingaeskey     = $config['encodingaeskey'];
        $this->open_log           = $config['open_log'];
    }
    
    /**
     * xml转数组
     * @param string $xml
     */
    public function xml2arr($xml)
    {
        return json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
    
    /**
     * 获取微信事件触发请求的数据入口
     */
    public function entrance()
    {
        $post_str = $GLOBALS["HTTP_RAW_POST_DATA"];
        
        if (!empty($post_str))
        {
            $this->receive = $this->xml2arr($post_str);
            
            if ($this->open_log)
            {
                log_message(var_export($this->receive, true));
            }
            
            return true;
        }
        return false;
    }
    
	/**
	 * 获取消息消息
	 */
	public function get_receive()
	{
	    return $this->receive;
	}
    
    /**
     * 微信开发者模式验证的签名
     * @param $token string
     */
    public function check_signature()
	{
        $msg_signature = urldecode(\Core\URI::kv('msg_signature', ''));
        $timestamp = urldecode(\Core\URI::kv('timestamp', ''));
        $nonce = urldecode(\Core\URI::kv('nonce', ''));
        $echostr = urldecode(\Core\URI::kv('echostr', ''));
        $decode_echostr = '';
        
        $wxcpt = new \WXBizMsgCrypt($this->token, $this->encodingaeskey, $this->corpid);   
        //进行地址解析 
        $errcode = $wxcpt->VerifyURL($msg_signature, $timestamp, $nonce, $echostr, $decode_echostr);
        if($errcode == 0)
        {
            return $decode_echostr;
        }
        return false;
	}
    
    /**
     * 获取企业号应用信息
     */
    public function get_agentid()
    {
        $host = 'https://qyapi.weixin.qq.com/cgi-bin/agent/get?access_token=%s&agentid=%s';
        $url = sprintf($host, $this->get_accesstoken(), $this->corpagentid);
	    $info = \Core\Curl::get($url);
	    $response = json_decode($info->response, true);
	    if ($response['errcode'] == 0)
        {
            return $response;
        }
        return false;
    }
    
    /**
     * 请求token
     */
    public function get_accesstoken($key = 'access_token', $default = null)
    {
    	\Core\Cache::init_config_params();
    	$this->enterprise_accesstoken = \Core\Cache::get('enterprise_accesstoken');
    	if(empty($this->enterprise_accesstoken))
    	{
	        $host = 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?corpid=%s&corpsecret=%s';
	        $url = sprintf($host, $this->corpid, $this->corpsecret);
		    $info = \Core\Curl::get($url);
		    $respone = json_decode($info->response , true);
		    if (isset($respone['access_token']))
		    {
		        $this->enterprise_accesstoken = $respone;
		    }
		    \Core\Cache::set('enterprise_accesstoken', $respone);
    	}
	    if(!isset($this->accesstoken[$key]))
        {
            $this->accesstoken[$key] = $default;
        }
        return $this->accesstoken[$key];
    }
}