<?php
//checkauth();
global $_GPC,$_W;
$cfg=$this->module['config'];
$userinfo = Member::initUserInfo(); //用户信息
$mid=intval($userinfo['id']);
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$title=$cfg['index_title'];
$ring_creidit= $cfg['ring_creidit'];//圈子发布限制
$ring_num=intval($cfg['ring_num']);//每天圈子发布数量
//print_r($_COOKIE);//打印所有缓存
//每天只能限制发信息
if($ring_creidit>0 && $_W['member']['credit1'] < $ring_creidit){
    $ring_creidit_flag=1;
}
if($ring_num>0){
    $todday=strtotime('now');
    $getRing_num=  pdo_fetch('SELECT COUNT(*) as num FROM ' . tablename(RING) . " WHERE mid= {$mid} and uniacid = {$_W['uniacid']} and addtime>=".$todday);
    if($getRing_num['num'] > $ring_num){
        $ring_num_flag=1;
    }

}


$credits = commonGetData::getUserCredit(getOpenid);
$page =$this->getPage();
$num = $this->getNum(); //每次取值的个数
$pageStart = $page * $num;
$title=$cfg['index_title'].' 同城圈子';
$adv_type=10;//1首页，4拼团，5秒杀，6首单，7买单，8同城,9附近，10圈子，11商家入驻
$openid=$this->getOpenid();
$a_data=$this->checkAdmin($openid);
$city_id=$this->getCity_id();
load()->func('tpl');
$id 	  = intval($_GPC['id']);
$citycondition="";
if($city_id>0){
    $citycondition=" and r.city_id=".$city_id;
}

if($op=="display"){
    $my=$_GPC['my'];
    $replay=$_GPC['replay'];
    if($my=='1'){
        $citycondition.=" and r.openid='".$openid."'";
    }elseif ($replay=='1'){
        $citycondition.=" and r.openid='".$openid."'";
        $replaycondition=" and z.zan_type=2" ;
    }
    $list= commonGetData::getRing(1,$citycondition,$pageStart,$num,$replaycondition);
}elseif ($op=="follow"){
    $list= commonGetData::getRing(2,$citycondition,$pageStart,$num);

}elseif ($op=="ring_add"){

    if (!empty($id)) {
        $condition=" and ring_id=".$id;
        $item= commonGetData::getRing(0,$condition,$pageStart,$num,$city_id);
    }
    if ($_GPC['add']==1) {
        //积分不够不能发圈子信息
        $this->checkBlack();
        if($ring_creidit_flag==1)message( '很抱歉，您需要满足'.$ring_creidit.'积分才可以发布圈子信息',referer(), 'error');
        //每天只能限制发信息
        if($ring_num_flag==1)message( '很抱歉，每天只能发布'.$ring_num.'条圈子信息',referer(), 'error');
       if (empty($_GPC['info'])) {
           message( '请填写内容',referer(), 'error');
       } else {
           $info =  commonGetData::guolv($_GPC['info']);
           $data = array(
               'uniacid' => $_W['uniacid'],
               'info' => $info,
               'addtime' => time(),
               'xsthumb' => json_encode($_GPC['xsthumb']),
               'lng' => $this->getLng(),
               'lat' => $this->getLat(),
               'openid' => $openid,
               'mid' => $userinfo['id'],
               'city_id' => $city_id,
               'topic_id' => intval($_GPC['topic']),

           );
           if (!empty($id)) {
               unset($data['ring_id']);
               pdo_update(RING, $data, array('ring_id' => $id, 'uniacid' => $_W['uniacid']));
           } else {
               pdo_insert(RING, $data);
               $id = pdo_insertid();
           }
           header("Location:".$this->createMobileUrl("ring") );
           exit();
       }
   }
    include $this->template('../mobile/ring_add');
    exit();

}elseif ($op=="delete" && !empty($id)){
    $ringData=util::getSingelDataInSingleTable(RING, array('ring_id' => $id,'uniacid' => $_W['uniacid']));
    if(empty($ringData))exit;
    if(!empty($a_data)) {//管理员删除
        $result=pdo_delete(RING, array('ring_id' => $id,'uniacid' => $_W['uniacid']));
    }else{
        $result=pdo_delete(RING, array('ring_id' => $id,'openid' => $openid,'uniacid' => $_W['uniacid']));

    }
    if(!empty($ringData['xsthumb'])){//图片不为空时要删除图片
        $xsthumb = json_decode($ringData['xsthumb']);
        foreach ($xsthumb as $k =>$v){
                    file_delete($v);
            }


    }
    $result2=pdo_delete(ZAN, array('ring_id' => $id,'uniacid' => $_W['uniacid']));
    if (!empty($result)) {
        echo json_encode(array('status' => '1'));
        exit;
    }
}elseif ($op=="zan" && !empty($id) || $op=="guanzhu" && !empty($id)){
    if($op=="zan"){
        $type=1;
    }else{
        $type=3;
    }

        $datainfo = util::getSingelDataInSingleTable(ZAN,array('openid'=>$openid,'ring_id'=>$id,'zan_type'=>$type,'uniacid' => $_W['uniacid']));


    if (!empty($datainfo)){//已赞(用户取消赞),已关注用户取消关注
        util::deleteData2('zan_id', $datainfo['zan_id'],ZAN);
        $info =pdo_fetchall("SELECT u.avatar,u.nickname FROM " . tablename(ZAN) . " z  left join " . tablename(MEMBER) . " u on z.openid=u.openid  and z.uniacid = u.uniacid WHERE  z.uniacid =:uniacid and z.ring_id=:ring_id and zan_type=:type order by z.zan_id desc", array(':uniacid'=>$_W['uniacid'],':ring_id'=>$id,':type'=>$type));
        if(count($info)>0){
            echo json_encode(array('status' => '1','num' => "1",'avatar' => $info,'add'=>'0'));
        }else{
            echo json_encode(array('status' => '1','num' => "0",'add'=>'0'));
        }

        exit;
    }
    //未赞，增加赞
    $data = array(
        'uniacid' => $_W['uniacid'],
        'zan_type' => $type,
        'addtime' => time(),
        'openid' => $openid,
        'ring_id' => $id,
    );
    $result=pdo_insert(ZAN, $data);
    if (!empty($result)) {
        echo json_encode(array('status' => '1','avatar' => $userinfo['avatar'],'add'=>'1','guans'=>'1'));
        exit;
    }
}elseif ($op=="ping" && !empty($id)){//1点赞，2评论，3关注
    $info=trim($_GPC['info']);
    if(empty($info)){
        echo json_encode(array('status' => '0','str' => '评论内容不能为空'));
        exit;
    }
    $time=time();
    $data = array(
        'uniacid' => $_W['uniacid'],
        'zan_type' => "2",
        'addtime' => $time,
        'openid' => $openid,
        'info' => $info,
        'ring_id' => $id,
    );
    $result=pdo_insert(ZAN, $data);
    if (!empty($result)) {
        echo json_encode(array('status' => '1','avatar' => $userinfo['avatar'],'nickname' => $userinfo['nickname'],'time' => date('m-d H:i', $time ),'info' =>$info));
        exit;
    }

}elseif ($op=="cancelPing" && !empty($id)){//1点赞，2评论，3关注
    if(!empty($a_data)){//管理员删除
        $datainfo = util::getSingelDataInSingleTable(ZAN,array('ring_id'=>$id,'zan_type'=>2,'uniacid' => $_W['uniacid']));
    }else{
        $datainfo = util::getSingelDataInSingleTable(ZAN,array('openid'=>$openid,'ring_id'=>$id,'zan_type'=>2,'uniacid' => $_W['uniacid']));
    }

    if (!empty($datainfo)){//删除评论
        util::deleteData2('zan_id', $datainfo['zan_id'],ZAN);
        echo json_encode(array('status' => '1'));
        exit;
    }
}else if($op =="shang"  && !empty($id)){
    //打赏
   // $rad_id = myFun::randombylength_num_true(11);
    $mf =   new myFun();
    $rad_id = $mf->randombylength_num_true(11);
    $params = array(
        'tid' => 'shang'.$rad_id,     //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
        'ordersn' =>$rad_id,                //收银台中显示的订单号
        'title' => '打赏',          //收银台中显示的标题
        'fee' => $_GPC['shang_amount'],      //收银台中显示需要支付的金额,只能大于 0
        'user' =>$user['openid'],       //付款用户, 付款的用户名(选填项)
    );
    $ringData=util::getSingelDataInSingleTable(RING, array('ring_id' => $id,'uniacid' => $_W['uniacid']));
    $type = 2;
    if(!empty($_GPC['type'])){
        $type = $_GPC['type'];
    }
    $toOpenid = $ringData['openid'];
    if(!empty($_GPC['toOpenId'])){
        $toOpenid = $_GPC['toOpenId'];
    }
    $data2 = array(
        'uniacid' => $_W['uniacid'],
        'cash_ordersn'=>$rad_id,
        'amount' => $_GPC['shang_amount'],
        'create_time' => time(),
        'openid' => $toOpenid,
        'type_id' => $id,
        'from_openid' =>$openid,
        'cash_type' =>$type,
        'status' =>0
    );
    $result=pdo_insert(CASH, $data2);
    $this->pay($params);
    exit;
}elseif($op =="detail"  && !empty($id)){
    $condition=' and r.ring_id='.$id.' ';
    $list= commonGetData::getRing(1,$condition,0,1,'');
    $item=$list[0];
    $Redpackage=new Redpackage();
    $red_data=$Redpackage->getRingRed_recordList($id,2);
    include $this->template('../mobile/ringDetail');
    exit;
}

if($_GPC['isajax']=="1" ){
    echo json_encode(array('status' => '1','isshang' =>$this->isShang(),'list' =>$list,'length'=>count($list)));
    exit;
}
include $this->template('../mobile/ring');
exit();

