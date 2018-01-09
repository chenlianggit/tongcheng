<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>

<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
			<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
				<li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
				<li class="active">信息管理</li>
			</ul>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('info',array('op' =>'display'))?>">信息中心</a></li>
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('info',array('op' =>'post'))?>"><?php  if(empty($item['id'])) { ?>添加信息<?php  } else { ?>编辑信息<?php  } ?></a></li>
</ul>

<?php  if($operation == 'display') { ?>
<div class="main">
	<div class="panel panel-info">
		<div class="panel-heading">筛选</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
				<input type="hidden" name="c" value="site" />
				<input type="hidden" name="a" value="entry" />
				<input type="hidden" name="m" value="yc_youliao" />
				<input type="hidden" name="do" value="info" />
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键词</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="可查询关键词">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">所属频道</label>
					<div class="col-sm-3 col-xs-12">					
						<select name="mid" class="form-control">
							<option value="">全部频道</option>
							<?php  if(is_array($modulecenterlist)) { foreach($modulecenterlist as $mrow) { ?>
								<?php  if($mrow['children']) { ?>
									<optgroup label="<?php  echo $mrow['name'];?>">
										<?php  if(is_array($mrow['children'])) { foreach($mrow['children'] as $mrowrow) { ?>
										<option value ="<?php  echo $mrowrow['id'];?>" <?php  if($mrowrow['id'] == $_GPC['mid']) { ?>selected="selected"<?php  } ?>>┗ <?php  echo $mrowrow['name'];?></option>
										<?php  } } ?>
									</optgroup>
								<?php  } else { ?>
									<option value="<?php  echo $mrow['id'];?>" <?php  if($mrow['id'] == $_GPC['mid']) { ?>selected="selected"<?php  } ?>><?php  echo $mrow['name'];?></option>
								<?php  } ?>
								
							<?php  } } ?>
						</select>
					</div>
					<div class="col-sm-7 col-xs-12">
						<input type="hidden" name="status" value="<?php  echo $status;?>" />
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
						<button type="button" class="btn btn-default">总记录数：<?php  echo $total;?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
	
	<div class="panel panel-default">
		<div class="panel-body table-responsive">
			<form action="" method="post">
			<table class="table table-hover">
				<thead class="navbar-inner">
					<tr>
						<th class="row-first" style="width:5%;">选择 </th>
						<th style="width:10%;">所属频道</th>
						<th style="width:8%;">支付</th>
						<th style="width:15%;">位置</th>
						<th style="width:8%;">发布人</th>
						<th style="width:23%;">标题</th>					
						<th style="width:10%;">发布时间</th>
						<th style="text-align:right;">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php  if(is_array($list)) { foreach($list as $message) { ?>
					<tr>
						<td><input class="checkbox" name="akid[<?php  echo $message['id'];?>]" value="1" type="checkbox"></td>
						<td><span style="color:#900;">[<?php  echo getmodulename($_W['uniacid'],$message['mid']);?>]</span></td>
						<td>
							<?php  if($message['isneedpay'] == 1) { ?>
								<?php  if($message['haspay'] == 1) { ?>
								<span class="label label-success">已支付</span>
								<?php  } else { ?>
								<span class="label label-warning">未支付</span>
								<?php  } ?>
							<?php  } ?>
						</td>
						<td><span class="label label-warning"><?php  echo $message['city'];?><?php  echo $message['district'];?></span></td>
						<td><span class="label label-default"><?php  echo $message['nickname'];?></span></td>
						<td><?php  echo $message['fieldlist']['title'];?> <?php  if($message['isding'] == 1) { ?><span class="label label-info">置顶</span><?php  } ?></td>
						<td><?php  echo date("Y-m-d H:i:s",$message['createtime'])?></td>
						<td style="text-align:right;">
							<button type="button" data-toggle="modal" data-target="#formModal<?php  echo $message['id'];?>" class="btn btn-info btn-sm">置顶</button>
							<?php  if($message['status'] == 0) { ?>
							<a href="<?php  echo $this->createWebUrl('info', array('op' => 'shenhe', 'id' => $message['id']))?>" onclick="return confirm('确认要审核该条信息吗？');return false;" class="btn btn-default btn-sm">审核</a>
							<?php  } else { ?>
							<span class="label label-success">已审核</span>
							<?php  } ?>
							<a href="<?php  echo $this->createWebUrl('info', array('op' => 'post', 'id' => $message['id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="修改"><i class="fa fa-edit"></i></a>
							<a href="<?php  echo $this->createWebUrl('info', array('op' => 'delete', 'id' => $message['id']))?>"class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认删除？');return false;" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>
						</td>
					</tr>
					<?php  } } ?>
					<?php  if($list) { ?>
					<tr>
						<td></td>
						<td colspan="7">
							<button class="btn btn-success" onclick="selall()" type="button">全选</button>
							<button class="btn btn-default" onclick="cancelall()" type="button">取消</button>
							<button type="submit" name="allsh" value="allsh" class="btn btn-primary" onclick="return confirm('你真的要审核吗？') ? true : false;">批量审核</button>
							<button type="submit" name="alldel" value="alldel" class="btn btn-danger" onclick="return confirm('你真的要删除吗？') ? true : false;">批量删除</button>
						</td>
					</tr>
				<?php  } ?>
				</tbody>
			</table>
			<input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
			</form>
			<?php  echo $pager;?>
		</div>
	</div>
</div>
<?php  if(is_array($list)) { foreach($list as $message) { ?>
<div class="modal fade" id="formModal<?php  echo $message['id'];?>" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
				<h4 class="modal-title">置顶</h4>
			</div>
			<div class="modal-body">
				<form action="" method="post" class="form-horizontal form">
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否置顶</label>
						<div class="col-sm-9 col-xs-12">
							<label class='radio-inline'>
								<input type='radio' name='isding' value='1' <?php  if($message['isding']==1) { ?>checked<?php  } ?> /> 是
							</label>
							<label class='radio-inline'>
								<input type='radio' name='isding' value='0' <?php  if($message['isding']==0) { ?>checked<?php  } ?> /> 否
							</label>
						</div>
					</div>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label">置顶结束时间</label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_date('dingtime',date('Y-m-d H:i:s',$message['dingtime']),true);?>
						</div>
					</div>
					<div class="modal-footer form-submit">
						<input name="op" value="zhiding" type="hidden">
						<input name="id" value="<?php  echo $message['id'];?>" type="hidden">
						<input name="submit" class="btn btn-primary" value="提交" type="submit">
						<input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
<?php  } } ?>
<script>
	function selall(){
		$("input.checkbox").prop('checked',true);
	}
	function cancelall(){
		$("input.checkbox").prop('checked',false);
	}
	require(['bootstrap'],function($){
		$('.btn').hover(function(){
			$(this).tooltip('show');
		},function(){
			$(this).tooltip('hide');
		});
	});
</script>
<?php  } ?>
<?php  if($operation == 'post') { ?>
<div class="main">
	<form action="" method="post" class="form-horizontal form" enctype="multipart/form-data">
		<input type="hidden" name="id" value="<?php  echo $message['id'];?>" />
		<input type="hidden" name="op" value="dopost" />
		<div class="panel panel-default">
			<div class="panel-heading"><?php  if(empty($item['id'])) { ?>添加信息<?php  } else { ?>编辑信息<?php  } ?></div>
			<div class="panel-body">
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">选择模型</label>
					<div class="col-sm-9 col-xs-12">
						<select name="mid" class="form-control">
							<option value="0">--请选择模型--</option>
							<?php  if(is_array($modulelist)) { foreach($modulelist as $mrow) { ?>
								<?php  if($mrow['children']) { ?>
									<optgroup label="<?php  echo $mrow['name'];?>">
										<?php  if(is_array($mrow['children'])) { foreach($mrow['children'] as $mrowrow) { ?>
										<option value ="<?php  echo $mrowrow['id'];?>" <?php  if($mrowrow['id'] == $message['mid']) { ?>selected="selected"<?php  } ?>>┗ <?php  echo $mrowrow['name'];?></option>
										<?php  } } ?>
									</optgroup>
								<?php  } else { ?>
									<option value="<?php  echo $mrow['id'];?>" <?php  if($mrow['id'] == $message['mid']) { ?>selected="selected"<?php  } ?>><?php  echo $mrow['name'];?></option>
								<?php  } ?>
								
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">发布人</label>
					<div class="col-sm-9 col-xs-12">
						<select name="openid" class="form-control">
							<option value="">--请选择发布人--</option>
							<?php  if(is_array($memberlist)) { foreach($memberlist as $mrow) { ?>
								<option value="<?php  echo $mrow['openid'];?>" <?php  if($mrow['openid'] == $message['openid']) { ?>selected="selected"<?php  } ?>><?php  echo $mrow['nickname'];?></option>
							<?php  } } ?>
						</select>
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">浏览量</label>
					<div class="col-sm-2 col-xs-12">
						<div class="input-group">
							<input name="views" type="number" class="form-control" value="<?php  echo $message['views'];?>"  />

						</div>
					</div>
				</div>
				<div class="form-group" >
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">坐标</label>
					<div class="col-sm-9 col-xs-12">

						<div class="lt">
							经度 <input type="text" name="lng" id="map_x" value="<?php  echo $message['lng'];?>" class="scAddTextName w200">
							纬度 <input type="text" name="lat" id="map_y" value="<?php  echo $message['lat'];?>" class="scAddTextName w200">
						</div>
						<div class="btn-bdmap">
							<a style="margin-left: 10px;" onclick="getMapXY();"   class="seleSj">百度地图</a>
						</div>
						<!--百度地图开始-->
						<input type="text" class="form-control input-text" id="suggestId" style="display:none;" placeholder="可以输入指定位置搜索">

						<div id="searchResultPanel" ></div>

						<div id="allmap" ></div>

					</div>
				
				<div id="fieldhtml">
				<?php  if(is_array($fieldslist)) { foreach($fieldslist as $row) { ?>
					<?php  if($row['mtype'] == 'text' || $row['mtype'] == 'idcard') { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  if($row['isrequired'] == 1) { ?><span style="color:red;">*</span><?php  } ?><?php  echo $row['name'];?></label>
						<div class="col-sm-9 col-xs-12">
							<?php  if($row['danwei'] != '') { ?>
								<div class="input-group">
									<input name="<?php  echo $row['enname'];?>" type="text" class="form-control" value="<?php  echo $content[$row['enname']];?>" placeholder="请填写<?php  echo $row['name'];?>" />
									<span class="input-group-addon"><?php  echo $row['danwei'];?></span>
								</div>
							<?php  } else { ?>
								<input name="<?php  echo $row['enname'];?>" type="text" class="form-control" value="<?php  echo $content[$row['enname']];?>" placeholder="请填写<?php  echo $row['name'];?>" />
							<?php  } ?>
						</div>
					</div>
					<?php  } ?>
					<?php  if($row['mtype'] == 'number' || $row['mtype'] == 'telphone') { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  if($row['isrequired'] == 1) { ?><span style="color:red;">*</span><?php  } ?><?php  echo $row['name'];?></label>
						<div class="col-sm-9 col-xs-12">
							<?php  if($row['danwei'] != '') { ?>
								<div class="input-group">
									<input name="<?php  echo $row['enname'];?>" type="number" class="form-control" value="<?php  echo $content[$row['enname']];?>" placeholder="请填写<?php  echo $row['name'];?>" />
									<span class="input-group-addon"><?php  echo $row['danwei'];?></span>
								</div>
							<?php  } else { ?>
								<input name="<?php  echo $row['enname'];?>" type="number" class="form-control" value="<?php  echo $content[$row['enname']];?>" placeholder="请填写<?php  echo $row['name'];?>" />
							<?php  } ?>
						</div>
					</div>
					<?php  } ?>
					<?php  if($row['mtype'] == 'longtext') { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  if($row['isrequired'] == 1) { ?><span style="color:red;">*</span><?php  } ?><?php  echo $row['name'];?></label>
						<div class="col-sm-9 col-xs-12">
							<textarea name="<?php  echo $row['enname'];?>" class="form-control" placeholder="请填写<?php  echo $row['name'];?>"><?php  echo $content[$row['enname']];?></textarea>
						</div>
					</div>
					<?php  } ?>
					<?php  if($row['mtype'] == 'radio') { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  if($row['isrequired'] == 1) { ?><span style="color:red;">*</span><?php  } ?><?php  echo $row['name'];?></label>
						<div class="col-sm-9 col-xs-12">
							<?php  if(is_array($row['mtypeconarr'])) { foreach($row['mtypeconarr'] as $rowrow) { ?>
							<label class='radio-inline'>
								<input name="<?php  echo $row['enname'];?>" value="<?php  echo $rowrow;?>" <?php  if($content[$row['enname']] == $rowrow) { ?>checked="checked"<?php  } ?> type="radio" /> <?php  echo $rowrow;?>
							</label>
							<?php  } } ?>
						</div>
					</div>
					<?php  } ?>
					<?php  if($row['mtype'] == 'checkbox') { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  if($row['isrequired'] == 1) { ?><span style="color:red;">*</span><?php  } ?><?php  echo $row['name'];?></label>
						<div class="col-sm-9 col-xs-12">
							<?php  if(is_array($row['mtypeconarr'])) { foreach($row['mtypeconarr'] as $rowrow) { ?>
							<label class='checkbox-inline'>
								<input name="<?php  echo $row['enname'];?>[]" value="<?php  echo $rowrow;?>" <?php  if(in_array($rowrow,$content[$row['enname']])) { ?>checked="checked"<?php  } ?> type="checkbox" /> <?php  echo $rowrow;?>
							</label>
							<?php  } } ?>
						</div>
					</div>
					<?php  } ?>
					<?php  if($row['mtype'] == 'select') { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  if($row['isrequired'] == 1) { ?><span style="color:red;">*</span><?php  } ?><?php  echo $row['name'];?></label>
						<div class="col-sm-9 col-xs-12">
							<select name="<?php  echo $row['enname'];?>">
								<?php  if(is_array($row['mtypeconarr'])) { foreach($row['mtypeconarr'] as $rowrow) { ?>
								<option value="<?php  echo $rowrow;?>" <?php  if($content[$row['enname']] == $rowrow) { ?>selected="selected"<?php  } ?>><?php  echo $rowrow;?></option>
								<?php  } } ?>
							</select>
						</div>
					</div>
					<?php  } ?>
					<?php  if($row['mtype'] == 'date') { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  if($row['isrequired'] == 1) { ?><span style="color:red;">*</span><?php  } ?><?php  echo $row['name'];?></label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_date($row['enname'],date('Y-m-d',$content[$row['enname']]));?>
						</div>
					</div>
					<?php  } ?>
					<?php  if($row['mtype'] == 'datetime') { ?>
					<div class="form-group">
						<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  if($row['isrequired'] == 1) { ?><span style="color:red;">*</span><?php  } ?><?php  echo $row['name'];?></label>
						<div class="col-sm-9 col-xs-12">
							<?php  echo tpl_form_field_date($row['enname'],date('Y-m-d H:i',strtotime($content[$row['enname']])),true);?>
						</div>
					</div>
					<?php  } ?>
					<?php  if($row['mtype'] == 'images') { ?>
						<div class="form-group">
							<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  if($row['isrequired'] == 1) { ?><span style="color:red;">*</span><?php  } ?><?php  echo $row['name'];?></label>
							<div class="col-sm-9 col-xs-12">
								<?php  echo tpl_form_field_multi_image($row['enname'], $content[$row['enname']])?>
							</div>
						</div>
					<?php  } ?>
				<?php  } } ?>
				</div>
				
				<div class="form-group">
					<label class="col-xs-12 col-sm-3 col-md-2 control-label">是否审核</label>
					<div class="col-sm-9 col-xs-12">
						<label class='radio-inline'>
							<input type='radio' name='status' value='1' <?php  if($message['status']==1) { ?>checked<?php  } ?> /> 是
						</label>
						<label class='radio-inline'>
							<input type='radio' name='status' value='0' <?php  if($message['status']==0) { ?>checked<?php  } ?> /> 否
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group col-sm-12 form-submit">
			<input type="submit" name="submit" value="提交" class="btn btn-primary" />
			<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
		</div>
	</form>
</div>
<script type="text/javascript">
$(function(){
	$("[name='mid']").change(function(){
		$.ajax({   
			url:"<?php  echo $this->createWebUrl('info',array('op'=>'fieldhtml'))?>",   
			type:'post', 
			data:{
				id:$(this).val(),
			},
			dataType:'html',
			success:function(data){   
				$('#fieldhtml').html(data);
			}
		});
	});
	

	$(".cityselect").change(function(){
        var cityid=$('select[name="area[city]"]').val;
        var op='changearea2';
        var url=common.createWebUrl('ajax_req',op);

        $.ajax({
            type:'post',
            url:url,
            dataType: 'json',
            data:{'id':cityid,'op':op},
            success:function(data){
                if(data.status=='1'){
                    var content="";
                    $.each(data.list,function(k,v){
                        content+=("<option value='"+v.name+"'>"+v.name+"</option>");
                    })
                    $('select[name="area[district]"]').html(content);

                }else{
                    tip(data.str);
                    tip_close();
                }

            }
        });
	});
})
</script>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('mapjs', TEMPLATE_INCLUDEPATH)) : (include template('mapjs', TEMPLATE_INCLUDEPATH));?>
<?php  } ?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>