<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/header', TEMPLATE_INCLUDEPATH)) : (include template('web/header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/left', TEMPLATE_INCLUDEPATH)) : (include template('web/left', TEMPLATE_INCLUDEPATH));?>

<section id="content">
	<section class="vbox">
		<section class="scrollable padder">
			<ul class="breadcrumb no-border no-radius b-b b-light pull-in">
				<li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
				<li class="active">圈子管理</li>
			</ul>
<ul class="nav nav-tabs">
	<li <?php  if($operation == 'display') { ?> class="active" <?php  } ?>><a href="<?php  echo $this->createWebUrl('ring',array('op' =>'display'))?>">圈子管理</a></li>
	<?php  if($operation == 'post') { ?>
	<li <?php  if($operation == 'post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('ring',array('op' =>'post'))?>">查看信息</a></li>
	<?php  } ?>
</ul>

<?php  if($operation == 'display') { ?>
<div class="main">
	<div class="panel panel-info">
		<div class="panel-heading" style="height: 35px;">
			<div class="pull-left" >筛选</div>
		<div class="pull-right setting-ico"  onClick="window.location='<?php  echo $_W['siteroot'];?>/web/index.php?c=profile&a=module&do=setting&m=yc_youliao&op=display#fabu'"><img src="<?php echo STYLE;?>images/b_setting.png"/>发布设置</div>
		</div>
		<div class="panel-body">
			<form action="./index.php" method="get" class="form-horizontal" role="form" id="form1">
				<input type="hidden" name="c" value="site" />
				<input type="hidden" name="a" value="entry" />
				<input type="hidden" name="m" value="yc_youliao" />
				<input type="hidden" name="do" value="ring" />

				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">关键词</label>
					<div class="col-sm-8 col-lg-9 col-xs-12">
						<input class="form-control" name="keyword" id="" type="text" value="<?php  echo $_GPC['keyword'];?>" placeholder="可查询关键词">
					</div>
				</div>
				<div class="form-group">
					<label class="col-xs-12 col-sm-2 col-md-2 col-lg-1 control-label">发布时间</label>
					<div class="col-sm-4 col-xs-12">
						<?php  echo tpl_form_field_daterange('time', array('starttime'=>date('Y-m-d', $starttime),'endtime'=>date('Y-m-d', $endtime)));?>
					</div>
					<div class="col-sm-7 col-xs-12 pull-right">
						<button class="btn btn-default"><i class="fa fa-search"></i> 搜索</button>
						<?php  if($total>0) { ?>
						<button type="button" class="btn btn-default">总记录数：<?php  echo $total;?></button>
						<?php  } ?>
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
						<th style="width:15%;">发布地理位置</th>
						<th style="width:15%;">发布人</th>
						<th style="width:40%;">标题</th>
						<th style="width:15%;">发布时间</th>
						<th style="width:10%;text-align:right;">操作</th>
					</tr>
				</thead>
				<tbody>
					<?php  if(is_array($list)) { foreach($list as $message) { ?>
					<tr>
						<td><input class="checkbox" name="akid[<?php  echo $message['id'];?>]" value="1" type="checkbox"></td>


						<td><span class="label label-warning"><?php  echo $message['province'];?><?php  echo $message['city'];?><?php  echo $message['district'];?></span></td>
						<td><span class="label label-default"><?php  echo $message['nickname'];?></span></td>
						<td><?php  echo $message['info'];?></td>

						<td><?php  echo date("Y-m-d H:i:s",$message['addtime'])?></td>
						<td style="text-align:right;">


							<a href="<?php  echo $this->createWebUrl('ring', array('op' => 'post', 'id' => $message['ring_id']))?>" class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="top" title="" data-original-title="查看"><i class="fa fa-edit"></i></a>
							<a href="<?php  echo $this->createWebUrl('ring', array('op' => 'delete', 'id' => $message['ring_id']))?>"class="btn btn-default btn-sm" onclick="return confirm('此操作不可恢复，确认删除？');return false;" data-toggle="tooltip" data-placement="top" title="删除"><i class="fa fa-times"></i></a>
						</td>
					</tr>
					<?php  } } ?>
					<?php  if($list) { ?>
					<tr>
						<td></td>
						<td colspan="7">
							<button class="btn btn-success" onclick="selall()" type="button">全选</button>
							<button class="btn btn-default" onclick="cancelall()" type="button">取消</button>
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
	<article id="comment-id-3" class="comment-item"> <a href="<?php  echo $this->createWebUrl('ring',array('op'=>'post','id'=>$item['id']))?>" class="pull-left thumb-sm avatar ring-avatar"><img src="<?php  echo $item['avatar'];?>" class="img-circle"></a> <span class="arrow left"></span>
		<div class="comment-body panel panel-default">
			<header class="panel-heading  ring-nickname"> <a href="#"><?php  echo $item['nickname'];?></a>
				<span class="text-muted m-l-sm pull-right"> <i class="fa fa-clock-o"></i> <?php  echo date('Y-m-d H:i', $item['addtime'])?></span> </header>
			<div class="panel-body grademsg">
				<div class="homeworktitle"> <?php  echo $item['info'];?></div>

				<?php  if($item['xsthumb']) { ?>
				<?php  $num=count($item['xsthumb'])?>
				<div class="ming">
					<?php  if(is_array($item['xsthumb'])) { foreach($item['xsthumb'] as $i) { ?>
					<img class="pic mainImg" <?php  if($num==1) { ?>style=width:200px;height:auto;<?php  } else if($num>1) { ?>style=width:100px;height:100px;<?php  } ?> src="<?php  echo $i;?>" alt=""/>
					<?php  } } ?>
				</div>
				<?php  } ?>
				<a href="<?php  echo $this->createWebUrl('ring',array('op'=>'delete','id'=>$item['ring_id']))?>"  class="comment-operate">删除 </a>
				<div class="comment-action m-t-sm textright"> <a href="#comment-id-3" data-dismiss="alert" class="btn btn-default btn-xs"> <?php  echo $item['znum'];?>人赞 <span class="ml-15"><?php  echo $item['pnum'];?>人评论</span>  </a> </div>
			</div>
			<div class="<?php  if($item['z']['0']) { ?>zan-total<?php  } ?> zan-avatar" >
			<?php  if(is_array($item['z']['0'])) { foreach($item['z']['0'] as $i) { ?>
			<img src="<?php  echo $i['avatar'];?>"/>
			<?php  } } ?>
			</div>
			<div class="comment-clearfix"></div>
			<div class="ring-comment_flag <?php  if($item['p']['0']) { ?>  ring-comment-list<?php  } ?>">
			<?php  if(is_array($item['p']['0'])) { foreach($item['p']['0'] as $i) { ?>
			<div class="ring-comment-box" user="self">
				<img class="myhead" src="<?php  echo $i['avatar'];?>" alt=""/>
				<div class="ring-comment-content">
					<p class="comment-text"><span class="user"><?php  echo $i['nickname'];?></span></p>
					<span class="pingtext"><?php  echo $i['info'];?></span>
					<p class="comment-time">
						<?php  echo date('m-d H:i', $i['addtime'])?>
						<a href="<?php  echo $this->createWebUrl('ring',array('op'=>'deleteP','zid'=>$i['zan_id'],'id'=>$item['ring_id']))?>"  class="comment-operate">删除 </a>
					</p>
				</div>
			</div>
			<?php  } } ?>
			</div>
		</div>
	</article>
</div>
<?php  } ?>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>