<?php
global $_GPC,$_W;
$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$title=$cfg['index_title'];
$adv_type=1;//1首页，4拼团，5秒杀，6首单，7买单，8同城
$userinfo = Member::initUserInfo(); //用户信息
$today = strtotime(date('Y-m-d', time())); // 今日
$mody = $today + 24 * 60 * 60; // 次日
$joinCity=$this->joinCity();
$codition =$this->getcookieCity();
$codition .=$this->getShopEndtime();
//城市
//print_r($_COOKIE);//打印所有缓存
//setcookie('address', '', time()-3600 * 24 * 7);
//setcookie('city_name', '', time()-3600 * 24 * 7);
if($op=='display') {
    //公告
    $msg=Member::member_msg(1);
    $city_name=$this->getCity_name();
    //天气
    $weatherurl = $this->weatherreq();
    $weatherdata=util::getWeather($weatherurl,$city_name);
    $weather2=json_decode($weatherdata,1);
    if( $weather2['status']=='1002'){//天气数据不正常时
        $weatherdata=util::getWeather($weatherurl,$_COOKIE['district']);
    }
    //签到
    $uid         = mc_openid2uid($_W['openid']);
    $timestr = date("Y-m-d", TIMESTAMP);
    $result = pdo_fetchcolumn("select count(*) from " . tablename(QIAN) . " where timestr=:timestr and uid=:uid", array(':timestr' => $timestr, ':uid' => $uid));
    $qiandao_random = $cfg['qiandao_random'];//是否随机签到
    if ($result > 0) {
        $qian_flag ="今日已签到";
    }elseif ($qiandao_random == 1) {
        $jifen ="获取随机积分";//根据最大的积分数，随机获取签分
    }elseif(!empty($cfg['qiandao_jifen'])){
        $jifen =' +'. $cfg['qiandao_jifen'].'积分';
    }

//同城信息
    $shownum=$this->showMsgNum();
    $info_condition=$this->info_condition();
    $lat=$this->getLat();
    $lng=$this->getLng();
    //今日置顶
    $zdmessagelist =commonGetData::getTopMsg($info_condition,$shownum,$lat,$lng);
    //最新
    $lastedmessagelist = commonGetData::getNewMsg($info_condition,$shownum,$lat,$lng);
//推荐商家
    $codition1 = " and s.status=1 and s.is_hot=1 ";


// 1入驻申请，2首页推荐，3秒杀，4拼团，5优惠买单,6店铺开启
    $shoplist = pdo_fetchall("SELECT s.*, a.area_name FROM " . tablename(SHOP) . " s  left join " .
        tablename(AREA) . " a on a.area_id=s.area_id and s.uniacid=a.uniacid WHERE s.uniacid =:uniacid {$codition} {$codition1} and s.status=1 ORDER BY  s.orderby DESC ", array(':uniacid' => $_W['uniacid']));


//查找最近的秒杀商品
    $stage_list =commonGetData::getmiaosha('','','',$joinCity,$codition,$today,$mody);
    $xsms= array();
    $xs= array();
//处理场次信息 显示当前秒杀中的场次 及以后的场次信息 不足五场显示第二天的场次信息
    $nowhour=date("H",time());
    if($stage_list){
    foreach ($stage_list as $k => $v) {
        $timebegin = $v['timestart']; //场次开始时间
        $timeend = $v['timeend']; //场次结束时间
        if ($nowhour >= $timebegin) {
            if ($nowhour >= $timeend) {
                $v['first_status'] = 2;  //已结束
            } else {
                $v['first_status'] = 1; //秒杀中
                $xs[] = $v;
            }
        } else {
            $v['first_status'] = 0; // 待秒杀
        }

      }
    }

    $xsms= array();
    //重新获取已开始的秒杀专场商品
    foreach($xs as $k => $v){
        if($v['first_status'] == 0){
            $id = $v['time_id'];

            $xsms=commonGetData::getmiaosha($id,'','',$joinCity,$codition,$today,$mody);
            $stage = $k;
            $current_status = 0;
            break;
        }
    }
//重新获取待开始的秒杀专场商品
    foreach($xs as $k => $v){
            if($v['first_status'] == 1){
                $id = $v['time_id'];
                $xsms=commonGetData::getmiaosha($id,'','',$joinCity,$codition,$today,$mody);
                $stage = $k;
                $current_status = 1;
                $msz_timestart= $v['timestart'];
                break;
            }
        }




}elseif($op=="mapWeather"){//根据坐标获取城市名再获取天气
    $latitude=$_GPC['latitude'];
    $longitude=$_GPC['longitude'];
    $mapreq=$this->mapreq();
    $chagexy=$this->chagexy();
    $data=util::getDistrictByLatLng($latitude,$longitude,$mapreq,$chagexy);
    echo json_encode(array('status' => $data['status'],'address' => $data['address'],'formatted_address' => $data['formatted_address']));
    exit;

}
include $this->template('../mobile/index');
exit();