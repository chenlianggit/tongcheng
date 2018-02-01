<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>

      <section id="content">
        <section class="vbox">
          <section class="padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
              <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
              <li class="active">广告管理</li>          
            </ul> 

<ul class="nav nav-tabs">
    <li <?php  if($op == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('adv',array('op' =>'display'))?>">广告列表</a></li>
    <?php  if($op == 'post') { ?> <li class="active" ><a href="<?php  echo $this->createWebUrl('adv',array('op' =>'post'))?>">添加广告</a></li><?php  } ?>
</ul>
<?php  if($op == 'display') { ?>
<div class="main">
    <div class="panel panel-info"  >
        <div class="panel-body  table-responsive" style="padding:15px;background:#fff;">
            <div class="jsglNr">
                <div class="selectNr" >
                    <div class="left">
                        <a href="<?php  echo $this->createWebUrl('adv',array('op' =>'post'))?>">添加广告</a>
                    </div>
        <table class="table table-hover">
            <thead class="navbar-inner">
                <tr class="theader">
                    <th>ID</th>
                    <th>缩略图</th>
                    <th>显示顺序</th>					
                    <th>标题</th>
                    <th>位置</th>
                    <th >操作</th>
                </tr>
            </thead>
            <tbody>
                <?php  if(is_array($list)) { foreach($list as $adv) { ?>
                <tr>
                    <td><?php  echo $adv['id'];?></td>
                    <td class="tableadv"><img src="<?php  echo tomedia($adv['thumb']);?>"
                             onerror="javascript:this.src='<?php echo SQ;?>public/images/noimg.png'"   /></td>
                    <td><?php  echo $adv['displayorder'];?></td>
                    <td><?php  echo $adv['advname'];?></td><?php  $adv['type']=json_decode($adv['type'])?>
                    <td><?php  if(in_array('1',(array)$adv['type'])) { ?>首页顶部<?php  } ?>
                        <?php  if(in_array('2',(array)$adv['type'])) { ?>首页中部<?php  } ?>
                        <?php  if(in_array('3',(array)$adv['type'])) { ?>首页底部<?php  } ?>
                        <?php  if(in_array('4',(array)$adv['type'])) { ?>拼团顶部<?php  } ?>
                        <?php  if(in_array('5',(array)$adv['type'])) { ?>秒杀顶部<?php  } ?>
                        <?php  if(in_array('6',(array)$adv['type'])) { ?>首单优惠顶部<?php  } ?>
                        <?php  if(in_array('7',(array)$adv['type'])) { ?>优惠买单顶部<?php  } ?>
                        <?php  if(in_array('8',(array)$adv['type'])) { ?>同城频道顶部<?php  } ?>
                        <?php  if(in_array('9',(array)$adv['type'])) { ?>附近商圈顶部<?php  } ?>
                        <?php  if(in_array('10',(array)$adv['type'])) { ?>圈子顶部<?php  } ?>
                        <?php  if(in_array('11',(array)$adv['type'])) { ?>支付页面顶部<?php  } ?>
                        <?php  if(in_array('12',(array)$adv['type'])) { ?>商家入驻顶部<?php  } ?>
                        <?php  if(in_array('15',(array)$adv['type'])) { ?>搜索页面顶部<?php  } ?>
                        <?php  if(in_array('13',(array)$adv['type'])) { ?>个人中心顶部背景图<?php  } ?>
                        <?php  if(in_array('14',(array)$adv['type'])) { ?>首页弹出框广告<?php  } ?>

                        </td>

                    <td class="listbtn"><a href="<?php  echo $this->createWebUrl('adv', array('op' => 'post', 'id' => $adv['id']))?>"><i class="fa fa-edit"></i>修改</a>
                        <a class="label label-danger pad-5 " href="<?php  echo $this->createWebUrl('adv', array('op' => 'delete', 'id' => $adv['id']))?>"><i class="fa fa-exclamation-triangle"></i>删除</a>
                      </td>
                </tr>
                <?php  } } ?>
            </tbody>
        </table>
            </div></div>
        <?php  echo $pager;?>
    </div>
</div>
<?php  } else if($op == 'post') { ?>
<div class="main">
    <form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" onsubmit='return formcheck()'>
        <input type="hidden" name="id" value="<?php  echo $adv['id'];?>" />
        <div class="panel panel-default">
            <div class="panel-heading">
                幻灯片设置
            </div>
            <div class="panel-body" >
                <div class="form-group" >
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片标题</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="advname" id='advname' class="form-control" value="<?php  echo $adv['advname'];?>" />
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">幻灯片图片</label>
                    <div class="col-sm-9 col-xs-12">
                        <?php  echo tpl_form_field_image('thumb',$adv['thumb']);?>
                        <p class="help-block">建议上传宽度768px高度300px图片,顶部广告图片需预留搜索框100px空隙</p>
                    </div>

                </div>


                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">店铺编号</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="number" name="link" id='link' class="form-control" value="<?php  if($adv['link']){echo $adv['link']; }else{echo 0;} ?>" />
                        <p class="help-block">请输入店铺编号,点击查看<a href="./index.php?c=site&a=entry&do=shop&m=yc_youliao" target="_blank" style="    background: #33b089;
    padding: 5px 5px;
    margin: 10px 0;">店铺编号列表</a></p>
                    </div>

                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">是否显示</label>
                    <div class="col-sm-9 col-xs-12">
                        <label class="radio-inline"><input type="radio" name="enabled" value="1" id="enabled1" <?php  if(empty($adv) || $adv['enabled'] == 1) { ?>checked="true"<?php  } ?> /> 是</label>
                        <label class="radio-inline"><input type="radio" name="enabled" value="0" id="enabled2"  <?php  if(!empty($adv) && $adv['enabled'] == 0) { ?>checked="true"<?php  } ?> /> 否</label>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">位置</label>
                    <div class="col-sm-9 col-xs-12 advcheck">
                        <?php  $adv['type']=json_decode($adv['type'])?>
                        <!-- <label ><input type="checkbox"  name="type[]" value="1" id="type1" <?php  if(in_array('1',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />首页顶部</label>
                        <label ><input type="checkbox"  name="type[]" value="2" id="type2"  <?php  if(in_array('2',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />首页中部</label>
                        <label ><input type="checkbox"  name="type[]" value="3" id="type3"  <?php  if(in_array('3',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />首页底部</label>
                        <label ><input type="checkbox"  name="type[]" value="4" id="type4"  <?php  if(in_array('4',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />拼团顶部</label>
                        <label ><input type="checkbox"  name="type[]" value="5" id="type5"  <?php  if(in_array('5',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />秒杀顶部</label>
                        <label ><input type="checkbox"  name="type[]" value="6" id="type6"  <?php  if(in_array('6',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />首单优惠顶部</label>
                        <label ><input type="checkbox"  name="type[]" value="7" id="type7"  <?php  if(in_array('7',(array)$adv['type'])) { ?>checked="checked"<?php  } ?>/>优惠买单顶部</label>
                        <label ><input type="checkbox"  name="type[]" value="8" id="type8"  <?php  if(in_array('8',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />同城频道顶部</label>
                        <label><input type="checkbox"  name="type[]" value="9" id="type9"  <?php  if(in_array('9',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />附近商圈顶部</label>
                        <label><input type="checkbox"  name="type[]" value="10" id="type10"  <?php  if(in_array('10',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />圈子顶部</label>
                        <label><input type="checkbox"  name="type[]" value="11" id="type11"  <?php  if(in_array('11',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />支付页面顶部</label>
                        <label><input type="checkbox"  name="type[]" value="12" id="type12"  <?php  if(in_array('12',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />商家入驻顶部</label>
                        <label><input type="checkbox"  name="type[]" value="15" id="type15"  <?php  if(in_array('15',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />搜索页面顶部</label>
                        <label><input type="checkbox"  name="type[]" value="13" id="type13"  <?php  if(in_array('13',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />个人中心顶部背景图</label>
                        <label><input type="checkbox"  name="type[]" value="14" id="type14"  <?php  if(in_array('14',(array)$adv['type'])) { ?>checked="checked"<?php  } ?> />首页弹出框广告</label> -->
                        <select name="" id="myselect">
                            <option value="1" data-checked="<?php  if(in_array('1',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">首页顶部</option>
                            <option value="2" data-checked="<?php  if(in_array('2',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">首页中部</option>
                            <option value="3" data-checked="<?php  if(in_array('3',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">首页底部</option>
                            <option value="4" data-checked="<?php  if(in_array('4',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">拼团顶部</option>
                            <option value="5" data-checked="<?php  if(in_array('5',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">秒杀顶部</option>
                            <option value="6" data-checked="<?php  if(in_array('6',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">首单优惠顶部</option>
                            <option value="7" data-checked="<?php  if(in_array('7',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">优惠买单顶部</option>
                            <option value="8" data-checked="<?php  if(in_array('8',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">同城频道顶部</option>
                            <option value="9" data-checked="<?php  if(in_array('9',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">附近商圈顶部</option>
                            <option value="10" data-checked="<?php  if(in_array('10',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">圈子顶部</option>
                            <option value="11" data-checked="<?php  if(in_array('11',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">支付页面顶部</option>
                            <option value="12" data-checked="<?php  if(in_array('12',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">商家入驻顶部</option>
                            <option value="13" data-checked="<?php  if(in_array('13',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">个人中心顶部背景图</option>
                            <option value="14" data-checked="<?php  if(in_array('14',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">首页弹出框广告</option>
                            <option value="15" data-checked="<?php  if(in_array('15',(array)$adv['type'])) { ?>1<?php  } else { ?>0<?php  } ?>">搜索页面顶部</option>
                        </select>
                        <p class="help-block">仅顶部广告为动画</p>
                    </div>
                </div>
                <script>
                    function SelectBox(options) {
                        this.hasSelect = []
                        this.id = options.id
                        this.name = options.name
                        this.init()
                      }
                      SelectBox.prototype.init = function () {
                        var Box = $('<div class="m-select"></div>')
                        var boxSelect = $('<div class="boxSelect">请选择</div>')
                        Box.append(boxSelect)
                        var str = '<div class="selectWap">'
                        var _self = this
                        $(this.id).children().each(function (i, v) {
                          var _this = $(this)
                          str += '<label for="type' + i + '" class="s-label">'
                          if ( _this.data('checked') == 1) {
                            str += '<input type="checkbox" name="' + _self.name + '" value="' + _this.val() + '" checked class="s-checkbox" id="type' + i + '">'
                            str += '<span class="s-checkbox__inner is-checked"></span>'
                            _self.hasSelect.push(_this.text())
                          } else {
                            str += '<input type="checkbox" name="' + _self.name + '"  value="' + _this.val() + '" class="s-checkbox" id="type' + i + '">'
                            str += '<span class="s-checkbox__inner"></span>'
                          }
                          str += '<span class="s-text">' + _this.text() + '</span>'
                          str += '</label>'
                        })
                        str += '</div>'
                        if (_self.hasSelect.length > 0) {
                          boxSelect.text(_self.hasSelect.toString())
                        }
                        $(str).appendTo(Box)
                        Box.on('click', '.boxSelect', function () {
                          var _this = $(this)
                          if (!_this.hasClass('show')) {
                            _this.addClass('show')
                            $('.selectWap').addClass('h180')
                          } else {
                            _this.removeClass('show')
                            $('.selectWap').removeClass('h180')
                          }
                        })
                        Box.on('click', '.s-checkbox', function () {
                          var _this = $(this)
                          if (this.checked) {
                            _self.hasSelect.push(_this.siblings('.s-text').text())
                            _this.siblings('.s-checkbox__inner').addClass('is-checked')
                          } else {
                            var index = _self.hasSelect.indexOf(_this.siblings('.s-text').text())
                            _self.hasSelect.splice(index, 1)
                            _this.siblings('.s-checkbox__inner').removeClass('is-checked')
                          }
                          if (_self.hasSelect.length > 0) {
                            $('.boxSelect').text(_self.hasSelect.toString())
                          } else {
                            $('.boxSelect').text('请点击选择(多选)')
                          }
                        })
                        $(this.id).replaceWith(Box)
                      }
                        $(function () {
                            var select = new SelectBox({id: '#myselect', name: 'type[]'})
                        })
                </script>
            <div class="panel-body">
                <div class="form-group">
                    <label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
                    <div class="col-sm-9 col-xs-12">
                        <input type="text" name="displayorder" class="form-control" value="<?php  echo $adv['displayorder'];?>" />
                    </div>
                </div>
            </div>
        </div>
        
        <div class="width100 ">
	    <input name="submit" type="submit" value="提交" class="btn btn-primary">
		</div>

        <input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
    </form>
</div>
</div>
<?php  } ?>
</section>
</section>
</section>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>