<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left" style="margin-right:20px">
  			<a id="add" href="<?php echo \Core\URI::a2p(array('notice'=>'add'))?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> 添加</a>
  			<button id="edit" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-pencil"></span> 编辑</button>
  			<button id="delete" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-minus"></span> 删除</button>
	</div>
  </div>
  <div class="panel-body" style="padding-top: 0px;">
  	<?php foreach($this->data as $key => $row):?>
	  	<div class="row slide"><?php echo $key?></div>
	  	<div class="row list">
	  		<?php foreach($row as $r):?>
			<div class="news pull-left" data_id =<?php echo $r->notice_id?>>
		      <img src="<?php echo $r->notice_pic?>" width="120px" height="54px"/>
		      <div class="caption">
		        <h4 style="padding-top:4px;"><?php echo $r->notice_tile?></h4>
			             简介：<?php echo mb_strimwidth($r->notice_profile, 0, 8, '..', 'utf-8')?>
	  			<br>
	  			时间：<?php echo date('m-d', $r->create_time)?><br>
	  			推送：<?php echo $r->is_sync == 1 ? '是':'否';?>
		      </div>
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
				$("#sync").attr("disabled", true);
				$("#delete").attr("disabled", true);
				$("#up").attr("disabled", true);
				$("#down").attr("disabled", true);
			}
			if($(".news.active").length == 1)
			{
				$("#edit").attr("disabled", false);
				$("#sync").attr("disabled", false);
				$("#delete").attr("disabled", false);
				$("#up").attr("disabled", false);
				$("#down").attr("disabled", false);
			}
			if($(".news.active").length > 1)
			{
				$("#edit").attr("disabled", true);
				$("#sync").attr("disabled", true);
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
			$.post('/manage/notice/delete', {'ids':ids}, function(data){
				window.location.reload();
			}, 'json')
		})
		$("#edit").click(function(){
			var id = $(".news.active").attr('data_id');
			window.location.href="/manage/notice/get/notice_id/"+id;
		})
		
		$("#sync").click(function(){
			$("#message").show().html("正在同步...");
			var id = $(".news.active").attr('data_id');
			$.post('/manage/notice/sync', {'id':id}, function(data){
				if(data.message == '')
				{
					window.location.reload();
				}
				else
				{
					$("#message").show().html(data.message);
				}
					
			}, 'json')
		});
	})
</script>