<?php
global $_W, $_GPC;
$title="圈子管理";
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    if (!empty($_GPC['akid'])) {
        if($_GPC['alldel'] == 'alldel'){
            foreach ($_GPC['akid'] as $id => $akid) {
                pdo_delete(RING, array('ring_id' => $id, 'uniacid' => $_W['uniacid']));
                pdo_delete(ZAN, array('ring_id' => $id, 'uniacid' => $_W['uniacid']));
            }
            $this->message('信息删除成功！', $this->createWebUrl('info', array('op' => 'display')), 'success');
        }
    }
    $ring_condition='';
    if (!empty($_GPC['keyword'])) {
        $ring_condition.= " AND r.info LIKE '%{$_GPC['keyword']}%'";
    }
    if (!empty($_GPC['time'])) {
        $ring_condition.= " and r.addtime >=" . strtotime($_GPC['time']['start']) . " and r.addtime <=" . strtotime($_GPC['time']['end']) . " ";
    }
    $city_id=$this->getAdmin_city_id();
    if($city_id>0){
        $ring_condition.=" and r.city_id=".$city_id;
    }
    $page = $this->getPage();
    $pageindex = $this->getWebPage();
    $num = $this->getNum(); //每次取值的个数
    $area=commonGetData::getArea($city_id);
    $list =commonGetData::getRing(1,$ring_condition,$pageindex,$num);
    $total=commonGetData::getRingNum($condition);
	$pager = pagination($total, $page, $num);

}elseif ($operation == 'post') {
	$id = intval($_GPC['id']);
    $city_id=$this->getAdmin_city_id();
    if($city_id>0){
        $ring_condition=" and r.city_id=".$city_id;
    }
    $ring_condition .=" and r.ring_id=".$id;
    $ring_data=commonGetData::getRing(1,$ring_condition,0,1);
    $item =$ring_data[0];
} elseif ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$message = pdo_fetch("SELECT ring_id FROM ".tablename(RING)." WHERE ring_id = {$id} AND uniacid= {$_W['uniacid']}");
	if (empty($message)) {
        $this->message('抱歉，信息不存在或是已经被删除！', $this->createWebUrl('ring', array('op' => 'display')), 'error');
	}
	pdo_delete(RING, array('ring_id' => $id));
    $message = pdo_fetchall("SELECT ring_id FROM ".tablename(ZAN)." WHERE ring_id = {$id} AND uniacid= {$_W['uniacid']}");
    if($message){
        pdo_delete(ZAN, array('ring_id' => $id));
    }
    $this->message('信息删除成功！', $this->createWebUrl('ring', array('op' => 'display')), 'success');
}elseif ($operation == 'deleteP') {
    $id = intval($_GPC['id']);
    $zid = intval($_GPC['zid']);
    $message = pdo_fetchall("SELECT ring_id FROM ".tablename(ZAN)." WHERE zan_id = {$zid} AND uniacid= {$_W['uniacid']}");
    if($message){
        pdo_delete(ZAN, array('zan_id' => $zid));
    }
    $this->message('评论删除成功！', $this->createWebUrl('ring', array('op' => 'post','id' => $id)), 'success');
}else{
	$this->message('请求方式不存在');
}
include $this->template('web/ring');


exit;
?>