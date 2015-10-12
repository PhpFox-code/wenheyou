<!-- <ul id="myTab" class="nav nav-tabs" role="tablist"> -->
<ul class="nav nav-tabs">
  <li <?php if (\Core\URI::kv('active') == 'nomal'):?>class="active"<?php endif;?>><a href="<?php echo current_url(array('active'=>'nomal'))?>" >消息对话</a></li>
  <li <?php if (\Core\URI::kv('active') == 'event'):?>class="active"<?php endif;?>><a href="<?php echo current_url(array('active'=>'event'))?>" >操作事件</a></li>
  </ul>