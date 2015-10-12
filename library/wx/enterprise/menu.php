<?php
namespace WX\Enterprise;

/**
 * 菜单接口类
 * @author chenyuwen
 *
 */
class Menu extends \WX\Enterprise\Common
{
    /**
     * 创建菜单
     * @param json $params
     */
    public function create($params)
    {
        $host = 'https://qyapi.weixin.qq.com/cgi-bin/menu/create?access_token=%s&agentid=0';
        $url = sprintf($host, $this->get_accesstoken());
        $info = \Core\Curl::post($url, $params);
        $response = json_decode($info->response, true);
	    if (isset($response['errcode']) && $response['errcode'] == '0')
	    {
	        return TRUE;
	    }
	    return $response['errmsg'];
    }
    
    /**
     * 删除菜单
     */
    public function delete()
    {
        $host = 'https://qyapi.weixin.qq.com/cgi-bin/menu/delete?access_token=%s&agentid=%s';
        $url = sprintf($host, $this->get_accesstoken(), $this->corp_agent_id);
        $info = \Core\Curl::get($url);
        $response = json_decode($info->response, true);
        if ($response['errcode'] ==0)
        {
            return $response;
        }
        return false;
    }
    
    /**
     * 获取菜单
     */
    public function get()
    {
        $host = 'https://qyapi.weixin.qq.com/cgi-bin/menu/get?access_token=%s&agentid=%s';
        $url = sprintf($host, $this->get_accesstoken(), $this->corp_agent_id);
        $info = \Core\Curl::get($url);
        $response = json_decode($info->response, true);
        if ($response['errcode'] ==0)
        {
            return $response;
        }
        return false;
    }
}