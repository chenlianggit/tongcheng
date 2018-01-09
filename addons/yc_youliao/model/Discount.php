<?php 


class discount
{
	// 查询单条卡券
	static function getSingleCard($id,$shop_id){
        global $_W;
		return Util::getDataByCacheFirst('card',$id,array('Util','getSingelDataInSingleTable'),array(DISCOUNT,array('id'=>$id,'shop_id'=>$shop_id,'uniacid'=>$_W['uniacid'])));
		//需删除缓存
	}
	
	//查询个人已领取对应id优惠券数量
	static function selectTakedNum($userid,$cardid){
		global $_W;
		return Util::countDataNumber(DISCOUNT_USER,array('userid'=>$userid,'uniacid'=>$_W['uniacid'],'cardid'=>$cardid));
	}
	
	//联合查询领取表和卡券表数据----已领取的卡券
	static function getTakedCard($where,$num,$page,$order=' b.`id` DESC',$from,$isNeedpage){
	
		$data = Util::structWhereStringOfAnd($where,'b');
		if($from == 'app'){
			$select = ' a.id,a.cardname,a.cardtype,a.cardvalue,a.fullmoney,b.overtime';
			$params = $data[1];
		
		}elseif($from == 'web'){
			$select = 'b.*,a.cardtype,a.cardname,a.cardvalue,a.fullmoney,c.nickname,c.headimgurl';
			if(!empty($where['cardtype'])){
				$temp = $where['cardtype'];
				unset($where['cardtype']);
				$data = Util::structWhereStringOfAnd($where,'b');
				$data[0] = $data[0] . 'AND a.`cardtype` = :cardtype ';
				$data[1][':cardtype'] = $temp;
			}
			$params = $data[1];
		
		}elseif($from == 'canuse'){ //confirm页面可使用的优惠券
			$select = ' a.id,a.cardname,a.cardtype,a.cardvalue,a.fullmoney,b.overtime,b.id AS usercardid';
			$fullmoney = $where['fullmoney'];
			unset($where['fullmoney']);
			$data = Util::structWhereStringOfAnd($where,'b');
			$data[0] = $data[0] . 'AND a.`fullmoney` <= :fullmoney ';
			$params = $data[1];
			$params[':fullmoney'] = $fullmoney;
		
		}elseif($from == 'usesingle'){ //选择的对应的卡券 在model_order页面计算价格方法内
			$select = ' a.cardtype,a.cardvalue,a.fullmoney,b.*';
			$params = $data[1];
		}
		
		$commonstr = tablename(DISCOUNT) ." AS a INNER JOIN ".tablename(DISCOUNT_USER)." AS b ON a.`id` = b.`cardid` 
		LEFT JOIN ".tablename(MEMBER)." AS c ON b.`userid` =c.`id` WHERE ".$data[0];
		
		$countStr = "SELECT COUNT(*) FROM ".$commonstr;
		$selectStr =  "SELECT $select FROM ".$commonstr;
		$data = Util::fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order,$isNeedpage);
		
		return $data;
	}

    static function deleteCard($id,$shop_id){
        global $_W;
        $id = intval($id);
        $res = pdo_delete(DISCOUNT,array('id'=>$id,'shop_id'=>$shop_id,'uniacid'=>$_W['uniacid']));
        return $res;
    }
	
	
}