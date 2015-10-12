<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="javascript:history.go(-1);" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 取消</a>
	</div>
  </div>
  <div class="panel-body" style="min-height:300px;">

	<form id="add" role="form" method="post" action="<?php echo \Core\URI::a2p(array('user'=>'save'))?>">
	<input id="id" type="hidden" name="id" value="<?php echo $this->row->user_id?>">
	<div class="row">
		<div class="pull-left" style="padding: 20px; margin-right: -1px;border-right: 1px solid #ddd;">
			<div style="padding: 0px 0px 10px 10px;"><b>缩略图</b></div>
      		<div class="thumbnail img-circle" style="width: 140px; height: 140px;">
      			<div class="bg-image" style="background-image: url(<?php echo $this->row->user_avatar?>);">
      				<input id="vs_upload" type="file" name="vs_upload" accept="image/*" style="display:inline-block;width: 100%;height: 100%;opacity:0; -moz-opacity:0; filter:alpha(opacity=0);cursor: pointer;">
      			</div>
      			<input id="vs_image" type="hidden" name="vs_image">
      		</div>
            <div style="text-align:center; margin-top:10px;color:#ccc">
           	 图片尺寸600*600
           	</div>
		</div>
		<div style="margin-left: 180px;width: auto; border-left: 1px solid #ddd; padding: 20px;">
			<div>
				<div class="col-md-6" style="padding-left: 0px;">
		            <div class="form-group"><label>姓名</label> 
		            <input type="text" class="form-control" disabled id="user_name" name="user_name" value="<?php echo $this->row->user_name?>" placeholder="姓名">
		            </div>
				</div>
				<div class="col-md-6" style="padding-right: 0px;">
					<div class="form-group"><label>身份证号码</label> 
						<input type="text" class="form-control" disabled id="identity_id" name="identity_id" value="<?php echo $this->row->identity_id?>" placeholder="身份证号">
		            </div>
				</div>
			</div>
			<div>
				<div class="col-md-6" style="padding-left: 0px;">
		            <div class="form-group"><label>微信昵称</label> 
		            <input type="text" class="form-control" disabled id="user_nickname" name="user_nickname" value="<?php echo $this->row->user_nickname?>" placeholder="微信昵称">
		            </div>
				</div>
				<div class="col-md-6" style="padding-right: 0px;">
					<div class="form-group"><label>微信性别</label> 
		            <input type="text" class="form-control" disabled id="recent_days" name="recent_days" value="<?php echo $this->row->get_gender()?>">
		            </div>
				</div>
			</div>
			<div>
				<div class="col-md-6" style="padding-left: 0px;">
		            <div class="form-group"><label>会员卡号</label> 
            		<input type="text" class="form-control" disabled id="card_id" name="card_id" value="<?php echo $this->row->card_id?>" placeholder="会员卡号">
		            </div>
				</div>
				<div class="col-md-6" style="padding-right: 0px;">
					<div class="form-group"><label>积分余额</label> 
		            <input type="text" class="form-control" id="card_score" name="card_score" value="<?php echo $this->row->card_score?>" placeholder="积分余额">
		            </div>
				</div>
			</div>
			<div>
				<div class="col-md-6" style="padding-left: 0px;">
		            <div class="form-group"><label>手机号码</label> 
		            <input type="number" class="form-control" disabled id="recent_price" name="recent_price" value="<?php echo $this->row->user_mobile?>">
		            </div>
				</div>
				<div class="col-md-6" style="padding-right: 0px;">
					<div class="form-group"><label>绑定时间</label> 
		            <input type="text" class="form-control" disabled id="recent_days" name="recent_days" value="<?php echo date('Y-m-d H:i:s', $this->row->create_time)?>">
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
	/*
    var filechange = function(){
        $.ajaxFileUpload({
            url: '/manage/goods/upload', //用于文件上传的服务器端请求地址
            secureuri: false, //是否需要安全协议，一般设置为false
            fileElementId: 'vs_upload', //文件上传域的ID
            dataType: 'json', //返回值类型 一般设置为json
            success: function (data, status)  //服务器成功响应处理函数
            {
                $(".bg-image").css("background-image", "url("+data.imgurl+")");
                $("#vs_upload").change(filechange);
                $("#vs_image").val(data.imgurl);
            },
            error: function (data, status, e)//服务器响应失败处理函数
            {
                alert(e);
            }
        });

    }
    $("#vs_upload").change(filechange);
    */
    
    function showRequest(formData, jqForm, options) {  
	    var card_score = $("#card_score").val(); 
	    if(card_score < 0 ){ 
	        $("#message").show().html("积分不能小于0！"); 
	        return false; 
	    } 
	    $("#message").show().html("正在提交..."); 
	    return true;  
	}  
	
	function showResponse(responseText, statusText)  {  
		if(responseText.message == ""){
	      window.location.href="/manage/user/index";
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