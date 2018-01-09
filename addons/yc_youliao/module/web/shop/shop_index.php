<?php
global $_GPC,$_W;
$title='店铺概览';
$shop_id=getShop_id();
$data=array('shop_id'=>$shop_id);
//会员总数（扫商家二维码）
$memberNum=util::getAllDataNumInSingleTable(SHOP_USER,$data);
//商品总数
$goodNum=util::getAllDataNumInSingleTable(GOODS,$data);
//订单总数（已支付）
$data['status>']=1;
$orderNum=util::getAllDataNumInSingleTable(ORDER,$data);

//订单（图标）
//商户订单
//今日
$ordertoday=  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}"
    ." and DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') " );
//昨日
$orderyestday =  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}"
    ." and TO_DAYS( NOW( ) ) - TO_DAYS(DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d')) <= 1 " );

for ($i=2; $i<=14; $i++) {
    $name = 'orderyestdayNum' . $i;
    $$name =  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}"
        ." and TO_DAYS( NOW( ) ) - TO_DAYS(DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d')) = {$i} " );

}

$list=pdo_fetch('SELECT ordersn,status,createtime,userid FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}" ." and DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') " );
//留言
$remark  = pdo_fetchall("select id, ordersn ,remark from ".tablename(ORDER)." where uniacid =:uniacid  and remark !='' order by id desc limit 5 ", array(':uniacid' => $_W['uniacid']));

include $this->template('web/shop/shop_index');
exit();