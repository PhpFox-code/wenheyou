<div class="panel panel-default">
<!--  
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="/manage/link/index/active/add" type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> 添加键值</a>
	</div>
  </div>
-->  
  <div class="panel-body" style="min-height:300px;">

	<form role="form" method="post" action="<?php echo current_url(array('action'=>'add'));?>">

	<dl class="dl-horizontal" style="padding:20px 20px 0px 0px;">
      <dt>
          	<div class="vs-upload img-circle" style="height:140px; width:140">
                <div id="callback-image" style="background-image:url(<?php if(isset($this->row['wechat_qr'])){echo $this->row['wechat_qr'];}?>); background-size:140px;">
                <input id="vs-upload" type="file" name="image" accept="image/*">
                <input id="vs-image" type="hidden" name=wechat_qr value="<?php if(isset($this->row['wechat_qr'])){echo $this->row['wechat_qr'];}?>">
                </div>
            </div>
            <div style="text-align:center; margin-top:10px;color:#ccc">
           	 微信公众号二维码<br/>140*140px
           	</div>
      </dt>
      <dd>
      		<div class="form-group"><label>站点名称：</label> 
            <input type="text" class="form-control" name="site_name" value="<?php if(isset($this->row['site_name'])){echo $this->row['site_name'];}?>" placeholder="站点名称">
			</div>
      		<div class="form-group"><label>客服QQ：</label> 
            <input type="text" class="form-control" name="custom_qq" value="<?php if(isset($this->row['custom_qq'])){echo $this->row['custom_qq'];}?>" placeholder="客服QQ">
			</div>
      		<div class="form-group"><label>订货通知邮箱：</label> 
            <input type="text" class="form-control" name="notify_email" value="<?php if(isset($this->row['notify_email'])){echo $this->row['notify_email'];}?>" placeholder="订货通知邮箱">
			</div>
      		<div class="form-group"><label>咨询电话：</label> 
            <input type="text" class="form-control" name="call_phone" value="<?php if(isset($this->row['call_phone'])){echo $this->row['call_phone'];}?>" placeholder="售前电话">
			</div>
      		<div class="form-group"><label>联系地址：</label> 
            <input type="text" class="form-control" name="contact_address" value="<?php if(isset($this->row['contact_address'])){echo $this->row['contact_address'];}?>" placeholder="联系地址">
			</div>
		    <button type="submit" class="btn btn-primary">提交</button>
      </dd>
    </dl>
	</form>


  </div>
  <div class="panel-footer">
  	<ol class="breadcrumb" style="margin-bottom:0px; padding:0px">
    <li>站点设置</li>
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