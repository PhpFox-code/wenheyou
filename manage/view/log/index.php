<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<button type="button" class="btn btn-default" disabled><span class="glyphicon glyphicon-eye-open"></span> 日志详情</button>
	</div>

  </div>

  <div class="panel-body">
	 <table class="table table table-bordered table-striped" style="margin:0px;">
      <thead>
        <tr style="line-height:30px;">
          <th>操作员</th>
          <th>触发时间</th>
          <th>触发事件</th>
          <th>说明</th>
        </tr>
      </thead>
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
		$.post('/manage/log/index_part', {'page':page}, function(result){
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
})
</script>