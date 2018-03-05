<?php defined('IN_IA') or exit('Access Denied');?><?php  $id=getShop_id()?>
<?php  if($id>0 && $_GPC['add']!='1') { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_header', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_left', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_left', TEMPLATE_INCLUDEPATH));?>
<style>
    @media (min-width: 768px) {
        .webapp, .webapp body {
            height: auto;
            overflow: auto;
        }
    }
</style>
<section  id="content">
    <section >
        <section class="padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
                <li class="active">商户管理</li>
            </ul>
<?php  } else { ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>
            <section>
                <section >
                    <section class="padder">
                        <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
                            <li><a href="<?php  echo $this->createWebUrl('index')?>"><i class="fa fa-home"></i>首页</a></li>
                            <li class="active">店铺管理</li>
                        </ul>

                        <ul class="nav nav-tabs">
                            <li <?php  if($op =='display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('shop',array('op' =>'display'))?>">店铺管理</a></li>
                            <?php  if($op =='post') { ?> <li  class="active" ><a href="<?php  echo $this->createWebUrl('shop_info',array('op' =>'post'))?>"> 编辑商家信息</a></li><?php  } ?>

                        </ul>
<?php  } ?>




            <div class="main">
                    <form method="post" class="form-horizontal form" enctype="multipart/form-data">
                        <input type="hidden" name="c" value="site" />
                        <input type="hidden" name="a" value="entry" />
                        <input type="hidden" name="m" value="yc_youliao" />
                        <input type="hidden" name="do" value="shop_info" />
                        <div class="panel panel-default">
                            <div class="panel-heading">
                               编辑商户
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>所属行业</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="margin-right:15px;" name="pcate_id"  autocomplete="off"   >
                                            <!--onchange="changeline(this.options[this.selectedIndex].value)"-->
                                            <?php  if($cate ) { ?>
                                            <option value="0">请选择分类</option>
                                            <?php  if(is_array($cate)) { foreach($cate as $row) { ?>

                                            <option value="<?php  echo $row['cate_id'];?>" <?php  if($row['cate_id'] == $item['pcate_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['cate_name'];?></option>
                                            <?php  } } ?>

                                            <?php  } else { ?>
                                            <option>暂无分类</option>
                                            <?php  } ?>


                                        </select>
                                    </div>
                                    <!--<div class="col-sm-2">-->
                                    <!--<select class="form-control" style="margin-right:15px;"  name="ccate_id"  autocomplete="off">-->
                                        <?php  if($ccate ) { ?>
                                        <!--<option value="0">请选择子类</option>-->
                                        <?php  if(is_array($ccate)) { foreach($ccate as $row) { ?>
                                        <!--<option value="<?php  echo $row['cate_id'];?>" <?php  if($row['cate_id'] == $item['ccate_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['cate_name'];?></option>-->
                                        <?php  } } ?>

                                        <?php  } else { ?>
                                        <!--<option value="0">暂无分类</option>-->
                                        <?php  } ?>


                                    <!--</select>-->
                                <!--</div>-->
                            </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>城市/区域/商圈</label>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="margin-right:15px;"  name="city_id" onchange="changearea(this.options[this.selectedIndex].value)"  autocomplete="off">
                                            <?php  if($city) { ?>
                                            <option value="0">请选择城市</option>
                                            <?php  if(is_array($city)) { foreach($city as $row) { ?>
                                            <option value="<?php  echo $row['city_id'];?>" <?php  if($row['city_id'] == $item['city_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['name'];?></option>
                                            <?php  } } ?>

                                            <?php  } else { ?>
                                            <option value="0">暂无城市</option>
                                            <?php  } ?>

                                        </select>
                                    </div>
                                    <div class="col-sm-2">
                                        <select class="form-control" style="margin-right:15px;"  name="area_id"   autocomplete="off">
                                            <!--onchange="changebusiness(this.options[this.selectedIndex].value)"-->
                                            <?php  if($area) { ?>
                                            <option value="0">请选择区域</option>
                                            <?php  if(is_array($area)) { foreach($area as $row) { ?>
                                            <option value="<?php  echo $row['area_id'];?>" <?php  if($row['area_id']  == $item['area_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['area_name'];?></option>
                                            <?php  } } ?>

                                            <?php  } else { ?>
                                            <option value="0">暂无区域</option>
                                            <?php  } ?>

                                        </select>
                                    </div>

                                    <!--<div class="col-sm-2">-->


                                        <!--<select class="form-control"  name="business_id" autocomplete="off">-->
                                            <?php  if($business) { ?>
                                            <!--<option value="0">请选择商圈</option>-->
                                            <?php  if(is_array($business)) { foreach($business as $row) { ?>
                                            <!--<option value="<?php  echo $row['area_id'];?>" <?php  if($row['area_id'] == $item['business_id']) { ?> selected="selected"<?php  } ?>><?php  echo $row['area_name'];?></option>-->
                                            <?php  } } ?>

                                            <?php  } else { ?>
                                            <!--<option value="0">暂无商圈</option>-->
                                            <?php  } ?>

                                        <!--</select>-->

                                    <!--</div>-->

                                </div>

                            <div class="form-group" >
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="red mr5">*</span>商铺坐标</label>
                                <div class="col-sm-9 col-xs-12">

                                    <div class="lt">
                                        经度 <input type="text" name="lng" id="map_x" value="<?php  echo $item['lng'];?>" class="scAddTextName w200">
                                        纬度 <input type="text" name="lat" id="map_y" value="<?php  echo $item['lat'];?>" class="scAddTextName w200">
                                    </div>
                                    <div class="btn-bdmap">
                                        <a style="margin-left: 10px;" onclick="getMapXY();"   class="seleSj">百度地图</a>
                                    </div>
                                    <!--百度地图开始-->
                                    <input type="text" class="form-control input-text" id="suggestId" style="display:none;" placeholder="可以输入指定位置搜索">

                                    <div id="searchResultPanel" ></div>

                                    <div id="allmap" ></div>

                                </div>
                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>店铺电话</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="telphone" id='telphone' class="form-control" value="<?php  echo $item['telphone'];?>" />
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>联系人</label>
                                    <div class="col-sm-4">
                                        <input type="text" name="manage" class="form-control" value="<?php  echo $item['manage'];?>" />
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="red mr5">*</span>店铺名称</span></label>
                                    <div class="col-sm-4">
                                        <input type="text" name="shop_name" id='name' class="form-control" value="<?php  echo $item['shop_name'];?>" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">营业执照</label>
                                    <div class="col-sm-4">
                                        <?php  echo tpl_form_field_image('shop_cert',$item['shop_cert']);?>

                                    </div>
                                </div>

                            <div class="form-group">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label">店铺LOGO</label>
                                <div class="col-sm-4">
                                    <?php  echo tpl_form_field_image('logo',$item['logo']);?>
                                    <p class="help-block">建议上传宽120px*高120px或长宽比例相同像素图片</p>
                                </div>
                            </div>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">简介图片</label>
                                    <div class="col-sm-4">
                                        <?php  echo tpl_form_field_multi_image('qr_code',$item['qr_code']);?>
                                    </div>
                                </div>
                            <!--<div class="form-group">-->
                                <!--<label class="col-xs-12 col-sm-3 col-md-2 control-label">店铺形象</label>-->
                                <!--<div class="col-sm-4">-->
                                    <!--&lt;!&ndash;<?php  echo tpl_form_field_image('bgpic',$item['bgpic']);?>&ndash;&gt;-->
                                    <!--<p class="help-block">建议上传宽768px高300px图片</p>-->
                                <!--</div>-->
                            <!--</div>-->

                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">店铺地址</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" name="address" id='address' class="form-control" value="<?php  echo $item['address'];?>" />
                                    </div>
                                </div>
                            <div class="form-group" >
                                <label class="col-xs-12 col-sm-3 col-md-2  control-label">店铺描述</label>
                                <div class="col-sm-9 col-xs-12">
                                    <textarea name="intro" rows="2"><?php  echo $item['intro'];?></textarea>
                                </div>
                            </div>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">人均消费</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" onkeyup="clearNoNum(this);"  name="renjun"  class="form-control" value="<?php  echo $item['renjun'];?>" />
                                            <span class="input-group-addon">元/人</span>
                                        </div>

                                    </div>
                                </div>
                                <div class="form-group inco">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">店铺标签</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <div class="input_form item_cell_flex checkbox good_inco_list">
                                            <div class="inco_append_box"><?php  $item['inco']=json_decode($item['inco'])?>

                                                <label><input type="checkbox" name="inco[]" <?php  if(in_array('支付宝支付',(array)$item['inco'])) { ?>checked="checked"<?php  } ?> value="支付宝支付" > 支付宝支付</label>
                                                <label><input type="checkbox" name="inco[]" <?php  if(in_array('微信支付',(array)$item['inco'])) { ?>checked="checked"<?php  } ?> value="微信支付" > 微信支付</label>
                                                <label><input type="checkbox" name="inco[]" <?php  if(in_array('WIFI',(array)$item['inco'])) { ?>checked="checked"<?php  } ?> value="WIFI" > WIFI</label>
                                                <label><input type="checkbox" name="inco[]" <?php  if(in_array('停车位',(array)$item['inco'])) { ?>checked="checked"<?php  } ?> value="停车位" > 停车位</label>
                                                <?php  if(is_array($item['inco'])) { foreach($item['inco'] as $i) { ?>
                                                <?php  if(!in_array($i,array('支付宝支付','微信支付','WIFI','停车位'))) { ?>
                                                <label>
                                                    <input type="checkbox" name="inco[]"checked="checked" value="<?php  echo $i;?>" > <?php  echo $i;?>
                                                </label>
                                                <?php  } ?>
                                                <?php  } } ?>
                                            </div>
                                            <p class="add_btn_box">
				<span class="input_box input_box_200">
					<input type="text" class="input_input">
				</span>
                                                <span class="font_13px_999 add_btn add_a_inco">添加一个标签</span>
                                            </p>
                                        </div>

                                    </div>
                                </div>



                                <div class="form-group">

                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">营业时间</label>
                                    <div class="col-sm-3">
                                        <input type="text" class="hour form-control" name="opendtime" value="<?php  echo $item['opendtime'];?>" style="width: 430px !important;">
                                        <!--<select name="opendtime" class="hour form-control" >-->
                                            <!--<option value="">营业</option>-->
                                            <!--<option value="0" <?php  if($item['opendtime']==0) { ?>selected="selected"<?php  } ?>>00 : 00</option>-->
                                            <!--<option value="1" <?php  if($item['opendtime']==1) { ?>selected="selected"<?php  } ?>>01 : 00</option>-->
                                            <!--<option value="2" <?php  if($item['opendtime']==2) { ?>selected="selected"<?php  } ?>>02 : 00</option>-->
                                            <!--<option value="3" <?php  if($item['opendtime']==3) { ?>selected="selected"<?php  } ?>>03 : 00</option>-->
                                            <!--<option value="4" <?php  if($item['opendtime']==4) { ?>selected="selected"<?php  } ?>>04 : 00</option>-->
                                            <!--<option value="5" <?php  if($item['opendtime']==5) { ?>selected="selected"<?php  } ?>>05 : 00</option>-->
                                            <!--<option value="6" <?php  if($item['opendtime']==6) { ?>selected="selected"<?php  } ?>>06 : 00</option>-->
                                            <!--<option value="7" <?php  if($item['opendtime']==7) { ?>selected="selected"<?php  } ?>>07 : 00</option>-->
                                            <!--<option value="8" <?php  if($item['opendtime']==8) { ?>selected="selected"<?php  } ?>>08 : 00</option>-->
                                            <!--<option value="9" <?php  if($item['opendtime']==9) { ?>selected="selected"<?php  } ?>>09 : 00</option>-->
                                            <!--<option value="10" <?php  if($item['opendtime']==10) { ?>selected="selected"<?php  } ?>>10 : 00</option>-->
                                            <!--<option value="11" <?php  if($item['opendtime']==11) { ?>selected="selected"<?php  } ?>>11 : 00</option>-->
                                            <!--<option value="12" <?php  if($item['opendtime']==12) { ?>checked="checked"<?php  } ?>>12 : 00</option>-->
                                            <!--<option value="13" <?php  if($item['opendtime']==13) { ?>selected="selected"<?php  } ?>>13 : 00</option>-->
                                            <!--<option value="14" <?php  if($item['opendtime']==14) { ?>selected="selected"<?php  } ?>>14 : 00</option>-->
                                            <!--<option value="15" <?php  if($item['opendtime']==15) { ?>selected="selected"<?php  } ?>>15 : 00</option>-->
                                            <!--<option value="16" <?php  if($item['opendtime']==16) { ?>selected="selected"<?php  } ?>>16 : 00</option>-->
                                            <!--<option value="17" <?php  if($item['opendtime']==17) { ?>selected="selected"<?php  } ?>>17 : 00</option>-->
                                            <!--<option value="18" <?php  if($item['opendtime']==18) { ?>selected="selected"<?php  } ?>>18 : 00</option>-->
                                            <!--<option value="19" <?php  if($item['opendtime']==19) { ?>selected="selected"<?php  } ?>>19 : 00</option>-->
                                            <!--<option value="20" <?php  if($item['opendtime']==20) { ?>selected="selected"<?php  } ?>>20 : 00</option>-->
                                            <!--<option value="21" <?php  if($item['opendtime']==21) { ?>selected="selected"<?php  } ?>>21 : 00</option>-->
                                            <!--<option value="22" <?php  if($item['opendtime']==22) { ?>selected="selected"<?php  } ?>>22 : 00</option>-->
                                            <!--<option value="23" <?php  if($item['opendtime']==23) { ?>selected="selected"<?php  } ?>>23 : 00</option>-->
                                        <!--</select>-->

                                        <!--<select name="closetime" class="hour form-control">-->
                                            <!--<option value="">打烊</option>-->
                                            <!--<option value="0" <?php  if($item['closetime']==0) { ?>selected="selected"<?php  } ?>>00 : 00</option>-->
                                            <!--<option value="1" <?php  if($item['closetime']==1) { ?>selected="selected"<?php  } ?>>01 : 00</option>-->
                                            <!--<option value="2" <?php  if($item['closetime']==2) { ?>selected="selected"<?php  } ?>>02 : 00</option>-->
                                            <!--<option value="3" <?php  if($item['closetime']==3) { ?>selected="selected"<?php  } ?>>03 : 00</option>-->
                                            <!--<option value="4" <?php  if($item['closetime']==4) { ?>selected="selected"<?php  } ?>>04 : 00</option>-->
                                            <!--<option value="5" <?php  if($item['closetime']==5) { ?>selected="selected"<?php  } ?>>05 : 00</option>-->
                                            <!--<option value="6" <?php  if($item['closetime']==6) { ?>selected="selected"<?php  } ?>>06 : 00</option>-->
                                            <!--<option value="7" <?php  if($item['closetime']==7) { ?>selected="selected"<?php  } ?>>07 : 00</option>-->
                                            <!--<option value="8" <?php  if($item['closetime']==8) { ?>selected="selected"<?php  } ?>>08 : 00</option>-->
                                            <!--<option value="9" <?php  if($item['closetime']==9) { ?>selected="selected"<?php  } ?>>09 : 00</option>-->
                                            <!--<option value="10" <?php  if($item['closetime']==10) { ?>selected="selected"<?php  } ?>>10 : 00</option>-->
                                            <!--<option value="11" <?php  if($item['closetime']==11) { ?>selected="selected"<?php  } ?>>11 : 00</option>-->
                                            <!--<option value="12" <?php  if($item['closetime']==12) { ?>selected="selected"<?php  } ?>>12 : 00</option>-->
                                            <!--<option value="13" <?php  if($item['closetime']==13) { ?>selected="selected"<?php  } ?>>13 : 00</option>-->
                                            <!--<option value="14" <?php  if($item['closetime']==14) { ?>selected="selected"<?php  } ?>>14 : 00</option>-->
                                            <!--<option value="15" <?php  if($item['closetime']==15) { ?>selected="selected"<?php  } ?>>15 : 00</option>-->
                                            <!--<option value="16" <?php  if($item['closetime']==16) { ?>selected="selected"<?php  } ?>>16 : 00</option>-->
                                            <!--<option value="17" <?php  if($item['closetime']==17) { ?>selected="selected"<?php  } ?>>17 : 00</option>-->
                                            <!--<option value="18" <?php  if($item['closetime']==18) { ?>selected="selected"<?php  } ?>>18 : 00</option>-->
                                            <!--<option value="19" <?php  if($item['closetime']==19) { ?>selected="selected"<?php  } ?>>19 : 00</option>-->
                                            <!--<option value="20" <?php  if($item['closetime']==20) { ?>selected="selected"<?php  } ?>>20 : 00</option>-->
                                            <!--<option value="21" <?php  if($item['closetime']==21) { ?>selected="selected"<?php  } ?>>21 : 00</option>-->
                                            <!--<option value="22" <?php  if($item['closetime']==22) { ?>selected="selected"<?php  } ?>>22 : 00</option>-->
                                            <!--<option value="23" <?php  if($item['closetime']==23) { ?>selected="selected"<?php  } ?>>23 : 00</option>-->
                                        <!--</select>-->
                                    </div>

                                </div>

                                <?php  $t=getAdmin_type()?>
                                <?php  if($t== 'Y') { ?>
                                <div class="col-sm-12">
                                <div class="line line-dashed line-lg "></div>
                                </div>
                                <div class="col-sm-12">
                                <label class="col-xs-12 col-sm-3 col-md-2 control-label mb5">以下仅模块管理员权限可见</label>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">续期至</label>
                                    <div class="col-sm-3">
                                        <?php echo tpl_form_field_date('endtime', !empty($item['endtime']) ? date('Y-m-d',$item['endtime']) : date('Y-m-d'), 0)?>
                                        <p class="help-block">店铺到期时间：<?php  echo date('Y-m-d H:i:s',$item['endtime'])?></p>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">交易费率</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" onkeyup="clearNoNum(this);" name="rate"  class="form-control" value="<?php  echo $item['rate'];?>" />
                                            <span class="input-group-addon">%</span>
                                        </div>
                                        <p class="help-block">0或空则表示不收取商家每笔订单费用</p>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">状态</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <label class="radio-inline"><input type="radio" value="1" name="status"   <?php  if($item['status'] == 1) { ?>checked="true"<?php  } ?> /> 开启</label>
                                        <label class="radio-inline"><input type="radio" value="0" name="status"    <?php  if($item['status'] == 0) { ?>checked="true"<?php  } ?> /> 关闭</label>
                                        <label class="radio-inline"><input type="radio" value="0" name="status"    <?php  if($item['status'] == 3) { ?>checked="true"<?php  } ?> /> 暂停</label>

                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">点评</label>
                                    <div class="col-sm-3">
                                        <div class="input-group">
                                            <input type="text" onkeyup="clearNoNum(this);"  name="dp"  class="form-control" value="<?php  echo $item['dp'];?>" />
                                            <span class="input-group-addon">分</span>
                                        </div>
                                        <p class="help-block">5分为满分</p>
                                    </div>
                                </div>
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                                        <div class="col-sm-2">
                                            <input   name="orderby" id="orderby" onkeyup="isNumber();" class="form-control" value="<?php  echo $item['orderby'];?>" />
                                        </div>
                                    </div>
                                <?php  } ?>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                        <input type="hidden" name="parent_id" value="<?php  echo $parent['shop_id'];?>" />
                        <input type="hidden" name="shop_id" value="<?php  echo $item['shop_id'];?>" />
                            <input type="hidden" name="op" value="post" />
                            <div class="width100 btn2">
                                <input name="submit" type="submit" value="提交" class="btn btn-primary" onclick="return checkform(this.form)">
                            </div>


                    </form>
                </div>



    </section>
</section>
</section>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('mapjs', TEMPLATE_INCLUDEPATH)) : (include template('mapjs', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>