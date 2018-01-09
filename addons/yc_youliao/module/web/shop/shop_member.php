<?php
global $_GPC,$_W;
$title='管理员';
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$page =$this->getPage();
$num = $this->getNum(); //每次取值的个数
$shop_id=getShop_id();
if ($op == 'display') {
    $where['uniacid']=$_W['uniacid'];
    $where['shop_id']=$shop_id;
    if ($_GPC['submit'] == '搜索') {
        if ($_GPC['mobile']) {
            $mobile = $_GPC['mobile'];
            $where['mobile@'] = $_GPC['mobile'];
        }
        if ($_GPC['nickname']) {
            $nickname= $_GPC['nickname'];
            $where['nickname@'] = $_GPC['nickname'];
        }

    }
    $arr =util::getAllDataInSingleTable(MEMBER,$where,$page,$num);
    $pager=$arr[1];
    $total=$arr[2];
    $data=$arr[0];
    $list=array();
    foreach ($data as $k => $v) {
        $credits = commonGetData::getUserCreditList($v['openid']);
        $v['credit'] = $credits['credit1'];
        $v['balance'] = $credits['credit2'];
        $list[] = $v;
    }
}

include $this->template('web/shop/shop_member');
exit();
