<?php
//checkauth();
load()->model('mc');
global $_GPC,$_W;
$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$title=$cfg['index_title']." 订单中心";
$userinfo = Member::initUserInfo(); //用户信息
$from_user=$this->getOpenid();
$credits = commonGetData::getUserCredit($from_user);
$page =$this->getPage();
$num = $this->getNum(); //每次取值的个数
$uniacid=$_W['uniacid'];
$isadmin = $this->checkAdmin();
$isshop_admin = $this->isshop_admin();
$my=intval($_GPC['my']);
if ((empty($isadmin) && empty($isshop_admin)) ) {
    $where['openid'] = $from_user;
}
if($op=="display") {//数据展示
    if ( $my==0) {
        $where['openid'] = $from_user;
    }
    $status=$_GPC['status'];
    if($status=="all")$where['status>']= 0;
    elseif(intval($status>=0))$where['status']= intval($status);
    $data=Order::getorderlist($where,$page,$num);
    $list=$data[0];
    $goods=$data[1];
    if($_GPC['isajax']==1) {
        echo json_encode(array('result' => '1', 'list' => $list, 'length' => count($list)));
        exit;
    }
    include $this->template('../mobile/order');
    exit;
}elseif($op=="detail") {//订单详情
    $id=intval($_GPC['id']);
    $where['id']=$id;
    $item=util::getSingelDataInSingleTable(ORDER,$where);
    $goods=Order::getGoodById($id);
    include $this->template('../mobile/order_detail');
    exit;
}elseif($op=="delete") {//删除订单
    $id = intval($_GPC['id']);
    $where['id']=$id;
    $where['status']=0;
    $item=util::getSingelDataInSingleTable(ORDER,$where);
    if($item){
        $where['status']=0;
        $where['uniacid'] = $_W['uniacid'];
        pdo_delete(ORDER, $where);
        $ogwhere['order_status']=0;
        $ogwhere['uniacid'] = $_W['uniacid'];
        $ogwhere['orderid'] = $id;
        pdo_delete(ORDER_GOODS,$ogwhere);
        echo json_encode(array('status' => '1'));
        exit;
    }else{
        echo json_encode(array('status' => '0'));
        exit;
    }
}

