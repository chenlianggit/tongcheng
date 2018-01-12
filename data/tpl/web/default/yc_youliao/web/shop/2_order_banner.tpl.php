<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
    <li <?php  if($op == 'display' && $status == '-2' && $today == '1') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'display', 'status' =>'-2', 'today' =>1))?>">今日订单</a></li>
    <li <?php  if($op == 'display' && $status == '0') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'display', 'status' => 0))?>">待付款</a></li>
    <li <?php  if($op == 'display' && $status == '2') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'display', 'status' => 2))?>">待使用</a></li>
    <li <?php  if($op == 'display' && $status == '3') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'display', 'status' => 3))?>">已完成</a></li>
    <li <?php  if($op == 'display' && $status == '4' || $_GPC['do']=='shop_refund') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'display', 'status' => 4))?>">售后退款</a></li>
    <li <?php  if($op == 'display' && $status == '-1') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'display', 'status' => -1))?>">全部订单</a></li>

</ul>