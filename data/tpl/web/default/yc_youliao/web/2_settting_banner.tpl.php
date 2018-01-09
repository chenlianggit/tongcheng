<?php defined('IN_IA') or exit('Access Denied');?><ul class="nav nav-tabs">
<li <?php  if($op =='display') { ?> class="active" <?php  } ?>><a href="<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=display">基础设置</a></li>
<li <?php  if($op =='page') { ?> class="active" <?php  } ?>><a href="<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=page">页面设置</a></li>
<li <?php  if($op =='shop') { ?> class="active" <?php  } ?>><a href="<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=shop">商户设置</a></li>
<li <?php  if($op=='share') { ?> class="active" <?php  } ?>><a href="<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=share">分享设置</a></li>
<li <?php  if($op=='btn') { ?> class="active" <?php  } ?>><a href="<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=btn">自定义导航</a></li>
<li<?php  if($_GPC['do'] == 'tpl') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('tpl')?>">模板消息设置</a></li>
<li <?php  if($op=='sign') { ?> class="active" <?php  } ?>><a href="<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=sign">请求参数设置</a></li>
<li <?php  if($op =='word') { ?> class="active" <?php  } ?>><a href="<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=word">敏感词设置</a></li>
</ul>