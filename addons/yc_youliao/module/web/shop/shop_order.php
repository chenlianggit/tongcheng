<?php
global $_GPC,$_W;
$title="订单管理";
$cfg    = $this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$status    = !isset($_GPC['status']) ? 1 : $_GPC['status'];
$pindex    = $this->getWebPage();
$psize     = $this->getWebNum();
$today = $_GPC['today'];
$condition = '';
$shop_id=getShop_id();
$search_type=2;
$param_ordersn = $_GPC['ordersn'];
		if ($op == 'display') {
            $condition .= " AND o.shop_id =".$shop_id;
		    if (!empty($_GPC['ordersn'])) {
		        $condition .= " AND o.ordersn LIKE '%{$_GPC['ordersn']}%'";
		    }
			if (!empty($_GPC['realname'])) {
		        $condition .= " AND a.realname LIKE '%{$_GPC['realname']}%'";
		    }
			if (!empty($_GPC['mobile'])) {
		        $condition .= " AND a.mobile LIKE '%{$_GPC['mobile']}%'";
		    }
		    if (!empty($_GPC['time'])) {
		        $condition .= " and o.createtime >=" . strtotime($_GPC['time']['start']) . " and o.createtime <=" . strtotime($_GPC['time']['end']) . " ";
		        $starttime = strtotime($_GPC['time']['start']);
		        $endtime   = strtotime($_GPC['time']['end']);
		    } else {
		        $starttime = 0;
		        $endtime   = time()+3600*24;
		    }
			 if ($status != '-1') {
		        if($today=="1"){
		            $condition .= " and DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')";
		        }else {
		            $condition .= " AND status = '" . intval($status) . "'";
		        }
		    }
			
		    if (!empty($_GPC['orderstatisticsEXP01'])) {
		        $report    = "orderstatistics";
		        $condition = '';
                $condition .= " AND o.shop_id =".$shop_id;
		        if (!empty($_GPC['ordersn'])) {
		            $condition .= " AND o.ordersn LIKE '%{$_GPC['ordersn']}%'";
		        }
				
				if (!empty($_GPC['realname'])) {
					$condition .= " AND a.realname LIKE '%{$_GPC['realname']}%'";
				}
				if (!empty($_GPC['mobile'])) {
					$condition .= " AND a.mobile LIKE '%{$_GPC['mobile']}%'";
				}

		       
				if ($status != '-1') {
					$condition .= " and o.status >0 ";
		       if($today=="1"){
		            $condition .= " and DATE_FORMAT(FROM_UNIXTIME(o.createtime),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d')";
		        }else {
		            $condition .= " AND o.status = '" . intval($status) . "'";
		        }
		    }
			
		        if (!empty($_GPC['orderstatisticsEXP01'])) {
		            $psize  = 9999;
		            $pindex = 1;
		        }

                $sql  = " from " . tablename(ADDRESS) . " a 
				right join ". tablename(ORDER) . " o on o.addressid=a.id and o.uniacid=a.uniacid 
				left join ". tablename(USER) . " u on u.id=o.userid and o.uniacid=u.uniacid 				
				WHERE o.uniacid = '{$_W['uniacid']}' {$condition} ";

				$list  = pdo_fetchall("select a.*,o.* ,u.nickname as realnamestr ".$sql." ORDER BY o.status desc, o.createtime DESC LIMIT " . $pindex . ',' . $psize);

				foreach ($list as $id => $displayorder) {
		            $list[$id]['ordergoods'] = pdo_fetchall("SELECT goods.thumb,ordersgoods.price,ordersgoods.total,goods.title,ordersgoods.optionname from " . tablename(ORDER_GOODS) . " ordersgoods left join " . tablename(GOODS) . " goods on goods.id=ordersgoods.goodsid  where ordersgoods.uniacid = :uniacid and ordersgoods.orderid=:oid order by ordersgoods.createtime  desc ", array(':uniacid' => $_W['uniacid'], ':oid' => $list[$id]['id']));
		        }
		        require 'report.php';
		        exit;
		    }

		    $sql2="from " . tablename(ADDRESS) . " a right join ".
                tablename(ORDER) . " o on o.addressid=a.id WHERE o.uniacid = '{$_W['uniacid']}'
			$condition";
			$list  = pdo_fetchall("select a.*,o.*  " .$sql2." ORDER BY status ASC, createtime DESC LIMIT " . $pindex. ',' . $psize);
		    $total = pdo_fetchcolumn('SELECT COUNT(*)  ' . $sql2);
            $pager = pagination($total, $pindex, $psize);

		    if (!empty($addressids)) {
		        $address = pdo_fetchall("SELECT * FROM " . tablename(ADDRESS) . " WHERE id IN ('" . implode("','", $addressids) . "')", array(), 'id');
		    }
		} elseif ($op == 'detail') {
            $members = pdo_fetchall("select id, realname from " . tablename(MEMBER) . " where uniacid = " . $_W['uniacid'] . " and status = 1");
            $member = array();
            foreach ($members as $m) {
                $member[$m['id']] = $m['realname'];
            }
            $id = intval($_GPC['id']);
            $item = pdo_fetch("SELECT * FROM " . tablename(ORDER) . " WHERE id = :id and uniacid = :uniacid and shop_id = :shop_id", array(':id' => $id, 'uniacid' => $_W['uniacid'],'shop_id'=>$shop_id));
            if (empty($item)) {
                $this->message("抱歉，订单不存在!", referer(), "error");
            }
            if($item['addressid']){
                $item['user']  = Util::getSingelDataInSingleTable(ADDRESS,array('id'=>$item['addressid']));
            }

            $goodData  = pdo_fetchall("SELECT g.goods_id,g.thumb,o.total,o.commission,o.commission2,o.commission3, g.title, g.status,g.thumb,g.marketprice,o.total,o.optionname,o.optionid,o.price as orderprice,o.order_status, o.id as ogid FROM " . tablename(ORDER_GOODS) . " o left join " . tablename(GOODS) . " g on o.goodsid=g.goods_id " . " WHERE o.orderid='{$id}'");


        }elseif ('delete' == $op) {
		    $id = intval($_GPC['id']);
		    pdo_delete(ORDER_GOODS, array('orderid' => $id, 'uniacid' => $_W['uniacid'],'shop_id'=>$shop_id));
		    pdo_delete(ORDER, array('id' => $id, 'uniacid' => $_W['uniacid'],'shop_id'=>$shop_id));
		    $this->message('订单删除成功', referer(), 'success');
		} elseif ($op == 'admin_remark') {
			$id = intval($_GPC['id']);
			$admin_remark=$_GPC['admin_remark'];
			if($admin_remark && $id){
			 pdo_update(ORDER, array('admin_remark' => $admin_remark), array('id' => $id,'uniacid'=>$_W['uniacid'],'shop_id'=>$shop_id));
		     $this->message('订单备注成功！', referer(), 'success');
			}
		}
include $this->template('web/shop/order');
exit();