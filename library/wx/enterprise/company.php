<?php
namespace WX\Enterprise;

/**
 * 公司通讯录处理类
 * @author chenyuwen
 *
 */
class Company extends \WX\Enterprise\Common
{   
    /**
     * 创建部门
     * @param array $department_info
     * 
     * @code
     * $department_info = array('name'=>'xxx', 'parentid'=>1);
     * @endcode
     */
    public function create_department($department_info)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/department/create?access_token=%s";
        $url = sprintf($host, $this->get_accesstoken());
	    $info = \Core\Curl::post($url, \WX\Enterprise\Send::decode_unicode(json_encode($department_info)));
	    $respone = json_decode($info->response , true);
	    if (isset($respone['errcode']) && $respone['errcode'] == '0')
	    {
	        return $respone['id'];
	    }
	    return FALSE;
    }
    
    /**
     * 更新部门
     * @param array $department_info
     * 
     * @code
     * $department_info = array('name'=>'xxx', 'id'=>1);
     * @endcode
     */
    public function update_department($department_info)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/department/update?access_token=%s";
        $url = sprintf($host, $this->get_accesstoken());
	    $info = \Core\Curl::post($url, json_encode($department_info));
	    $respone = json_decode($info->response , true);
	    if (isset($respone['errcode']) && $respone['errcode'] == '0')
	    {
	        return TRUE;
	    }
	    return FALSE;
    }
    
    /**
     * 删除部门
     */
    public function delete_department($department_id)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/department/delete?access_token=%s&id=%s";
        $url = sprintf($host, $this->get_accesstoken(), $department_id);
	    $info = \Core\Curl::delete($url);
	    $respone = json_decode($info->response , true);
	    if (isset($respone['errcode']) && $respone['errcode'] == '0')
	    {
	        return TRUE;
	    }
	    return $respone['errmsg'];
    }
    
    /**
     * 获取部门列表
     */
    public function get_department()
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/department/list?access_token=%s";
        $url = sprintf($host, $this->get_accesstoken());
	    $info = \Core\Curl::get($url);
	    $respone = json_decode($info->response , true);
	    if (isset($respone['department']))
	    {
	        return $respone['department'];
	    }
	    return FALSE;
    }
    
    /**
     * 获取部门成员列表
     */
    public function get_department_list($department_id, $fetch_child=0, $status = 0)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/user/simplelist?access_token=%s&department_id=%s&fetch_child=%s&status=%s";
        $url = sprintf($host, $this->get_accesstoken(), $department_id, $fetch_child, $status);
	    $info = \Core\Curl::get($url);
	    $respone = json_decode($info->response , true);
    	if (isset($respone['userlist']))
	    {
	        return $respone['userlist'];
	    }
	    return $respone['errmsg'];
    }
    
    /**
     * 创建成员
     * @param array $user_info
     * 
     * @code
     * $user_info = array(
     *    'userid' => '',
     *    'name' => '',
     *    'department' => '',
     *    'position' => '',
     *    'mobile' => '',
     *    'gender' => '',
     *    'tel' => '',
     *    'email' => '',
     *    'weixinid' => '',
     * );
     * @encode
     */
    public function create_member($user_info)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/user/create?access_token=%s";
        $url = sprintf($host, $this->get_accesstoken());
	    $info = \Core\Curl::post($url, \WX\Enterprise\Send::decode_unicode(json_encode($user_info)));
	    $respone = json_decode($info->response , true);
	    if (isset($respone['errcode']) && $respone['errcode'] == '0')
	    {
	        return TRUE;
	    }
	    return $respone['errmsg'];;
    }
    
    /**
     * 更新用户信息
     * @param array $user_info
     * 
     * @code
     * $user_info = array(
     *    'userid' => '',
     *    'name' => '',
     *    'department' => '',
     *    'position' => '',
     *    'mobile' => '',
     *    'gender' => '',
     *    'tel' => '',
     *    'email' => '',
     *    'weixinid' => '',
     * );
     * @encode
     */
    public function update_member($user_info)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/user/update?access_token=%s";
        $url = sprintf($host, $this->get_accesstoken());
	    $info = \Core\Curl::post($url, json_encode($user_info));
	    $respone = json_decode($info->response , true);
	    if (isset($respone['errcode']) && $respone['errcode'] == '0')
	    {
	        return TRUE;
	    }
	    return FALSE;
    }
    
    /**
     * 删除用户
     * @param string $user_number
     */
    public function delete_member($user_number)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/user/delete?access_token=%s&userid=%s";
        $url = sprintf($host, $this->get_accesstoken(), $user_number);
	    $info = \Core\Curl::delete($url);
	    $respone = json_decode($info->response , true);
	    if (isset($respone['errcode']) && $respone['errcode'] == '0')
	    {
	        return TRUE;
	    }
	    return FALSE;
    }
    
    /**
     * 获取用户信息
     * @param string $user_number
     */
    public function get_member($user_number)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/user/get?access_token=%s&userid=%s";
        $url = sprintf($host, $this->get_accesstoken(), $user_number);
	    $info = \Core\Curl::get($url);
	    $respone = json_decode($info->response , true);
	    if (isset($respone['name']))
	    {
	        return $respone;
	    }
	    return FALSE;
    }
    
    /**
     * 获取未关注用户
     * @param int $department_id
     * @param int $fetch_child
     */
    public function get_unfollow_members($department_id = 1, $fetch_child = 1)
    {
        $host = "https://qyapi.weixin.qq.com/cgi-bin/user/list?access_token=%s&department_id=%s&fetch_child=%s";
        $url = sprintf($host, $this->get_accesstoken(), $department_id, $fetch_child);
	    $info = \Core\Curl::get($url);
	    $respone = json_decode($info->response , true);
	    if (isset($respone['userlist']))
	    {
	        return $respone;
	    }
	    return FALSE;
    }
}