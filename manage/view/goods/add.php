<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="javascript:history.go(-1);" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 取消</a>
	</div>
  </div>
  <div class="panel-body" style="min-height:300px;">

	<form id="add" role="form" method="post" action="<?php echo \Core\URI::a2p(array('goods'=>'save'))?>">

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
           	 图片尺寸900*900
           	</div>
		</div>
		<div style="margin-left: 180px;width: auto; border-left: 1px solid #ddd; padding: 20px;">
			<div class="form-group"><label>分店名称</label> 
    			<select name="store_id"  class="form-control">
    			  <option value="0">无</option>
    			  <?php $stores = \DB\Mall\Store::fetch();?>
    			  <?php foreach ($stores as $store):?>
				  <option value="<?php echo $store->store_id?>" ><?php echo $store->store_name?></option>
				  <?php endforeach;?>
				</select>
			</div>
			<div class="form-group"><label>分类名称</label> 
    			<select name="category_id"  class="form-control">
    			  <?php $category = \DB\Mall\Category::fetch();?>
    			  <?php foreach ($category as $c):?>
				  <option value="<?php echo $c->category_id?>" ><?php echo $c->category_name?></option>
				  <?php endforeach;?>
				</select>
			</div>
      		<div class="form-group"><label>商品名称</label> 
            <input type="text" class="form-control" id="goods_name" name="goods_name" value="" placeholder="goods_name">
			</div>
			<div class="row">
				<div class="col-md-6">
		            <div class="form-group"><label>销售价格</label> 
		            <input type="number" class="form-control" id="goods_discount_price" name="goods_discount_price" value="0">
		            </div>
				</div>
				<div class="col-md-6">
					<div class="form-group"><label>商品原价</label> 
		            <input type="number" class="form-control" id="goods_original_price" name="goods_original_price" value="0">
		            </div>
				</div>
			</div>
			<div class="row">
				<div class="col-md-4">
		            <div class="form-group"><label>排序(数值越大越靠前)</label> 
		            <input type="number" class="form-control" id="goods_order" name="goods_order" value="1">
		            </div>
				</div>
				<div class="col-md-4">
					<div class="form-group"><label>是否推荐</label> 
						<select name="is_recommend"  class="form-control">
						  <option value="0" >否</option>
						  <option value="1" >是</option>
						</select>
		            </div>
				</div>
				<div class="col-md-4">
					<div class="form-group"><label>推荐星级</label> 
						<select name="count_star"  class="form-control">
						  <option value="0" >0</option>
						  <option value="1" >1</option>
						  <option value="2" >2</option>
						  <option value="3" >3</option>
						  <option value="4" >4</option>
						  <option value="5" >5</option>
						</select>
		            </div>
				</div>
			</div>
			<div class="form-group"><label>商品摘要</label> 
            <textarea type="textarea" class="form-control" id="goods_profile" name="goods_profile" placeholder="预览的描述信息" rows="6"></textarea>
            </div>
            
            <div class="form-group">
            <label>商品介绍</label>
            <textarea id="goods_content" name="goods_content" placeholder="这里输入内容" autofocus></textarea>
            </div>
		    <button id="sumbit" type="button" class="btn btn-primary">提交</button>
    </div>
	</form>
  </div>
</div>

<script type="text/javascript">
$(document).ready(function(){
	 var editor;
		KindEditor.ready(function(K) {
			editor = K.create('#goods_content', {
				width : "100%", //编辑器的宽度为100%
				height :"300px",
				minHeight :"300px",
				resizeType : 1,
				allowPreviewEmoticons : false,
				allowImageUpload : true,
				items : [
				'fontsize', '|', 'forecolor', 'hilitecolor', 'bold', 'italic', 'underline',
				'removeformat', '|', 'justifyleft', 'justifycenter', 'justifyright', 'insertorderedlist',
				'insertunorderedlist', '|', 'image', 'media','link']
			});
		});

    // $('#goods_content').editable({
    //     inlineMode: false,
    //     imageUploadURL: "/manage/meta/picture",
    //     // Set content changed callback.
    //     contentChangedCallback: function () {
    //       console.log ('content has been changed');
    //     }
    //   })
   
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
	     
	    var goods_name = $("#goods_name").val(); 
	    if(goods_name==""){ 
	        $("#message").show().html("商品名称不能为空"); 
	        return false; 
	    } 
	    var goods_discount_price = $("#goods_discount_price").val(); 
	    if(goods_discount_price==""){ 
	        $("#message").show().html("销售价格不能为空"); 
	        return false; 
	    } 
	    var goods_original_price = $("#goods_original_price").val(); 
	    if(goods_original_price==""){ 
	        $("#message").show().html("挂牌价格不能为空"); 
	        return false; 
	    } 
	    var goods_content = $("#goods_content").val(); 
	    if(goods_content==""){ 
	        $("#message").show().html("商品介绍不能为空"); 
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
		if(responseText.message == ""){
	      window.location.href="/manage/goods/index";
	    }
	    else
	    {
	    	$("#message").show().html(responseText.message); 
	    }
	} 
	$("#sumbit").click(function(){
	    editor.sync();
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