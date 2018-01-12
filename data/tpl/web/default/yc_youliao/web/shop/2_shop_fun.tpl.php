<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_header', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_left', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_left', TEMPLATE_INCLUDEPATH));?>

<section id="content">
<section >
    <section class="padder">
        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
            <li><a href="<?php  echo $this->createWebUrl('shop_index')?>"><i class="fa fa-home"></i>首页</a></li>
            <li class="active">店铺功能管理</li>
        </ul>

        <ul class="nav nav-tabs">
            <li <?php  if($op =='display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_fun',array('op' =>'display'))?>">店铺功能管理</a></li>


        </ul>

        <div class="main">
            <link rel="stylesheet" href="../addons/yc_youliao/public/css/common.css" type="text/css" />
            <div class="panel panel-info" >
                <div class="panel-body  table-responsive">

                        <div class="tableBox">
                           <form action="" method="post" onsubmit="return formcheck(this)">
                           <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >
                                <tr class="theader">


                                    <td>商铺LOGO</td>
                                    <td>商铺名称</td>
                                    <td>入驻时间</td>
                                    <td>是否开启	</td>
                                    <td>首页推荐	</td>
                                    <td>秒杀	</td>
                                    <td>拼团	</td>
                                    <td>优惠买单	</td>
                                </tr>


                                <tr>

                                    <td class="shop-logo"> <img src="<?php  echo tomedia($item['logo']);?>"
                                         onerror="javascript:this.src='<?php echo SQ;?>public/images/noimg.png'"   />
                                    </td>
                                    <td><?php  echo $item['shop_name'];?></td>
                                    <td>
                                       <?php  echo date('Y-m-d H:i', $item['applytime'])?>

                                    </td>
                                    <td class="text-l">

                                        <label class="switch">
                                            <input type="checkbox" <?php  if($item['is_open']==1) { ?> onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_open',0);" checked='checked'<?php  } else { ?>onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_open',1);"<?php  } ?>>
                                            <span></span> </label>
                                    </td>
                                    <td class="listbtn">
                                    <?php  if($item['is_hot']==1) { ?>
                                        <i class="fa fa-check-square-o"></i>
                                    <?php  } else { ?>
                                    <a href="<?php  echo $this->createWebUrl('shop_fun', array('op' => 'post', 'f_type' => '2'))?>"><i class="fa fa-edit"></i>申请开通</a>
                                     <?php  } ?>
                                    </td>

                                    <td class="listbtn">
                                        <?php  if($item['is_time']==1) { ?>
                                        <i class="fa fa-check-square-o"></i>
                                        <?php  } else { ?>
                                        <a href="<?php  echo $this->createWebUrl('shop_fun', array('op' => 'post', 'f_type' => '3'))?>"><i class="fa fa-edit"></i>申请开通</a>
                                        <?php  } ?>
                                    </td>

                                    <td class="listbtn">
                                        <?php  if($item['is_group']==1) { ?>
                                        <i class="fa fa-check-square-o"></i>
                                        <?php  } else { ?>
                                        <a href="<?php  echo $this->createWebUrl('shop_fun', array('op' => 'post', 'f_type' => '4'))?>"><i class="fa fa-edit"></i>申请开通</a>
                                        <?php  } ?>
                                    </td>
                                    <td class="listbtn">
                                        <?php  if($item['is_discount']==1) { ?>
                                        <i class="fa fa-check-square-o"></i>
                                        <?php  } else { ?>
                                        <a href="<?php  echo $this->createWebUrl('shop_fun', array('op' => 'post', 'f_type' => '5'))?>"><i class="fa fa-edit"></i>申请开通</a>
                                        <?php  } ?>

                                    </td>

                                </tr>


                            </table>






                    </div>

                </div>

            </div>
        </div>
    </section>
</section>
</section>
</body>
</html>