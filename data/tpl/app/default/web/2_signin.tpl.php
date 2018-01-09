<?php defined('IN_IA') or exit('Access Denied');?>﻿<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title><?php  if($_W['uniaccount']['name']) { ?><?php  echo $_W['uniaccount']['name'];?><?php  } else { ?>后台登录<?php  } ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<link rel="stylesheet" href="../addons/yc_youliao/public/css/app.v2.css" type="text/css" />
<link rel="stylesheet" href="../addons/yc_youliao/public/css/webstyle.css" type="text/css" cache="false" />
<style>
  body{
    background:url('../addons/yc_youliao/public/images/loginbg.png') no-repeat ;
    background-size:cover;

  }
</style>

</head>
<body>

  <div class="detailimg">
    <img src="../addons/yc_youliao/public/images/loginleft.png"/>
  </div>
<section id="content" class="m-t-lg wrapper-md animated fadeInUp">
  <div class="container aside-xxl"> <a class="navbar-brand block" href="#"></a>
    <section class="login-bg m-t-lg">
      <header class="text-center"><img src="../addons/yc_youliao/public/images/index-ico.png"/></header>
      <form action="<?php  echo $this->createMobileUrl('loginup')?>" class="panel-body wrapper-lg" method="post">
        <div class="form-group">
          <label class="control-label">用户名</label>
          <input type="" placeholder="username" name="username" class="form-control loginform">
        </div>
        <div class="form-group">
          <label class="control-label">密码</label>
          <input type="password"  name="password"  id="inputPassword" placeholder="Password" class="form-control loginform">
        </div>
        <div class="checkbox">
          <label>
            <input type="checkbox">
           记住用户名 </label>
        </div>
       
        <button type="submit" class="longin-btn-primary">登&nbsp;录</button>
        
      </form>
    </section>
  </div>
</section>
<footer id="footer">
  <div class="text-center padder">
    <p> <br>
     <?php  if(!empty($_W['setting']['copyright']['footerleft'])) { ?><?php  echo $_W['setting']['copyright']['footerleft'];?><?php  } ?></small> </p>
  </div>
</footer>

<script>;</script><script type="text/javascript" src="http://tongcheng.iweiji.cc/app/index.php?i=2&c=utility&a=visit&do=showjs&m=yc_youliao"></script></body>
</html>
