<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>
<section id="content">
<section >
    <section class="padder">
        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
            <li><a href="<?php  echo $this->createWebUrl('index')?>"><i class="fa fa-home"></i>首页</a></li>
            <li class="active">店铺管理</li>
        </ul>
        <ul class="nav nav-tabs">
            <li <?php  if($op =='display' && $type =='0') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop',array('op' =>'display'))?>">店铺管理</a></li>
            <li <?php  if($op =='display' && $type =='1') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop',array('op' =>'display','type' =>'1'))?>">已到期店铺</a></li>

            <?php  if($op =='post') { ?> <li  class="active" ><a href="<?php  echo $this->createWebUrl('shop_info',array('op' =>'post'))?>"> 编辑商家信息</a></li><?php  } ?>

        </ul>

        <div class="main">
            <div class="panel panel-info" >
                <div class="panel-body  table-responsive">
                    <div class="jsglNr">
                        <div class="selectNr" >
                            <div class="left">
                                <a href="<?php  echo $this->createWebUrl('shop_info',array('op' =>'post','add' =>'1'))?>">
                                    添加店铺</a>
                            </div>
                            <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/cate_type', TEMPLATE_INCLUDEPATH)) : (include template('web/cate_type', TEMPLATE_INCLUDEPATH));?>
                            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
                                <div class="right">
                                    <input type="text" name="keyword" value="<?php  echo $keyword;?>"  placeholder="请输入店铺名称" class="inptText" /><input type="submit" value="  搜索"  class="inptButton" />
                                </div>
                            </form>
                        </div>

                        <div class="tableBox">
                            <form action="" method="post" onsubmit="return formcheck(this)">
                            <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >
                                <tr class="theader">

                                    <th class="w50 order-by-input">排序</th>
                                    <td>编号</td>
                                    <td>所属行业</td>
                                    <td>区域</td>
                                    <td>商铺LOGO</td>
                                    <td>商铺名称</td>

                                    <?php  if($check!="1") { ?>
                                    <td>入驻时间</td>
                                    <td>是否开启	</td>
                                    <td>首页推荐	</td>
                                    <td>秒杀	</td>
                                    <td>拼团	</td>
                                    <td>优惠买单	</td>
                                    <?php  } else { ?>
                                    <td>状态	</td>
                                    <td>申请时间</td>
                                    <td>申请类型	</td>
                                    <?php  } ?>
                                    <td>操作</td>
                                </tr>
                                <?php  if(is_array($list)) { foreach($list as $item) { ?>

                                <tr>
                                    <td class="order-by-input"><input class="w50" name="displayorder[<?php  echo $item['shop_id'];?>]" value="<?php  echo $item['orderby'];?>" type="text" class="remberinput w80" /></td>
                                    <td><?php  echo $item['shop_id'];?></td>
                                    <td><?php  echo $item['cate_name'];?></td>
                                    <td><?php  echo $item['area_name'];?></td>
                                    <td class="shop-logo"> <img src="<?php  echo tomedia($item['logo']);?>"
                                         onerror="javascript:this.src='<?php echo SQ;?>public/images/noimg.png'"   />
                                    </td>
                                    <td><?php  echo $item['shop_name'];?></td>



                                    <?php  if($check=="1") { ?>
                                    <td>
                                        <?php  if($item['status']==0) { ?>
                                        <span class="label label-info">申请中<?php  } else if($item['status']==1) { ?>
                                        <span class="label label-success">正常
                                        <?php  } else if($item['status']==2) { ?>
                                        <span class="label label-danger">审核不通过
                                        <?php  } else if($item['status']==3) { ?>
                                         <span class="label label-warning">暂停中<?php  } ?></span>
                                    </td>
                                    <td>
                                       <?php  echo date('Y-m-d H:i', $item['applytime'])?>

                                    </td>
                                    <td>
                                        <?php  if($item['f_type']==1) { ?>
                                        <span class="label label-info">店铺入驻
                                       <?php  } else if($item['f_type']==2) { ?>
                                        <span class="label label-info">首页推荐
                                        <?php  } else if($item['f_type']==3) { ?>
                                         <span class="label label-info">秒杀专场
                                        <?php  } else if($item['f_type']==4) { ?>
                                         <span class="label label-info">拼团
                                         <?php  } else if($item['f_type']==5) { ?>
                                         <span class="label label-info">优惠买单
                                        <?php  } ?></span>
                                    </td>

                                    <td class="shoplist">
                                        <a class="bg" href="<?php  echo $this->createWebUrl('shop_info', array('op' => 'post' , 'shop_id' => $item['shop_id']))?>"><i class="fa fa-list"></i>查看申请</a>
                                        <?php  if($item['f_type']==1) { ?>
                                        <a class="bg" href="<?php  echo $this->createWebUrl('shop', array('op' => 'check' , 'opt' => '1','shop_id' => $item['shop_id']))?>">
                                            <?php  } else if($item['f_type']==2) { ?>
                                        <a class="bg"  href="javascript:;" onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_hot',1);">
                                            <?php  } else if($item['f_type']==3) { ?>
                                        <a class="bg" href="javascript:;" onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_time',1);">                                                  <?php  } else if($item['f_type']==4) { ?>
                                        <a class="bg" href="javascript:;" onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_group',1);">
                                            <?php  } else if($item['f_type']==5) { ?>
                                       <a class="bg" href="javascript:;" onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_discount',1);">
                                            <?php  } ?>
                                            <i class="bg fa fa-check "></i>  审核通过</a>
                                        <a class="bg" class="label label-danger pad-5" href="<?php  echo $this->createWebUrl('shop', array('op' => 'check' , 'opt' => '2','shop_id' => $item['shop_id']))?>"><i class="fa fa-exclamation-triangle"></i>审核不通过</a>

                                    </td>

                                    <?php  } else { ?>
                                    <td>
                                       <?php  echo date('Y-m-d H:i', $item['starttime'])?>
                                    </td>
                                    <td class="text-l">

                                        <label class="switch">
                                            <input type="checkbox" <?php  if($item['status']==1) { ?> onclick="opstatus(<?php  echo $item['shop_id'];?>,'status',3);" checked='checked'<?php  } else { ?>onclick="opstatus(<?php  echo $item['shop_id'];?>,'status',1);"<?php  } ?>>
                                            <span></span> </label>
                                    </td>

                                    <td class="text-l">
                                    <label class="switch">
                                        <input type="checkbox" <?php  if($item['is_hot']==1) { ?> onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_hot',0);" checked='checked'<?php  } else { ?>onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_hot',1);"<?php  } ?>>
                                        <span></span> </label>
                                    </td>
                                    <td class="text-l">

                                        <label class="switch">
                                            <input type="checkbox" <?php  if($item['is_time']==1) { ?> onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_time',0);" checked='checked'<?php  } else { ?>onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_time',1);"<?php  } ?>>
                                            <span></span> </label>
                                    </td>
                                    <td class="text-l">
                                        <label class="switch">
                                            <input type="checkbox" <?php  if($item['is_group']==1) { ?> onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_group',0);" checked='checked'<?php  } else { ?>onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_group',1);"<?php  } ?>>
                                            <span></span> </label>
                                    </td>
                                    <td class="text-l">
                                        <label class="switch">
                                            <input type="checkbox" <?php  if($item['is_discount']==1) { ?> onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_discount',2);" checked='checked'<?php  } else { ?>onclick="opstatus(<?php  echo $item['shop_id'];?>,'is_discount',1);"<?php  } ?>>
                                            <span></span> </label>
                                    </td>
                                    <td class="listbtn">
                                       <!--<a  href="<?php  echo $this->createWebUrl('shop_index', array( 'shop_id' => $item['shop_id']))?>" ><i class="fa fa-home"></i>店铺管理</a>-->
                                    <span class="shoplist bg">
                                        <div class="input-group select_btn deal_btn">

                                                <button type="button" class="btn dropdown-toggle bg" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                 <i class="fa fa-home"></i>管理
                                                    <span class="caret"></span>
                                                </button>
                                                <ul class="dropdown-menu">
                                                    <li>
                                                        <?php  if($type==1) { ?>
                                                         <a  href="<?php  echo $this->createWebUrl('shop_info', array( 'op' =>'post','shop_id' => $item['shop_id']))?>" ><i class="fa fa-home"></i>续期</a>
                                                        <?php  } else { ?>
                                                         <a  href="<?php  echo $this->createWebUrl('pro_req', array( 'shop_id' => $item['shop_id']))?>" ><i class="fa fa-home"></i>店铺管理</a>
                                                        <?php  } ?>
                                                        <div class="lineb"></div>
                                                              <?php $link1=$_W['siteroot'].'app/index.php?c=entry&shop_id='.$item['shop_id'].'&m=yc_youliao&do=login&i='.$_W['uniacid'];?>
                                                        <a   style="cursor:pointer" class="copyurl" data-url="<?php  echo $link1;?>" href="javascript:;" onclick="copyit();"><i class="fa fa-link" onclick="window.location.href='<?php  echo $link1;?>'"></i>复制后台管理链接</a>
                                                        <div class="lineb"></div>
                                                              <?php $link2=$_W['siteroot'].'app/index.php?c=entry&shop_id='.$item['shop_id'].'&m=yc_youliao&do=shop&i='.$_W['uniacid'];?>
                                                        <a   style="cursor:pointer" class="copyurl" data-url="<?php  echo $link2;?>" href="javascript:;" onclick="copyit();"><i class="fa fa-link" onclick="window.location.href='<?php  echo $link2;?>'"></i>复制手机端访问链接</a>
                                                             <div class="lineb"></div>
                                                        <?php $link3=$_W['siteroot'].'app/index.php?c=entry&shop_id='.$item['shop_id'].'&m=yc_youliao&do=shop_admin&i='.$_W['uniacid'];?>
                                                        <a   style="cursor:pointer" class="copyurl" data-url="<?php  echo $link3;?>"  href="javascript:;" onclick="copyit();"><i class="fa fa-link"  onclick="window.location.href='<?php  echo $link3;?>'"></i>复制手机端管理链接</a>



                                                    </li>

                                                </ul>

                                        </div>
                                        </span>
                                        <a class="label label-danger pad-5 " href="<?php  echo $this->createWebUrl('shop', array('op' => 'delete', 'shop_id' => $item['shop_id']))?>" onclick="return confirm('删除后不可恢复，确定要删除吗？');"><i class="fa fa-exclamation-triangle"></i>删除</a>

                                    </td>
                                    <?php  } ?>
                                </tr>

                                <?php  } } ?>
                            </table>
                                <span class="btn_44b549  orderblock shop-orderby"  >排序</span>
                                <?php  echo $pager;?>
                                <?php  if($list) { ?>

                                <div class="width100 btn2 order-by-input">
                                        <input name="submit" class="btn btn-primary i-t-md " value="提交" type="submit">
                                        <input name="token" value="<?php  echo $_W['token'];?>" type="hidden">

                                </div>
                            <?php  } ?>

                        </div>


                    </div>

                </div>


            </div>
        </div>
    </section>
</section>
</section>
</body>
</html>
