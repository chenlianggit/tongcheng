<?php
global $_GPC,$_W;
$title='店铺管理';
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$id 	  = intval($_GPC['shop_id']);
$shop =Shop::getShopInfo($shop_id);
setShop_id($shop_id);
setShop_name($shop['shop_name']);
setShop_logo($shop['logo']);
if ($op == 'post') {
    $parentid = intval($_GPC['parent_id']);

    if(empty($id)){
        $id=getShop_id();
    }
    $children = array();
    $cate = Shop::getCate();
    $ccate = Shop::getCcate();
    $city =Shop::getCity();
    $area = Shop::getArea();
    $business =Shop::getBusiness();
    if (!empty($id) && $_GPC['add']!='1')
        $item = Shop::getShopInfo($id);
        if(!empty($item['qr_code'])){
            $item['qr_code'] = json_decode($item['qr_code'],true);
        }
    else
        $shopcate = array('displayorder' => 0,);
    if (!empty($parentid)) {

        $parent = pdo_fetch("SELECT cate_id,cate_name FROM " . tablename(SHOP) . " WHERE cate_id = '$parentid' and uniacid = '{$_W['uniacid']}'");
        if (empty($parent))
            $this->message('抱歉，上级分类不存在或是已经被删除！', referer(), 'error');
    }
    if (checksubmit('submit')) {
        foreach($_GPC['qr_code'] as $k => &$v ){

            if(preg_match_all('/^&#039/', $v)){
                unset($_GPC['qr_code'][$k]);
            }
            if(preg_match_all('/^images/', $v)){
                $v = 'https://'.$_SERVER['HTTP_HOST'].'/attachment/'.$v;
            }
        }

        if (empty($_GPC['shop_name']))     $this->message('店铺名称不能为空！');
        if (empty($_GPC['lng']) || empty($_GPC['lat']) )     $this->message('店铺坐标不能为空！');
        $data = array('uniacid' => $_W['uniacid'],
            'shop_name' 	=> $_GPC['shop_name'],
            'city_id' => intval($_GPC['city_id']),
            'area_id' => intval($_GPC['area_id']),
            'business_id' => intval($_GPC['business_id']),
            'pcate_id' => intval($_GPC['pcate_id']),
            'ccate_id' => intval($_GPC['ccate_id']),
            'lng' => $_GPC['lng'],
            'lat' => $_GPC['lat'],
            'logo' => $_GPC['logo'],
            'shop_cert' => $_GPC['shop_cert'],
            'bgpic' => $_GPC['bgpic'],
            'telphone'    =>$_GPC['telphone'],
            'manage' => $_GPC['manage'],
            'starttime' =>TIMESTAMP,
            'renjun' => $_GPC['renjun'],
            'intro' => trim($_GPC['intro']),
            'inco'=>json_encode( iunserializer($_GPC['inco'])),//商品标签
            'opendtime' => $_GPC['opendtime'],
            'address' => $_GPC['address'],
            'closetime' => $_GPC['closetime'],
            'qr_code'   =>json_encode($_GPC['qr_code']),

        );
        $t=getAdmin_type();
        if ($t== 'Y'){
            $renew=util::getYearStamp();
            $data2 = array(
                'endtime' => strtotime($_GPC['endtime'])+$renew,
                'rate' => $_GPC['rate'],
                'status' => 1,
                'orderby' => intval($_GPC['orderby']),
                'dp' => intval($_GPC['dp']),//点评满分5分
            );
            $data= array_merge($data,$data2);
        }
        if (!empty($id)) {
            unset($data['parent_id']);
            unset($data['starttime']);
            pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
        } else {
            pdo_insert(SHOP, $data);
            $id = pdo_insertid();
        }
        $this->message('操作成功！', referer(), 'success');
    }
    include $this->template('web/shop/shop_info');
    exit();
}
