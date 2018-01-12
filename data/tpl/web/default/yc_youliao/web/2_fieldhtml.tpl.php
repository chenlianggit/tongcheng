<?php defined('IN_IA') or exit('Access Denied');?><?php  if(is_array($fieldslist)) { foreach($fieldslist as $row) { ?>
<?php  if($row['mtype'] == 'text' || $row['mtype'] == 'idcard') { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $row['name'];?><?php  if($row['danwei']) { ?>(单位：<?php  echo $row['danwei'];?>)<?php  } ?></label>
	<div class="col-sm-9 col-xs-12">
		<input name="<?php  echo $row['enname'];?>" type="text" class="form-control" value="<?php  echo $content[$row['enname']];?>" placeholder="请填写<?php  echo $row['name'];?>" />
	</div>
</div>
<?php  } ?>
<?php  if($row['mtype'] == 'number' || $row['mtype'] == 'telphone' || $row['mtype'] == 'numprice' || $row['mtype'] == 'numstock' || $row['mtype'] == 'numbuy' || $row['mtype'] == 'numexpress') { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $row['name'];?><?php  if($row['danwei']) { ?>(单位：<?php  echo $row['danwei'];?>)<?php  } ?></label>
	<div class="col-sm-9 col-xs-12">
		<input name="<?php  echo $row['enname'];?>" type="number" class="form-control" value="<?php  echo $content[$row['enname']];?>" placeholder="请填写<?php  echo $row['name'];?>" />
	</div>
</div>
<?php  } ?>
<?php  if($row['mtype'] == 'longtext') { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $row['name'];?><?php  if($row['danwei']) { ?>(单位：<?php  echo $row['danwei'];?>)<?php  } ?></label>
	<div class="col-sm-9 col-xs-12">
		<textarea name="<?php  echo $row['enname'];?>" class="form-control" placeholder="请填写<?php  echo $row['name'];?>"><?php  echo $content[$row['enname']];?></textarea>
	</div>
</div>
<?php  } ?>
<?php  if($row['mtype'] == 'radio') { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $row['name'];?><?php  if($row['danwei']) { ?>(单位：<?php  echo $row['danwei'];?>)<?php  } ?></label>
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
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $row['name'];?><?php  if($row['danwei']) { ?>(单位：<?php  echo $row['danwei'];?>)<?php  } ?></label>
	<div class="col-sm-9 col-xs-12">
		<?php  if(is_array($row['mtypeconarr'])) { foreach($row['mtypeconarr'] as $rowrow) { ?>
		<label class='checkbox-inline'>
			<!--<input  type="checkbox"  name="<?php  echo $row['enname'];?>[]" value="<?php  echo $rowrow;?>" <?php  if(in_array($rowrow,$content[$row['enname']])) { ?>checked="checked"<?php  } ?>/> <?php  echo $rowrow;?>-->
			<input  type="checkbox"  name="<?php  echo $row['enname'];?>[]" value="<?php  echo $rowrow;?>" /> <?php  echo $rowrow;?>

		</label>
		<?php  } } ?>
	</div>
</div>
<?php  } ?>
<?php  if($row['mtype'] == 'select') { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $row['name'];?><?php  if($row['danwei']) { ?>(单位：<?php  echo $row['danwei'];?>)<?php  } ?></label>
	<div class="col-sm-9 col-xs-12">
		<select name="<?php  echo $row['enname'];?>">
			<?php  if(is_array($row['mtypeconarr'])) { foreach($row['mtypeconarr'] as $rowrow) { ?>
			<option value="<?php  echo $rowrow;?>" <?php  if($content[$row['enname']] == $rowrow) { ?>selected="selected"<?php  } ?>><?php  echo $rowrow;?></option>
			<?php  } } ?>
		</select>
	</div>
</div>
<?php  } ?>
<?php  if($row['mtype'] == 'date' || $row['mtype'] == 'goodsdatetime' || $row['mtype'] == 'goodssdatetime') { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $row['name'];?><?php  if($row['danwei']) { ?>(单位：<?php  echo $row['danwei'];?>)<?php  } ?></label>
	<div class="col-sm-9 col-xs-12">
		<?php  echo tpl_form_field_date($row['enname'],date('Y-m-d',$content[$row['enname']]));?>
	</div>
</div>
<?php  } ?>
<?php  if($row['mtype'] == 'datetime') { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $row['name'];?><?php  if($row['danwei']) { ?>(单位：<?php  echo $row['danwei'];?>)<?php  } ?></label>
	<div class="col-sm-9 col-xs-12">
		<?php  echo tpl_form_field_date($row['enname'],date('Y-m-d H:i',strtotime($content[$row['enname']])),true);?>
	</div>
</div>
<?php  } ?>
<?php  if($row['mtype'] == 'images' || $row['mtype'] == 'goodsthumbs' || $row['mtype'] == 'goodsbaoliao') { ?>
<div class="form-group">
	<label class="col-xs-12 col-sm-3 col-md-2 control-label"><?php  echo $row['name'];?><?php  if($row['danwei']) { ?>(单位：<?php  echo $row['danwei'];?>)<?php  } ?></label>
	<div class="col-sm-9 col-xs-12">
		<?php  echo tpl_form_field_multi_image($row['enname'], $content[$row['enname']])?>
	</div>
</div>
<?php  } ?>
<?php  } } ?>