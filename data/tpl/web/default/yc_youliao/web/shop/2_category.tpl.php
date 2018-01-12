<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_header', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_left', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_left', TEMPLATE_INCLUDEPATH));?>

    <section id="content">
        <section class="vbox">
          <section class="scrollable padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
              <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
              <li class="active">分类设置</li>
               <li class="active">分类列表</li>
            </ul>  
<ul class="nav nav-tabs">
    <li <?php  if($op =='display') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_goods_cate', array('op' => 'display'))?>">管理分类</a></li>
  <li <?php  if($op =='post') { ?>class="active"<?php  } ?>><a href="<?php  echo $this->createWebUrl('shop_goods_cate', array('op' => 'post'))?>">添加分类</a></li>
</ul>
<?php  if($op == 'post') { ?>

<div class="main">
    <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/categrory_detail', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/categrory_detail', TEMPLATE_INCLUDEPATH));?>
</div>
<?php  } else if($op == 'display') { ?>
<div class="main">
	<div class="category">
		<form action="" method="post" onsubmit="return formcheck(this)">
            <div class="panel panel-info" style="border-color:#dddddd">
                <div class="panel-body  table-responsive" style="padding:15px;background:#fff;">
		<table class="table table-hover">
			<thead>
				<tr>
                    <th style="width:5%;"></th>

					<th style="width:8%;">显示顺序</th>
					<th style="width:67%;">分类名称</th>
					<th style="width:20%;">操作</th>
				</tr>
			</thead>
			<tbody>
			<?php  if(is_array($category)) { foreach($category as $row) { ?>
				<tr>
					<td><?php  if(count($children[$row['id']]) > 0) { ?><a href="javascript:;"><i class="icon-chevron-down"></i></a><?php  } ?></td>
					<td><input type="text" style="border:none;outline:none;"  name="displayorder[<?php  echo $row['id'];?>]" value="<?php  echo $row['displayorder'];?>"></td>
                                        <td><img src="<?php  echo $_W['attachurl'];?><?php  echo $row['thumb'];?>" width='50' height="50" onerror="$(this).remove()" style='padding:1px;border: 1px solid #ccc;float:left;' />
                                            <div class="type-parent"><?php  echo $row['name'];?>&nbsp;&nbsp;
                                             </div>
                                        </td>
					<td>

                         &nbsp;&nbsp;
                      <a href="<?php  echo $this->createWebUrl('shop_goods_cate', array('op' => 'post', 'id' => $row['id']))?>"><i class="fa fa-edit"></i>编辑</a>
                    &nbsp;&nbsp;
                    <a href="<?php  echo $this->createWebUrl('shop_goods_cate', array('op' => 'delete', 'id' => $row['id']))?>"
                         onclick="return confirm('确认删除此分类吗？');return false;"><i class="fa fa-exclamation-triangle"></i>删除</a>
                         
                         </td>
				</tr>

			<?php  } } ?>

				<tr>
					<td></td>
					<td colspan="3" >
						<input name="submit" type="submit" class="btn btn-primary" value="提交">
						<input type="hidden" name="token" value="<?php  echo $_W['token'];?>" />
					</td>
				</tr>
			</tbody>
		</table>
                    </div>
                </div>
		</form>
	</div>
</div>
<?php  } ?>

</section>
</section>
</section>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>
