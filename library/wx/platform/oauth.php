<?php
namespace WX\Platform;
/**
 * 微信用户授权
 * @author EVEN
 *
 */
class Oauth extends Common
{
    /**
     * 免授权跳转
     * @var string
     */
    public $host_base = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=123#wechat_redirect";
    
    /**
     * 授权页面跳转
     * @var string
     */
    public $host_userinfo = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect";
    
    /**
     * 用户的accssToken
     * @var array
     */
    protected $user_accesstoken = NULL;
    
    /**
     * 用户信息
     * @var array
     */
    public $user_info;
    
    /**
     * 跳转到微信，然后传参数回来
     * @param string $type
     * @param string $appId
     * @param string $redirectUrl
     */
    public function to_weixin($redirect_url, $type = 'user_info')
    {
        if ($type == 'user_info')
        {
            $host = $this->host_userinfo;
        }
        else
        {
            $host = $this->host_base;
        }
        $url = sprintf ( $host, $this->appid, $redirect_url );
        redirect ( $url );
        exit ();
    }
    
    /**
     * 获取用户授权的token
     * @param string $code
     */
    public function user_accesstoken($code)
    {
		$host = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=%s&secret=%s&code=%s&grant_type=authorization_code";
        $url = sprintf ( $host, $this->appid, $this->appsecret, $code );
        $info = \Core\Curl::get($url);
        $response = json_decode ( $info->response, true );
        if (isset ( $response ['openid'] ))
        {
            $this->user_accesstoken = $response;
        }
        return $this->user_accesstoken;
    }
    
    /**
     * 获取用户基本信息
     * @param string $access_token
     * @param string $open_id
     */
    public function user_info($key = null)
    {
        if(empty($this->user_info))
        {
            $host = "https://api.weixin.qq.com/sns/userinfo?access_token=%s&openid=%s&lang=zh_CN";
            $url = sprintf ( $host, $this->user_accesstoken['access_token'], $this->user_accesstoken['openid']);
            $info = \Core\Curl::get($url);
            $response = json_decode ( $info->response, true );
            if (isset ($response ['nickname'] ))
            {
                $this->user_info = $response;
            }
        }
        if (! is_null ( $key ) && isset ( $this->user_info [$key] ))
        {
            return $this->user_info [$key];
        }
        
        return $this->user_info;
    }
}