<?php 
class PayResult{

    //发布信息支付成功业务处理
    public function payresult_info($params, $paydetail, $logtag,$wxapp=0)
    {
        //订单信息的支付状态
        global $_W;
        $checkReq=$this->checkReq($params);
        if($checkReq==0)return;
        //先用小程序的uacid验证完成，再用现有的公众号id同步数据
        if($wxapp==1) $_W['uniacid']=$this->getUniacid();
        $in['ordersn'] = $params['tid'];
        $messorder = util::getSingelDataInSingleTable(INFOORDER, $in, 'id,message_id,from_user,price,status', '2');
        if ($messorder['status'] > 0) return $messorder['message_id'];//已做处理需返回
        pdo_update(INFOORDER, array('status' => 1, 'transid' => $logtag['transaction_id'], 'paydetail' => $paydetail), array('ordersn' => $params['tid']));
        pdo_update(INFO, array('haspay' => 1), array('id' => $messorder['message_id']));
        if($wxapp==0) {
            //发送消息通知用户
            $i_item = '信息发布支付成功';
            $url = Util::createModuleUrl('detail', array('id' => $messorder['message_id']));
            $where['id'] = $messorder['message_id'];
            $mid = util::getSingelDataInSingleTable(INFO, $where, 'mid', '2');
            $where2['id'] = $mid['mid'];
            $title = util::getSingelDataInSingleTable(CHANNEL, $where2, 'name', '2');
            Message::ordermessage($messorder['from_user'], $i_item, $url, $title['name'], $messorder['price']);//通知用户
            //发送消息通知管理员
            $i_item = '有人发布信息并支付成功啦！';
            Message::admin_ordermessage($i_item, $url, $title['name'], $messorder['price']);
            return $messorder['message_id'];
        }
    }

    //置顶支付成功业务处理
    public function payresult_zd($params, $paydetail, $logtag,$wxapp=0)
    {
        //订单信息的支付状态
        global $_W;
        $checkReq=$this->checkReq($params);
        if($checkReq==0)return;
        $in['ordersn'] = $params['tid'];
        $messorder = util::getSingelDataInSingleTable(ZDORDER, $in, 'message_id,days,status,price', '2');
        if ($messorder['status'] > 0) return $messorder['message_id'];//已做处理需返回
        pdo_update(ZDORDER, array('status' => 1, 'transid' => $logtag['transaction_id'], 'paydetail' => $paydetail), array('ordersn' => $params['tid']));

        $where['id'] = $messorder['message_id'];
        $message = util::getSingelDataInSingleTable(INFO, $where, 'dingtime,mid', '2');
        if ($message['dingtime'] == 0) {
            $dingtime = TIMESTAMP + $messorder['days'] * 24 * 3600;
        } else {
            $dingtime = $message['dingtime'] + $messorder['days'] * 24 * 3600;
        }
        pdo_update(INFO, array('isding' => 1, 'dingtime' => $dingtime), array('id' => $messorder['message_id']));
        if($wxapp==0) {
            //发送消息通知用户
            $i_item = '置顶信息支付成功';
            $url = Util::createModuleUrl('detail', array('id' => $messorder['message_id']));
            $where2['id'] = $message['mid'];
            $title = util::getSingelDataInSingleTable(CHANNEL, $where2, 'name', '2');
            Message::ordermessage($messorder['from_user'], $i_item, $url, $title['name'], $messorder['price']);//通知用户
            //发送消息通知管理员
            $i_item = '有人置顶并支付成功啦！';
            Message::admin_ordermessage($i_item, $url, $title['name'], $messorder['price']);
            return $messorder['message_id'];
        }
    }
    public function payresult_ye($params) {
        global $_W;
        $checkReq=$this->checkReq($params);
        if($checkReq==0)return;
        load()->model('mc');
        $id=$params['tid'];
        $from_user=$params['user'];
        $uid=mc_openid2uid($from_user);
        $id=intval(str_replace('ye','',$id));
        $result=pdo_fetch("select * from ".tablename(BALANCE)." where balance_id={$id} and uid={$uid} and 
		uniacid={$_W['uniacid']} and money<={$params['fee']}  and status=0");
        if($result){
            pdo_update(BALANCE,array('status'=>1),array('balance_id'=>$id,'uniacid'=>$_W['uniacid']));
            $balance=pdo_fetchcolumn("select credit2 from ".tablename('mc_members')." where uid={$uid}");
            $new=$balance+$params['fee'];
            pdo_update('mc_members',array('credit2'=>$new),array('uid'=>$uid,'uniacid'=>$_W['uniacid']));
            $paylog = array('type' => 'charge', 'uniacid' => $_W['uniacid'], 'openid' =>$from_user, 'tid' => date('Y-m-d H:i:s'),
                'fee' => $params['fee'], 'module' =>  MODULE, 'tag' => ' [社区余额充值]充值前' . $balance . '元，充值后'.$new."元",
                'encrypt_code'=>"社区余额充值");
            pdo_insert('core_paylog', $paylog);
            $acid=pdo_fetchcolumn("select acid from ".tablename('account')." where uniacid={$params['uniacid']} ");
            $word="恭喜您，余额充值成功!\\n充值前金额：".$balance."元\\n充值后金额：".$new."元";
            load()->classs('weixin.account');
            $accObj= WeixinAccount::create($acid);
            $accObj->sendCustomNotice(array('touser'=>$from_user,'msgtype'=>'text','text'=>array('content'=>urlencode($word)) ));
        }

    }
    public function payresult_renew ($params){
        global $_W;
        $checkReq=$this->checkReq($params);//检查支付日志，防止一分钱漏洞
        if($checkReq==0)return;
        $id=str_replace('renew','',$params['tid']);
        $result=pdo_fetch("select * from ".tablename(RENEW)." where ordersn={$id}  and 
		uniacid={$_W['uniacid']}    and status=0");
        if($result) {
            //查询该用户的续期起始日期
            $shop=SHOP::getShopInfoAll($result['shop_id']);
            if(empty($shop['endtime']))$shop['endtime']= TIMESTAMP;
            $renew=util::getYearStamp();
            $renew= $renew*intval($result['type']);
            $endtime=$shop['endtime']+$renew;
            $member = Member::getUserByid($result['mid']);
            //更新到期日期
            $paytype= $this->paytype($params['type'], $params['paysys']);
            pdo_update(RENEW, array('status' => 1, 'paytype' => $paytype,'starttime' => $shop['endtime'], 'endtime' => $endtime), array('ordersn' => $id, 'uniacid' => $_W['uniacid']));
            pdo_update(SHOP, array('endtime' => $endtime), array('shop_id' => $result['shop_id'], 'uniacid' => $_W['uniacid']));
            if($result['flag']==1) {//续费
                //通知操作人
                $title = '续费';
                $i_item = '恭喜，' . $shop['shop_name'] . $title . '成功';
                $url = Util::createModuleUrl('shop_admin', array('op' => 'renew_re', 'id' => $result['id']));
                $remark = "续费时长：" . $result['type'] . "年";
                $remark .= '\\n';
                $remark .= "有效期至：" . date('Y-m-d ', $endtime);
                Message::ordermessage($member['openid'], $i_item, $url, '商户' . $title, $params['fee'], $remark);//通知用户
                //通知管理员
                $i_item = $shop['shop_name'] . $title . '成功';
                $url = Util::createModuleUrl('admin', array('op' => 'renew', 'id' => $result['id']));
                Message::admin_ordermessage($i_item, $url, '商户' . $title, $params['fee'], $remark);
            }elseif($result['flag']==0) {//入驻
                $url= Util::createModuleUrl('shop_admin',array('shop_id'=>$shop['shop_id'],'op'=>'info','check'=>1));
                $name='店铺入驻';
                $remark = "入驻缴费：" . $params['fee'] . "元";
                Message::admin_checkmsg('有新的商家入驻!',$url,$name,$member['nickname'],TIMESTAMP,$remark);
            }
        }
    }
    public function payresult_shang($params){
        //打赏
        global $_W;
        $order_sn = str_ireplace('shang', '', $params['tid']);
        pdo_update(CASH, array('status' => 1), array('uniacid' => $_W['uniacid'],'cash_ordersn' =>$order_sn));
        //更新用户可提现余额
        $result=pdo_fetch("select * from ".tablename(CASH)." where cash_ordersn=".$order_sn);
       $userinfo =  MEMBER::getSingleUser($result['openid']);
        pdo_update(MEMBER, array('balance'=>($userinfo['balance']+$result['amount'])), array('openid' => $result['openid'], 'uniacid' => $_W['uniacid']));

    }

    public function payresult_redpackage($params){ //抢红包支付
        global $_W;
        $red_id = str_ireplace('redpackage', '', $params['tid']);
        $from_user = $params['user'];
        $uid = mc_openid2uid($from_user);
        pdo_update(REDPACKAGE, array('status' => 1), array('uniacid' => $_W['uniacid'],'red_id' =>$red_id));

    }
    public function payresult_dis($params,$wxapp=0)
    {//优惠买单
        global $_W;
        $checkReq=$this->checkReq($params);
        if($checkReq==0)return;
        $dis_id = str_ireplace('dis', '', $params['tid']);
        $result = commonGetData::getDiscountInfo($dis_id);
        $from_user = $params['user'];
        $uid = mc_openid2uid($from_user);
        if ($result['status'] == 0) {
            $paytype= $this->paytype($params['type'],$params['paysys']);
            pdo_update(DISCOUNT_RE, array('status' => '1','paytype'=>$paytype), array('id' => $dis_id, 'uniacid' => $_W['uniacid']));
            //改变商户可提现余额
            Common::changeShopBalance($result['paymoney'],$result['shop_id']);
            $credit1 = mc_fetch($from_user);
            if ($result['needcredit'] > 0) {
                $new = $credit1 - $result['needcredit'];
                pdo_update('mc_members', array('credit1' => $new), array('uid' => $uid, 'uniacid' => $_W['uniacid']));
                $data = array(
                    'type' => 'credit1',
                    'tid' => date('YmdHis'),
                    'title' => '优惠买单-积分抵扣',
                    'fee' => $result['needcredit'],
                    'user' => $from_user,
                );
                commonGetData::insertlog($data);
            }
            $url = Util::createModuleUrl('user',array('op'=>'mydiscount'));
            $where['id'] = $result['mid'];
            $member = util::getSingelDataInSingleTable(MEMBER, $where, 'openid');
            if($wxapp==0) {
                $i_item = '优惠买单支付成功';
                Message::ordermessage($member['openid'], $i_item, $url, '优惠买单', $result['paymoney']);//通知用户
                // 通知店铺管理员
                Message::shop_dis_ordermessage($result['shop_id'], $url, '优惠买单', $result['paymoney']);
            }
        }
    }


    public function payresult_order($params, $item,$wxapp=0)
    {
        global $_W;
        $checkReq=$this->checkReq($params);
        if($checkReq==0)return;
        load()->model('mc');
        $id = $item['id'];
        $from_user = $params['user'];
        $uid = mc_openid2uid($from_user);
        if ($item['status'] == 0 && $item['price'] == $params['fee']) {
            if ($params['type'] == 'credit') {
                $data = array(
                    'type' => 'credit2',//[credit1] => 积分, [credit2] => 余额
                    'tid' => date('YmdHis'),
                    'title' => '消费',
                    'fee' => $params['fee'],
                    'user' => $from_user,
                );
                commonGetData::insertlog($data);
            }
            //'1为余额，2微信支付，3支付宝，4银行版收银台,5货到付款'
            if ($params['type'] == 'delivery') {//货到付款订单
                $data = array('status' => "0", 'paytype' => "3",);
                $oddata['order_status'] = 0;
            } else {//已付款订单
                $oddata['order_status'] = 1;
                $data = array('status' => $params['result'] == 'success' ? 1 : 0);//1:已付款
                $data['paytype'] = $this->paytype($params['type'], $params['paysys']);
                if ($data['paytype'] == 2) {
                    $data['transid'] = $params['tag']['transaction_id'];
                }

            }
            $data['paytime'] = time();
            //生成二维码
            if ($item['ordertype'] == 1) {
               Order::createQrCodeByorder($item['shop_id'],$item['ordersn'],$id);
            }
            //是新建团单 先获取团id
            $orderinfo = Order::getSingleOrderAndGood($id); //查询订单
            $member=member::getMemberByopenid($item['openid']);
            if ($orderinfo['ordertype'] == 3 && empty($orderinfo['groupid'])) {
                $groupdata = array(
                    'uniacid' => $_W['uniacid'],
                    'shop_id' => $orderinfo['shop_id'],
                    'uid' => $member['id'],
                    'gid' => $orderinfo['gid'],
                    'status' => 1,
                    'fullnumber' => $orderinfo['groupnum'],
                    'lastnumber' => $orderinfo['groupnum'] - 1,
                    'overtime' => $orderinfo['groupendtime'] * 3600 + time(),
                    'createtime' => time(),
                    'createrid' => $orderinfo['userid']
                );
                $res = pdo_insert(GROUP, $groupdata);
                $data['groupid'] = pdo_insertid();
                //如果新建团，直接赋值给订单的groupid 这样如果是参团单的话，下步更新的时候也不会改变值
            }


            $res = pdo_update(ORDER, $data, array('id' => $id, 'uniacid' => $_W['uniacid']));
            $res2 = pdo_update(ORDER_GOODS, $oddata, array('orderid' => $id, 'uniacid' => $_W['uniacid']));
            if ($wxapp == 0) {
                if ($res && $res2) { //发支付成功通知 //发开团成功通知，//发团购快成功的通知
                    $where['orderid'] = $id;
                    $og = util::getSingelDataInSingleTable(ORDER_GOODS, $where, 'goodsid');
                    $ogwhere['goods_id'] = $og['goodsid'];
                    $goods = util::getSingelDataInSingleTable(GOODS, $ogwhere, 'title');
                    $title = $goods['title'];
                    if ($item['m_status'] == 0) {//是否已发通知 ：用于标识，以防数据处理多次
                        if ($orderinfo['ordertype'] == 1) {//普通订单
                            $i_item = '您的订单已支付成功';
                            $url = Util::createModuleUrl('order', array('status' => '1', 'id' => $id));
                            Message::ordermessage($item['openid'], $i_item, $url, $title, $item['price']);//通知用户
                            // 通知店铺管理员
                            Message::shop_ordermessage($item['shop_id'], $id, '有人下单啦');
                        } elseif ($orderinfo['ordertype'] == 2) { //参团订单
                            //更新团信息 剩余人数减1
                            $i_item = '参团成功';
                            $url = Util::createModuleUrl('group', array('op' => 'detail', 'groupid' =>  $orderinfo['groupid']));
                            $res = Util::addOrMinusOrUpdateData(GROUP,
                                array('lastnumber' => -1), $orderinfo['groupid'], 'addorminus');
                            Util::deleteCache('groupmember', $orderinfo['groupid']); //删除成员缓存
                            //判断团是否完成 这里已发参团成功通知 已删除缓存
                            $isfinish = Group::checkGroupIsFinished($orderinfo['groupid'], $orderinfo['openid'], $this, $id, $orderinfo['shop_id']);

                        } elseif ($orderinfo['ordertype'] == 3) {//新开团
                            Message::bmessage($orderinfo['openid'], $this, $orderinfo['title'], $orderinfo['totalmoney'],
                                $orderinfo['groupnum'], $data['groupid']); //发开团成功通知
                        }

                        //更新库存
                        Util::setOrderStock($id);
                        //下级购买通知
                        //Message::sendshopmsg($id);
                        //扣除积分
                        if ($item['deductible'] > 0) {
                            Member::updateUserCredit($uid, -$item['deductible'], 2);
                        }
                        pdo_update(ORDER, array('m_status' => 1,), array('id' => $id, 'uniacid' => $_W['uniacid']));
                    }

                }
            }
        }

    }
    public function checkReq($params){
        $log = Util::getSingelDataInSingleTable('core_paylog', array('module' => 'yc_youliao', 'tid' => $params['tid']));
        if ((!empty($log) && $log['status'] == '1' && $log['fee'] == $params['fee']) || ($params['type'] == "delivery" && $log['fee'] == $params['fee'])) {
            return 1;
        }else{return 0;}
    }
    public function paytype($type,$paysys){//支付标记
        if($paysys=='payms'){
            return 4;
        }else {
            if ($type == 'credit') return 1;
            if ($type == 'wechat') return 2;
            if ($type == 'alipay') return 3;
            if ($type == 'delivery') return 5;
        }
    }

    static function insertlog($order,$goodsTitle){
        global $_W;
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
        return 1;
    }

}