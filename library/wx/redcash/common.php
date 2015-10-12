<?php
namespace Wx\Redcash;
/**
 * 发送红包
 * @author EVEN
 *
 */
class Common
{
    /**
     * 红包发放的参数
     * @var array
     */
    public $params = array(
        'nonce_str'=>'',
        'mch_billno'=>'',
        'mch_id'=>'',
        'wxappid'=>'',
        'nick_name'=>'',
        'send_name'=>'',
        're_openid'=>'',
        'total_amount'=>'',
        'min_value'=>'',
        'max_value'=>'',
        'total_num'=>'',
        'wishing'=>'',
        'client_ip'=>'',
        'act_name'=>'',
        'remark'=>'',
    );
    
    /**
     * 微信公众号配置
     * @var string
     */
    public $appid = NULL;
    
    /**
     * 现金红包的api_key
     * @var string
     */
    public $mchid = NULL;
    public $cert = NULL;
    public $key = NULL;
    public $ca = NULL;
    public $api_key = NULL;
    
    /**
     * 初始化
     */
    public function __construct()
    {
        $config = \Core\Application::config()->redcash;
        
        $this->appid   = $config['appid'];
        $this->cert    = $config['cert'];
        $this->ca      = $config['ca'];
        $this->key     = $config['key'];
        $this->api_key = $config['api_key'];
        $this->mchid   = $config['mchid'];
    }
    
    /**
     * 生成随即字符串
     * @param string $length
     */
	protected function create_noncestr( $length = 32 ) 
	{
		$chars = "abcdefghijklmnopqrstuvwxyz0123456789";  
		$str ="";
		for ( $i = 0; $i < $length; $i++ )  
		{  
			$str.= substr($chars, mt_rand(0, strlen($chars)-1), 1);  
		}  
		return $str;
	}
    
    /**
     * 获取签名
     */
    protected function get_sign()
    {
        ksort ( $this->params );
        $str = urldecode(http_build_query($this->params));
        $str .= "&key=" . $this->api_key; 
        return strtoupper ( md5 ( $str ) );
    }
    
    /**
     * 初始化数据
     * @param string $order_id   $this->mchid.date('YmdHis').rand(1000, 9999);
     * @return \WX\Redcash\Common
     */
    public function init_params($order_id, $send_name, $nick_name, $open_id, $total_amount, $min_value, $max_value, $total_num, $wishing, $action_name, $remark)
    {
        $this->params['nonce_str'] = $this->create_noncestr();
        $this->params['mch_billno'] = $order_id;
        $this->params['mch_id'] = $this->mchid;
        $this->params['wxappid'] = $this->appid;
        $this->params['nick_name'] = $nick_name;
        $this->params['send_name'] = $send_name;
        $this->params['re_openid'] = $open_id;
        $this->params['total_amount'] = $total_amount;
        $this->params['min_value'] = $min_value;
        $this->params['max_value'] = $max_value;
        $this->params['total_num'] = $total_num;
        $this->params['wishing'] = $wishing;
        $this->params['client_ip'] = client_ip();
        $this->params['act_name'] = $action_name;
        $this->params['remark'] = $remark;
        return $this;
    }
	
	/**
	 * 数组转xml
	 * @param array $arr
	 */
    protected function arr2xml($arr)
    {
        $xml = "<xml>";
        foreach ( $arr as $key => $val )
        {
            if (is_numeric ( $val ))
            {
                $xml .= "<" . $key . ">" . $val . "</" . $key . ">";
            }
            else
            {
                $xml .= "<" . $key . "><![CDATA[" . $val . "]]></" . $key . ">";
            }
        }
        $xml .= "</xml>";
        return $xml;
    }
    
    /**
     * xml转数组
     * @param string $xmlstring
     */
    protected function xml2arr($xmlstring) 
    {
        return json_decode(json_encode(simplexml_load_string($xmlstring, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
    }
    
    /**
     * 创建xml数据
     */
    protected function create_xml()
    {
        $this->params['sign'] = $this->get_sign();
        return $this->arr2xml( $this->params );
    }
    
    /**
     * 发送请求
     */
    public function send()
    {
        $host = 'https://api.mch.weixin.qq.com/mmpaymkttransfers/sendredpack';
        $option = array(
           CURLOPT_SSLCERT     =>  $this->cert,
           CURLOPT_SSLKEY      =>  $this->key,
           CURLOPT_CAINFO      =>  $this->ca,
           CURLOPT_HTTPHEADER  =>  array ('Content-Type: text/xml' ),
        );
        $xml = $this->create_xml();
        $rs = \Core\Curl::post($host, $xml, $option);
        $message = $this->xml2arr($rs->response);
        log_message(var_export($message, true));
        return $message;
    }
}