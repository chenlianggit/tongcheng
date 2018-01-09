<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html lang="en" class="webapp">
<head>
<meta charset="utf-8" />
<title><?php  if($title) { ?><?php  echo $title;?>--<?php  } ?><?php  if($_W['uniaccount']['name']) { ?><?php  echo $_W['uniaccount']['name'];?><?php  } ?></title>
<meta name="description" content="<?php  if(empty($_W['page']['copyright']['description'])) { ?><?php  if(IMS_FAMILY != 'x') { ?>社区后台管理<?php  } ?><?php  } else { ?><?php  echo $_W['page']['copyright']['description'];?><?php  } ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="shortcut icon" href="<?php  echo $_W['siteroot'];?><?php  echo $_W['config']['upload']['attachdir'];?>/<?php  if(!empty($_W['setting']['copyright']['icon'])) { ?><?php  echo $_W['setting']['copyright']['icon'];?><?php  } else { ?>images/global/wechat.jpg<?php  } ?>"/>
<link href="./resource/css/bootstrap.min.css" rel="stylesheet">
<script type="text/javascript" src="../addons/yc_youliao/public/js/jquery-2.1.4.min.js"></script>
<script type="text/javascript" src="../addons/yc_youliao/public/js/app.v2.js"></script>
<script>var require = { urlArgs: 'v=20161011' };</script>
<?php  echo Util::web_register_jssdk();?>

<?php  if($_GPC['do']=='shop' ) { ?>
<script type="text/javascript" src="./resource/components/zclip/jquery.zclip.min.js"></script>
<?php  } else { ?>
<link href="./resource/css/common.css?v=20161011" rel="stylesheet">
<script type="text/javascript" src="./resource/js/app/util.js?v=20161011"></script>
<script type="text/javascript" src="./resource/js/app/common.min.js?v=20170802"></script>
<script type="text/javascript" src="../addons/yc_youliao/public/js/common.min.js?v=20161011"></script>
<?php  } ?>

<?php  if($_GPC['do']!='index' && $_GPC['do']!='shop_index'  ) { ?>
<script type="text/javascript" src="./resource/js/require.js?v=20161011"></script>
<?php  } ?>

<script type="text/javascript" src="./resource/js/app/config.js?v=20161011"></script>
<link rel="stylesheet" href="../addons/yc_youliao/public/css/app.v2.css" type="text/css" />
<link rel="stylesheet" href="../addons/yc_youliao/public/css/webstyle.css" type="text/css" cache="false" />
<link rel="stylesheet" href="../addons/yc_youliao/public/css/style.css" type="text/css" />
<script type="text/javascript" src="../addons/yc_youliao/public/js/common.js"></script>
<script type="text/javascript" src="../addons/yc_youliao/public/js/basic.js"></script>
<script type="text/javascript" src="../addons/yc_youliao/public/js/base.js"></script>



</head>
<body>
<section class="vbox">