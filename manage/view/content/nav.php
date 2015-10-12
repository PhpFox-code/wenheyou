<ul class="nav nav-tabs">
  <li <?php if (\Core\URI::kv('active') == 'news'):?>class="active"<?php endif;?>><a href="<?php echo current_url(array('active'=>'news'))?>" >图文内容</a></li>
  <!--<li <?php if (\Core\URI::kv('active') == 'video'):?>class="active"<?php endif;?>><a href="<?php echo current_url(array('active'=>'video'))?>" >视频内容</a></li>-->
</ul>