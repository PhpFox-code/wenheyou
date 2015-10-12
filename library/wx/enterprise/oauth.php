<?php
namespace WX\Enterprise;

/**
 * oauth授权类
 * @author chenyuwen
 *
 */
class Oauth extends \WX\Enterprise\Common
{
    /**
     * 授权页面跳转
     * @var string
     */
    public $host = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=%s&redirect_uri=%s&response_type=code&scope=snsapi_base&state=STATE#wechat_redirect";
    
    /**
     * 跳转到微信，然后传参数回来
     * @param string $type
     * @param string $appId
     * @param string $redirectUrl
     */
    public function goto_weixin($redirect_url)
    {
        $url = sprintf($this->host, $this->corpid, $redirect_url);
        redirect($url);
    }
    
    /**
     * 获取用户授权的token
     * @param string $code
     * @param int $corp_agent_id
     */
    public function get_userid($code)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/user/getuserinfo?access_token=%s&code=%s&agentid=%s";
	    $url = sprintf($host, $this->get_accesstoken(), $code, $this->corpagentid);
	    $info = \Core\Curl::get($url);
	    $response = json_decode($info->response, true);
        if(isset($response['UserId']))
        {
            return $response['UserId'];
        }
        return false;
    }
}