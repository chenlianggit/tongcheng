<?php
global $_GPC,$_W;
$title='区域管理';
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($op == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update(AREA, array('orderby' => $displayorder), array('area_id' => $id));
        }
        $this->message('排序更新成功！', $this->createWebUrl('area', array('op' => 'display')), 'success');
    }
    if(!empty($_GPC['keyword'])){
        $codition=" and area_name like '%".$_GPC['keyword']."%' ";
        $k=2;
    }
    $children = array();
    $list = pdo_fetchall("SELECT * FROM " . tablename(AREA) . " WHERE uniacid = '{$_W['uniacid']}' {$codition} ORDER BY orderby DESC");
    foreach ($list as $index => $row) {
        if (!empty($row['parent_id'])) {
            $children[$row['parent_id']][] = $row;
            unset($shopcate[$index]);
        }
    }
    $page =$this->getPage();
    $num = $this->getNum(); //每次取值的个数
    $total=count( $list);
    $pager = pagination($total, $page, $num);
} elseif ($op == 'post') {
    $parentid = intval($_GPC['parent_id']);
    $id 	  = intval($_GPC['area_id']);
    $city_id 	  = intval($_GPC['city_id']);
    $city = pdo_fetchall(" SELECT * FROM " . tablename(CITY) . " WHERE  uniacid = '{$_W['uniacid']}' ORDER BY  orderby asc");
    if( !empty($city_id) && $city_id !=0){
        $condition=" and city_id=".$city_id;
    }
    if( !empty($parentid) && $parentid !=0){
        $condition .=" and area_id=".$parentid;
    }
    $area =commonGetData::getArea($city_id);;

    if (!empty($id))
        $item = pdo_fetch(" SELECT * FROM " . tablename(AREA) . " WHERE area_id = '$id' and uniacid = '{$_W['uniacid']}'");
    else
        $item = array('displayorder' => 0,);
    if (!empty($parentid)) {

        $parent = pdo_fetch("SELECT area_id,area_name FROM " . tablename(AREA) . " WHERE area_id = '$parentid' and uniacid = '{$_W['uniacid']}'");
        if (empty($parent))
            $this->message('抱歉，区域不存在或是已经被删除！', $this->createWebUrl('area'), 'error');
    }
    if (checksubmit('submit')) {

        if (empty($_GPC['area_name'])) {
            $this->message('抱歉，请输入分类名称！');
        }
        $data = array('uniacid' => $_W['uniacid'],
            'city_id' 	=> $_GPC['city_id'],
            'area_name' 	=> $_GPC['area_name'],
            'orderby' => intval($_GPC['orderby']),
            'parent_id' => intval($parentid),
            'is_hot'    =>intval($_GPC['is_hot'])
        );
        if (!empty($id)) {
            unset($data['parent_id']);
            pdo_update(AREA, $data, array('area_id' => $id, 'uniacid' => $_W['uniacid']));
        } else {
            pdo_insert(AREA, $data);
            $id = pdo_insertid();
        }
        $this->message('操作成功！', $this->createWebUrl('area', array('op' => 'display')), 'success');
    }

} elseif ($op == 'delete') {
    $id = intval($_GPC['area_id']);
    $category = pdo_fetch("SELECT area_id, parent_id FROM " . tablename(AREA) . " WHERE area_id = '$id' and uniacid = '{$_W['uniacid']}'");

    if (empty($category)) {
        $this->message('区域不存在或是已经被删除！', $this->createWebUrl('area', array('op' => 'display')), 'error');
    }
    pdo_delete(AREA, array('area_id' => $id, 'parent_id' => $id), 'OR');
    $this->message('删除成功！', $this->createWebUrl('area', array('op' => 'display')), 'success');
}
include $this->template('web/area');
exit();