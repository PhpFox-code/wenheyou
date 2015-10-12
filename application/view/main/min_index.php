<div class="min_index">
	<div class="min_index_cover">
		<a href="javascript:;"></a>
	</div>
	<div class="index_banner swiper-container">
		<ul class="swiper-wrapper">
			<?php foreach ($this->rows as $row):?>
			<li class="swiper-slide" id="goods_<?php echo $row->goods_id?>">
				<form action="/trade/index" method="get">
					<a href="<?php echo \Core\URI::a2p(array('main'=>'get', 'id'=>$row->goods_id));?>">
						<div class="index_img main_image">
							<img src="<?php echo \Core\URI::a2p(array('image'=>'get'))?>?path=<?php echo $row->goods_pic?>&size=650-400">
							<div>
								<p>¥<em><?php echo $row->goods_discount_price?></em></p>
								<h4><?php echo $row->goods_name?></h4>
							</div>
						</div>
					</a>
	    			<div class="detail_button">
	    					<input type="hidden" name="id" value="<?php echo $row->goods_id?>">
		    				<button class="submit true_pay" type="submit">快速下单</button>
							<div class="goods_count">
								<div class="count">
									<a href="javascript:;" class="dec"><div></div></a>
									<input type="text" name="nums" value="<?php echo !empty($init_nums->goods_nums) ? $init_nums->goods_nums : 0;?>">
									<a href="javascript:;" class="inc"><div></div></a>
								</div>
							</div>
		    				<div class="button_money">
		    					<div class="pay_num">
		    						<p>¥<kbd>0</kbd></p>
		    					</div>
		    				</div>
	    			</div>
				</form>
			</li>
			<?php endforeach;?>
		</ul>
		<div class="swiper-pagination"></div>
	</div>
	<div class="personally_btn">
		<a href="<?php echo \Core\URI::a2p(array('main'=>'tab2'))?>"></a>
	</div>
</div>
<a class="my_center" href="/account/index"></a>
<script type="text/javascript">
	require(['init','swiper'], function(){
		$(".min_index_cover").click(function(){
			$(".min_index_cover").css("display","none");
		});
		var swiper = new Swiper('.swiper-container', {
    		slidesPerView: 1,
	        pagination: '.swiper-pagination',
	        paginationClickable: false,
        	loop: true
	    });
	    $(document).off('click','.count .dec').on("click",".count .dec",function(){
	        var input = $(this).closest('.count').find('input');
	        var form = $(this).closest('form');
	        var price = parseFloat($('.main_image p em', form).html());
	        var n = parseInt(input.val()) - 1;
	        if(n <= 0){
	        	n = 0;
	        }
	        input.val(n);
	        input[0].defaultValue = $(this).val();
	        $('.pay_num kbd',form).html(price * n);
	    }).off('click','.count .inc').on("click",".count .inc",function(){
	        var input = $(this).closest('.count').find('input');
	        var form = $(this).closest('form');
	        var price = parseFloat($('.main_image p em', form).html());
	        var n = parseInt(input.val()) + 1;
	        input.val(n);
	        console.log(price * n);
	        input[0].defaultValue = n;
	        $('.pay_num kbd',form).html(price * n);
	    }).off('click','.count input').on("blur",".count input",function(){
	        var re = /\d+$/gi;
	        var form = $(this).closest('form');
	        var price = parseFloat($('.main_image p em', form).html());
	        if(re.test($(this).val())){
	        	this.defaultValue = $(this).val();
	        	$('.pay_num kbd',form).html(price * n);
	        }else{
	            $(this).val(function(){
	                return this.defaultValue;
	            });
	        }
	    });
	    $('.index_banner').on('submit','form', function(){
	    	if(parseInt($('input[name=nums]', this).val()) <= 0){
	    		alert('请选择下单数量！');
	    		return false;
	    	}
	    });
	});
</script>