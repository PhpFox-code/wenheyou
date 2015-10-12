<?php
namespace WX\Platform;

/**
 * 客服消息
 * @author EVEN
 *
 */
class Custom extends \WX\Platform\Callback
{
	/**
	 * 发送模版消息
	 * @param json $params
	 * 
	 * {
     *       "touser":"OPENID",
     *       "template_id":"ngqIpbwh8bUfcSsECmogfXcV14J0tQlEpBO27izEYtY",
     *       "url":"http://weixin.qq.com/download",
     *       "topcolor":"#FF0000",
     *       "data":{
     *           "first":{
     *               "value":"恭喜你购买成功！",
     *               "color":"#173177"
     *          },
     *           "keynote1":{
     *               "value":"巧克力",
     *               "color":"#173177"
     *           },
     *           "keynote2":{
     *               "value":"39.8元",
     *               "color":"#173177"
     *           },
     *           "keynote3":{
     *               "value":"2014年9月16日",
     *               "color":"#173177"
     *           },
     *           "remark":{
     *               "value":"欢迎再次购买！",
     *               "color":"#173177"
     *           }
     *       }
     *   }
     *   
	 */
	public function template($params)
	{
	    $host = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=%s";
	    $url = sprintf($host, $this->get_accesstoken());
	    $info = \Core\Curl::post($url, $params);
    	return json_decode($info->response, true);
	}
	

	/**
	 * 回复客服消息,消息使用json格式化
	 * 
	 * @param json $params
	 */
	public function reply($params)
	{
	    $host = "https://api.weixin.qq.com/cgi-bin/message/custom/send?access_token=%s";
	    $url = sprintf($host, $this->get_accesstoken());
	    $info = \Core\Curl::post($url, $params);
    	return json_decode($info->response, true);
	}
    
}