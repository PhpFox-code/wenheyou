	<div class="personal_center">
		<dl class="base_dl">
			<dd>
				<ul class="base_list personal_center_detail">
					<li>
						<div class="personal_list">
							<img src="<?php echo $this->user->user_avatar?>">
							<div>
								<h3><?php echo $this->user->user_nickname?></h3>
								<p>我的积分<ins><?php echo $this->user->user_score?></ins></p>
							</div>
						</div>
					</li>
				</ul>
			</dd>
		</dl>
		<dl class="table_view">
			<dd>
				<ul class="pay_detail">
					<li class="item arrow">
	    				<a class="rect detail_change personal_books_num" href="<?php echo \Core\URI::a2p(array('account'=>'order_list'))?>">
	    					<label>我的订单</label>
	    					<ins><?php echo $this->order_nums?></ins>
	    				</a>
	    			</li>
	    			<li class="item arrow">
	    				<a class="rect detail_change personal_default_address" href="<?php echo \Core\URI::a2p(array('address'=>'index'))?>">
	    					<label>收货地址</label>
	    					<kbd><?php if(!empty($this->address)):?><?php echo $this->address->address_city.$this->address->address_area.$this->address->address_street;?><?php endif;?></kbd>
	    				</a>
	    			</li>
				</ul>
			</dd>
		</dl>
	</div>
