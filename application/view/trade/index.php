<form action="">
	<div class="personal_address send_detail">
		<dl class="table_view">
			<dt>配送金额</dt>
			<dd>
				<ul>
					<li class="item">
						<a class="rect">
							<label>
								<textarea id="money_textarea" disabled="disabled" style="width:100%;" rows="4" value="" placeholder="1公里免费, 2公里5元 , 3公里10元 , 4公里15 , 5公里20,6公里累加10元,1公里免费, 2公里5元 , 3公里10元 , 4公里15 , 5公里20,6公里累加10元"></textarea>
								<div  style="display: block;">
									<input type="radio" name="pay_type" value="1">
								</div>
							</label>
						</a>
					</li>
				</ul>
			</dd>
			<!-- <dt>支付方式</dt>
			<dd>
				<ul>
					<li class="item">
						<a class="rect">
							<label>微信支付
							<div>
								<input type="radio" name="pay_type" value="0">
							</div>
							</label>
						</a>
					</li>
					<li class="item">
						<a class="rect">
							<label>
								现金支付（货到付款）
								<div>
									<input type="radio" name="pay_type" value="1">
								</div>
							</label>
						</a>
					</li>
				</ul>
			</dd> -->
			<dt>配送时间</dt>
			<dd>
				<ul>
					<li class="item">
						<a class="rect">
							<label>
								尽快送达
								<div>
									<input type="radio" name="change_time" value="0">
								</div>	
							</label>
						</a>
					</li>
					<li class="item send_time arrow">
						<a class="rect">
							<label for="change_time">
								预约
								<div>
									<input type="radio" name="change_time" id="change_time" value="1">
								</div>
							</label>
							<kbd>
								<select class="select" id="pick_time_picker" dir="rtl">
									<option value="<?php echo 60*30; ?>">30分钟后</option>
									<option value="<?php echo 60*60; ?>">1个小时后</option>
									<option value="<?php echo 60*90; ?>">1.5小时后</option>
									<option value="<?php echo 60*120; ?>">2个小时后</option>
									<option value="<?php echo 60*150; ?>">2.5小时后</option>
									<option value="<?php echo 60*180; ?>">3个小时后</option>
								</select>
								<input type="hidden" name="pick_time" id="pick_time" value="">
							</kbd>
						</a>
					</li>
				</ul>
			</dd>
			<dt>配送地址</dt>
			<dd class="send_massage">
				<ul>
					<?php foreach ($this->address as $row):?>
						<li class="item">
							<a class="rect">
								<label>
									<p><?php echo $row->address_province.$row->address_city.$row->address_area.$row->address_street?></p>
									<i></i>
									<span><?php echo $row->user_mobile?></span><span><?php echo $row->user_name?></span>
									<div>
										<input type="radio" name="address_id" value="<?php echo $row->address_id; ?>" data-default="<?php echo($row->is_default ? 1 : 0); ?>">
									</div>
								</label>
							</a>
						</li>
					<?php endforeach;?>
					<li class="item new_address" id="new_address">
						<a class="rect" href="<?php echo \Core\URI::a2p(array('address'=>'create','ref'=>'cart'))?>">
							<label>添加新地址</label>
						</a>
					</li>
				</ul>
			</dd>
			<dt>备注</dt>
			<dd class="send_remark">
				<ul>
					<li class="item">
						<a class="rect">
							<textarea name="order_remark" id="order_remark" placeholder="(选填)"></textarea>
						</a>
					</li>
				</ul>
			</dd>
		</dl>
		<div class="detail_button">
			<input type="hidden" name="id" value="<?php echo \Core\URI::kv('id',0); ?>">
			<input type="hidden" name="nums" value="<?php echo \Core\URI::kv('nums',0); ?>">
			<button class="submit" type="submit">
				提交订单
			</button>
			<div class="button_money">
				<div class="pay_num">
					<h1>应付金额：</h1><p>¥<kbd><?php echo $this->count['total_fee']?></kbd></p>
				</div>
			</div>
		</div>
	</div>
</form>
<script type="text/javascript">
	require(['init'], function(){
		$("input[name='pay_type']").on("click",function(){
			$(this).closest('div').show().closest('li').siblings().find('div').hide();
			Cute.Cookie.set('last_pay_type', $(this).val());
		});
		$("input[name='change_time']").on("click",function(e){
			$(this).closest('div').show().closest('li').siblings().find('div').hide();
			$('#pick_time').val('');
			Cute.Cookie.set('last_pick_time', '');
		});
		$("input[name='address_id']").on("click",function(event){
			$(this).closest('div').show().closest('li').siblings().find('div').hide();
		}).filter('[data-default=1]').trigger('click');
		$('#order_remark').on('blur', function(){
			Cute.Cookie.set('last_order_remark', $(this).val());
		});
		$('.send_time .rect').on('click', function(){
			$('#pick_time_picker', this).trigger('click').trigger('focus');
		});
		$('#pick_time_picker').on('click', function(){
			$(this).closest('li').find("input[name='change_time']").trigger('click');
			var seconds = $(this).val() * 1000;
			var date = Cute.Date.format(new Date((new Date().getTime()) + seconds),'yyyy-MM-dd hh:mm');
			$('#pick_time').val(date);
			Cute.Cookie.set('last_pick_time', $(this).val());
		});

		if(Cute.Cookie.get('last_pay_type')){
			$("input[name='pay_type'][value=" + Cute.Cookie.get('last_pay_type') + ']').trigger('click');
		}else{
			$("input[name='pay_type']").eq(0).trigger('click');
		}
		if(Cute.Cookie.get('last_pick_time')){
			$('#pick_time_picker').val(Cute.Cookie.get('last_pick_time')).trigger('click');
		}else{
			$("input[name='change_time']").eq(0).trigger('click');
		}
		if(Cute.Cookie.get('last_order_remark')){
			$('#order_remark').val(Cute.Cookie.get('last_order_remark'));
		}

		$('form').on("submit",function(e){
			e.preventDefault();
			var address_id,pay_type,pick_time,order_remark;
			Cute.api.post("/trade/confirm", $(this).serialize(), function(json){
				if (json.code == 0) {
					location.href='/trade/order?id=' + json.data;
				}else{
					alert(json.message);
				}
			});
		});
	});
</script>