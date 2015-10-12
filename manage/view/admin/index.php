<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a id="add" href="<?php echo \Core\URI::a2p(array('admin'=>'add'))?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> 添加</a>
  			<button id="edit" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-pencil"></span> 编辑</button>
  			<button id="delete" type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-minus"></span> 删除</button>
	</div>
  </div>
  <div class="panel-body">
	<table class="table table table-bordered table-striped" style="margin:0px;">
      <thead>
        <tr style="line-height:30px;">
          <th>管理员ID</th>
          <th>头像</th>
          <th>名称</th>
          <th>帐号</th>
          <th>创建时间</th>
          <th>级别</th>
        </tr>
      </thead>
      <tbody id="members" >
      	<?php foreach ($this->rows as $row):?>
        <tr class="order_item" data_id="<?php echo $row->admin_id?>" data_level="<?php echo $row->admin_level?>">
          <td style="vertical-align:middle"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $row->admin_id?></td>
          <td style="vertical-align:middle"><img width="50px" src="<?php echo !empty($row->admin_avatar) ? $row->admin_avatar : "/m/image/avatar.jpg"; ?>"></td>
          <td style="vertical-align:middle"><?php echo $row->admin_name?></td>
          <td style="vertical-align:middle"><?php echo $row->admin_account?></td>
          <td style="vertical-align:middle"><?php echo date('Y-m-d H:i:s',$row->create_time)?></td>
          <td style="vertical-align:middle"><?php echo $row->get_level()?></td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
  </div>
</div>
<script type="text/javascript">
$(function(){
	  document.onkeydown = function(e){ 
	      var ev = document.all ? window.event : e;
	      if(ev.keyCode==13) {
	        var search = $("#search");
	        if ($("#user_mobile").val().length != 0)
	        {
	          search.submit();
	        }
	      }
	  }
  
  	 function menu()
	 {
			if($(".order_item.active").length == 0)
			{
				$("#delete").attr("disabled", true);
				$("#edit").attr("disabled", true);
			}
			if($(".order_item.active").length == 1)
			{
				$("#delete").attr("disabled", false);
				$("#edit").attr("disabled", false);
			}
			if($(".order_item.active").length > 1)
			{
				$("#delete").attr("disabled", false);
				$("#edit").attr("disabled", true);
			}
		}
		
		$(".order_item").click(function(){
	  	if($(this).hasClass('active'))
	  	{
	  		$(this).removeClass('active')
	  	}else{
	  		$(this).addClass('active')
	  	}
	  	menu()
	   })
		
		$("#delete").click(function(){
			var ids = '';
			$(".order_item.active").each(function(){
				ids += $(this).attr('data_id')+'-';
			})
			ids = ids.substr(0,ids.length-1)
			$("#message").show().html("正在提交...");
			$.post('/manage/admin/delete', {'ids':ids}, function(data){
				window.location.reload();
			}, 'json')
		})
		
		$("#edit").click(function(){
			var id = $(".order_item.active").attr('data_id');
			window.location.href="/manage/admin/get/id/"+id;
		})
});  
</script>