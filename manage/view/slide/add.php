<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="javascript:history.go(-1);" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 取消</a>
	</div>
  </div>
  <div class="panel-body" style="min-height:300px;">

	<form id="add" role="form" method="post" action="<?php echo \Core\URI::a2p(array('slide'=>'save'))?>">

	<div class="row">
		<div class="pull-left" style="padding: 20px; margin-right: -1px;border-right: 1px solid #ddd;">
			<div style="padding: 0px 0px 10px 10px;"><b>缩略图</b></div>
      		<div class="thumbnail img-circle" style="width: 140px; height: 140px;">
      			<div class="bg-image" style="background-image: url(/manage/image/add_image.jpg);">
      				<input id="ajax_upload" type="file" name="ajax_upload" accept="image/*" style="display:inline-block;width: 100%;height: 100%;opacity:0; -moz-opacity:0; filter:alpha(opacity=0);cursor: pointer;">
      			</div>
      			<input id="ajax_image" type="hidden" name="ajax_image">
      		</div>
            <div style="text-align:center; margin-top:10px;color:#ccc">
           	图片尺寸620*310
           	</div>
		</div>
		<div style="margin-left: 180px;width: auto; border-left: 1px solid #ddd; padding: 20px;">
            <div class="form-group"><label>打开方式</label> 
				<select id="slide_target" name="slide_target" class="form-control">
                    <option value="_blank">_blank</option>
                    <option value="_self">_self</option>
                    <option value="_parent">_parent</option>
                </select>
            </div>
            <div class="form-group"><label>排序(数值越大越靠前)</label> 
            <input type="text" class="form-control" id="slide_order" name="slide_order" value="1">
            </div>
            <div class="form-group"><label>标题</label> 
            <input type="text" class="form-control" id="slide_title" name="slide_title" value="">
            </div>
            <div class="form-group"><label>链接地址</label>
            <input type="text" class="form-control" id="slide_link" name="slide_link" value="" placeholder="http://www.domain.com">
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
	    var group_name = $("#group_name").val(); 
	    if(group_name==""){ 
	        $("#message").show().html("组名称不能为空！"); 
	        return false; 
	    } 
	     
	    var slide_link = $("#slide_link").val(); 
	    if(slide_link==""){ 
	        $("#message").show().html("链接地址不能为空"); 
	        return false; 
	    } 
	    
	    var slide_title = $("#slide_title").val(); 
	    if(slide_title==""){ 
	        $("#message").show().html("标题不能为空"); 
	        return false; 
	    } 
	    var vs_image = $("#vs_image").val(); 
	    if(vs_image==""){ 
	        $("#message").show().html("图片不能为空"); 
	        return false; 
	    } 
	    $("#message").show().html("正在提交..."); 
	    return true;  
	}  
	
	function showResponse(responseText, statusText)  {  
	    window.location.href="/manage/slide/index";
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