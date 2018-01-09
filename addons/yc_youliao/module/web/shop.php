<?php
global $_GPC,$_W;
$title='店铺管理';
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$check=$_GPC['check'];
clear_cook();
$_SESSION['admin_type']  = 'Y';
$page =$this->getWebPage();
$num = $this->getNum(); //每次取值的个数
if ($op == 'display') {

    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update(SHOP, array('orderby' => $displayorder), array('shop_id' => $id));
        }
        $this->message('排序更新成功！', $this->createWebUrl('shop', array('op' => 'display')), 'success');
    }
    if(!empty($_GPC['cate_type'])){
        $codition.=" and s.cate_type=".$_GPC['cate_type'];
    }
    if(!empty($_GPC['keyword'])){
        $codition.=" and s.shop_name like '%".$_GPC['keyword']."%' ";
        $k=2;
    }
    $type=intval($_GPC['type']);
    if($type==1){
        $codition.=$this->getShopEndtime(2);
    }else{
        $codition.=$this->getShopEndtime();
    }
    if($check=="1"){
        $data=commonGetData::getShop_apply($page,$num);
        $list =$data[0];
        $pager=pagination($data[1], $page, $num);
    }else{
        $codition.=" and (s.status=1 or s.status=3)  ";//status:0未审核1成功入驻2未通过3暂停中  f_type:0无申请 1入驻申请，2首页推荐，3秒杀，4拼团，5优惠买单,6店铺开启
        $list =commonGetData:: getShop($codition, $page, $num,'2');
        $total =commonGetData:: getShop($codition);
        $pager=pagination(count($total), $_GPC['page'], $num);


    }



} elseif ($op == 'delete') {
    $id = $_GPC['shop_id'];
    pdo_delete(SHOP_APPLY, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    $codition.=" and shop_id=".$id;
    $list =commonGetData:: getShop($codition);
    if(!empty($list)){
        pdo_delete(SHOP, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
        pdo_delete(SHOP_ADMIN, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
        pdo_update(GOODS, array('status' => 1, 'uniacid' => $_W['uniacid']), array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
        $this->message('删除成功！', $this->createWebUrl('shop', array('op' => 'display')), 'success');
    }

    $this->message('数据不存在或已删除,请您刷新后重试！', $this->createWebUrl('shop', array('op' => 'display')), 'success');
}elseif ($op == 'check') {
    $id = intval($_GPC['shop_id']);
    $opt = intval($_GPC['opt']);
    $data = array('status' => $opt);
    pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    //删除申请
    pdo_delete(SHOP_APPLY, array('shop_id' => $id,'f_type' => '1','uniacid' => $_W['uniacid']));
    if($opt==1){
        $info="审核通过";
    } else{
        $info="审核不通过";
    }
    $this->message($info, $this->createWebUrl('shop', array('check' => '1')), 'success');
}elseif ($op == 'is_hot') {
    $id = intval($_GPC['shop_id']);
    $opt= intval($_GPC['opt']);
    $data = array('is_hot' => $opt);
    pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    if($opt==1)$info="开启";
    else $info="关闭";
    $this->message($info.'成功！', $this->createWebUrl('shop', array('op' => 'display')), 'success');
}elseif ($op == 'is_group') {
    $id = intval($_GPC['shop_id']);
    $opt= intval($_GPC['opt']);
    $data = array('is_group' => $opt);
    pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    if($opt==1)$info="开启";
    else $info="关闭";
    $this->message($info.'成功！', $this->createWebUrl('shop', array('op' => 'display')), 'success');
}elseif ($op == 'is_discount') {
    $id = intval($_GPC['shop_id']);
    $opt= intval($_GPC['opt']);
    $data = array('is_discount' => $opt);
    pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    if($opt==1)$info="开启";
    else $info="关闭";
    $this->message($info.'成功！', $this->createWebUrl('shop', array('op' => 'display')), 'success');
}


include $this->template('web/shop');
exit();