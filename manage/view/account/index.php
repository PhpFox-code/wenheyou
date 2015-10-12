<div class="panel panel-default">
  <div class="panel-body" style="min-height:300px;">

	<form id="account_form" role="form" method="post" action="<?php echo \Core\URI::a2p(array('account'=>'changepw'));?>">

      		<div class="form-group"><label>原始密码：</label> 
            <input type="password" class="form-control" id="password" name="password"  placeholder="初始密码">
			</div>
      		<div class="form-group"><label>新密码：</label> 
            <input type="password" class="form-control" id="new_password" name="new_password"  placeholder="新密码">
			</div>
      		<div class="form-group"><label>重复新密码：</label> 
            <input type="password" class="form-control" id="repeat_password" name="repeat_password"  placeholder="重复密码">
			</div>
		    <button id="account_submit" type="button" class="btn btn-primary">提交</button>
	</form>


  </div>
  <div class="panel-footer">
  	<ol class="breadcrumb" style="margin-bottom:0px; padding:0px">
    <li>帐号设置</li>
    </ol>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    
    function showRequest(formData, jqForm, options) {  
	    var password = $("#password").val(); 
	    if(password==""){ 
	        $("#message").show().html("原始密码不能为空"); 
	        return false; 
	    } 
	     
	    var new_password = $("#new_password").val(); 
	    if(new_password==""){ 
	        $("#message").show().html("新密码不能为空"); 
	        return false; 
	    } 
	    var repeat_password = $("#repeat_password").val(); 
	    if(repeat_password != new_password){ 
	        $("#message").show().html("2次输入的新密码不一致"); 
	        return false; 
	    } 
	    $("#message").show().html("正在提交..."); 
	    return true;  
	}  
	
	function showResponse(responseText, statusText)  {  
	    $("#message").show().html(responseText.message); 
	    return false;
	} 
	$("#account_submit").click(function(){
		var options = {  
	        beforeSubmit:  showRequest,  //提交前处理 
	        success:       showResponse,  //处理完成 
	        resetForm: true,  
	        dataType:  'json'  
	    };  
	    $("#account_form").ajaxSubmit(options);  
	})
})
</script>