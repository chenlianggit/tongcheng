<?php
global $_GPC,$_W;
$title='区域管理';
$class_dao_adv = D('City');
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op == 'display'){
    $name     = $_GPC['keyword'];
    if($name){
        $params[":name"]     = $name;
        $result = $class_dao_adv->getList($params);
    }else{
        $result = $class_dao_adv->dataList(false);
    }

    $list   = $result['list'];
    if (!empty($_GPC['displayorder'])) {
        foreach ($_GPC['displayorder'] as $id => $displayorder) {
            pdo_update(CITY, array('orderby' => $displayorder), array('city_id' => $id));
        }
        $this->message('排序更新成功！', $this->createWebUrl('city', array('op' => 'display')), 'success');
    }

}elseif($op == 'edit'){
    $id     = intval($_GPC['id']);
    if($id){
        $city = $class_dao_adv->dataEdit($id);
    }
    if(checksubmit('submit')){
        $name     =  $_GPC['name'];
        if(empty($name)){
            $this->message('分类名称不能为空', 'error');
        }
        $in  =  getNewUpdateData($_GPC,$class_dao_adv);
        if ($id) {
            $class_dao_adv->dataEdit($id,$in);
            $dec="更新成功";
        }else{
            $id = $class_dao_adv->dataAdd($in);
            $dec="增加成功";
        }

        $this->message($dec, $this->createWebUrl('city', array('op' => 'display')), 'success');
    }

} elseif ($op == 'delete') {
    $id  = intval($_GPC['id']);
    if($id){
        $class_dao_adv->delete(array($class_dao_adv->city_id=>$id));
    }
    $this->message('删除成功！', $this->createWebUrl('city', array('op' => 'display')), 'success');
}

include $this->template('web/city');
exit();