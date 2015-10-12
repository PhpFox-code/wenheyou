<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a id="add" href="<?php echo \Core\URI::a2p(array('slide'=>'add'))?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> 添加</a>
  			<button id="edit" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-pencil"></span> 编辑</button>
  			<button id="delete" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-minus"></span> 删除</button>
	</div>
  </div>
  <div class="panel-body" style="padding-top: 15px;">
  	<?php foreach($this->rows as $row):?>
	  		<div class="image" data_id =<?php echo $row->slide_id?> >
	  			<div class="bg-image"  style="background-image: url(<?php echo $row->slide_pic?>);"></div>
		    </div>
  	<?php endforeach?>
  </div>
</div>
<script language="JavaScript">
	$(document).ready(function(){
		function operate()
		{
			if($(".image.active").length == 0)
			{
				$("#edit").attr("disabled", true);
				$("#delete").attr("disabled", true);
			}
			if($(".image.active").length == 1)
			{
				$("#edit").attr("disabled", false);
				$("#delete").attr("disabled", false);
			}
			if($(".image.active").length > 1)
			{
				$("#edit").attr("disabled", true);
				$("#delete").attr("disabled", false);
			}
		}
		$(".image").click(function(){
			if($(this).hasClass('active'))
			{
				$(this).removeClass('active')
			}else{
				$(this).addClass('active')
			}
			operate();
		})
		// 删除数据
		$("#delete").click(function(){
			var ids = '';
			$(".image.active").each(function(){
				ids += $(this).attr('data_id')+'-';
			})
			ids = ids.substr(0,ids.length-1)
			$("message").show().html("正在提交...");
			$.post('/manage/slide/delete', {'ids':ids}, function(data){
				window.location.reload();
			}, 'json')
		})
		// 选中编辑
		$("#edit").click(function(){
			var id = $(".image.active").attr('data_id');
			window.location.href="/manage/slide/get/id/"+id;
		})
	})
</script>