<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="<?php echo current_url(array('active'=>'list'))?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 取消操作</a>
	</div>
  </div>
  <div class="panel-body" style="min-height:300px;">

	<form role="form" method="post" action="<?php echo current_url(array('action'=>'add'))?>">
	<input type="hidden" name="link_id" value="<?php echo $this->row->link_id?>">
	<dl class="dl-horizontal" style="padding:20px 20px 0px 0px;">
      <dt>
          	<div class="vs-upload img-circle" style="height:140px; width:140">
                <div id="callback-image" style="background-image:url(<?php echo $this->row->link_logo?>)">
                <input id="vs-upload" type="file" name="image" accept="image/*">
                <input id="vs-image" type="hidden" name="link_logo">
                </div>
            </div>
            <div style="text-align:center; margin-top:10px;color:#ccc">
           	 图片尺寸140*140
           	</div>
      </dt>
      <dd>
      		<div class="form-group"><label>品牌中文名称</label> 
            <input type="text" class="form-control" name="link_name" value="<?php echo $this->row->link_name?>" placeholder="链接名称">
			</div>
            <div class="form-group"><label>打开方式</label> 
				<select name="link_target" class="form-control">
                    <option value="_blank">_blank</option>
                    <option value="_self">_self</option>
                    <option value="_parent">_parent</option>
                </select>
            </div>
            <div class="form-group"><label>排序(数值越大越靠前)</label> 
            <input type="text" class="form-control" name="link_order" value="<?php echo $this->row->link_order?>">
            </div>
            <div class="form-group"><label>链接地址</label> 
            <input type="text" class="form-control" name="link_url" value="<?php echo $this->row->link_url?>" placeholder="http://www.sony.com">
            </div>
		  <button type="submit" class="btn btn-primary">提交</button>
      </dd>
    </dl>
	</form>


  </div>
  <div class="panel-footer">
  	<ol class="breadcrumb" style="margin-bottom:0px; padding:0px">
    <li>友情链接</li>
    </ol>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
    var filechange = function(){
        $.ajaxFileUpload({
            url: '/manage/product/upload', //用于文件上传的服务器端请求地址
            secureuri: false, //是否需要安全协议，一般设置为false
            fileElementId: 'vs-upload', //文件上传域的ID
            dataType: 'json', //返回值类型 一般设置为json
            success: function (data, status)  //服务器成功响应处理函数
            {
                $("#callback-image").css("background-image", "url("+data.imgurl+")");
                $("#vs-upload").change(filechange);
                $("#vs-image").val(data.relative_imgurl);
            },
            error: function (data, status, e)//服务器响应失败处理函数
            {
                alert(e);
            }
        });

    }
    $("#vs-upload").change(filechange);

})
</script>