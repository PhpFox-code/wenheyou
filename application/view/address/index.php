<div class="personal_address">
	<dl class="table_view">
		<dd>
			<ul>
				<?php foreach ($this->rows as $row):?>
				<li class="item arrow">
					<a href="<?php echo \Core\URI::a2p(array('address'=>'update', 'id'=>$row->address_id))?>" class="rect">
						<p><?php echo $row->address_city.$row->address_area.$row->address_street?></p>
						<i></i><span><?php echo $row->user_mobile?></span><span><?php echo $row->user_name?></span>
					</a>
				</li>
				<?php endforeach;?>
				<li class="item new_address" id="new_address">
					<a class="rect" href="<?php echo \Core\URI::a2p(array('address'=>'create'))?>">
						<label>添加新地址</label>
					</a>
				</li>
			</ul>
		</dd>
	</dl>
</div>