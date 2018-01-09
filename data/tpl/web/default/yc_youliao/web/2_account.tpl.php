<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>
<section id="content">
<section class="vbox">
    <section class="padder">
        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
            <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
            <li class="active">资金管理</li>
        </ul>
        <ul class="nav nav-tabs">
            <li <?php  if($op =='check_post') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('account',array('op' =>'check_post'))?>">审核提现</a></li>
            <li <?php  if($op =='display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('account')?>" > 资金流水</a></li>
            <li <?php  if($op =='record') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('account',array('op' =>'record'))?>">提现记录</a></li>


        </ul>

        <div class="main">
            <div class="">
                <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/search_input', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/search_input', TEMPLATE_INCLUDEPATH));?>
            <?php  if($op == 'display') { ?>
                <div class="col-sm-6 mt15 mb10">
                    <div class="theader trhead tr-2 h-30 pl-15">商品订单<span class="ml_15">（资金记录为：已完成订单，支持退款订单需超过7天期限）</span></div>
                       <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >
                            <tr></tr>
                            <tr class="theader">
                                <td>订单编号</td>
                                <td>金额</td>
                                <td>日期</td>
                                <td>查看</td>
                            </tr>
                            <?php  if(is_array($list)) { foreach($list as $item) { ?>
                            <tr>
                                <td><?php  echo $item['ordersn'];?></td>
                                <td>+ ￥<?php  echo $item['price'];?></td>
                                <td><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></td>
                                <td>
                                    <a  href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'detail', 'id' => $item['ogid'],'shop_id' => $item['shop_id']))?>"
                                        class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="查看详情"><i class="fa fa-pencil"></i>
                                    </a>
                                </td>
                            </tr>
                           <?php  } } ?>
                        </table>
                    <?php  echo $pager;?>
                </div>
                <div class="col-sm-6 mt15 mb10">
                    <div class="theader trhead tr-2 h-30 pl-15">优惠买单</div>
                    <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >

                        <tr class="theader">
                            <td>订单编号</td>
                            <td>金额</td>
                            <td>日期</td>
                            <td>查看</td>
                        </tr>
                        <?php  if(is_array($list2)) { foreach($list2 as $item) { ?>
                        <tr>
                            <td><?php  echo $item['ordersn'];?></td>
                            <td>+ ￥<?php  echo $item['paymoney'];?></td>
                            <td><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></td>
                            <td>
                                <a  href="<?php  echo $this->createWebUrl('shop_discount', array('op' => 'detail', 'shop_id' => $item['shop_id'], 'id' => $item['id']))?>"
                                    class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="查看详情"><i class="fa fa-pencil"></i>
                                </a>
                            </td>
                        </tr>
                        <?php  } } ?>
                    </table>
                    <?php  echo $pager2;?>
                </div>

            <?php  } else if($op == 'record') { ?>

                <div class="tableBox">
                    <form action="" method="post" onsubmit="return formcheck(this)">
                        <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >

                            <tr class="theader">
                                <td >编号</td>
                                <td >商户</td>
                                <td>金额</td>
                                <td>手续费</td>
                                <td>商户管理ID</td>
                                <td>提现方式</td>
                                <td>状态</td>
                                <td>日期</td>
                            </tr>
                            <?php  if(is_array($list)) { foreach($list as $item) { ?>
                            <tr>
                                <td><?php  echo $item['ordersn'];?></td>
                                <td ><?php  echo Shop::getShop_name($item['shop_id'])?></td>
                                <td><?php  echo $item['amount'];?></td>
                                <td><?php  echo $item['transfer'];?></td>
                                <td><?php  echo $item['admin_id'];?></td>
                                <td> <?php  if($item['paytype']=='1') { ?>微信<?php  } else if($item['paytype']=='2') { ?> 支付宝
            <?php  } else if($item['paytype']=='3') { ?>银行卡<?php  } ?></td>
                                <td> <?php  if($item['status']=='0') { ?><span class="red"> 未审核</span><?php  } else if($item['status']=='1') { ?> <span class="green"> 已提现</span>
                                    <?php  } else if($item['status']=='2') { ?> <span class="warning"> 已驳回</span><?php  } ?></td>
                                <td><?php  echo date('Y-m-d H:i', $item['addtime'])?></td>
                            </tr>
                            <?php  } } ?>
                        </table>
                    </form>
                </div>




            <?php  } else if($op == 'check_post') { ?>
                <div class="tableBox">
                    <form action="" method="post" onsubmit="return formcheck(this)">
                        <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >

                            <tr class="theader">
                                <td >编号</td>
                                <td >商户</td>
                                <td>金额</td>
                                <td>手续费</td>
                                <td>商户管理ID</td>
                                <td>提现方式</td>
                                <td>日期</td>
                                <td>操作</td>
                            </tr>
                            <?php  if(is_array($list)) { foreach($list as $item) { ?>
                            <tr>
                                <td><?php  echo $item['ordersn'];?></td>
                                <td ><?php  echo Shop::getShop_name($item['shop_id'])?></td>
                                <td><?php  echo $item['amount'];?></td>
                                <td><?php  echo $item['transfer'];?></td>
                                <td><?php  echo $item['admin_id'];?></td>
                                <td> <?php  if($item['paytype']=='1') { ?>微信<?php  } else if($item['paytype']=='2') { ?> 支付宝
                                    <?php  } else if($item['paytype']=='3') { ?>银行卡<?php  } ?></td>
                                <td><?php  echo date('Y-m-d H:i', $item['addtime'])?></td>

                                <td class="listbtn">
                                    <a  href="<?php  echo $this->createWebUrl('account',   array('op' => 'detail', 'cash_id' => $item['cash_id']))?>" ><i class="fa fa-home"></i>查看详情</a>
                                    <a class="label label-success  " href="javascript:;"  onclick="check_account(this,1,<?php  echo $item['cash_id'];?>)" ><i class="fa fa-check"></i>审核通过</a>
                                    <a class="label label-danger pad-5 " href="javascript:;" onclick="check_account(this,2,<?php  echo $item['cash_id'];?>)"><i class="fa fa-exclamation-triangle"></i>审核驳回</a>

                                </td>
                            </tr>
                            <?php  } } ?>
                        </table>
                    </form>
                </div>


                <?php  } else if($op == 'detail') { ?>

                <?php  } ?>
    </section>
</section>
</section>
</body>
</html>

