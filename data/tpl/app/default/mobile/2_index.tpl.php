<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../mobile/header', TEMPLATE_INCLUDEPATH)) : (include template('../mobile/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../mobile/popup', TEMPLATE_INCLUDEPATH)) : (include template('../mobile/popup', TEMPLATE_INCLUDEPATH));?>
<link  href="<?php echo STYLE;?>css/index.css" rel="stylesheet" type="text/css">
<div id="home-hd-bar">
    <a href="<?php  echo $this->createMobileUrl('changeadd')?>">
        <div class="city-layout">
            <span id="nowcity"><?php  echo $this->getAddress()?></span>
        </div>
    </a>
    <div class="search-layout">
       <a href="<?php  echo $this->createMobileUrl('search');?>">  <span class="search iconfont"><img src="<?php echo STYLE;?>images/b_search.png"/></span></a>
        <span class="icon iconfont" id="scan"><img src="<?php echo STYLE;?>images/g_scan.png"/></span>
    </div>

</div>

<?php  $advs= commonGetData::getAdv($adv_type);?>
<!--头部广告-->

<?php  if(!empty($advs)) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../mobile/adv1', TEMPLATE_INCLUDEPATH)) : (include template('../mobile/adv1', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>

<?php  if($msg) { ?>
<div class="noticeWap">
    <span class="noticeTxt">公告</span>
    <div class="noticeConWap">
        <ul class="noticeLists">
            <?php  if(is_array($msg)) { foreach($msg as $i => $m) { ?>
            <li class="noticeList">
                <a href="<?php  echo $this->createMobileUrl('user', array('op' => 'msg','msg_id' => $m['msg_id']))?>">
                    <span class="time"><?php  echo date("m-d",$m['add_time'])?></span>
                    <div class="cont"><?php  echo $m['msg_title'];?></div>
                </a>
            </li>
            <?php  } } ?>
        </ul>
    </div>
    <div class="closeWap">
        <div class="close-icon"></div>
    </div>
</div>
<script>
    $(function () {
        var listsLen
        var i = 1
        var timer
        var ul = $('.noticeWap .noticeLists')
        listsLen = ul.children().length
        timer = setInterval(function () {
            if (i == listsLen){
                i = 0
            }
            ul.css({transform: 'translateY(-'+ i * 42 + 'px)'})
            i++
        }, 3000)
        $('.noticeWap .closeWap').on('touchend', function () {
            clearInterval(timer)
            $('.noticeWap').hide()
        })
    })
</script>
<?php  } ?>
<div class="weather">
    <div class="nav_time_left">
    <img id="img_type"/>
    <div class="left">
        <div id="fx"></div>
        <div id="high"></div>
    </div>
        <span id="type"></span>

    </div>

    <?php  $qdurl=$this->createMobileUrl('qiandao');?>
    <div class="nav_time_right qiandao" <?php  if($jifen) { ?> onClick="qiandao('<?php  echo $qdurl;?>');"<?php  } ?>>
        <?php  if(!empty($qian_flag)) { ?>
        <?php  echo $qian_flag;?>
        <?php  } else if($jifen) { ?>
         签到 <span class="tishi"><?php  echo $jifen;?></span>
        <?php  } ?>

    </div>

</div>

<!--同城频道-->
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../mobile/channel_icon', TEMPLATE_INCLUDEPATH)) : (include template('../mobile/channel_icon', TEMPLATE_INCLUDEPATH));?>

<!--足迹-->
<?php  $footmark=commonGetData::getFoot($userinfo['id']);$footmark=$footmark['content']?>
<?php  if(!empty($footmark)) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../mobile/footmark', TEMPLATE_INCLUDEPATH)) : (include template('../mobile/footmark', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<div class="clear relative"></div>
<!--今日置顶-->
<?php  if($zdmessagelist) { ?>
<div class="huadong">
    <div class="huabox">
        <div class="hdimg"><img src="<?php echo STYLE;?>images/jrtt.png"></div>
        <div class="notice_active">
            <ul>
                <?php  if(is_array($zdmessagelist)) { foreach($zdmessagelist as $zdrow) { ?>
                <li class="notice_active_ch" onClick="location.href='<?php  echo $this->createMobileUrl('detail',array('id'=>$zdrow['id']))?>'">
                   <div> <span class="red">[<?php  echo $zdrow['modulename'];?>] </span><em><?php  echo $zdrow['createtime'];?></em></div>
                    <?php  echo $zdrow['con']['title'];?>

                    <div class="gg_more">
                    <a title="news_more" href="<?php  echo $this->createMobileUrl('msglist',array('id'=>$zdrow['mid'],'zhiding'=>1))?>">更多<img src="<?php echo STYLE;?>images/right.png"/></a>
                    </div>
                </li>
                <?php  } } ?>
            </ul>
        </div>

    </div>
</div>
<?php  } ?>
<?php  if($cfg['showShop']!=2) { ?>
<!--商家频道开始-->
<div class="sy_tese mb10">
    <ul>
        <li class="list listOne">
            <a href="<?php  echo $this->createMobileUrl('list', array('type' =>4))?>">
                <div class="box">
                    <h3 class="colr_1"><em class="ico"></em>全民拼团</h3>
                    <p>爱拼才会赢 轻松拼好货</p>
                    <img src="<?php echo STYLE;?>images/teseImg1.png">
                </div>
            </a>
        </li>
        <li class="list listThree">
            <a href="<?php  echo $this->createMobileUrl('list', array('type' =>7))?>">
                <div class="box">
                    <img src="<?php echo STYLE;?>images/teseImg3.png">
                    <div class="pub_wz">
                        <h3 class="colr_3"><em class="ico"></em>优惠买单</h3>
                        <p>你买单 我贴钱</p>
                    </div>
                </div>
            </a>
        </li>
        <li class="list listThree">
            <a href="<?php  echo $this->createMobileUrl('list', array('type' =>6))?>">
                <div class="box">
                    <img src="<?php echo STYLE;?>images/teseImg5.png">
                    <div class="pub_wz">
                        <h3 class="colr_4"><em class="ico"></em>首单优惠</h3>
                        <p>新人独享 抄底价</p>
                    </div>
                </div>
            </a>
        </li>
    </ul>
    <div class="clear"></div>
</div>

<?php  } ?>
<!--同城信息展示-->
<?php  if(empty($cfg['showChannel']) || $cfg['showChannel']==1) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../mobile/channel', TEMPLATE_INCLUDEPATH)) : (include template('../mobile/channel', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>

<div class="redTop" style="display: none">
    <div class="topBan">
      <div class="t-haf checked" data-id="0">土豪榜</div>
      <div class="t-haf" data-id="1">抢钱榜</div>
      <div class="t-mask"></div>
    </div>
    <div class="topListWap">
      <div class="ulWap clearfix">
        <ul class="money type0">
          <li class="list">
          <div class="avatar"><img class="img" src="http://wx.qlogo.cn/mmopen/xZH5xsscnGSnNDyNhHuOc7PZLB4lMV5CnOJLj2M9w5qI6p98Xdk4ia15clYwYWia4Ihj6b77h7yzNmVTzZKBjKJgZ6zRt22pPt/132"></div>
          <div class="name">
            <p class="t">名字名字</p>
            <p class="b">第一名</p>
          </div>
          <div class="num">
            <span class="icon"></span>
            <span style="color:#fb5100;">18.88元</span>
          </div>
        </li>
        <li class="list">
          <div class="avatar"><img class="img" src="http://wx.qlogo.cn/mmopen/xZH5xsscnGSnNDyNhHuOc7PZLB4lMV5CnOJLj2M9w5qI6p98Xdk4ia15clYwYWia4Ihj6b77h7yzNmVTzZKBjKJgZ6zRt22pPt/132"></div>
          <div class="name">
            <p class="t">名字名字</p>
            <p class="b">第二名</p>
          </div>
          <div class="num">
            <span class="icon"></span>
            <span style="color:#fb5100;">18.88元</span>
          </div>
        </li>
    </ul>
    <ul class="money type1">
        <li class="list">
          <div class="avatar"><img class="img" src="http://wx.qlogo.cn/mmopen/xZH5xsscnGSnNDyNhHuOc7PZLB4lMV5CnOJLj2M9w5qI6p98Xdk4ia15clYwYWia4Ihj6b77h7yzNmVTzZKBjKJgZ6zRt22pPt/132"></div>
          <div class="name">
            <p class="t">名字名字</p>
            <p class="b">第一名</p>
          </div>
            <div class="num">
              <span class="icon"></span>
              <span style="color:#fb5100;">18.88元</span>
            </div>
            </li>
            <li class="list">
              <div class="avatar"><img class="img" src="http://wx.qlogo.cn/mmopen/xZH5xsscnGSnNDyNhHuOc7PZLB4lMV5CnOJLj2M9w5qI6p98Xdk4ia15clYwYWia4Ihj6b77h7yzNmVTzZKBjKJgZ6zRt22pPt/132"></div>
              <div class="name">
                <p class="t">名字名字</p>
                <p class="b">第二名</p>
              </div>
              <div class="num">
                <span class="icon"></span>
                <span style="color:#fb5100;">18.88元</span>
              </div>
            </li>
        </ul>
      </div>
    </div>
</div>
<script>
    $('.t-haf').on('click', function () {
        var _this = $(this)
        _this.siblings('.checked').removeClass('checked')
        _this.addClass('checked')
        $('.t-mask').css({ 'transform': 'translateX(' + _this.data('id') + '00%)' })
        $('.ulWap').css({ 'transform': 'translateX(-' + _this.data('id') * 50 + '%)' })
    })
</script>

<?php  $advs2= commonGetData::getAdv(2);?>
<?php  if($advs2) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../mobile/adv2', TEMPLATE_INCLUDEPATH)) : (include template('../mobile/adv2', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>

<!--秒杀开始-->
<div class="xsqg" style="<?php  if(empty($xsms)) { ?>display:none;<?php  } ?>">
    <div class="xshead ">
        <div class="nav_time_left">
            <span class="nav_time_end" id="nav_time_title">距离结束</span>
            <span class="nav_time_change" id="nav_time_hour">00</span>:
            <span class="nav_time_change" id="nav_time_minute">00</span>:
            <span class="nav_time_change" id="nav_time_second">00</span>
        </div>
        <div class="nav_time_right">
            <a href="<?php  echo $this->createMobileUrl('xsms')?>"> 更多 <img src="<?php echo STYLE;?>images/right.png"/>
            </a>
        </div>
    </div>
    <div class="clearfix" ></div>
    <div  class="swiper-container-horizontal swiper-container-free-mode">
        <div class="swiper-container" id="seck">

            <div class="swiper-wrapper ">
                <?php  if(is_array($xsms)) { foreach($xsms as $item) { ?>
                <div class="swiper-slide">
                    <a href="<?php  echo $this->createMobileUrl('good', array('shop_id' => $item['shop_id'],'id' => $item['goods_id']))?>">

                        <img class="tub1" src="<?php  echo $_W['attachurl'];?><?php  echo $item['thumb'];?>" alt="">
                        <div class="name"><?php  echo $item['title'];?></div>
                        <div class="price">¥ <?php  echo $item['time_money'];?>
                            <?php  if($item['marketprice']) { ?>
                            <span class="oldp">¥ <?php  echo $item['marketprice'];?></span>
                            <?php  } ?>
                        </div>
                    </a>
                </div>
                <?php  } } ?>
            </div>
        </div>
    </div>
</div>
<script>
    var mySwiper = new Swiper('#seck',{
        slidesPerView : 3,
        slidesPerGroup : 3,
        prevButton:'.swiper-button-prev',
        nextButton:'.swiper-button-next',

    })
</script>
<!--秒杀结束-->


<!--推荐店铺开始-->
<?php  if($shoplist) { ?>
    <div class="shop-title">
        <span><i class="icon iconfont icon-xing"></i>为您推荐</span>
        <div></div>
    </div>
<div class="shop-list">
    <ul id="mihua_sq_list" class="am-cf">
        <?php  if(is_array($shoplist)) { foreach($shoplist as $item) { ?>
        <li class="shop-list-li">
            <a href="<?php  echo $this->createMobileUrl('shop', array('shop_id' => $item['shop_id']))?>">
                <div class="shop-list-li-img">
                   <img class="lazy inline"  src="<?php  echo $_W['attachurl'];?><?php  echo $item['logo'];?>" onerror="this.src='<?php  echo tomedia($cfg['shop_logo'])?>'">
                </div>

                <div class="shop-list-info">
                        <?php  $distance= util::getDistance($item['lat'], $item['lng'], $_COOKIE['lat'], $_COOKIE['lng']);?>
                        <?php  if($distance>0) { ?>
                        <div class="y"><?php  echo $distance;?>km</div>
                        <?php  } ?>
                        <div class="wap1 mr_5 title"><?php  echo $item['shop_name'];?></div>

                    <div>
                        <?php  if(!empty($item['dp']) && $item['dp']>0) { ?>
                        <div class="shop_star_s mr_10"><img src="<?php echo STYLE;?>images/<?php  if($item['dp']>=5) { ?>5x<?php  } else if($item['dp']>=4 && $item['dp']<=4.9) { ?>4x<?php  } else if($item['dp']>=3 && $item['dp']<=3.9) { ?>3x<?php  } else if($item['dp']>=2&& $item['dp']<=2.9) { ?>2x<?php  } else if($item['dp']>=1 && $item['dp']<=1.9) { ?>1x<?php  } else { ?>0x<?php  } ?>.png"></span></div>
                        <?php  } ?>
                        <?php  if($item['renjun']>0) { ?>
                        <div class="renjun"><cite>￥</cite><?php  echo $item['renjun'];?>/人</div>
                    <?php  } ?>

                    <div class="shop-list-addr">
                        <div class="wap1">
                            <?php  $item['inco']=json_decode($item['inco'])?>
                            <?php  if(is_array($item['inco'])) { foreach($item['inco'] as $i) { ?>
                            <i><?php  echo $i;?></i>
                            <?php  } } ?>
                        </div>
                    </div>
                </div>
            </a>
        </li>

        <?php  } } ?>
    </ul>

</div>
<?php  } ?>




</div>
</div>

<!--商铺结束-->


<!--底部广告-->
<?php  $advs3= commonGetData::getAdv(3);?>
<?php  if($advs3) { ?>
<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../mobile/adv3', TEMPLATE_INCLUDEPATH)) : (include template('../mobile/adv3', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<div style="display:none;">
    touchstart,touchmove,
    touchend,touchcancel
</div>

<?php (!empty($this) && $this instanceof WeModuleSite) ? (include $this->template('../mobile/footer', TEMPLATE_INCLUDEPATH)) : (include template('../mobile/footer', TEMPLATE_INCLUDEPATH));?>
<script>
    $(function(){
        //显示地理位置
        var address = getCookie('address');
        if(address!=''){
            $('#nowcity').text(address);
        }
        //显示天气
        var data='<?php  echo $weatherdata;?>';
        var res=eval("("+data+")");
        var high = res.data.forecast[0].high;
        var low = res.data.forecast[0].low;
        high = high.replace('高温 ', '');
        low = low.replace('低温 ', '');
        $('#high').text(low + " ~ " + high);
        $('#fx').text(res.data.forecast[0].date);
        var type = res.data.forecast[0].type;
        $('#type').text(type);
        if (type.indexOf('云') > 0) {
            $("#img_type").attr("src", "<?php echo STYLE;?>images/dy.png");
        } else if (type.indexOf('雨') > 0) {
            $("#img_type").attr("src", "<?php echo STYLE;?>images/by.png");
        } else if (type.indexOf('阴') > 0) {
            $("#img_type").attr("src", "<?php echo STYLE;?>images/y.png");
        } else {
            $("#img_type").attr("src", "<?php echo STYLE;?>images/dy.png");
        }
    });
    setInterval(getRTime, 1000); //页面倒计时使用
    var stage = "<?php  echo $stage;?>"; //页面场次标识
    var id = ""; //场次信息
    var current_status = "<?php  echo $current_status;?>"; //0待秒杀 1秒杀中 2已结束

    var obj;
    function getRTime(){
        if(current_status == "0"){ //距离开始
            var timestart = "<?php  echo $xsms[$stage]['timestart'];?>";
            //截取小时 分钟
            var hour = timestart.substring(0, 2);
            var minute = timestart.substring(3, 5);
            var EndTime= new Date(); //截止时间
            if(parseInt(hour) < EndTime.getHours()){ //若第一场小时小于当前时间小时 说明是第二天
                EndTime.setDate(EndTime.getDate() + 1);
            }
            EndTime.setHours(hour, minute, 0);

            var NowTime = new Date();
            var t =EndTime.getTime() - NowTime.getTime();

            var d=Math.floor(t/1000/60/60/24);  //天
            var h=Math.floor(t/1000/60/60%24); //时
            var m=Math.floor(t/1000/60%60);  //分
            var s=Math.floor(t/1000%60); //秒

            $("#nav_time_title").html('距离开始');
            var hour = String(d*24 + h);
            if(hour.length == 1){
                hour = 0 + hour;
            }
            $("#nav_time_hour").html(hour);
            var minute = String(m);
            if(minute.length == 1){
                minute = 0 + minute;
            }
            $("#nav_time_minute").html(minute);
            var second = String(s);
            if(second.length == 1){
                second = 0 + second;
            }
            $("#nav_time_second").html(second);
        }else if(current_status == "1"){ //距结束
            var timeend = "<?php  echo $xsms[$stage]['timeend'];?>";
            //截取小时 分钟
            var hour = timeend.substring(0, 2);
            var minute = timeend.substring(3, 5);
            var EndTime= new Date(); //截止时间
            if(parseInt(hour) < EndTime.getHours()){ //若第一场小时小于当前时间小时 说明是第二天
                EndTime.setDate(EndTime.getDate() + 1);
            }
            EndTime.setHours(hour, minute, 0);

            var NowTime = new Date();
            var t =EndTime.getTime() - NowTime.getTime();

            var d=Math.floor(t/1000/60/60/24);  //天
            var h=Math.floor(t/1000/60/60%24); //时
            var m=Math.floor(t/1000/60%60);  //分
            var s=Math.floor(t/1000%60); //秒

            $("#nav_time_title").html('距离结束');
            var hour = String(d*24 + h);
            if(hour.length == 1){
                hour = 0 + hour;
            }
            $("#nav_time_hour").html(hour);
            var minute = String(m);
            if(minute.length == 1){
                minute = 0 + minute;
            }
            $("#nav_time_minute").html(minute);
            var second = String(s);
            if(second.length == 1){
                second = 0 + second;
            }
            $("#nav_time_second").html(second);
        }else {
            $("#nav_time_title").html('已结束');
        }
    }


</script>
