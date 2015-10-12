<div class="content order_detail">
	<dl class="table_view">
		<dd>
			<ul>
    			<li class="item">
    				<a class="rect">
    					<label>订单号</label>
    					<kbd><?php echo $this->row->order_id?></kbd>
    				</a>
    			</li>
    			<li class="item">
    				<a class="rect"><label>订单状态</label>
    					<kbd><?php echo $this->row->get_status()?></kbd></a>
    			</li>
    			<?php if($this->row->order_status == 1):?>
    			<li class="item">
    				<a class="rect"><label>下单时间</label>
    					<kbd><?php echo date('Y-m-d H:i:s', $this->row->create_time)?></kbd>
    				</a>
    			</li>
    			<?php elseif($this->row->order_status == 2):?>
    			<li class="item">
    				<a class="rect"><label>订单确认时间</label>
    					<kbd><?php echo date('Y-m-d H:i:s', $this->row->confirm_time);?></kbd>
    				</a>
    			</li>
    			<?php elseif($this->row->order_status == 3):?>
    			<li class="item">
    				<a class="rect"><label>发货时间</label>
    					<kbd><?php echo date('Y-m-d H:i:s', $this->row->release_time);?></kbd>
    				</a>
    			</li>
    			<?php elseif($this->row->order_status ==4):?>
    			<li class="item">
    				<a class="rect"><label>已完成</label>
    					<kbd><?php echo date('Y-m-d H:i:s', $this->row->success_time);?></kbd>
    				</a>
    			</li>
    			<?php elseif($this->row->order_status ==5):?>
    			<li class="item">
    				<a class="rect"><label>作废时间</label>
    					<kbd><?php echo date('Y-m-d H:i:s', $this->row->destory_time);?></kbd>
    				</a>
    			</li>
    			<?php endif;?>
    			<li class="item">
    				<a class="rect"><label>支付方式</label> 
    					<kbd><?php echo $this->row->get_pay_type()?></kbd></a>
    			</li>
    			<li class="item">
    				<a class="rect"><label>地址</label>
    					<p><?php echo $this->row->address_province.$this->row->address_city.$this->row->address_area.$this->row->address_street?></p></a>
    			</li>
    			<li class="item">
    				<a class="rect"><label>联系人</label>
    					<kbd><?php echo $this->row->user_name?></kbd></a>
    			</li>
    			<li class="item">
    				<a class="rect"><label>联系电话</label>
    					<kbd><?php echo $this->row->user_mobile?></kbd></a>
    			</li>
    			<li class="item">
    				<a class="rect"><label>预约时间</label>
    					<kbd><?php echo $this->row->pick_time < W_START_TIME ? '尽快送达' : date('Y-m-d H:i:s', $this->row->pick_time);?></kbd>
    				</a>
    			</li>
    			<?php if(!empty($this->row->order_remark)):?>
    			<li class="item">
    				<a class="rect"><label>备注</label>
    					<kbd><?php echo $this->row->order_remark?></kbd></a>
    			</li>
    			<?php endif;?>
			</ul>
		</dd>
    	<dt>已选物品</dt>
    	<dd>
    	    <?php $cart = unserialize($this->row->cart_text);?>
    		<ul class="base_goods_list">
    			<?php foreach ($cart as $item):?>
    			<li class="item">
    				<a href="/main/get?id=<?php echo $item->goods->goods_id;?>">
	    				<div class="goods">
		    				<img src="<?php echo \Core\URI::a2p(array('image'=>'get'))?>?path=<?php echo $item->goods->goods_pic?>?size=180-180">
		    				<div class="goods_detail">
		    					<h3>
                                <?php if($item->goods->is_recommend):?>
                                <i></i>
                                <?php endif;?>
                                <?php echo $item->goods->goods_name?></h3>
		    					<div class="goods_level">
							    <?php echo str_repeat('<span></span>', $item->goods->count_star);?>
				                <?php if($item->goods->count_star < 5):?>
				                	<?php echo str_repeat('<span class="level_null"></span>', 5-$item->goods->count_star);?>
				                <?php endif;?>
		    					</div>
		    					<div class="goods_price">
		    						<h4>¥ <span><?php echo $item->goods_discount_price?></span></h4>
		    					</div>
		    				</div>
		    				<div class="goods_num">
		    					<span>×<h5><?php echo $item->goods_nums?></h5></span>
		    				</div>
		    			</div>
		    		</a>
    			</li>
    			<?php endforeach;?>
    		</ul>
    	</dd>
    	<dt>订单说明</dt>
    	<dd class="intro">
    		<ul>
    			<li class="item">
    				<div>
			    		<p>- 退换货规则说明退换货规则说明退换货规则说明退换货规则说明退换货规则说明</p>
			    		<p>- 卫生安全说明卫生安全说明卫生安全说明</p>
			    	</div>
    			</li>
    		</ul>
    	</dd>
    	<dd>
    		<?php if($this->row->order_status == 0 && $this->row->pay_type == 0 && $this->row->pay_status == 0):?>
    		<!-- 未确认订单可取消 -->
    		<div class="detail_button">
				<button class="submit " id="submit" type="button">立即支付</button>
				<div class="button_money">
					<div class="pay_num">
						<h1>应付金额：</h1><p>¥<kbd><?php echo $this->row->total_amount?></kbd></p>
					</div>
				</div>
			</div>
    		<!-- 商家未确认订单可取消 -->
    		<?php elseif($this->row->order_status == 1):?>
    		<!-- 未确认订单取消 -->
    		<div class="detail_button">
				<button class="submit " id="btn_cancel" type="button">取消订单</button>
				<div class="button_money">
					<div class="pay_num">
						<h1>实付金额：</h1><p>¥<kbd><?php echo $this->row->total_amount?></kbd></p>
					</div>
				</div>
			</div>
    		<!-- 未确认订单取消 -->
    		<?php elseif($this->row->order_status == 2):?>
    		<!-- 已确认订单催单 -->
    		<div class="detail_button">
    			<button class="submit button_pass button_sp" id="btn_quick" type="button">催单</button>
				<div class="button_money">
					<div class="pay_num">
						<h1>实付金额：</h1><p>¥<kbd><?php echo $this->row->total_amount?></kbd></p>
					</div>
				</div>
			</div>
    		<?php elseif($this->row->order_status == 3):?>
    		<!-- 配送中订单 -->
    		<div class="detail_button">
				<div class="pay_num pay_mark">
					<h1>配送中</h1>
				</div>
				<div class="button_money">
					<div class="pay_num">
						<h1>实付金额：</h1><p>¥<kbd><?php echo $this->row->total_amount?></kbd></p>
					</div>
				</div>
			</div>
    		<?php elseif($this->row->order_status == 4):?>
    		<!-- 已完成订单 -->
    		<div class="detail_button">
				<div class="pay_num pay_mark">
					<h1>已完成</h1>
				</div>
				<div class="button_money">
					<div class="pay_num">
						<h1>实付金额：</h1><p>¥<kbd><?php echo $this->row->total_amount?></kbd></p>
					</div>
				</div>
			</div>
    		<?php elseif($this->row->order_status == 5):?>
    		<!-- 已完成订单 -->
    		<div class="detail_button">
				<div class="pay_num pay_mark">
					<h1>已作废</h1>
				</div>
				<div class="button_money">
					<div class="pay_num">
						<h1>实付金额：</h1><p>¥<kbd><?php echo $this->row->total_amount?></kbd></p>
					</div>
				</div>
			</div>
    		<?php endif;?>
			<div class="fresh">
		    	<a href="<?php echo \Core\URI::a2p(array('trade'=>'order', 'id'=>$this->row->order_id));?>"></a>
		    </div>
    	</dd>
    </dl>
</div>
<script type="text/javascript">
require(['init'], function(){
	<?php if(!empty($this->jsApiParameters)):?>
	//调用微信JS api 支付
	function jsApiCall()
	{
		WeixinJSBridge.invoke(
			'getBrandWCPayRequest',
			<?php echo $this->jsApiParameters; ?>,
			function(res){
				WeixinJSBridge.log(res.err_msg);
				//alert(res.err_code+' '+res.err_desc+' '+res.err_msg);
				if(res.err_msg == 'get_brand_wcpay_request:ok')
				{
					Cute.Cookie.del('last_pay_type');
					Cute.Cookie.del('last_pick_time');
					Cute.Cookie.del('last_order_remark');
					window.location.href="<?php echo \Core\URI::a2p(array('trade'=>'success'));?>"
				}
				else
				{
					//alert(res.err_msg);
				}
				
			}
		);
	}

	function callpay()
	{
		if (typeof WeixinJSBridge == "undefined"){
		    if( document.addEventListener ){
		        document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		    }else if (document.attachEvent){
		        document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
		        document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		    }
		}else{
		    jsApiCall();
		}
	}
	$("#submit").click(function(){
		callpay();
	});
	<?php endif;?>
	
    $("#btn_cancel").click(function(e){
        Cute.api.post('/account/order_delete', {id:"<?php echo $this->row->order_id; ?>"},function(json){
            if(json.code == 0){
                alert('订单取消成功！');
                location.reload();
            }else{
                alert(json.message);
            }
        });
    });
    
    $("#btn_quick").click(function(e){
        Cute.api.post('/account/order_hurry', {id:"<?php echo $this->row->order_id; ?>"},function(json){
            if(json.code == 0){
                alert('催单成功，请耐心等待！');
                location.reload();
            }else{
                alert(json.message);
            }
        });
    });
    
})
</script>