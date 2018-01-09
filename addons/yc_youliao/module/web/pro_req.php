<?php
global $_GPC,$_W;
$shop_id=intval($_GPC['shop_id']);

if($shop_id!=0) {
    $shop =Shop::getShopInfo($shop_id);
    setShop_id($shop_id);
    setShop_name($shop['shop_name']);
    setShop_logo($shop['logo']);
    setIs_discount($shop['is_discount']);
    setIs_group($shop['is_group']);
    setIs_time($shop['is_time']);
    setIs_hot($shop['is_hot']);
    header("Location:" . $_W['siteroot'] . 'web/' . $this->createWebUrl("shop_index").'&shop_id='.$shop_id);

}else{
    include $this->template('error');
    exit;
}
