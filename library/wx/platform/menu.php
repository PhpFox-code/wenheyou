<?php
namespace Wx\Platform;

/**
 * 菜单管理
 * @author EVEN
 *
 */
class Menu extends \WX\Platform\Common
{
    /**
     * 创建菜单
     * @param json $params
     */
    public function create($params)
    {
        $host = 'https://api.weixin.qq.com/cgi-bin/menu/create?access_token=%s';
        $url = sprintf($host, $this->get_accesstoken());
        $info = \Core\Curl::post($url);
        $response = json_decode($info->response, true);
        if ($response['errcode'] == 0)
        {
            return $response;
        }
        return false;
    }
    
    /**
     * 删除菜单
     */
    public function delete()
    {
        $host = 'https://api.weixin.qq.com/cgi-bin/menu/delete?access_token=%s';
        $url = sprintf($host, $this->get_accesstoken());
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
        $host = 'https://api.weixin.qq.com/cgi-bin/menu/get?access_token=%s';
        $url = sprintf($host, $this->get_accesstoken());
        $info = \Core\Curl::get($url);
        $response = json_decode($info->response, true);
        if ($response['errcode'] ==0)
        {
            return $response;
        }
        return false;
    }
}