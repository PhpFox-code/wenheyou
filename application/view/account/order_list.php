<form action="">
	<div class="my_books_content">
		<ul class="base_goods_list my_books">
			<?php foreach ($this->rows as $row):?>
			<li class="item">
			 	<a style="display: block;" href="<?php echo \Core\URI::a2p(array('trade'=>'order', 'id'=>$row->order_id))?>">
				<div class="goods">
					<?php $cart = unserialize($row->cart_text);?>
    				<img src="<?php echo \Core\URI::a2p(array('image'=>'get'))?>?path=<?php echo $cart[0]->goods->goods_pic?>&size=180-180">
    				<div class="goods_detail">
    					<h2>订单号：<?php echo $row->order_id?></h2>
    					<div class="goods_level">
                            <h4>¥<?php echo $row->total_amount?></h4>
    						<h2><?php echo $row->get_status()?></h2>
    					</div>
    					<div class="goods_price">
    						<h2><?php echo date('Y-m-d H:i:s', $row->create_time)?></h2>
    					</div>
    				</div>
    			</div>
    			</a>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
</form>
<a class="my_center" href="/account/index"></a>