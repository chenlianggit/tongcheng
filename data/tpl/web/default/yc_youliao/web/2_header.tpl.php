<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header_common', TEMPLATE_INCLUDEPATH)) : (include template('web/header_common', TEMPLATE_INCLUDEPATH));?>
  <header class="bg-dark dk header navbar navbar-fixed-top-xs headerlogo">
    <div class="navbar-header "> <a class="btn btn-link visible-xs" data-toggle="class:nav-off-screen" data-target="#nav"> <i class="fa fa-bars"></i> </a> <a href="#" class="navbar-brand" data-toggle="fullscreen">
       
       <?php  if($_W['uniacid']) { ?>
       <?php  $img = tomedia('headimg_'.$_W['uniacid'].'.jpg');  ?>
			 <img src="<?php  if($img) { ?><?php  echo tomedia('headimg_'.$_W['uniacid'].'.jpg');?><?php  } ?>"onerror="this.src='../addons/yc_youliao/public/images/gw-wx.gif'" />
      <?php  } ?>

      <?php  echo $_W['uniaccount']['name'];?></a> <a class="btn btn-link visible-xs" data-toggle="dropdown" data-target=".nav-user"> <i class="fa fa-cog"></i> </a> </div>
   
    <ul class="nav navbar-nav navbar-right hidden-xs nav-user">
     
      <li class="dropdown hidden-xs"> <a href="javascript:;" onclick="javascript:history.back(-1);" class="dropdown-toggle " data-toggle="dropdown">
				<i class="fa fa-fw fa-mail-reply" title="返回上一页"></i></a>
      </li>
      <li class="dropdown">
			<a>
					 <span class="thumb-sm avatar pull-left"> <img src="../addons/yc_youliao/public/images/avatar_default.jpg"> </span>
					 <?php  echo $_W['username'];?>
			</a>	
        
      </li>
			 <li class="dropdown">

                 <a href="<?php  echo $_W['siteroot'];?>/app/<?php  echo $this->createMobileUrl('login')?>">
					 <i class="fa fa-fw fa-sign-out" title="退出"></i>
						
					 </span>
					
					 </a>
        
      </li>
    </ul>
  </header>

