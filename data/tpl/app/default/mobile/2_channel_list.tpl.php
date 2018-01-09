<?php defined('IN_IA') or exit('Access Denied');?><div class="mmsg " >
    <div onclick="location.href = '<?php  if($mrow['autourl'] != '') { ?><?php  echo $mrow['autourl'];?><?php  } else { ?><?php  echo $this->createMobileUrl('detail',array('id'=>$zdrow['id']))?><?php  } ?>'">
    <div class="nickname" >
        <img src="<?php  echo $zdrow['avatar'];?>"/>
        <span class="nick-name"><?php  echo $zdrow['nickname'];?></span>
        <?php  if($zdrow['fmid']!=0 || $adv_type==1) { ?>
            <span class="moduname <?php  if($zdrow['mid']%5==0) { ?>color0<?php  } else if($zdrow['mid']%5==1) { ?> color1<?php  } else if($zdrow['mid']%5==2) { ?> color2<?php  } else if($zdrow['mid']%5==3) { ?> color3<?php  } else if($zdrow['mid']%5==4) { ?> color4<?php  } else if($zdrow['mid']%5==5) { ?>color5<?php  } ?>"><?php  echo $zdrow['modulename'];?></span>
        <?php  } ?>
    </div>
    <a class="list-chat" href='<?php  echo $this->createMobileUrl('chat',array('toopenid'=>$zdrow['openid']))?>'>
        <div class="span2 iconfont text-c dochat" ><img src="<?php echo STYLE;?>images/g_chat.png"><span class="pd-d">微聊</span></div>
    </a>


    <div class="clearfix"></div>
    <div class="mtitle" <?php  if(empty($zdrow['con']['thumbs'])) { ?>style="width: 100%"<?php  } ?>>
        <div class="title"><?php  if($zdrow['isding']==1) { ?><span class="zding">置顶</span> <?php  } ?> <?php  echo $zdrow['con']['title'];?></div>
        <div class="info-input">
            <?php  if($zdrow['con']['price']) { ?>
            <span class="redbox">￥<?php  echo $zdrow['con']['price'];?></span>
            <?php  } ?>
            <?php  if($zdrow['con']['xinshui']) { ?>
            <span class="redbox"><?php  echo $zdrow['con']['xinshui'];?></span>
            <?php  } ?>
            <?php  if($zdrow['con']['feiyong']) { ?>
            <span class="redbox">￥<?php  echo $zdrow['con']['feiyong'];?></span>
            <?php  } ?>

            <?php  if($zdrow['con']['ziding1']) { ?>
            <span class="redbox"><?php  echo $zdrow['con']['ziding1'];?></span>
            <?php  } ?>

            <?php  if($zdrow['con']['ziding2']) { ?>
            <span class="graybox"><?php  echo $zdrow['con']['ziding2'];?></span>
            <?php  } ?>

            <?php  if($zdrow['con']['yuanjia']) { ?>
            <span class="graybox line-through">￥<?php  echo $zdrow['con']['yuanjia'];?></span>
            <?php  } ?>

            <?php  if($zdrow['con']['huxing']) { ?>
            <span class="graybox"><?php  echo $zdrow['con']['huxing'];?></span>
            <?php  } ?>
            <?php  if($zdrow['con']['zhuangxiu']) { ?>
            <span class="graybox"><?php  echo $zdrow['con']['zhuangxiu'];?></span>
            <?php  } ?>
            <?php  if($zdrow['con']['age']) { ?>
            <span class="graybox"><?php  echo $zdrow['con']['age'];?>岁</span>
            <?php  } ?>
            <?php  if($zdrow['con']['zwtitle']) { ?>
            <span class="graybox"><?php  echo $zdrow['con']['zwtitle'];?></span>
            <?php  } ?>

            <?php  if($zdrow['con']['qiwangzw']) { ?>
            <span class="graybox"><?php  echo $zdrow['con']['qiwangzw'];?></span>
            <?php  } ?>
            <?php  if($zdrow['con']['xueli']) { ?>
            <span class="graybox"><?php  echo $zdrow['con']['xueli'];?></span>
            <?php  } ?>



        </div>
        <div>
            <?php  if($zdrow['con']['cfcity']) { ?>
            <div class="backbox">出发：<?php  echo $zdrow['con']['cfcity'];?></div>
            <?php  } ?>
            <?php  if($zdrow['con']['ddcity']) { ?>
            <div class="backbox">目的：<?php  echo $zdrow['con']['ddcity'];?></div>
            <?php  } ?>
            <?php  if($zdrow['con']['gotime']) { ?>
            <div class="backbox">出行时间：<?php  echo $zdrow['con']['gotime'];?></div>
            <?php  } ?>
        </div>
        <div class="info-checkbox">

            <?php  if($zdrow['con']['type']) { ?>
            <span class="greenbox"><?php  echo $zdrow['con']['type'];?></span>
            <?php  } ?>


            <?php  if($zdrow['con']['fuli']) { ?>
            <?php  if(is_array($zdrow['con']['fuli'])) { foreach($zdrow['con']['fuli'] as $fuli) { ?>
            <span class="greenbox"><?php  echo $fuli;?></span>
            <?php  } } ?>
            <?php  } ?>

            <?php  if($zdrow['con']['peizhi']) { ?>
            <?php  if(is_array($zdrow['con']['peizhi'])) { foreach($zdrow['con']['peizhi'] as $i) { ?>
            <span class="greenbox"><?php  echo $i;?></span>
            <?php  } } ?>
            <?php  } ?>

            <?php  if($zdrow['con']['ziding3']) { ?>
            <?php  if(is_array($zdrow['con']['ziding3'])) { foreach($zdrow['con']['ziding3'] as $i) { ?>
            <span class="greenbox"><?php  echo $i;?></span>
            <?php  } } ?>
            <?php  } ?>

        </div>

    </div>
    <?php  if($zdrow['con']['thumbs']) { ?>
    <div class="mimg" >
        <img src="<?php  echo $zdrow['con']['thumbs']['0'];?>" class="img2">
    </div>
    <?php  } ?>
</div>

<div class="fr">
    <?php  if($this->isShang()==0) { ?>
    <span class="shangWap" onclick="shang_show(<?php  echo $zdrow['id'];?>,'<?php  echo $zdrow['openid'];?>');"><span class="shang-icon" ></span></span>
    <?php  } ?>
        <span class="graybox timer">
    <?php  if($zdrow['freshtime']) { ?>
    <?php  echo $zdrow['freshtime'];?>
    <?php  } else { ?>
    <?php  echo $zdrow['createtime'];?>
    <?php  } ?>
        </span>
</div>
</div>
<div class="line"></div>