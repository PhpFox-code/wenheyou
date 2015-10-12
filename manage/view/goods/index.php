<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a id="add" href="<?php echo \Core\URI::a2p(array('goods'=>'add'))?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> 添加</a>
  			<button id="edit" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-pencil"></span> 编辑</button>
  			<button id="up" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-upload"></span> 上架</button>
  			<button id="down" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-download"></span> 下架</button>
  			<button id="delete" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-minus"></span> 删除</button>
	</div>
  </div>
  <div class="panel-body" style="padding-top: 0px;" id="thetable">
  	<?php foreach($this->data as $key => $row):?>
  		<?php if($key ==0):?>
  		<div class="row slide">分店名称：无</div>
  		<?php else:?>
	  	<div class="row slide">分店名称：<?php  echo $this->data[0]->store->store_name?></div>
	  	<?php endif;?>
	  	<div class="row list">
	  		<?php foreach($row as $r):?>
			<div class="news pull-left" data_id =<?php echo $r->goods_id?>>
		      <img src="<?php echo $r->goods_pic?>" width="140px" height="140px"/>
		      <div class="caption">
		        <h5 style="padding-top:4px;"><?php echo mb_strimwidth($r->goods_name, 0, 18, '..', 'utf-8')?></h5>
	  			商品原价：¥<?php echo $r->goods_original_price ? $r->goods_original_price : 0.00 ?><br>
	  			销售价格：¥<?php echo $r->goods_discount_price ? $r->goods_discount_price : 0.00 ?><br>
	  			星级数量：<?php echo $r->count_star?><br>
	  			分类：<?php echo $r->category->category_name?><br>
		      </div>
			  <?php if($r->is_recommend == '1'):?>
			  <div class="recommend">
			  	<img src="/manage/image/goods_hot.png">
			  </div>
			  <?php endif;?>
			  <?php if($r->goods_status == 0):?>
			  <div class="recommend">
			  	<img src="/manage/image/goods_down.png">
			  </div>
			  <?php endif;?>
			</div>
			<?php endforeach;?>
	  	</div>
  	<?php endforeach?>
  </div>
</div>
<script language="JavaScript">
	$(document).ready(function(){
		function menu()
		{
			if($(".news.active").length == 0)
			{
				$("#edit").attr("disabled", true);
				$("#delete").attr("disabled", true);
				$("#up").attr("disabled", true);
				$("#down").attr("disabled", true);
			}
			if($(".news.active").length == 1)
			{
				$("#edit").attr("disabled", false);
				$("#delete").attr("disabled", false);
				$("#up").attr("disabled", false);
				$("#down").attr("disabled", false);
			}
			if($(".news.active").length > 1)
			{
				$("#edit").attr("disabled", true);
				$("#delete").attr("disabled", false);
				$("#up").attr("disabled", true);
				$("#down").attr("disabled", true);
			}
		}
		$(".news").click(function(){
			if($(this).hasClass('active'))
			{
				$(this).removeClass('active')
			}else{
				$(this).addClass('active')
			}
			menu();
		})
		
		$("#delete").click(function(){
			var ids = '';
			$(".news.active").each(function(){
				ids += $(this).attr('data_id')+'-';
			})
			ids = ids.substr(0,ids.length-1)
			$("#message").show().html("正在提交...");
			$.post('/manage/goods/delete', {'ids':ids}, function(data){
				window.location.reload();
			}, 'json')
		})
		$("#edit").click(function(){
			var id = $(".news.active").attr('data_id');
			window.location.href="/manage/goods/get/id/"+id;
		})
		
		$("#up").click(function(){
			$("#message").show().html("正在提交...");
			var ids = '';
			$(".news.active").each(function(){
				ids += $(this).attr('data_id')+'-';
			})
			ids = ids.substr(0,ids.length-1)
			$.post('/manage/goods/status', {'ids':ids, 'status':1}, function(data){
				window.location.reload();
			}, 'json')
		});
		$("#down").click(function(){
			$("#message").show().html("正在提交...");
			var ids = '';
			$(".news.active").each(function(){
				ids += $(this).attr('data_id')+'-';
			})
			ids = ids.substr(0,ids.length-1)
			$.post('/manage/goods/status', {'ids':ids, 'status':0}, function(data){
				window.location.reload();
			}, 'json')
		});
	  $('#thetable').tableScroll({
	    height:$(window).height() - 200,
	    width:'100%'
	  });
	})
</script>