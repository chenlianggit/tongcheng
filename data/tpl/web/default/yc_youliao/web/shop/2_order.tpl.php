<?php defined('IN_IA') or exit('Access Denied');?><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_header', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_header', TEMPLATE_INCLUDEPATH));?>
<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/shop_left', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/shop_left', TEMPLATE_INCLUDEPATH));?>
   <section id="content">
        <section class="vbox">
          <section class="scrollable padder">
            <ul class="breadcrumb no-border no-radius b-b b-light pull-in">
              <li><a href="<?php  echo $this->createWebUrl("index")?>"><i class="fa fa-home"></i>首页</a></li>
              <li class="active">订单管理</li>
            </ul>

<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/order_banner', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/order_banner', TEMPLATE_INCLUDEPATH));?>
			  <div class="main">
<?php  if($op == 'display') { ?>

				  <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/search_input', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/search_input', TEMPLATE_INCLUDEPATH));?>

				  <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/order_item', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/order_item', TEMPLATE_INCLUDEPATH));?>

				  <?php  } else if($op == 'detail') { ?>

 <div class="order-detail">
	<div class="col-sm-6">
			<section class="panel panel-default">
				<header class="panel-heading"> <strong>订单详情</strong> </header>
				<div class="panel-body">
					<div class="form-group">
						<label class="col-sm-3 control-label">订单编号</label>
						<div class="col-sm-9">
							<?php  echo $item['ordersn'];?>
						</div>
					</div>
					<div class="line line-dashed line-lg pull-in"></div>
					<div class="form-group">
						<label class="col-sm-3 control-label">支付金额</label>
						<div class="col-sm-9">
							<?php  echo $item['price'];?> 元
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">下单时间</label>
						<div class="col-sm-9">
							<?php  echo date('Y-m-d H:i:s', $item['createtime'])?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">支付方式</label>
						<div class="col-sm-9">
							<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/order_paytype', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/order_paytype', TEMPLATE_INCLUDEPATH));?>
						</div>
					</div>
					<div class="line line-dashed line-lg pull-in"></div>
					<div class="form-group">
						<label class="col-sm-3 control-label">订单类型</label>
						<div class="col-sm-9">
							<?php  if($item['ordertype'] == 1) { ?><span>普通订单</span>
							<?php  } else if($item['ordertype'] ==2) { ?><span class="label label-info">参团订单</span>
							<?php  } else if($item['ordertype'] == 3) { ?><span class="label label-success">建团订单</span>
							<?php  } ?>
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-3 control-label">订单状态</label>
						<div class="col-sm-9">
							<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/status', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/status', TEMPLATE_INCLUDEPATH));?>
						</div>
					</div>
					<div class="line line-dashed line-lg pull-in"></div>
					<div class="form-group">
						<label class="col-sm-3 control-label">订单留言</label>
						<div class="col-sm-9">
							<?php  echo $item['remark'];?>
						</div>
					</div>

					<div class="line line-dashed line-lg pull-in"></div>
					<?php  if($item['user']) { ?>
					<div class="form-group">
						<label class="col-sm-3 control-label">联系人</label>
						<div class="col-sm-9">
							<?php  echo $item['user']['realname'];?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">联系电话</label>
						<div class="col-sm-9">
							<?php  echo $item['user']['mobile'];?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">联系地址</label>
						<div class="col-sm-9">
							<?php  echo $item['user']['province'];?><?php  echo $item['user']['city'];?><?php  echo $item['user']['area'];?><?php  echo $item['user']['address'];?>
						</div>
					</div>
					<?php  } else { ?>
					<?php  $userData= Member::getUserByid($item['userid'])?>
					<div class="form-group">
						<label class="col-sm-3 control-label">用户名</label>
						<div class="col-sm-9">
							<?php  echo $userData['nickname'];?>
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">联系电话</label>
						<div class="col-sm-9">
							<?php  echo $userData['telphone'];?>
						</div>
					</div>

					<?php  } ?>
				</div>
			</section>
	</div>




	 <div class="col-sm-6">
		 <section class="panel panel-default">
			 <header class="panel-heading"> <strong>商品详情</strong> </header>
			 <div class="panel-body">

				 <?php  if(is_array($goodData)) { foreach($goodData as $goods) { ?>

				 <div class="form-group">
					 <label class="col-sm-3 control-label">商品标题</label>
					 <div class="col-sm-9">
						 <a target="_blank" href="<?php  echo $this->createWebUrl('shop_goods', array('id' => $goods['goods_id'], 'op' => 'post'))?>"><?php  if($goods['thumb']) { ?><img class="goodsimg" src="<?php  echo $_W['attachurl'];?><?php  echo $goods['thumb'];?>" ><?php  } ?><?php  echo $goods['title'];?></a>
					 </div>
				 </div>
				<?php  if($goods['optionname']) { ?>
				 <div class="form-group">
					 <label class="col-sm-3 control-label">商品规格</label>
					 <div class="col-sm-9">
						 <?php  echo $goods['optionname'];?>
					 </div>
				 </div>
				<?php  } ?>
				 <div class="form-group">
					 <label class="col-sm-3 control-label">成交价</label>
					 <div class="col-sm-9">
						 <?php  echo $goods['orderprice'];?>
					 </div>
				 </div>

				 <div class="form-group">
					 <label class="col-sm-3 control-label">购买数量</label>
					 <div class="col-sm-9">
						 <?php  echo $goods['total'];?>
					 </div>
				 </div>
				 <?php  if($goods['order_status'] >= 2) { ?>
				 <?php  $g=$goods?>
				 <div class="form-group">

					 <label class="col-sm-3 control-label">退款状态</label>
					 <div class="col-sm-9">
						 <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/order_status', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/order_status', TEMPLATE_INCLUDEPATH));?>
						 <a href="<?php  echo $this->createWebUrl('shop_refund', array('ogid' => $goods['ogid']))?>"
							class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="操作"><i class="fa fa-pencil"></i> </a>
					 </div>



				 </div>

				 <?php  } ?>
			<?php  } } ?>
			 </div>

		 </section>

	 </div>

	 <div class="col-sm-6">
 <div class="panel panel-default">
        <div class="panel-heading">
           管理员备注
        </div>
        <div class="panel-body table-responsive">
			 <form action="./index.php"  class="form-horizontal" role="form" onSubmit="return check_adminRemark(this)" method="post">
                <input type="hidden" name="c" value="site" />
                <input type="hidden" name="a" value="entry" />
                <input type="hidden" name="m" value="yc_youliao" />
                <input type="hidden" name="do" value="shop_order" />
                <input type="hidden" name="op" value="admin_remark" />
				<input type="hidden" name="id" value="<?php  echo $item['id'];?>" />
				 <input name="token" value="<?php  echo $_W['token'];?>" type="hidden">
		<textarea style="height:150px;" class="span7" id="admin_remark" name="admin_remark" cols="70"
		 placeholder="订单备注信息（仅管理员可见）" value=""  ><?php  echo $item['admin_remark'];?></textarea>

			<button type="submit" style="float:right" class="btn btn-success span2" >确认提交</button>
			 </form>
            </div>
        </div>
	 </div>

<?php  } ?>
 </div>
 </div>
</div>
</div>
 <?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/footer', TEMPLATE_INCLUDEPATH)) : (include template('web/footer', TEMPLATE_INCLUDEPATH));?>