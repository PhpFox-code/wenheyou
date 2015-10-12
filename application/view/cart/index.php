<div class="shop_track">
	<div class="track_content">
		<?php if(!$this->rows){ ?>
		<p class="no_data">:( 您还什么都没有选呢！</p>
		<?php } ?>
		<ul class="track_list">
			<?php foreach ($this->rows as $row):?>
			<li id="goods_<?php echo $row->goods->goods_id?>">
				<div class="track_goods">
					<a class="track_img" href="<?php echo \Core\URI::a2p(array('main'=>'get', 'id'=>$row->goods_id));?>">
					<img src="<?php echo \Core\URI::a2p(array('image'=>'get'))?>?path=<?php echo $row->goods->goods_pic?>&size=180-180">
					</a>
					<div class="goods_detail">
						<a href=""><h3>
						<?php if($row->is_recommend):?>
						<span></span>
						<?php endif;?>
						<?php echo $row->goods->goods_name?></h3></a>
						<div class="goods_price">
							<h4>¥<span><?php echo $row->goods_discount_price*$row->goods_nums?></span></h4>
							<div class="count">
								<a href="javascript:;" class="dec"><div></div></a>
								<input type="text" value="<?php echo $row->goods_nums?>">
								<a href="javascript:;" class="inc"><div></div></a>
							</div>
						</div>
					</div>
				</div>
			</li>
			<?php endforeach;?>
		</ul>
	</div>
	<div class="detail_button">
		<a href="<?php echo \Core\URI::a2p(array('trade'=>'index'))?>" class="submit">
			立即下单
		</a>
		<div class="button_list">
			<div><a href="/main/min_index"></a></div>
		</div>
		<div class="button_money">
			<div class="pay_num">
				<h1>合计：</h1><p>¥<kbd><?php echo $this->count['total_fee']?></kbd></p>
			</div>
		</div>
	</div>
</div>
<a class="my_center" href="/account/index"></a>
<script type="text/javascript">
	require(['init'], function(){
		window.update_cart_cb = function(goods_id, num){
			if(num == 0){
				var goods = $('#goods_' + goods_id).fadeOut(500, function(){
					if($(this).siblings('li').length == 0){
						$('<p class="no_data">:( 您还什么都没有选呢！</p>').prependTo('.track_content');
					}
					$(this).remove(); 
				});
			}
		};
	});
</script>