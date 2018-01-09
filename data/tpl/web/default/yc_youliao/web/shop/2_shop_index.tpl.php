<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_header', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_left', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_left', TEMPLATE_INCLUDEPATH));?>
<script src="../addons/yc_youliao/public/js/jquery.easy-pie-chart.js" cache="false"></script>
<script src="../addons/yc_youliao/public/js/jquery.sparkline.min.js" cache="false"></script>
<!-- /.aside -->
<section id="content">
    <section class="vbox">
        <section class=" padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
                <!--<li class="active">Workset</li>-->
            </ul>
            <div class="m-b-md">
                <h3 class="m-b-none">Overview</h3>
                <small>店铺统计概况</small> </div>
            <section class="panel panel-default panel2">
                <div class="row m-l-none m-r-none bg-light lter">
                    <a href="<?php  echo $this->createWebUrl('shop_member')?>">
                    <div class="col-sm-6 index-col-md-3 padder-z b-r b-light">
                        <span class="fa-stack fa-2x pull-left m-r-sm topicon" ><img src="<?php echo STYLE;?>images/member.png"/></span>
                        <a class="index-clear toptitle" href="<?php  echo $this->createWebUrl("shop_member")?>"> <span class="h3 block m-t-xs"><strong  id="members"><?php  echo $memberNum;?></strong></span> <span class="text-muted text-uc">粉丝总数</span> </a>
                        </a>
                    </div>

                    <div class="col-sm-6 index-col-md-3 padder-z b-r b-light lt">
                        <a  href="<?php  echo $this->createWebUrl('shop_goods')?>">
                        <span class="fa-stack fa-2x pull-left m-r-sm topicon" >  <img src="<?php echo STYLE;?>images/good.png"/></span>
                        <a class="index-clear toptitle" href="<?php  echo $this->createWebUrl("shop_goods")?>"> <span class="h3 block m-t-xs"><strong id="bugs"><?php  echo $goodNum;?></strong></span> <span class="text-muted text-uc">商品总数</span> </a>
                        </a>
                    </div>
                    <div class="col-sm-6 index-col-md-3 padder-z">
                        <a  href="<?php  echo $this->createWebUrl("shop_order")?>">
                        <span class="fa-stack fa-2x pull-left m-r-sm topicon" >  <img src="<?php echo STYLE;?>images/item.png"/></span>
                        <a class="index-clear toptitle" href="<?php  echo $this->createWebUrl("shop_order")?>"> <span class="h3 block m-t-xs"><strong id="firers"><?php  echo $orderNum;?></strong></span> <span class="text-muted text-uc">订单总数</span> </a>
                        </a>
                    </div>
                </div>
            </section>



            <div class="row">
                <div class="col-md-8">
                    <section class="panel panel-default">
                        <header class="panel-heading font-bold">近半月销量趋势图</header>

                        <div class="panel-body">
                            <div class="text-center m-b-n m-t-sm">
                                <div class="sparkline" data-type="line" data-height="65" data-width="100%" data-line-width="2"
                                     data-line-color="#dddddd" data-spot-color="#bbbbbb" data-fill-color="" data-highlight-line-color="#fff"
                                     data-spot-radius="3" data-resize="true" values="<?php  echo $yestdayNum14['num'];?>,<?php  echo $yestdayNum13['num'];?>,<?php  echo $yestdayNum12['num'];?>,<?php  echo $yestdayNum11['num'];?>,<?php  echo $yestdayNum10['num'];?>,<?php  echo $yestdayNum9['num'];?>,
                        <?php  echo $yestdayNum8['num'];?>,<?php  echo $yestdayNum7['num'];?>,<?php  echo $yestdayNum6['num'];?>,<?php  echo $yestdayNum5['num'];?>,<?php  echo $yestdayNum4['num'];?>,<?php  echo $yestdayNum3['num'];?>,
                        <?php  echo $yestdayNum2['num'];?>,<?php  echo $yestdayNum['num'];?>,<?php  echo $todayNum['num'];?>"></div>
                                <div class="sparkline inline" data-type="bar" data-height="45" data-bar-width="6" data-bar-spacing="6" data-bar-color="#65bd77">
                                    <?php  echo $yestdayNum14['num'];?>,<?php  echo $yestdayNum13['num'];?>,<?php  echo $yestdayNum12['num'];?>,<?php  echo $yestdayNum11['num'];?>,<?php  echo $yestdayNum10['num'];?>,<?php  echo $yestdayNum9['num'];?>,
                                    <?php  echo $yestdayNum8['num'];?>,<?php  echo $yestdayNum7['num'];?>,<?php  echo $yestdayNum6['num'];?>,<?php  echo $yestdayNum5['num'];?>,<?php  echo $yestdayNum4['num'];?>,<?php  echo $yestdayNum3['num'];?>,
                                    <?php  echo $yestdayNum2['num'];?>,<?php  echo $yestdayNum['num'];?>,<?php  echo $todayNum['num'];?></div>
                            </div>

                        </div>
                        <footer class="panel-footer bg-white no-padder">
                            <div class="row text-center no-gutter">
                                <div class="col-xs-3 b-r b-light">
                                    <a  href="<?php  echo $this->createWebUrl("order")?>">
                                    <span class="h4 font-bold m-t block"><?php  echo $todayNum['num'];?></span> <small class="text-muted m-b block">今日订单</small>
                                    </a>
                                </div>
                                <div class="col-xs-3 b-r b-light">
                                    <a  href="<?php  echo $this->createWebUrl("order")?>">
                                    <span class="h4 font-bold m-t block"><?php  echo $yestdayNum['num'];?></span> <small class="text-muted m-b block">昨日订单</small>
                                    </a>
                                </div>
                                <div class="col-xs-3 b-r b-light">
                                    <a  href="<?php  echo $this->createWebUrl("order")?>">
                                    <span class="h4 font-bold m-t block"><?php  echo $weekNum['num'];?></span> <small class="text-muted m-b block">最近一周</small>
                                    </a>
                                </div>
                                <div class="col-xs-3">
                                    <a  href="<?php  echo $this->createWebUrl("order")?>">
                                    <span class="h4 font-bold m-t block"><?php  echo $monthNum['num'];?></span> <small class="text-muted m-b block">最近一月</small>
                                    </a>
                                </div>

                            </div>
                        </footer>

                    </section>
                </div>

                <div class="col-md-4">
                    <section class="panel panel-default">
                        <header class="panel-heading font-bold">近半月销售金额</header>
                        <div class="bg-light dk wrapper">

                            <div class="text-center m-b-n m-t-sm">
                                <div class="sparkline" data-type="line" data-height="65" data-width="100%" data-line-width="2"
                                     data-line-color="#dddddd" data-spot-color="#bbbbbb" data-fill-color="" data-highlight-line-color="#fff"
                                     data-spot-radius="3" data-resize="true" values="<?php  echo $yestdayNum14['money'];?>,<?php  echo $yestdayNum13['money'];?>,<?php  echo $yestdayNum12['money'];?>,<?php  echo $yestdayNum11['money'];?>,<?php  echo $yestdayNum10['money'];?>,<?php  echo $yestdayNum9['money'];?>,<?php  echo $yestdayNum8['money'];?>,<?php  echo $yestdayNum7['money'];?>,<?php  echo $yestdayNum6['money'];?>,<?php  echo $yestdayNum5['money'];?>,<?php  echo $yestdayNum4['money'];?>,<?php  echo $yestdayNum3['money'];?>,
                        <?php  echo $yestdayNum2['money'];?>,<?php  echo $yestdayNum['money'];?>,<?php  echo $todayNum['money'];?>"></div>
                                <div class="sparkline inline" data-type="bar" data-height="45" data-bar-width="6" data-bar-spacing="6" data-bar-color="#65bd77"><?php  echo $yestdayNum14['money'];?>,<?php  echo $yestdayNum13['money'];?>,<?php  echo $yestdayNum12['money'];?>,<?php  echo $yestdayNum11['money'];?>,<?php  echo $yestdayNum10['money'];?>,<?php  echo $yestdayNum9['money'];?>,<?php  echo $yestdayNum8['money'];?>,<?php  echo $yestdayNum7['money'];?>,<?php  echo $yestdayNum6['money'];?>,<?php  echo $yestdayNum5['money'];?>,<?php  echo $yestdayNum4['money'];?>,<?php  echo $yestdayNum3['money'];?>,
                                    <?php  echo $yestdayNum2['money'];?>,<?php  echo $yestdayNum['money'];?>,<?php  echo $todayNum['money'];?></div>
                            </div>
                        </div>
                        <div class="panel-body">


                            <div class="row m-t-sm">
                                <div class="col-xs-3">
                                    <a  href="<?php  echo $this->createWebUrl("order")?>">
                                    <small class="text-muted block">今日</small> <span>￥<?php  echo $todayNum['money'];?></span>
                                    </a>
                                </div>
                                <div class="col-xs-3">
                                    <a  href="<?php  echo $this->createWebUrl("order")?>">
                                    <small class="text-muted block">昨日</small> <span>￥<?php  echo $yestdayNum['money'];?></span>
                                    </a>
                                </div>
                                <div class="col-xs-3">
                                    <a  href="<?php  echo $this->createWebUrl("order")?>">
                                    <small class="text-muted block">近一周</small> <span>￥<?php  echo $weekNum['money'];?></span>
                                    </a>
                                </div>
                                <div class="col-xs-3">
                                    <a  href="<?php  echo $this->createWebUrl("order")?>">
                                    <small class="text-muted block">近一月</small> <span>￥<?php  echo $monthNum['money'];?></span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8">
                    <h4 class="m-t-none">订单概览</h4>
                    <div class="btn-group m-b-xs">
                        <div class="btn btn-sm btn-default <?php  if(empty($status) or ($createtime == '1'&& $status == '7')) { ?>active<?php  } ?>">
                            <a href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'display', 'status' =>'-2', 'today' =>1))?>">今日订单</a> </div>
                        <div class="btn btn-sm btn-default <?php  if($status == '1' && ( $sendtype=='1' || $sendtype=='0') ) { ?>active<?php  } ?>">
                            <a href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'display', 'status' => 0))?>">待付款</a>
                        </div>


                        <div class="btn btn-sm btn-default <?php  if($status == '3') { ?>active<?php  } ?>">

                            <a href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'display', 'status' => -1))?>">全部订单</a> </div>
                    </div>
                    <ul class="list-group gutter list-group-lg list-group-sp sortable">

                        <li class="list-group-item box-shadow">
                            <div class="clear index-list-order gray">
                                <div class="index-ordernum"> 订单编号</div>
                                <div class="index-ordername"> 用户名</div>
                                <div class="index-ordermoney"> 订单金额</div>
                                <div class="index-time"> 下单时间</div>
                                <div class="index-status"> 订单状态</div>
                            </div>
                        </li>

                        <?php  if($list) { ?>
                        <?php  if(is_array($list)) { foreach($list as $item) { ?>
                        <li class="list-group-item box-shadow">
                            <a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $item['id']))?>">
                                <div class="clear index-list-order">
                                    <div class="index-ordernum"> <?php  echo $item['ordersn'];?></div>
                                    <?php  $userData= Member::getUserByid($item['userid'])?>
                                    <div class="index-ordername"> <?php  echo $userData['nickname'];?></div>
                                    <div class="index-ordermoney"> ￥<?php  echo $item['price'];?></div>
                                    <div class="index-time"> <?php  echo date('Y-m-d H:i:s', $item['createtime'])?></div>
                                    <div class="index-status">
                                        <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/order_status', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/order_status', TEMPLATE_INCLUDEPATH));?>

                                    </div>
                                </div>
                            </a>
                        </li>
                        <?php  } } ?>
                        <?php  } else { ?>
                        <li class="list-group-item box-shadow text-center">
                            暂无订单
                        </li>
                        <?php  } ?>
                    </ul>
                </div>
                <div class="col-md-4">
                    <section class="panel b-light">
                        <header class="panel-heading bg-primary dker no-border"><strong>订单留言</strong></header>

                        <?php  if($remark) { ?>
                        <?php  if(is_array($remark)) { foreach($remark as $re) { ?>
                        <div class="list-group">
                            <a href="<?php  echo $this->createWebUrl('order', array('op' => 'detail', 'id' => $re['id']))?>" class="list-group-item text-ellipsis">
                                <div class="index-ordersn">订单编号： <?php  echo $re['ordersn'];?>
                                    <!--<span class="username" >用户名：</span> -->
                                </div>

                                <?php  echo $re['remark'];?>
                            </a>
                        </div>
                        <?php  } } ?>
                        <?php  } else { ?>
                        <div class="list-group text-center">
                            暂无评论
                        </div>
                        <?php  } ?>
                    </section>


                </div>
            </div>
            <div>

        </section>
    </section>

    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>
