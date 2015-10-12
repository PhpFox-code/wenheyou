<div class="panel panel-default">
  <div class="panel-heading">
  	<div class="btn-group pull-left">
  			<a href="<?php echo \Core\URI::a2p(array('link'=>'index', 'active'=>'add'))?>" type="button" class="btn btn-default"><span class="glyphicon glyphicon-plus"></span> 添加友情连接</a>
	</div>
  </div>
  <div class="panel-body" style="min-height:300px;">
  		<?php foreach ($this->rows as $row):?>
  		<div class="thumbnail pull-left my-menu">
	  	    <a href="<?php echo \Core\URI::a2p(array('link'=>'index','active'=>'edit', 'link_id'=>$row->link_id))?>">
          	<img class="img-circle" width="140px" height="140px" src="<?php echo $row->link_logo?>">
            
          	<div class="caption"><?php echo $row->link_name?></div>
          	</a>
    	    <div class="panel-footer">
                <div class="btn-group">
                  <a href="<?php echo \Core\URI::a2p(array('link'=>'destory', 'link_id'=>$row->link_id))?>" type="button" class="btn btn-xs btn-default"><span class="glyphicon glyphicon-trash"></span> 删除</a>
                </div>
            </div>
	    </div>
		<?php endforeach;?>
  </div>
  <div class="panel-footer">
  	<ol class="breadcrumb" style="margin-bottom:0px; padding:0px">
    <li>友情链接</li>
    </ol>
  </div>
</div>