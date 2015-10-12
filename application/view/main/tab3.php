
	<div class="index_crap index">
		<div class="crap_main">
			<?php echo view('main/menu.php');?>
			<div class="crap_content">
				<ul id="goodsList" class="base_goods_list">
					
				</ul>
    			<div class="pager">
    				<a href="javascript:void(0)">点击加载更多</a>
    			</div>
			</div>
		</div>
		<div class="detail_button">
			<a href="<?php echo \Core\URI::a2p(array('cart'=>'index'))?>" class="submit">
				<i title="<?php echo $this->count['total_nums']?>"><?php echo $this->count['total_nums']?></i>
				<span></span>购物车
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
			var next_page = 1;
			$('.pager a').on('click', function(e){
				var that = this;
				var cb = arguments.callee;
				$(this).off('click').text('努力加载中...');
				Cute.api.get('/main/tab3_part',{page:next_page, store:'all', sort:'0'}, function(json){
					if(json.message == ''){
						$("#goodsList").append(json.data);
						$(that).on('click', cb).text('点击查看更多');
					}else{
						$(that).text(json.message);
					}
					next_page++;
				});
			}).trigger('click');
		});
	</script>