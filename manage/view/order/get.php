<?php foreach($this->rows as $row):?>
<div class="clearfix" style="margin: 5px;">
	<img src="<?php echo $row->goods->goods_pic?>" style="display: block;float: left;width: 60px; height: 60px;"/>
	<span style="display: block;float: left; margin-left: 10px;">
		<?php echo $row->goods->goods_name?><br>
		数量：<?php echo $row->goods_nums?><br>
		价格：<?php echo $row->goods_discount_price?>
	</span>
</div>
<?php endforeach;?>