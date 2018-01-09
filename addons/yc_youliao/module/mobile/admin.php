<?php
global $_GPC,$_W;
$title = '社区管理中心';
$userinfo = Member::initUserInfo(); //用户信息
$openid=$this->getOpenid();
$a_data=$this->checkAdmin($openid);
if(empty($a_data)){
    message('您不是管理员或管理员身份已失效');
}
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$page =$this->getPage();
$num = $this->getNum(); //每次取值的个数
$pageStart = $page * $num;
$keyword =$this->getKeyword();
$starttime =$this->getStarttime();
$endtime =$this->getEndtime();
$sqlweher='';
if($op=='display'){
    //待审核信息
    $nocheck_where1['status']=0;
    $nocheck_info=util::getAllDataNumInSingleTable(INFO,$nocheck_where1,'2');
    //待审核商家
    $nocheck_where2['f_type>']=0;
    $nocheck_where2['shop_id>']=0;
    pdo_delete(SHOP_APPLY,array('shop_id'=>0));
    $nocheck_shop=util::getAllDataNumInSingleTable(SHOP_APPLY,$nocheck_where2,'1');
    $amount_where['status']=0;
    $nocheck_amount=util::getAllDataNumInSingleTable(ACCOUNT,$amount_where,'1');
    $userinfo = Member::getSingleUser($openid); //用户信息
    include $this->template('../mobile/admin');
    exit;
}elseif($op=='check'){
    $banner_title='审核同城信息';
    $info_condition=$this->info_condition();
    $status=intval($_GPC['status']);
    $isding=intval($_GPC['isding']);

    if($isding==1){
      $sqlweher.=' and isding=1 and dingtime >'.TIMESTAMP;
    }
    if($starttime){
        $sqlweher.=' and createtime >='.$starttime;
    }
    if($endtime){
        $sqlweher.=' and createtime <='.$endtime;
    }
    if($keyword){
        $sqlweher.=" AND content LIKE '%{$keyword}%'";
    }
    $mapreq=$this->mapreq();
    $chagexy=$this->chagexy();
    $lastedmessagelist = pdo_fetchall('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']}  AND status = {$status} {$sqlweher} ORDER BY createtime DESC LIMIT  {$pageStart},{$num} ");
    foreach ($lastedmessagelist as $k => $v) {
        $getAddress = util::getDistrictByLatLng($v['lat'], $v['lng'],$mapreq,$chagexy,'1');
        $lastedmessagelist[$k]['address'] = $getAddress['address'];
        $module = pdo_fetch('SELECT name FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND id = {$v['mid']}");
        $lastedmessagelist[$k]['con'] = unserialize($v['content']);
        $lastedmessagelist[$k]['modulename'] = $module['name'];
        $lastedmessagelist[$k]['isneedpay']= $module['isneedpay'];
        $lastedmessagelist[$k]['needpay']= $module['needpay'];
        $lastedmessagelist[$k]['createtime']=  date('Y-m-d H:i', $v['createtime']);

    }
    if($_GPC['isajax']=="1"){
        $item=Array();
        foreach ($lastedmessagelist as $k =>  $arr) {
            $arr[$k]['con']['thumbs']= json_decode($arr[$k]['con']['thumbs']) ;
            $item[]=$arr;
        }
        echo json_encode(array('status' => '1','length'=>count($item),'list' => $item));
        exit;
    }
    include $this->template('../mobile/admin_check');
    exit;
}elseif($op=='check_info'){
    if(empty($_GPC['id']) || $_GPC['status']==""){
        echo json_encode(array('status' => '0'));
        exit;
    }
    $id=intval($_GPC['id']);
    $status=intval($_GPC['status']);//记录：0未审核 1审核通过 2审核未通过 3置顶 4取消置顶 5刷新 6删除
    if($status<=2){
         pdo_update(INFO, array('status' => $status), array('id' => $id,'weid'=>$_W['uniacid']));
        //模板消息通知用户
        $info_where['id']=$id;
        $info_data=util::getSingelDataInSingleTable(INFO, $info_where,'openid,nickname,content,mid','2');
        $module_where['id']=$info_data['mid'];
        $module =util::getSingelDataInSingleTable(CHANNEL, $module_where,'name','2');
        $content=unserialize($info_data['content']);
        $url= Util::createModuleUrl('detail',array('id'=>$id));
        if($status==1){
            $i_item='恭喜您，您在'.$module['name'].'发布的信息已审核通过';
            $status_info='审核通过';
        }elseif($status==2){
            $i_item='很抱歉，您在'.$module['name'].'发布的信息审核未通过';
            $status_info='审核未通过';
        }
        $remark='内容标题：'.$content['title'];
        Message::admin_checkmessage($i_item,$url,$info_data['openid'],$status_info,$info_data['nickname'],$remark);
    }elseif($status==3){//置顶
        $dingtime=intval($_GPC['dingtime']);
        pdo_update(INFO, array('isding' => 1,'dingtime' =>$dingtime), array('id' => $id,'weid'=>$_W['uniacid']));
    }elseif($status==4){//取消置顶
        pdo_update(INFO, array('isding' => 0), array('id' => $id,'weid'=>$_W['uniacid']));
    }elseif($status==5){//刷新
        pdo_update(INFO, array('freshtime' => TIMESTAMP), array('id' => $id,'weid'=>$_W['uniacid']));
    }elseif($status==6){//删除
        pdo_delete(INFO, array('id' => $id,'weid'=>$_W['uniacid']));
    }
    echo json_encode(array('status' => '1'));
    exit;


}elseif($op=='check_shop'){
    $status=intval($_GPC['status']);
    if($isding==1){
        $sqlweher.=' and isding=1 and dingtime >'.TIMESTAMP;
    }

    if($status>0){
        $banner_title='商家管理';
        $input_detail='店铺名称';
        if($starttime){
            $sqlweher.=' and s.createtime >='.$starttime;
        }
        if($endtime){
            $sqlweher.=' and s.createtime <='.$endtime;
        }
        if($keyword){
            $sqlweher.=" and s.shop_name LIKE '%{$keyword}%'";
        }
        $sqlweher.=' and s.status>='.$status;
        $list=commonGetData::getShop($sqlweher,$page,$num);
    }else{
        $banner_title='审核商家';
        $input_detail='店铺名称';
        if($starttime){
            $sqlweher.=' and p.applytime >='.$starttime;
        }
        if($endtime){
            $sqlweher.=' and p.applytime <='.$endtime;
        }
        if($keyword){
            $sqlweher.=" and s.shop_name LIKE '%{$keyword}%'";
        }
        $data=commonGetData::getShop_apply($page,$num, $sqlweher);
        $list =$data[0];
    }
    if($_GPC['isajax']=="1"){
        echo json_encode(array('status' => '1','length'=>count($list),'list' => $list));
        exit;
    }
    include $this->template('../mobile/admin_shop_list');
    exit;
}elseif($op=='check_shop_result'){
    if(empty($_GPC['id']) || $_GPC['status']==""){
        echo json_encode(array('status' => '0'));
        exit;
    }
    $id=intval($_GPC['id']);
    $status=intval($_GPC['status']);//记录：0未审核 1审核通过 2审核未通过 6删除
    if($status<=2){
        if($status==1){
            $i_item='恭喜您，店铺申请入驻已审核通过，赶快完善资料上传商品吧！';
            $status_info='审核通过';
        }elseif($status==2){
            $i_item='很抱歉，关于您申请店铺入驻审核未通过，请您重新填写资料再申请';
            $status_info='审核未通过';
        }
        pdo_update(SHOP, array('status' => $status), array('shop_id' => $id,'uniacid'=>$_W['uniacid']));

        //模板消息通知用户
        $info_where['shop_id']=$id;
        $info_data=util::getSingelDataInSingleTable(SHOP, $info_where,'mid,shop_name');
        $user_where['id']=$info_data['mid'];
        $user_data=util::getSingelDataInSingleTable(MEMBER, $user_where,'openid,nickname');
        $url= Util::createModuleUrl('shop_admin',array('shop_id'=>$id));
        $remark='店铺名称：'.$info_data['shop_name'];
        Message::admin_checkmessage($i_item,$url,$user_data['openid'],$status_info,$user_data['nickname'],$remark);

        //将申请人设置成店铺超级管理员
        $admin_data = array(
            'uniacid' => $_W['uniacid'],
            'shop_id' => $id,
            'admin_type' =>1,
            'openid' => $user_data['openid'],
        );
        pdo_insert(SHOP_ADMIN, $admin_data);
    }elseif($status==6){//删除
        pdo_delete(SHOP, array('shop_id' => $id,'uniacid'=>$_W['uniacid']));
    }
    pdo_delete(SHOP_APPLY, array('shop_id' => $id,'uniacid'=>$_W['uniacid']));
    echo json_encode(array('status' => '1'));
    exit;


}elseif($op=='ring'){
    $banner_title='圈子管理';
    $input_detail='圈子内容';
    $ring_condition='';
    if ($keyword) {
        $ring_condition.= " AND r.info LIKE '%{$keyword}%'";
    }
    if($starttime){
        $ring_condition.=' and r.addtime >='.$starttime;
    }
    if($endtime){
        $ring_condition.=' and r.addtime <='.$endtime;
    }


    $pageStart = $page * $num;
    $list= commonGetData::getRing(1,$ring_condition,$pageStart,$num,'','1');
    if($_GPC['isajax']=="1" ){
        $item=Array();
        foreach ($list as $k =>  $arr) {
            $arr['xsthumb']= json_decode($arr['xsthumb']) ;
            $arr['addtime']=  date('m-d H:i', $arr['addtime']);
            $item[]=$arr;
        }
        echo json_encode(array('status' => '1','list' => $item,'length'=>count($item)));
        exit;
    }
    include $this->template('../mobile/admin_ring_list');
    exit;

}elseif($op=='fans'){
    $banner_title='粉丝管理';
    $input_detail='用户名';

    $type=intval($_GPC['type']);
    if($type==1){//黑名单列表
        if($starttime){
            $sqlweher.=' and b.createtime >='.$starttime;
        }
        if($endtime){
            $sqlweher.=' and b.createtime <='.$endtime;
        }
        if($keyword){
            $sqlweher.=" and m.nickname LIKE '%{$keyword}%'";
        }
        if($_GPC['post']=='add'){//加入黑名单
            $data=array(
              'uniacid'=>  $_W['uniacid'],
              'uid'=>  intval($_GPC['uid']),
              'createtime'=> time(),
            );
            $black= Member::getBlack($_GPC['uid']);
            if(empty($black))pdo_insert(BLACK,$data);
        }elseif($_GPC['post']=='delete'){//删除黑名单
           pdo_delete(BLACK,array( 'uniacid'=>  $_W['uniacid'],'uid'=>  intval($_GPC['uid']),));
        }
        $list = pdo_fetchall('SELECT b.*,m.nickname,m.avatar FROM ' . tablename(BLACK) . " b left join  " . tablename(MEMBER) . "m on b.uid = m.id  WHERE b.uniacid = {$_W['uniacid']}   {$sqlweher} ORDER BY b.black_id DESC LIMIT  {$pageStart},{$num} ");

    }else {//粉丝列表
        if($starttime){
            $sqlweher.=' and createtime >='.$starttime;
        }
        if($endtime){
            $sqlweher.=' and createtime <='.$endtime;
        }
        if($keyword){
            $sqlweher.=" and nickname LIKE '%{$keyword}%'";
        }
        $data = pdo_fetchall('SELECT * FROM ' . tablename(MEMBER) . " WHERE uniacid = {$_W['uniacid']}   {$sqlweher} ORDER BY id DESC LIMIT  {$pageStart},{$num} ");
        $list = array();
        foreach ($data as $k => $v) {
            if ($v['shop_id']) {
                $shop_where['shop_id'] = $v['shop_id'];
                $shop = util::getSingelDataInSingleTable(SHOP, $shop_where, 'shop_name');
                $v['shop_name'] = $shop['shop_name'];
            }
            $credits = commonGetData::getUserCreditList($v['openid']);
            $v['credit'] = $credits['credit1'];
            $v['balance'] = $credits['credit2'];
            $list[] = $v;
        }
    }

    if($_GPC['isajax']=="1"){
        echo json_encode(array('type' => $type,'status' => '1','length'=>count($list),'list' => $list));
        exit;
    }
    include $this->template('../mobile/admin_fans_list');
    exit;
}elseif($op=='fans_credit'){
    $banner_title='会员充值';
    $input_detail='用户名';
    $mid=$_GPC['mid'];
    $credit_type=intval($_GPC['credit_type']);
//获取该用户现有余额、积分
    $member_where['id']=$mid;
    $user=util::getSingelDataInSingleTable(MEMBER,$member_where,'nickname,avatar,openid');
    if($user){
        $credits = commonGetData::getUserCreditList($user['openid']);
    }
//充值
    $fee=$_GPC['fee'];
    if($_GPC['isajax']=="1" && !empty($fee)){
        $tag='管理员:'.$a_data['nickname'].'操作';
            if($credit_type==1){
                $re = Member::updateUserCredit($user['openid'], $fee, 5, $tag);
                $_fee=floatval($credits['credit1']+$fee);
                $word="恭喜您，获得：".$fee."积分\\n您目前的积分为：". $_fee."积分";
            }else  if($credit_type==2){
                $re = Member::updateUserMoney($user['openid'], $fee, 5, $tag);
                $_fee=floatval($credits['credit2']+$fee);
                $word="恭喜您，获得：".$fee."元现金\\n您现在的金额为：". $_fee."元";
            }
            if($re){
                $conarr = explode('-',$fee);
                if($conarr<=1){
                    $this->rep_text($user['openid'], $word);
                }
            echo json_encode(array('status' => '1','fee' => $_fee));
            exit;
            }
        }
    include $this->template('../mobile/admin_fans_credit');
    exit;
}elseif($op=='order'){
    $banner_title='订单列表';
    $input_detail='用户名';
    $status=$_GPC['status'];
    if(empty($status) || $status=="all")$sqlweher.=' and o.status >'.intval($status);
    elseif(intval($status>=4))$sqlweher.=' and o.status >='.intval($status);
    elseif(intval($status>=0))$sqlweher.=' and o.status ='.intval($status);
    if($starttime){
        $sqlweher.=' and o.createtime >='.$starttime;
    }
    if($endtime){
        $sqlweher.=' and o.createtime <='.$endtime;
    }
    if($keyword){
        $sqlweher.=" and m.nickname LIKE '%{$keyword}%'";
    }
    $leftjoin=  " left join ".tablename(MEMBER)."  m on m.openid=o.openid ";
    $data=Order::getorderlist($sqlweher,$page,$num,$leftjoin);
    $list=$data[0];
    $goods=$data[1];
    if($_GPC['isajax']==1) {
        echo json_encode(array('result' => '1', 'list' => $list, 'length' => count($list)));
        exit;
    }
    include $this->template('../mobile/admin_order');
    exit;
}elseif($op=='discount'){
    $banner_title='订单列表';
    $input_detail='用户名';
    if($starttime){
        $sqlweher.=' and r.createtime >='.$starttime;
    }
    if($endtime){
        $sqlweher.=' and r.createtime <='.$endtime;
    }
    if($keyword){
        $sqlweher.=" and m.nickname LIKE '%{$keyword}%'";
    }
    $data=commonGetData::getDiscount($page,$num,'',$sqlweher);
    $list=$data[0];
    if($_GPC['isajax']==1) {
        $info=Array();
        foreach ($list as $k => $v) {
            $v['createtime']=date('Y-m-d H:i', $v['createtime']);
            $v['logo']=tomedia($v['logo']);
            $info[]=$v;
        }

        echo json_encode(array('result'=>'1','list'=>$info,'length'=>count($info)));
        exit;
    }
    include $this->template('../mobile/admin_order');
    exit();
}elseif($op=='renew'){
    $banner_title='商户缴费列表';
    $input_detail='商户名称';
    if($starttime){
        $sqlweher.=' and r.createtime >='.$starttime;
    }
    if($endtime){
        $sqlweher.=' and r.createtime <='.$endtime;
    }
    if($keyword){
        $sqlweher.=" and s.shop_name LIKE '%{$keyword}%'";
    }
     $id=intval($_GPC['id']);
    $list=Shop::getShopRenew(0,$sqlwhere);
    if($_GPC['isajax']==1) {
        $info=Array();
        foreach ($list as $k => $v) {
            $v['createtime']=date('Y-m-d H:i', $v['createtime']);
            $v['starttime']=date('Y-m-d H:i', $v['starttime']);
            $v['endtime']=date('Y-m-d H:i', $v['endtime']);
            $v['logo']=tomedia($v['logo']);
            $info[]=$v;
        }

        echo json_encode(array('result'=>'1','list'=>$info,'length'=>count($info)));
        exit;
    }elseif($id>0){
        $search=1;
        $item=Shop::getShopRenew(0,'',$id);
        $item=  $item[0];
        include $this->template('../mobile/renew_detail');
        exit();
    }

    include $this->template('../mobile/admin_order');
    exit();
}elseif($op=='order_info'){
    $banner_title='订单列表';
    $input_detail='用户名';
    if($starttime){
        $sqlweher.=' and o.createtime >='.$starttime;
    }
    if($endtime){
        $sqlweher.=' and o.createtime <='.$endtime;
    }
    if($keyword){
        $sqlweher.=" and i.nickname LIKE '%{$keyword}%'";
    }
    $type=$_GPC['type'];
    if($type=="1"){
        $list = pdo_fetchall("SELECT i.*,o.createtime as zdtime,o.price as zdprice ,o.ordersn FROM ".tablename(ZDORDER)." o left join  ".tablename(INFO)."i on o.message_id=i.id WHERE i.weid = {$_W['uniacid']} {$sqlweher} ORDER BY createtime DESC LIMIT ".$page.",".$num);
    }else{
    $list = pdo_fetchall("SELECT i.*,o.createtime as infotime,o.price as infoprice,o.ordersn FROM ".tablename(INFOORDER)." o left join  ".tablename(INFO)."i on o.message_id=i.id WHERE i.weid = {$_W['uniacid']} {$sqlweher} ORDER BY createtime DESC LIMIT ".$page.",".$num);
    }

    foreach($list as $k=>$v){
        $list[$k]['con'] = unserialize($v['content']);
        $list[$k]['createtime']= date('Y-m-d H:i', $v['createtime']);
    }

    if($_GPC['isajax']==1) {
        echo json_encode(array('result'=>'1','list'=>$list,'length'=>count($list)));
        exit;
    }
    include $this->template('../mobile/admin_order');
    exit();
}elseif($op=='account_order'){
    $banner_title='资金汇总';
    $search=1;
    $type=intval($_GPC['type']);
    $type_time=util::getStrtotime($type);
    $start=$type_time[0];
    $end=$type_time[1];
    $list=Array();

//商品订单金额统计
    $list[0]['name']='商品订单' ;
    $data = pdo_fetch('SELECT sum(price) as num FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']}  AND createtime >= {$start}  AND createtime <= {$end} AND status=3");
    $list[0]['num']=$data['num'] ;

//优惠买单金额统计
    $list[1]['name']='优惠买单' ;
    $data = pdo_fetch('SELECT sum(paymoney) as num FROM ' . tablename(DISCOUNT_RE) . " WHERE uniacid = {$_W['uniacid']} AND createtime >= {$start}  AND createtime <= {$end} AND status=1");
    $list[1]['num']=$data['num'] ;

//信息发布金额统计
    $list[2]['name']='信息发布' ;
    $data = pdo_fetch('SELECT sum(price) as num FROM ' . tablename(INFOORDER) . " WHERE weid = {$_W['uniacid']}  AND createtime >= {$start}  AND createtime <= {$end} AND status=1");
    $list[2]['num']=$data['num'] ;

 //置顶信息统计
    $list[3]['name']='信息置顶' ;
    $data = pdo_fetch('SELECT sum(price) as num FROM ' . tablename(ZDORDER) . " WHERE weid = {$_W['uniacid']}  AND createtime >= {$start}  AND createtime <= {$end} AND status=1");
    $list[3]['num']=$data['num'] ;

    include $this->template('../mobile/admin_statistics');
    exit();
}elseif($op=='info_statistics') {
    $banner_title = '数据统计';
    $search=1;
    $type=intval($_GPC['type']);
    $type_time=util::getStrtotime($type);
    $start=$type_time[0];
    $end=$type_time[1];
    $channel_where['id>']=1;
    $list=util::getAllDataBySingleTable(CHANNEL,$channel_where,'id','id,name',2);
    foreach ($list as $k => $v){
        $data = pdo_fetch('SELECT count(id) as num FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} AND mid = {$v['id']} AND createtime >= {$start} AND createtime <= {$end} ");
        $list[$k]['num']=$data['num'];
    }

    include $this->template('../mobile/admin_statistics');
    exit();
}elseif($op=='account') {//提现管理
    $banner_title='提现管理';
    $input_detail='店铺名称';
    $id=intval($_GPC['id']);
    if($id>0){//详情页
        $search=1;
        $item=commonGetData::getAccountDetail($id);
    }else {//列表页
        if ($starttime) {
            $sqlweher .= ' and a.addtime >=' . $starttime;
        }
        if ($endtime) {
            $sqlweher .= ' and a.addtime <=' . $endtime;
        }
        if ($keyword) {
            $sqlweher .= " and s.shop_name LIKE '%{$keyword}%'";
        }
        $status = intval($_GPC['status']);
        $list =Admin::getAccount_applay($openid,$status,$pageStart,$num,$sqlweher);
        if ($_GPC['isajax'] == "1") {
            echo json_encode(array('status' => '1', 'length' => count($list), 'list' => $list));
            exit;
        }
    }
    include $this->template('../mobile/admin_account_list');
    exit();
}

