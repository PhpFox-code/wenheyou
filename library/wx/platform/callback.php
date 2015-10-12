<?php
namespace WX\Platform;

/**
 * 微信回调接口
 * @author EVEN
 *
 */
class Callback extends \WX\Platform\Common
{
    /**
     * 获取调用传过来的数据
     */
    public function post()
    {
        $rs = '';
        $postStr = $GLOBALS ["HTTP_RAW_POST_DATA"];
        if (! empty ( $postStr ))
        {
            libxml_disable_entity_loader ( true );
            $rs =  simplexml_load_string ( $postStr, 'SimpleXMLElement', LIBXML_NOCDATA );
        }
        return $rs;
    }
    
    /**
     * 验证接口
     */
    public function get()
    {
        $echoStr = $_GET ["echostr"];
        if ($this->check_signature())
        {
            echo $echoStr;
            exit ();
        }
    }
    
    /**
     * 验证算法封装
     */
    protected function check_signature()
    {
        $signature = $_GET ["signature"];
        $timestamp = $_GET ["timestamp"];
        $nonce = $_GET ["nonce"];
        $tmpArr = array ($this->token, $timestamp, $nonce );
        sort ( $tmpArr, SORT_STRING );
        $tmpStr = implode ( $tmpArr );
        $tmpStr = sha1 ( $tmpStr );
        
        if ($tmpStr == $signature)
        {
            return true;
        }
        return false;
    }
}