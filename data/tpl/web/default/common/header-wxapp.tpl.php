<?php defined('IN_IA') or exit('Access Denied');?><img src="<?php  echo tomedia('headimg_'.$_W['account']['acid'].'.jpg')?>?time=<?php  echo time()?>" class="head-logo">
<span class="wxapp-name"><?php  echo $wxapp_info['name'];?></span>
<span class="wxapp-version"><?php  echo $version_info['version'];?></span>
<div class="pull-right">
	<a href="<?php  echo url('wxapp/version/display', array('uniacid' => $version_info['uniacid']))?>" class="color-default"><i class="wi wi-cut"></i>切换版本</a>
	<?php  if(in_array($role, array(ACCOUNT_MANAGE_NAME_OWNER, ACCOUNT_MANAGE_NAME_MANAGER)) || $_W['isfounder']) { ?>
	<a href="<?php  echo url('wxapp/manage/display', array('uniacid' => $version_info['uniacid']))?>" class="color-default"><i class="wi wi-text"></i>管理</a>
	<?php  } ?>
	<a href="<?php  echo url('wxapp/display')?>" class="color-default"><i class="wi wi-small-routine"></i>切换小程序</a>
</div>