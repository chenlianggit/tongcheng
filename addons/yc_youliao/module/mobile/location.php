<?php
global $_GPC,$_W;
$title = '城市切换';
$op     =  $_GPC['op'] ;
if($op=='change'){
    $city_id=intval($_GPC['city_id']);
    $area_id=intval($_GPC['area_id']);
    $city_name = $_GPC['city_name'];
    $district= $_GPC['area_name'];
    if ($city_id > 0 || $city_id>0 ) {
        if ($city_id > 0 && !empty($city_name) ) {
            setcookie('area_id', '', time() - 3600 * 24 * 7);
            setcookie('district', '', time() - 3600 * 24 * 7);
        }
        if ($city_id > 0 &&  $area_id>0 && !empty($city_name)  && !empty($district) ) {
            setcookie('area_id', $area_id, time() + 3600 * 24 * 7);
            setcookie('district', $district, time() + 3600 * 24 * 7);
        }
        $city = Util::getSingelDataInSingleTable(CITY, array('city_id' => $city_id, 'uniacid' => $_W['uniacid']));
        setcookie('city_id', $city['city_id'], time() + 3600 * 24 * 7);
        setcookie('city_name',  $city['name'], time() + 3600 * 24 * 7);
        setcookie('lat', $city['lat'], time() + 3600 * 24 * 7);
        setcookie('lng', $city['lng'], time() + 3600 * 24 * 7);

    }
    echo json_encode(array('status' => '1'));
    exit;
}
$firstz = array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z');

$hotcitys =pdo_fetchall('SELECT a.area_id,a.area_name,c.city_id,c.name FROM ' . tablename(AREA) . " a left join ". tablename(CITY) . " c on a.city_id=c.city_id WHERE a.uniacid = {$_W['uniacid']} AND  a.is_hot=1 AND a.parent_id=0 order by a.orderby");
$allcitys = array();
foreach ($firstz as $k => $v) {

        $citylist = pdo_fetchall('SELECT city_id,name FROM ' . tablename(CITY) . " WHERE uniacid = {$_W['uniacid']} AND  first_letter = '{$v}' order by add_time,orderby");

        if (empty($citylist)) {
            unset($firstz[$k]);
        } else {
            foreach ($citylist as $kk => $vv) {
                $citylist[$kk]['name'] = $vv['name'];
                $citylist[$kk]['city_id'] = $vv['city_id'];
                $arealist = pdo_fetchall('SELECT area_id,area_name FROM ' . tablename(AREA) . " WHERE uniacid = {$_W['uniacid']} AND parent_id=0 AND city_id = '{$vv['city_id']}' order by orderby");
                $citylist[$kk]['area'] = $arealist;
            }


            $allcitys[$k]['citys'] = $citylist;
            $allcitys[$k]['zimu'] = $v;
        }


}

include $this->template('../mobile/location');
exit();