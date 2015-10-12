<?php
namespace Controller;
/**
 * 个人地址管理
 * @author Yuwenc
 *
 */
class Address extends \Model\Authorize\Oauth
{
	public function initialize()
    {
    	parent::initialize();
    	$this->view = view('layout/index.php');
        $this->user = \Model\Authorize\Oauth::login_user();
        \Core\View::$title = '文和友老长沙外卖';
    }
    
    /**
     * 列表
     */
    public function index()
    {
    	//\Core\View::$title = '我的地址';
        $this->view->content = view('address/index.php');
        $this->view->content->rows = \DB\Account\Address::fetch(array('user_id'=>$this->user->user_id));
    }
    
    public function create()
    {
    	//\Core\View::$title = '添加地址';
    	$this->view->content = view('address/create.php');
    }
    
    public function update()
    {
    	//\Core\View::$title = '更新地址';
        $id = \Core\URI::kv('id');
        $this->view->content = view('address/update.php');
        $this->view->content->row = \DB\Account\Address::row(array('user_id'=>$this->user->user_id, 'address_id'=>$id));
    }
    
    /**
     * 保存
     */
    public function save()
    {  
        $user_name = \Core\URI::kv('user_name');   
        $user_mobile = \Core\URI::kv('user_mobile');
        $address_province = \Core\URI::kv('address_province');  
        $address_city = \Core\URI::kv('address_city');   
        $address_area = \Core\URI::kv('address_area');   
        $address_street = \Core\URI::kv('address_street');   
        $is_default = \Core\URI::kv('is_default', 1);   
        $v = new \Model\Validation();
        $v->required($user_name)->message('用户姓名不能为空', 1000);
        $v->required($user_mobile)->message('用户手机号码不能为空', 1000);
        $v->filter_var(preg_match('/^1[34578]\d{9}$/', $user_mobile) > 0)->message('手机号码不正确', 1000);
        $v->required($address_province)->message('省份不能为空', 1000);
        $v->required($address_city)->message('城市不能为空', 1000);
        $v->required($address_area)->message('区域不能为空', 1000);
        $v->required($address_street)->message('街道地址不能为空', 1000);
        if (!$v->has_error())
        {
        	if(!empty($is_default))
        	{
        		\DB\Account\Address::rollback_status($this->user->user_id);
        	}
            $address_id = \Core\URI::kv('id', null);
            $model = new \DB\Account\Address($address_id);
            $model->user_id = $this->user->user_id;
            $model->user_name = $user_name;
            $model->user_mobile = $user_mobile;
            
            $model->address_province = $address_province;
            $model->address_city = $address_city;
            $model->address_area = $address_area;
            $model->address_street = $address_street;
            $model->is_default = 1;
            $model->save();
        }
        $v->send();
    }

    /**
     * 改变状态
     */
	public function set_default()
	{
	    $address_id = \Core\URI::kv('id');
        $v = new \Model\Validation();
        $v->required($address_id)->message('参数错误', 1000);
        
        if(!$v->has_error())
        {
        	$address = \DB\Account\Address::row(array('address'=>$address_id, 'user_id'=>$this->user->user_id));
        	$v->required($address)->message('地址不存在', 1000);
        	if(!$v->has_error())
        	{
        		\DB\Account\Address::rollback_status($this->user->user_id);
        		$address->is_default = 1;
        		$address->update();
        	}
        }
        $v->send();
	}
    
    /**
     * 删除地址
     */
    public function delete()
    {
        $ids = \Core\URI::kv('ids');
        $v = new \Model\Validation();
        $v->required($ids)->message('参数错误', 1000);
        
        if(!$v->has_error())
        {
        	$id_arr = explode('-', $ids);
			foreach($id_arr as $id)
			{
	            $model = new \DB\Account\Address($id);
	            $model->delete();
			}
			// 查看是否还有默认地址
			$row = \DB\Account\Address::row(array('user_id'=>$this->user->user_id, 'is_default'=>1));
			if(empty($row))
			{
				// 如果没有默认地址，重新设置最后一个地址为默认地址
				$row = \DB\Account\Address::row(array('user_id'=>$this->user->user_id), array('create_time'=>'desc'));
				if($row)
				{
					$row->is_default = 1;
					$row->save();
				}
			}
        }
       $v->send();
    }
    
    /**
     * 输出视图
     */
    public function send()
    {
        echo $this->view;
    }
}