<?php
global $_GPC,$_W;
$title='功能列表';
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$shop_id=getShop_id();
$item = Shop::getShopInfo($shop_id);
if($op=="post"){
    $f_type     =  $_GPC['f_type'];
    $scount= Shop::getApplynum($shop_id,$f_type);
    if ($scount > 0) {
        $this->message('您已提交过申请，请您等候处理', referer(), 'error');
    }
    $data = array(
        'uniacid' => $_W['uniacid'],
        'shop_id' => $shop_id,
        'f_type' =>  $f_type,
        'applytime' =>  TIMESTAMP );
    pdo_insert(SHOP_APPLY, $data);
    $this->message('申请已提交,请您耐心等待', referer(),'success');
}
include $this->template('web/shop/shop_fun');
exit();