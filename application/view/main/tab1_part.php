<?php foreach ($this->rows as $row):?>
<li id="goods_<?php echo $row->goods_id?>">
	<a class="thumb" href="<?php echo \Core\URI::a2p(array('main'=>'get', 'id'=>$row->goods_id));?>">
		<div class="index_img">
			<img src="<?php echo \Model\Common::get_upload_url($row->goods_pic,450,200)?>">
			<p>
			¥<em><?php echo $row->goods_discount_price?></em>&nbsp;<del>&nbsp;原价：<?php echo $row->goods_original_price?>&nbsp;</del>
			</p>
		</div>
	</a>
	<div class="index_count">
		<div class="goods_count">
			<div class="count">
				<a href="javascript:;" class="dec"><div></div></a>
				<?php $init_nums = \Db\Trade\Cart::row(array('user_id'=>$this->user->user_id, 'goods_id'=>$row->goods_id));?>
				<input type="text" name="nums" value="<?php echo !empty($init_nums->goods_nums) ? $init_nums->goods_nums : 0;?>">
				<a href="javascript:;" class="inc"><div></div></a>
			</div>
		</div>
		<div class="goods_title">
			<a href="<?php echo \Core\URI::a2p(array('main'=>'get', 'id'=>$row->goods_id));?>">
				<h4>
				<?php if($row->is_recommend):?>
				<i></i>
				<?php endif;?>
				<?php echo $row->goods_name?>
				</h4>
			</a>
			<div class="goods_level">
			    <?php echo str_repeat('<span></span>', $row->count_star);?>
                <?php if($row->count_star < 5):?>
                	<?php echo str_repeat('<span class="level_null"></span>', 5-$row->count_star);?>
                <?php endif;?>
			</div>
		</div>
		<p><?php echo $row->goods_profile?></p>
	</div>
</li>
<?php endforeach;?>