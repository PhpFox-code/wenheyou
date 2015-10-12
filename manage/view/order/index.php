<?php $status = \Core\URI::kv('status')?>
<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="row">
  		<div class="col-md-4 pull-left">
  			<div class="input-group">
        	<span class="add-on input-group-addon">
        		<i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
        	</span>
        	<input type="text" readonly name="reservation" id="reservation" class="form-control" value="<?php echo urldecode(\Core\URI::kv('reservation'))?>" placeholder="选择时间范围" /> 
        	<span id="range" class="button btn-default input-group-addon">确定</span>
        	</div>
  		</div>
	  	<div class="col-md-4 pull-right">
	      <form id="search" method="get" action="<?php echo \Core\URI::a2p(array('order'=>'search'))?>" style="margin:0px;">
	  	    <div class="input-group">
			      <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
			      <input id="order_id" class="form-control" name="order_id" value="<?php $order_id = \Core\URI::kv('order_id'); if(!empty($order_id)){echo $order_id;}?>" type="text" placeholder="订单号 / 手机号码">
	          <a href="<?php echo \Core\URI::a2p(array('order'=>'index'))?>" class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></a> 
			 		</div>
	      </form>
		</div>
	</div> 
  </div>

  <div class="panel-body" style="padding: 0px; overflow-y: hidden;">
	 <table class="table table-bordered table-striped" id="thetable">
      <thead>
        <tr style="line-height:30px;">
          <th>交易订单号</th>
          <th>总数</th>
          <th>下单时间</th>
          <th>收货姓名</th>
          <th>收货电话</th>
          <th>商品价格</th>
          <th>订单状态</th>
          <th>是否支付</th>
          <th>配送地址</th>
          <th>是否催单</th>
          <th>合计</th>
          <th>操作</th>
        </tr>
      </thead>
      <tbody>
      	<?php foreach ($this->rows as $row):?>
            <?php if( \Core\URI::kv('active') == 'queue' && W_START_TIME - 3600*5  > $row->create_time):?>	
            <tr class="order_item doing" data_id=<?php echo $row->order_id?>>
            <?php elseif($row->hurry_status == 1):?>	
            <tr class="order_item warn" data_id=<?php echo $row->order_id?>>
            <?php else:?>
            <tr class="order_item" data_id=<?php echo $row->order_id?>>
            <?php endif;?>
          <td><?php echo $row->order_id?></td>
          <td><?php echo $row->order_nums?></td>
          <td><?php echo date('Y-m-d H:i',$row->create_time)?></td>
          <td><?php echo $row->user_name?></td>
          <td><?php echo $row->user_mobile?></td>
          <td><?php echo $row->order_amount?></td>
          <td><?php echo $row->get_status()?></td>
          <td><?php echo $row->pay_status == 1 ? '是': '否'?></td>
          <td style="width:150px"><?php echo $row->address_area.$row->address_street?></td>
          <td><?php echo $row->hurry_status ? '是' : '否'?></td>
          <td><?php echo $row->total_amount?></td>
          <td>
			      <?php if(\Core\URI::kv('active') == 'wait_confirm'):?>
			      	<button data_id=<?php echo $row->order_id?> type="button" class="btn btn-default destory btn-sm" ><span class="glyphicon glyphicon-trash"></span> 作废</button>
			      <?php elseif(\Core\URI::kv('active') == 'queue'):?>
			      		<div class="btn-group" role="group">
							<button data_id=<?php echo $row->order_id?> type="button" class="btn btn-default destory btn-sm" ><span class="glyphicon glyphicon-trash"></span> 作废</button>
							<button data_id=<?php echo $row->order_id?> type="button" class="btn btn-default confirm btn-sm" ><span class="glyphicon glyphicon-ok"></span> 确认</button>
						</div>
						<?php elseif(\Core\URI::kv('active') == 'check'):?>
							<button data_id=<?php echo $row->order_id?> type="button" class="btn btn-default release btn-sm" ><span class="glyphicon glyphicon-ok"></span> 配送</button>
						<?php elseif(\Core\URI::kv('active') == 'release'):?>
							<button data_id=<?php echo $row->order_id?> type="button" class="btn btn-default success btn-sm" ><span class="glyphicon glyphicon-ok"></span> 完成</button>
						<?php elseif(\Core\URI::kv('active') == 'wait_refund'):?>
							<button data_id=<?php echo $row->order_id?> type="button" class="btn btn-default refund btn-sm" ><span class="glyphicon glyphicon-ok"></span> 退款</button>
						<?php endif;?>
          </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
  </div>
  <div class="panel-footer">
  	<?php echo $this->page?>
  </div>
</div>

<div class="modal fade">
  <div class="modal-dialog" style="margin-top: 150px;">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title">商品详情</h4>
      </div>
      <div class="modal-body" style="padding: 10px;">
      	
      </div>
      <div class="modal-footer" style="margin-top: 0px;">
        <button type="button" class="btn btn-default" data-dismiss="modal">关闭</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$(function(){
  document.onkeydown = function(e){ 
      var ev = document.all ? window.event : e;
      if(ev.keyCode==13) {
        var search = $("#search");
        if ($("#order_id").val().length != 0)
        {
           search.submit();
        }
      }
  }
  
  $(".order_item").dblclick(function(){
  	var order = $(this).attr('data_id');
  	$.post('/manage/order/get', {'id':order}, function(rs){
  		if(rs.code != 0)
			{
				$(".modal-body").html(rs.message);
			}
			else
			{
				$(".modal-body").html(rs.data);
			}
  	}, 'json')
  	$(".modal").modal('show')
  })
  
  
	$(".destory").click(function(){
		var order_id = $(this).attr('data_id');
		$.post('/manage/order/destory', {'id':order_id}, function(rs){
			if(rs.code != 0)
			{
				alert(rs.message);
			}
			else
			{
				window.location.reload();
			}
		}, 'json');
	})
	
	$(".confirm").click(function(){
		var order_id = $(this).attr('data_id');
		$.post('/manage/order/confirm', {'id':order_id}, function(rs){
			if(rs.code != 0)
			{
				alert(rs.message);
			}
			else
			{
				window.location.reload();
			}
		}, 'json');
	})

	$(".release").click(function(){
		var order_id = $(this).attr('data_id');
		$.post('/manage/order/release', {'id':order_id}, function(rs){
			if(rs.code != 0)
			{
				alert(rs.message);
			}
			else
			{
				window.location.reload();
			}
		}, 'json');
	})
	
	$(".success").click(function(){
		var order_id = $(this).attr('data_id');
		$.post('/manage/order/success', {'id':order_id}, function(rs){
			if(rs.code != 0)
			{
				alert(rs.message);
			}
			else
			{
				window.location.reload();
			}
		}, 'json');
	})
	
	$(".refund").click(function(){
		var order_id = $(this).attr('data_id');
		$.post('/manage/order/refund', {'id':order_id}, function(rs){
			if(rs.code != 0)
			{
				alert(rs.message);
			}
			else
			{
				window.location.reload();
			}
		}, 'json');
	})
		
	$("#destory").click(function(){
		$("#message").show().html("正在提交...");
		var ids = '';
		$(".order_item.active").each(function(){
			ids += $(this).attr('data_id')+'-';
		})
		ids = ids.substr(0,ids.length-1)
		$.post('/manage/order/destory', {'ids':ids}, function(data){
			window.location.reload();
		}, 'json')
	});
	
	
	$('#thetable').tableScroll({
		height:$(window).height() - 400,
		width:'100%'
	});
	


  $('#reservation').daterangepicker(null, function(start, end, label) {
    console.log(start.toISOString(), end.toISOString(), label);
  });
  
  $('#range').click(function(){
  	
  	window.location.href="/manage/order/index/active/<?php echo \Core\URI::kv('active')?>/reservation/"+$('#reservation').val();
  	
  })
  
	
<?php if(\Core\URI::kv('active') == 'queue'):?>
function reload()
{
   window.location.reload();
}
setTimeout(reload, 30000) //单位毫秒

<?php endif;?>  


});  



</script>