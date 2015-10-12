<?php
namespace Controller;

class Weixin extends \Core\Controller
{
	/**
	 * 接收微信通知
	 */
    public function connect()
    {
        $callback = \WX\Platform\Message::init_config_params();
        // 如果是post请求
        if (get_method() == 'get')
        {
            $callback->get();
        }
        else
        {
            $callback->post();
            log_message(var_export($callback->receive, true));
            //log_message($callback->receive->Content);
            if($callback->is_textmsg())
            {
            	    $info = array(
                        array(
                            'title'=> '寻找中国九大仙草--中奖名单',
                            'discription'=> '中奖名单',
                            'picurl'=>'http://jiucao.daxiangw.com/img/feng.jpg',
                            'url'=> 'http://mp.weixin.qq.com/s?__biz=MzA4Nzk2MzY4NQ==&mid=207476894&idx=1&sn=ebb8545afe9f20cda7f0a01c1c8b41d8#rd',
                        ),
                    );
                    echo $callback->output_news($info);
            }
        }
    }
    
}