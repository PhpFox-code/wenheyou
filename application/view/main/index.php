<?php 
	$row = \DB\Mall\Slide::row(array(), array('slide_order'=>'desc'));
?>
	<div class="home" style="background-image:url(<?php echo $row->slide_pic?>);" onclick="window.location.href='<?php echo $row->slide_link?>'">
		<div class="home_main">
			<a href="/main/tab1" onclick="window.event? window.event.cancelBubble = true : e.stopPropagation();" class="btn_begin"></a>
<!-- 			<a href="<?php echo $row->slide_link?>" class="btn_detail">活动详情</a> -->
		</div>
	</div>
<script type="text/javascript">
		document.body.onload =  function(){
			setTimeout(function(){
				location.href = '/main/tab2';
			},5000);
		};
</script>