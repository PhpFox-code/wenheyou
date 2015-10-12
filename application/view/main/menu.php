<div class="index_list">
	<div class="">
		<a <?php if(\Core\URI::part(1)=='tab1'):?>class="font_page"<?php endif;?> href="<?php echo \Core\URI::a2p(array('main'=>'tab1'))?>">
			<i class="combo"></i>
			<h3>套餐</h3>
		</a>
	</div>
	<div class="">
		<a <?php if(\Core\URI::part(1)=='tab2'):?>class="font_page"<?php endif;?> href="<?php echo \Core\URI::a2p(array('main'=>'tab2'))?>">
			<i class="cray"></i>
			<h3>主打菜</h3>
		</a>
	</div>
	<div class="">
		<a <?php if(\Core\URI::part(1)=='tab3'):?>class="font_page"<?php endif;?> href="<?php echo \Core\URI::a2p(array('main'=>'tab3'))?>">
			<i class="else"></i>
			<h3>特色小吃</h3>
		</a>
	</div>
</div>