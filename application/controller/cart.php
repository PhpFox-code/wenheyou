<?php
namespace Controller;
/**
 * 购物车管理
 * @author Yuwenc
 *
 */
class Cart extends \Model\Authorize\Oauth
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
    	//\Core\View::$title = '我的购物车';
        $this->view->content = view('cart/index.php');
        $this->view->content->rows = \DB\Trade\Cart::fetch(array('user_id'=>$this->user->user_id));
        $this->view->content->count = \Db\Trade\Cart::count_cart($this->user->user_id);
    }
    
    /**
     * 保存
     */
    public function save()
    {  
        $goods_id = \Core\URI::kv('id');   
        $goods_nums = \Core\URI::kv('nums', 1);   
        $cart_status = \Core\URI::kv('status', 1);   
        $v = new \Model\Validation();
        $v->required($goods_id)->message('商品编号不能为空', 1000);
        $goods_nums = abs(intval($goods_nums));
        $v->filter_var($goods_nums > 0)->message('商品数量不能小于1', 1000);
        if (!$v->has_error())
        {
            $goods = \DB\Mall\Goods::row(array('goods_id'=>$goods_id, 'goods_status'=>1));
            $v->required($goods)->message('商品不存在', 1000);
            if(!$v->has_error())
            {
	            $model = \DB\Trade\Cart::row(array('user_id'=>$this->user->user_id, 'goods_id'=>$goods_id));
	            if($model)
	            {
	            	$model->goods_nums = $goods_nums;
	            	$model->goods_discount_price = $goods->goods_discount_price;
	            	$model->goods_original_price = $goods->goods_original_price;
	            	$model->create_time = W_START_TIME;
	            	$model->cart_status = $cart_status;
	            	$model->update();
	            }
	            else 
	            {
	            	$model = new \Db\Trade\Cart();
	            	$model->user_id = $this->user->user_id;
	            	$model->create_time = W_START_TIME;
	            	$model->goods_id = $goods_id;
	            	$model->goods_discount_price = $goods->goods_discount_price;
	            	$model->goods_original_price = $goods->goods_original_price;
	            	$model->goods_nums = $goods_nums;
	            	$model->cart_status = $cart_status;
	            	$model->insert();
	            }
	            $v->set_data(\Db\Trade\Cart::count_cart($this->user->user_id));
            }
        }
        $v->send();
    }

    /**
     * 改变状态
     */
	public function status()
	{
	    $ids = \Core\URI::kv('ids');
	    $status = \Core\URI::kv('status', 1);
        $v = new \Model\Validation();
        $v->required($ids)->message('参数错误', 1000);
        
        if(!$v->has_error())
        {
        	$id_arr = explode('-', $ids);
			foreach($id_arr as $id)
			{
	            $model = \DB\Trade\Cart::row(array('user_id'=>$this->user->user_id, 'goods_id'=>$id));
	            if($model)
	            {
	            	$model->cart_status = $status;
	            	$model->update();
	            }
			}
			$v->set_data(\Db\Trade\Cart::count_cart($this->user->user_id));
        }
        $v->send();
	}
    
    /**
     * 删除商品
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
	            $model = \DB\Trade\Cart::row(array('user_id'=>$this->user->user_id, 'goods_id'=>$id));
	            if($model)
	            {
	            	$model->delete();
	            }
			}
			$v->set_data(\Db\Trade\Cart::count_cart($this->user->user_id));
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