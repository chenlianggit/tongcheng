<?php defined('IN_IA') or exit('Access Denied');?><table class="table table-hover">
	<thead class="navbar-inner">
	<tr>

		<th class="col-sm-1">
			<label class="my_checkbox">
				<input class="" type="checkbox" name="" onclick="var ck = this.checked;$('.goodid_check input').each(function(){this.checked = ck});"> 全选
			</label>
		</th>
		<th class="col-sm-1 order-by-input">排序</th>

		<th class="col-sm-4">标题/图片</th>
		<th class="col-sm-1">价格</th>
		<th class="col-sm-1">销量</th>
		<th class="col-sm-2">参与活动</th><th class="col-sm-1">其他</th>
		<th class="col-sm-2">操作</th>

	</tr>
	</thead>
  <tbody>
<?php  if(is_array($list)) { foreach($list as $li) { ?>
<tr>

  <td>
	  <label class="my_checkbox goodid_check">
		  <input type="checkbox" name="checkid[]" value="<?php  echo $li['id'];?>" class=""> <?php  echo $li['id'];?>
	  </label>
  </td>
  <td class="opclass order-by-input">
<span class="input_box input_box_100" style="width: 94px;">
<input type="text"  placeholder="排序号" class="input_input" name="sort[<?php  echo $li['id'];?>]" value="<?php  echo $li['sort'];?>">
</span>
  </td>

  <td>
	  <li><a title=" <?php  echo $li['title'];?>" href="<?php  echo $this->createWebUrl('shop_goods', array('id' => $li['id'], 'op' => 'post'))?>">
		  <?php  echo $li['title'];?></a></li>
	  <li class="good_list_img">
		  <a href="<?php  echo $this->createWebUrl('shop_goods', array('id' => $li['id'], 'op' => 'post'))?>">
			  <img src="<?php  echo tomedia($li['thumb'])?>" onerror="javascript:this.src='<?php echo SQ;?>public/images/noimg.png'" >
		  </a>

	  </li>
  </td>
  <td class="font_13px_999">
	  <li>销售价：<span class="font_ff5f27"><?php  echo $li['marketprice'];?></span></li>
	  <?php  if($li['is_group']==1) { ?>
	  <li>团购价：<span class="font_ff5f27"><?php  echo $li['groupprice'];?></span></li>
	  <?php  } ?>
  </td>
  <td class="font_13px_999">
	  <li>销量：<span class="font_ff5f27"><?php  echo $li['sales'];?></span></li>
	  <?php  if($li['is_group']==1) { ?>
	  <li>满团数：<span class="font_ff5f27"><?php  echo $li['groupnum'];?></span></li>
	  <?php  } ?>
  </td>

  <td class="font_13px_999">
	  <?php  if($li['is_hot'] == 1) { ?><li>首页推荐</li><?php  } ?>
	  <?php  if($li['is_time'] == 1) { ?><li>限时秒杀</li><?php  } ?>
	  <?php  if($li['is_group'] == 1) { ?><li>拼团</li><?php  } ?>
	  <?php  if($shop['is_time'] ==0) { ?>
	  <li>未开通专场秒杀功能<a class=" wl2 label label-info" href="<?php  echo $this->createWebUrl('shop_fun')?>">马上申请</a>  </li>
	  <?php  } ?>
	  <?php  if($shop['is_hot'] ==0) { ?>
	  <li>未开通首页推荐功能<a class=" wl2 label label-info" href="<?php  echo $this->createWebUrl('shop_fun')?>">马上申请</a>  </li>
	  <?php  } ?>
	  <?php  if($shop['is_group'] ==0) { ?>
	  <li>未开通团购功能<a class=" wl2 label label-info" href="<?php  echo $this->createWebUrl('shop_fun')?>">马上申请</a>  </li>
	  <?php  } ?>
  </td>
  <td>
	  <?php  if($li['astrict']>0) { ?><li>限购<?php  echo $li['astrict'];?>件</li><?php  } ?>
	  <?php  if($li['status'] == 1) { ?>
		  <?php  if($li['total'] <= 0) { ?>
		  <li><span class="font_ff5f27">已售罄</span></li>
		  <?php  } else { ?>
		  <li><span>上架中</span></li>
		  <?php  } ?>
	  <?php  } else if($li['status'] == 1) { ?>
	  <li><span class="font_ff5f27">已下架</span></li>
	  <?php  } ?>
	  <a   style="cursor:pointer" class="copyurl label label-primary"
		   data-url="<?php  echo $_W['siteroot'];?>app/index.php?c=entry&id=<?php  echo $item['id'];?>&m=yc_youliao&do=detail&i=<?php  echo $_W['uniacid'];?>"
		   href="javascript:;" onclick="copyit();">复制链接</a>
  </td>

  <td class="opclass">
	  <div class="input-group select_btn deal_btn">
		  <div class="btn-group">
			  <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  操作
				  <span class="caret"></span>
			  </button>
			  <ul class="dropdown-menu">
				  <li><a href="<?php  echo $this->createWebUrl('shop_goods', array('id' => $li['goods_id'], 'op' => 'post'))?>">编辑</a></li>

				  <!--<li><a  href="<?php  echo $this->createWebUrl('virtual_comments',array('op'=>'post','gid'=>$li['id']))?>">评价</a></li>-->

				  <li><a href="<?php  echo $this->createWebUrl('shop_goods', array('id' => $li['goods_id'], 'op' => 'delete'))?>" onclick="return confirm('删除后不可恢复，确定要删除吗？');">删除</a></li>
			  </ul>
		  </div>
	  </div>
  </td>


</tr>
<?php  } } ?>
  </tbody>
</table>

