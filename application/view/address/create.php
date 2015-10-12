<form>
    <div class="new_address">
    	<dl class="table_view">
    		<dd>
		    	<ul>
		    		<li class="item">
		    			<a class="rect">
			    			<label>联系人</label>
			    			<kbd>
			    				<input class="get_name" name="user_name" type="text">
			    			</kbd>
		    			</a>
		    		</li>
		    		<li class="item">
		    			<a class="rect">
			    			<label>联系电话</label>
			    			<kbd>
			    				<input class="get_phone" name="user_mobile" type="text">
			    			</kbd>
		    			</a>
		    		</li>
		    		<li class="item">
		    			<a class="rect">
			    			<label>配送区域</label>
			    			<kbd>
								<select name="address_area" class="get_place">
									<option value="">请选择区域</option>
									<option value="开福区">开福区</option>
								 	<option value="雨花区">雨花区</option>
								  	<option value="天心区">天心区</option>
								  	<option value="岳麓区">岳麓区</option>
								  	<option value="芙蓉区">芙蓉区</option>
								  	<option value="长沙县">长沙县</option>
								  	<option value="望城区">望城区</option>
								</select>
							</kbd>
						</a>
		    		</li>
		    		<li class="item">
		    			<a class="rect">
			    			<label>联系地址</label>
			    			<p>
								<textarea name="address_street" class="get_place_detail" rows="2"></textarea>
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
	    	<button type="submit">确认保存</button>
	    </div>
    </div>
</form>
<script type="text/javascript">
	require(['init'], function(){
		$("form").on("submit",function(){
			Cute.api.post("/address/save", $(this).serialize(), function(data){
				if (data.code == 0) {
					alert('保存成功！');
					if("<?php echo \Core\URI::kv('ref',''); ?>" === ""){
						location.href="/address/index";
					}else{
						location.href="/trade/index";
					}
				}else{
					alert(data.message);
				}
			},'json');
			return false;
		});
	});
</script>