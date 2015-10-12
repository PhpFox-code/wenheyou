<?php
namespace WX\Coupon;

/**
 * 卡券接口
 */
class Common extends \WX\Platform\Common
{
    public $ticket = NULL;
    
    public function get_ticket($key='ticket', $default = null)
    {
        \Core\Cache::init_config_params();
    	$this->ticket = \Core\Cache::get('card_ticket');
    	if(empty($this->ticket))
    	{
            $host = 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token=%s&type=wx_card';
            $url = sprintf($host, $this->get_accesstoken());
            $info = \Core\Curl::post($url);
    		$respone = json_decode($info->response , true);
		    if (isset($respone['ticket']))
		    {
		        $this->ticket = $respone;
		    }
		    \Core\Cache::set('card_ticket', $respone);
    	}
	    if(!isset($this->ticket[$key]))
        {
            $this->ticket[$key] = $default;
        }
        return $this->ticket[$key];
    }
    
    /**
     * 获取店铺列表
     */
    public function get_stores($page = 1, $limit = 10)
    {
        $offset = ($page - 1)*$limit;
        $host = 'https://api.weixin.qq.com/card/location/batchget?access_token=%s';
        $url = sprintf($host, $this->get_accesstoken());
        $info = \Core\Curl::post($url, json_encode(array('offset'=>$offset, 'count'=>$limit)));
        $response = json_decode($info->response, true);
        if ($response['errcode'] == 0)
        {
            return $response;
        }
        return false;
    }
    
    /**
     * 获取卡券列表
     * @param 获取卡券
     */
    public function get_cards($page = 1, $limit = 10)
    {
        $offset = ($page - 1)*$limit;
        $host = 'https://api.weixin.qq.com/card/batchget?access_token=%s';
        $url = sprintf($host, $this->get_accesstoken());
        $info = \Core\Curl::post($url, json_encode(array('offset'=>$offset, 'count'=>$limit)));
        $response = json_decode($info->response, true);
        if ($response['errcode'] == 0)
        {
            return $response;
        }
        return false;
    }
    
    /**
     * 获取卡券详情
     * @param string 卡券ID
     */
    public function get_card_detail($card_id)
    {
        $host = 'https://api.weixin.qq.com/card/get?access_token=%s';
        $url = sprintf($host, $this->get_accesstoken());
        $info = \Core\Curl::post($url, json_encode(array('card_id'=>$card_id)));
        $response = json_decode($info->response, true);
        if ($response['errcode'] == 0)
        {
            return $response;
        }
        return false;
    }
    
    /**
     * 生成随机字符串
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
     * 获取卡券参数,包括签名之类
     * $type string 卡券类型
     */
    public function get_card_param($locaton_id = '', $type = 'CASH')
    {
        $arr = array( 
        	'app_id' => $this->appid,
        	'api_ticket' => $this->get_ticket(),
        	'timestamp' => W_START_TIME,
        	'nonceStr' => $this->create_noncestr(),
            'card_type' => $type 
        );
        if(!empty($locaton_id))
        {
            $arr['location_id'] = $locaton_id;
        }
        $arr1  = array_values($arr);   
        sort( $arr1, SORT_STRING );
        $arr['card_sign'] =  sha1(  implode($arr1) ) ;
        return $arr;
    }
    
    /**
     * 获取卡券的自定义编号
     * @param string $encrypt_code
     */
    public function get_card_code($encrypt_code)
    {
        $host = 'https://api.weixin.qq.com/card/code/decrypt?access_token=%s';
        $url = $url = sprintf($host, $this->get_accesstoken());
        $info = \Core\Curl::post($url, json_encode(array('encrypt_code'=>$encrypt_code)));
        $response = json_decode($info->response, true);
        if ($response['errcode'] == 0)
        {
            return $response;
        }
        return false;
    }
    
    /**
     * 核销卡券
     * @param $card_id 卡券ID
     * @param $code 自定义编码
     */
    public function consumption_card($card_id, $code = '')
    {
        $host = 'https://api.weixin.qq.com/card/code/consume?access_token=%s';
        $url = $url = sprintf($host, $this->get_accesstoken());
        $params = array('card_id'=>$card_id);
        if(!empty($code))
        {
            $params['code'] = $code;
        }
        $info = \Core\Curl::post($url, json_encode($params));
        $response = json_decode($info->response, true);
        log_message(var_export($response, true), var_export($params, true));
        if ($response['errcode'] == 0)
        {
            return $response;
        }
        return false;
    }
    
}