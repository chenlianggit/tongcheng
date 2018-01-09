<?php 

class Queue {
	
	private $islock = array('value'=>0,'expire'=>0);
	private $expiretime = 900; //锁过期时间，秒
	
	//初始赋值
	public function __construct(){
		$lock = Util::getCache('queuelock','first');
		if(!empty($lock)) $this->islock = $lock;
	}
	
	//加锁
	private function setLock(){
		$array = array('value'=>1,'expire'=>time());
		Util::setCache('queuelock','first',$array);
		$this->islock = $array;
	}
	
	//删除锁
	private function deleteLock(){
		Util::deleteCache('queuelock','first');
		$this->islock = array('value'=>0,'expire'=>time());
	}	
	
	//检查是否锁定
	public function checkLock(){
		$lock = $this->islock;	
		if($lock['value'] == 1 && $lock['expire'] < (time() - $this->expiretime )){ //过期了，删除锁
			$this->deleteLock();
			return false;
		}
		if(empty($lock['value'])){
			return false;
		}else{
			return true;
		}
	
	}
	
	public function queueMain($module){
		
		//$this->deleteLock();//===调试
		if($this->checkLock()){
			return false; //锁定的时候直接返回
		}else{
			$this->setLock(); //没锁的话锁定
		}

		//do something
		$this->sendMessage($module); //发消息
		$this->checkGroup($module); //改变失败团状态
		$this->autoOrderRecord($module); //自动处理商家资金
		$this->deleteLock(); //执行完删除锁
	}
	
	
/************以下是自动处理订单*****************/	
	//自动处理商家账户
    static function autoOrderRecord($module){
        global $_W;
        $paymoney=0;
        //查询哪些订单未同步(已无成订单，并且超过了支持退款的期限,非建团订单或者已成团订单)
        $orderwhere = array('uniacid'=>$_W['uniacid'],'order_status'=>1,'iscopy' => 0,'iscomplete' => 1);
        $orderdata = Util::getAllDataInSingleTable(ORDER_GOODS,$orderwhere,1,50,'id ASC',false,'* ');
        //print_r($orderdata);
        //将满足提现条件的订单放入订单流水表
        foreach($orderdata[0] as $k=>$v){
            //如商品支持7天退货，则需要超过7天
            $good = Util::getSingelDataInSingleTable(GOODS,array('goods_id'=>$v['goodsid']),'iscanrefund ');
            $order_item =Util::getSingelDataInSingleTable(ORDER,array('id'=>$v['orderid']),'ordersn,paytime');
            $isrefund=Order::isrefund($order_item['paytime']);
            if($good['iscanrefund']==0 || $isrefund==1){//不支持退款或者时间超过7天
            //将数据同步到记录表里
                $data = array(
                    'uniacid'=>$_W['uniacid'],
                    'shop_id'=>$v['shop_id'],
                    'price' => $v['price'],
                    'ordersn' =>$order_item['ordersn'],
                    'ogid' =>$v['orderid'],
                    'createtime' => $v['createtime'],
                );
                pdo_insert(ORDER_RE,$data);

                    //改变已同步数据的状态
                    pdo_update(ORDER_GOODS,  array('iscopy' => 1), array('id' => $v['id'], 'uniacid' => $_W['uniacid']));
                    $paymoney+=$v['price'];

            }
        }
       //改变商户余额并通知商户今天入账
        Common::changeAccount(1);
    }
	//自动处理订单
	static function autoDealOrder($module){
		global $_W;
		
		//自动取消订单
		$canceltime = time() - $module->module['config']['autocancelordertime']*60;
		$orderwhere = array('uniacid'=>$_W['uniacid'],'status'=>1,'createtime<' => $canceltime);
		$orderdata = Util::getAllDataInSingleTable(ORDER,$orderwhere,1,50,'id ASC',false,'openid,status,id,cardid,deductible,userid,ordersn,price ');
		foreach($orderdata[0] as $k=>$v){
			Order::cancelDoNotPayOrder($v,$module);
		}
		
		//自动完成订单
		$confirmtime = time() - $module->module['config']['autofinishordertime']*60;
		$orderwhere = array('uniacid'=>$_W['uniacid'],'status'=>4,'sendtime<' => $confirmtime);
		$orderdata = Util::getAllDataInSingleTable(ORDER,$orderwhere,1,50,'id ASC',false,' openid,status,ordersn,id,userid ');
		foreach($orderdata[0] as $k=>$v){
			Order::confirmOrder($v,2);
			//发完成通知
			Message::hmessage($v['openid'],$module,$v['ordersn'],$v['id']);
		}	
		
		//发未支付提醒消息
		if($module->module['config']['remindmessagetime'] > 0){
			$time = time() - $module->module['config']['autocancelordertime']*60 + $module->module['config']['remindmessagetime']*60;
			$orderwhere = array('uniacid'=>$_W['uniacid'],'status'=>1,'isremind'=>0,'createtime<' => $time);
			$orderdata = Util::getAllDataInSingleTable(ORDER,$orderwhere,1,100,'id ASC',false,' openid,id,ordersn,price,createtime ');
			foreach($orderdata[0] as $k=>$v){
				$res = Message::kmessage($v['openid'],'',$module,$v['price'],'点击此处查看详情',$v['createtime'],$v['orderid'],$v['id']);
				
				if($res){
					pdo_update(ORDER,array('isremind'=>1),array('id'=>$v['id']));
					Util::deleteCache('order',$v['id']);
				} 
			}
			
		}		
		
	}
	
	
	
	
/*************以下是自动处理团*****************/	
	
	function checkGroup($module){
		global $_W;				
		$whereb = array('uniacid'=>$_W['uniacid'],'overtime<'=>time(),'lastnumber>'=>1);
		$data = Group::getAllGroup('',$whereb,'',' a.title,b.id,b.fullnumber ',1,50,'b.id ASC',false);

		//失败的团 变成 已失败状态
		foreach($data[0] as $k => $v){
			$res = pdo_update(GROUP,array('status'=>2),array('uniacid'=>$_W['uniacid'],'id'=>$v['id']));
			Util::deleteCache('group',$v['id']);			
			$orderwhere = array('uniacid'=>$_W['uniacid'],'groupid'=>$v['id'],'status'=>1);	//1已支付	
			$orderdata = Util::getAllDataInSingleTable(ORDER,$orderwhere,1,200,'id ASC',false,' gmessage,openid,id,price,groupid ');
			//$this->addMessage(6,$v['id']);//把需要发送的失败团模板消息插入数据库
			foreach($orderdata[0] as $kk=>$vv){	
				if($vv['gmessage']==0){	//是否已发送失败团消息
					$goodsid = pdo_fetchcolumn("SELECT goodsid  FROM " . tablename(ORDER_GOODS) . " WHERE uniacid = {$_W['uniacid']} and orderid= {$vv['id']} order by id limit 1");
					if($goodsid){
						$title= pdo_fetchcolumn("SELECT title  FROM " . tablename(GOODS) . " WHERE uniacid = {$_W['uniacid']} and goods_id= {$goodsid} order by goods_id limit 1");
					}else{
						$title='点击查看详情';	
					}
					Message::gmessage($vv['openid'],$module,$title,$v['fullnumber'],$v['id']);
					pdo_update(ORDER,array('gmessage'=>1),array('uniacid'=>$_W['uniacid'],'id'=>$vv['id']));
				}
			
				//自动退款
				if($module->module['config']['isautorefundgroup'] == 1) {
					$res=Order::refundMoney($vv['id'],$vv['price'],$module,'queue');
				}
			}
		}
		
		
		// 待退款的团
		$where = array('uniacid'=>$_W['uniacid'],'isrefund'=>1);
		$data = Group::getAllGroup('',$where,'',' b.id ',1,50,'b.id ASC',false);
		foreach($data[0] as $k => $v){
			$orderwhere = array('uniacid'=>$_W['uniacid'],'groupid'=>$v['id'],'status'=>3);
			$orderdata = Util::getAllDataInSingleTable(ORDER,$orderwhere,1,200,'id ASC',false,' from_user,id,price ');
			foreach($orderdata[0] as $kk=>$vv){
				Order::refundMoney($vv['id'],$vv['price'],$module,'queue');
			}
		}

	

	}
	
	
	
/*************以下是发消息******************/	

	//增加待发消息
	public function addMessage($type,$str){
		global $_W;
		$data = array(
			'uniacid' => $_W['uniacid'],
			'type' => $type,
			'str' => $str
		);
		$res = pdo_insert(WAIT_MESSAGE,$data);
		return $res;
	}
	
	//删除消息队列
	public function deleteMessage($id){
		global $_W;		
		pdo_delete(WAIT_MESSAGE,array('uniacid'=>$_W['uniacid'],'id'=>$id),'AND');
	}
	
	//查询需要发消息的记录
	public function getNeedMessageItem(){
		global $_W;
		$array = array(':uniacid'=>$_W['uniacid']);
		return pdo_fetchall("SELECT * FROM ".tablename(WAIT_MESSAGE)." WHERE `uniacid` = :uniacid ORDER BY `id` ASC ",$array);
	}
	
	//发消息
	public function sendMessage($module){
		//echo("s1");//====调试		
		$message = $this->getNeedMessageItem();		
		foreach($message as $k=>$v){
			if($v['type'] == 1){ //发货消息
				$this->sendgoodMessage($v['str'],$module);
			}
			
			if($v['type'] == 2){ 
				//echo 222;
			}			
			
			if($v['type'] == 4){ //团完成了通知
				$this->GroupDoneMessage($v['str'],$module);
			}
			if($v['type'] == 5){ //发给管理员的下单通知
				$id = intval($v['str']);
				$order = Util::getSingelDataInSingleTable(ORDER,array('id'=>$id),' price ');
				Message::jmessage($module,'点击此处查看详情',$order['price'],$id);
			}
			
			// if($v['type'] == 6){ //组团失败
			// 	//发失败通知				
			// 	$this->sendgrouploseMessage($v['str'],$module);
			// }
			$this->deleteMessage($v['id']); //删除已发的
		}
	}
	

	//组团失败
	public function sendgrouploseMessage($id,$module){
		global $_W;	
		$id = intval($id);	
		if(empty($id)) return false;
		$sql = "SELECT from_user as openid,ordersn as orderid,id FROM ".tablename(ORDER)." WHERE `uniacid` = :uniacid AND (`status` = 1 or `status`=0 and paytype=3)AND `groupid` = :groupid ORDER BY `id` DESC";
		$openidarray = pdo_fetchall($sql,array(':uniacid'=> $_W['uniacid'],':groupid' => $id));
		
		if(empty($openidarray)) return false;
		
		
		foreach($openidarray as $k=>$v){
			$goodsid = pdo_fetchcolumn("SELECT goodsid  FROM " . tablename(ORDER_GOODS) . " WHERE uniacid = {$_W['uniacid']} and orderid= {$v['id']} order by id limit 1");
			
			if($goodsid){
			$title= pdo_fetchcolumn("SELECT title  FROM " . tablename(GOODS) . " WHERE uniacid = {$_W['uniacid']} and id= {$goodsid} order by id limit 1");	
			}else{
			$title='点击查看详情';	
			}
			//查团信息
			$groupdes = pdo_fetch("SELECT fullnumber, id FROM " . tablename(GROUP) . " WHERE uniacid = {$_W['uniacid']} and id= {$id} order by id limit 1");		
			
			Message::gmessage($v['openid'],$module,$title,$groupdes['fullnumber'],$id);
			
		}
		
		
		
	}
	//发货通知
	public function sendgoodMessage($id,$module){
		global $_W;	
		$id = intval($id);	
		if(empty($id)) return false;
		$order = Util::getSingelDataInSingleTable(ORDER,array('id'=>$id),' from_user,expresscom,expresssn ');
		if(empty($order)) return false;
		Message::emessage($order['from_user'],$module,'点击此处查看订单详情',$order['expresscom'],$order['expresssn'],'',$id);
	}	
	
	//团完成通知
	public function GroupDoneMessage($groupid,$module){
		global $_W;	
		$groupid = intval($groupid);
		if(empty($groupid)) return false;

		$sql = "SELECT openid,ordersn as orderid,id FROM ".tablename(ORDER)." WHERE `uniacid` = :uniacid AND (`status` = 1 or `status`=0 and paytype=3)AND `groupid` = :groupid ORDER BY `id` DESC";
		$openidarray = pdo_fetchall($sql,array(':uniacid'=> $_W['uniacid'],':groupid' => $groupid));
		
		if(empty($openidarray)) return false;
		
		
		foreach($openidarray as $k=>$v){
			$goodsid = pdo_fetchcolumn("SELECT goodsid  FROM " . tablename(ORDER_GOODS) . " WHERE uniacid = {$_W['uniacid']} and orderid= {$v['id']} order by id limit 1");
			if($goodsid){
			$title= pdo_fetchcolumn("SELECT title  FROM " . tablename(GOODS) . " WHERE uniacid = {$_W['uniacid']} and id= {$goodsid} order by id limit 1");	
			}else{
			$title='点击查看详情';	
			}
			
			Message::dmessage($v['openid'],$module,$v['orderid'],$groupid,$title);
		}
		
	}	
	
}

