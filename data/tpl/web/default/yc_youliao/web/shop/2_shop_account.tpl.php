<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_header', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_left', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_left', TEMPLATE_INCLUDEPATH));?>

<section id="content">
<section class="vbox">
    <section class="padder">
        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
            <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
            <li class="active">资金管理</li>
        </ul>

        <ul class="nav nav-tabs">
            <li <?php  if($op =='display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_account',array('op' =>'display'))?>">资金流水</a></li>
            <li <?php  if($op =='record') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_account',array('op' =>'record'))?>">提现记录</a></li>
            <li <?php  if($op =='post') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_account',array('op' =>'post'))?>">申请提现</a></li>


        </ul>

        <div class="main">
            <div class="">
            <?php  if($op == 'display') { ?>
                <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/search_input', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/search_input', TEMPLATE_INCLUDEPATH));?>

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
                                    <a  href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'detail', 'id' => $item['ogid']))?>"
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
                                <a  href="<?php  echo $this->createWebUrl('shop_discount', array('op' => 'detail', 'id' => $item['id']))?>"
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
                                <td>金额</td>
                                <td><?php  echo $item['amount'];?></td>
                                <td>提现方式</td>
                                <td>状态</td>
                                <td>日期</td>
                            </tr>
                            <?php  if(is_array($list)) { foreach($list as $item) { ?>
                            <tr>
                                <td><?php  echo $item['ordersn'];?></td>
                                <td><?php  echo $item['amount'];?></td>
                                <td><?php  echo $item['transfer'];?></td>
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




            <?php  } else if($op == 'post') { ?>
                <div class="panel panel-info">
                    <header class="panel-heading font-bold">提现申请（提现到微信零钱请使用店铺管理手机端操作）</header>
                    <div class="panel-body">
                        <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 control-label"><span class="red">*</span>提现金额</label> <div class="col-sm-6 col-xs-6">
                                <input type="text" onkeyup="clearNoNum(this);"  name="money" class="form-control" placeholder="可提现金额<?php  echo $shop['balance'];?>元" value="<?php  echo $shop['balance'];?>">最小提现金额1元！
                            </div>
                    </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 control-label"><span class="red">*</span>开户银行</label> <div class="col-sm-6 col-xs-6">
                                <input value="<?php  echo $item['bank_name'];?>" type="text" name="bank_name" class="form-control" >
                            </div>
                    </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 control-label"><span class="red">*</span>开户账号</label> <div class="col-sm-6 col-xs-6">
                                <input type="text" value="<?php  echo $item['bank_num'];?>" name="bank_num"  class="form-control" >
                            </div>
                    </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 control-label"><span class="red">*</span>开户名</label>
                                <div class="col-sm-6 col-xs-6">
                                    <input type="text" value="<?php  echo $item['bank_realname'];?>" name="bank_realname" class="form-control" >
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 control-label">开户支行</label>
                                <div class="col-sm-6 col-xs-6">
                                <input type="text" value="<?php  echo $item['bank_branch'];?>" name="bank_branch"  class="form-control" >
                            </div>
                            </div>

                            <div class="width100 btn2">
                                <input name="submit" class="btn btn-primary i-t-md" value="提交" type="submit">
                                <input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
                <?php  } ?>
    </section>
</section>
</section>
</body>
</html>

