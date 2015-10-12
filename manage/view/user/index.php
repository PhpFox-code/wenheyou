<?php $status = \Core\URI::kv('status')?>
<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="row">
		
	  	<div class="col-md-4 pull-right">
	        <form id="search" method="get" action="<?php echo \Core\URI::a2p(array('user'=>'search'))?>" style="margin:0px;">
	  	    <div class="input-group">
			      <div class="input-group-addon"><span class="glyphicon glyphicon-search"></span></div>
			      <input id="user_nickname" class="form-control" name="user_nickname" value="<?php $user_nickname = \Core\URI::kv('user_nickname'); if(!empty($user_nickname)){echo $user_nickname;}?>" type="text" placeholder="微信昵称 ">
	          	  <a href="<?php echo \Core\URI::a2p(array('user'=>'index'))?>" class="input-group-addon"><span class="glyphicon glyphicon-remove"></span></a> 
			 </div>
	         </form>
		</div>
	</div>

  </div>

  <div class="panel-body" style="padding: 0px; overflow-y: hidden;">
	 <table class="table table table-bordered table-striped" id="thetable">
      <thead>
        <tr style="line-height:30px;">
          <th>会员ID</th>
          <th>头像</th>
          <th>微信昵称</th>
          <th>性别</th>
          <th>积分</th>
          <th>绑定时间</th>
          <th>登录时间</th>
          <th>历史订单</th>
        </tr>
      </thead>
      <tbody id="members" >
      	<?php foreach ($this->rows as $row):?>
        <tr class="order_item" data_id="<?php echo $row->user_id?>" >
          <td style="vertical-align:middle"><span class="glyphicon glyphicon-user"></span>&nbsp;&nbsp;<?php echo $row->user_id?></td>
          <td style="vertical-align:middle"><img width="50px" src="<?php echo !empty($row->user_avatar) ? $row->user_avatar : "/m/image/avatar.jpg"; ?>"></td>
          <td style="vertical-align:middle"><?php echo $row->user_nickname?></td>
          <td style="vertical-align:middle"><?php echo $row->get_gender()?></td>
          <td style="vertical-align:middle"><?php echo $row->user_score?></td>
          <td style="vertical-align:middle"><?php echo date('Y-m-d H:i:s',$row->create_time)?></td>
          <td style="vertical-align:middle"><?php echo date('Y-m-d H:i:s',$row->login_time)?></td>
          <td style="vertical-align:middle">
          <a href="<?php echo \Core\URI::a2p(array('user'=>'record','user_id'=>$row->user_id))?>" type="button" class="btn btn-default confirm order" ><span class="glyphicon glyphicon-ok"></span> 历史订单</a>
          </td>
        </tr>
        <?php endforeach;?>
        </tbody>
    </table>
  </div>
  <div class="panel-footer">
  	<?php echo $this->page?>
  </div>
</div>

<script type="text/javascript">
$(function(){
    document.onkeydown = function(e){ 
      var ev = document.all ? window.event : e;
      if(ev.keyCode==13) {
        var search = $("#search");
        if ($("#user_nickname").val().length != 0)
        {
          search.submit();
        }
      }
    }

	$('#thetable').tableScroll({
    height:$(window).height() - 350,
		width:'100%'
	});
});  
</script>