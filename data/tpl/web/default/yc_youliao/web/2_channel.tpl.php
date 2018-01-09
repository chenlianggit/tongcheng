<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>

<section id="content">
	<section class="vbox">
		<section class="padder">
			<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
				<li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
				<li class="active">频道管理</li>
			</ul>

			<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('channel', array('op' => 'display'))?>">频道分类</a></li>
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('channel', array('op' => 'post'))?>"><?php  if(empty($item['id'])) { ?>添加频道<?php  } else { ?>编辑频道<?php  } ?></a></li>
</ul>
<?php  if($operation == 'post') { ?>
<style type='text/css'>
	.tab-pane {padding:20px 0 20px 0;}
</style>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data" id="form1">
		<div class="panel panel-default">
			<div class="panel-heading">
				<?php  if(empty($item['id'])) { ?>添加频道<?php  } else { ?>编辑频道<?php  } ?>
			</div>
			<div class="panel-body">
				<ul class="nav nav-tabs" id="myTab" role="tablist">
					<li class="active" role="presentation"><a aria-expanded="true" aria-controls="tab_basic" data-toggle="tab" role="tab" href="#tab_basic">基本信息</a></li>
					<li role="presentation"><a aria-expanded="true" aria-controls="tab_share" data-toggle="tab" role="tab" href="#tab_share">分享设置</a></li>
					<li role="presentation"><a aria-expanded="true" aria-controls="tab_switch" data-toggle="tab" role="tab" href="#tab_switch">开关设置</a></li>
					<li role="presentation"><a aria-expanded="true" aria-controls="tab_haibao" data-toggle="tab" role="tab" href="#tab_haibao">海报设置</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane  active" id="tab_basic"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/module_basic', TEMPLATE_INCLUDEPATH)) : (include template('web/module_basic', TEMPLATE_INCLUDEPATH));?></div>
					<div class="tab-pane" id="tab_share"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/module_share', TEMPLATE_INCLUDEPATH)) : (include template('web/module_share', TEMPLATE_INCLUDEPATH));?></div>
					<div class="tab-pane" id="tab_switch"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/module_switch', TEMPLATE_INCLUDEPATH)) : (include template('web/module_switch', TEMPLATE_INCLUDEPATH));?></div>
					<div class="tab-pane" id="tab_haibao"><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/module_haibao', TEMPLATE_INCLUDEPATH)) : (include template('web/module_haibao', TEMPLATE_INCLUDEPATH));?></div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12 form-submit">
			<input type="submit" name="submit" value="提交" class="btn btn-primary" onclick="return check(this.form)" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>
<?php  } ?>


<?php  if($operation == 'display') { ?>
<div class="panel panel-default tdbox">
	<div class="table-responsive">
		<form action="" method="post">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<!--<th style="width:3%;">ID</th>-->
					<th style="width:6%;">排序</th>
					<th style="width:10%;">频道图标</th>
					<th style="width:17%;">频道名称</th>
					<th style="width:8%;">发布信息</th>
					<th style="width:8%;">信息审核</th>
					<th style="width:56%;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<!--<td><?php  if(count($children[$item['id']]) > 0) { ?><a href="javascript:;"><i class="fa fa-chevron-down" data-id="<?php  echo $item['id'];?>"></i></a><?php  } ?></td>-->
					<td><input class="form-control" name="displayorder[<?php  echo $item['id'];?>]" value="<?php  echo $item['displayorder'];?>" type="text"></td>
					<td class="tableBox">
						<img src="<?php  echo tomedia($item['thumb']);?>"
							 onerror="javascript:this.src='<?php echo SQ;?>public/images/noimg.png'"  />
						<a href="<?php  echo $this->createWebUrl('channel',array('op'=>'post','fid'=>$item['id']))?>"><i class="fa fa-plus-circle"></i> 子分类</a>
					</td>
					<td><span class="label label-default"><?php  echo $item['name'];?></span> <?php  if($item['ison'] == 1) { ?><span class="label label-success">展示</span><?php  } else { ?><span class="label label-danger">不展示</span><?php  } ?></td>
					<td>
						<?php  if(count($children[$item['id']]) <= 0) { ?>
							<?php  if($item['canrelease'] == 1) { ?><span class="label label-success">允许</span><?php  } else { ?><span class="label label-danger">不允许</span><?php  } ?>
						<?php  } ?>
					</td>
					<td>
						<?php  if(count($children[$item['id']]) <= 0) { ?>
							<?php  if($item['isshenhe'] == 1) { ?><span class="label label-success">开启</span><?php  } else { ?><span class="label label-danger">关闭</span><?php  } ?>
						<?php  } ?>
					</td>
					<td style="text-align:right;">
						<?php  if(count($children[$item['id']]) <= 0) { ?>
						<button type="button" data-toggle="modal" data-target="#formModal<?php  echo $item['id'];?>" class="btn btn-info btn-sm">添加自定义属性</button>
						<button type="button" data-toggle="modal" data-target="#customModal<?php  echo $item['id'];?>" class="btn btn-info btn-sm">查看自定义属性<?php  if($item['fieldnum'] > 0) { ?><span class="label label-warning" style="margin-left:5px;"><?php  echo $item['fieldnum'];?></span><?php  } ?></button>
						<div class="fl">
						<a href="<?php  echo $this->createWebUrl('channel', array('id' => $item['id'], 'op' => 'html','type'=>'list'))?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="自定义列表页面" target="_blank">自定义列表页面</a>
						</div>
						<div class="fl">
						<a href="<?php  echo $this->createWebUrl('channel', array('id' => $item['id'], 'op' => 'html','type'=>'detail'))?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="自定义详情页面" target="_blank">自定义详情页面</a>
						</div>
						<?php  } ?>
	<div class="fl">
						<a href="<?php  echo $this->createWebUrl('channel', array('id' => $item['id'], 'op' => 'post'))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
						<a href="<?php  echo $this->createWebUrl('channel', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('删除频道将删除频道对应的所有信息，确认删除吗？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>
	</div>
					</td>
				</tr>
				<?php  if(is_array($children[$item['id']])) { foreach($children[$item['id']] as $item) { ?>
					<tr data-parentid="<?php  echo $item['fid'];?>">

						<td><input class="form-control" name="displayorder[<?php  echo $item['id'];?>]" value="<?php  echo $item['displayorder'];?>" type="text"></td>
						<td>
							&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span class="label label-default"><?php  echo $item['name'];?></span>
						</td>
						<td><?php  if($item['ison'] == 1) { ?><span class="label label-success">展示</span><?php  } else { ?><span class="label label-danger">不展示</span><?php  } ?></td>
						<td><?php  if($item['canrelease'] == 1) { ?><span class="label label-success">允许</span><?php  } else { ?><span class="label label-danger">不允许</span><?php  } ?></td>
						<td><?php  if($item['isshenhe'] == 1) { ?><span class="label label-success">开启</span><?php  } else { ?><span class="label label-danger">关闭</span><?php  } ?></td>
						<td style="text-align:right;">
							<button type="button" data-toggle="modal" data-target="#formModal<?php  echo $item['id'];?>" class="btn btn-info btn-sm">添加自定义属性</button>
							<button type="button" data-toggle="modal" data-target="#customModal<?php  echo $item['id'];?>" class="btn btn-info btn-sm">查看自定义属性<?php  if($item['fieldnum'] > 0) { ?><span class="label label-warning" style="margin-left:5px;"><?php  echo $item['fieldnum'];?></span><?php  } ?></button>
							<div class="fl">
							<a href="<?php  echo $this->createWebUrl('channel', array('id' => $item['id'], 'op' => 'html','type'=>'list'))?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="自定义列表页面" target="_blank">自定义列表页面</a>
							</div>
							<div class="fl">
							<a href="<?php  echo $this->createWebUrl('channel', array('id' => $item['id'], 'op' => 'html','type'=>'detail'))?>" class="btn btn-success btn-sm" data-toggle="tooltip" data-placement="top" title="自定义详情页面" target="_blank">自定义详情页面</a>
							</div>
							<div class="fl">
							<a href="<?php  echo $this->createWebUrl('channel', array('id' => $item['id'],'fid' => $item['fid'], 'op' => 'post'))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="编辑"><i class="fa fa-pencil"></i></a>&nbsp;&nbsp;
							<a href="<?php  echo $this->createWebUrl('channel', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('删除频道将删除频道对应的所有信息，确认删除吗？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>
							</div>
						</td>
					</tr>
				<?php  } } ?>
				<?php  } } ?>
				<?php  if($list) { ?>
				<tr>
					<td colspan="7">
						<input name="submit" class="btn btn-primary i-t-md" value="提交" type="submit">
						<input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
					</td>
				</tr>
			<?php  } ?>
			</tbody>
		</table>
		</form>
	</div>
	</div>
</div>

<?php  if(is_array($list2)) { foreach($list2 as $item) { ?>
<div class="modal fade" id="formModal<?php  echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="" method="post" class="form-horizontal form">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">添加<strong><?php  echo $item['name'];?></strong>自定义属性</h4>
			</div>
			<div class="modal-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">添加信息提示名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="name" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">前端页面显示名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="showname" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">字段英文名</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="enname" class="form-control" />
						<span class="help-block" style="color:#900;">
						信息标题字段英文名务必填写成title
						<br />请填写英文名称,不要填写和系统内置字段相同的名称
						<br />如：area,createtime,nickname,id,weid,mid,avatar,province,city,district,lng,lat,views,status,module,isneedpay,haspay
						</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">类型</label>
					<div class="col-sm-9 col-xs-12">
						<select name="mtype" class="form-control">
							<option value="text" onclick="$('#mtypecon<?php  echo $item['id'];?>').hide();$('#danwei<?php  echo $item['id'];?>').show();">文本</option>
							<option value="number" onclick="$('#mtypecon<?php  echo $item['id'];?>').hide();$('#danwei<?php  echo $item['id'];?>').show();">数字</option>
							<option value="longtext" onclick="$('#mtypecon<?php  echo $item['id'];?>').hide();$('#danwei<?php  echo $item['id'];?>').hide();">长文本</option>
							<option value="select" onclick="$('#mtypecon<?php  echo $item['id'];?>').show();$('#danwei<?php  echo $item['id'];?>').hide();">下拉选项</option>
							<option value="checkbox" onclick="$('#mtypecon<?php  echo $item['id'];?>').show();$('#danwei<?php  echo $item['id'];?>').hide();">多选框</option>
							<option value="radio" onclick="$('#mtypecon<?php  echo $item['id'];?>').show();$('#danwei<?php  echo $item['id'];?>').hide();">单选框</option>
							<option value="images" onclick="$('#mtypecon<?php  echo $item['id'];?>').hide();$('#danwei<?php  echo $item['id'];?>').hide();">图片</option>
							<option value="date" onclick="$('#mtypecon<?php  echo $item['id'];?>').hide();$('#danwei<?php  echo $item['id'];?>').hide();">日期</option>
							<option value="datetime" onclick="$('#mtypecon<?php  echo $item['id'];?>').hide();$('#danwei<?php  echo $item['id'];?>').hide();">日期时间</option>
							<option value="telphone" onclick="$('#mtypecon<?php  echo $item['id'];?>').hide();$('#danwei<?php  echo $item['id'];?>').hide();">手机</option>
							<option value="idcard" onclick="$('#mtypecon<?php  echo $item['id'];?>').hide();$('#danwei<?php  echo $item['id'];?>').hide();">身份证</option>
						</select>
					</div>
				</div>
				<div class="form-group" id="danwei<?php  echo $item['id'];?>" style="display:none;">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">单位</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="danwei" class="form-control" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">默认值</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="defaultval" class="form-control" />
						<span class="help-block" style="color:#900;">图片不支持默认值</span>
					</div>
				</div>
				<div class="form-group" id="mtypecon<?php  echo $item['id'];?>" style="display:none;">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">类型初始化值</label>
					<div class="col-sm-9 col-xs-12">
						<textarea class="form-control" name="mtypecon"></textarea>
						<span class="help-block" style="color:#900;">多个请用|隔开</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享类型</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline"><input type="radio" name="sharetype" checked="checked" value="0" /> 无</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" name="sharetype" value="1" /> 分享标题</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" name="sharetype" value="2" /> 分享描述</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否必填</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline"><input type="radio" name="isrequired" value="1" /> 是</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" name="isrequired" value="0" /> 否</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否验证字符长度</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline"><input type="radio" onclick="$('.lengroup').show();" name="islenval" value="1" /> 验证</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" onclick="$('.lengroup').hide();" name="islenval" value="0" /> 不验证</label>
					</div>
				</div>
				<div class="form-group lengroup" style="display:none;">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">最小长度</label>
					<div class="col-sm-3 col-xs-12">
						<div class="input-group">
							<input type="text" name="minlen" class="form-control" />
							<span class="input-group-addon">个字符</span>
						</div>
					</div>
				</div>
				<div class="form-group lengroup" style="display:none;">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">最大长度</label>
					<div class="col-sm-3 col-xs-12">
						<div class="input-group">
							<input type="text" name="maxlen" class="form-control" />
							<span class="input-group-addon">个字符</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
					<div class="col-sm-2 col-xs-12">
						<input type="text" name="displayorder" class="form-control" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input name="op" value="custom" type="hidden">
				<input name="mid" value="<?php  echo $item['id'];?>" type="hidden">
				<input name="submit" class="btn btn-primary" value="提交" type="submit">
				<input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
			</div>
		</div>
	</div>
	</form>
</div>

<?php  if($item['fieldslist']) { ?>
<?php  if(is_array($item['fieldslist'])) { foreach($item['fieldslist'] as $rowrow) { ?>
<div class="modal" id="formupModal<?php  echo $rowrow['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<form action="" method="post" class="form-horizontal form">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">修改<strong><?php  echo $item['name'];?></strong>自定义属性</h4>
			</div>
			<div class="modal-body">				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">添加信息提示名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="name" class="form-control" value="<?php  echo $rowrow['name'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">前端页面显示名称</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="showname" class="form-control" value="<?php  echo $rowrow['showname'];?>" />
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">字段英文名</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="enname" value="<?php  echo $rowrow['enname'];?>" class="form-control" />
						<span class="help-block" style="color:#900;">
						信息标题字段英文名务必填写成title
						<br />请填写英文名称,不要填写和系统内置字段相同的名称
						<br />如：area,createtime,nickname,id,weid,mid,avatar,province,city,district,lng,lat,views,status,module,isneedpay,haspay
						</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">类型</label>
					<div class="col-sm-9 col-xs-12">
						<select name="mtype" class="form-control">
							<option value="text" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').hide();$('#danwei<?php  echo $rowrow['id'];?>').show();" <?php  if($rowrow['mtype'] == 'text') { ?>selected="selected"<?php  } ?>>文本</option>
							<option value="number" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').hide();$('#danwei<?php  echo $rowrow['id'];?>').show();" <?php  if($rowrow['mtype'] == 'number') { ?>selected="selected"<?php  } ?>>数字</option>
							<option value="longtext" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').hide();$('#danwei<?php  echo $rowrow['id'];?>').hide();" <?php  if($rowrow['mtype'] == 'longtext') { ?>selected="selected"<?php  } ?>>长文本</option>
							<option value="select" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').show();$('#danwei<?php  echo $rowrow['id'];?>').hide();" <?php  if($rowrow['mtype'] == 'select') { ?>selected="selected"<?php  } ?>>下拉选项</option>
							<option value="checkbox" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').show();$('#danwei<?php  echo $rowrow['id'];?>').hide();" <?php  if($rowrow['mtype'] == 'checkbox') { ?>selected="selected"<?php  } ?>>多选框</option>
							<option value="radio" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').show();$('#danwei<?php  echo $rowrow['id'];?>').hide();" <?php  if($rowrow['mtype'] == 'radio') { ?>selected="selected"<?php  } ?>>单选框</option>
							<option value="images" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').hide();$('#danwei<?php  echo $rowrow['id'];?>').hide();" <?php  if($rowrow['mtype'] == 'images') { ?>selected="selected"<?php  } ?>>图片</option>
							<option value="date" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').hide();$('#danwei<?php  echo $rowrow['id'];?>').hide();" <?php  if($rowrow['mtype'] == 'date') { ?>selected="selected"<?php  } ?>>日期</option>
							<option value="datetime" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').hide();$('#danwei<?php  echo $rowrow['id'];?>').hide();" <?php  if($rowrow['mtype'] == 'datetime') { ?>selected="selected"<?php  } ?>>日期时间</option>
							<option value="telphone" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').hide();$('#danwei<?php  echo $rowrow['id'];?>').hide();" <?php  if($rowrow['mtype'] == 'telphone') { ?>selected="selected"<?php  } ?>>手机</option>
							<option value="idcard" onclick="$('#mtypecon<?php  echo $rowrow['id'];?>').hide();$('#danwei<?php  echo $rowrow['id'];?>').hide();" <?php  if($rowrow['mtype'] == 'idcard') { ?>selected="selected"<?php  } ?>>身份证</option>
						</select>
					</div>
				</div>
				
				<?php  if($rowrow['mtype'] == 'text' || $rowrow['mtype'] == 'number') { ?>
				<div class="form-group" id="danwei<?php  echo $rowrow['id'];?>">
				<?php  } else { ?>
				<div class="form-group" id="danwei<?php  echo $rowrow['id'];?>" style="display:none;">
				<?php  } ?>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">单位</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="danwei" class="form-control" value="<?php  echo $rowrow['danwei'];?>" />
					</div>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">默认值</label>
					<div class="col-sm-9 col-xs-12">
						<input type="text" name="defaultval" class="form-control" value="<?php  echo $rowrow['defaultval'];?>" />
						<span class="help-block" style="color:#900;">图片不支持默认值</span>
					</div>
				</div>
				
				<?php  if($rowrow['mtype'] == 'select' || $rowrow['mtype'] == 'checkbox' || $rowrow['mtype'] == 'radio') { ?>
				<div class="form-group" id="mtypecon<?php  echo $rowrow['id'];?>">
				<?php  } else { ?>
				<div class="form-group" id="mtypecon<?php  echo $rowrow['id'];?>" style="display:none;">
				<?php  } ?>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">类型初始化值</label>
					<div class="col-sm-9 col-xs-12">
						<textarea class="form-control" name="mtypecon"><?php  echo $rowrow['mtypecon'];?></textarea>
						<span class="help-block" style="color:#900;">多个请用|隔开</span>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">分享类型</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline"><input type="radio" name="sharetype" <?php  if($rowrow['sharetype'] == 0) { ?>checked="checked"<?php  } ?> value="0" /> 无</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" name="sharetype" <?php  if($rowrow['sharetype'] == 1) { ?>checked="checked"<?php  } ?> value="1" /> 分享标题</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" name="sharetype" <?php  if($rowrow['sharetype'] == 2) { ?>checked="checked"<?php  } ?> value="2" /> 分享描述</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否必填</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline"><input type="radio" name="isrequired" value="1" <?php  if($rowrow['isrequired'] == 1) { ?>checked="checked"<?php  } ?> /> 是</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" name="isrequired" value="0" <?php  if($rowrow['isrequired'] == 0) { ?>checked="checked"<?php  } ?> /> 否</label>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否验证字符长度</label>
					<div class="col-sm-9 col-xs-12">
						<label class="radio-inline"><input type="radio" onclick="$('.lengroup').show();" <?php  if($rowrow['islenval'] == 1) { ?>checked="checked"<?php  } ?> name="islenval" value="1" /> 验证</label>
						&nbsp;&nbsp;&nbsp;
						<label class="radio-inline"><input type="radio" onclick="$('.lengroup').hide();" <?php  if($rowrow['islenval'] == 0) { ?>checked="checked"<?php  } ?> name="islenval" value="0" /> 不验证</label>
					</div>
				</div>
				<?php  if($rowrow['islenval'] == 1) { ?>
				<div class="form-group lengroup">
				<?php  } else { ?>
				<div class="form-group lengroup" style="display:none;">
				<?php  } ?>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">最小长度</label>
					<div class="col-sm-3 col-xs-12">
						<div class="input-group">
							<input type="text" name="minlen" class="form-control" value="<?php  echo $rowrow['minlen'];?>" />
							<span class="input-group-addon">个字符</span>
						</div>
					</div>
				</div>
				<?php  if($rowrow['islenval'] == 1) { ?>
				<div class="form-group lengroup">
				<?php  } else { ?>
				<div class="form-group lengroup" style="display:none;">
				<?php  } ?>
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">最大长度</label>
					<div class="col-sm-3 col-xs-12">
						<div class="input-group">
							<input type="text" name="maxlen" class="form-control" value="<?php  echo $rowrow['maxlen'];?>" />
							<span class="input-group-addon">个字符</span>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
					<div class="col-sm-2 col-xs-12">
						<input type="text" name="displayorder" class="form-control" value="<?php  echo $rowrow['displayorder'];?>" />
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<input name="op" value="custom" type="hidden">
				<input name="mid" value="<?php  echo $rowrow['mid'];?>" type="hidden">
				<input name="id" value="<?php  echo $rowrow['id'];?>" type="hidden">
				<input name="submit" class="btn btn-primary" value="提交" type="submit">
				<input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
			</div>
		</div>
	</div>
	</form>
</div>
<?php  } } ?>
<?php  } ?>

<div class="modal" id="customModal<?php  echo $item['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title"><strong><?php  echo $item['name'];?></strong>自定义属性列表</h4>
			</div>
			<div class="modal-body table-responsive">
				<?php  if($item['fieldslist']) { ?>
					<form action="" method="post">
					<table class="table table-hover table-bordered">
						<thead class="navbar-inner">
							<tr>
								<th style="width:10%;">排序</th>
								<th style="width:20%;">展示名称</th>
								<th style="width:15%;">字段名称</th>
								<th style="width:15%;">类型</th>
								<th style="width:15%;">默认值</th>
								<th style="width:10%;">必填</th>
								<th style="width:15%;text-align:right;">操作</th>
							</tr>
						</thead>
						<tbody>
							<?php  if(is_array($item['fieldslist'])) { foreach($item['fieldslist'] as $rowrow) { ?>
							<tr>
								<td>
									<input class="form-control" name="displayorder[<?php  echo $rowrow['id'];?>]" value="<?php  echo $rowrow['displayorder'];?>" type="text">
								</td>
								<td>
									<span class="label label-success"><?php  echo $rowrow['showname'];?></span>
									<?php  if($rowrow['sharetype'] > 0) { ?>
										<span class="label label-warning"><?php  if($rowrow['sharetype'] == 1) { ?>分享标题<?php  } ?><?php  if($rowrow['sharetype'] == 2) { ?>分享描述<?php  } ?></span>
									<?php  } ?>
								</td>
								<td>
									<span class="label label-success"><?php  echo $rowrow['enname'];?></span>
								</td>
								<td>
									<span class="label label-primary"><?php  echo $this->getfieldtype($rowrow['mtype']);?></span>
								</td>
								<td>
									<span class="label label-success"><?php  echo $rowrow['defaultval'];?></span>
								</td>
								<td>
									<?php  if($rowrow['isrequired'] == 1) { ?>
									<span class="label label-success">必填</span>
									<?php  } else { ?>
									<span class="label label-danger">非必填</span>
									<?php  } ?>
								</td>
								<td style="text-align:right;">
									<button type="button" data-toggle="modal" data-target="#formupModal<?php  echo $rowrow['id'];?>" onclick="$('#customModal<?php  echo $item['id'];?>').modal('hide');" class="btn btn-info btn-sm">修改</button>
									<a href="<?php  echo $this->createWebUrl('channel', array('id' => $rowrow['id'], 'op' => 'deletefield'))?>" onclick="return confirm('此操作不可恢复，确认删除？');return false;" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>
								</td>
							</tr>
							<?php  } } ?>
							<tr>
								<td colspan="7">
									<input name="op" value="customdisplayorder" type="hidden">
									<input name="submit" class="btn btn-primary" value="排序" type="submit">
									<input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
								</td>
							</tr>
						</tbody>
					</table>
					</form>
				<?php  } else { ?>
					<table class="table table-hover table-bordered">
						<thead class="navbar-inner">
							<tr><th colspan="7">暂无记录</th></tr>
						</thead>
					</table>
				<?php  } ?>
			</div>
		</div>
	</div>
</div>
<?php  } } ?>
<?php  } ?>
<script>
    function check(){
        var n = $("input[name='name']").val();
        if(n==""){
            tip("频道名称不能为空");
            tip_close();
            return false;
        }

    }
$(function(){
	$(".fa").click(function(){
		$("tr[data-parentid="+$(this).attr('data-id')+"]").toggle();
		if($(this).hasClass("fa-chevron-down")){
			$(this).removeClass('fa-chevron-down').addClass('fa-chevron-up');
		}else{
			$(this).removeClass('fa-chevron-up').addClass('fa-chevron-down');
		}
	});
})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>