<?php

	global $_W,$_GPC;
	$userinfo = Member::initUserInfo(); //用户信息
	$title="确认订单";
	//$this->checkAuth();
	load()->model('mc');
	$cfg   		 = $this->module['config'];
	$from_user=$this->getOpenid();
	$qrcode_flag=$cfg['qrcode_flag'];
	$fans=mc_fansinfo($from_user,$_W['acid'],$_W['uniacid']);
	$uid = mc_openid2uid($from_user);
	$member= mc_fetch($uid);
	$myheadimg['tag'] = mc_credit_fetch($uid);
	$uniacid    = $_W['uniacid'];
	$op         = $_GPC['op'] ? $_GPC['op'] : 'display';
	$issendfree=0;
	$isfull =0;
	$fullShipping = $cfg['fullShipping'];
	$verify_des = $cfg['verify_des'];
	$fullmoney=0;
	if($op=="display"){
		unset($_SESSION['order']); //清缓存
		$allgoods   = array();
        $id         = intval($_GPC['id']);//商品id
        $shop_id         = intval($_GPC['shop_id']);//商品id
        $shop=  Shop::getShopInfoAll($shop_id);

		if(!empty($id)){//直接购买
			$total      = intval($_GPC['total']);//数量
			if (empty($total)) {
			$total = 1;
			}
			$optionid   = intval($_GPC['optionid']);//规格
			$iscanbuy = Goods::checkIsCanBuyThisGood($id,$shop_id,$total);//验证商品是否可以购买
			if($iscanbuy != 1){
			 message($iscanbuy,referer(),  'error');
			}
			$group      = $_GPC['group'];//为空单独购买，new新建团，不为空&& !=new参团此为gid(参团不允许加入购物车)

			$item= Goods::getSingleGood($id,$shop_id);
			if(empty($group)){ //单独购买
				$data['buytype'] = 'single';
			}elseif($group == 'new'){ //新建团
			 if($shop['is_group']==1 && $item['is_group']==1 ){
				$data['buytype'] = 'group';
				$groupflag=1;
				//组团库存是否足够
				 if($item['total'] < $item['groupnum']){
					   message('很抱歉，商品库存无法组团！',referer(),  'error');
				 }
			 }else{
				$data['buytype'] = 'single';
			 }

			}elseif(!empty($group) &&  $group!= 'new'){ //参团
			 if( $item['is_group']==1 ){
				 $data['buytype'] = 'joingroup';
				$data['groupid'] = $group;
				$groupflag=2;
			 }else{
				$data['buytype'] = 'single';
			 }
				$res = Group::checkIsAllowJoinGroup($group);//参团，验证团是否存在，是否已结束，是否已满员 ,是否已参团
				if($res != 1){
					 message($res,referer(),  'error');
				}
			}
			$data['gid'] = $id;
			$data['id'] = $id;
			if (!empty($optionid)) {//产品规格
			$option = pdo_fetch("select  virtual,title,marketprice,weight,stock,groupprice,time_money from " . tablename(OPTION) . " where id=:id and goodsid=:goodsid limit 1",
			array(":id" => $optionid,":goodsid" => $id));
				if ($option) {
					$item['optionid']    = $optionid;
					$item['title']       = $item['title'];
					$item['optionname']  = $option['title'];
					$item['marketprice'] = $option['marketprice'];
					$item['groupprice'] = $option['groupprice'];
                    $item['time_money']=$option['time_money'];
					$item['stock']     = $option['stock'];
					$item['weight']      = $option['weight'];
					$data['gid'] = $optionid;
					}

				}else{
				$item['stock']      = $item['total'];

				}

			if($item['stock']  < $total)  message('很抱歉，商品库存不足！',referer(),  'error'); //没有库存了
			if($groupflag==1){//组团
			if($item['stock']  <$item['groupnum'])  message('很抱歉，商品库存不足，无法组团',referer(),  'error');//没有库存了
			}
			$rule['id']=$item['id'];
			$rule['marketprice']=$item['marketprice'];
            $rule['time_money']=$item['time_money'];
			$rule['groupprice']=$item['groupprice'];
			$rule['optionid']=$item['optionid'];
			$rule['optionname']=$item['optionname'];
			$rule['stock']=$item['stock'];
			$rule['weight']=$item['weight'];
			$data['rule'] = $rule;
			$item['total']      = $total;
			$data['number'] = $total;
			$data['direct']=1;
			if($groupflag==1||$groupflag==2){//团购价格
			$item['marketprice'] = $item['groupprice'];
			}


			if($item['checkaddress']==1){//其中一个需要强制填写则必须全部填写
					$checkaddress=1;//是否强制填写地址
				}
			$item['totalprice'] =  $total *$item['marketprice'];
			$allgoods[]         = $item;

            $data['shop_id']=$item['shop_id'];

		Goods::structGoodSession($data,$data['buytype']); //设置商品session
		if(empty($_SESSION['order'])) message('出错了，请重新下单！',referer(),  'error'); //没有库存了;
		$returnurl = $this->createMobileUrl("confirm", array("id" => $id, "optionid" => $optionid, "total" => $total,"group"=> $group));

		//  =============================================================

		}else{//购物车

		$list = pdo_fetchall("SELECT * FROM " . tablename(CART) . " WHERE  uniacid = '{$_W['uniacid']}' AND from_user = '" . $from_user . "'");

			if (!empty($list)) {
				$totalprice=0;
				$full=1;
				foreach ($list as &$g) {
					$goodsid=intval($g['goodsid']);
					$goodsnum=intval($g['total']);
					$iscanbuy = Goods::checkIsCanBuyThisGood($goodsid,$shop_id, $goodsnum);//是否可购买
					if($iscanbuy != 1){ message($iscanbuy, referer(),  'error');}
					$item   = pdo_fetch("select id,fullShipping,astrict,thumb,ccate,title,weight,marketprice,total,type,totalcnf,sales,unit,issendfree,deductible from " . tablename(GOODS) .
					" where id=:id ", array(":id" => $goodsid));
					$option = pdo_fetch("select title,marketprice,weight,stock from " . tablename(OPTION) . " where id=:id limit 1",
					 array(":id" => $g['optionid']));

					if ($option) {
						$item['optionid']    = $optionid;
						$item['title']       = $item['title'];
						$item['optionname']  = $option['title'];
						$item['marketprice'] = $option['marketprice'];
						//$item['groupprice'] = $option['groupprice']; 加购物车不能团购，秒杀
						$item['stock']     = $option['stock'];
						$item['weight']      = $option['weight'];
					}

					$item['stock']      = $item['total'];
					$item['total']      =$goodsnum;
					$item['totalprice'] = $goodsnum * $item['marketprice'];
					if($item['fullShipping'] !=0 ){//查看该商品是否全部参与包邮,并且商品总价是否大于等于额度
						$full= 1;
					}
					if($item['checkaddress']==1){//其中一个需要强制填写则必须全部填写
						$checkaddress=1;//是否强制填写地址
					}


					$allgoods[]         = $item;
					$item['totalprice'] += $item['totalprice'];
					if($g['optionid']){
					$data['gid'] = $g['optionid'];
					}else{
					$data['gid'] = $item['id'];
					}

					$data['id'] = $goodsid;
					$rule['marketprice']=$item['marketprice'];
					$rule['optionid']=$g['optionid'];
					$rule['optionname']=$item['optionname'];
					$rule['stock']=$item['stock'];
					$rule['weight']=$item['weight'];
					$rule['id']=$item['id'];
					$data['rule'] = $rule;
					$data['number'] =  $goodsnum;
					$data['direct']=2;
                    $data['shop_id']=$item['shop_id'];

				Goods::structGoodSession($data,'single'); //设置商品session


		}



			unset($g);
			if(empty($_SESSION['order'])) message('出错了，请重新下单！', referer(), 'error');
			$returnurl = $this->createMobileUrl("confirm");

		}
	}//cart end
	$orderinfo =Order::countOrderMoney($_SESSION['order'],true,'',$this);
	 include $this->template('../mobile/confirm');
	 exit;


	//  =============================================================

	}elseif($op=="confirm"){
		if (checksubmit('submit')) {//提交订单

		$iscredit = false;
		if(intval($_GPC['iscredit']) > 0) $iscredit = true;
		$cardid = intval($_GPC['checkedcard']);
		$orderinfo = Order::countOrderMoney($_SESSION['order'],$iscredit,$cardid,$this);

		if($orderinfo['totalmoney'][1] <= 0) message('下单金额不能少于等于0',referer(),  'error');
		if(empty($orderinfo['goodinfo'])) message('请先选择商品',referer(),  'error');

			//地址
		$address = pdo_fetch("SELECT * FROM " . tablename(ADDRESS) . " WHERE id = :id", array(':id' => intval($_GPC['address'])));
		$addressid=$address['id'];
		$virtual_name= $_GPC['virtual_name'];
		$virtual_mobile=$_GPC['virtual_mobile'];
		if(!empty($virtual_name) && !empty($virtual_mobile) ){//线下核销
			$addlist=pdo_fetch("select * from ".tablename(ADDRESS)." where realname ='{$virtual_name}' and mobile ='{$virtual_mobile}' order by id desc limit 1");
			if(empty($addlist)){
			$data = array('uniacid' => $_W['uniacid'], 'openid' =>$_GPC['openid'], 'realname' =>$virtual_name,
			'mobile' => $virtual_mobile,);
			pdo_insert(ADDRESS, $data);
			$addressid = pdo_insertid();
			}else{
			$addressid=$addlist['id'];
			}

			}



			//核销
			$virtual_name= $_GPC['virtual_name'];
			$virtual_mobile=$_GPC['virtual_mobile'];
			$address = pdo_fetch("SELECT * FROM " . tablename(ADDRESS) . " WHERE id = :id", array(':id' => intval($_GPC['address'])));
			$addressid=$address['id'];
			if(!empty($virtual_name) && !empty($virtual_mobile) ){//线下核销
				$addlist=pdo_fetch("select * from ".tablename(ADDRESS)." where realname ='{$virtual_name}' and mobile ='{$virtual_mobile}' order by id desc limit 1");
				if(empty($addlist)){
				$data = array('uniacid' => $_W['uniacid'], 'openid' =>$_GPC['openid'], 'realname' =>$virtual_name,
				'mobile' => $virtual_mobile,);
				pdo_insert(ADDRESS, $data);
				$addressid = pdo_insertid();
				}else{
				$addressid=$addlist['id'];
				}


			 }
			//分销
		if (empty($profile) && empty($profile['id'])) {
				$shareids = pdo_fetch("SELECT * FROM " . tablename(SHARE_HISTORY) . " WHERE  from_user=:from_user and uniacid=:uniacid limit 1", array(':from_user' => $from_user, ':uniacid' => $_W['uniacid']));
				if (!empty($shareids['sharemid'])) {
					$seid   = $shareids['sharemid'];
					$member = $this->getMember($shareids['sharemid']);
					if ($member['flag'] != 1) {
						$seid = 0;
					}
				} else {
					$seid = 0;
				}
				if(!pdo_fetch('select * from '.tablename(MEMBER).' where openid=:openid ',array(':openid'=>$from_user))){
					$data = array(
						'uniacid' => $_W['uniacid'],
						'openid' => $from_user,
						'nickname' => $_W['fans']['nickname'],
						'mobile' => $_W['fans']['mobile'],
						'commission' => 0,
						'createtime' => TIMESTAMP,
						'flagtime' => TIMESTAMP,
						'shareid' => $seid,
						'status' => 1,
						'flag' => 0,
						'uid' => $uid);
					pdo_insert(MEMBER, $data);
				}
			}
			$shareId  = $this->getShareId();
			$shareId2 = $this->getShareId('', 2);
			$shareId3 = $this->getShareId('', 3);
			//判断是否本人购买
			if ($shareId == $shareId2) {
				$shareId2 = 0;
			}
			if ($shareId == $shareId3) {
				$shareId3 = 0;
			}
			if ($shareId2 == $shareId3) {
				$shareId3 = 0;
			}
			if ($cfg['globalCommissionLevel'] < 2) {
				$shareId3 = 0;
			}
			if ($cfg['globalCommissionLevel'] < 3) {
				$shareId3 = 0;
			}
		$ordersn=util::getordersn(ORDER);
		$ded_money = sprintf("%01.2f", $orderinfo['minuscreditmoney']);

		$data = array(
			'uniacid' => $_W['uniacid'],
			'openid' => $from_user,
            'shop_id' => $_GPC['shop_id'],
            'city_id' => $this->getCity_id(),
			'ordersn' => $ordersn,
			'userid'=> $userinfo['id'],
			'ordertype' => $orderinfo['ordertype'],//订单类型 1单独订单，2参团订单，3建团订单
			'groupid' => $orderinfo['groupid'],//参团id
			'cardcutmoney' => $orderinfo['totalcardcountmoney'],//优惠券抵扣金额
			'cardid' => $cardid,//优惠券id
			'ded_money' => $ded_money,//积分抵扣金额
			'deductible' => $orderinfo['minuscredit'],//积分
			'goodsprice' => $orderinfo['totalmoney'][0],//计算前金额
			'price' => $orderinfo['totalmoney'][1] -$ded_money,//最终支付金额
			'remark' => $_GPC['remark'], //备注
			'shareid' => $shareId,
			'shareid2' => $shareId2,
			'shareid3' => $shareId3,
			'status' => 0,//0待支付
            'xscut' => $orderinfo['xscut'],//限时抢购
            'firstcut' => $orderinfo['firstcutmoney'],//限时抢购
			'createtime' => TIMESTAMP
		);
		if($orderinfo['ordertype'] == 1) $data['iscomplete'] = 1; //根据此参数判断是否完成团，以便筛选发货
		$res = pdo_insert(ORDER,$data);
		$orderid = pdo_insertid();
		if($res){
		    $fa=1;
			foreach($orderinfo['goodinfo'] as $k => $v){
//			    //查看该商品是否参与积分抵扣
//                if($fa==1 && $v['credit']>0 ){
//                    $nowprice=$v['buytotalmoney']-$ded_money;
//                    if($nowprice<=0)$nowprice=0;
//                    $fa=2;
//                }
//                if($v['buyfirstcutflag'] = 1) {
//                    //单个商品订单金额
//                    $v['buytotalmoney'] -= $firstcutmoney;
//                }
				$d = array(
					'uniacid' => $_W['uniacid'],
					'orderid' => $orderid,
                    'shop_id' => $_GPC['shop_id'],
					'goodsid' => $v['goods_id'],
					'total' => $v['buynumber'],
					'price' =>$v['buytotalmoney'],//总价
					'total' => $v['buynumber'],//数量
					'optionid' => $v['optionid'],
					// 'singleprice' => $v['buyprice'],//单价
					// 'buycardcutmoney' => $v['buycardcutmoney'],
					// 'buycreditflag' => $v['buycreditflag'],
					'createtime' => TIMESTAMP,
                    'iscomplete' => $data['iscomplete'],
				);
				$o = pdo_fetch("select title from " . tablename(OPTION) . " where id=:id limit 1",
				array(":id" => $v['optionid']));
				if (!empty($o)) {
					$d['optionname'] = $o['title'];
				}
				$ccate       = $v['ccate'];
				$commission  = pdo_fetchcolumn(" SELECT commission FROM " . tablename(GOODS) . "  WHERE goods_id=" . $v['goods_id']);
				$commission2 = pdo_fetchcolumn(" SELECT commission2 FROM " . tablename(GOODS) . "  WHERE goods_id=" . $v['goods_id']);
				$commission3 = pdo_fetchcolumn(" SELECT commission3 FROM " . tablename(GOODS) . "  WHERE goods_id=" . $v['goods_id']);
				if ($commission == false || $commission == null || $commission < 0) {
					$commission = $cfg['globalCommission'];
				}
				if ($commission2 == false || $commission2 == null || $commission2 < 0) {
					$commission2 = $cfg['globalCommission2'];
				}
				if ($commission3 == false || $commission3 == null || $commission3 < 0) {
					$commission3 = $cfg['globalCommission3'];
				}
				if ($cfg['commissionType'] == 1) {
					$commissionTotal  = $v['buyprice'] * $commission / 100;
					$d['commission']  = $commissionTotal;
					$commissionTotal2 = $commissionTotal * $commission2 / 100;
					$d['commission2'] = $commissionTotal2;
					$commissionTotal3 = $commissionTotal2 * $commission3 / 100;
					$d['commission3'] = $commissionTotal3;
				} else {
					$commissionTotal  = $v['buyprice'] * $commission / 100;
					$d['commission']  = $commissionTotal;
					$commissionTotal2 = $v['buyprice'] * $commission2 / 100;
					$d['commission2'] = $commissionTotal2;
					$commissionTotal3 = $v['buyprice'] * $commission3 / 100;
					$d['commission3'] = $commissionTotal3;
				}
				if ($cfg['globalCommissionLevel'] < 2) {
					$d['commission2'] = 0;
				}
				if ($cfg['globalCommissionLevel'] < 3) {
					$d['commission3'] = 0;
				}
				$res = pdo_insert(ORDER_GOODS,$d);
				Util::deleteCache('good',$v['goods_id']); //删除商品缓存
				//根据已购买的Id删除购物车
				pdo_delete(CART, array("uniacid" => $_W['uniacid'], "from_user" => $from_user,"goodsid"=> $v['id']));
			}
		}

		if($res){
			unset($_SESSION['order']); //删除session中订单信息
			Util::deleteCache('ordernumber',$userinfo['id']); //删除订单数量数据缓存
			$this->setOrderStock($orderid);
		 die("<script>window.location.href='" . $this->createMobileUrl('confirm', array('op'=>'pay','orderid' => $orderid), 'success') . "';</script>");
		 exit;
		}
		}

	}elseif ($op=='pay'){
        $orderid = intval($_GPC['orderid']);
        $order = pdo_fetch("SELECT * FROM " . tablename(ORDER) . " WHERE id = :id and uniacid=:uniacid", array(':id' => $orderid, ':uniacid' => $_W['uniacid']));
        $goodsstr = "";
        $bodygoods = "";
        if ($order['status'] != '0') {
            message('抱歉，您的订单已经付款或是被关闭，请重新进入付款！', $this->createMobileUrl('myorder'), 'error');
        }
        // 商品编号
        $sql = 'SELECT `goodsid` FROM ' . tablename(ORDER_GOODS) . " WHERE `orderid` = :orderid and uniacid=:uniacid";
        $goodsId = pdo_fetchcolumn($sql, array(':orderid' => $orderid, ':uniacid' => $_W['uniacid']));
        // 商品名称
        $sql = 'SELECT `title` FROM ' . tablename(GOODS) . " WHERE `goods_id` = :id and uniacid=:uniacid";
        $goodsTitle = pdo_fetchcolumn($sql, array(':id' => $goodsId, ':uniacid' => $_W['uniacid']));
        $params['fee'] = $order['price'];
        $params['tid'] = $order['ordersn'];
        $params['user'] = $order['from_user'];
        $params['title'] = $goodsTitle;
        $params['ordersn'] = $order['ordersn'];
        $params['virtual'] = $order['goodstype'] == 2 ? true : false;
        $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => 'yc_youliao', 'tid' => $params['tid']));
        if (empty($log)) {
            $log = array(
                'uniacid' => $_W['uniacid'],
                'acid' => $_W['acid'],
                'openid' => $_W['member']['uid'],
                'module' => 'yc_youliao',
                'tid' => $params['tid'],
                'fee' => $params['fee'],
                'card_fee' => $params['fee'],
                'status' => '0',
                'is_usecard' => '0',
            );
            pdo_insert('core_paylog', $log);
        }

        if ($order['paytype'] == 1 && $_W['fans']['credit2'] < $order['price']) {
            message('抱歉，您帐户的余额不够支付该订单，请充值！', create_url('site/entry/charge', array('name' => 'member', 'uniacid' => $_W['uniacid'])), 'error');
        }
        if ($order['price'] == '0') {
            $this->payResult(array('tid' => $order['ordersn'], 'from' => 'return', 'type' => 'credit2'));
            exit;
        }

        $this->Pay($params);

    }



?>