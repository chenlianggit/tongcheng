<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>

<section id="content">
<section class="vbox">
    <section class="scrollable padder">
        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
            <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
            <li class="active">县/区管理</li>
        </ul>

        <ul class="nav nav-tabs">
            <li <?php  if($do =='city') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('city',array('op' =>'display'))?>">城市管理</a></li>
            <li <?php  if($do =='area') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('area',array('op' =>'display'))?>">县/区管理</a></li>

        </ul>


        <div class="main">
            <?php  if($op == 'display') { ?>
            <div class="panel panel-info" >
                <div class="panel-body  table-responsive">
                    <div class="jsglNr">
                        <div class="selectNr" >
                            <div class="left">
                                <a href="<?php  echo $this->createWebUrl('area',array('op' =>'post'))?>">添加县/区</a>
                            </div>
                            <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
                                <div class="right">
                                    <input type="text" name="keyword" value="<?php  echo $keyword;?>"  placeholder="请输入分类名称" class="inptText" /><input type="submit" value="  搜索"  class="inptButton" />
                                </div>
                            </form>
                        </div>

                        <div class="tableBox">
                            <form action="" method="post" onsubmit="return formcheck(this)">
                            <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >
                                <tr class="theader">

                                    <td class="w80">排序</td>
                                    <td colspan="2">区域/商圈名称</td>
                                    <td>是否热门</td>
                                    <td class="w120">操作</td>
                                </tr>
                                <?php  if(is_array($list)) { foreach($list as $item) { ?>
                                <?php  if(empty($item['parent_id']) || $k==2) { ?>
                                <tr class="bggreen">
                                    <td><input  name="displayorder[<?php  echo $item['area_id'];?>]" value="<?php  echo $item['orderby'];?>" type="text" class="remberinput w80" /></td>

                                    <td colspan="2"><?php  echo $item['area_name'];?></td>
                                    <td><?php  if($item['is_hot']==1) { ?><img src="<?php echo STYLE;?>images/hot.png" /><?php  } ?></td>
                                    <td class="listbtn">
                                        <?php  if(empty($item['parent_id'])) { ?>
                                        <a href="<?php  echo $this->createWebUrl('area', array('op' => 'post', 'parent_id' => $item['area_id']))?>"><i class="fa fa-plus-square"></i>添加商圈</a>
                                        <?php  } ?>
                                        <a href="<?php  echo $this->createWebUrl('area', array('op' => 'post', 'area_id' => $item['area_id']))?>"><i class="fa fa-edit"></i>修改</a>
                                        <a class="label label-danger pad-5 " href="<?php  echo $this->createWebUrl('area', array('op' => 'delete', 'area_id' => $item['area_id']))?>"><i class="fa fa-exclamation-triangle"></i>删除</a>
                                    </td>

                                </tr>
                                <?php  } ?>
                                <?php  if(is_array($children[$item['area_id']])) { foreach($children[$item['area_id']] as $item) { ?>
                                <tr class="nonebg">


                                    <td><input  name="displayorder[<?php  echo $item['area_id'];?>]" value="<?php  echo $item['orderby'];?>" type="text" class="remberinput w80" /></td>
                                    <td class="tdnone"></td>
                                    <td><?php  echo $item['area_name'];?></td>
                                    <td><?php  if($item['is_hot']==1) { ?><img src="<?php echo STYLE;?>images/hot.png" /><?php  } ?></td>
                                    <td class="listbtn">

                                        <a href="<?php  echo $this->createWebUrl('area', array('op' => 'post','area_id' => $item['area_id'],'parent_id' => $item['parent_id']))?>"><i class="fa fa-edit"></i>修改</a>
                                        <a class="label label-danger pad-5 "  href="<?php  echo $this->createWebUrl('area', array('op' => 'delete', 'area_id' => $item['area_id']))?>"><i class="fa fa-exclamation-triangle"></i>删除</a> </td>
                                </tr>
                                <?php  } } ?>
                                <?php  } } ?>

                            </table>
                            <?php  echo $page;?>
                                <?php  if($list) { ?>

                                <div class="width100 btn2">
                                    <input name="submit" class="btn btn-primary i-t-md" value="提交" type="submit">
                                    <input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
                                </div>

                                <?php  } ?>
                        </div>


                    </div>

                </div>
                <?php  } else if($op == 'post') { ?>

                <div class="panel panel-info" >

                    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">

                        <div class=" panel-default">
                            <div class="panel-heading">
                               编辑
                            </div>
                            <div class="panel-body" >
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>
                                        <?php  if($_GPC['parent_id']) { ?>所属县/区<?php  } else { ?>所属城市<?php  } ?></label>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="margin-right:15px;" id="city_id" name="city_id" <?php  if($_GPC['parent_id']) { ?>onchange="fetchoption(this.options[this.selectedIndex].value)" <?php  } ?> autocomplete="off">
                                            <?php  if($city) { ?>
                                            <?php  if(is_array($city)) { foreach($city as $row) { ?>
                                            <option value="<?php  echo $row['city_id'];?>" <?php  if($row['city_id'] == $city_id ||$row['city_id'] == $item['city_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
                                            <?php  } } ?>

                                            <?php  } else { ?>
                                            <option value="0">暂无城市</option>
                                            <?php  } ?>

                                        </select>
                                    </div>
                                    <?php  if(!empty($parentid)) { ?>
                                    <div class="col-sm-2">
                                        <select class="form-control"  name="area_id" autocomplete="off">
                                            <option value=""></option>
                                            <?php  if($area) { ?>
                                            <?php  if(is_array($area)) { foreach($area as $row) { ?>

                                            <option value="<?php  echo $row['area_id'];?>" <?php  if($row['area_id'] == $item['area_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['area_name'];?></option>

                                            <?php  } } ?>
                                            <?php  } else { ?>            <option value="0">暂无区域</option>
                                            <?php  } ?>
                                        </select>

                                    </div>
                                    <?php  } ?>

                                </div>
                                <div style="margin-left: 18%">需填全称，如宝安区，需填：宝安区。如县级上无市级，请选择直辖县</div>
                                </div>

                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="red mr5">*</span>名称</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="area_name" id='name' class="form-control" value="<?php  echo $item['area_name'];?>" />
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否热门</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <label class="radio-inline"><input type="radio" value="1" name="is_hot"   <?php  if($item['is_hot'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
                                        <label class="radio-inline"><input type="radio" value="0" name="is_hot"    <?php  if($item['is_hot'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                                        <div class="col-sm-4">
                                            <input type="text" name="orderby" class="form-control" value="<?php  echo $item['orderby'];?>" />
                                        </div>
                                    </div>


                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="parent_id" value="<?php  echo $parent['area_id'];?>" />
                        <input type="hidden" name="area_id" value="<?php  echo $item['area_id'];?>" />
                            <input type="hidden" name="op" value="post" />
                            <div class="width100 btn2">
                                <input name="submit" type="submit" value="提交"
                                       class="btn btn-primary" onclick="return check(this.form)">
                            </div>


                    </form>
                </div>


                <?php  } ?>
    </section>
</section>
</section>
<script>
    function check(){
    var n = $("#name").val();
    if(n==""){
        tip("名称不能为空");
        tip_close();
        return false;
    }

}
        function fetchoption(optionstr){
            $('select[name="area_id"]').find("option").remove();
            $.ajax({
                type:'post',
                url:"<?php  echo $this->createWebUrl('ajax_req')?>",
                dataType: 'json',
                data:{'id':optionstr,'op':'changearea'},
                success:function(data){
                    if(data.status=='1'){
                        var content="";
                        $.each(data.list,function(k,v){
                            content+=("<option value='"+v.id+"'>"+v.name+"</option>");
                        })
                        $('select[name="area_id"]').append(content);

                    }else{
                        tip(data.str);
                        tip_close();
                    }

                }
            });


        }
</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>