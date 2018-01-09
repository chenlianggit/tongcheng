<?php defined('IN_IA') or exit('Access Denied');?>
<div class="cate_type right input-group select_btn">
    <div class="btn-group">
        <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <?php  if($_GPC['cate_type']=='0') { ?>商铺消费
            <?php  } else if($_GPC['cate_type']=='1') { ?>酒店预订
            <?php  } else if($_GPC['cate_type']=='2') { ?>影院订座
            <?php  } else if($_GPC['cate_type']=='3') { ?>外卖点餐
            <?php  } else if($_GPC['cate_type']=='4') { ?>微商城
            <?php  } else { ?>请选择业务类型
            <?php  } ?>

            <span class="caret"></span>
        </button>
        <ul class="dropdown-menu">
            <li><a href="<?php  echo $this->createWebUrl($_GPC['do'], array('cate_type' => '0'))?>"> 商铺消费</a></li>
            <!--<li role="separator" class="divider"></li>-->
            <!--<li><a href="<?php  echo $this->createWebUrl($_GPC['do'], array('cate_type' => '1'))?>"> 酒店预订</a></li>-->
            <!--<li role="separator" class="divider"></li>-->
            <!--<li><a href="<?php  echo $this->createWebUrl($_GPC['do'], array('cate_type' => '2'))?>"> 影院订座</a></li>-->
            <!--<li role="separator" class="divider"></li>-->
            <!--<li><a href="<?php  echo $this->createWebUrl($_GPC['do'], array('cate_type' => '3'))?>"> 外卖点餐</a></li>-->
            <!--<li role="separator" class="divider"></li>-->
            <!--<li><a href="<?php  echo $this->createWebUrl($_GPC['do'], array('cate_type' => '4'))?>"> 微商城</a></li>-->

        </ul>
    </div>
</div>