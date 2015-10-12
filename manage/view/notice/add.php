<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="javascript:history.go(-1);" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 取消</a>
	</div>
  </div>
  <div class="panel-body" style="min-height:300px;">

	<form id="add" role="form" method="post" action="<?php echo \Core\URI::a2p(array('notice'=>'save'))?>">

	<div class="row">
		<div class="pull-left" style="padding: 20px; margin-right: -1px;border-right: 1px solid #ddd;">
			<div style="padding: 0px 0px 10px 10px;"><b>缩略图</b></div>
      		<div class="thumbnail img-circle" style="width: 140px; height: 140px;">
      			<div class="bg-image" style="background-image: url(/m/image/add_image.jpg);">
      				<input id="ajax_upload" type="file" name="ajax_upload" accept="image/*" style="display:inline-block;width: 100%;height: 100%;opacity:0; -moz-opacity:0; filter:alpha(opacity=0);cursor: pointer;">
      			</div>
      			<input id="ajax_image" type="hidden" name="ajax_image">
      		</div>
            <div style="text-align:center; margin-top:10px;color:#ccc">
           	 图片尺寸435*195
           	</div>
		</div>
		<div style="margin-left: 180px;width: auto; border-left: 1px solid #ddd; padding: 20px;">
      		<div class="form-group"><label>GROUP名称</label> 
<!--            <input type="text" class="form-control" id="group_name" name="group_name" value="" placeholder="group_name">-->
				<select name="group_name" class="form-control">
					<option value="最新活动">最新活动</option>
					<option value="景区导览">景区导览</option>
				</select>
			</div>
      		<div class="form-group"><label>内容标题</label> 
            <input type="text" class="form-control" id="notice_title" name="notice_title" value="" placeholder="notice_title">
			</div>
            <div class="form-group"><label>内容简介</label> 
            <textarea type="textarea" class="form-control" id="notice_profile" name="notice_profile" placeholder="预览的描述信息" rows="4"></textarea>
            </div>
            <div class="form-group">
            <label>内容正文</label>
            <textarea  id="notice_text" name="notice_text" placeholder="这里输入内容" autofocus></textarea>
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

    $('#notice_text').editable({
        inlineMode: false,
        imageUploadURL: "/manage/notice/picture",
        // Set content changed callback.
        contentChangedCallback: function () {
          console.log ('content has been changed');
        }
      })
    
    function showRequest(formData, jqForm, options) {  
	    var group_name = $("#group_name").val(); 
	    if(group_name==""){ 
	        $("#message").show().html("组名称不能为空！"); 
	        return false; 
	    } 
	     
	    var notice_title = $("#notice_title").val(); 
	    if(notice_title==""){ 
	        $("#message").show().html("标题不能为空"); 
	        return false; 
	    } 
	    var notice_profile = $("#notice_profile").val(); 
	    if(notice_profile==""){ 
	        $("#message").show().html("内容简介不能为空"); 
	        return false; 
	    } 
	    var notice_text = $("#notice_text").val(); 
	    if(notice_text==""){ 
	        $("#message").show().html("内容正文不能为空"); 
	        return false; 
	    } 
	    var vs_image = $("#vs_image").val(); 
	    if(vs_image==""){ 
	        $("#message").show().html("缩略图片不能为空"); 
	        return false; 
	    } 
	    $("#message").show().html("正在提交..."); 
	    return true;  
	}  
	
	function showResponse(responseText, statusText)  {  
		if(responseText.message == ""){
	      window.location.href="/manage/notice/index";
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