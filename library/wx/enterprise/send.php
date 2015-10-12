<?php
namespace WX\Enterprise;

/**
 * 微信消息主动发送消息
 * @author chenyuwen
 */
class Send extends \WX\Enterprise\Message
{
    /**
     * 发送消息请求
     * @param string $access_token
     * @param json $message
     */
    protected function push($message)
    {
        $host = 'https://qyapi.weixin.qq.com/cgi-bin/message/send?access_token=%s';
        $info = \Core\Curl::post(sprintf($host, $this->get_accesstoken()), $message);
        $respone = json_decode($info->response , true);
	    if (isset($respone['errcode']) && $respone['errcode'] == 0)
	    {
	        return $respone;
	    }
	    return FALSE;
    }
    
    /**
     * 发送文本内容
     * @param string $open_id
     * @param string $content
     */
    public function text($content, $to_user = '', $to_party = '')
    {
        $message =  self::decode_unicode(json_encode(array(
            'touser' => $to_user,
            'toparty' => $to_party,
            'msgtype' => 'text',
            'agentid' => $this->corpagentid,
            'text'=> array('content'=>$content),
            'safe'=> 0,
        )));
        return $this->push($message);
    }
    
    /**
     * 主动发送图片信息
     * @param string $open_id
     * @param string $media_id
     */
    public function image($media_id, $to_user = '', $to_party = '')
    {
        $message = self::decode_unicode(json_encode(array(
            'touser' => $to_user,
            'toparty' => $to_party,
            'msgtype'=>'image',
            'agentid' => $this->corpagentid,
            'image'=>array('media_id'=>$media_id),
        	'safe'=> 1,
        )));
        return $this->push($message);
    }
    
    /**
     * 主动发送声音信息
     * @param string $open_id
     * @param string $media_id
     */
    public function voice($media_id, $to_user = '', $to_party = '')
    {
        $message = self::decode_unicode(json_encode(array(
            'touser' => $to_user,
            'toparty' => $to_party,
            'msgtype'=>'voice',
            'agentid' => $this->corpagentid,
            'voice'=>array('media_id'=>$media_id),
        	'safe'=> 1,
        )));
        return $this->push($message);
    }
    
    /**
     * 主动发送视频信息
     * @param string $open_id
     * @param string $media_id
     */
    public function video($media_id, $description, $to_user = '', $to_party = '')
    {
        $message = self::decode_unicode(json_encode(array(
            'touser' => $to_user,
            'toparty' => $to_party,
            'msgtype'=>'video',
            'agentid' => $this->corpagentid,
            'video'=>array('media_id'=>$media_id, 'description' => $description),
        	'safe'=> 1,
        )));
        return $this->push($message);
    }
    
    /**
     * 主动发送文件
     * @param string $open_id
     * @param string $media_id
     */
    public function file($media_id, $to_user = '', $to_party = '')
    {
        $message = self::decode_unicode(json_encode(array(
            'touser' => $to_user,
            'toparty' => $to_party,
            'msgtype'=>'file',
            'agentid' => $this->corpagentid,
            'file'=>array('media_id'=>$media_id),
        	'safe'=> 1,
        )));
        return $this->push($message);
    }
    
    /**
     * 主动发送图文信息
     * @param string $access_token
     * @param string $agentid
     * @param array $new_arr = array(array('title'=>'', 'url'=>'', 'picurl'=>'', 'description'=>''))
     * @param string $touser
     * @param string $toparty
     */
    public function news($new_arr, $to_user = '', $to_party = '')
    {
        $message = self::decode_unicode(json_encode(array(
            'touser' => $to_user,
            'toparty' => $to_party,
            'msgtype'=>'news',
            'agentid' => $this->corpagentid,
            'news'=>array('articles'=>$new_arr),
        	'safe'=> 0,
        )));
        return $this->push($message);
    }
    
    /**
     * 主动发送图文信息
     * @param string $access_token
     * @param string $agentid
     * @param array $new_arr = array(array('thumb_media_id'=>'','title'=>'', 'anthor'=>'', 'content_source_url'=>'', 'content'=>'', 'digest'=>'', 'show_cover_pic'=>0))
     * @param string $touser
     * @param string $toparty
     */
    public function mpnews($new_arr, $media_id = '', $to_user = '', $to_party = '')
    {
        $message = self::decode_unicode(json_encode(array(
            'touser' => $to_user,
            'toparty' => $to_party,
            'msgtype'=>'mpnews',
            'agentid' => $this->corpagentid,
            'mpnews'=>array('articles'=>$new_arr, 'media_id'=>$media_id),
        	'safe'=> 1,
        )));
        return $this->push($message);
    }
    
    /**
     * 解码json_encode的中文Unicode问题
     * @param string $str
     */
	public static function decode_unicode ($str)
	{
	    return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', 
	    	create_function('$matches', 
			    'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'), 
			    $str
		);
	}
}