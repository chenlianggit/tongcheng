<?php
class Shop{
    public  function postShopInfo($openid,$type=1){

        global $_GPC, $_W;
        $cfg=$this->module['config'];
        $member = pdo_fetch('SELECT id,nickname,openid,avatar FROM ' . tablename(MEMBER) . " WHERE openid = '{$openid}'");
        if (empty($member)) {
            $resArr['error'] = 1;
            $resArr['message'] = '获取您的信息失败！';
            return $resArr;
        }
        $id  = intval($_GPC['shop_id']);//更新还是新增
        $mid = intval($_GPC['mid']);
        $logo = $_GPC['logo'];
        $shop_name = $_GPC['shop_name'];
        $telphone = $_GPC['telphone'];
        $lng = trim($_GPC['lng']);
        $qr_code = $_GPC['imgUrl'];//门店照片
        $dp = $_GPC['dp'];
        if(!$shop_name){
            $resArr['error'] = 1;
            $resArr['message'] = '请输入店铺名称！';
            return $resArr;
        }
        if(!$logo){
            $resArr['error'] = 1;
            $resArr['message'] = '请上传店铺Logo！';
            return $resArr;
        }
        if(!$telphone){
            $resArr['error'] = 1;
            $resArr['message'] = '请输入手机号！';
            return $resArr;
        }
        if(!is_array($qr_code)){
            $resArr['error'] = 1;
            $resArr['message'] = '请上传门店照片！';
            return $resArr;
        }
        $qr_code = json_encode($qr_code);
        if ($mid <= 0) {
            $resArr['error'] = 1;
            $resArr['message'] = '项目加载失败！';
            return $resArr;
        }
        if (empty($lng)) {
            $resArr['error'] = 1;
            $resArr['message'] = '没有获取您所在的地理位置信息！';
            return $resArr;
        }
        if (!$dp) {
            $dp = '4.'.rand(0,99);//评分随机4或5
        }


        $data = array(
            'uniacid'       => $_W['uniacid'],
            'openid'        => $openid,
            'shop_name' 	=> $shop_name,  //店铺名称
            'logo'          => $logo,       //LOGO
            'telphone'      => $telphone,   //手机号码
            'qr_code'       =>  $qr_code,//门店照片
            'lng'           => $_GPC['lng'],//坐标
            'lat'           => $_GPC['lat'],//坐标
            'inco'          => json_encode( iunserializer($_GPC['inco'])),//商品标签
            'opendtime'     => $_GPC['opendtime'],  //开店时间
            'closetime'     => $_GPC['closetime'],  //打烊时间
            'intro'         => trim($_GPC['intro']),//简介
            'ccate_id'      => intval($_GPC['cate_id']),//类别
            'starttime'     => time(),//入驻时间
            'endtime'       => time() + (util::getYearStamp()) * 3,//到期时间 增加3年
            'status'        => 1,//已审核
            'dp'            => $dp,//点评满分5分
            'address'=> $_GPC['address'],//详细地址
            'manage'        => $member['nickname'],//联系人
        );
        if (!empty($id)) {
            unset($data['starttime']);
            unset($data['uniacid']);
            pdo_update(SHOP, $data, array('shop_id' => $id, 'uniacid' => $_W['uniacid']));
        } else {
            pdo_insert(SHOP, $data);
            $id = pdo_insertid();
            $resArr['message'] = '恭喜您，添加店铺成功！';
        }
        $resArr['error'] = 0;
        return $resArr;
//        $views_num=intval($cfg['views_num']);//随机最高浏览数量
//        if($views_num>0) {
//            $views = mt_rand(1, $views_num);//根据最大的积分数，随机获取签分
//            $data['views'] = $views;
//        }
//        //新增信息
//        pdo_insert(INFO, $data);
//        $message_id = pdo_insertid();
//        if ($moduleres['minscore'] > 0) {
//            $datascore['weid'] = $_W['uniacid'];
//            $datascore['openid'] = $member['openid'];
//            $datascore['num'] = $moduleres['minscore'];
//            $datascore['time'] = TIMESTAMP;
//            $datascore['explain'] = '发布信息奖励积分';
//            pdo_insert(INTEGRAL, $datascore);
//        }
//        if ($moduleres['isneedpay'] == 1 && $moduleres['needpay'] > 0) {
//            $ordersn = date('Ymd') . random(7, 1);
//            $dataorder['weid'] = $_W['uniacid'];
//            $dataorder['from_user'] = $member['openid'];
//            $dataorder['ordersn'] = $ordersn;
//            $dataorder['price'] = $moduleres['needpay'];
//            $dataorder['paytype'] = 1;
//            $dataorder['createtime'] = TIMESTAMP;
//            $dataorder['message_id'] = $message_id;
//            $dataorder['module'] = $mid;
//            pdo_insert(INFOORDER, $dataorder);
//            $resArr['ispay'] = 1;
//            $resArr['ordersn'] = $ordersn;
//        } else {
//            $resArr['ispay'] = 0;
//            $resArr['ordersn'] = '';
//        }
//
//        if($moduleres['isneedpay'] == 1){//需要支付
//            $resArr['message']=$tipinfo;
//            $resArr['ordersn']=$ordersn;
//        }elseif ($moduleres['isshenhe'] == 1 ) {//需要审核
//            $resArr['message'] = '恭喜您，添加信息成功，请等待管理员审核！';
//            //模板消息通知管理员审核
//            if($type==1){
//                $url= Util::createModuleUrl('detail',array('id'=>$message_id));
//                $name=$moduleres['name'];
//                Message::admin_checkmsg('您有一条审核提醒!',$url,$name,$member['nickname'],TIMESTAMP);
//            }
//
//        } else {//无需审核，无需支付
//            $resArr['message'] = '恭喜您，添加信息成功！';
//        }
//        $resArr['error'] = 0;
//        return $resArr;
    }


public static function getShopInfo($shop_id){
    global  $_GPC,$_W;
    $where               = " shop_id=:shop_id and uniacid=:uniacid";
    $params[":shop_id"] = $shop_id;
    $params[":uniacid"] = $_W['uniacid'];
    $re = pdo_fetch("select * from  ".tablename(SHOP)." where ".$where,$params);
    return $re;
}
    public static function getShopIsMy($shop_id,$openid){
        global  $_GPC,$_W;
        $where               = " shop_id=:shop_id and openid=:openid and uniacid=:uniacid ";
        $params[":shop_id"] = $shop_id;
        $params[":openid"] = $openid;
        $params[":uniacid"] = $_W['uniacid'];
        $re = pdo_fetch("select * from  ".tablename(SHOP)." where ".$where,$params);
        return $re;
    }
    public static function proCollect($openid){
        global $_W ,$_GPC;
        $shop_id = intval($_GPC['shop_id']);
        $collect = pdo_fetch("SELECT * FROM ".tablename(COLLECT)." WHERE weid = {$_W['uniacid']} AND openid = '{$openid}' AND shop_id = {$shop_id}");
        if(!empty($collect)){
            pdo_delete(COLLECT,array('weid'=>$_W['uniacid'],'openid'=>$openid,'shop_id'=>$shop_id));
            $resArr['error'] = 0;
            $resArr['message'] = "取消收藏成功！";
            return $resArr;
        }else{
            $data['weid'] = $_W['uniacid'];
            $data['openid'] = $openid;
            $data['shop_id'] = $shop_id;
            $data['time'] = TIMESTAMP;
            pdo_insert(COLLECT,$data);
            $resArr['message'] = "恭喜您，收藏成功！";
            $resArr['error'] = 0;
            return $resArr;
        }
    }
public static function getShop_name($shop_id){
    global  $_GPC,$_W;
    $where               = " shop_id=:shop_id and uniacid=:uniacid";
    $params[":shop_id"] = $shop_id;
    $params[":uniacid"] = $_W['uniacid'];
    $re = pdo_fetch("select * from  ".tablename(SHOP)." where ".$where,$params);
    return $re['shop_name'];
}
public static function getShopInfoAll($shop_id){
    global  $_GPC,$_W;
    $where               = " s.shop_id=:shop_id and s.uniacid=:uniacid";
    $params[":shop_id"] = $shop_id;
    $params[":uniacid"] = $_W['uniacid'];
    $re = pdo_fetch("select s.*,c.cate_name, a.area_name from  ".tablename(SHOP)." s left join ".tablename(CATE)." c on s.ccate_id=c.cate_id or s.pcate_id=c.cate_id and c.uniacid=s.uniacid  left join ".tablename(AREA)." a on a.area_id=s.business_id and a.uniacid=s.uniacid and s.status=1 where ".$where,$params);
    return $re;
}

public static function getShopType($cate_id){
    global  $_GPC,$_W;
    $where               = "  uniacid=:uniacid and cate_id=:cate_id";
    $params[":cate_id"] = $cate_id;
    $params[":uniacid"] = $_W['uniacid'];
    $re = pdo_fetchcolumn("select cate_type from  ".tablename(CATE)." where ".$where,$params);
    return $re;
}
public static function getApplynum($shop_id,$f_type){
    global  $_GPC,$_W;
    $where               = " shop_id=:shop_id and uniacid=:uniacid and f_type=:f_type";
    $params[":shop_id"] = $shop_id;
    $params[":uniacid"] = $_W['uniacid'];
    $params[":f_type"] = $f_type;
    $re = pdo_fetchcolumn("SELECT count(*) from  ".tablename(SHOP_APPLY)." where ".$where,$params);
    return $re;
    }


    public static function getSingleAccount($shop_id,$condition,$sqlwhere=''){
        global  $_GPC,$_W;
        $where='';
        if(intval($shop_id)>0){
        $where.= " and shop_id=".$shop_id;
        }
        if($condition==1){
        $re = pdo_fetch("select * from  ".tablename(ACCOUNT)." where uniacid = '{$_W['uniacid']}'  ".$where.' order by cash_id desc limit 1');
        }else{
        $re = pdo_fetchall("select * from  ".tablename(ACCOUNT)." where uniacid = '{$_W['uniacid']}'  ".$where.$sqlwhere.' order by cash_id desc ');
        }
        return $re;
        }

    public static function postAccountApplay($shop,$transfer_min,$transfer_max ,$admin_id,$transfer){
    global  $_GPC,$_W;
    $balance=$shop['balance'];
    $shop_id=$shop['shop_id'];
         if( $balance<=1){
             return '可提现金额小于1元';
            }
        $money =round($_GPC['money'],2);

        if ( $money > $balance)
        {
            return '余额不足，无法提现';
        }
        $transfer=floatval($money*$transfer*0.01);
        $id = self::insertAccount($money,$transfer_min,$transfer_max,$transfer,2,$shop,$admin_id);
        //减去申请提现的金额
         if(intval($id)>0){
            $am=$money+$transfer;
            $acc=$balance-$am;
            pdo_update(SHOP, array('balance' =>$acc), array('shop_id' => $shop_id,'uniacid'=>$_W['uniacid']));
            return $id;
         }else{
                return $id;
            }


    }
    public static function insertAccount($money,$transfer_min,$transfer_max,$transfer,$type,$shop='',$admin_id=0){
        global  $_GPC,$_W;
         if($type==2){
             $shop_id=$shop['shop_id'];
             $where['status'] = 0;
             $where['admin_id'] = $admin_id;
             $a_data = util::getSingelDataInSingleTable(SHOP_ADMIN, $where, 'admin_type,openid');
             if($a_data['admin_type']!=1 ){
                 return '您没有提现权限';
             }
             $openid=$a_data['openid'];
             $title='店铺['.$shop['shop_name'].']申请提现';
         }else{
             $openid=$_W['openid'];
             $title='会员提现申请';
         }
        if ($money < $transfer_min || $money > $transfer_max )
        {
            return '申请需金额需小于等于'.$transfer_max.'元，大于等于'.$transfer_min.'元';
        }
        $paytype=intval($_GPC['paytype']);
        $alipay_account=$_GPC['alipay_account'];
        $alipay_name=$_GPC['alipay_name'];
        $bank_num=$_GPC['bank_num'];
        $bank_realname=$_GPC['bank_realname'];
        $bank_branch=$_GPC['bank_branch'];
        $arr = array();
        if($paytype==0) {
            return '请选择提现方式';
        }if($paytype==2) {//支付宝
            if($alipay_account==''){
                return '请检查支付宝账号';
            }
            if( $alipay_name==''){
                return '请检查支付宝姓名';
            }
        }elseif($paytype==2) {//银行卡
            if( $bank_num==''){
                return '请检查银行卡账号';
            }
            if($bank_realname==''){
                return '请检查银行卡姓名';
            }
            if($bank_branch==''){
                return '请检查开户银行';
            }
        }

        $ordersn=util::getordersn(ACCOUNT);

        $arr['uniacid'] = $_W['uniacid'];
        $arr['ordersn'] = $ordersn;
        $arr['admin_id'] = $admin_id;
        $arr['shop_id'] = $shop_id;
        $arr['amount'] = $money;
        $arr['transfer'] = $transfer;
        $arr['addtime'] =TIMESTAMP;
        $arr['alipay_account'] = $alipay_account;
        $arr['alipay_name'] = $alipay_name;
        $arr['bank_num'] = $bank_num;
        $arr['bank_realname'] =$bank_realname;
        $arr['bank_branch'] = $bank_branch;
        $arr['paytype'] = $paytype;
        $arr['openid'] = $openid;
        $arr['type'] = $type;
        //提现记录表插入提现记录
        pdo_insert(ACCOUNT, $arr);
        $id = pdo_insertid();

        //通知管理员
        if(intval($id)==0){return '数据有误';}
        $member_where['openid']=$_W['openid'];
        $admin_user=util::getSingelDataInSingleTable(MEMBER,$member_where,'nickname');
        $paytype=intval($_GPC['paytype']);
        if($transfer>0){
            $transfer='(含手续费：'.$transfer.'元)';
        }else{
            $transfer='(免手续费)';
        }
        $am=$money+$transfer;
        Message::admin_acount($title,'￥'.$am.$transfer,$admin_user['nickname'],TIMESTAMP,$id,$paytype);
        return $id ;
    }

    public static function getCate(){
    global  $_GPC,$_W;
     $cate = pdo_fetchall("SELECT * FROM " . tablename(CATE) . " WHERE uniacid = '{$_W['uniacid']}' and (parent_id =0 or parent_id is null) ORDER BY orderby DESC");
     return $cate;
    }

     public static function getCcate(){
      global  $_GPC,$_W;
     $ccate = pdo_fetchall("SELECT * FROM " . tablename(CATE) . " WHERE uniacid = '{$_W['uniacid']}' and parent_id >0 ORDER BY orderby DESC");
     return $ccate;
    }
    public static function getCity(){
      global  $_GPC,$_W;
    $city = pdo_fetchall(" SELECT * FROM " . tablename(CITY) . " WHERE  uniacid = '{$_W['uniacid']}' ORDER BY  orderby asc");
     return $city;
    }

   public static function getArea(){
      global  $_GPC,$_W;
     $area = pdo_fetchall(" SELECT * FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}'  and (parent_id =0 or parent_id is null) ORDER BY  orderby asc");
     return $area;
    }
    public static function getBusiness(){
      global  $_GPC,$_W;
    $business =pdo_fetchall(" SELECT * FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}'  and parent_id >0 ORDER BY  orderby asc");
     return $business;
    }

    public static function editShopInfo($userid,$shop_id,$status){
     global  $_GPC,$_W;
        if (empty($_GPC['shop_name'])) return '店铺名称不能为空！';
        if (empty($_GPC['telphone']))return '联系电话不能为空！';
                $shop_in_data = array('uniacid' => $_W['uniacid'],
                'shop_name' => $_GPC['shop_name'],
                'city_id' => intval($_GPC['city_id']),
                'area_id' => intval($_GPC['area_id']),
                'business_id' => intval($_GPC['business_id']),
                'pcate_id' => intval($_GPC['pcate_id']),
                'ccate_id' => intval($_GPC['ccate_id']),
                'telphone' => $_GPC['telphone'],
                'manage' => $_GPC['manage'],
                'mid' =>$userid,
                 'lng' => $_GPC['lng'],
                 'lat' => $_GPC['lat'],
                  'intro' => trim($_GPC['intro']),
                 'inco'=>json_encode( iunserializer($_GPC['inco'])),//商品标签
                 'renjun' => $_GPC['renjun'],
                'opendtime' => $_GPC['opendtime'],
                'address' => $_GPC['address'],
                'address_detail' => $_GPC['address_detail'],
                'closetime' => $_GPC['closetime'],
            );
            if($status==0){//未成功入驻
            $shop_in_data['starttime'] = TIMESTAMP;
            $shop_in_data['status'] = $status;
            }
            $img_dir = util::getimgdir();//存入图片路径
            $type = strtolower($_FILES["logo"]["type"]);
            if (($type == "image/gif" || $type == "image/jpg" || $type == "image/jpeg" || $type == "image/png")
                //&& ($_FILES["logo"]["size"]) < 20000
            ) {//logo
                $logo = $_FILES["logo"]["tmp_name"];
                $logoname = util::createimgname();//建立图片名
                $logo_url = $img_dir . $logoname;//图片路径+图片名
                move_uploaded_file($logo, IA_ROOT . '/attachment/' . $logo_url);
                if (!empty($_W['setting']['remote']['type'])) { // 判断系统是否开启了远程附件
                    $logo_url = util::checkdir($logo_url);
                }
                $shop_in_data['logo'] = $logo_url;
            }

            $cert_type = strtolower($_FILES["shop_cert"]["type"]);
            if (($cert_type == "image/gif" || $cert_type == "image/jpg" || $cert_type == "image/jpeg" || $cert_type == "image/png") ) {//营业执照&& ($_FILES["shop_cert"]["size"] < 20000)
                $cert = $_FILES["shop_cert"]["tmp_name"];
                $certname = util::createimgname();
                $cert_url = $img_dir . $certname;
                move_uploaded_file($cert, IA_ROOT . '/attachment/' . $cert_url);
                if (!empty($_W['setting']['remote']['type'])) { // 判断系统是否开启了远程附件
                    $cert_url = util::checkdir($cert_url);
                }
                $shop_in_data['shop_cert'] = $cert_url;
            }

        $bgpic_type = strtolower($_FILES["bgpic"]["type"]);
        if (($bgpic_type == "image/gif" || $bgpic_type == "image/jpg" || $bgpic_type == "image/jpeg" || $bgpic_type == "image/png") ) {//营业执照&& ($_FILES["shop_cert"]["size"] < 20000)
            $cert = $_FILES["bgpic"]["tmp_name"];
            $certname = util::createimgname();
            $bgpic_url = $img_dir . $certname;
            move_uploaded_file($cert, IA_ROOT . '/attachment/' . $bgpic_url);
            if (!empty($_W['setting']['remote']['type'])) { // 判断系统是否开启了远程附件
                $bgpic_url = util::checkdir($bgpic_url);
            }
            $shop_in_data['bgpic'] = $bgpic_url;
        }

            if (!empty($shop_id)) {
                pdo_update(SHOP, $shop_in_data, array('shop_id' => $shop_id, 'uniacid' => $_W['uniacid']));

            } else {
                pdo_insert(SHOP, $shop_in_data);
                $shop_id = pdo_insertid();

            }
            $apply_data = array('uniacid' => $_W['uniacid'],
                'shop_id' => $shop_id,
                'f_type' => 1,
                'mid' =>$userid,
                'applytime' => TIMESTAMP
            );
            pdo_insert(SHOP_APPLY, $apply_data);
            return $shop_id;
    }


    public static function insertRenew($type,$status, $price,$cfg,$flag,$shop_id,$mid){
        global  $_GPC,$_W;
        $ordersn=util::getordersn(RENEW);
        $in=Array();
        $in['uniacid']=$_W['uniacid'];
        $in['ordersn']=$ordersn;
        $in['mid']=$mid;
        $in['price']=$price;
        $in['createtime']=TIMESTAMP;
        $in['type']=$type;
        $in['flag']=$flag;
        $in['shop_id']=$shop_id;
        $in['status']=$status;
        pdo_insert(RENEW,$in);
        return $ordersn;
    }

    public static function getShopRenew($shop_id=0,$sqlwhere='',$id=0){
        global  $_GPC,$_W;
        if($shop_id>0){
            $where= ' and s.shop_id='.$shop_id;
        }
        if($id>0){
            $where.= ' and r.id='.$id;
        }
        $re = pdo_fetchall("select r.*,s.logo,s.shop_name,m.avatar,m.nickname from  ".tablename(RENEW)." r  left join ".tablename(SHOP)." s on s.shop_id=r.shop_id   left join".tablename(MEMBER)." m on m.id=r.mid  where r.uniacid = '{$_W['uniacid']}'  ".$where.$sqlwhere.' order by r.id desc ');
        return $re;
    }

}
