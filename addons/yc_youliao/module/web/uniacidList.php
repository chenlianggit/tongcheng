<?php
global $_GPC,$_W;
$title='选择公众号';
//wq系统账户
if($_GPC['ac']=='change'  ){
    isetcookie('__uniacid', $_GPC['uniacid'], 7 * 86400);
    isetcookie('__uid', $_W['uid'], 7 * 86400);
    $_SESSION['uniacid']      = $_GPC['uniacid'];

    header("Location:".$this->createWebUrl("index") );
    exit();
}
if (!empty($_W['isfounder'])) {
    $condition .= " WHERE a.default_acid <> 0 AND b.isdeleted <> 1";
    $order_by = " ORDER BY a.`rank` DESC";
} else {
    $condition .= "LEFT JOIN ". tablename('uni_account_users')." as c ON a.uniacid = c.uniacid WHERE a.default_acid <> 0 AND c.uid = :uid AND b.isdeleted <> 1";
    $pars[':uid'] = $_W['uid'];
    $order_by = " ORDER BY c.`rank` DESC";
}


$tsql = "SELECT COUNT(*) FROM " . tablename('uni_account'). " as a LEFT JOIN". tablename('account'). " as b ON a.default_acid = b.acid {$condition} {$order_by}, a.`uniacid` DESC";
$total = pdo_fetchcolumn($tsql, $pars);
$sql = "SELECT * FROM ". tablename('uni_account'). " as a LEFT JOIN". tablename('account'). " as b ON a.default_acid = b.acid  {$condition} {$order_by}, a.`uniacid` DESC ";
$pager = pagination($total, $pindex, $psize);
$list = pdo_fetchall($sql, $pars);
if(!empty($list)) {
    foreach($list as $unia => &$account) {
        $account['details'] = uni_accounts($account['uniacid']);
        $account['role'] = uni_permission($_W['uid'], $account['uniacid']);
        $account['setmeal'] = uni_setmeal($account['uniacid']);
    }
}


include $this->template('web/uniacidList');
exit();