<?php
global $_GPC,$_W;
//if(!$_W['isajax']) die;
$op=$_GPC['op'];
if($op == 'changearea'){
    $city_id = intval($_GPC['id']);
    if( $city_id){
        $condition="and city_id=".$city_id;
    }
    $list = pdo_fetchall(" SELECT area_id as id,area_name as name FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}' {$condition} ORDER BY  orderby asc");
    if (!empty($list)) {
        echo json_encode(array('status'=>'1','list'=>$list,));
    }else{
        echo json_encode(array('status'=>'2','str'=>'暂时没有数据'));
    }

    exit;

}if($op == 'changearea2'){
    $city_id = intval($_GPC['id']);
    if(!$city_id){
        echo json_encode(array('status'=>'2','str'=>'请先选择城市'));
    }
    if( $city_id){
        $condition="and city_id=".$city_id;
    }
    $list = pdo_fetchall(" SELECT area_id as id,area_name as name FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}' {$condition} and (parent_id is null or parent_id=0) ORDER BY  orderby asc");

    if (!empty($list)) {
        echo json_encode(array('status'=>'1','list'=>$list,));
    }else{
        echo json_encode(array('status'=>'2','str'=>'暂时没有数据'));
    }

    exit;

}elseif($op == 'changebusiness'){
    $area_id = intval($_GPC['id']);
    if( $area_id){
        $condition="and parent_id=".$area_id;
    }
    $list = pdo_fetchall(" SELECT area_id as id,area_name as name FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}' {$condition}  and (parent_id is not null or parent_id!=0) ORDER BY  orderby asc");

    if (!empty($list)) {
        echo json_encode(array('status'=>'1','list'=>$list,));
    }else{
        echo json_encode(array('status'=>'2','str'=>'暂时没有数据'));
    }

    exit;

}elseif($op == 'changeline'){
    $cate_id = intval($_GPC['id']);
    if( $cate_id){
        $condition="and parent_id=".$cate_id;
    }

    $list = pdo_fetchall("SELECT cate_id as id,cate_name as name FROM " . tablename(CATE) . " WHERE uniacid = '{$_W['uniacid']}' {$condition}  ORDER BY orderby DESC");

    if (!empty($list)) {
        echo json_encode(array('status'=>'1','list'=>$list,));
    }else{
        echo json_encode(array('status'=>'2','str'=>'暂时没有数据'));
    }

exit;

}elseif ($op == 'status') {
    $id = intval($_GPC['shop_id']);
    $opt= intval($_GPC['opt']);
    $data = array('status' => $opt);
    pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    if($opt==1){
        $info="开启店铺";
    }else {
        $info = "暂停店铺";
    }
    echo json_encode(array('status'=>'1','str'=>$info.'操作成功！'));
    exit;
}elseif ($op == 'is_hot') {
    $id = intval($_GPC['shop_id']);
    $opt= intval($_GPC['opt']);
    $data = array('is_hot' => $opt);
    pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    if($opt==1){
        $info="首页推荐";
        pdo_delete(SHOP_APPLY, array('shop_id' => $id,'f_type' => '2','uniacid' => $_W['uniacid']));
        //'0无申请 1入驻申请，2首页推荐，3秒杀，4拼团，5优惠买单'
    }else {
        $info = "取消首页推荐";
    }   
    echo json_encode(array('status'=>'1','str'=>$info.'操作成功！'));
    exit;
}elseif ($op == 'is_group') {
    $id = intval($_GPC['shop_id']);
    $opt= intval($_GPC['opt']);
    $data = array('is_group' => $opt);
    pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    if($opt==1){
        $info="开启拼团";
        pdo_delete(SHOP_APPLY, array('shop_id' => $id,'f_type' => '4','uniacid' => $_W['uniacid']));
        //'0无申请 1入驻申请，2首页推荐，3秒杀，4拼团，5优惠买单'
    }else {
        $info = "关闭拼团";
    }    
    echo json_encode(array('status'=>'1','str'=>$info.'操作成功！'));
    exit;
}elseif ($op == 'is_discount') {
    $id = intval($_GPC['shop_id']);
    $opt= intval($_GPC['opt']);
    $data = array('is_discount' => $opt);
    pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    if($opt==1){
        pdo_delete(SHOP_APPLY, array('shop_id' => $id,'f_type' => '5','uniacid' => $_W['uniacid']));
        //'0无申请 1入驻申请，2首页推荐，3秒杀，4拼团，5优惠买单'
        $info="开启优惠买单";
    }else {
        $info = "关闭优惠买单";
    }
    echo json_encode(array('status'=>'1','str'=>$info.'操作成功！'));
    exit;
}elseif ($op == 'is_time') {
    $id = intval($_GPC['shop_id']);
    $opt= intval($_GPC['opt']);
    $data = array('is_time' => $opt);
    pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
    if($opt==1){
        $info="开启秒杀";
        pdo_delete(SHOP_APPLY, array('shop_id' => $id,'f_type' => '3','uniacid' => $_W['uniacid']));
    }else {
        $info = "关闭秒杀";
    }
    echo json_encode(array('status'=>'1','str'=>$info.'操作成功！'));
    exit;
}elseif ($op == 'addtime') {
    $timestart = intval($_GPC['timestart']);
    $timeend = intval($_GPC['timeend']);
    $timenum= pdo_fetch("SELECT count(*)as num FROM ".tablename(MSTIME)." WHERE uniacid = {$_W['uniacid']} and timestart ={$timestart} and timeend= {$timeend}  ");
    if($timenum['num']>=1){
        echo json_encode(array('status'=>'0','str'=>'专场已存在'));
        exit;
    }
    $data = array('timestart' => $timestart,'timeend' => $timeend,'uniacid' => $_W['uniacid']);
    $res =pdo_insert(MSTIME, $data);
    $id = pdo_insertid();
    echo json_encode(array('status'=>'1','id'=>$id));
    exit;
}elseif ($op == 'deletetime') {
    $time_id = intval($_GPC['id']);
    pdo_delete(MSTIME, array('time_id' => $time_id,'uniacid' => $_W['uniacid']));
    echo json_encode(array('status'=>'1'));
    exit;
}elseif ($op == 'admin_status') {//店铺管理员状态
    $admin_id = intval($_GPC['admin_id']);
    $opt= intval($_GPC['opt']);
    $data = array('status' => $opt);
    pdo_update(SHOP_ADMIN, $data, array('admin_id' => $admin_id, 'shop_id' =>getShop_id(),'uniacid' => $_W['uniacid']));
    echo json_encode(array('status'=>'1','str'=>'操作成功',));
    exit;
}elseif ($op == 'a_admin_status') {//管理员
    $admin_id = intval($_GPC['admin_id']);
    $opt= intval($_GPC['opt']);
    $data = array('status' => $opt);
    pdo_update(ADMIN, $data, array('admin_id' => $admin_id, 'uniacid' => $_W['uniacid']));
    echo json_encode(array('status'=>'1','str'=>'操作成功',));
    exit;
}elseif ($op == 'msg_flag') {
    $admin_id = intval($_GPC['admin_id']);
    $opt= intval($_GPC['opt']);
    $data = array('msg_flag' => $opt);
    pdo_update(SHOP_ADMIN, $data, array('admin_id' => $admin_id, 'shop_id' => getShop_id(),'uniacid' => $_W['uniacid']));
    echo json_encode(array('status'=>'1','str'=>'操作成功',));
    exit;
}elseif ($op == 'a_msg_flag') {
    $admin_id = intval($_GPC['admin_id']);
    $opt= intval($_GPC['opt']);
    $data = array('msg_flag' => $opt);
    pdo_update(ADMIN, $data, array('admin_id' => $admin_id, 'uniacid' => $_W['uniacid']));
    echo json_encode(array('status'=>'1','str'=>'操作成功',));
    exit;
}elseif( $_GPC['op'] == 'queue'){
    //Util::deleteCache('sq_queue','sq_q');//===调试
    for( $i = 0;$i<3;$i++ ){
        $cache = Util::getCache('sq_queue','sq_q');
        if( empty( $cache ) || $cache['time'] < (time()- 40) ){
            if( $i == 2 ){
                $url = Util::createModuleUrl('message',array('op'=>1));
                $res = Util::http_request($url);
                die('----status:0----');
            }
            sleep(1);
        }else{
           die('----status:1----');
        }

       }
    echo json_encode(array('status'=>'3','str'=>'该请求没有数据'+$_GPC['op'],));
    exit;
}elseif( $_GPC['op'] == 'recash'){//付款给申请的商户
    //验证是否管理员
    $openid = $_GPC['openid'];
    if($openid){
        $a_data=$this->checkAdmin($openid);
        if(empty($a_data)){
            echo json_encode(array('status'=>'0','str'=>'您不是管理员或管理员身份已失效',));
            exit;
        }
    }elseif(! $_W['isfounder']){
        echo json_encode(array('status'=>'0','str'=>'此项操作必须站长权限',));
        exit;
    }
    //验证是否存在该提现申请
    $id = intval($_GPC['id']);
    $item=commonGetData::getAccountDetail($id,' and a.status=0');
    $shop_id=intval($item['shop_id']);
    if(empty($item)){
        echo json_encode(array('status'=>'0','str'=>'申请不存在或已处理'));
        exit;
    }
    //1同意申请 2驳回申请
    $type = intval($_GPC['type']);
    if($type==1 && $item['paytype']==1){//同意申请：微信（企业直接付给个人）支付
        $amount=$item['amount'];
        $desc=$this->module['config']['index_title'];
        if($shop_id>0){
            $desc.='-商户提现';
        }else{
            $desc.='-会员提现';
        }
        if(empty($desc)){
            $desc= $_W['uniaccount']['name'];
        }
        $core=new Core();
        $res=$core->wechat_MchPay($item['openid'], $amount, $item['ordersn'],$desc );
        if($res['status']==0){
            echo json_encode(array('status'=>'0','str'=>$res['str']));
            exit;
        }
    }elseif( $type==1 && $item['paytype']==4){//同意申请：微信（企业直接付给个人）支付)
        if($item['type']=='1'){
           $tag='用户提现至余额' ;
        }else if($item['type']=='1'){
            $tag='商户提现至余额' ;
        }
        $re = Member::updateUserMoney($item['openid'], $item['amount'], 6, $tag);
        $credits = commonGetData::getUserCreditList($item['openid']);
        $_fee=floatval($credits['credit2']);
        $word="恭喜您，提现：".$item['amount']."元现金已到账\\n您现在的余额为：". $_fee."元";
        $this->rep_text($item['openid'], $word);
    }
    //更新状态
    pdo_update(ACCOUNT, array('status'=>$type,'checktime'=>TIMESTAMP,'check_admin'=>$a_data['admin_id']), array('cash_id' => $id,'uniacid' => $_W['uniacid']));
    if($type==2){//驳回申请，把余额也返回，并通知用户
        if( $shop_id>0){
            $shop=Shop::getShopInfo($shop_id);
            $acc=$item['amount']+$item['transfer'];
            $balance=$shop['balance']+$acc;//返回余额
            pdo_update(SHOP, array('balance' =>$balance), array('shop_id' =>$shop_id,'uniacid'=>$_W['uniacid']));
        }else{//用户提现返回
            $member=Member::getMemberByopenid($item['openid']);
            $acc=$item['amount']+$item['transfer'];
            $balance=$member['balance']+$acc;//返回余额
            pdo_update(MEMBER, array('balance' =>$balance), array('openid' =>$item['openid'],'uniacid'=>$_W['uniacid']));
        }
        $userinfo = Member::getSingleUser($item['openid']); //用户信息
        message::amount($item['openid'],'很抱歉，您的提现申请被驳回，余额已原路返还，请您重新申请',$acc,$userinfo['nickname'],TIMESTAMP,$id,intval($item['paytype']),'点击查看详情');
    }
    echo json_encode(array('status'=>'1'));
    exit;
}elseif($op == 'getChildCate'){//查询同城分类的子类
    $id = intval($_GPC['id']);
    $data=util::getAllDataBySingleTable(CHANNEL,array('fid'=>$id),'displayorder asc ','id,name,thumb','2');
    foreach ($data as $k=> $v){
        if($v['thumb']){
            $data[$k]['thumb']=tomedia($v['thumb']);
        }
    }
    echo json_encode(array('status'=>'1','list'=>$data,'len'=>count($data)));
    exit;
}elseif($op=='getChanne'){
    $flag=$_GPC['flag'];
    $condition='';
    if($flag=='msglist'){
        $flag_num=2;
    }else{
        $flag_num=1;
    }
    $list= commonGetData::getChannel(2,$flag_num);
    echo json_encode(array('status'=>'1','list'=>$list,'len'=>count($list)));
    exit;
}elseif($op=='getAddress'){
    $address = pdo_fetchall("select * from " . tablename(ADDRESS) . " where  uniacid='{$_W['uniacid']}' and openid='{$_W['openid']}' order by id desc ");
    echo json_encode(array('status'=>'1','list'=>$address,'len'=>count($address)));
    exit;
}


