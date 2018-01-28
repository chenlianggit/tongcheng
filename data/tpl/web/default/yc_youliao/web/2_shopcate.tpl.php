<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>

<section id="content">
<section class="vbox">
    <section class="scrollable padder">
        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
            <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
            <li class="active">商户管理</li>
        </ul>

        <ul class="nav nav-tabs">
            <li <?php  if($op =='display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shopcate',array('op' =>'display'))?>">店铺分类</a></li>
            <?php  if($op =='post') { ?> <li  class="active" ><a href="<?php  echo $this->createWebUrl('shopcate',array('op' =>'post'))?>">添加分类</a></li><?php  } ?>

        </ul>

        <div class="main">
            <?php  if($op == 'display') { ?>
            <link rel="stylesheet" href="../addons/yc_youliao/public/css/common.css" type="text/css" />
            <div class="panel panel-info" >
                <div class="panel-body  table-responsive">
                    <div class="jsglNr">
                        <div class="selectNr" >
                            <div class="left">
                                <a href="<?php  echo $this->createWebUrl('shopcate',array('op' =>'post'))?>">添加一级分类</a>
                            </div>
                            <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/cate_type', TEMPLATE_INCLUDEPATH)) : (include template('web/cate_type', TEMPLATE_INCLUDEPATH));?>
                            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
                                <div class="right">

                                    <input type="text" name="keyword" value="<?php  echo $keyword;?>"  placeholder="请输入分类名称" class="inptText" /><input type="submit" value="  搜索"  class="inptButton" />
                                </div>
                            </form>
                        </div>

                        <div class="tableBox">
                            <div action="" method="post" onsubmit="return formcheck(this)">
                            <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >
                                <tr class="theader">

                                    <td class="w50">ID</td>
                                    <td class="w80">排序</td>
                                    <!--<td class="w80">热门推荐</td>-->
                                    <td colspan="2">分类名称</td>
                                    <td>分类图标</td>
                                    <td class="w120">操作</td>
                                </tr>
                                <?php  if(is_array($list)) { foreach($list as $shopcate) { ?>
                                <?php  if(empty($shopcate['parent_id']) || $k==2) { ?>
                                <tr class="bggreen">

                                    <td><?php  echo $shopcate['cate_id'];?></td>
                                    <td><input  name="displayorder[<?php  echo $shopcate['cate_id'];?>]" value="<?php  echo $shopcate['orderby'];?>" type="text" class="remberinput w80" /></td>
                                    <!--<td class="text-l">-->
                                        <!--<label class="switch">-->
                                            <!--<input type="checkbox" <?php  if($shopcate['is_hot']==1) { ?> onclick="opstatus(<?php  echo $shopcate['cate_id'];?>,'is_hot',0);" checked='checked'<?php  } else { ?>onclick="opstatus(<?php  echo $shopcate['cate_id'];?>,'is_hot',1);"<?php  } ?>>-->
                                            <!--<span></span> </label>-->
                                    <!--</td>-->
                                    <td colspan="2"><?php  echo $shopcate['cate_name'];?></td>
                                    <td><img src="<?php  echo tomedia($shopcate['thumb']);?>" onerror="javascript:this.src='<?php echo SQ;?>public/images/noimg.png'" /></td>


                                    <td class="listbtn">
                                        <?php  if(empty($shopcate['parent_id'])) { ?>
                                        <a href="<?php  echo $this->createWebUrl('shopcate', array('op' => 'post', 'parent_id' => $shopcate['cate_id']))?>"><i class="fa fa-plus-square"></i>增加子类</a>
                                        <?php  } ?>
                                        <a href="<?php  echo $this->createWebUrl('shopcate', array('op' => 'post', 'id' => $shopcate['cate_id']))?>"><i class="fa fa-edit"></i>修改</a>
                                        <a class="label label-danger pad-5 " href="<?php  echo $this->createWebUrl('shopcate', array('op' => 'delete', 'id' => $shopcate['cate_id']))?>"><i class="fa fa-exclamation-triangle"></i>删除</a> </td>
                                </tr>
                                <?php  } ?>
                                <?php  if(is_array($children[$shopcate['cate_id']])) { foreach($children[$shopcate['cate_id']] as $shopcate) { ?>
                                <tr class="nonebg">

                                    <td><?php  echo $shopcate['cate_id'];?></td>
                                    <td><input  name="displayorder[<?php  echo $shopcate['cate_id'];?>]" value="<?php  echo $shopcate['orderby'];?>" type="text" class="remberinput w80" /></td>


                                    <td class="tdnone"></td>
                                    <td><?php  echo $shopcate['cate_name'];?></td>
                                    <td><img src="<?php  echo tomedia($shopcate['thumb']);?>" onerror="javascript:this.src='<?php echo SQ;?>public/images/noimg.png'" /></td>
                                    <td class="listbtn">

                                        <a href="<?php  echo $this->createWebUrl('shopcate', array('op' => 'post', 'id' => $shopcate['cate_id'],'parent_id' => $shopcate['parent_id']))?>"><i class="fa fa-edit"></i>修改</a>
                                        <a class="label label-danger pad-5 "  href="<?php  echo $this->createWebUrl('shopcate', array('op' => 'delete', 'id' => $shopcate['cate_id'],'parent_id' => $shopcate['parent_id']))?>"><i class="fa fa-exclamation-triangle"></i>删除</a>

                                    </td>
                                </tr>
                                <?php  } } ?>
                                <?php  } } ?>

                            </table>
                                <?php  if($list) { ?>
                                <div class="width100 btn2">
                                        <input name="submit" class="btn btn-primary i-t-md" value="提交" type="submit">
                                        <input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
                            </div>
                            </form>
                                <?php  } ?>
                            <?php  echo $page;?>
                        </div>


                    </div>

                </div>
                <?php  } else if($op == 'post') { ?>

                <div class="panel" >
                    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">

                        <div class="panel-default">
                            <div class="panel-heading">
                                添加分类
                            </div>
                            <div class="panel-body">
                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 control-label"><span class="red mr5">*</span>业务类型</span></label>
                                    <div class="col-sm-9 col-xs-12">
                                        <span  title="购买成功生成二维码到店核销">
                                        <input  type="radio"  name="cate_type" class="mr20 "  value="0"  <?php  if($shopcate['cate_type']==0) { ?>checked="checked"<?php  } ?>/>商铺消费</span>
                                        <span class="gray" title="暂未开放">
                                        <input type="radio"  name="cate_type" id="close_type" class="wl2  cate_type"  <?php  if($shopcate['cate_type']==1) { ?>checked="checked"<?php  } ?> value="1" />酒店预订
                                        <input type="radio"  name="cate_type" class="wl2  cate_type"  <?php  if($shopcate['cate_type']==2) { ?>checked="checked"<?php  } ?> value="2" />影院订座
                                        <input type="radio"  name="cate_type" class="wl2  cate_type"  <?php  if($shopcate['cate_type']==3) { ?>checked="checked"<?php  } ?> value="3" />外卖点餐
                                        <input type="radio"  name="cate_type" class="wl2 cate_type"  <?php  if($shopcate['cate_type']==3) { ?>checked="checked"<?php  } ?> value="3" />微商城
</span>

                                    </div>
                                </div>

                                <?php  if(!empty($parentid)) { ?>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 control-label">行业分类</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="margin-right:15px;" id="city_id" name="parent_id"  autocomplete="off">
                                            <?php  if($cate ) { ?>
                                            <?php  if(is_array($cate)) { foreach($cate as $row) { ?>
                                            <option  value="<?php  echo $row['cate_id'];?>" <?php  if($row['cate_id'] == $parentid) { ?> selected="selected"<?php  } ?>><?php  echo $row['cate_name'];?></option>
                                            <?php  } } ?>

                                            <?php  } else { ?>
                                            <option>暂无分类</option>
                                            <?php  } ?>

                                        </select>
                                </div>
                                <?php  } ?>
                                </div>
                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 control-label"><span class="red mr5">*</span>分类名称</span></label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" name="cate_name" id='name' class="form-control" value="<?php  echo $shopcate['cate_name'];?>" />
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 control-label"><span class="red mr5">*</span>分类图片</span></label>
                                    <div class="col-sm-6 col-xs-6">
                                        <?php  echo tpl_form_field_image('thumb',$item['thumb']);?>
                                    </div>
                                </div>

                               
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 control-label">排序</label>
                                        <div class="col-sm-4 col-xs-4">
                                            <input type="text" name="orderby" class="form-control" value="<?php  echo $shopcate['orderby'];?>" />
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 control-label">热门</label>
                                        <div class="col-sm-4 col-xs-4">
                                            <input type="text" name="is_hot" class="form-control" value="<?php  echo $shopcate['is_hot'];?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="parent_id" value="<?php  echo $parent['cate_id'];?>" />
                        <input type="hidden" name="cate_id" value="<?php  echo $shopcate['cate_id'];?>" />
                            <input type="hidden" name="op" value="post" />
                            <div class="width100 btn2">
                                <input name="submit" type="submit" value="提交" class="btn btn-primary" onclick="return check(this.form)">
                            </div>


                    </form>
                </div>


                <?php  } ?>
    </section>
</section>
</section>
<script>
    $(".cate_type").click(function(){
        if ($(".cate_type").is(':checked')) {
            $(".cate_type").removeAttr('checked');
        }
    });



    function check(){
    var n = $("#name").val();
    var cate_type=$('select[name="cate_type"]').val();
        if(cate_type==""){
            tip("请选择业务类型");
            tip_close();
            return false;
        }
    if(n==""){
        tip("分类名称不能为空");
        tip_close();
        return false;
    }


}

</script>

