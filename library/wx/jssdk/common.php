<?php
namespace WX\JSSDK;
/**
 * jssdk通用模块获取签名包
 * @author EVEN
 *
 */
class Common extends \WX\Platform\Common
{
	public $ticket = NULL;
	
    public function get_sign_package()
    {
        $jsapiticket = $this->get_jsapi_ticket();
        
        // 注意 URL 一定要动态获取，不能 hardcode.
        $protocol = (! empty ( $_SERVER ['HTTPS'] ) && $_SERVER ['HTTPS'] !== 'off' || $_SERVER ['SERVER_PORT'] == 443) ? "https://" : "http://";
        $url = "$protocol$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
        
        $timestamp = W_START_TIME;
        $noncestr = $this->create_nonce_str();
        
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiticket&noncestr=$noncestr&timestamp=$timestamp&url=$url";
        $signature = sha1 ( $string );
        
        return array (
        	"appId"      => $this->appid, 
        	"nonceStr"   => $noncestr, 
        	"timestamp"  => $timestamp, 
        	"url"        => $url, 
        	"signature"  => $signature, 
        	"rawString"  => $string 
        );
    }
    
    private function create_nonce_str($length = 16)
    {
        $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
        $str = "";
        for($i = 0; $i < $length; $i ++)
        {
            $str .= substr ( $chars, mt_rand ( 0, strlen ( $chars ) - 1 ), 1 );
        }
        return $str;
    }
    
    private function get_jsapi_ticket($key = 'ticket', $default = null)
    {
        \Core\Cache::init_config_params();
    	$this->ticket = \Core\Cache::get('jsapi_ticket');
    	if(empty($this->ticket))
    	{
	        $host = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?type=jsapi&access_token=%s";
	        $url = sprintf($host, $this->get_accesstoken());
		    $info = \Core\Curl::get($url);
		    $respone = json_decode($info->response , true);
		    if (isset($respone['ticket']))
		    {
		        $this->ticket = $respone;
		    }
		    \Core\Cache::set('jsapi_ticket', $respone);
    	}
	    if(!isset($this->ticket[$key]))
        {
            $this->ticket[$key] = $default;
        }
        return $this->ticket[$key];
    }
}