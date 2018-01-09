<?php
global $_W,$_GPC;
$userinfo = Member::initUserInfo(); //用户信息
$op = $_GPC['op'];
$title="售后服务";
$cfg=$this->module['config'];
$shop_cfg=commonGetData::getShopCfg($shop_id);
$noticeid=pdo_fetchcolumn("select count(*) from ".tablename(SHOP_ADMIN)."  where openid='{$_W['openid']}'  and uniacid = " . $_W['uniacid']);
if($op){//ajax请求处理退货退款操作
   return  Order::ajaxrefund($op,$noticeid);
   exit;
}
$ogid = intval($_GPC['ogid']);
$where['id'] = $ogid;
if ($ogid < 0) {
    message('订单不存在', referer(), error);
}
$url=$this->createMobile('refund');
$data = util::getSingelDataInSingleTable(ORDER_GOODS, $where, '*');
if (empty($data)) message('退款已申请或订单不存', referer(), error);
$shop_id = $data['shop_id'];
$refundMoney = $data['price'];
$order_status = $data['order_status'];
$refund_id = $data['refund_id'];
//是否开启退款，商品是可以退款
$where1['goods_id'] = $data['goodsid'];
$goods = util::getSingelDataInSingleTable(GOODS, $where1, 'title');
$orwhere['id'] = $data['orderid'];
$order = util::getSingelDataInSingleTable(ORDER, $orwhere, 'id,ordertype,status,refundmoney,refundtime,ordersn');

$refund =$this->gorefund($goods['iscanrefund'],$data['createtime'],$data['order_status']);
if(($refund!=1 && $order['ordertype']=1) || $order['ordertype']>1 && $order['status']!=4)
    message('该商品不允许退款', $this->createMobileUrl('order', array('id' =>$order['id'])), error);
//申请退款
if ($order_status == 1 || $order_status == 9) {//已支付申请及驳回重新申请

    $refundDetail = $shop_cfg['refundDetail'];
        if (checksubmit('submit')) {
            $req_money = $_GPC['refundMoney'];
            if ($req_money > $refundMoney || $req_money <= 0) {//请求金额小于等于下单金额
                message('退款金额不能大于下单金额且申请金额不能为0', referer(), error);
            }
            $type = intval($_GPC['type']);
            $resean = trim($_GPC['resean']);
            $resn= Util::getordersn(REFUND);

            //改变商品订单状态
            $re_data = array(
                'shop_id' => $shop_id,
                'applytime' => time(),
                'money' => $req_money,
                'ogid' => $ogid,
                'type' => $type,
                'uniacid' => $_W['uniacid'],
                'from_user' => $_W['openid'],
                'goodsid' => $data['goodsid'],
                'ordersn' => $resn,
                'resean' => $resean
            );

            if (empty($refund_id)) {
                pdo_insert(REFUND, $re_data);
                $refund_id = pdo_insertid();
            } else {
                pdo_update(REFUND, $re_data, array('id' => $refund_id,   'shop_id' => $shop_id, 'uniacid' => $_W['uniacid']));
            }
            if ($refund_id) {
                $res = pdo_update(ORDER_GOODS, array('order_status' =>2,
                    'refund_id' => $refund_id), array('id' => $ogid, 'order_status' =>$order_status, 'uniacid' => $_W['uniacid']));

                $res2 = pdo_update(ORDER, array('status' => 4), array('id' => $data['orderid'], 'uniacid' => $_W['uniacid']));
                //发送退款申请通知
                $msgid = commonGetData::gettpl('TM00431');
                $msgid =$msgid['tpl_id'];
                if ($msgid) {
                    $name = $goods['title'];
                    $ordersn = $order['ordersn'];
                    $title = "您的退款申请已通知商家处理，请您耐心等待";
                    $i_item = "";
                    if ($resean) {
                        $i_item .= '退款原因：' . $resean . '\\n';
                    }
                    if ($type == 1) {
                        $i_item .= '退款类型：退货退款 ';
                    } elseif ($type == 2) {
                        $i_item .= '退款类型：仅退款 ';
                    }

                    Message::applyrefund($_W['openid'], $msgid, $title, $ordersn, $req_money, $name, $ogid, $i_item);
                    $noticeid = pdo_fetchall("select openid from " . tablename(SHOP_ADMIN) . "  where msg_flag='0'  and uniacid = " . $_W['uniacid'] ." and admin_type <3 and shop_id = " . $shop_id);
                    if (!empty($noticeid)) {
                        foreach ($noticeid as &$adminid) {
                            $title = "您有新的退款申请，请及时处理";
                            Message::applyrefund($adminid['openid'], $msgid, $title, $ordersn, $req_money, $name, $ogid, $i_item);
                        }
                    }
                }
            }
            message('您的退款申请已提交，请您耐心等待', $this->createMobileUrl('refund', array('ogid' => $ogid)), sucess);
        }


}elseif ($order_status>=2){
    $title="售后服务";
 //已申请退款中，待审批
    $codition['id'] = $refund_id;
    $item = util::getSingelDataInSingleTable(REFUND, $codition, '*');
    if($item['from_user']!=$_W['openid'] && $noticeid<0 )die;
    $goods = util::getSingelDataInSingleTable(GOODS, $where1, 'thumb,title');
    $where2['id'] = $item['addressid'];
    //管理员
    if($noticeid>0){
     $address= $shop_cfg['address'];
     $mobile= $shop_cfg['mobile'];
     $man= $shop_cfg['man'];
    }
}
include $this->template('../mobile/refund');
    exit;