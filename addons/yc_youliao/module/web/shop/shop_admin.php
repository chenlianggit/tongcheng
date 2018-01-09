<?php
global $_GPC,$_W;
$title='店铺管理员';
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$admin_flag=1;
$Admin = new Admin();
$shop_id=getShop_id();
$g=getAdmin_type();
if ($g!= 1 &&  $g!="Y"){$this->message('您没有访问权限', referer(), 'error');}
if ($op == 'display') {

    if(!empty($_GPC['status'])){
        $codition.=" and status=".$_GPC['status'];
    }
    $list =$Admin->getShopAdminAll($shop_id);

} elseif ($op == 'post') {
    $admin_id = intval($_GPC['admin_id']);
    if(!empty($admin_id)){
        $item = $Admin::getShop_adminByid($shop_id,$admin_id);

    }
    if (checksubmit('submit')) {
        $res=$Admin::postAdmin($shop_id);
        $res1=intval($res);
        if($res1==0){
            $this->message($res, referer(), 'error');
        }else{
            $this->message('操作成功！', $this->createWebUrl('shop_admin', array('op' => 'display')), 'success');
        }

    }

}elseif ($op == 'delete') {
    $id = intval($_GPC['admin_id']);
    pdo_delete(SHOP_ADMIN, array('admin_id' => $id,'uniacid'=>$_W['uniacid'],'shop_id'=>$shop_id));
    $this->message('删除成功！', $this->createWebUrl('shop_admin', array('op' => 'display')), 'success');
}elseif ($op == 'query') {
    $ds=Member::searchMember();
    //print_r($ds);
    include $this->template('web/shop/shop_admin_query');
    exit;

}

include $this->template('web/shop/shop_admin');
exit();
