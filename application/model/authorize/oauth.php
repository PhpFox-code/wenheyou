<?php
namespace Model\Authorize;
/**
 * 微信帐号授权
 * @author Yuwenc
 *
 */
class Oauth extends \Core\Controller
{
    /**
     * 微信创建账号登录
     * @see Core.Controller::initialize()
     */
    public function initialize()
    {
        $user = self::login_user();
        if (empty($user))
        {
            $code = \Core\URI::kv('code');
            $v = new \Core\Validation();
            $v->required($code)->message('用户未来授权访问', 1000);
            $oauth = \WX\Platform\Oauth::init_config_params();
            if ($v->has_error())
            {
//                $oauth->to_weixin(W_DOMAIN.\Core\URI::a2p_before(), 'host_base');
                $oauth->to_weixin(W_DOMAIN.\Core\URI::a2p_before(), 'user_info');
            }
            else 
            {
                $user_accesstoken = $oauth->user_accesstoken($code);
                $openid = $user_accesstoken['openid'];
                $access_token = $user_accesstoken['access_token'];
                
                $userinfo = $oauth->user_info();
                $row = \DB\Account\Identify::row(array('identify_name'=>$openid, 'identify_type'=>4));
                if (empty($row))
                {
                    $user = new \DB\Account\User();
                    $user->user_avatar = $userinfo['headimgurl'];
                    $user->user_nickname = $userinfo['nickname'];
                    $user->user_status = 1;
                    $user->user_gender = $userinfo['sex'] == 1 ? 'male' : 'female';
                    $user->create_time = W_START_TIME;
                    $user->login_time = W_START_TIME;
                    $user_id = $user->save();
                    
                    $identify = new \DB\Account\Identify();
                    $identify->identify_name = $openid;
                    $identify->identify_level = 1;
                    $identify->create_time = W_START_TIME;
                    $identify->identify_password = $access_token;
                    $identify->user_id = $user_id;
                    $identify->identify_type = 4;
                    $identify->save();
                }
                else
                {
                    $user_id = $row->user_id;
                    $row->user->user_avatar = $userinfo['headimgurl'];
                    $row->user->user_nickname = $userinfo['nickname'];
                    $row->user->user_gender = $userinfo['sex'] == 1 ? 'male' : 'female';
                    $row->user->login_time = W_START_TIME;
                    $row->user->save();
                }
                \Core\Session::set('user_id', $user_id);
            }
        }
    }
    
    public static function login_user($user_id = null)
    {
        static $user = NULL;
        if(empty($user))
        {
        	if(is_null($user_id))
        	{
    	    	$user_id = \Core\Session::get('user_id');
        	}
    	    if(!empty($user_id))
    	    {
    	        $user = \DB\Account\User::row(array('user_id'=>$user_id));
    	    }
        }
        return $user;
    }
    
}