<form>
    <div class="new_address">
    	<dl class="table_view">
    		<dd>
		    	<ul>
		    		<li class="item">
		    			<a class="rect">
			    			<label>联系人</label>
			    			<kbd>
			    				<input class="get_name" name="user_name" type="text" value="<?php echo $this->row->user_name?>">
			    			</kbd>
		    			</a>
		    		</li>
		    		<li class="item">
		    			<a class="rect">
			    			<label>联系电话</label>
			    			<kbd>
			    				<input class="get_phone" name="user_mobile" type="text" value="<?php echo $this->row->user_mobile?>">
			    			</kbd>
		    			</a>
		    		</li>
		    		<li class="item">
		    			<a class="rect">
			    			<label>配送区域</label>
			    			<kbd>
								<select name="address_area" class="get_place">
									<option value="">请选择区域</option>
								  	<option value="开福区" <?php if($this->row->address_area == '开福区'){echo 'selected';}?>>开福区</option>
								 	<option value="雨花区" <?php if($this->row->address_area == '雨花区'){echo 'selected';}?>>雨花区</option>
								  	<option value="天心区" <?php if($this->row->address_area == '天心区'){echo 'selected';}?>>天心区</option>
								  	<option value="岳麓区" <?php if($this->row->address_area == '芙蓉区'){echo 'selected';}?>>岳麓区</option>
								  	<option value="芙蓉区" <?php if($this->row->address_area == '芙蓉区'){echo 'selected';}?>>芙蓉区</option>
								  	<option value="长沙县" <?php if($this->row->address_area == '长沙县'){echo 'selected';}?>>长沙县</option>
								  	<option value="望城区" <?php if($this->row->address_area == '望城区'){echo 'selected';}?>>望城区</option>
								</select>
							</kbd>
						</a>
		    		</li>
		    		<li class="item">
		    			<a class="rect">
			    			<label>联系地址</label>
			    			<p>
								<textarea name="address_street" class="get_place_detail" rows="2"><?php echo $this->row->address_street?></textarea>
							</p>
						</a>
		    		</li>
		    	</ul>
		    </dd>
	    </dl>
	    <div class="button_n">
		    <input type="hidden" name="address_province" value="湖南省" />
			<input type="hidden" name="address_city" value="长沙市" />
			<input type="hidden" name="is_default" value="1" />
		    <input type="hidden" name="id" value="<?php echo $this->row->address_id?>">
	    	<button type="submit">确认保存</button>
	    	<a class="delete" href="javascript:;" data-id="<?php echo $this->row->address_id?>">删除这个地址</a>
	    </div>
    </div>
</form>
<script type="text/javascript">
	require(['init'], function(){
		$(".button_n button").on("click",function(){
			var user_mobile    = $('input[name="user_mobile"]').val();
	      if(!(/^1[3|5|7|8]\d{9}$/.test(user_mobile))) {
	        alert("手机号码不正确");
	        return false;
	      }
		});
		$("form").on("submit",function(){
			var user_mobile    = trim($('input[name="user_mobile"]').val());
		      if(!(/^1[3|5|7|8]\d{9}$/.test(user_mobile))) {
		        alert("1");
		        return false;
		      }else{
				Cute.api.post("/address/save", $(this).serialize(), function(data){
					if (data.code == 0) {
						alert('保存成功！');
						location.href="/address/index";
					}else{
						alert(data.message);
					}
				},'json');
				return false;
				}
			});
		$(".delete").on("click",function(){
			if(confirm('确认要删除这个地址吗？')){
				Cute.api.post("/address/delete",{ids:$(this).data('id')},function(data){
					if (data.code == 0) {
						location.href="/address/index";
					}else{
						alert(data.message);
					};
				});
			}
			return false;
		});
	});
</script>

      
      