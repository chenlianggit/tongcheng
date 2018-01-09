<?php
//checkauth();
//发红包
global $_GPC,$_W;
use QL\QueryList;
if($this->isRedpacket()!=0){
    die("<script>window.location.href='" . $this->createMobileUrl('ring', array('op'=>'display'), 'success') . "';</script>");
}
$cfg=$this->module['config'];
$userinfo = Member::initUserInfo(); //用户信息
$openid=$from_user=$this->getOpenid();
$userinfo = Member::getMemberByopenid($openid);
$mid=intval($userinfo['id']);
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'redpackage';
$title=$cfg['index_title'];
$adv_type=10;//1首页，4拼团，5秒杀，6首单，7买单，8同城,9附近，10圈子，11商家入驻
$credits = commonGetData::getUserCredit(getOpenid);
$page =$this->getPage();
$num = $this->getNum(); //每次取值的个数
$pageStart =$this->pageIndex();
$title='福利红包';
$a_data=$this->checkAdmin($openid);
$city_id=$this->getCity_id();
$lat=$this->getLat();
$lng=$this->getLng();
load()->func('tpl');
$id = intval($_GPC['id']);
$citycondition="";
if($city_id>0){
    $citycondition=" and r.city_id=".$city_id;
}

if($op=="redpackage"){

    //获取可以抢的红包数量
    $adv_type=10;//1首页，4拼团，5秒杀，6首单，7买单，8同城,9附近，10圈子，11商家入驻
    $list_ch= Redpackage::getRedpackage($pageStart,$num,"r.status=1");
    $list = array();
    foreach($list_ch as $k => $v) {
        $v['xsthumb'] = json_decode($v['xsthumb']);
        foreach ((array)$v['xsthumb'] as $a => $b) {
            if($b){
                $v['xsthumb'] [$a] = tomedia($b);
            }
        }

        $d = util::getDistance($lat, $lng, $v['lat'], $v['lng']);
        if (!empty($v['distance']) && $v['distance'] > 0) {
            if ($v['distance'] > $d) {
                    $v['distance'] = $d;
                    $list[] = $v;
            }
        }else{
            $v['distance'] = $d;
            $list[] = $v;
        }

    }

    if($_GPC['isajax']==1) {
        echo json_encode(array('result'=>'1','list'=>$list,'length'=>count($list)));
        exit;
    }
}else if ($op=="redpackage_add") {
    if ($_GPC['add'] == 1) {
        $total_num = intval($_GPC['total_num']); // 红包数（个）
        $total_amount = floatval($_GPC['total_amount']); // 红包总额（元）
        if($total_num==0 || $total_amount<1){
            message('红包金额需大于1元，红包个数最少为1个', referer(), 'error');
        }
            if ($_GPC['allocation_way'] == '1') {
                //生成平均分配方案
                $plan = $this->red_average_plan($total_amount, $total_num);
            } else {
                // 生成随机分配方案
                $plan = $this->red_plan($total_amount, $total_num, 1);
            }
            $info = commonGetData::guolv($_GPC['info']);
            $plan = implode(',', $plan);
            $data = array(
                'uniacid' => $_W['uniacid'],
                'content' => $info,
                'create_time' => time(),
                'model' => $_GPC['model'],
                'kouling' => $_GPC['kouling'],
                'xsthumb' => json_encode($_GPC['xsthumb']),
                'allocation_way' => $_GPC['allocation_way'],
                'distance' => $_GPC['distance'],
                'rob_plan' => $plan,
                'total_num' => $total_num,
                'total_amount' => $total_amount,
                'total_pay' => $total_amount,
                'lng' => $this->getLng(),
                'lat' => $this->getLat(),
                'openid' => $openid,
                'mid' => $userinfo['id'],
                'city_id' => $city_id
            );

            pdo_insert(REDPACKAGE, $data);
            $id = pdo_insertid();
            $params = array(
                'tid' => 'redpackage'.$id,     //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
                'ordersn' =>$id,                //收银台中显示的订单号
                'title' => '福利红包',          //收银台中显示的标题
                'fee' => $total_amount,      //收银台中显示需要支付的金额,只能大于 0
                'user' =>$user['openid'],       //付款用户, 付款的用户名(选填项)
            );
            $this->pay($params);
            exit();
        }


    include $this->template('../mobile/redpackage_add');
    exit();

}else if ($op=="showredpackage" && !empty($id)){

    //抢红包页面
    $userData=util::getSingelDataInSingleTable(GETREDPACKAGE, array('red_id' => $id,'openid' => $openid,'uniacid' => $_W['uniacid']));
    $redpackageData= Redpackage::getRedpackage($pageStart,$num,"r.red_id=".$id);
    $getredpackageData=Redpackage::getRedpackageRecords("red_id=".$id);
    if(empty($redpackageData)){
        message('福利红包不存在', referer(), 'error');
    }

    include $this->template('../mobile/redpackage_show');
    exit();
}elseif ($op=="getpackage" && !empty($id)){
    //领取红包
    $redpackageData= Redpackage::getRedpackage($pageStart,$num,"r.red_id=".$id);
    $getredpackageData=Redpackage::getRedpackageRecords("red_id=".$id);
    $userData=util::getSingelDataInSingleTable(GETREDPACKAGE, array('red_id' => $id,'openid' => $openid,'uniacid' => $_W['uniacid']));
    if(empty($redpackageData)){
        //对应福利红包不存在
        echo json_encode(array('code' => '1001'));
        exit;
    }
    if(!empty($userData)){
        //重复领取
        echo json_encode(array('code' => '1005'));
        exit;
    }
    $getcount = count($getredpackageData);
    $getmoney = explode(',',$redpackageData[0]['rob_plan']);
    $getmoney =$getmoney[$getcount];
    if(!empty($getredpackageData) && $getcount>=$redpackageData[0]['total_num']){
        //福利红包已经领取完
        echo json_encode(array('code' => '1002'));
        exit;
    }
    if($redpackageData[0]['model']==2){
        if($redpackageData[0]['kouling']!=$_GPC['kouling']){
            //福利红包口令错误
            echo json_encode(array('code' => '1003'));
            exit;
        }
    }

    //增加领取红包记录
    $data = array(
        'uniacid' => $_W['uniacid'],
        'get_amount' => $getmoney/100,
        'create_time' => time(),
        'openid' => $openid,
        'red_id' => $id,
    );
    $result=pdo_insert(GETREDPACKAGE, $data);
    if (!empty($result)) {
        $data1 = array(
            'send_num' => $redpackageData[0]['send_num']+1
        );
        pdo_update(REDPACKAGE, $data1, array('red_id' => $id, 'uniacid' => $_W['uniacid']));

        //将可提现金额存到可提现金额表中
        $data2 = array(
            'uniacid' => $_W['uniacid'],
            'amount' => $getmoney/100,
            'create_time' => time(),
            'openid' => $openid,
            'type_id' => $id,
            'from_openid' =>$redpackageData[0]['openid'] ,
            'cash_type' =>1
        );
        $result=pdo_insert(CASH, $data2);
        pdo_update(MEMBER, array('balance'=>($userinfo['balance']+($getmoney/100))), array('openid' => $openid, 'uniacid' => $_W['uniacid']));
        echo json_encode(array('code' => '1000','money' =>$getmoney/100));
        exit;
    }else{
        //领取福利红包出错
        echo json_encode(array('code' => '10004','money' =>$getmoney));
        exit;
    }
}else if($op=="cash"){
    if(empty($openid)){
        message('用户信息不存在', referer(), 'error');
    }
    $sql='select * from '.tablename(CASH)."  WHERE  uniacid =".$_W['uniacid']." and openid=".$openid."  ORDER BY create_time DESC ";
    $list = pdo_fetchall($sql);
    $cash = 0;
    $get_cash = 0;;
    foreach($list as $k => $v){
     if($v['type']==1){
         //存入总金额
         $cash = $cash+$v['amount'];
        $fromuserinfo =   Util::getSingelDataInSingleTable(MEMBER, array('openid' => $v['from_openid']));
         $list[$k]['fromusername'] = $fromuserinfo['nickname'];
         $lsit[$k]['fromuserimage']=$fromuserinfo['headimgurl'];
     }else{
         //取现金额
         $get_cash = $get_cash+$v['amount'];
     }
        include $this->template('../mobile/cash');
        exit;
    }
}else if($op == 'getcash'){
    //提现
    if(empty($openid)){
        message('用户信息不存在', referer(), 'error');
    }
    if(empty($_GPC['amount'])){
        message('提现金额不能为空', referer(), 'error');
    }
    $sql='select count(amount) from '.tablename(CASH)."  WHERE  uniacid =".$_W['uniacid']." and openid=".$openid." and type=1";
    $cash = pdo_fetch($sql);
    $sql='select count(amount) from '.tablename(CASH)."  WHERE  uniacid =".$_W['uniacid']." and openid=".$openid." and type=2";
    $get_cash = pdo_fetch($sql);
    if(($cash-$get_cash)<$_GPC['amount']){
        message('提现金额不能超过可提现金额', referer(), 'error');
    }
    //====提现操作===

    //====提现成功更新数据库====
    $data = array(
        'uniacid' => $_W['uniacid'],
        'amount' => $_GPC['amount'],
        'create_time' => time(),
        'openid' => $openid,
        'from_openid' =>$openid ,
        'cash_type' =>2,
        'type_id' => $id,
        'cash_desc'=>"用户申请提现"
    );
    pdo_insert(CASH,$data);
    echo json_encode(array('code' => '10000','desc' =>"提现"+$_GPC['amount']+"元成功"));
    exit;
}
include $this->template('../mobile/redpackage');
exit();

