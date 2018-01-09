<?php
global $_GPC,$_W;
$title='基础设置';
$shop_id=getShop_id();
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'basic';
$g=getAdmin_type();
if ($g!= 1 &&  $g!="Y"){$this->message('您没有访问权限', referer(), 'error');}
$shop_where['shop_id']=$shop_id;
if($op=='basic'){
    $settings= commonGetData::getShopCfg($shop_id);
    if (checksubmit()) {
        $data['cfg'] = serialize($_POST);
        if (!empty($settings)) {
            pdo_update(CFG,$data,array('shop_id'=>$shop_id, 'uniacid'=> $_W['uniacid']));
        }else{
            $data['shop_id']=$shop_id;
            $data['uniacid'] =$_W['uniacid'];
            pdo_insert(CFG, $data);

        }
        $this->message('操作成功', referer(), 'error');
    }
}

include $this->template('web/shop/shop_setting');
exit();