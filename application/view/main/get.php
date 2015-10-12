	<div class="goods_detail index">
		<div class="index_main">
			<div class="index_content">
				<ul>
					<li id="goods_<?php echo $this->row->goods_id?>">
						<div class="index_img">
							<img src="<?php echo $this->row->goods_pic?>">
							<p>¥<em><?php echo $this->row->goods_discount_price?></em></p>
						</div>
						<div class="index_count">
							<div class="goods_count">
								<div class="count">
									<a href="javascript:;" class="dec"><div></div></a>
									<?php $init_nums = \Db\Trade\Cart::row(array('user_id'=>$this->user_id, 'goods_id'=>$this->row->goods_id));?>
									<input type="text" name="nums" value="<?php echo !empty($init_nums->goods_nums) ? $init_nums->goods_nums : 0;?>">
									<a href="javascript:;" class="inc"><div></div></a>
								</div>
							</div>
							<div class="goods_title">
								<?php if($this->row->is_recommend):?>
								<i></i>
								<?php endif;?>
								<h4><?php echo $this->row->goods_name?></h4>
							</div>
							<div class="goods_level">
							    <?php echo str_repeat('<span></span>', $this->row->count_star);?>
				                <?php if($this->row->count_star < 5):?>
				                	<?php echo str_repeat('<span class="level_null"></span>', 5-$this->row->count_star);?>
				                <?php endif;?>
							</div>
							<p><?php echo $this->row->goods_profile?></p>
						</div>
					</li>
				</ul>
				<div class="goods_detail_title">
					<span></span><p>商品详情</p><span></span>
				</div>
				<div class="detail_content">
					<?php echo $this->row->goods_content?>
				</div>
			</div>
		</div>
		<div class="detail_button">
			<a class="submit" href="<?php echo \Core\URI::a2p(array('cart'=>'index'))?>">
				<i title="<?php echo $this->count['total_nums']?>"><?php echo $this->count['total_nums']?></i>
				<span></span>下一步
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