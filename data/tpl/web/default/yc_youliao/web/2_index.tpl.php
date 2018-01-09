<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>
<script src="../addons/yc_youliao/public/js/jquery.easy-pie-chart.js" cache="false"></script>
<script src="../addons/yc_youliao/public/js/jquery.sparkline.min.js" cache="false"></script>
<!-- /.aside -->
<div id="content">
    <div class="vbox">
        <div class="scrollable padder">
            <div class="m-b-md i-t-md">
                <div class="panel panel-default">
                    <div class="row m-l-none m-r-none bg-light lter">
                        <div class="col-sm-6 col-md-3 padder-v b-r b-light"> <span class="fa-stack fa-2x pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-info"></i>
                        <i class="fa fa-male fa-stack-1x text-white"></i> </span>
                            <a href="<?php  echo $this->createWebUrl('member')?>"> <span class="h3 block m-t-xs">
                            <strong><?php  echo $fansnum;?></strong></span> <small class="text-muted text-uc">粉丝</small>
                            </a> </div>
                        <div class="col-sm-6 col-md-3 padder-v b-r b-light lt"> <span class="fa-stack fa-2x pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-warning"></i>
                        <i class="fa fa-sitemap fa-stack-1x text-white"></i>
                        <span class="easypiechart pos-abt" ></span> </span>
                            <a  href="<?php  echo $this->createWebUrl('shop')?>"> <span class="h3 block m-t-xs">
                            <strong id="bugs"><?php  echo $shopnum;?></strong></span> <small class="text-muted text-uc">商户</small>
                            </a> </div>
                        <div class="col-sm-6 col-md-3 padder-v b-r b-light"> <span class="fa-stack fa-2x pull-left m-r-sm">
                        <i class="fa fa-circle fa-stack-2x text-danger"></i>
                        <i class="fa fa-user fa-stack-1x text-white"></i>
                        <span class="easypiechart pos-abt" ></span> </span>
                            <a href="<?php  echo $this->createWebUrl('info')?>"> <span class="h3 block m-t-xs"><strong id="firers"><?php  echo $infonum;?></strong></span> <small class="text-muted text-uc">同城信息</small> </a> </div>
                        <div class="col-sm-6 col-md-3 padder-v b-r b-light lt"> <span class="fa-stack fa-2x pull-left m-r-sm"> <i class="fa fa-circle fa-stack-2x icon-muted"></i> <i class="fa fa-users fa-stack-1x text-white"></i> </span>
                            <a href="#"> <span class="h3 block m-t-xs"><strong><?php  echo $ringnum;?></strong></span> <small class="text-muted text-uc">圈子</small> </a> </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-default">
                            <header class="panel-heading font-bold">发布信息趋势图（单位：条）</header>
                            <div class="panel-body">
                                <div class="text-center m-b-n m-t-sm">
                                    <div class="sparkline" data-type="line" data-height="65" data-width="100%" data-line-width="2"
                                         data-line-color="#dddddd" data-spot-color="#bbbbbb" data-fill-color="" data-highlight-line-color="#fff"
                                         data-spot-radius="3" data-resize="true" values="<?php  echo $yestdayNum14['num'];?>,<?php  echo $yestdayNum13['num'];?>,<?php  echo $yestdayNum12['num'];?>,<?php  echo $yestdayNum11['num'];?>,<?php  echo $yestdayNum10['num'];?>,<?php  echo $yestdayNum9['num'];?>,
                        <?php  echo $yestdayNum8['num'];?>,<?php  echo $yestdayNum7['num'];?>,<?php  echo $yestdayNum6['num'];?>,<?php  echo $yestdayNum5['num'];?>,<?php  echo $yestdayNum4['num'];?>,<?php  echo $yestdayNum3['num'];?>,
                        <?php  echo $yestdayNum2['num'];?>,<?php  echo $yestdayNum['num'];?>,<?php  echo $todayNum['num'];?>"></div>
                                    <div class="sparkline inline" data-type="bar" data-height="65" data-bar-width="6" data-bar-spacing="6" data-bar-color="#65bd77">
                                        <?php  echo $yestdayNum14['num'];?>,<?php  echo $yestdayNum13['num'];?>,<?php  echo $yestdayNum12['num'];?>,<?php  echo $yestdayNum11['num'];?>,<?php  echo $yestdayNum10['num'];?>,<?php  echo $yestdayNum9['num'];?>,
                                        <?php  echo $yestdayNum8['num'];?>,<?php  echo $yestdayNum7['num'];?>,<?php  echo $yestdayNum6['num'];?>,<?php  echo $yestdayNum5['num'];?>,<?php  echo $yestdayNum4['num'];?>,<?php  echo $yestdayNum3['num'];?>,
                                        <?php  echo $yestdayNum2['num'];?>,<?php  echo $yestdayNum['num'];?>,<?php  echo $todayNum['num'];?></div>
                                </div>
                            </div>
                            <footer class="panel-footer bg-white no-padder">
                                <div class="row text-center no-gutter">
                                    <div class="col-xs-3 b-r b-light"> <span class="h4 font-bold m-t block"><?php  echo $infotoday['num'];?></span> <small class="text-muted m-b block">今天</small> </div>
                                    <div class="col-xs-3 b-r b-light"> <span class="h4 font-bold m-t block"><?php  echo $infoyestday['num'];?></span> <small class="text-muted m-b block">昨天</small> </div>
                                    <div class="col-xs-3 b-r b-light"> <span class="h4 font-bold m-t block"><?php  echo $infoweek['num'];?></span> <small class="text-muted m-b block">本周</small> </div>
                                    <div class="col-xs-3"> <span class="h4 font-bold m-t block"><?php  echo $infomonth['num'];?></span> <small class="text-muted m-b block">本月</small> </div>
                                </div>
                            </footer>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="panel panel-default">
                            <header class="panel-heading font-bold">店铺订单（单位：元）
                            </header>
                            <div class="bg-light dk wrapper">
                                <div class="text-center m-b-n m-t-sm">
                                    <div class="sparkline" data-type="line" data-height="65" data-width="100%" data-line-width="2" data-line-color="#dddddd" data-spot-color="#bbbbbb" data-fill-color="" data-highlight-line-color="#fff" data-spot-radius="3" data-resize="true"
                                         values="<?php  echo $orderyestdayNum14['num'];?>,<?php  echo $orderyestdayNum13['num'];?>,<?php  echo $orderyestdayNum12['num'];?>,<?php  echo $orderyestdayNum11['num'];?>,<?php  echo $orderyestdayNum10['num'];?>,<?php  echo $orderyestdayNum9['num'];?>,
<?php  echo $orderyestdayNum8['num'];?>,<?php  echo $orderyestdayNum7['num'];?>,<?php  echo $orderyestdayNum6['num'];?>,<?php  echo $orderyestdayNum5['num'];?>,<?php  echo $orderyestdayNum4['num'];?>,<?php  echo $orderyestdayNum3['num'];?>,
<?php  echo $orderyestdayNum2['num'];?>,<?php  echo $orderyestdayNum['num'];?>,<?php  echo $todayNum['num'];?>"></div>
                                    <div class="sparkline inline" data-type="bar" data-height="45" data-bar-width="6" data-bar-spacing="6" data-bar-color="#65bd77"><?php  echo $orderyestdayNum14['num'];?>,<?php  echo $orderyestdayNum13['num'];?>,<?php  echo $orderyestdayNum12['num'];?>,<?php  echo $orderyestdayNum11['num'];?>,<?php  echo $orderyestdayNum10['num'];?>,<?php  echo $orderyestdayNum9['num'];?>,
                                        <?php  echo $orderyestdayNum8['num'];?>,<?php  echo $orderyestdayNum7['num'];?>,<?php  echo $orderyestdayNum6['num'];?>,<?php  echo $orderyestdayNum5['num'];?>,<?php  echo $orderyestdayNum4['num'];?>,<?php  echo $orderyestdayNum3['num'];?>,
                                        <?php  echo $orderyestdayNum2['num'];?>,<?php  echo $orderyestdayNum['num'];?>,<?php  echo $todayNum['num'];?></div>
                                </div>
                            </div>
                            <div class="panel-body">

                                <div class="line pull-in"></div>
                                <div class="row m-t-sm">
                                    <div class="col-xs-3"> <small class="text-muted block">今天</small> <span class="mutednum"><?php  echo $ordertoday['num'];?></span> </div>
                                    <div class="col-xs-3"> <small class="text-muted block">昨天</small> <span class="mutednum"><?php  echo $orderyestday['num'];?></span> </div>
                                    <div class="col-xs-3"> <small class="text-muted block">本周</small> <span class="mutednum"><?php  echo $orderweek['num'];?></span> </div>
                                    <div class="col-xs-3"> <small class="text-muted block">本月</small> <span class="mutednum"><?php  echo $ordermonth['num'];?></span> </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div>
                    <!-- .最近作业 -->
                    <?php  if($lastedmessagelist) { ?>
                    <div class="col-md-8">
                        <div class="comment-list block">
                            <article class="comment-item"> <span class="fa-stack pull-left m-l-xs in-fa-stack"> <i class="fa fa-circle text-info fa-stack-2x"></i> <i class="fa fa-hand-o-down text-white fa-stack-1x"></i> </span>
                                <div class="comment-body m-b-lg">
                                    <header> <a href="#"><strong>最新同城信息</strong></a> </header>

                                </div>
                            </article>
                            <!-- .最近作业loop 最新5条-->
                            <?php  if(is_array($lastedmessagelist)) { foreach($lastedmessagelist as $zdrow) { ?>
                            <article  class="comment-item"> <a class="pull-left thumb-sm avatar" href="<?php  echo $this->createWebUrl('info',array('op'=>'post','id'=>$zdrow['id']))?>"><img src="<?php  echo $zdrow['avatar'];?>" class="img-circle"></a> <span class="arrow left"></span>
                                <div class="comment-body panel panel-default">
                                    <header class="panel-heading"> <a href="<?php  echo $this->createWebUrl('info',array('op'=>'post','id'=>$zdrow['id']))?>"><?php  echo $zdrow['nickname'];?></a>
                                        <label class="label bg-success m-l-xs <?php  if($zdrow['mid']%5==0) { ?>color0<?php  } else if($zdrow['mid']%5==1) { ?> color1<?php  } else if($zdrow['mid']%5==2) { ?> color2<?php  } else if($zdrow['mid']%5==3) { ?> color3<?php  } else if($zdrow['mid']%5==4) { ?> color4<?php  } else if($zdrow['mid']%5==5) { ?>color5<?php  } ?>"><?php  echo $zdrow['modulename'];?></label>
                                        <span class="text-muted m-l-sm pull-right"> <i class="fa fa-clock-o"></i> <?php  echo date("Y-m-d H:s:i",$zdrow['createtime']);?></span> </header>
                                    <div class="panel-body">
                                        <div class="homeworktitle"><?php  echo $zdrow['con']['title'];?></div>
                                        <?php  if($zdrow['con']['thumbs']) { ?>
                                        <div class="mimg">
                                            <?php  if(is_array($zdrow['con']['thumbs'])) { foreach($zdrow['con']['thumbs'] as $i) { ?>
                                            <img src="<?php  echo $_W['attachurl'];?><?php  echo $i;?>" class="img2">
                                            <?php  } } ?>
                                        </div>
                                        <?php  } ?>
                                        <div class="comment-action m-t-sm textright"> <a href="#comment-id-3" data-dismiss="alert" class="btn btn-default btn-xs">  <?php  echo $zdrow['city'];?><?php  echo $zdrow['district'];?> </a> </div>
                                    </div>
                                </div>
                            </article>
                            <?php  } } ?>

                            <!-- loop end-->
                            <span class="fa-stack pull-left m-l-xs i-i-co"> <i class="fa fa-circle text-info fa-stack-2x"></i> <i class="fa fa-hand-o-up text-white fa-stack-1x"></i> </span>
                        </div>
                        <a href="<?php  echo $this->createWebUrl('info')?>" class="btn btn-default btn-sm m-b more-btn"><i class="fa fa-plus icon-muted"></i><span class="listmore">查看更多</span></a> </div>
                </div>
            </div>

<?php  } ?>

            <!-- .圈子 -->
            <?php  if($list) { ?>
            <div class="col-md-4">
                <div class="comment-list block">
                    <article id="comment-id-1" class="comment-item"> <span class="fa-stack pull-left m-l-xs in-fa-stack"> <i class="fa fa-circle text-info fa-stack-2x"></i> <i class="fa fa-hand-o-down text-white fa-stack-1x"></i> </span>
                        <div class="comment-body m-b-lg">
                            <header> <a href="#"><strong>圈子动态</strong></a> </header>

                        </div>
                    </article>
                    <!-- .最近班级圈loop 最新5条-->
                    <?php  if(is_array($list)) { foreach($list as $item) { ?>
                    <article id="comment-id-3" class="comment-item"> <a href="<?php  echo $this->createWebUrl('ring',array('op'=>'post','id'=>$item['ring_id']))?>" class="pull-left thumb-sm avatar"><img src="<?php  echo $item['avatar'];?>" class="img-circle"></a> <span class="arrow left"></span>
                        <div class="comment-body panel panel-default" onclick="location.href='<?php  echo $this->createWebUrl('ring',array('op'=>'post','id'=>$item['ring_id']))?>'">
                            <header class="panel-heading list-avatar"> <a href="<?php  echo $this->createWebUrl('ring',array('op'=>'post','id'=>$item['ring_id']))?>"><?php  echo $item['nickname'];?></a>
                                <span class="text-muted m-l-sm pull-right"> <i class="fa fa-clock-o"></i> <?php  echo date('Y-m-d H:i', $item['addtime'])?></span> </header>
                            <div class="panel-body grademsg" >
                                <div class="homeworktitle" > <?php  echo $item['info'];?></div>

                                <?php  if($item['xsthumb']) { ?>
                                <?php  $num=count($item['xsthumb'])?>
                                <div class="ming">
                                <?php  if(is_array($item['xsthumb'])) { foreach($item['xsthumb'] as $i) { ?>
                                <img class="pic mainImg" <?php  if($num==1) { ?>style=width:200px;height:auto;<?php  } else if($num==2) { ?>style=width:100px;height:auto;<?php  } ?> src="<?php  echo $i;?>" alt=""/>
                                <?php  } } ?>
                                </div>
                                <?php  } ?>
                                <div class="comment-action m-t-sm textright"> <a data-dismiss="alert" class="btn btn-default btn-xs"> <?php  echo $item['znum'];?>人赞 <span class="ml-15"><?php  echo $item['pnum'];?>人评论</span>  </a> </div>
                            </div>
                        </div>
                    </article>
<?php  } } ?>

                    <!-- .最近班级圈loop end-->
                    <span class="fa-stack pull-left m-l-xs i-i-co"> <i class="fa fa-circle text-info fa-stack-2x"></i> <i class="fa fa-hand-o-up text-white fa-stack-1x"></i> </span>
                </div>
                <a href="<?php  echo $this->createWebUrl('ring')?>" class="btn btn-default btn-sm m-b more-btn"> <span class="listmore">查看更多</span></a> </div>
        </div>
    </div>
    <?php  } ?>
</div>
</div>

</div>
</div>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>
