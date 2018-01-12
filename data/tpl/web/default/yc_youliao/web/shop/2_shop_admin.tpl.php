<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_header', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_left', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_left', TEMPLATE_INCLUDEPATH));?>

<section id="content">
<section >
    <section class="padder">
        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
            <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
            <li class="active">管理员</li>
        </ul>

        <ul class="nav nav-tabs">
            <li <?php  if($op =='display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_admin',array('op' =>'display'))?>">管理员列表</a></li>
            <?php  if($op =='post') { ?> <li  class="active" ><a href="<?php  echo $this->createWebUrl('shop_admin',array('op' =>'post'))?>"> 编辑管理员信息</a></li><?php  } ?>

        </ul>

        <div class="main">
            <link rel="stylesheet" href="../addons/yc_youliao/public/css/common.css" type="text/css" />
            <?php  if($op == 'display') { ?>
            <div class="panel panel-info" >
                <div class="panel-body  table-responsive">
                    <div class="jsglNr">
                        <div class="selectNr" >
                            <div class="left">
                                <?php  if($admin_flag==1) { ?>
                                <?php  $opt1="admin_status";?>
                                <?php  $opt2="msg_flag";?>
                                <a href="<?php  echo $this->createWebUrl('shop_admin',array('op' =>'post'))?>">
                                    添加店铺管理员</a>
                                <?php  } else { ?>
                                <?php  $opt1="a_admin_status";?>
                                <?php  $opt2="a_msg_flag";?>
                                <a href="<?php  echo $this->createWebUrl('admin',array('op' =>'post'))?>">
                                    添加管理员</a>
                                <?php  } ?>
                            </div>

                            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
                                <div class="right">
                                    <input type="text" name="keyword" value="<?php  echo $keyword;?>"  placeholder="请输入用户名" class="inptText" /><input type="submit" value="  搜索"  class="inptButton" />
                                </div>
                            </form>
                        </div>

                        <div class="tableBox">
                            <form action="" method="post" onsubmit="return formcheck(this)">
                            <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >
                                <tr class="theader">

                                    <td>头像</td>
                                    <td>用户名</td>
                                    <td>用户角色</td>

                                    <td>状态</td>
                                    <td>下单通知</td>
                                    <td>操作</td>
                                </tr>
                                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                                <tr>
                                    <td class="shop-logo"> <img src="<?php  echo tomedia($item['avatar']);?>"
                                                                onerror="javascript:this.src='<?php echo STYLE;?>images/avatar_default.jpg'"   />
                                    </td>
                                    <td><?php  echo $item['passport'];?></td>

                                    <td title="超级管理员：全部权限 <br/> 操作员：商品管理、订单管理、核销订单 | 核销员：仅能核销订单"><?php  if($item['admin_type']==1) { ?>超级管理员<?php  } else if($item['admin_type']==2) { ?>操作员<?php  } else if($item['admin_type']==3) { ?>核销员<?php  } ?></td>
                                    <td class="text-l">
                                        <label class="switch">

                                            <input type="checkbox" <?php  if($item['status']==0) { ?> onclick="adminstatus(<?php  echo $item['admin_id'];?>,'<?php  echo $opt1;?>',1);" checked='checked'<?php  } else { ?>onclick="adminstatus(<?php  echo $item['admin_id'];?>,'<?php  echo $opt1;?>',0);"<?php  } ?>>
                                            <span></span> </label>
                                    </td>
                                    <td class="text-l">
                                        <label class="switch">
                                            <input type="checkbox" <?php  if($item['msg_flag']==0) { ?> onclick="adminstatus(<?php  echo $item['admin_id'];?>,'<?php  echo $opt2;?>',1);" checked='checked'<?php  } else { ?>onclick="adminstatus(<?php  echo $item['admin_id'];?>,'<?php  echo $opt2;?>',0);"<?php  } ?>>
                                            <span></span> </label>
                                    </td>


                                    <td class="listbtn">
                                        <a href="<?php  echo $this->createWebUrl('shop_admin', array('op' => 'post', 'admin_id' => $item['admin_id']))?>"><i class="fa fa-edit"></i>修改</a>
                                        <a class="label label-danger pad-5 " href="<?php  echo $this->createWebUrl('shop_admin', array('op' => 'delete', 'admin_id' => $item['admin_id']))?>"><i class="fa fa-exclamation-triangle"></i>删除</a>
                                    </td>

                                </tr>

                                <?php  } } ?>
                            </table>

                                <?php  echo $page;?>
                                <?php  if($list) { ?>

                                <div class="width100 btn2 order-by-input">
                                        <input name="submit" class="btn btn-primary i-t-md " value="提交" type="submit">
                                        <input name="token" value="<?php  echo $_W['token'];?>" type="hidden">

                                </div>
                            <?php  } ?>


                        </div>


                    </div>

                </div>

                <?php  } else if($op == 'post') { ?>

                <div class="panel panel-info" >

                    <form  action="" method="post" class="form-horizontal form" enctype="multipart/form-data">

                        <div>

                            <div class='panel-body'>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span> 选择管理员</label>
                                    <div class="col-md-6">

                                        <input type='hidden' id='openid' name='openid' value="<?php  if($_GPC['openid']) { ?><?php  echo $_GPC['openid'];?><?php  } else { ?><?php  echo $item['openid'];?><?php  } ?>" />
                                        <input type='hidden' id='nickname' name='nickname' value="<?php  if($_GPC['nickname']) { ?><?php  echo $_GPC['nickname'];?><?php  } else { ?><?php  echo $item['nickname'];?><?php  } ?>" />
                                        <input type='hidden' id='avatar' name='avatar' value="<?php  if($_GPC['avatar']) { ?><?php  echo $_GPC['avatar'];?><?php  } else { ?><?php  echo $item['avatar'];?><?php  } ?>" />
                                        <div class='input-group'>
                                            <input type="text" name="admin_name" maxlength="30"
                                                   value="<?php  if($_GPC['nickname']) { ?><?php  echo $_GPC['nickname'];?><?php  } else { ?><?php  echo $item['nickname'];?><?php  } ?>"
                                                   id="saler" class="form-control" readonly />
                                            <div class='input-group-btn'>
                                                <button class="btn btn-default" type="button" onclick="popwin = $('#modal-module-menus').modal();">选择管理员</button>
                                            </div>

                                    </div>

                                        <span class='shop-logo'><img  id="picc" src="<?php  if($_GPC['avatar']) { ?><?php  echo $_GPC['avatar'];?><?php  } else { ?><?php  echo $item['avatar'];?><?php  } ?>" onerror="this.src='../addons/yc_youliao/public/images/avatar_default.jpg'"/></span>


                                        <div id="modal-module-menus"  class="modal fade" tabindex="-1">
                                            <div class="modal-dialog" style='width: 920px;'>
                                                <div class="modal-content">
                                                    <div class="modal-header"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>选择管理员</h3></div>
                                                    <div class="modal-body" >
                                                        <div class="row">
                                                            <div class="input-group">
                                                                <input type="text" class="form-control" name="keyword" value="" id="search-kwd" placeholder="请输入粉丝昵称/姓名/手机号" />
                                                                <span class='input-group-btn'><button type="button" class="btn btn-default" onclick="search_members();">搜索</button></span>
                                                            </div>
                                                        </div>
                                                        <div id="module-menus" style="padding-top:5px;"></div>
                                                    </div>
                                                    <div class="modal-footer"><a href="#" class="btn btn-default" data-dismiss="modal" aria-hidden="true">关闭</a></div>
                                                </div>

                                            </div>
                                        </div>
                                        <p class="help-block">为方便接收微信模板消息通知，管理员必须关注公众号： <?php  echo $_W['uniaccount']['name'];?></p>
                                    </div>
                                </div>
                                <?php  if($admin_flag==1) { ?>
                                <!--店铺管理员需填-->
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="red">*</span>角色</label>
                                    <div class="col-sm-6"> <!-- radio -->
                                        <div class="radio">
                                            <label class="radio-custom admintype-1">
                                                <input  type="radio" name="admin_type" value="1" <?php  if($item['admin_type']==1) { ?>checked="checked"<?php  } ?>>
                                                超级管理员：全部权限 </label>
                                        </div>
                                        <div class="radio">
                                            <label class="radio-custom admintype-1">
                                                <input type="radio" <?php  if($item['admin_type']==2) { ?>checked="checked"<?php  } ?> name="admin_type"  value="2">
                                                操作员：商品管理、订单管理、核销订单 </label>
                                        </div>
                                        <div class="radio">
                                            <label class="radio-custom admintype-3">
                                                <input type="radio" <?php  if($item['admin_type']==3) { ?>checked="checked"<?php  } ?> name="admin_type" value="3">
                                                核销员：核销订单</label>
                                        </div>

                                    </div>
                                </div>
                            </div>


                                    <div class="form-group password">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="red">*</span> 用户名</label>
                                        <div class="col-md-6">
                                            <input  style="ime-mode: disabled;" id="passport" type="text" maxLength="200" name="passport" class="form-control" value="<?php  echo $item['passport'];?>" />

                                        </div>
                                    </div>
                                    <div class="form-group password">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="red">*</span> 密码</label>
                                        <div class="col-md-6">
                                            <input type="password" id="password" name="password" class="form-control" value="<?php  echo $item['password'];?>" />
                                            <p class="help-block">密码需8位以上，由数字、字母、字符组成</p>
                                        </div>

                                    </div>
                            <?php  } ?>
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">姓名</label>
                                        <div class="col-md-6">
                                            <input type="text" name="admin_name" class="form-control" value="<?php   echo $item['admin_name'];?>" />

                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">电话</label>
                                        <div class="col-md-6">
                                            <input type="text"  name="mobile" class="form-control" value="<?php  echo $item['mobile'];?>" onkeyup="this.value=this.value.replace(/[^\d]/ig,'')" size="11"/>

                                        </div>
                                    </div>

                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">开启模板消息通知</label>
                                <div class="col-md-6">
                                    <input type="radio" name="msg_flag"  value="0" <?php  if($item['msg_flag']==0) { ?>checked="checked"<?php  } ?>/> 开
                                    <input type="radio" class="wl2" name="msg_flag" <?php  if($item['msg_flag']==1) { ?>checked="checked"<?php  } ?> value="1" class="radiomar"/>关
                                    <p class="help-block">默认为开启</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否设为客服</label>
                                <div class="col-md-6">
                                    <input type="radio" name="customer"  value="1" <?php  if($item['customer']==1) { ?>checked="checked"<?php  } ?>/>是
                                    <input type="radio" class="wl2" name="customer" <?php  if($item['customer']==0) { ?>checked="checked"<?php  } ?> value="0" class="radiomar"/>否
                                    <p class="help-block">默认为开启</p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
                                <div class="col-md-6">
                                    <input type="radio" name="status"  value="0" <?php  if($item['status']==0) { ?>checked="checked"<?php  } ?>/> 正常
                                    <input type="radio" class="wl2" name="status" <?php  if($item['status']==1) { ?>checked="checked"<?php  } ?> value="1" class="radiomar"/>暂停
                                    <p class="help-block">默认为正常状态</p>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                            <input type="hidden" name="admin_id" value="<?php  echo $item['admin_id'];?>" />
                            <input type="hidden" name="op" value="post" />
                            <div class="width100 btn2">
                                <input name="submit" type="submit" value="提交" class="btn btn-primary" onclick="return checkAdmin(this.form)">
                            </div>


                    </form>
                </div>


                <?php  } ?>
            </div>
        </div>
    </section>
</section>
</section>

</body>
</html>