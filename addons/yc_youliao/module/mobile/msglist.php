<?php
global $_GPC,$_W;
$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$userinfo = Member::initUserInfo(); //用户信息
$adv_type=8;//1首页，4拼团，5秒杀，6首单，7买单，8同城
$info_condition='';
$id = intval($_GPC['id']);
$flag = intval($_GPC['flag']);
$zhiding =$_GPC['zhiding'];
$keyword = $_GPC['keyword'];
if($zhiding) {
    $info_condition .= " and isding = 1 ";
}
if($keyword){
    $info_condition .=" and content like '%".$keyword."%' ";
    $allchildren = pdo_fetchall('SELECT id,name,fid,thumb,autourl FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']}  ORDER BY displayorder ASC");
}else{
    $districtname = $this->getCity_name();
if (empty($districtname)) {
$url = $this->createMobileUrl('changeadd');
header("Location:{$url}");
}
    $allchildren = pdo_fetchall('SELECT id,name,fid,thumb,autourl FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND fid = {$id} ORDER BY displayorder ASC");
    $childrenid = intval($_GPC['childrenid']);
    if ($childrenid) {//有子类
        $mid = $childrenid;
    } else {//无子类
        if (!empty($allchildren)) {
            $mid = $allchildren[0]['id'];
        } else {
            $mid = $id;
        }
    }

    $moduleres = pdo_fetch('SELECT * FROM ' . tablename(CHANNEL) . " WHERE id = {$mid} AND weid = {$_W['uniacid']}");
    $moduleres['listhtml'] = htmlspecialchars_decode($moduleres['listhtml']);
    $title=$moduleres['name'];
}
//记录足迹
$childNum=count($allchildren);
$footmark=commonGetData::proFoot($userinfo['id'],'1',$id,$moduleres['name']);
//更新置顶时间
$dingmessage = pdo_fetchall('SELECT id,dingtime FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} AND isding = 1");

foreach ($dingmessage as $k => $v) {
if ($v['dingtime'] < TIMESTAMP) {
pdo_update(INFO, array('isding' => 0, 'dingtime' => 0), array('id' => $v['id']));
}
}
$page =$this->getWebPage();
$num = $this->getNum(); //每次取值的个数
$info_condition .=$this->info_condition();
$lat=$this->getLat();
$lng=$this->getLng();
//查询一级分类
$fid=0;
if($flag==1){
    $fid=$id;
    $moduleres = pdo_fetch('SELECT name FROM ' . tablename(CHANNEL) . " WHERE id = {$fid} AND weid = {$_W['uniacid']}");
    $title=$moduleres['name'];
}
$messagelist = commonGetData::getMsgById($id,$page,$num,$city,$lat,$lng,$info_condition,$fid);
$isajax = intval($_GPC['isajax']);
if ($isajax == 1) {
    echo json_encode(array('result'=>'1','isshang'=>$this->isShang(),'list'=>$messagelist,'length'=>count($messagelist)));
    exit;
}
$html = '';
if (!empty($moduleres['listhtml']) || $moduleres['defult_list']==2) //自定义列表页
 {
    foreach ($messagelist as $k => $v) {
        $newhtml = '<a href="' . $this->createMobileUrl('detail', array('id' => $v['id'])) . '">' . $moduleres['listhtml'];
        $fieldlist = unserialize($v['content']);
        $fieldlist = commonGetData::guolv($fieldlist);
        foreach ($fieldlist as $kk => $vv) {
            $fieldmtype = pdo_fetch('SELECT mtype,danwei FROM ' . tablename(FIELDS) . " WHERE weid = {$_W['uniacid']} AND mid = {$v['mid']} AND enname = '{$kk}'");
            if ($fieldmtype['mtype'] == 'checkbox') {
                $checkboxhtml = '';
                foreach ($vv as $ck => $cv) {
                    $checkboxhtml .= '<div class="span4"><span class="iconfont">&#xe624;</span>' . $cv . '</div>';
                }
                $newhtml = str_replace('[' . $kk . ']', $checkboxhtml, $newhtml);
            } elseif ($fieldmtype['mtype'] == 'radio' || $fieldmtype['mtype'] == 'select') {
                $newhtml = str_replace('[' . $kk . ']', $vv . $fieldmtype['danwei'], $newhtml);
            } elseif ($fieldmtype['mtype'] == 'images' || $fieldmtype['mtype'] == 'goodsthumbs' || $fieldmtype['mtype'] == 'goodsbaoliao') {
                $imgurl = tomedia($vv[0]);
                $newhtml = str_replace('../addons/yc_youliao/public/images/quesheng.jpg', $imgurl, $newhtml);
            } else {
                $newhtml = str_replace('[' . $kk . ']', $vv . $fieldmtype['danwei'], $newhtml);
            }
            $newhtml = str_replace('[' . $kk . ']', $vv, $newhtml);
            $newhtml = str_replace('[openid]', $v['openid'], $newhtml);
            $newhtml = str_replace('[nickname]', $v['nickname'], $newhtml);
            $newhtml = str_replace('[province]', $v['province'], $newhtml);
            $newhtml = str_replace('[city]', $v['city'], $newhtml);
            $newhtml = str_replace('[district]', $v['district'], $newhtml);
            $newhtml = str_replace('[views]', $v['views'], $newhtml);
            $createdate = date('Y-m-d H:i:s', $v['createtime']);
            $newhtml = str_replace('[createtime]', $createdate, $newhtml);
        }
        $html .= $newhtml . '</a>';
    }
     if ($isajax == 1) {
         echo json_encode(array('result'=>'1','str'=>$html));
         exit;
     }
}


if(empty($_GPC['id'])){
    include $this->template('../mobile/msg_center');
    exit;
}

//分享内容设置
$share_title=$moduleres['sharetitle'];
$share_info=$moduleres['sharedes'];
$share_img=$moduleres['sharethumb'];
include $this->template('../mobile/messagelist');
exit;
