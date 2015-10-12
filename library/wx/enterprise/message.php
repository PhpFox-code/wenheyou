<?php
namespace WX\Enterprise;

/**
 * 发送消息
 * @author chenyuwen
 *
 */
class Message extends \WX\Enterprise\Common
{
    /**
     * 接收到的消息
     * @var mix
     */
    public $receive = null;
    
    /**
	 * 订阅事件
	 * @var string
	 */
	const E_EVT_SUBSCRIBE   = 'evt_subscribe';
	const E_EVT_UNSUBSCRIBE = 'evt_unsubscribe';
	const E_EVT_VERIFY      = 'evt_verify';
	const E_EVT_CLICK       = 'evt_click';
	
	/**
	 * 消息类型
	 * @var string
	 */
	const E_MSG_TEXT       = 'msg_text';
	const E_MSG_IMAGE      = 'msg_image';
	const E_MSG_VIDEO      = 'msg_video';
	const E_MSG_VOICE      = 'msg_voice';
	const E_MSG_LOCATION   = 'msg_location';
	
    /**
     * 上传文件
     * @param string $type
     * @param string $fileRealPath
     */
    public function upload($type = 'image', $fileRealPath)
    {
        $types = array('image', 'voice', 'video', 'file');
	    if (in_array($type, $types))
	    {
            $host = "https://qyapi.weixin.qq.com/cgi-bin/media/upload?access_token=%s&type=%s";
            $url = sprintf($host, $this->get_accesstoken('access_token'), $type);
	        if (version_compare(PHP_VERSION, '5.5.0', '<'))
    	    {
    	        $data = array('media' => "@{$fileRealPath}");
    	    }
    	    else 
    	    {
    	        $fileName = basename($fileRealPath);
    	        $finfo = finfo_open(FILEINFO_MIME_TYPE);
    	        $mimeType = finfo_file($finfo, $fileRealPath);
    	        $data['media'] = new \CurlFile($fileRealPath, $mimeType, $fileName);
    	    }
    	    $info = \Core\Curl::post($url, $data);
    	    $response = json_decode($info->response, true);
    	    if (!empty($response['media_id']))
    	    {
    	        return $response['media_id'];
    	    }
    	    if (!empty($response['thumb_media_id']))
    	    {
    	        return $response['thumb_media_id'];
    	    }
	    }
	    else
	    {
	        throw new \Exception('upload file type is not vaild!');
	    }
	    return FALSE;
    }
    
    /**
     * 获取媒体文件
     * @param int $media_id
     */
    public function get_media($media_id)
    {
        $host = 'https://qyapi.weixin.qq.com/cgi-bin/media/get?access_token=%s&media_id=%s';
        $url = sprintf($host, $this->get_accesstoken('access_token'), $media_id);
        return $url;
    }
}