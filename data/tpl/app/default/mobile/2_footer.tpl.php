<?php defined('IN_IA') or exit('Access Denied');?><div class="clearfix" ></div>
<?php  $cfg= $this->module['config']?>

<div class="copyright">
   <?php  if(!empty($cfg['footer'])) { ?><?php  echo $cfg['footer']?><?php  } ?></div>

<div class="footer_nav"></div>
<div class="wx_nav">

   <ul>
      <li>
         <a class="<?php  if($_GPC['do']=='index') { ?>active<?php  } ?>"
            href=" <?php  if(!empty($cfg['btn1_link'])) { ?><?php  echo $cfg['btn1_link']?><?php  } else { ?><?php  echo $this->createMobileUrl('index')?><?php  } ?>"  data-href="###" ptag="37080.1.1" ><em class="home"></em><p>
            <?php  if(!empty($cfg['btn1_name'])) { ?><?php  echo $cfg['btn1_name']?><?php  } else { ?>首页<?php  } ?></p></a>
      </li>
      <li>
         <a class="<?php  if(($_GPC['do']=='list' && $_GPC['type']=='9' )) { ?>active<?php  } ?>" href="<?php  if(!empty($cfg['btn2_link'])) { ?><?php  echo $cfg['btn2_link']?><?php  } else { ?><?php  echo $this->createMobileUrl('list',array('type'=>'9'))?><?php  } ?>" ptag="37080.1.2"><em class="list"></em><p><?php  if(!empty($cfg['btn2_name'])) { ?><?php  echo $cfg['btn2_name']?><?php  } else { ?>附近<?php  } ?></p></a>
      </li>
      <li>
         <a  href="<?php  if(!empty($cfg['btn3_link'])) { ?><?php  echo $cfg['btn3_link']?><?php  } ?>"  ptag="37080.1.3" >
            <?php  if(!empty($cfg['btn3_name'])) { ?> <em class="edit"></em><p><?php  echo $cfg['btn3_name']?></p><?php  } ?>
         </a>
      </li>
      <li>
         <a class="<?php  if(($_GPC['do']=='ring' || $_GPC['do']=='redpackage')) { ?>active<?php  } ?>" href="<?php  if(!empty($cfg['btn4_link'])) { ?><?php  echo $cfg['btn4_link']?><?php  } else { ?><?php  echo $this->createMobileUrl('redpackage')?><?php  } ?>"  ptag="37080.1.4"><em class="ring"></em><p><?php  if(!empty($cfg['btn4_name'])) { ?><?php  echo $cfg['btn4_name']?><?php  } else { ?>圈子<?php  } ?></p></a>
      </li>
      <li>
         <a class="<?php  if(($_GPC['do']=='user' || $_GPC['do']=='order'|| $_GPC['do']=='mylocal'|| $_GPC['do']=='myring')) { ?>active<?php  } ?>" href="<?php  if(!empty($cfg['btn5_link'])) { ?><?php  echo $cfg['btn5_link']?><?php  } else { ?><?php  echo $this->createMobileUrl('user')?><?php  } ?>"  ptag="37080.1.4"><em class="my"></em><p><?php  if(!empty($cfg['btn5_name'])) { ?><?php  echo $cfg['btn5_name']?><?php  } else { ?>我的<?php  } ?></p></a>
      </li>


   </ul>
</div>
<?php  if(empty($cfg['btn3']) || empty($cfg['btn3_name'])) { ?>
<div id="edit_banner">
      <img id="add" src="<?php echo STYLE;?>images/add2.png" onClick="showlist();"/>
   <img id="xadd"  class="none" src="<?php echo STYLE;?>images/xadd.png" onClick="showlist();"/>
   <div class="fabu">发布</div>
</div>
<?php  } ?>
<div id="showlist" class="none">
   <div class="fabuico">
      <a href="<?php  echo $this->createMobileUrl('msglist');?>">
      <img class="icon" src="<?php echo STYLE;?>images/fabu_1.png"/>
      <div class="icon-name">发布信息</div>
      </a>

      <?php  $isshop_admin=$this->isshop_admin();?>
      <?php  if(!empty($isshop_admin)) { ?>
      <a href="<?php  echo $this->createMobileUrl('shop_admin',array('shop_id'=>$isshop_admin['shop_id']))?>">
         <img class="icon" src="<?php echo STYLE;?>images/fabu_2.png"/>
         <div class="icon-name">店铺管理</div>
      </a>
      <?php  } else { ?>
      <a href="<?php  echo $this->createMobileUrl('user',array('op'=>'shop_in'));?>">
         <img class="icon" src="<?php echo STYLE;?>images/fabu_2.png"/>
         <div class="icon-name">商家入驻</div>
      </a>
      <?php  } ?>
   </div>

</div>
<style>
   <?php  if(!empty($cfg['btn1'])) { ?>
   .wx_nav ul li a em.home {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn1']?>) ;
   }
   <?php  } ?>
   <?php  if(!empty($cfg['btn2'])) { ?>
   .wx_nav ul li a em.list {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn2']?>) ;
   }
   <?php  } ?>
   <?php  if(!empty($cfg['btn3'])) { ?>
   .wx_nav ul li a em.edit {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn3']?>) ;
   }
   <?php  } ?>
   <?php  if(!empty($cfg['btn4'])) { ?>
   .wx_nav ul li a em.ring {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn4']?>) ;
   }
   <?php  } ?>
   <?php  if(!empty($cfg['btn5'])) { ?>
   .wx_nav ul li a em.my {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn5']?>) ;
   }
   <?php  } ?>

   <?php  if(!empty($cfg['btn1_hover'])) { ?>
   .wx_nav ul li a.active em.home {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn1_hover']?>) ;

   }
   <?php  } ?>
   <?php  if(!empty($cfg['btn2_hover'])) { ?>
   .wx_nav ul li a.active em.list {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn2_hover']?>) ;
   }
   <?php  } ?>
   <?php  if(!empty($cfg['btn3_hover'])) { ?>
   .wx_nav ul li a.active em.ring {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn3_hover']?>) ;

   }
   <?php  } ?>
   <?php  if(!empty($cfg['btn4_hover'])) { ?>
   .wx_nav ul li a.active em.edit {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn4_hover']?>);

   }
   <?php  } ?>
   <?php  if(!empty($cfg['btn5_hover'])) { ?>
   .wx_nav ul li a.active em.my {
      background-image:url(<?php  echo $_W['attachurl'].$cfg['btn5_hover']?>) ;

   }
   <?php  } ?>
</style>
<script>;</script><script type="text/javascript" src="http://tc.chen.com/app/index.php?i=2&c=utility&a=visit&do=showjs&m=yc_youliao"></script></body>
</html>