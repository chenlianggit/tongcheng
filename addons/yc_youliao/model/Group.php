<?php 


class Group
{
	
	
	static function decodeGroupStatus($status,$overtime,$isrefund,$lastnumber){
		global $_W;		
		if($isrefund == 1){
			return 4; //组团失败退款中
		}else{
			if($status == 1 && $overtime > time() && $lastnumber > 0){
				return 1; //团购中
			}elseif(($status == 2 || $overtime < time()) && $lastnumber > 0){
				return 2; //组团失败
			}elseif($status == 3 || $lastnumber == 0){
				return 3; //组团成功
			}
		}
		return 2;
	}
	
	//判断团是否完成
	static function checkGroupIsFinished($groupid,$openid,$module,$orderid,$shop_id){
		global $_W;
		$group = Util::getSingelDataInSingleTable(GROUP,array('id'=>$groupid));
		if($group['lastnumber'] <= 0){
			$res = pdo_update(GROUP,array('status'=>3,'finishtime'=>time()),array('uniacid'=>$_W['uniacid'],'id'=>$groupid));
			pdo_update(ORDER,array('iscomplete'=>1),array('uniacid'=>$_W['uniacid'],'groupid'=>$groupid));
             pdo_update(ORDER_GOODS,array('iscomplete'=>1),array('uniacid'=>$_W['uniacid'],'orderid'=>$orderid));
             //已成团的要生成二维码
            Order::createQrCode($shop_id,$groupid);
			$queue = new queue; //将待发团完成消息插入数据库
			$queue -> addMessage(4,$groupid);			
		}else{
			$good = Goods::getSingleGood($group['gid']);
			Message::cmessage($openid,$module,$good['title'],$group['overtime'],$good['groupprice'],$group['id'],$group['lastnumber']);
		}
		Util::deleteCache('group',$groupid); //删除缓存
		if($res) return true; return false;
	}
	
	//查询最近团
	static function getLatelyGroup($where,$str,$page,$num,$select,$order,$isNeedpage){
		$data = Util::structWhereStringOfAnd($where,'a');
		$commonstr = tablename(GROUP)." AS a LEFT JOIN ".tablename(MEMBER)." AS b ON a.`uid` = b.`id` WHERE ".$data[0].$str;
		$countStr = "SELECT  COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT  $select FROM ".$commonstr;
		$res = Util::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$isNeedpage);
		return $res;
	}
	
	
	// 查询单条团购信息
	static function getSingleGroup($id,$shop_id){
        global $_W;
        $select='b.*,a.thumb,a.title,a.productprice,a.marketprice,a.groupprice';
        $commonstr = tablename(GOODS)." AS a RIGHT JOIN ".tablename(GROUP)." AS b ON a.`goods_id` = b.`gid` WHERE   a.uniacid ={$_W['uniacid']} and b.id={$id}  and a.shop_id={$shop_id}";
        $selectStr =  "SELECT  $select FROM ".$commonstr;
        $data =pdo_fetch($selectStr);
        return $data;
		//需删除缓存
	}
	
	
	//批量查询团购
	static function getAllGroup($wherea,$whereb,$statusstr,$select,$page,$num,$order,$isNeedpage){
		$dataa = Util::structWhereStringOfAnd($wherea,'a');
		$datab = Util::structWhereStringOfAnd($whereb,'b');
		
		$params = array_merge((array)$dataa[1],(array)$datab[1]);
		
		if(!empty($dataa[0]) && !empty($datab[0])) $datab[0] = ' AND '.$datab[0];
		
		$commonstr = tablename(GOODS)." AS a RIGHT JOIN ".tablename(GROUP)." AS b ON a.`goods_id` = b.`gid` WHERE ".$dataa[0].$datab[0].$statusstr;
		
		$countStr = "SELECT  COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT  $select FROM ".$commonstr;
		$data = Util::fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order,$isNeedpage);
		
		return $data;
	}
	
	
	//批量查询团购订单
	static function getAllGroupOrder($wherea,$whereb,$statusstr,$select,$page,$num,$order,$isNeedpage){
		$dataa = Util::structWhereStringOfAnd($wherea,'a');
		$datab = Util::structWhereStringOfAnd($whereb,'b');
		
		if(!empty($statusstr)) $str = ' AND '.$statusstr;
		$params = array_merge((array)$dataa[1],(array)$datab[1]);
		
		if(!empty($dataa[0]) && !empty($datab[0])) $datab[0] = ' AND '.$datab[0];
		
		$select = $select.',d.title,d.thumb,a.price ';
		
		$commonstr = tablename(ORDER) ." AS a LEFT JOIN ".tablename(GROUP)." AS b ON a.`groupid` = b.`id`
		 LEFT JOIN  ".tablename(ORDER_GOODS)." AS c ON c.`orderid` = a.`id`
		 LEFT JOIN  ".tablename(GOODS)." AS d ON c.`goodsid` = d.`goods_id`  WHERE ".$dataa[0].$datab[0].$str ;
	
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$data = Util::fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order,$isNeedpage);
		
		return $data;
	}	
	

	static function getGroupMemberWithCache($groupid){
        global $_W;
		$groupid = intval($groupid);
        $select=' b.avatar,b.nickname,b.id AS userid,a.paytime';
        $commonstr = tablename(ORDER)." AS a LEFT JOIN ".tablename(MEMBER)." AS b ON a.`userid` = b.`id` WHERE   a.uniacid ={$_W['uniacid']} and a.groupid={$groupid}";
        $selectStr =  "SELECT  $select FROM ".$commonstr;
        $data =pdo_fetchall($selectStr);

        return $data;

	}
	

		// 查询团成员
	static function getGroupMember($where,$select,$page,$num,$order,$isNeedpage){
		$dataa = Util::structWhereStringOfAnd($where,'b');		
		$commonstr = tablename(MEMBER) ." AS a LEFT JOIN ".tablename(ORDER)." AS b ON a.`id` = b.`userid`  WHERE ".$dataa[0];
		if(empty($select)) $select = ' a.*,a.status AS astatus,a.id AS userid,b.status AS bstatus,b.orderid,b.id AS bid ';
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$data = Util::fetchFunctionInCommon($countStr,$selectStr,$dataa[1],$page,$num,$order,$isNeedpage);
		return $data;
	}
	
	
	//验证是否允许参团，在ajaxdeal的提交支付和pay的重新支付里
	static function checkIsAllowJoinGroup($groupid){
		global $_W;
		$groupid = intval($groupid);
		$groupinfo = pdo_get(GROUP,array('uniacid'=>$_W['uniacid'],'id'=>$groupid));
		if(empty($groupinfo)) return '您要参与的团不存在';
		if($groupinfo['lastnumber'] <= 0 || $groupinfo['status'] == 3) return '您要参与的团已经满了';
		if($groupinfo['overtime'] <= time()  || $groupinfo['status'] == 2) return '您要参与的团已经结束了';
		//$isingroup = model_order::getSingleOrderByStatus(array('groupid'=>$data['groupid'],'from_user'=>$_W['openid']),' NOT IN (1,2) '); 
		$isingroup = pdo_fetch("SELECT *  FROM " . tablename(ORDER) . " WHERE groupid=".$groupid ." and openid='".$_W['openid']."' and uniacid = " . $_W['uniacid']);
		if(!empty($isingroup)) return '您已参与过此团';
		return 1;
	}
	
}