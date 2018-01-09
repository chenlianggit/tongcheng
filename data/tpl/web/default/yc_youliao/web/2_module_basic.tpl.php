<?php defined('IN_IA') or exit('Access Denied');?><div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><span style='color:red'>*</span>频道名称</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="name"  class="form-control" value="<?php  echo $item['name'];?>" />
	</div>
</div>

<input type="hidden" name="fid" value="<?php  echo $fid;?>" />


<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">
		频道图标</label>
	<div class="col-sm-9 col-xs-12">
		<?php  echo tpl_form_field_image('thumb', $item['thumb'], '', array('extras' => array('text' => 'readonly')))?>
		<span class="help-block" style="color:#900;">建议上传100*100px图片</span>
	</div>
</div>




<?php  if(empty($id)) { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">复制频道</label>
	<div class="col-sm-9 col-xs-12">
		<select name="fuzhi" class="form-control">
			<option value="">--系统自带频道--</option>
			<option value="neizhi1">房屋出租 </option>
			<option value="neizhi3">企业招聘 </option>
			<option value="neizhi5">个人求职 </option>
			<option value="neizhi2">同城交友 </option>
			<option value="neizhi4">二手物品 </option>
			<option value="neizhi6">拼车出行 </option>
			<option value="neizhi7">寻人寻物 </option>
			<option value="neizhi8">本地活动 </option>
			<option value="neizhi10">代办跑腿 </option>
			<option value="neizhi11">家有宠物 </option>
			<?php  if($modulelist) { ?>
			<option value="">--已建成频道--</option>
			<?php  if(is_array($modulelist)) { foreach($modulelist as $mrow) { ?>
				<?php  if($mrow['children']) { ?>
					<optgroup label="<?php  echo $mrow['name'];?>【已建成频道】">
						<?php  if(is_array($mrow['children'])) { foreach($mrow['children'] as $mrowrow) { ?>
						<option value ="<?php  echo $mrowrow['id'];?>">┗ <?php  echo $mrowrow['name'];?>【已建成频道】</option>
						<?php  } } ?>
					</optgroup>
				<?php  } else { ?>
					<option value="<?php  echo $mrow['id'];?>"><?php  echo $mrow['name'];?>【已建成频道】</option>
				<?php  } ?>
			<?php  } } ?>
			<?php  } ?>
		</select>
	</div>
</div>
<?php  } ?>

<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">自定义频道链接</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="autourl" class="form-control" value="<?php  echo $item['autourl'];?>" />
	</div>
</div>

<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">排序</label>
	<div class="col-sm-9 col-xs-12">
		<input type="text" name="displayorder" class="form-control" value="<?php  echo $item['displayorder'];?>" />
	</div>
</div>

<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label">置顶费用</label>
	<div class="col-sm-2 col-xs-12">
		<div class="input-group">
			<input class="form-control" name="zdprice" value="<?php  echo $item['zdprice'];?>" type="text">
			<span class="input-group-addon">元/天</span>
		</div>
		<span class="help-block" style="color:#900;">为0表示不开通置顶功能</span>
	</div>
</div>