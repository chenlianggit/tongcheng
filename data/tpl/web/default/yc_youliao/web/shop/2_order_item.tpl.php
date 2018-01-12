<?php defined('IN_IA') or exit('Access Denied');?><div style="padding:15px;" class=" main-823 panel-body table-responsive">
		<table class="table table-hover">
			<thead class="navbar-inner">
				<tr>
					<th style="width:120px;">订单编号</th>
					<th style="width:100px;">用户名</th>
					<th style="width:80px;">联系电话</th>
					<th style="width:80px;">支付方式</th>
					<th style="width:50px;">总价</th>
					<th style="width:150px;">状态</th>
					<th style="width:150px;">下单时间</th>
					<th style="width:100px;">订单类型</th>
					<th style="width:120px;">操作</th>
				</tr>
			</thead>
			<tbody>
				<?php  if(is_array($list)) { foreach($list as $item) { ?>
				<tr>
					<td><?php  echo $item['ordersn'];?></td>
					<?php  if($address[$item['addressid']]) { ?>
					<td><?php  echo $address[$item['addressid']]['realname'];?></td>
                    <td><?php  echo $address[$item['addressid']]['mobile'];?></td>
					<?php  } else { ?>
					<?php  $userData= Member::getUserByid($item['userid'])?>
                    <td><?php  echo $userData['nickname'];?></td>
                    <td><?php  echo $userData['telphone'];?></td>
					<?php  } ?>

					<td><?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/order_paytype', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/order_paytype', TEMPLATE_INCLUDEPATH));?></td>

					<td><?php  echo $item['price'];?> 元</td>
<!--				<td><?php  if($item['goodstype']) { ?>实物<?php  } else { ?>虚拟<?php  } ?></td>-->
					<td>
					<?php (!empty($this) && $this instanceof WeModuleSite || 1) ? (include $this->template('web/shop/status', TEMPLATE_INCLUDEPATH)) : (include template('web/shop/status', TEMPLATE_INCLUDEPATH));?>
					</td>
					<td><?php  echo date('Y-m-d H:i:s', $item['createtime'])?></td>
					<?php  if(!empty($shareid)) { ?>
							<td><?php  if($item['status'] == 3) { ?><?php  echo $item['commission'];?>元<?php  } else { ?><?php  echo $item['commission'];?>元<?php  } ?></td><?php  if($cfg['globalCommissionLevel']>=2) { ?>
							<td><?php  if($item['status'] == 3) { ?><?php  echo $item['commission2'];?>元<?php  } else { ?><?php  echo $item['commission2'];?>元<?php  } ?></td><?php  } ?>	<?php  if($cfg['globalCommissionLevel']>=3) { ?>
							<td><?php  if($item['status'] == 3) { ?><?php  echo $item['commission3'];?>元<?php  } else { ?><?php  echo $item['commission3'];?>元<?php  } ?></td><?php  } ?>
                    <?php  } ?>

					<td>
                      	<?php  if($item['ordertype'] == 1) { ?><span>普通订单</span><?php  } ?>
						<?php  if($item['ordertype'] ==2) { ?><span class="label label-info">参团订单</span><?php  } ?>
						 <?php  if($item['ordertype'] == 3) { ?><span class="label label-success">建团订单</span><?php  } ?>
                    </td>


					<td>
                        <a  href="<?php  echo $this->createWebUrl('shop_order', array('op' => 'detail', 'id' => $item['id']))?>"
							class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="查看详情"><i class="fa fa-pencil"></i>
							</a>
							 <?php  if($item['status']==0) { ?>
                        <a href="<?php  echo $this->createWebUrl('shop_order', array('id' => $item['id'], 'op' => 'delete'))?>" onclick="return confirm('此操作不可恢复，确认删除？');"
                           class="btn btn-default btn-sm" data-toggle="tooltip" data-placement="bottom" title="删除"><i class="fa fa-times"></i>
                        </a>
                        <?php  } ?>
                    </td>


				</tr>
				<?php  } } ?>
			</tbody>

		</table>
		<?php  echo $pager;?>
	</div>