<?php
namespace WX\Enterprise;

/**
 * 微信消息被动回复
 * @author chenyuwen
 *
 */
class Reply extends \WX\Enterprise\Message
{

    /**
     * 事件名称
     * @var string
     */
    const EVENT_BIND_KEY = 'wxreply';
    
    /**
     * 监听事件
     */
    public function watch_event()
    {
        // 加入事件绑定
        event(self::EVENT_BIND_KEY, $this);
    }
    
    /**
     * 文本消息
     * @param string $from_user
     * @param string $to_user
     * @param string $text 
     */
    public function text($content)
    {
        $time = W_START_TIME;
        $tpl = "<xml>
                <ToUserName><![CDATA[{$this->receive['ToUserName']}]]></ToUserName>
                <FromUserName><![CDATA[{$this->receive['FromUserName']}]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[text]]></MsgType>
                <Content><![CDATA[{$content}]]></Content>
                </xml>"; 
        return $tpl;
    }
    
    /**
     * 发送图片
     * @param string $from_user
     * @param string $to_user
     * @param int $media_id
     */
    public function image($media_id)
    {
        $time = W_START_TIME;
        $tpl = "<xml>
                <ToUserName><![CDATA[{$this->receive['ToUserName']}]]></ToUserName>
                <FromUserName><![CDATA[{$this->receive['FromUserName']}]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[image]]></MsgType>
                <Image>
                <MediaId><![CDATA[{$media_id}]]></MediaId>
                </Image>
                </xml>";
        return $tpl;
    }
    

    
    /**
     * 发送图片
     * @param string $from_user
     * @param string $to_user
     * @param int $media_id
     * @param int $message_id
     * @param int $format 语音格式，如 amr，speex 等
     */
    public function voice($media_id)
    {
        $time = W_START_TIME;
        $tpl = "<xml>
                <ToUserName><![CDATA[{$this->receive['ToUserName']}]]></ToUserName>
                <FromUserName><![CDATA[{$this->receive['FromUserName']}]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[voice]]></MsgType>
                <Voice>
                <MediaId><![CDATA[{$media_id}]]></MediaId>
                </Voice>
                </xml>";
        return $tpl;
    }
    
    /**
     * 发送图片
     * @param string $from_user
     * @param string $to_user
     * @param int $media_id
     * @param int $message_id
     */
    public function video($media_id, $title, $description)
    {
        $time = W_START_TIME;
        $tpl = "<xml>
                <ToUserName><![CDATA[{$this->receive['ToUserName']}]]></ToUserName>
                <FromUserName><![CDATA[{$this->receive['FromUserName']}]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[video]]></MsgType>
                <Video>
                <Title><![CDATA[{$title}]]></Title>
                <MediaId><![CDATA[{$media_id}]]></MediaId>
                <Description><![CDATA[{$description}]]></Description>
                </Video>
                </xml>";
        return $tpl;
    }
    
    /**
     * 发送图片
     * @param string $from_user
     * @param string $to_user
     * @param array $news = array('title'=>'', 'description'=>'', 'picture_url', 'url'=>'')
     */
    public function news($news)
    {
        $time = W_START_TIME;
        $count = count($news);
        $tpl = "<xml><ToUserName><![CDATA[{$this->receive['ToUserName']}]]></ToUserName>
                <FromUserName><![CDATA[{$this->receive['FromUserName']}]]></FromUserName>
                <CreateTime>{$time}</CreateTime>
                <MsgType><![CDATA[news]]></MsgType>
                <ArticleCount>{$count}</ArticleCount>
                <Articles>";
        
        foreach ($news as $val)
        {
            $tpl .= "<item><Title><![CDATA[{$val['title']}]]></Title> 
                    <Description><![CDATA[{$val['description']}]]></Description>
                    <PicUrl><![CDATA[{$val['picture_url']}]]></PicUrl>
                    <Url><![CDATA[{$val['target_url']}]]></Url>
                    </item>";
        }
        
        $tpl .="</Articles></xml>";
        return $tpl;
    }
}