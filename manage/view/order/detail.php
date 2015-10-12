<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="<?php echo \Core\URI::a2p(array('order'=>'index', 'active'=>\Core\URI::kv('active')));?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-remove"></span> 取消操作</a>
	</div>
  </div>
  <div class="panel-body" style="min-height:300px;">

	<form role="form" method="post" action="<?php echo \Core\URI::a2p(array('order'=>'update'))?>">
	<input type="hidden"  name="order_id" value="<?php echo $this->row->order_id?>">
	<dl class="dl-horizontal" style="padding:20px 20px 0px 0px;">
	
      <dt style="padding:20px 0px;">派送信息：</dt>
      <dd>
			
      		<div class="form-group col-md-6">
      			<label>姓&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;名</label> 
				<input type="text" class="form-control" name="ship_name" value="<?php echo $this->row->ship_name?>" placeholder="姓名">
			</div>
			
			
      		<div class="form-group col-md-6">
      			<label>移动电话</label> 
      			<input type="text" class="form-control" name="ship_mobile" value="<?php echo $this->row->ship_mobile?>" placeholder="移动电话">
			</div>
      </dd>
      <dd>
			
      </dd>
      <dt style="padding:20px 0px;">价格：</dt>   
      <dd>
      		<div class="form-group col-md-6">
      			<label>时间 / 天</label> 
				<input type="text" class="form-control" name="revert_address" value="<?php echo $this->row->rent_days?>" placeholder="还机地点">
			</div>
			
      		<div class="form-group col-md-6">
          		<label>租金</label> 
          		<input type="text" class="form-control" name="item_nums" value="<?php echo $this->row->rent_price?>" placeholder="数量">
			</div>
      </dd>                
      <dd>
      		<div class="form-group col-md-6">
      			<label><span style="color:red">订单总额</span></label> 
				<input type="text" class="form-control" name="revert_address" value="<?php echo $this->row->total_amount?>" placeholder="还机地点">
			</div>
      </dd>         
      <dt style="padding:20px 0px;">状态：</dt>            
      <dd>
      
      		<div class="form-group col-md-6">
          		<label>数量</label> 
          		<input type="text" class="form-control" name="item_nums" value="<?php echo $this->row->item_nums?>" placeholder="数量">
			</div>
			
             <div class="form-group col-md-6">
             	<label>订单状态</label> 
             	<select name="status" class="form-control">
                  <option value="active" <?php if($this->row->status == 'active'){echo 'selected';}?>>正常</option>
                  <option value="destory" <?php if($this->row->status == 'destory'){echo 'selected';}?>>作废</option>
                </select>
			</div>
      </dd> 
      <dd style="padding:0px 15px;">
      		<button type="submit" class="btn btn-primary">提交</button>
      </dd>
    </dl>
	</form>


  </div>
  <div class="panel-footer">
  	<ol class="breadcrumb" style="margin-bottom:0px; padding:0px">
    <li>订单详情</li>
    </ol>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
          $(".date_start").datetimepicker({
              language:  'zh-CN',
              format: "yyyy-mm-dd hh:00",
              minView: 1,
              autoclose: true,
              todayBtn: true,
              startDate:new Date(),
              pickerPosition: "bottom-left"
          }).on('changeDate', function(ev){
              var end_time = ev.date.valueOf()+2*86400000;
              $(".date_end").datetimepicker({
                  language:  'zh-CN',
                  format: "yyyy-mm-dd hh:00",
                  minView: 1,
                  autoclose: true,
                  todayBtn: true,
                  startDate: new Date(end_time),
                  pickerPosition: "bottom-left"
              });
          });
    })
</script>