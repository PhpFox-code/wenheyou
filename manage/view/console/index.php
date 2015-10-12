<?php $status = \Core\URI::kv('status')?>
<div class="panel panel-default">
  <div class="panel-heading">
  	<form id="myform" method="post" action="<?php echo \Core\URI::a2p(array('console'=>'exportorder'))?>">
  	<div class="row">
  		<div class="col-md-3">
			<div class="btn-group pull-left">
				<div class="input-group date form_datetime" id="datetimepicker_start">
				    <input class="form-control" size="16" name="time_start" readonly id="time_start" type="text" placeholder="起始时间">
				    <span class="input-group-addon"><span class="glyphicon glyphicon-th"></span></span>
				</div>
			</div>
		</div>
		<div class="col-md-3">
         <div class="form-group">
            <input type="text" name="days" class="form-control" id="days" placeholder="相差天数">
          </div>
		</div>
	  	<div class="col-md-6">
			<div class="btn-group pull-left">
				<button id="ordersubmit" type="button" class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> 导出消费报表</button>
				<button id="scoresubmit" type="button" class="btn btn-default"><span class="glyphicon glyphicon-download-alt"></span> 导出积分报表</button>
			</div>
		</div>

	</div> 
	</form>
  </div>
</div>

<script type="text/javascript">
$(function(){
    var start_time =  $('#datetimepicker_start').datetimepicker({
		language:  'zh-CN',
        format: "yyyy-mm-dd hh:00",
        minView: 1,
        autoclose: true,
        todayBtn: true,
        weekStart:1,
        pickerPosition: "bottom-left"
    });

    function check() {  
	    var time_start = $("#time_start").val(); 
	    if(time_start==""){ 
	        $("#message").show().html("开始时间不能为空"); 
	        return false; 
	    } 
	     
	    var days = $("#days").val(); 
	    if(days==""){ 
	        $("#message").show().html("相差天数不能为空"); 
	        return false; 
	    } 
	    $("#message").show().html("正在提交..."); 
	    return true;  
	}  

    $("#ordersubmit").click(function(){
    	if(check())
    	{
        	window.location.href = '/manage/console/exportorder/time_start/'+$("#time_start").val()+'/days/'+$("#days").val();
        	$("#message").hide(); 
        }	
    })
    
    $("#scoresubmit").click(function(){
    	if(check())
    	{
        	window.location.href = '/manage/console/exportscore?time_start='+$("#time_start").val()+'&days='+$("#days").val();
        	$("#message").hide(); 
        }	
    })
});  
</script>