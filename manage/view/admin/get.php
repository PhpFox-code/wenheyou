<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="javascript:history.go(-1);" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 取消</a>
	</div>
  </div>
  <div class="panel-body" style="min-height:300px;">

	<form id="add" role="form" method="post" action="<?php echo \Core\URI::a2p(array('admin'=>'save'))?>">
	<input id="id" type="hidden" name="id" value="<?php echo $this->row->admin_id?>">
	<div class="row">
		<div class="pull-left" style="padding: 20px; margin-right: -1px;border-right: 1px solid #ddd;">
			<div style="padding: 0px 0px 10px 10px;"><b>缩略图</b></div>
      		<div class="thumbnail img-circle" style="width: 140px; height: 140px;">
      			<div class="bg-image" style="background-image: url(<?php echo $this->row->admin_avatar?>);">
      				<input id="ajax_upload" type="file" name="ajax_upload" accept="image/*" style="display:inline-block;width: 100%;height: 100%;opacity:0; -moz-opacity:0; filter:alpha(opacity=0);cursor: pointer;">
      			</div>
      			<input id="ajax_image" type="hidden" name="ajax_image" value="<?php echo $this->row->admin_avatar?>">
      		</div>
            <div style="text-align:center; margin-top:10px;color:#ccc">
           	 图片尺寸100*100
           	</div>
		</div>
		<div style="margin-left: 180px;width: auto; border-left: 1px solid #ddd; padding: 20px;">
			<div>
				<div class="col-md-6" style="padding-left: 0px;">
		            <div class="form-group"><label>姓名</label> 
		            <input type="text" class="form-control" id="admin_name" name="admin_name" value="<?php echo $this->row->admin_name?>" placeholder="姓名">
		            </div>
				</div>
				<div class="col-md-6" style="padding-right: 0px;">
					<div class="form-group"><label>级别</label> 
						<select name="admin_level" disabled  class="form-control">
						  <option value="1" <?php if($this->row->admin_level == '1'){ echo 'selected';}?>>管理员</option>
						  <option value="0" <?php if($this->row->admin_level == '0'){ echo 'selected';}?>>超级管理员</option>
						</select>
		            </div>
				</div>
			</div>
			<div>
				<div class="col-md-6" style="padding-left: 0px;">
		            <div class="form-group"><label>邮箱帐号</label> 
            		<input type="text" class="form-control" id="admin_account" name="admin_account" value="<?php echo $this->row->admin_account?>" placeholder="会员卡号">
		            </div>
				</div>
				<div class="col-md-6" style="padding-right: 0px;">
					<div class="form-group"><label>密码</label> 
		            <input type="password" class="form-control" id="admin_password" name="admin_password" value="<?php echo $this->row->admin_password?>" placeholder="积分余额">
		            </div>
				</div>
			</div>
			<div>
				<div class="col-md-6" style="padding-left: 0px;">
		            <div class="form-group"><label>手机号码</label> 
		            <input type="number" class="form-control" id="admin_mobile" name="admin_mobile" value="<?php echo $this->row->admin_mobile?>">
		            </div>
				</div>
				<div class="col-md-6" style="padding-right: 0px;">
					<div class="form-group"><label>更新时间</label> 
		            <input type="text" class="form-control" disabled id="create_time" name="create_time" value="<?php echo date('Y-m-d H:i:s', $this->row->create_time)?>">
		            </div>
				</div>
			</div>
		    <button id="sumbit" type="button" class="btn btn-primary">提交</button>
    </div>
	</form>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	
    var filechange = function(){
        $.ajaxFileUpload({
            url: '/manage/meta/upload', //用于文件上传的服务器端请求地址
            secureuri: false, //是否需要安全协议，一般设置为false
            fileElementId: 'ajax_upload', //文件上传域的ID
            dataType: 'json', //返回值类型 一般设置为json
            success: function (data, status)  //服务器成功响应处理函数
            {
                $(".bg-image").css("background-image", "url("+data.imgurl+")");
                $("#ajax_upload").change(filechange);
                $("#ajax_image").val(data.imgurl);
            },
            error: function (data, status, e)//服务器响应失败处理函数
            {
                alert(e);
            }
        });

    }
    $("#ajax_upload").change(filechange);
    
    function showRequest(formData, jqForm, options) {  
	    var admin_name = $("#admin_name").val(); 
	    if(admin_name == '' ){ 
	        $("#message").show().html("姓名不能为空"); 
	        return false; 
	    } 
	    var admin_account = $("#admin_account").val(); 
	    if(admin_account == '' ){ 
	        $("#message").show().html("邮箱帐号不能为空"); 
	        return false; 
	    } 
	    var admin_mobile = $("#admin_mobile").val(); 
	    if(admin_mobile == '' ){ 
	        $("#message").show().html("手机号码不能为空"); 
	        return false; 
	    } 
	    $("#message").show().html("正在提交..."); 
	    return true;  
	}  
	
	function showResponse(responseText, statusText)  {  
		if(responseText.message == ""){
	      window.location.href="/manage/admin/index";
	    }
	    else
	    {
	    	$("#message").show().html(responseText.message); 
	    }
	} 
	$("#sumbit").click(function(){
		var options = {  
	        beforeSubmit:  showRequest,  //提交前处理 
	        success:       showResponse,  //处理完成 
	        resetForm: true,  
	        dataType:  'json'  
	    };  
	    $("#add").ajaxSubmit(options);  
	})
})
</script>