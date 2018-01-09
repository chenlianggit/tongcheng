<?php
global $_GPC,$_W;
$title='社区概览';

$city_id=$this->getAdmin_city_id();
if($city_id>0){
    $cityidWhere['city_id']=$city_id;
    $city_id_condition=" and city_id=".$city_id;
    $ring_condition=" and r.city_id=".$city_id;
}
$city_name=$this->getAdmin_city_name();
if($city_name){
    $infoWhere['city']=$city_name;
    $condition=" and city=".$city_name;

}
//粉丝数量
$fansnum=util::getAllDataNumInSingleTable(MEMBER,'');

//商户数量
$shopnum=util::getAllDataNumInSingleTable(SHOP,$cityidWhere);
//同城信息
$infonum=util::getAllDataNumInSingleTable(INFO, $infoWhere,'2');
//今日
$infotoday=  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']}"
    ." and DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') {$condition}" );
//昨日
$infoyestday =  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']}"
    ." and TO_DAYS( NOW( ) ) - TO_DAYS(DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d')) <= 1 {$condition}" );

for ($i=2; $i<=14; $i++) {
    $name = 'yestdayNum' . $i;
    $$name =  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']}"
        ." and TO_DAYS( NOW( ) ) - TO_DAYS(DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d')) = {$i} {$condition}" );

}
//一周
$infoweek = pdo_fetch('SELECT COUNT(*) as num  FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']}"
    ." and DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d') {$condition}" );
//一月
$infomonth =  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']}"
    ." and DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d') {$condition}" );

//圈子信息
$ringnum=util::getAllDataNumInSingleTable(RING, $cityidWhere);


//商户订单
//今日
$ordertoday=  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}"
    ." and DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d') = DATE_FORMAT(NOW(),'%Y-%m-%d') {$city_id_condition}" );
//昨日
$orderyestday =  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}"
    ." and TO_DAYS( NOW( ) ) - TO_DAYS(DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d')) <= 1 {$city_id_condition}" );

for ($i=2; $i<=14; $i++) {
    $name = 'orderyestdayNum' . $i;
    $$name =  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}"
        ." and TO_DAYS( NOW( ) ) - TO_DAYS(DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d')) = {$i} {$city_id_condition}" );

}
//一周
$orderweek = pdo_fetch('SELECT COUNT(*) as num  FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}"
    ." and DATE_SUB(CURDATE(), INTERVAL 7 DAY) <= DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d') {$city_id_condition}" );
//一月
$ordermonth =  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}"
    ." and DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= DATE_FORMAT(FROM_UNIXTIME(createtime),'%Y-%m-%d') {$city_id_condition}" );

//最新发布内容
$lastedmessagelist = pdo_fetchall('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} {$condition}  ORDER BY createtime DESC LIMIT 10");
foreach ($lastedmessagelist as $k => $v) {
    $module = pdo_fetch('SELECT name FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND id = {$v['mid']}");
    $lastedmessagelist[$k]['con'] = unserialize($v['content']);
    $lastedmessagelist[$k]['modulename'] = $module['name'];
}

$list =commonGetData::getRing(1,$ring_condition,1,10);


include $this->template('web/index');
exit();