<?php 


class Order
{
	
	//返回订单状态
	static function decodeOrderStatus($status,$refundstatus){
		if($refundstatus == 1){
			$res = 8; //申请退款
		}else{
			$res = $status;
		}
		return $res;
	}
	
	//查询单条订单的详情+商品商品，在payresault类中用到
	static function getSingleOrderAndGood($orderid){
		global $_W;
		$select = 'a.shop_id,a.price as totalmoney,a.createtime,a.openid as openid,a.ordertype,a.id AS idoforder,a.userid,a.groupid,a.status,b.total as buynum,c.goods_id AS gid,c.groupnum,c.groupendtime,c.title,d.mobile';
		$sql = " SELECT $select FROM ". tablename(ORDER) . " AS a RIGHT JOIN ". tablename(ORDER_GOODS) ." AS b ON a.`id` = b.orderid LEFT JOIN ". tablename(GOODS) . " AS c ON c.`goods_id` = b.`goodsid` LEFT JOIN ". tablename(ADDRESS) . " AS d ON d.`id` = a.`addressid` WHERE a.`uniacid` = :uniacid AND a.id = :orderid ";
		$data = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid'],':orderid'=>$orderid));
		foreach($data as $k=>$v){
			if($k == 0){
				$order = $v;
			}
			$order['goodinfo'][$k] = $v;
		}

		return $order;
	}
    //查询单条订单的详情+商品商品
    static function getOrderAndGood($orderid){
        global $_W;
        $select = 'a.price as totalmoney,a.createtime,a.openid as openid,a.ordertype,a.id AS idoforder,a.userid,a.groupid,a.status,b.total as buynum,c.goods_id AS gid,c.groupnum,c.groupendtime,c.title,d.mobile';
        $sql = " SELECT $select FROM ". tablename(ORDER) . " AS a RIGHT JOIN ". tablename(ORDER_GOODS) ." AS b ON a.`id` = b.orderid LEFT JOIN ". tablename(GOODS) . " AS c ON c.`goods_id` = b.`goodsid` LEFT JOIN ". tablename(ADDRESS) . " AS d ON d.`id` = a.`addressid` WHERE a.`uniacid` = :uniacid AND a.id = :orderid order by a.id desc limit 1 ";
        $data = pdo_fetch($sql,array(':uniacid'=>$_W['uniacid'],':orderid'=>$orderid));
        return $data;
    }
    //根据订单id查询多条商品
    static function getGoodById($orderid){
        global $_W;
        $select = 'b.*, b.total as ototal,c.*,c.createtime as starttime ';
        $sql = " SELECT $select FROM ". tablename(ORDER_GOODS) ." AS b  LEFT JOIN ". tablename(GOODS) . " AS c ON c.`goods_id` = b.`goodsid`  WHERE b.`uniacid` = :uniacid AND b.orderid = :orderid order by b.id desc  ";
        $data = pdo_fetchall($sql,array(':uniacid'=>$_W['uniacid'],':orderid'=>$orderid));
        return $data;
    }
    // 查询单条指定状态的订单 $statusstr要加  IN 或者 NOT IN
	static function getSingleOrderByStatus($where,$statusstr){
		$data = Util::structWhereStringOfAnd($where);
		$str = $data[0] . ' AND status '.$statusstr;
		$sql = "SELECT * FROM ". tablename(ORDER) ." WHERE $str ";
		return pdo_fetch($sql,$data[1]);		
		
	}
	
	//查询某状态订单数量  $statusstr要加  IN 或者 NOT IN
	static function getOrderNumberByStatus($where,$statusstr){
		$data = Util::structWhereStringOfAnd($where);
		$str = $data[0] . ' AND status '.$statusstr;
		$sql = "SELECT COUNT(*) FROM ". tablename(ORDER) ." WHERE $str ";
		return pdo_fetchcolumn($sql,$data[1]);
	}	
	
	//查询某条订单的详情
	static function getSingleOrderDetail($id,$wherea){
		return Util::getDataByCacheFirst('order',$id,array('order','getAllOrder'),array($wherea,'','',' *,a.id AS id,b.id AS bid ',1,10,' b.id DESC ',false));
		//需删除缓存
	}
	
	//计算相应订单数量
	static function countOrderNumber($uid){
        global $_W;
		$data = Util::getCache('ordernumber',$uid);
		if(empty($data)){
			$data['waitpay'] = Util::countDataNumber(ORDER,array('uniacid'=>$_W['uniacid'],'uid'=>$uid,'status'=>1));
			$data['waitsend'] = Util::countDataNumber(ORDER,array('uniacid'=>$_W['uniacid'],'uid'=>$uid,'status'=>3),' AND refundstatus != 1 ');
			$data['waittake'] = Util::countDataNumber(ORDER,array('uniacid'=>$_W['uniacid'],'uid'=>$uid,'status'=>4));
			$data['waitcomment'] = Util::countDataNumber(ORDER,array('uniacid'=>$_W['uniacid'],'uid'=>$uid,'status'=>5));
			util::setCache('ordernumber',$uid,$data);
		}
		return $data;
	}
	
	
	//批量查询订单
	static function getAllOrder($wherea,$whereb,$statusstr,$select,$page,$num,$order,$isNeedpage){
		$dataa = Util::structWhereStringOfAnd($wherea,'a');
		$datab = Util::structWhereStringOfAnd($whereb,'b');
		
		if(!empty($statusstr)) $str = ' AND '.$statusstr;
		$params = array_merge((array)$dataa[1],(array)$datab[1]);
		
		if(!empty($datab[0])) $datab[0] = ' AND '.$datab[0];
		$commonstr = tablename(ORDER) ." AS a 
		 LEFT JOIN  ".tablename(ORDER_GOODS)." AS c ON c.`orderid` = a.`id`
		 LEFT JOIN  ".tablename(ADDRESS)." AS s ON s.`id` = a.`addressid`
		 LEFT JOIN  ".tablename(MEMBER)." AS u ON a.`userid` = u.`id`
		 LEFT JOIN  ".tablename(GOODS)." AS d ON c.`goodsid` = d.`goods_id`  WHERE ".$dataa[0].$datab[0].$str ;
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$data = Util::fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order,$isNeedpage);
		foreach($data[0] as $k=>$v){
			$orderinfo[$v['idoforder']][$k] = $v;
		}
		
		return array($orderinfo,$data[1],$data[2]);
	}
	
	//取消未支付的订单
	static function cancelDoNotPayOrder($orderinfo,$module){
		global $_W;
		if($orderinfo['status'] != 1) return false; //不是待支付的订单
		$res = pdo_update(ORDER,array('status'=>2,'canceltime'=>time()),array('id'=>$orderinfo['id'],'status'=>1));
		
		//退还卡券
		if($module->module['config']['isreturncard'] == 1 && $orderinfo['cardid'] > 0){
			$res = pdo_update(USERCARD,array('usetime'=>0,'status'=>0),array('id'=>$orderinfo['cardid'],'uniacid'=>$_W['uniacid']));
		}
		if($module->module['config']['isreturncredit'] == 1 && $orderinfo['deductible'] > 0){
			$res = Member::updateUserCredit($orderinfo['openid'],$orderinfo['deductible'],'3');
		}
		
		//恢复商品库存
		$title="";
		$address="";
		$ordergood = Util::getAllDataInSingleTable(ORDER_GOODS,array('orderid'=>$orderinfo['id']),1,10,'id DESC',false,' id,total ');
		foreach($ordergood[0] as $k=>$v){
			Util::addOrMinusOrUpdateData(GOODS,array('total'=>$v['total']),$v['goodsid'],'addorminus');
			Util::deleteCache('good',$v['goodsid']);
			$title .= pdo_fetchcolumn("SELECT title  FROM " . tablename(GOODS) . " WHERE uniacid = {$_W['uniacid']} and id= {$v['goodsid']}");
		}
		if($orderinfo['addressid']){
		$addressall= pdo_fetch("SELECT realname,province,city,area,address  FROM " . tablename(ADDRESS) . " WHERE uniacid = {$_W['uniacid']} and id= {$orderinfo['addressid']}");
		$address=$addressall['realname'].' '.$addressall['province'].$addressall['city'].$addressall['area'].$addressall['address'];
		}
		
		//发消息		
		Message::imessage2($orderinfo['openid'],$module,$title,$orderinfo['ordersn'],$orderinfo['price'],$address,$orderinfo['id']);
		Util::deleteCache('order',$orderinfo['id']);
		Util::deleteCache('ordernumber',$orderinfo['userid']);
		
		return $res;
	}
	
	//订单确认收货
	static function confirmOrder($orderinfo,$type){
		if($orderinfo['status'] != 4) return false; //不是已发货的订单
		$res = pdo_update(ORDER,array('status'=>5,'confirmtime'=>time(),'comfiretype'=>$type),array('id'=>$orderinfo['id'],'status'=>4));
		// 积分奖励

		$allgood = pdo_getall(ORDER_GOODS,array('orderid'=>$orderinfo['id']));
		
		foreach ($allgood as $k => $v) {
			$credit = pdo_get(GOODS,array('id'=>$v['goodsid']),'usercredit');
			//个人积分奖励
			if($credit['usercredit'] > 0){
				Member::updateUserCredit($orderinfo['openid'],$credit['usercredit']*$v['buynum'],4);
			}
		}

		//删除会员缓存
		Util::deleteCache('fsuser',$orderinfo['openid']);
		Util::deleteCache('order',$orderinfo['id']);
		Util::deleteCache('ordernumber',$orderinfo['userid']);
		return $res;	
	}
	
	//发货
	static function sendGood($id,$uparray,$type){
		global $_W;	
		$orderinfo = Util::getSingelDataInSingleTable(ORDER,array('uniacid'=>$_W['uniacid'],'id'=>$id),' groupid,userid ');
		//验证是否团购订单，是否可发货
		$groupstatus = self::checkIsAllowReundAndSend($orderinfo['groupid']);
		if(!$groupstatus) return array('status'=>false,'err_code'=>'团购订单还在组团中，不能发货');	
		
		$data['status'] = pdo_update(ORDER,$uparray,array('uniacid'=>$_W['uniacid'],'id'=>intval($id)));		
		
		if($data['status'] && $type == 'express'){
			$queue = new queue; //将待发消息插入数据库
			$queue -> addMessage(1,$id);
		}
		Util::deleteCache('order',$id);
		Util::deleteCache('ordernumber',$orderinfo['userid']);
		return $data;
	}
	
	//根据团，验证团购订单是否可以发货和退款
	static function checkIsAllowReundAndSend($groupid){
		global $_W;		
		$groupinfo = Util::getSingelDataInSingleTable(GROUP,array('uniacid'=>$_W['uniacid'],'id'=>$groupid),' * ');
		if($groupinfo['status'] == 1 || $groupinfo['isrefund'] == 2){ //组团中，退款中		
			return false;
		}
		return true;
	}

    //订单退款（普通订单）
    static function backMoney($order_goods,$money,$module,$from){
        global $_W;
        $id =intval($order_goods['orderid']);
        $ogid=intval($order_goods['id']);
        $orderinfo = Util::getSingelDataInSingleTable(ORDER,array('uniacid'=>$_W['uniacid'],'id'=>$id),
            ' price,status,refundstatus,paytype,openid,id,transid,ordersn');

        if($money <= 0 || $order_goods['price'] < $money || ($orderinfo['status'] != 1 && $orderinfo['status'] != 4) || ($order_goods['order_status']!=3 && $order_goods['order_status']!=5) ) return false;

        if($orderinfo['paytype'] == '1'){ //余额支付
            $res['status'] =Member::updateUserMoney($orderinfo['openid'],$money,1);
        }elseif($orderinfo['paytype'] == '2' && !empty($orderinfo['transid'])){ //微信支付
            $pay = new WeixinPay;
            $arr = array('uorderid'=>$orderinfo['transid'],
                'totalmoney'=>$orderinfo['price'],
                'refundmoney'=>$money);
            $data = $pay -> refund($arr);
            if($data['result_code']=='SUCCESS'){
                $res['status'] = true;
            }else{
                $res['status'] = false;
                $res['error_code'] = $data['err_code_des'];
//                print_r($data);
//                echo json_encode(array('status'=>'2','str'=>$data));
//                exit;
            }
        }
        if($res['status']){
            //改订单
            $ress = pdo_update(ORDER_GOODS,array('order_status'=>10),array('uniacid'=>$_W['uniacid'],'id'=>$ogid));
            if($ress) {
                $result=pdo_update(REFUND,array('refundtime'=>time(),'money'=>$money),array('uniacid'=>$_W['uniacid'],'ogid'=>$ogid));
                //发通知
                $url2 = Util::createModuleUrl('refund',array('ogid'=>$ogid));
                Message::fmessage($orderinfo['openid'],$module,$orderinfo['ordersn'],$money,$orderinfo['paytype'],$url2);
                return $result;
            }

        }

    }

    //团购单退款
	static function refundMoney($id,$money,$module,$from){
		
		global $_W;	
		$id = intval($id);
		$orderinfo = Util::getSingelDataInSingleTable(ORDER,array('uniacid'=>$_W['uniacid'],'id'=>$id),
		' price,status,refundstatus,paytype,openid,id,transid,groupid ');
		if($money <= 0 || $orderinfo['price'] < $money || ($orderinfo['status'] != 1 && $orderinfo['status'] != 4)) return false;
		
		//验证是不是团订单，如果是团购订单，而且没有失败，那么不能退款
		if($orderinfo['groupid'] >0 && $from == 'web'){
			$groupstatus = self::checkIsAllowReundAndSend($orderinfo['groupid']);
			if(!$groupstatus){
				$res['status'] = false;
				$res['error_code'] = '团购订单还在组团中，不能退款';
				return $res;				
			}
		}
		
		if($orderinfo['paytype'] == '1'){ //余额支付
			
			$res['status'] = Member::updateUserMoney($orderinfo['openid'],$money,1);
			
		}elseif($orderinfo['paytype'] == '2' && !empty($orderinfo['transid'])){ //微信支付
			$pay = new WeixinPay;
			$arr = array('uorderid'=>$orderinfo['transid'],'totalmoney'=>$orderinfo['price'],'refundmoney'=>$money);
			$data = $pay -> refund($arr);
			
			if($data['result_code']=='SUCCESS'){
				$res['status'] = true;
			}else{
				$res['status'] = false;
				$res['error_code'] = $data['err_code_des'];
			}
		}
		
		if($res['status']){
			//改订单
			$ress = pdo_update(ORDER,array('status'=>4,'refundstatus'=>3,'refundtime'=>time(),'refundmoney'=>$money),array('id'=>$id));

			if($ress) {
                pdo_update(ORDER_GOODS,array('order_status'=>10),array('orderid'=>$id));
				//检查团是不是已退完款,如果已退完了，那么改变团的退款状态
				if($orderinfo['groupid'] > 0){
					$isendgroup = self::getSingleOrderByStatus(array('uniacid'=>$_W['uniacid'],'groupid'=>$orderinfo['groupid']),' IN (3,4,5,6) ');
					if(empty($isendgroup)){
						pdo_update(GROUP,array('isrefund'=>2),array('uniacid'=>$_W['uniacid'],'id'=>$orderinfo['groupid']));
						Util::deleteCache('group',$orderinfo['groupid']); //删除团缓存
					}
				}

				//删缓存
				Util::deleteCache('order',$id);
				Util::deleteCache('ordernumber',$orderinfo['userid']);
				//发通知
                $url=Util::createModuleUrl('group', array('op' => 'detail', 'groupid' => $orderinfo['groupid']));
				Message::fmessage($orderinfo['openid'],$module,$orderinfo['ordersn'],$money,$orderinfo['paytype'],$url);
			}
			
		}
		
		return $res;
	}
	
	
	//计算订单金额等
	/* 
		$orderInSession 在session内的订单商品 array
		$iscredit 是否积分抵扣 bool
		$cardid 优惠券id int
		$province 收货地址省份 str
		$modul $this 需要使用到设置内的积分抵扣比例参数 object
	*/
	
	static function countOrderMoney($orderInSession,$iscredit,$cardid,$module){
		global $_W;
		$maxcredit = 0; //可抵扣的积分
		$iscard = 0; //是否可使用卡券
		$firstcut = 0; //最大的首单优惠金额
        $xscut = 0; //限时抢购金额
		$totalcardcountmoney = 0; //优惠券总计减免金额
		$totalnum = 0;
		$totalmoney = array();
		$goodinfo = array();
        $de=$module->module['config']['credit2money'];
        if (empty($de)) {
            $de = 0.1;
        }
		foreach($orderInSession as $k=>$v){
			// print_r($orderInSession);	
			// exit;		
			$goodinfo[$k] = Goods::getSingleGood($v['id'],$v['shop_id']);  ///////////////////////这里要考虑商品不存在的情况

			//判断是不是能购买
			$iscanbuy = Goods::checkIsCanBuyThisGood($v['id'],$v['shop_id'],$v['number']);
			if($iscanbuy != 1) message($iscanbuy);
			
			unset($goodinfo[$k]['content']); //删除不需要的数据
			unset($goodinfo[$k]['description']);
			unset($goodinfo[$k]['xsthumb']);
			unset($goodinfo[$k]['createtime']);
			unset($goodinfo[$k]['sort']);
			unset($goodinfo[$k]['goodssn']);	
		    $buyprice=Goods::getGoodPriceInRule($goodinfo[$k],$v['buytype'],$v['rule']);
			$goodinfo[$k]['afterprice'] = $buyprice[0];
            $goodinfo[$k]['buyprice'] = $buyprice[1];
			$goodinfo[$k]['buyrule'] = Goods::getGoodRuleToView($goodinfo[$k]['hasoption'],$v['rule']); //处理多规格购买规格
			$goodinfo[$k]['buynumber'] = $v['number']; //下单的数量
			$goodinfo[$k]['optionid']=$v['rule']['optionid'];
			
			
			//确定订单类型
			if($v['buytype'] == 'single'){
				$ordertype = 1;
			}elseif($v['buytype'] == 'joingroup'){
				$ordertype = 2;
			}elseif($v['buytype'] == 'group'){
				$ordertype = 3;
			}else{
				message('请返回重新选择商品');
			}
			//确定团id
			$groupid = $v['groupid'] > 0 ? $v['groupid'] : 0;
			if(empty($goodinfo[$k]['buyprice']) || $goodinfo[$k]['buyprice'] <= 0 || !is_numeric($goodinfo[$k]['buyprice'])) message('可能商品已不存在请返回重新选择商品');
			
			//获取当前订单最多可抵扣的积分
			if($goodinfo[$k]['credit'] >0 ) $maxcredit += $goodinfo[$k]['credit'];
            //首单优惠金额
            if($goodinfo[$k]['isfirstcut']  > $firstcut) $firstcut = $goodinfo[$k]['isfirstcut'];


            $xscut += $goodinfo[$k]['afterprice']-$goodinfo[$k]['buyprice'];
            if($goodinfo[$k]['iscard']  == 1) $iscard = 1; //是否可使用优惠券 便于判断下一步是否需要计算优惠券优惠金额
			
			//只计算数量和单价的总金额
			$goodinfo[$k]['buytotalmoney'] = $goodinfo[$k]['buynumber']*$goodinfo[$k]['afterprice'];
			$totalmoney[0] += $goodinfo[$k]['buytotalmoney'];
			
			$totalnum += $goodinfo[$k]['buynumber']; //总计数量
			$virtual=$goodinfo[$k]['virtual'];//虚拟卡密只能直接购买
		}
	
		//计算优惠券 优惠金额
		if(!empty($cardid) && $iscard == 1){
			$cardinfo = model_card::getTakedCard(array('id'=>$cardid),1,1,' b.`id` DESC','usesingle',false); //查询对应卡券
			$cardinfo = $cardinfo[0][0];
			
			if($cardinfo['status'] != 0 || $cardinfo['overtime'] < time() || $cardinfo['fullmoney'] > $totalmoney[0]){ 
				
				$totalcardcountmoney = 0; //如果卡券不符合减免要求，设减免0
			}else{
				if($cardinfo['cardtype'] == 1){ //如果是抵金券直接设总减免
					$totalcardcountmoney = $cardinfo['cardvalue'];
					//设定某个商品为卡券减免的商品
					foreach($goodinfo as $k=>$v){
						if($v['iscard'] == 1){
							$goodinfo[$k]['buycardflag'] = 1;
							$goodinfo[$k]['buytotalmoney'] -= $totalcardcountmoney; //单个商品订单金额
							break;
						}
					}
					
				}elseif($cardinfo['cardtype'] == 2){ //如果是折扣券，一件一件商品去计算减免
					foreach($goodinfo as $k=>$v){
						if($v['iscard'] == 1){
							$goodinfo[$k]['buycardcutmoney'] = $v['buynumber']*$v['buyprice']*(1 - $cardinfo['cardvalue']); //计算此商品减免金额
							$totalcardcountmoney += $goodinfo[$k]['buycardcutmoney']; //计算总计减免金额
							
							//单个商品订单金额
							$goodinfo[$k]['buytotalmoney'] -= $goodinfo[$k]['buycardcutmoney'];
						}
					}
				}
			}
		}
	
		//计算当前用户可抵扣积分
		if($iscredit){
			$usercredit = Member::getUserCredit($_W['openid']);
			if($usercredit['credit1'] >= $maxcredit){
				$minuscredit = $maxcredit;
			}else{
				$minuscredit = intval($usercredit['credit1']);
			}	
			//设定某个商品为抵扣的商品
			foreach($goodinfo as $k=>$v){
				if($v['credit'] == $maxcredit){
					$goodinfo[$k]['buycreditflag'] = 1;
					
					//单个商品订单金额
					$goodinfo[$k]['buytotalmoney'] -= $minuscredit*$de;
					break;
				}
			}
			
		}else{
			$minuscredit = 0;
		}

		$creditcutmoney = $minuscredit*$de;

        //计算首单优惠金额
        if($firstcut > 0) $order = self::getSingleOrderByStatus(array('openid'=>$_W['openid']),' >=1 ');
        $firstcutmoney = 0; //首单优惠金额
        if(!$order) {
            $firstcutmoney = $firstcut;
            //设定某个商品为首单优惠的商品
            foreach($goodinfo as $k=>$v){
                if($v['isfirstcut']>0){
                    $goodinfo[$k]['buyfirstcutflag'] = 1;
                    //单个商品订单金额
                    $goodinfo[$k]['buytotalmoney'] -= $firstcutmoney;
                    break;
                }
            }
        }
        //基本金额  -限时抢购金额- 积分抵扣 -首单优惠 -优惠券优惠金额
        $totalmoney[1] = $totalmoney[0] - $xscut  -  $firstcutmoney - $totalcardcountmoney; //最后的金额

        return array(
			'ordertype' => $ordertype,
			'groupid' => $groupid,
			'minuscredit' => $minuscredit, //需减掉的积分
			'minuscreditmoney' => $creditcutmoney, //积分抵扣减掉的金额
			'totalnum' => $totalnum, //总计数量
			'iscard' => $iscard, //是否可使用优惠券
            'firstcutmoney' => $firstcutmoney, //首单优惠金额
            'xscut'=>$xscut,//限时抢购减去的金额
			'totalcardcountmoney' => $totalcardcountmoney, //总计优惠券减免金额
			'totalmoney' => $totalmoney, //0是最初的金额，1是计算后的金额
			'virtual' => $virtual,
			'goodinfo' => $goodinfo
		);
		
	}

	//查询单订单（多）商品详情
    static function getorder($id){
        $goods = pdo_fetchall("SELECT g.goods_id, g.title, g.thumb, g.marketprice,o.total,o.optionid,o.order_status,o.price FROM " . tablename(ORDER_GOODS) . " o left join " . tablename(GOODS) . " g on o.goodsid=g.goods_id " . " WHERE o.orderid='{$id}'");
        foreach ($goods as &$item) {
            $option = pdo_fetch("select title,marketprice,weight,groupprice,stock from " . tablename(OPTION) . " where id=:id limit 1", array(":id" => $item['optionid']));
            if ($option) {
                $item['title']       = "[" . $option['title'] . "]" . $item['title'];
                $item['marketprice'] = $option['marketprice'];
                $item['groupprice'] = $option['groupprice'];
            }
        }
        unset($item);
        $row['goods']    = $goods;
        $row['total']    = $goods['total'];
        $row['createtime']    = date('Y-m-d H:i',$row['createtime']);
        return $goods;

    }
	static function getorderlist($where,$page,$num,$leftjoin='',$status_where=''){
        global $_W;
        if($leftjoin !=''){
            $sql="SELECT o.*, m.nickname,m.avatar FROM " . tablename(ORDER) .' o '. $leftjoin." WHERE o.uniacid= ".$_W['uniacid']. $where." ORDER BY o.id DESC LIMIT " . $page  * $num . ',' . $num;
            $list  =pdo_fetchall($sql);
        }else{
            $where = util::structWhereStringOfAnd($where);
            $sql = "SELECT * FROM " . tablename(ORDER) . " WHERE $where[0] ORDER BY id DESC LIMIT " . $page * $num . ',' . $num;
            $list  =pdo_fetchall($sql,$where[1]);
        }

        if (!empty($list)) {
            foreach ($list as &$row) {
                $goods = pdo_fetchall("SELECT g.goods_id, g.title, g.thumb, g.marketprice,o.total,o.optionid,o.order_status,o.price FROM " . tablename(ORDER_GOODS) . " o left join " . tablename(GOODS) . " g on o.goodsid=g.goods_id " . " WHERE o.orderid='{$row['id']}' {$status_where}");
                foreach ($goods as &$item) {
                    $option = pdo_fetch("select title,marketprice,weight,groupprice,stock from " . tablename(OPTION) . " where id=:id limit 1", array(":id" => $item['optionid']));
                    if ($option) {
                        $item['title']       = "[" . $option['title'] . "]" . $item['title'];
                        $item['marketprice'] = $option['marketprice'];
                        $item['groupprice'] = $option['groupprice'];
                    }
                }
                unset($item);
                $row['goods']    = $goods;
                $row['total']    = $goods['total'];
                $row['createtime']    = date('Y-m-d H:i',$row['createtime']);
            }
        }
        return array($list,$goods);
    }
	
function createOrderId($uid){
    global $_W;
		return date("YmdHis") . $_W['uniacid'] .$uid . rand(10000,99999);
	}

    static function isrefund($createtime){
        //时间是否超过退货退款期退
        //订单成交日期-今天的时间是否小于等于退货时间
        $a= time()-$createtime ;
        $b= 7*24*60*60;
        if(abs($a)<=$b){
            return 1;
        }else{
            return 0;
        }

    }
//	给订单生成二维码

    static function createQrCode($shop_id,$groupid){
        global $_W;
        $orderdata=util::getAllDataInSingleTable(ORDER,array('groupid'=>$groupid),1,50,'id desc',false,'id,ordersn');
        //给每个order_goods生成一个二维码
        foreach($orderdata[0] as $kk=>$vv){
            self::createQrCodeByorder($shop_id,$vv['ordersn'],$vv['id']);
        }
    }

    static function createQrCodeByorder($shop_id,$ordersn,$id){
        global $_W;
        //给每个order_goods生成一个二维码
            $data=util::getAllDataBySingleTable(ORDER_GOODS,array('orderid'=>$id),'id desc');
            foreach($data as $k=>$v){
                $homeurl =util::getVerify($shop_id,$ordersn.'_'.$v['id']) ;
                $qr_code= util::getURLQR($homeurl,$ordersn.'_'.$v['id']);
                $qr_code_str=util:: getrandomstr(ORDER_GOODS,6,'qr_code_str');
                pdo_update(ORDER_GOODS,  array('qr_code'=>$qr_code,'qr_code_str'=>$qr_code_str), array('id' => $v['id'], 'uniacid' => $_W['uniacid']));
            }


    }



    static function ajaxrefund($op,$noticeid){
        global $_W,$_GPC;
        $msgid =  commonGetData::gettpl('OPENTM405486816');
        //ajax请求提交物流数据
        if($op=="submitexpress"){//用户提交物流信息
            $refund_id=intval($_GPC['refund_id']);
            if( empty($refund_id) || empty($_GPC['expresscom']) || empty($_GPC['expresssn']) || empty($_GPC['express']) ){
                echo json_encode(array('status'=>'0'));
                exit;
            }
            $re_data = array(
                'expresstime' => time(),
                'expresscom' => $_GPC['expresscom'],
                'expresssn' => $_GPC['expresssn'],
                'express' => $_GPC['express']

            );
            $res=pdo_update(REFUND, $re_data, array('id' => $refund_id, 'uniacid' => $_W['uniacid']));
            if( $res){
                $res = pdo_update(ORDER_GOODS, array('order_status' => 4), array('refund_id' => $refund_id,'order_status' => 3, 'uniacid' => $_W['uniacid']));
                if( $res) {
                    echo json_encode(array('status' => '1'));
                    exit;
                }
            }

        }elseif($op=="submitAddress"){//提交退货地址
            if($noticeid<0) exit;
            $re_data = array(
                'man' => trim($_GPC['man']),
                'address' =>trim( $_GPC['address']),
                'mobile' => trim($_GPC['mobile']),
                'uniacid' => $_W['uniacid']
            );
            $result=pdo_insert(REFUND_ADDRESS, $re_data);
            $addressid = pdo_insertid();
            if($result){
                echo json_encode(array('status' => '1','addressid' => $addressid));
                exit;
            }
        }elseif($op=="submitResult"){//审核结果
            if($noticeid<0) exit;
            $refund_id=intval($_GPC['refund_id']);
            $status=intval($_GPC['status']);
            if( empty($refund_id) || $status<=0){
                echo json_encode(array('status'=>'0'));
                exit;
            }
            $beizhu=trim($_GPC['remark']);
            $re_data = array(
                'remark' =>  $beizhu,
                'resulttime'=>time(),
                'addressid' => intval($_GPC['addressid']),
            );
            pdo_update(REFUND, $re_data, array('id' => $refund_id, 'uniacid' => $_W['uniacid']));
            $result = pdo_update(ORDER_GOODS, array('order_status' =>$status), array('refund_id' => $refund_id,'order_status' => 2, 'uniacid' => $_W['uniacid']));
            if($result){

                if ($msgid) {
                    $where2['id'] = $refund_id;
                    $refundinfo = util::getSingelDataInSingleTable(REFUND, $where2, 'money,from_user,ordersn,ogid,addressid');
                    if($status==3){
                        $title="你好，您的退款申请已通过";
                        $contact_where['id'] = $refundinfo['addressid'];
                        $contact = util::getSingelDataInSingleTable(REFUND_ADDRESS, $contact_where, '*');
                        $remark='联系人：'.$contact['man'];
                        $remark.='\\n'.'联系电话：'.$contact['mobile'];
                        $remark.='\\n'.'邮寄地址：'.$contact['address'];
                        if( $beizhu){
                            $remark.='\\n'.'备注说明：'. $beizhu;
                        }
                    }elseif($status==9){
                        $title="很抱歉，您的退款申请已被驳回";
                        $remark=$beizhu;
                    }else{
                        $title="很抱歉，您的退款申请未通过";
                        $remark=$beizhu;
                    }
                    Message::refundresult($refundinfo['from_user'], $msgid, $title, $refundinfo['ordersn'],$refundinfo['money'], $refundinfo['ogid'], $remark);
                }
                echo json_encode(array('status' => '1','order_status' => $status));
                exit;
            }

        }elseif($op=="backmoney"){//退款
            if($noticeid<0) exit;
            $refund_id=intval($_GPC['refund_id']);
            $status=intval($_GPC['status']);
            $type=intval($_GPC['type']);
            if( empty($refund_id)  || $type<=0){
                echo json_encode(array('status'=>'0','str'=>'请求数据出错，请稍候再试'));
                exit;
            }
            if($type==1){//退货退款
                $afterstatus=4;
                $status=5;
            }elseif($type==2){//仅退款
                $afterstatus=2;
                $re_data['resulttime']=time();
            }
            $back_remark= trim($_GPC['remark']);
            if($back_remark){
                $re_data['back_remark']= $back_remark;
                $back_remark= $_GPC['remark']. '\\n';
            }
            if(count($re_data)>0){
                pdo_update(REFUND, $re_data, array('id' => $refund_id, 'uniacid' => $_W['uniacid']));
            }

            $result = pdo_update(ORDER_GOODS, array('order_status' =>$status), array('refund_id' => $refund_id,'order_status' => $afterstatus, 'uniacid' => $_W['uniacid']));
            if(!result)echo json_encode(array('status' => '4','str' =>'退款不存在或已处理'));
            $where2['id'] = $refund_id;
            $refundinfo = util::getSingelDataInSingleTable(REFUND, $where2, 'money,from_user,ordersn,ogid');
            $ogid=$refundinfo['ogid'];
            if(($status==5 && $type==1) || ($status==3 && $type==2) ){//1、仅退款 2、退货退款：已收到货需退款
                $where['id'] = $ogid;
                $data = util::getSingelDataInSingleTable(ORDER_GOODS, $where, 'price,order_status,goodsid,refund_id,orderid,id');
                $res = Order::backMoney( $data,$refundinfo['money'],"yc_youliao",'app');
                if($res) {
                    load()->func('file');
                    file_delete($data ['qr_code']); //已核销成功，则删除二维码图片
                    pdo_update(ORDER_GOODS, array('qr_code' =>'','qr_code_str' =>''), array('refund_id' => $refund_id, 'uniacid' => $_W['uniacid']));
                    echo json_encode(array('status' => '1','order_status' => $status));
                    exit;
                }else{
                    echo json_encode(array('status' => '2','str' =>'退款失败,请您稍候再试'));
                    exit;
                }

            }else{
                if ($msgid) {
                    $title="很抱歉，您的退款申请未通过";
                    if($status==9){$title="很抱歉，您的退款申请已被驳回";}
                    Message::refundresult($refundinfo['from_user'], $msgid, $title, $refundinfo['ordersn'],$refundinfo['money'], $ogid, $back_remark);
                }
                echo json_encode(array('status' => '3','str' =>'审核不通过'));
                exit;
            }

        }

    }



}