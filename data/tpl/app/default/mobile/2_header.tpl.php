<?php defined('IN_IA') or exit('Access Denied');?><!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" class="am-touch js cssanimations">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,minimum-scale=1,user-scalable=no">
    <meta content="yes" name="apple-mobile-web-app-capable">
    <meta content="black" name="apple-mobile-web-app-status-bar-style">
    <meta content="telephone=no" name="format-detection">
    <meta content="email=no" name="format-detection">
    <title><?php  if(!empty($title)) { ?><?php  echo $title;?><?php  } else { ?><?php  echo $this->module['config']['index_title']?><?php  } ?></title>
    <meta name="keywords" content="<?php  echo $title;?>" />
    <meta name="description" content="<?php  echo $setting['title'];?>--<?php  echo $title;?>" />
    <link rel="stylesheet" type="text/css" href="<?php echo MIHUA_STYLE;?>css/style.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo MIHUA_STYLE;?>css/common.css"/>
    <link rel="stylesheet" type="text/css" href="<?php echo MIHUA_STYLE;?>css/show_notice.css"  />
    <link rel="stylesheet" type="text/css" href="<?php echo MIHUA_STYLE;?>css/footer.css"/>
    <link  href="<?php echo MIHUA_STYLE;?>css/swiper-3.3.1.min.css" rel="stylesheet" type="text/css"/>
    <script type="text/javascript" src="<?php echo MIHUA_STYLE;?>js/jquery-2.1.4.min.js"></script>
    <script type="text/javascript" src="<?php echo MIHUA_STYLE;?>js/swiper-3.3.1.min.js"></script>
    <script type="text/javascript" src="<?php echo MIHUA_STYLE;?>js/dropload.min.js" ></script>
    <script type="text/javascript" src="<?php echo MIHUA_STYLE;?>js/lyz.delayLoading.min.js"></script>
    <script type="text/javascript" src="<?php echo MIHUA_STYLE;?>js/common.js"></script>
    <script type="text/javascript" src="<?php echo MIHUA_STYLE;?>js/mobile_basic.js"></script>
    <script type="text/javascript" src="<?php echo MIHUA_STYLE;?>js/base.js"></script>
    <?php  echo register_jssdk(false);?>
    <script>
        var deviceWidth = document.documentElement.clientWidth;
        document.documentElement.style.fontSize = deviceWidth / 7.5 + 'px';
        $(function(){
        wx.ready(function () {
            var c=window.location.href;
            sharedata = {
                title: "<?php  if(!empty($share_title)) { ?><?php  echo $share_title;?><?php  } else { ?><?php  echo $this->module['config']['share_title']?><?php  } ?>",
                desc: "<?php  if(!empty($share_info)) { ?><?php  echo $share_info;?><?php  } else { ?><?php  echo $this->module['config']['share_info']?><?php  } ?>",
                link: '<?php  echo $share_link;?>',
                imgUrl: "<?php  if(!empty($share_img)) { ?><?php  echo tomedia($share_img)?><?php  } else { ?><?php  echo tomedia($this->module['config']['share_img'])?><?php  } ?>",
                success: function(){
            },
            cancel: function(){
            }
        };
            wx.onMenuShareAppMessage(sharedata);
            wx.onMenuShareTimeline(sharedata);
            <?php  $lflag=$this->getLaction_flag();?>
            <?php  if($lflag==0 && ( $_GPC['do']=='changeadd' || $adv_type>0 )) { ?>
            //没有手动修改定位都需要重新获取实时定位
            wx.getLocation({
                success: function (res) {
                    var latitude = res.latitude; // 纬度，浮点数，范围为90 ~ -90
                    var longitude = res.longitude; // 经度，浮点数，范围为180 ~ -180。
                    var speed = res.speed; // 速度，以米/每秒计
                    var accuracy = res.accuracy; // 位置精度

                    $.ajax({
                        type: 'post',
                        url: "<?php  echo $this->createMobileUrl('index', array('op'=>'mapWeather'));?>",
                        data: {latitude: latitude, longitude:longitude},
                        dataType: 'json',
                        success: function (data) {
                            <?php  if($_GPC['do']=='changeadd') { ?>
                            $('.locatioaddress').text(data.address);
                            $('.formatted').text(data.formatted_address);
                            <?php  } ?>
                        }
                    });
                },
                cancel: function (res) {
                    //  alert('您拒绝授权获取地理位置');
                }
            });
            <?php  } ?>
        });
//提示关注
            $('#qr_code').click(function(){
                <?php  $url = tomedia('qrcode_'.$_W['acid'].'.jpg'); ?>
                showBigImage('<?php  echo $url;?>',$('#qr_code'));

            });
//扫描二维码
            $('#scan').click(function(){
                wx.scanQRCode();
            });
        })
        //同步数据
        $.ajax({
            url:'<?php  echo $this->createMobileUrl('ajax_req',array('op'=>'queue'));?>',
            type:'post',
            dataType:'json',
            success:function(data){
            }
        });
    </script>
</head>
<body>
<?php  $member= Member::isMember();?>
<?php  if($this->module['config']['qrcode_flag']==0 && $member==0) { ?>
<nav class="mui-bar mui-bar-tab" >
    <?php  $img = tomedia($_W['fans']['tag']['avatar']); ?>
    <img src="<?php  echo $img;?>" onerror="<?php echo MIHUA_STYLE;?>images/avatar_default.jpg" />
    <div class="mui-desc"><span><?php  echo $_W['fans']['nickname'];?></span><br>您还未关注<?php  echo $_W['account']['name'];?>！</div>
    <button id="qr_code" class="mui-btn mui-btn-warning">点击关注</button>
</nav>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('move_btn', TEMPLATE_INCLUDEPATH)) : (include template('move_btn', TEMPLATE_INCLUDEPATH));?>