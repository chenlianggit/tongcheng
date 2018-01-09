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
        <?php  if($op == 'display') { ?>
        <div class="main">
            <div class="panel panel-info" >
                <div class="panel-body  table-responsive">
                    <div class="jsglNr">
                        <div class="selectNr" >
                            <div class="left">
                                <a href="<?php  echo $this->createWebUrl('city',array('op' =>'edit'))?>">添加城市</a>
                            </div>
                            <form action="" method="post" onsubmit="return formcheck(this)">
                                <div class="right">
                                    <input type="text" name="keyword" value="<?php  echo $keyword;?>"  placeholder="请输入城市名称" class="inptText" /><input type="submit" value="  搜索"  class="inptButton" />

                                </div>
                            </form>
                        </div>
                        <form action="" method="post" onsubmit="return formcheck(this)">
                        <div class="tableBox">
                            <table bordercolor="#dbdbdb" cellspacing="0" width="100%" border="1px"  class="tablestyle" >
                                <tr class="theader">

                                    <td class="w80">排序</td>
                                    <td>站点名称</td>
                                    <td>站点拼音</td>
                                    <td>热门</td>
                                    <td>状态</td>

                                    <td class="w120">操作</td>
                                </tr>
                                <?php  if(is_array($list)) { foreach($list as $city) { ?>
                                <tr>
                                    <td><input  name="displayorder[<?php  echo $city['city_id'];?>]" value="<?php  echo $city['orderby'];?>" type="text" class="remberinput w80" /></td>

                                    <td><?php  echo $city['name'];?></td>
                                    <td><?php  echo $city['pinyin'];?></td>
                                    <td><?php  if($city['is_hot']==1) { ?><img src="<?php echo STYLE;?>images/hot.png" /><?php  } ?></td>
                                    <td><?php  if($city['isopen']==1) { ?>已开启<?php  } else if($city['isopen']==0) { ?>已关闭<?php  } ?></td>

                                    <td class="listbtn">
                                        <a href="<?php  echo $this->createWebUrl('area', array('op' => 'post', 'city_id' => $city['city_id']))?>"><i class="fa fa-plus-square"></i>添加县/区</a>
                                        <a href="<?php  echo $this->createWebUrl('city', array('op' => 'edit', 'id' => $city['city_id']))?>"><i class="fa fa-edit"></i>修改</a>
                                        <a class="label label-danger pad-5 " href="<?php  echo $this->createWebUrl('city', array('op' => 'delete', 'id' => $city['city_id']))?>"><i class="fa fa-exclamation-triangle"></i>删除</a>
                                         </td>
                                </tr>
                                <?php  } } ?>


                            </table>
                            <?php  if($list) { ?>
                            <div class="width100 ">
                            <input name="submit" class="btn btn-primary i-t-md" value="提交" type="submit">
                            <input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
                            </div>
                            <?php  } ?>
                            <?php  echo $pager;?>
                        </div>


                    </div>

                </div>
                <?php  } else if($op == 'edit') { ?>
                <script type="text/javascript" src="<?php  echo $this->mapUrl()?>"></script>

                <div class="main city">
                    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
                        <input type="hidden" name="id" value="<?php  echo $city['city_id'];?>" />
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                添加城市
                            </div>
                            <div class="panel-body">

                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="red mr5">*</span>城市名称</span></label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" name="name" id='name' class="form-control" value="<?php  echo $city['name'];?>" /><div>需填全称，如深圳市，需填：深圳市。如县级上无市级，这里需填直辖县</div>
                                    </div>
                                </div>

                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">城市拼音</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" name="pinyin" id='pinyin' class="form-control" value="<?php  echo $city['pinyin'];?>" />
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">首字母（大写）</label>
                                    <div class="col-sm-9 col-xs-12">
                                        <input type="text" name="first_letter" id='first_letter' class="form-control" value="<?php  echo $city['first_letter'];?>" />
                                    </div>
                                </div>
                                <div class="form-group" >
                                    <label class="col-xs-12 col-sm-3 col-md-2 control-label"><span class="red mr5">*</span>城市坐标</label>
                                    <div class="col-sm-9 col-xs-12">

                                        <div class="lt">
                                            经度 <input type="text" name="lng" id="map_x" value="<?php  echo $city['lng'];?>" class="scAddTextName w200">
                                            纬度 <input type="text" name="lat" id="map_y" value="<?php  echo $city['lat'];?>" class="scAddTextName w200">
                                        </div>
                                        <div class="btn-bdmap">
                                            <a style="margin-left: 10px;" onclick="getMapXY();"   class="seleSj">百度地图</a>
                                        </div>
                                        <!--百度地图开始-->
                                        <input type="text" class="form-control input-text" id="suggestId" style="display:none;" placeholder="可以输入指定位置搜索">

                                        <div id="searchResultPanel" ></div>

                                        <div id="allmap" ></div>

                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否热门</label>
                                        <div class="col-sm-9 col-xs-12">
                                            <label class="radio-inline"><input type="radio" value="1" name="is_hot"   <?php  if($city['is_hot'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
                                            <label class="radio-inline"><input type="radio" value="0" name="is_hot"    <?php  if($city['is_hot'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否启用</label>
                                        <div class="col-sm-9 col-xs-12">
                                            <label class="radio-inline"><input type="radio" value="1" name="isopen"   <?php  if($city['isopen'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
                                            <label class="radio-inline"><input type="radio" value="0" name="isopen"    <?php  if($city['isopen'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                                        <div class="col-sm-9 col-xs-12">
                                            <input type="text" name="orderby" class="form-control" value="<?php  echo $city['orderby'];?>" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
                            <input type="hidden" name="op" value="edit" />
                            <div class="width100 ">
                                <input name="submit" type="submit" value="提交" class="btn btn-primary" onclick="return check(this.form)">
                            </div>


                    </form>
                </div>


                <?php  } ?>
    </section>
</section>
</section>
<script>

var map = new BMap.Map("allmap");
var point = new BMap.Point(116.331398,39.897445);
map.centerAndZoom(point,12);

var geolocation = new BMap.Geolocation();
geolocation.getCurrentPosition(function(r){
    if(this.getStatus() == BMAP_STATUS_SUCCESS){
        var mk = new BMap.Marker(r.point);
        map.addOverlay(mk);
        map.panTo(r.point);
    }
    else {
        // alert('failed'+this.getStatus());
    }
},{enableHighAccuracy: true})

/**
 * 获取经纬度
 */
function getMapXY(){
    //单击获取点击的经纬度
    $("#allmap").toggle();
    $("#suggestId").toggle();
    map.addEventListener("click",function(e){
        console.log(e.point);
        $("#map_x").val(e.point.lng);
        $("#map_y").val(e.point.lat);
    });

    // 百度地图API功能
    function G(id) {
        return document.getElementById(id);
    }

    // 初始化地图,设置城市和地图级别。

    var ac = new BMap.Autocomplete(    //建立一个自动完成的对象
        {"input" : "suggestId"
            ,"location" : map
        });

    ac.addEventListener("onhighlight", function(e) {  //鼠标放在下拉列表上的事件
        var str = "";
        var _value = e.fromitem.value;
        var value = "";
        if (e.fromitem.index > -1) {
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str = "FromItem<br />index = " + e.fromitem.index + "<br />value = " + value;

        value = "";
        if (e.toitem.index > -1) {
            _value = e.toitem.value;
            value = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        }
        str += "<br />ToItem<br />index = " + e.toitem.index + "<br />value = " + value;
        G("searchResultPanel").innerHTML = str;
    });

    var myValue;
    ac.addEventListener("onconfirm", function(e) {    //鼠标点击下拉列表后的事件
        var _value = e.item.value;
        myValue = _value.province +  _value.city +  _value.district +  _value.street +  _value.business;
        G("searchResultPanel").innerHTML ="onconfirm<br />index = " + e.item.index + "<br />myValue = " + myValue;

        setPlace();
    });

    function setPlace(){
        map.clearOverlays();    //清除地图上所有覆盖物
        function myFun(){
            var pp = local.getResults().getPoi(0).point;    //获取第一个智能搜索的结果
            map.centerAndZoom(pp, 18);
            map.addOverlay(new BMap.Marker(pp));    //添加标注
        }
        var local = new BMap.LocalSearch(map, { //智能搜索
            onSearchComplete: myFun
        });
        local.search(myValue);
    }
}

function check(){
    var x = $("#map_x").val();
    var y = $("#map_y").val();
    var n = $("#name").val();
    if(x=="" || y==""){
        tip("城市坐标不能为空");
        tip_close();
        return false;
    }
    if(n==""){
        tip("城市名称不能为空");
        tip_close();
        return false;
    }

}

</script>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>