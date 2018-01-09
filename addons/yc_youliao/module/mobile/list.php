<?php
global $_GPC,$_W;
$cfg=$this->module['config'];
$shopLogo=tomedia($cfg['shop_logo']);
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$userinfo = Member::initUserInfo(); //用户信息
$pageStart =$this->pageIndex();
$num = $this->getNum(); //每次取值的个数
$joinCity=$this->joinCity();
$cityCondition=$this->getcookieCity();
$joinArea=$this->joinArea();
$condition="";
$codition .=$this->getShopEndtime();
$orderby="orderby";
if($_GPC['type']=="4"){
    $btn ="去拼团";
    $title=$cfg['index_title'].' 全民拼团';
    $adv_type=4;//1首页，4拼团，5秒杀，6首单，7买单，8同城,9附近，10圈子
    $condition.=" and s.is_group=1 and g.is_group=1 and  g.groupnum>0 ";
}elseif($_GPC['type']=="6") {
    $btn ="首单优惠";
    $title=$cfg['index_title'].' 马上下单';
    $adv_type=6;
    $condition.="  and g.isfirstcut >0 ";
}elseif($_GPC['type']=="7") {
    $btn ="去买单";
    $title=$cfg['index_title'].' 优惠买单';
    $adv_type=7;
    $condition.=" and s.is_discount=1 ";
}elseif($_GPC['type']=="9") {
    $btn ="附近";
    $title=$cfg['index_title'].' 附近商圈';
    $adv_type=9;

}else{
    return;
}


$area = $this->getArea();
$business = $this->getBusiness();

$cate = Shop::getccate();
$cate_id=intval($_GPC['cate_id']);
if($cate_id>0){
    $condition.="and s.ccate_id =".$cate_id;
}
$type_id=intval($_GPC['type_id']);
if($_GPC['datatype']=="area"){
    $condition.="and s.area_id =".$type_id;
}elseif($_GPC['datatype']=="business"){
    $condition.="and s.business_id =".$type_id;
}elseif($_GPC['datatype']=="zn"){
    if($type_id==1){
        $orderby="s.dp DESC";
    }elseif($type_id==2){
        $orderby="s.renjun ASC";
    }

}
if($_GPC['type']=="7" || $_GPC['type']=="9") {
    $keyword =$_GPC['keyword'];//关键字搜索
    if($keyword){
        $condition.="and (s.shop_name like '%".$keyword."%' or s.telphone like '%".$keyword."%' or s.address like '%".$keyword."%' )";
    }
    $dis = pdo_fetchall("SELECT s.* FROM " . tablename(SHOP) . " s {$joinArea} WHERE  s.uniacid = '{$_W['uniacid']}'   and s.status =1   {$condition} {$cityCondition} ORDER BY {$orderby} limit {$pageStart},{$num}  ");
    $isgroup = Array();
    foreach ($dis as $k => $arr) {
        $arr['distance'] = util::getDistance($arr['lat'], $arr['lng'], $_COOKIE['lat'], $_COOKIE['lng']);
        $arr['inco'] = json_decode($arr['inco']);
        $isgroup[] = $arr;
    }

    if ($_GPC['datatype'] == "near") {//附近公里
        if($type_id > 0) {
            $near = Array();
            foreach ($isgroup as $k => $arr) {
                if ($arr['distance'] <= $type_id) {
                    $near[] =$arr;
                }
            }
            $isgroup = $near;

        }else{
            $arrSort = array();
            $sort = array(
                'direction' => 'SORT_ASC', //排序顺序标志 SORT_DESC 降序；SORT_ASC 升序
                'field'     => 'distance',       //排序字段
            );
            foreach($isgroup AS $uniqid => $row){
                foreach($row AS $key=>$value){
                    $arrSort[$key][$uniqid] = $value;
                }
            }
            if($sort['direction']){
                array_multisort($arrSort[$sort['field']], constant($sort['direction']), $isgroup);
            }
            $isgroup = $isgroup;

        }
    }


}else{
    $isgroup     = pdo_fetchall("SELECT g.*,s.shop_name FROM " . tablename(GOODS) . " g {$joinCity} WHERE  g.uniacid = '{$_W['uniacid']}'  and s.status=1 and g.status =0   {$condition} {$cityCondition} ORDER BY  g.createtime DESC, sales DESC limit {$pageStart},{$num}  ");
}

//拼团用户头像
if($isgroup && $adv_type==4){
    $data1 =array();
    foreach ($isgroup as $key => $value) {
        $data    = pdo_fetchall("SELECT   distinct(o.openid),og.goodsid, u.avatar  FROM " . tablename(ORDER_GOODS)  .
            "og  left join" . tablename(ORDER)  ."o on og.orderid=o.id and og.uniacid=o.uniacid " .
            "left join" . tablename(MEMBER)  ."u on o.userid=u.id and o.uniacid=u.uniacid " .
            "WHERE og.uniacid = '{$_W['uniacid']}' 
				and og.goodsid='{$value['id']}' 
				and o.status>=1
				ORDER BY o.createtime DESC limit {$pageStart},{$num}");
        $data1[$value['id']]=$data;

    }


}
foreach ($isgroup as $k => $v) {
    $isgroup[$k]['logo']=tomedia($v['logo']);
    $isgroup[$k]['thumb']=tomedia($v['thumb']);
}
if($op=='ajax_req' ){
    if($isgroup){
        echo json_encode(array('status'=>'1','length'=>count($isgroup),'list'=>$isgroup,'data1'=>$data1,'logo'=>$shopLogo));
        exit;
    }else{
        echo json_encode(array('status'=>'0','length'=>0));
        exit;
    }

}


include $this->template('../mobile/list');
exit();