<?php defined('IN_IA') or exit('Access Denied');?><?php  if($cfg['show_service']==0 ||  ($cfg['show_service']==2 && $_GPC['do']=='index')) { ?>
<?php  if(!empty($cfg['service_btn']) && $service_flag!=1) { ?>
<?php  $w=$cfg['service_w']; $h=$cfg['service_h'];$b=$cfg['service_b']; $l=$cfg['service_l'];?>
<div id="service_btn"  style="<?php  if(!empty($w) && !empty($h)) { ?>width:<?php  echo $w;?>px; height:<?php  echo $h;?>px;<?php  } ?> <?php  if(!empty($b) ) { ?>bottom: <?php  echo $b;?>px;<?php  } ?> <?php  if(!empty($l) ) { ?>left: <?php  echo $l;?>px;<?php  } ?>">
	<a href="<?php  if(!empty($cfg['service_link'])) { ?><?php  echo $cfg['service_link']?><?php  } else { ?>#<?php  } ?>">
		<img src="<?php  echo tomedia($cfg['service_btn'])?>"
      style="<?php  if(!empty($w) && !empty($h)) { ?>width:<?php  echo $w;?>px; height:<?php  echo $h;?>px;<?php  } ?>  "></a>
</div>
<?php  } ?>
<?php  } else if($_GPC['do']=='good' || $_GPC['do']=='shop') { ?>
<?php  $serviceadmin=$this->getCustomerById($_GPC['shop_id']);?>
<?php  if($serviceadmin) { ?>
<?php  $w=$cfg['service_w']; $h=$cfg['service_h'];$b=$cfg['service_b']; $l=$cfg['service_l'];?>
<div id="service_btn" >
	<?php  if(is_array($serviceadmin)) { foreach($serviceadmin as $a) { ?>
	<a href="<?php  echo $this->createMobileUrl('chat',array('toopenid'=>$a['openid']))?>">
		<img src="<?php  echo tomedia($cfg['shop_service_btn'])?>" onerror="this.src='<?php  echo $a['avatar'];?>'; this.style='border-radius:50%;box-shadow: 1px 2px 2px #777;'" ></a>
	<?php  } } ?>
</div>
<?php  } ?>
<div style="display:none;">
	touchstart,touchmove,
	touchend,touchcancel
</div>
<script type="text/javascript">
var canmore = false;
$(function(){	
	var block = document.getElementById("service_btn");
  var oW,oH;
  // 绑定touchstart事件
  block.addEventListener("touchstart", function(e) {
   console.log(e);
   var touches = e.touches[0];
   oW = touches.clientX - block.offsetLeft;
   oH = touches.clientY - block.offsetTop;
   //阻止页面的滑动默认事件
   document.addEventListener("touchmove",defaultEvent,false);
  },false)
 
  block.addEventListener("touchmove", function(e) {
   var touches = e.touches[0];
   var oLeft = touches.clientX - oW;
   var oTop = touches.clientY - oH;
   if(oLeft < 0) {
    oLeft = 0;
   }else if(oLeft > document.documentElement.clientWidth - block.offsetWidth) {
    oLeft = (document.documentElement.clientWidth - block.offsetWidth);
   }
   block.style.left = oLeft + "px";
   block.style.top = oTop + "px";
  },false);
   
  block.addEventListener("touchend",function() {
   document.removeEventListener("touchmove",defaultEvent,false);
  },false);
  function defaultEvent(e) {
   e.preventDefault();
  }
})
</script>


<?php  } ?>