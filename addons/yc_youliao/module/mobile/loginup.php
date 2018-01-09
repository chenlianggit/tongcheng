<?php
global $_GPC,$_W;
$admin = new Admin();
if(!empty($_GPC['username']) && !empty($_GPC['password'])) {

    $result = $admin->adminLogin($_GPC['username'], $_GPC['password']);
    if ($result['errcode'] == 1) {//登录失败
        message($result['msg'], referer(), 'error');
        exit();
    } elseif ($result['errcode'] == 0) {//登录成功
        $shop_id=getShop_id();
        if(!empty($shop_id) || $shop_id!=0 ){
            header("Location:" . $_W['siteroot'] . 'web/' . $this->createWebUrl("shop_index"));
        }else{
            header("Location:" . $_W['siteroot'] . 'web/' . $this->createWebUrl("uniacidList"));
        }
        exit();

    }
}else{
   message('用户名或密码不能为空',referer(), 'error');
}