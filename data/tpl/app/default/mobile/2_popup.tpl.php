<?php defined('IN_IA') or exit('Access Denied');?><?php  $advData= commonGetData::getAdv(14);?>
<?php  $adv= $advData['0'];?>
<?php  if($adv) { ?>
<!--首页弹出框广告-->

<script language="javascript" type="text/javascript" src="<?php echo STYLE;?>js/jquery.cookie.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo STYLE;?>js/flash.js"></script>
<script language="javascript" type="text/javascript" src="<?php echo STYLE;?>js/homead.js"></script>

<div id="indexheadpopup">
    <a class="closepop" href="javascript:;" onclick="indexheadpopup.style.display='none'">
        <img  src="<?php echo STYLE;?>images/f_close.png" />
    </a>
    <ul>
    <?php  if($adv['thumb']) { ?>
    <li><a href="<?php  if(empty($adv['link'])) { ?><?php  } else { ?><?php  echo $adv['link'];?><?php  } ?>">
        <?php  $height= getimagesize($_W['attachurl'].$adv['thumb'])?>
        <?php  $height= $height['1']?>
        <div id="popupimg"><?php  echo $height?></div>
        <img  src="<?php  echo $_W['attachurl'];?><?php  echo $adv['thumb'];?>" /></a></li>
    <?php  } ?>

    </ul>
</div>

<?php  } ?>