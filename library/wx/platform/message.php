<?php
namespace WX\Platform;

/**
 * 消息处理
 * @author EVEN
 *
 */
class Message extends \WX\Platform\Callback
{
    const MSG_TYPE_TEXT = 'text';
    const MSG_TYPE_IMAGE= 'image';
    const MSG_TYPE_LINK= 'link';
    const MSG_TYPE_LOCATION = 'location';
    const MSG_TYPE_EVENT= 'event';
    
    const REPLY_TYPE_MUSIC= 'music';
    const REPLY_TYPE_TEXT = 'text';
    const REPLY_TYPE_NEWS = 'news';
    
    public $receive = null;
    
    public $from_user;
    
    public $to_user;
    
    /**
     * 接收微信推送消息
     * @see WX\Platform.Callback::post()
     */
    public function post()
    {
        $rs = parent::post();
        if(!empty($rs))
        {
            $this->set_receive($rs);
            return $rs;
        }
        return false;
    }
    
    /**
     * 设置接收的消息
     * @param object $data
     */
    protected function set_receive($data)
    {
        $this->receive = $data;
        $this->from_user = $this->receive->FromUserName;
        $this->to_user =  $this->receive->ToUserName;
    }
    
    /**
     * check text msg
     * @return boolean
     */
    public function is_textmsg()
    {
        return $this->receive->MsgType == self::MSG_TYPE_TEXT;
    }
    
    /**
     * 关注事件
     */
    public function is_subscribe()
    {
        if($this->receive->MsgType == self::MSG_TYPE_EVENT && $this->receive->Event == 'subscribe')
        {
            return true;
        }
        return false;
    }
    
    /**
     * check location
     * @return boolean
     */
    public function is_locationmsg()
    {
        return $this->receive->MsgType == self::MSG_TYPE_LOCATION;
    }
    
    /**
     * check image
     * @return boolean
     */
    public function is_imagemsg()
    {
        return $this->receive->MsgType == self::MSG_TYPE_IMAGE;
    }
    /**
     * check links
     * @return boolean
     */
    public function is_linkmsg()
    {
        return $this->receive->MsgType == self::MSG_TYPE_LINK;
    }
    
    /**
     * check event push
     * @return boolean
     */
    public function is_eventmsg()
    {
        return $this->receive->MsgType == self::MSG_TYPE_EVENT;
    }
    
    /**
     * generate text msg string
     * @param string $content
     * @return string xml
     */
    public function output_text($content)
    {
        $textTpl = '<xml>
                <ToUserName><![CDATA[%s]]></ToUserName>
                <FromUserName><![CDATA[%s]]></FromUserName>
                <CreateTime>%s</CreateTime>
                <MsgType><![CDATA[%s]]></MsgType>
                <Content><![CDATA[%s]]></Content>
                <FuncFlag>0</FuncFlag>
            </xml>';
        
        $text = sprintf ( $textTpl, $this->from_user, $this->to_user, time (), self::REPLY_TYPE_TEXT, $content );
        return $text;
    }
    
    /**
     * generate text & images msg string
     * @param string $content
     * @param arrry $posts article array. Every item is an article array, the keys are in consistent of the official instructions.
     * @return string xml
     */
    public function output_news($posts = array())
    {
        $textTpl = '<xml>
             <ToUserName><![CDATA[%s]]></ToUserName>
             <FromUserName><![CDATA[%s]]></FromUserName>
             <CreateTime>%s</CreateTime>
             <MsgType><![CDATA[%s]]></MsgType>
             <ArticleCount>%d</ArticleCount>
             <Articles>%s</Articles>
             <FuncFlag>1<FuncFlag>
         </xml>';
        
        $itemTpl = '<item>
             <Title><![CDATA[%s]]></Title>
             <Description><![CDATA[%s]]></Description>
             <PicUrl><![CDATA[%s]]></PicUrl>
             <Url><![CDATA[%s]]></Url>
         </item>';
        
        $items = '';
        foreach ( ( array ) $posts as $p )
        {
            if (is_array ( $p ))
            {
                $items .= sprintf ( $itemTpl, $p ['title'], $p ['discription'], $p ['picurl'], $p ['url'] );
            } 
            else
            {
                throw new \Exception ( '$posts data structure wrong' );
            }
        }
        
        $text = sprintf ( $textTpl, $this->from_user, $this->to_user, W_START_TIME, self::REPLY_TYPE_NEWS, count ( $posts ), $items);
        return $text;
    }
    
    /**
     * 回复音乐
     * @param unknown_type $musicpost
     */
    public function output_music($musicpost)
    {
        $textTpl = '<xml>
            <ToUserName><![CDATA[%s]]></ToUserName>
            <FromUserName><![CDATA[%s]]></FromUserName>
            <CreateTime>%s</CreateTime>
            <MsgType><![CDATA[%s]]></MsgType> 
            <Music>%s</Music>
            <FuncFlag>0</FuncFlag>
        </xml>';
        
        $musicTpl = '
            <Title><![CDATA[%s]]></Title>
            <Description><![CDATA[%s]]></Description>
            <MusicUrl><![CDATA[%s]]></MusicUrl>
            <HQMusicUrl><![CDATA[%s]]></HQMusicUrl>
            ';
        $music = '';
        if (is_array ( $musicpost ))
        {
            $music .= sprintf ( $musicTpl, $musicpost ['title'], $musicpost ['discription'], $musicpost ['musicurl'], $musicpost ['hdmusicurl'] );
        }
        else
        {
            throw new \Exception ( '$posts data structure wrong' );
        }
        
        $text = sprintf ( $textTpl, $this->from_user, $this->to_user, time (), self::REPLY_TYPE_MUSIC, $music );
        return $text;
    
    }
	
}