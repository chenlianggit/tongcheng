<?php
clear_cook();
global $_GPC,$_W;
$title='资金管理';
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$pindex    = $this->getWebPage();
$psize     = $this->getWebNum();
$shop_where['shop_id>']=0;
$search_type=3;
$shop=util::getAllDataBySingleTable(SHOP,array(status=>1),'shop_id,shop_name');
$starttime = strtotime($_GPC['time']['start']);
$endtime   = strtotime($_GPC['time']['end']);
$sqlwhere='';
$shop_id=intval($_GET['shop_id']);
if($shop_id){
    $sqlwhere.=" and shop_id =".$shop_id;
}
if($op=='display'){

    if($starttime){
        $sqlwhere.=' and createtime >='.$starttime;
    }
    if($endtime){
        $sqlwhere.=' and createtime <='.$endtime;
    }
    if($_GPC['ordersn']){
        $sqlwhere.=" and ordersn LIKE '%{$_GPC['ordersn']}%'";
    }

    //订单记录
    $list = pdo_fetchall('SELECT * FROM ' . tablename(ORDER_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlwhere} ORDER BY id DESC LIMIT  {$pindex},{$psize } ");
    $total= pdo_fetchcolumn('SELECT count(*) FROM ' . tablename(ORDER_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlwhere}  ");
    $pager=pagination($total, $pindex, $psize);


     //买单记录
    $sqlwhere.=' and status=1';
    $list2 = pdo_fetchall('SELECT * FROM ' . tablename(DISCOUNT_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlwhere} ORDER BY id DESC LIMIT  {$pindex},{$psize} ");
    $total2= pdo_fetchcolumn('SELECT count(*) FROM ' . tablename(DISCOUNT_RE) . " WHERE uniacid = {$_W['uniacid']}   {$sqlwhere}  ");
    $pager2=pagination($total2, $pindex, $psize);


}elseif($op=='record'){
    if($starttime){
        $sqlwhere.=' and addtime >='.$starttime;
    }
    if($endtime){
        $sqlwhere.=' and addtime <='.$endtime;
    }
    if($_GPC['ordersn']){
        $sqlwhere.=" and ordersn LIKE '%{$_GPC['ordersn']}%'";
    }

    $list =Shop::getSingleAccount('',0,$sqlwhere);



}elseif($op=='check_post'){
    $status = intval($_GPC['status']);
    $list=Admin::getAccount_applay('',$status,$pindex,$psize,$sqlwhere);
}elseif($op=='detail'){
    $id = intval($_GPC['cash_id']);
    $item=commonGetData::getAccountDetail($id);
}
include $this->template('web/account');
exit();