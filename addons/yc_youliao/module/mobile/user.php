<?php
//checkauth();
load()->model('mc');
global $_GPC,$_W;
$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$title=$cfg['index_title']." 个人中心";
$userinfo = Member::initUserInfo(); //用户信息
$openid=$from_user=$this->getOpenid();
$userinfo = Member::getMemberByopenid($openid);
$credits = commonGetData::getUserCredit($from_user);
$page =$this->getPage();
$pageIndex =$this->pageIndex();
$num = $this->getNum(); //每次取值的个数
$adv_type=13;
$getAdvData=commonGetData::getAdv($adv_type);
$userbg= $getAdvData[0];
$isadmin=$this->checkAdmin($openid);
$isshop_admin=$this->isshop_admin();
if($op=="mydiscount"){//我的买单
    $title='优惠买单列表 '. $cfg['index_title'];
    $data=commonGetData::getDiscount($page,$num,$userinfo['id']);
    $list=$data[0];
    if($_GPC['isajax']==1) {
        $info=Array();
        foreach ($list as $k => $v) {
            $v['createtime']=date('Y-m-d H:i', $v['createtime']);
            $v['logo']=$_W['attachurl'].$v['logo'];
            $info[]=$v;
        }
        echo json_encode(array('result'=>'1','list'=>$info,'length'=>count($info)));
        exit;
    }
    include $this->template('../mobile/mydiscount');
    exit();
}elseif($op=="shop_in") {//商家入驻
    if ($cfg['shop_enter']==1) message('入驻申请已关闭，请联系管理员',referer());
    $a_data=$this->checkAdmin($openid);
    $shop_id=intval($_GPC['shop_id']);
    if($shop_id>0 && !empty($a_data)){
        $where['shop_id'] = $shop_id;
    }else{
        $where['mid'] = $userinfo['id'];
    }
    $item = util::getSingelDataInSingleTable(SHOP, $where);
    //检查是否是管理员进入审核状态
    if(!empty($a_data) && $item['status']==0 && $_GPC['check']==1)$check=1;

    if ($_GPC['po']=='1') {
        $re=util::getSingelDataInSingleTable(SHOP_APPLY,array('f_type'=>1,'mid'=>$userinfo['id'],'uniacid' => $_W['uniacid']));
        if(!empty($re)){//检查是否有申请过
            message('您的申请正在审核', $this->createMobileUrl('user'), 'success');
        }
        $res=Shop::editShopInfo($userinfo['id'],$item['shop_id'],0);
        $res1=intval($res);
        //是否需要收费
        $type=intval($_GPC['shop_renew']);
        if($type==1){//'1续1年，2续2年，3续3年'
            $price=$cfg['one_year_money'];
        }elseif($type==2){
            $price=$cfg['two_year_money'];
        }elseif($type==3){
            $price=$cfg['three_year_money'];
        }
        if(empty($price)){//未填写入驻套餐，免费入驻
            $status=1;
        }else{
            $status=0;
        }
        $ordersn=Shop:: insertRenew($type,$status, $price,$cfg,0,$res1,$userinfo['id']);
       if($res1>0 && $status==1){//免费入驻1年，提交入驻成功
           //通知管理员
           $renew=util::getYearStamp();
           pdo_update(SHOP,array('endtime'=> TIMESTAMP+$renew),array('shop_id'=>$shop_id,'uniacid'=>$_W['uniacid']));
           $url= Util::createModuleUrl('shop_admin',array('shop_id'=>$res1,'op'=>'info','check'=>1));
           $name='店铺入驻';
           Message::admin_checkmsg('有新的商家入驻!',$url,$name,$userinfo['nickname'],TIMESTAMP);
           message('提交成功', $this->createMobileUrl('user'), 'success');
           exit();
       }elseif($res1>0 && $status==0){//需要交费才能入驻
           $params = array(
               'tid' => 'renew' . $ordersn,      //此号码用于业务模块中区分订单，交易的识别码
               'ordersn' => $ordersn,  //收银台中显示的订单号
               'title' => $_GPC['shop_name'] . '--商户入驻缴费',          //收银台中显示的标题
               'fee' => $price,      //收银台中显示需要支付的金额,只能大于 0
               'user' => $openid,     //付款用户, 付款的用户名(选填项)
           );
           $result = commonGetData::insertlog($params);
           if ($result == 1) {
               $this->pay($params);
               exit();
           }
       }elseif($res1==0){
            message($res);
        }

    }

    $adv_type=12;//1首页，4拼团，5秒杀，6首单，7买单，8同城,9附近，10圈子，11支付页面 12商家入驻
    $title="商家入驻 ".$cfg['index_title'];
    $cate = pdo_fetchall("SELECT * FROM " . tablename(CATE) . " WHERE uniacid = '{$_W['uniacid']}' and (parent_id =0 or parent_id is null) ORDER BY orderby DESC");
    $ccate = pdo_fetchall("SELECT * FROM " . tablename(CATE) . " WHERE uniacid = '{$_W['uniacid']}' and parent_id >0 ORDER BY orderby DESC");
    $city = pdo_fetchall(" SELECT * FROM " . tablename(CITY) . " WHERE  uniacid = '{$_W['uniacid']}' ORDER BY  orderby asc");
    $area = pdo_fetchall(" SELECT * FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}'  and (parent_id =0 or parent_id is null) ORDER BY  orderby asc");
    $business = pdo_fetchall(" SELECT * FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}'  and parent_id >0 ORDER BY  orderby asc");

    $contract=commonGetData::sensitiveword(1);
    $contract=$contract['contract'];
    include $this->template('../mobile/shop_in');
    exit();
}elseif($op=="myinfo"){//我的资料
    $title="商家入驻 ".$cfg['index_title'];
    if(checksubmit('submit')) {
//    print_r($_POST);
//    exit;

        $telphone=$_GPC['telphone'];
        if($telphone){
            if (!$this->isMobile($telphone)) {
                message('请填写正确的手机号码',referer());
            }
        }
        $data = array(
            'nickname' =>addslashes($_GPC['nickname']),
            'telphone' =>addslashes( $telphone),
            'gender' => addslashes(intval( $_GPC['gender'])),
        );
        $avatar=$_GPC['avatar'];
        if($avatar){
            $re=util::SaveAjaxUpload( $avatar);
            if($re){
                $data['avatar']=addslashes($re);
            }

        }

        pdo_update(MEMBER, $data, array('openid' => $from_user));
        Util::deleteCache('fsuser', $from_user);

        message('提交成功',$this->createMobileUrl('user', array('op' => 'myinfo')), 'success');
    }
    include $this->template('../mobile/myinfo');
    exit();
}elseif($op=="mycollect"){//我的收藏：1同城信息 2收藏的商品 3收藏的店铺
    $title=$cfg['index_title']." 我的收藏";
    $type=intval($_GPC['type']);
    $shop_id=intval($_GPC['shop_id']);
    $goods_id=intval($_GPC['goods_id']);
     if($_GPC['collect']=='add'){//添加收藏
        if(empty($shop_id) || empty($from_user)){
            echo json_encode(array('result'=>'0'));
            exit;
        }

         $data['openid'] = $from_user;
         if(intval($_GPC['goods_id'])>0){
             $data['goods_id'] = $goods_id;
             $data['type'] = 2;
         }else{
             $data['type'] = 3;
         }
         $data['shop_id'] = $shop_id;
         $coll=util::getAllDataBySingleTable(COLLECT,$data,'id','id','2');
         $data['weid'] = $_W['uniacid'];
         $data['time'] = TIMESTAMP;
        if(empty($coll)){
            pdo_insert(COLLECT,$data);
        }
         echo json_encode(array('result'=>'1'));
         exit;
     }else if($_GPC['collect']=='cancel'){//取消收藏
         $id = intval($_GPC['id']);
         pdo_delete(COLLECT,array('weid'=>$_W['uniacid'],'openid'=>$from_user,'id'=>$id));
         echo json_encode(array('result'=>'1'));
         exit;
     }
     //展示数据
    $where['openid'] =$from_user;
    $where['type'] =$type;
    if($type==1){//同城信息
        $info=new Info();
        $list=$info->getCollect  ($from_user,$page,$num);
        include $this->template('../mobile/mycollect');
        exit();
    }elseif($type==2){//商品
        $name = 'goods_id';
    }elseif($type==3){//店铺
        $name= 'shop_id';
    }
    $co=util::getAllDataBySingleTable(COLLECT,$where,'id',$name.',id','2');
    if($co) {
        foreach ($co as $c) {
            $coll[] = $c[$name];
        }
        $c_list = pdo_fetchall("SELECT g.*, s.* FROM " . tablename(GOODS) .
            " g   left join " . tablename(SHOP) . "s on s.shop_id=g.shop_id and  s.uniacid=g.uniacid WHERE g." . $name . " IN ('" . implode("','", $coll) . "')", array(), $name);

        $new = array();
        foreach ($co as $c) {
            $new[$c[$name]] = $c;
        }
        foreach ($c_list as &$info) {
            $goodId = $info[$name];
            $info['id'] = $new[$goodId]['id'];
            $list[] = $info;
        }

    }
    include $this->template('../mobile/mycollect');
    exit();
}elseif($op=="address"){
    $shownotice= $this->checkUser();
    $cfg   		 = $this->module['config'];
    $qr_code =$this->getQr_code();
    $fans=mc_fansinfo($from_user,$_W['acid'],$_W['uniacid']);
    $modulephp='address';
    $signPackage = $this->getSignPackage($modulephp);
    $from = $_GPC['from'];
    $returnurl = urldecode($_GPC['returnurl']);
    $operation = $_GPC['type'];
    if ($operation == 'post') {
        $id = intval($_GPC['id']);
        $data = array('uniacid' => $_W['uniacid'], 'openid' => $from_user,'lat' => $_GPC['lat'], 'lng' => $_GPC['lng'], 'inco' => $_GPC['inco'], 'realname' => $_GPC['realname'], 'mobile' => $_GPC['mobile'], 'province' => $_GPC['province'], 'city' => $_GPC['city'], 'area' => $_GPC['area'], 'address' => $_GPC['address'],);
        if (empty($_GPC['realname']) || empty($_GPC['mobile']) || empty($_GPC['address'])) {
            message('请完善您的资料！');
        }
        if (!empty($id)) {
            unset($data['uniacid']);
            unset($data['openid']);
            pdo_update(ADDRESS, $data, array('id' => $id));
            message($id, '', 'ajax');
        } else {
            pdo_update(ADDRESS, array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'openid' => $from_user));
            $data['isdefault'] = 1;
            pdo_insert(ADDRESS, $data);
            $id = pdo_insertid();
            $uid=mc_openid2uid($from_user);
            $profile=mc_fetch($uid,array('realname','mobile'));
            if (empty($profile['realname']) || empty($profile['mobile'])) {
                mc_update($uid,array("mobile" => $_GPC['mobile']));
            }
            if (!empty($id)) {
                message($id, '', 'ajax');
            } else {
                message(0, '', 'ajax');
            }
        }
    } elseif ($operation == 'default') {
        $id = intval($_GPC['id']);
        pdo_update(ADDRESS, array('isdefault' => 0), array('uniacid' => $_W['uniacid'], 'openid' => $from_user));
        pdo_update(ADDRESS, array('isdefault' => 1), array('id' => $id));
        message(1, '', 'ajax');
    } elseif ($operation == 'detail') {
        $id = intval($_GPC['id']);
        $row = pdo_fetch("SELECT * FROM " . tablename(ADDRESS) . " WHERE id = :id", array(':id' => $id));
        message($row, '', 'ajax');
    } elseif ($operation == 'remove') {
        $id = intval($_GPC['id']);
        if (!empty($id)) {
            $address = pdo_fetch("select isdefault from " . tablename(ADDRESS) . " where id='{$id}' and uniacid='{$_W['uniacid']}' and openid='" . $from_user . "' limit 1 ");
            if (!empty($address)) {
                pdo_update(ADDRESS, array("deleted" => 1, "isdefault" => 0), array('id' => $id, 'uniacid' => $_W['uniacid'], 'openid' => $from_user));
                if ($address['isdefault'] == 1) {
                    $maxid = pdo_fetchcolumn("select max(id) as maxid from " . tablename(ADDRESS) . " where uniacid='{$_W['uniacid']}' and openid='" . $from_user . "' limit 1 ");
                    if (!empty($maxid)) {
                        pdo_update(ADDRESS, array('isdefault' => 1), array('id' => $maxid, 'uniacid' => $_W['uniacid'], 'openid' => $from_user));
                        die(json_encode(array("result" => 1, "maxid" => $maxid)));
                    }
                }
            }
        }
        die(json_encode(array("result" => 1, "maxid" => 0)));
    } else {

        $uid=mc_openid2uid($from_user);
        $profile=mc_fetch($uid,array('resideprovince','residedist','residedist','address','realname','mobile'));
        $address = pdo_fetchall("SELECT * FROM " . tablename(ADDRESS) . " WHERE deleted=0 and openid = :openid", array(':openid' => $from_user));
        if (empty($address) || count($address) == 0) {
            $useAddApi = true;
            if (!isset($_GPC['code'])) {
                $this->getUserTokenForAddr();
            }
            if (isset($_GPC['code']) && $_GPC['code'] != "authdeny") {
                $state = $_GPC['state'];
                $code = $_GPC['code'];
                $addressSignInfo = $this->getAddressSignInfo($code, "http://" . $_SERVER[HTTP_HOST] . "" . $_SERVER['REQUEST_URI'], $signPackage);
            }
        }

        $carttotal = $this->getCartTotal();
        include $this->template('../mobile/address');
        exit();

    }
}elseif($op=="withdraw") {//提现
    $item=$userinfo;
    $payType=$cfg['pay_type_user'];
    $transfer=$cfg['transfer_user'];//用户提现手续费
    $item['balance']=!empty($item['balance']) ? $item['balance'] :0;
    $transfer_min=!empty($cfg['transfer_min']) ? $cfg['transfer_min'] :1;//最低提现金额
    $transfer_max=!empty($cfg['transfer_max']) ? $cfg['transfer_max'] :20000;//最高提现金额
    if ($_GPC['submit_post']=='1') {
        $money =floatval($_GPC['money']);
        $transfer=$money*$transfer*0.01;
        $result=Shop::insertAccount($money,$transfer_min,$transfer_max,$transfer,0,$openid,2);
        if(intval($result)>0){
            $am=$money+$transfer;
            $acc=floatval($item['balance']-$am);
            pdo_update(MEMBER, array('balance' =>$acc), array('id' => $userinfo['id'],'uniacid'=>$_W['uniacid']));

            echo json_encode(array('status' => '1', 'str' => '提交成功'));
            exit;
        }else{
            echo json_encode(array('status' => '0', 'str' => $result));
            exit;
        }
    }
    include $this->template('../mobile/withdraw');
    exit();
}elseif($op=="withdraw_record") {//提现记录
    $id=intval($_GPC['id']);
    if($id>0) {//详情页
        $item = commonGetData::getAccountDetail($id);
    }else {
        $list = pdo_fetchall('SELECT * FROM ' . tablename(ACCOUNT) . " WHERE uniacid = {$_W['uniacid']} and openid ='{$openid}'   ORDER BY cash_id DESC LIMIT  {$pageIndex},{$num} ");
        if ($_GPC['isajax'] == "1") {
            echo json_encode(array('status' => '1', 'length' => count($list), 'type' => $type, 'list' => $list, 'flag' => 0));
            exit;
        }
    }
    include $this->template('../mobile/withdraw');
    exit();
}elseif($op=="red_record") {//红包和打赏记录
    //type=0发出的红包,type=1收到的红包,type=2发出的打赏,3收到的打赏
    $type=intval($_GPC['type']);
    $Redpackage=new Redpackage();
    if($type==0){
        $list =   $Redpackage ->getRedpackageRecordList($userinfo['openid'],$pageIndex,$num);
    }elseif($type==1){
        $list =   $Redpackage ->sendRedpackageRecordList($userinfo['openid'],$pageIndex,$num);
    }elseif($type==2){
        $list = $Redpackage->getShangRecordList($userinfo['openid'],$pageIndex,$num);
    }elseif($type==3){
        $list = $Redpackage->sendShangRecordList($userinfo['openid'],$pageIndex,$num);
    }
    if($_GPC['isajax']==1) {
        echo json_encode(array('result'=>'1','list'=>$list,'length'=>count($list),type=>$type));
        exit;
    }
    include $this->template('../mobile/red_record');
    exit();
}elseif($op=="msg") {//公告
    $msg_id=intval($_GPC['msg_id']);
    $type     = !empty($_GPC['type']) ? intval($_GPC['type']) :1;
    if($msg_id>0){
        $item=util::getSingelDataInSingleTable(MSG,array('msg_id'=>$msg_id));

        if($type==1){
            $tablename=MEMBER;
        }else{
            $tablename=SHOP_ADMIN;
        }
        $msg_id_str=pdo_fetchcolumn("select msg_id_str from ".tablename($tablename)." where openid='{$openid}' and uniacid = '{$_W['uniacid']}' ");
        $msg_arr=explode(',',$msg_id_str);
        $isin = in_array($msg_id,$msg_arr);
        if(! $isin){
            $msg_id_str2=$msg_id_str.','.$msg_id;
            $msg_id_str=trim($msg_id_str2,',');
            pdo_update($tablename,array('msg_id_str'=>$msg_id_str),array('openid'=>$openid));
        }
        include $this->template('../mobile/newsdetail');
        exit();
    }else{
        $openid=$_W['openid'];
        $data=pdo_fetchall("select * from ".tablename(MSG)." where status=1 AND type='{$type}'AND `uniacid` = " . $_W['uniacid'] ." order by msg_id desc limit {$pageIndex},{$num}");
        $list=array();
        foreach ($data as $k => $v) {
            $v['msg_content']= htmlspecialchars_decode($v['msg_content']);
            $list[]=$v;
        }
        if($_GPC['isajax']==1) {
            echo json_encode(array('result'=>'1','list'=>$list,'length'=>count($list)));
            exit;
        }
        include $this->template('../mobile/newslist');
        exit();
    }

}
//未读消息
$message=pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(CHAT)." WHERE weid = {$_W['uniacid']} AND toopenid = '{$openid}'AND hasread = 0");
$msg=Member::member_msg(1);
$msg_count=count($msg);
include $this->template('../mobile/user');
exit();
