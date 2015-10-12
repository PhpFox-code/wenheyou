<?php
namespace Controller;

class Goods extends \Model\Authorize\Admin
{
    public function initialize()
    {
    	parent::initialize();
        $this->view = view('layouts/main.php');
    }
    
    /**
     * 列表
     */
    public function index()
    {
        \Core\View::css('/manage/tablescroll/css/style.css');
        \Core\View::script('/manage/tablescroll/js/jquery.tablescroll.js');
        $this->view->content = view('goods/index.php');
        $rows = \DB\Mall\Goods::fetch(null, 0, 0, array('goods_order'=>'desc'));
        $data = array();
        foreach ($rows as $row)
        {
            $data[$row->store_id][] = $row;
        }
        $this->view->content->data = $data;
        //dump($data);exit();
    }
    
    /**
     * 添加视图
     */
    public function add()
    {
    	\Core\View::script('/manage/js/ajaxfileupload.js');
    	\Core\View::script('/manage/editor/js/libs/beautify/beautify-html.js');
        \Core\View::script('/manage/editor/js/froala_editor.min.js');
        \Core\View::script('/manage/editor/js/plugins/tables.min.js');
        \Core\View::script('/manage/editor/js/plugins/colors.min.js');
        \Core\View::script('/manage/editor/js/plugins/fonts/fonts.min.js');
        \Core\View::script('/manage/editor/js/plugins/fonts/font_family.min.js');
        \Core\View::script('/manage/editor/js/plugins/block_styles.min.js');
        \Core\View::script('/manage/editor/js/plugins/fonts/font_size.min.js');
        \Core\View::script('/manage/editor/js/plugins/video.min.js');
        \Core\View::css('/manage/editor/css/font-awesome.min.css');
        \Core\View::css('/manage/editor/css/froala_editor.min.css');
        \Core\View::css('/manage/editor/css/froala_reset.min.css');
        
        $this->view->content = view('goods/add.php');
    }
    
    /**
     * 保存
     */
    public function save()
    {
        $goods_pic = \Core\URI::kv('ajax_image');   
//        $category_name = \Core\URI::kv('category_name');   
        $store_id = \Core\URI::kv('store_id', 0);   
        $goods_name = \Core\URI::kv('goods_name');   
        $goods_order = \Core\URI::kv('goods_order', 1);
        $goods_profile = \Core\URI::kv('goods_profile'); 
        $category_id = \Core\URI::kv('category_id'); 
        $goods_content = \Core\URI::kv('goods_content');    
        $goods_discount_price = abs(intval(\Core\URI::kv('goods_discount_price')));       
        $goods_original_price = abs(intval(\Core\URI::kv('goods_original_price')));    
        $is_recommend = \Core\URI::kv('is_recommend', 0);       
        $count_star = \Core\URI::kv('count_star', 0);       
        $v = new \Core\Validation();
        $v->required($goods_pic)->message('图片不能为空');
        $v->required($goods_name)->message('商品名称不能为空');
        $v->filter_var($goods_discount_price >= 1)->message('商品价格不能小于1元');
        $v->filter_var($goods_original_price >= 1)->message('挂牌价格不能小于1元');
        $v->required($goods_content)->message('商品详情不能为空');
        if (!$v->has_error())
        {
            $goods_id = \Core\URI::kv('goods_id', null);
            $link = new \DB\Mall\Goods($goods_id);
            $link->goods_pic = $goods_pic;
            $link->category_id = $category_id;
            $link->store_id = $store_id;
            $link->goods_name = $goods_name;
            $link->goods_order = $goods_order;
            $link->goods_profile = $goods_profile;
            $link->goods_content = $goods_content;
            $link->goods_discount_price = $goods_discount_price;
            $link->goods_original_price = $goods_original_price;
            $link->create_time = W_START_TIME;
            $link->is_recommend = $is_recommend;
            $link->count_star = $count_star;
            $link->goods_status = 0;
            $link->save();
        }
		echo json_encode($v->get_error());exit();
    }

    /**
     * 获取某列数据
     */
	public function get()
	{
    	\Core\View::script('/manage/js/ajaxfileupload.js');
    	\Core\View::script('/manage/editor/js/libs/beautify/beautify-html.js');
        \Core\View::script('/manage/editor/js/froala_editor.min.js');
        \Core\View::script('/manage/editor/js/plugins/tables.min.js');
        \Core\View::script('/manage/editor/js/plugins/colors.min.js');
        \Core\View::script('/manage/editor/js/plugins/fonts/fonts.min.js');
        \Core\View::script('/manage/editor/js/plugins/fonts/font_family.min.js');
        \Core\View::script('/manage/editor/js/plugins/block_styles.min.js');
        \Core\View::script('/manage/editor/js/plugins/fonts/font_size.min.js');
        \Core\View::script('/manage/editor/js/plugins/video.min.js');
        \Core\View::css('/manage/editor/css/font-awesome.min.css');
        \Core\View::css('/manage/editor/css/froala_editor.min.css');
        \Core\View::css('/manage/editor/css/froala_reset.min.css');
        
	    $goods_id = \Core\URI::kv('id');
        $v = new \Core\Validation();
        $v->required($goods_id)->message('参数错误');
        
        if(!$v->has_error())
        {
            $this->view->content = view('goods/get.php');
            $this->view->content->data = new \DB\Mall\Goods($goods_id);;
        }
	}
	
    /**
     * 更改商品状态
     */
    public function status()
    {
        $ids = \Core\URI::kv('ids');   
		$status = \Core\URI::kv('status', 0);   
        $v = new \Core\Validation();
        $v->required($ids)->message('参数不合法');
        if (!$v->has_error())
        {
            $id_arr = explode('-', $ids);
			foreach($id_arr as $id)
			{
	            $item = \Db\Mall\Goods::row(array('goods_id'=>$id));
	            if(!empty($item))
	            {
	                $item->goods_status = $status;
	                $item->update();
	            }
			}
        }
        echo json_encode($v->get_error());exit();
    }
    
    /**
     * 删除友情连接
     */
    public function delete()
    {
        $ids = \Core\URI::kv('ids');
        $v = new \Core\Validation();
        $v->required($ids)->message('参数错误');
        
        if(!$v->has_error())
        {
        	$id_arr = explode('-', $ids);
			foreach($id_arr as $id)
			{
	            $goods = new \DB\Mall\Goods($id);
	            $goods->delete();
			}
        }
        echo json_encode($v->get_error());exit();
    }
    
    /**
     * 输出视图
     */
    public function send()
    {
        echo $this->view;
    }
}