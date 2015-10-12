<?php foreach ($this->rows as $row):?>
<li id="goods_<?php echo $row->goods_id?>">
	<div class="goods">
		<a class="thumb" href="<?php echo \Core\URI::a2p(array('main'=>'get', 'id'=>$row->goods_id));?>">
			<img src="<?php echo \Model\Common::get_upload_url($row->goods_pic,160,160)?>">
		</a>
		<div class="goods_detail">
			<a href="<?php echo \Core\URI::a2p(array('main'=>'get', 'id'=>$row->goods_id));?>">
				<h3>
					<?php if($row->is_recommend):?>
					<span></span>
					<?php endif;?>
					<?php echo $row->goods_name?>
				</h3>
			</a>
			<div class="goods_level">
			    <?php echo str_repeat('<span></span>', $row->count_star);?>
                <?php if($row->count_star < 5):?>
                	<?php echo str_repeat('<span class="level_null"></span>', 5-$row->count_star);?>
                <?php endif;?>
			</div>
			<p><?php echo $row->goods_profile?></p>
			<div class="goods_price">
				<h4>¥<span><?php echo $row->goods_discount_price?></span></h4>
				<div class="count">
					<a href="javascript:;" class="dec"><div></div></a>
					<?php $init_nums = \Db\Trade\Cart::row(array('user_id'=>$this->user->user_id, 'goods_id'=>$row->goods_id));?>
					<input type="text"  value="<?php echo !empty($init_nums->goods_nums) ? $init_nums->goods_nums : 0;?>">
					<a href="javascript:;" class="inc"><div></div></a>
				</div>
			</div>
			<div></div>
		</div>
	</div>
</li>
<?php endforeach;?>