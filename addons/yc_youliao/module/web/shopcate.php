<?php
global $_GPC,$_W;
$title='店铺分类管理';
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($op == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update(CATE, array('orderby' => $displayorder), array('cate_id' => $id));
        }
        $this->message('分类排序更新成功！', $this->createWebUrl('shopcate', array('op' => 'display')), 'success');
    }
    if(!empty($_GPC['cate_type'])){
        $codition.=" and cate_type=".$_GPC['cate_type'];
    }
    if(!empty($_GPC['keyword'])){
        $codition.=" and cate_name like '%".$_GPC['keyword']."%' ";
        $k=2;
    }
    $children = array();
    $list = pdo_fetchall("SELECT * FROM " . tablename(CATE) . " WHERE uniacid = '{$_W['uniacid']}' {$codition} ORDER BY  orderby DESC");
    foreach ($list as $index => $row) {
        if (!empty($row['parent_id'])) {
            $children[$row['parent_id']][] = $row;
            unset($shopcate[$index]);
        }
    }

} elseif ($op == 'post') {
    $parentid = intval($_GPC['parent_id']);
    $id 	  = intval($_GPC['id']);
    if(!empty($parentid)){
        $condition=" and (parent_id is null or  parent_id=0)";
    }
    $cate = pdo_fetchall("SELECT cate_id,cate_name FROM " . tablename(CATE) . " WHERE uniacid = '{$_W['uniacid']}'  {$condition} ORDER BY  orderby DESC");
    if (!empty($id))
        $shopcate = pdo_fetch(" SELECT * FROM " . tablename(CATE) . " WHERE cate_id = '$id' and uniacid = '{$_W['uniacid']}'");
    else
        $shopcate = array('displayorder' => 0,);
    if (!empty($parentid)) {

        $parent = pdo_fetch("SELECT cate_id,cate_name FROM " . tablename(CATE) . " WHERE cate_id = '$parentid' and uniacid = '{$_W['uniacid']}'");
        if (empty($parent))
            $this->message('抱歉，上级分类不存在或是已经被删除！', $this->createWebUrl('shopcate'), 'error');
    }
    if (checksubmit('submit')) {

        if (empty($_GPC['cate_name'])) {
            $this->message('抱歉，请输入分类名称！');
        }
        $data = array('uniacid' => $_W['uniacid'],
            'cate_name' 	=> $_GPC['cate_name'],
            'orderby' => intval($_GPC['orderby']),
            'title' => $_GPC['title'],
            'parent_id' => intval($parentid),
            'cate_type' => intval($_GPC['cate_type']),//0商铺消费类,1酒店预订,2影院订座,3外卖点餐,4微商城
            'cate_url' => $_GPC['cate_url'],
            'thumb'    =>$_GPC['thumb']
        );
        if ($parentid>0 && $id>0) {
            pdo_update(CATE, $data, array('cate_id' => $id, 'uniacid' => $_W['uniacid']));
        }elseif ( $id>0 && $parentid==0) {
            unset($data['parent_id']);
            pdo_update(CATE, $data, array('cate_id' => $id, 'uniacid' => $_W['uniacid']));
        } else {
            pdo_insert(CATE, $data);
            $id = pdo_insertid();
        }

        $this->message('更新分类成功！', $this->createWebUrl('shopcate', array('op' => 'display')), 'success');
    }

} elseif ($op == 'delete') {
    $id = intval($_GET['id']);
    $category = pdo_fetch("SELECT cate_id FROM " . tablename(CATE) . " WHERE cate_id = '$id' and uniacid = '{$_W['uniacid']}'");

    if (empty($category)) {
        $this->message('抱歉，分类不存在或是已经被删除！', $this->createWebUrl('shopcate', array('op' => 'display')), 'error');
    }
    pdo_delete(CATE, array('cate_id' => $id, 'parent_id' => $id), 'OR');
    $this->message('分类删除成功！', $this->createWebUrl('shopcate', array('op' => 'display')), 'success');
}
include $this->template('web/shopcate');
exit();