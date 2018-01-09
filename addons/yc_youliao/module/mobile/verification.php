<?php 
//核销
$userinfo = Member::initUserInfo(); //用户信息
global $_W, $_GPC;
$openid    = $_W['openid'];
$uniacid   = $_W["uniacid"];
$shop_id=intval( $_GPC['shop_id']);
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$saler     = pdo_fetch("select * from " . tablename(SHOP_ADMIN) . " where openid=:openid and uniacid=:uniacid  and shop_id=:shop_id limit 1", array(
    ":uniacid" => $_W["uniacid"],
    ":openid" => $openid,
    ":shop_id" => $shop_id,
));


if (empty($saler)) {
    $url=$this->createMobileUrl('index');
    $this-> messageresult("您没有核销权限",$url);
}
$oid  = $_GPC["oid"];
$ostr   =explode('_',$oid);
$ordersn   =$ostr[0];
$ogid   =$ostr[1];
$qrcode  = $_GPC["qrcode"];
if(!empty($qrcode) ) {//qrcode 核销码核销
        $g = pdo_fetch("SELECT g.*,og.id as ogid,og.qr_code,og.orderid,og.order_status,og.verified,og.verifyopenid,og.verifytime FROM " . tablename(GOODS) . "g 
      left join" . tablename(ORDER_GOODS) . " og on og.goodsid=g.goods_id and og.uniacid= g.uniacid " .
            " left join" . tablename(ORDER) . " o on og.orderid=o.id and og.uniacid= o.uniacid " .
            "WHERE og.qr_code_str = :qr_code_str and o.uniacid=:uniacid", array(
            ':qr_code_str' => $qrcode,
            ":uniacid" => $uniacid));

        $item=$order = pdo_fetch("select * from " . tablename(ORDER) . " where id=:id and uniacid=:uniacid and shop_id=:shop_id  limit 1", array(
            ":id" => $g['orderid'],
            ":shop_id" => $saler['shop_id'],
            ":uniacid" => $uniacid
        ));
    $ogid   =$g['ogid'];
}else{
    $order = pdo_fetch("select * from " . tablename(ORDER) . " where ordersn=:ordersn and uniacid=:uniacid and shop_id=:shop_id   limit 1", array(
        ":ordersn" => $ordersn,
        ":shop_id" => $saler['shop_id'],
        ":uniacid" => $uniacid
    ));

    $item =$order ;
    $g = pdo_fetch("SELECT g.*,og.qr_code,og.order_status,og.verified,og.verifyopenid,og.verifytime FROM " . tablename(GOODS) . "g 
      left join" . tablename(ORDER_GOODS) . " og on og.goodsid=g.goods_id and og.uniacid= g.uniacid " .
    " left join" . tablename(ORDER) . " o on og.orderid=o.id and og.uniacid= o.uniacid " .
     "WHERE og.id = :id and o.uniacid=:uniacid", array(
        ':id' => $ogid,
         ":uniacid" => $uniacid));
}
if (empty($order)||empty($order['price'])) {
    $url=$this->createMobileUrl('index');
    $this-> messageresult("订单不存在",$url);
}
$orderid=$order['id'];
if($op=="submit"){
    if ($order["status"] !=1) {
        $url=$this->createMobileUrl('shop_admin');
        $this-> messageresult("订单必须为已付款或未完成状态",$url);
    }

    if (intval($g["verified"])!=0) {
        $url=$this->createMobileUrl('shop_admin');
        $this-> messageresult("订单此已核销，无需要重复核",$url);
    }


    $time = time();
    pdo_update(ORDER_GOODS, array(
        "order_status" => 3,
        "verifytime" => $time,
        "verified" => 1,
        "verifyopenid" => $openid,
        "qr_code" => '',
        "qr_code_str" => '',
    ), array(
        "id" => $ogid,
        "uniacid" => $_W["uniacid"],
    ));
    //查询是否还有未核销的订单商品，如果没有，更新order表里的状态
     $nowdata=util::getSingelDataInSingleTable(ORDER_GOODS,array("orderid" => $orderid,"order_status" => 1));

        if(empty($nowdata)){
            pdo_update(ORDER, array(
                "status" => 3,
            ), array(
                "id" =>  $orderid,
                "uniacid" => $_W["uniacid"],
            ));
        }
    load()->func('file');
    file_delete($g['qr_code']); //已核销成功，则删除二维码图片
        $url= $this->createMobileUrl('order',array('op'=>'detail','shop_id'=>$shop_id,'id'=>$orderid));
        $this-> messageresult("订单核销成功",$url,1,'success');
}
include $this->template('../mobile/verification');
exit;