<ul class="nav nav-tabs">
  <li <?php if (\Core\URI::kv('active') == 'wait_confirm'):?>class="active"<?php endif;?>><a href="<?php echo \Core\URI::a2p(array('order'=>'index','active'=>'wait_confirm'))?>" >等待支付</a></li>
  <li <?php if (\Core\URI::kv('active') == 'queue'):?>class="active"<?php endif;?>><a href="<?php echo \Core\URI::a2p(array('order'=>'index','active'=>'queue'))?>" >等待商家确认</a></li>
  <li <?php if (\Core\URI::kv('active') == 'check'):?>class="active"<?php endif;?>><a href="<?php echo \Core\URI::a2p(array('order'=>'index','active'=>'check'))?>" >商家已确认</a></li>
  <li <?php if (\Core\URI::kv('active') == 'release'):?>class="active"<?php endif;?>><a href="<?php echo \Core\URI::a2p(array('order'=>'index','active'=>'release'))?>" >配送中</a></li>
  <li <?php if (\Core\URI::kv('active') == 'success'):?>class="active"<?php endif;?>><a href="<?php echo \Core\URI::a2p(array('order'=>'index','active'=>'success'))?>" >已经完成</a></li>
  <li <?php if (\Core\URI::kv('active') == 'wait_refund'):?>class="active"<?php endif;?>><a href="<?php echo \Core\URI::a2p(array('order'=>'index','active'=>'wait_refund'))?>" >待退款</a></li>
  <li <?php if (\Core\URI::kv('active') == 'refund'):?>class="active"<?php endif;?>><a href="<?php echo \Core\URI::a2p(array('order'=>'index','active'=>'refund'))?>" >已退款</a></li>
  <li <?php if (\Core\URI::kv('active') == 'destory'):?>class="active"<?php endif;?>><a href="<?php echo \Core\URI::a2p(array('order'=>'index','active'=>'destory'))?>" >已作废</a></li>
</ul>
<div style="height:10px;"></div>