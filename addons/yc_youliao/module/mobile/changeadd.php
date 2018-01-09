<?php
global $_GPC,$_W;
$title = '定位管理';
$op     =  $_GPC['op'];
$mapreq=$this->mapreq();
$userinfo = Member::initUserInfo(); //用户信息
$chagexy=$this->chagexy();
if($op=='changexy'){//切换位置时，要缓存要标记,不需要转换坐标
    $lat=$_GPC['lat'];
    $lng=$_GPC['lng'];
    if(empty($lat) || empty($lng) ){
        if($_GPC['a_jax']=='1'){
            echo json_encode(array('status' =>'0'));
        }else{
            message('请选择下拉框的地址');
        }
    }
    $data=util::getDistrictByLatLng($lng,$lat,$mapreq,$chagexy,'0','1','0');

    if($_GPC['a_jax']=='1'){
        echo json_encode(array('status' => $data['status'],'address' => $data['address'],'formatted_address' => $data['formatted_address']));
        exit;
    }
    //刷新当前页面
    die("<script>window.location.href='" . $this->createMobileUrl('changeadd') . "';</script>");
    exit;
}else{//普通查询，无须缓存，无须标记
    $lat=$this->getLat();
    $lng=$this->getLng();
    $noauto=$_GPC['noauto'];
    if(empty($noauto)){
        $noauto='0';
    }else{//去掉手动定位标记
        $noauto=$_GPC['noauto'];
    }
    $data=util::getDistrictByLatLng($lat,$lng,$mapreq,$chagexy,'0',$noauto);
}
$lat=$this->getReqLat();
$lng=$this->getReqLng();
$reqData=util::getDistrictByLatLng($lng,$lat,$mapreq,$chagexy,'0','1','0');
$pois=$reqData['pois'];
if($noauto=='2'){//重新定到当前地址：去掉手动标记后浏览器将重新获取坐标
    die("<script>window.location.href='" . $this->createMobileUrl('changeadd') . "';</script>");
    exit;
}

//print_r($pois);
include $this->template('../mobile/changeadd');
exit;