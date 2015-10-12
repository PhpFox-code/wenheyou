<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="javascript:history.go(-1);" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 取消</a>
	</div>

  </div>

  <div class="panel-body">
      <table class="table table-bordered table-striped" style="margin:0px;" id="thetable">
      <thead>
        <tr style="line-height:30px;">
          <th>交易订单号</th>
          <th>总数</th>
          <th>下单时间</th>
          <th>收货姓名</th>
          <th>收货电话</th>
          <th>商品价格</th>
          <th>是否支付</th>
          <th>配送地址</th>
          <th>是否催单</th>
          <th>合计</th>
          <th>订单状态</th>
        </tr>
      </thead>
      <tbody>
      <tbody class="full">

      </tbody>
    </table>
  </div>
  <div class="panel-footer" id="more" data-page="1" style="cursor: pointer;"></div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	function load(page)
	{
		$("#more").text('努力加载中...');
		$.post('/manage/user/record_part/user_id/<?php echo \Core\URI::kv('user_id')?>', {'page':page}, function(result){
			if(result.message == '')
			{
				$(".full").append(result.data)
				$("#more").text('点击查看更多');
			}
			else
			{
				$("#more").text(result.message);
			}
		}, 'json');
	}
	$("#more").click(function(){
	    var current_page = parseInt($(this).attr("data-page"))+1
	    $(this).attr("data-page", current_page);
		load(current_page);
	})
	load(1);
  $('#thetable').tableScroll({
    height:$(window).height() - 400,
    width:'100%'
  });
})
</script>