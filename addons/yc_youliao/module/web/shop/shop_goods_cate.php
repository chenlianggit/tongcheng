<?php
global $_GPC, $_W;
$uniacid = $_W['uniacid'];
$modules = 'category';
$op = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$shop_id=getShop_id();
if ($op == 'display') {
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update(GOODS_CATE, array('displayorder' => $displayorder), array('id' => $id));
        }
        $this->message('分类排序更新成功！', $this->createWebUrl('shop_goods_cate', array('op' => 'display')), 'success');
    }
    $category = Goods::getcate($shop_id);
    include $this->template('web/shop/category');
} elseif ($op == 'post') {
    $id 	  = intval($_GPC['id']);
    if (!empty($id)  &&  $shop_id>0)
        $category =Util::getSingelDataInSingleTable(GOODS_CATE,array('id'=>$id,'shop_id'=>$shop_id));
    else
        $category = array('displayorder' => 0,);

    if (checksubmit('submit') && $shop_id>0){
        $resutl=Goods::postCate($shop_id);

        $this->message('更新分类成功！', $this->createWebUrl('shop_goods_cate', array('op' => 'display')), 'success');
    }
    include $this->template('web/shop/category');
} elseif ($op == 'delete') {
    $id = intval($_GPC['id']);
    $category = pdo_fetch("SELECT id FROM " . tablename(GOODS_CATE) . " WHERE id = '$id' and uniacid = '{$_W['uniacid']}'");

    if (empty($category)  && !empty($shop_id)) {
        $this->message('抱歉，分类不存在或是已经被删除！', $this->createWebUrl('shop_goods_cate', array('op' => 'display')), 'error');
    }
    pdo_delete(GOODS_CATE, array('id' => $id), 'OR');
    $this->message('分类删除成功！', $this->createWebUrl('shop_goods_cate', array('op' => 'display')), 'success');
}		