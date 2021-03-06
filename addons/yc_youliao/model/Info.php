<?php 
class Info{
    //添加信息
    public function postInfo($openid,$type=1){
        global $_GPC, $_W;
        $cfg=$this->module['config'];
        $member = pdo_fetch('SELECT nickname,openid,avatar FROM ' . tablename(MEMBER) . " WHERE openid = '{$openid}'");
        if (empty($member)) {
            $resArr['error'] = 1;
            $resArr['message'] = '获取您的信息失败！';
            return $resArr;
        }
        $mid        = intval($_GPC['mid']);
        $province   = trim($_GPC['province']);
        $city       = trim($_GPC['city']);
        $district   = trim($_GPC['district']);
        $lng        = trim($_GPC['lng']);
        $lat        = trim($_GPC['lat']);
        $openid     = $member['openid'];
        $nickname   = $_GPC['nickname'];
        $logo       = $_GPC['logo'];
        $shop_id    = $_GPC['shop_id'];
        if ($mid <= 0) {
            $resArr['error'] = 1;
            $resArr['message'] = '项目加载失败！';
            return $resArr;
        }
        if (empty($city)) {
            $resArr['error'] = 1;
            $resArr['message'] = '没有获取您所在的地理位置信息！';
            return $resArr;
        }

        $moduleres = pdo_fetch('SELECT isshenhe,minscore,isneedpay,needpay,fid ,name FROM ' . tablename(CHANNEL) . " WHERE id = {$mid} AND weid = {$_W['uniacid']}");
        if ($moduleres['isneedpay'] == 1) {
            $data['isneedpay'] = 1;
            $tipinfo='提交信息成功，去支付'.$moduleres['needpay'].'元';
        }
        $data['weid']       = $_W['uniacid'];
        $data['mid']        = $mid;
        $data['fmid']       = $moduleres['fid'];
        $data['openid']     = $openid;
        $data['nickname']   = $nickname;
        $data['avatar']     = $logo;
        $data['shop_id']    = $shop_id;
        $data['province']   = $province;
        $data['city']       = $city;
        $data['district']   = $district;
        $data['lng']        = $lng;
        $data['lat']        = $lat;
        //thumbs[] 图片
        //telphone
        unset($_POST['province']);
        unset($_POST['city']);
        unset($_POST['district']);
        unset($_POST['lng']);
        unset($_POST['lat']);
        $post = $_POST;
        $post['thumbs'] = explode(',',$post['thumbs']);
        $data['content'] = serialize( commonGetData::guolv($post));
        $data['createtime'] = TIMESTAMP;
        $data['freshtime'] = TIMESTAMP;
        $data['status'] = $moduleres['isshenhe'] == 1 ? 0 : 1;
        $views_num=intval($cfg['views_num']);//随机最高浏览数量
        if($views_num>0) {
            $views = mt_rand(1, $views_num);//根据最大的积分数，随机获取签分
            $data['views'] = $views;
        }
        //新增信息
        pdo_insert(INFO, $data);
        $message_id = pdo_insertid();
        if ($moduleres['minscore'] > 0) {
            $datascore['weid'] = $_W['uniacid'];
            $datascore['openid'] = $member['openid'];
            $datascore['num'] = $moduleres['minscore'];
            $datascore['time'] = TIMESTAMP;
            $datascore['explain'] = '发布信息奖励积分';
            pdo_insert(INTEGRAL, $datascore);
        }
        if ($moduleres['isneedpay'] == 1 && $moduleres['needpay'] > 0) {
            $ordersn = date('Ymd') . random(7, 1);
            $dataorder['weid'] = $_W['uniacid'];
            $dataorder['from_user'] = $member['openid'];
            $dataorder['ordersn'] = $ordersn;
            $dataorder['price'] = $moduleres['needpay'];
            $dataorder['paytype'] = 1;
            $dataorder['createtime'] = TIMESTAMP;
            $dataorder['message_id'] = $message_id;
            $dataorder['module'] = $mid;
            pdo_insert(INFOORDER, $dataorder);
            $resArr['ispay'] = 1;
            $resArr['ordersn'] = $ordersn;
        } else {
            $resArr['ispay'] = 0;
            $resArr['ordersn'] = '';
        }

        if($moduleres['isneedpay'] == 1){//需要支付
            $resArr['message']=$tipinfo;
            $resArr['ordersn']=$ordersn;
        }elseif ($moduleres['isshenhe'] == 1 ) {//需要审核
            $resArr['message'] = '恭喜您，添加信息成功，请等待管理员审核！';
            //模板消息通知管理员审核
            if($type==1){
                $url= Util::createModuleUrl('detail',array('id'=>$message_id));
                $name=$moduleres['name'];
                Message::admin_checkmsg('您有一条审核提醒!',$url,$name,$member['nickname'],TIMESTAMP);
            }

        } else {//无需审核，无需支付
            $resArr['message'] = '恭喜您，添加信息成功！';
        }
        $resArr['error'] = 0;
        return $resArr;

    }
//    public function postInfo($openid,$type=1){
//        global $_GPC, $_W;
//        $cfg=$this->module['config'];
//        $member = pdo_fetch('SELECT nickname,openid,avatar FROM ' . tablename(MEMBER) . " WHERE openid = '{$openid}'");
//        if (empty($member)) {
//            $resArr['error'] = 1;
//            $resArr['message'] = '获取您的信息失败！';
//            return $resArr;
//        }
//        $mid = intval($_GPC['mid']);
//        $province = trim($_GPC['province']);
//        $city = trim($_GPC['city']);
//        $district = trim($_GPC['district']);
//        $lng = trim($_GPC['lng']);
//        $lat = trim($_GPC['lat']);
//        if ($mid <= 0) {
//            $resArr['error'] = 1;
//            $resArr['message'] = '项目加载失败！';
//            return $resArr;
//        }
//        if (empty($city)) {
//            $resArr['error'] = 1;
//            $resArr['message'] = '没有获取您所在的地理位置信息！';
//            return $resArr;
//        }
//        $fieldslist = commonGetData::getfield($mid);
//        foreach ($fieldslist as $k => $v) {
//            $fieldname = $_GPC[$v['enname']];
//            if( is_array( $fieldname ) )$fieldname =implode(" ",$fieldname);
//            $fieldnamelen = mb_strlen($fieldname,'utf-8');
//            if ($v['islenval'] == 1) {
//                if ($fieldnamelen < $v['minlen'] || $fieldnamelen > $v['maxlen']) {
//                    $resArr['error'] = 1;
//                    $resArr['message'] = $v['name'] . '字符长度应该在' . $v['minlen'] . '字符到' . $v['maxlen'] . '字符之间，当前字符长度' . $fieldnamelen;
//                    return $resArr;
//                }
//            }
//
//            if ($v['isrequired'] == 1) {
//                if (empty($fieldname)) {
//                    $resArr['error'] = 1;
//                    $resArr['message'] = '请填写' . $v['name'];
//                    return $resArr;
//                }
//            }
//            if ($v['mtype'] == 'telphone' && $v['isrequired'] == 1) {
//                if (!util::isMobile($fieldname)) {
//                    $resArr['error'] = 1;
//                    $resArr['message'] = '请填写正确的手机号码';
//                    return $resArr;
//                }
//            }
//            if ($v['mtype'] == 'idcard' && $v['isrequired'] == 1) {
//                if (!util::isCreditNo($fieldname)) {
//                    $resArr['error'] = 1;
//                    $resArr['message'] = '请填写正确的身份证号';
//                    return $resArr;
//                }
//            }
//        }
//
//        $moduleres = pdo_fetch('SELECT isshenhe,minscore,isneedpay,needpay,fid ,name FROM ' . tablename(CHANNEL) . " WHERE id = {$mid} AND weid = {$_W['uniacid']}");
//        if ($moduleres['isneedpay'] == 1) {
//            $data['isneedpay'] = 1;
//            $tipinfo='提交信息成功，去支付'.$moduleres['needpay'].'元';
//        }
//        $data['weid'] = $_W['uniacid'];
//        $data['mid'] = $mid;
//        $data['fmid'] = $moduleres['fid'];
//        $data['openid'] = $member['openid'];
//        $data['nickname'] = $_GPC['nickname'];
//        $data['avatar'] = $member['avatar'];
//        $data['shop_id'] = $_GPC['shop_id'];
//        $data['province'] = $province;
//        $data['city'] = $city;
//        $data['district'] = $district;
//        $data['lng'] = $lng;
//        $data['lat'] = $lat;
//        unset($_POST['province']);
//        unset($_POST['city']);
//        unset($_POST['district']);
//        unset($_POST['lng']);
//        unset($_POST['lat']);
//        $data['content'] = serialize( commonGetData::guolv($_POST));
//        $data['createtime'] = TIMESTAMP;
//        $data['freshtime'] = TIMESTAMP;
//        $data['status'] = $moduleres['isshenhe'] == 1 ? 0 : 1;
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
//
//    }
    // 查询多条信息
    static function getAllInfo($where,$page,$num,$order='`orderby` DESC'){
        $goodinfo = Util::getAllDataInSingleTable(GOODS,$where,$page,$num,$order);
        foreach($goodinfo[0] as $k=>$v){
            $newgoodinfo[$k] = self::initSingleGoodPro($v);
        }
        return array($newgoodinfo,$goodinfo[1],$goodinfo[2]);
    }
    //搜索接口
    public function searchInfo($key,$page,$num){
        global $_W ,$_GPC;
        $data = util::getAllDataInSingleTable(INFO,array('content@'=>$key),$page,$num,'id DESC',false,' *',$type='2');
        $zdmessagelist = '';
        $lat = $_GPC["lat"];
        $lng = $_GPC["lng"];
        if($data[0]){
            $zdmessagelist = $data[0];
            foreach ($zdmessagelist as $k => $v) {

                $zdmessagelist[$k]['distance'] = util::getDistance($v['lat'], $v['lng'], $lat, $lng);
                $module = pdo_fetch('SELECT name FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND id = {$v['mid']}");
                $zdmessagelist[$k]['con'] = unserialize($v['content']);
                $zdmessagelist[$k]['modulename'] = $module['name'];

                if($v['freshtime']) {
                    $zdmessagelist[$k]['freshtime'] = date("Y-m-d H:i", $v['freshtime']);
                }
                $zdmessagelist[$k]['con']['thumbs']= self::tomediaImg($zdmessagelist[$k]['con']['thumbs']);
                if($zdmessagelist[$k]['con']['thumbs'][0] == ""){
                    $zdmessagelist[$k]['con']['thumbs'] = array();
                }
                $zdmessagelist[$k]['createtime'] = date("Y-m-d H:i",$v['createtime']);

            }
        }
        return $zdmessagelist;
    }
    //图片格式化成域名+完整图片
    static function tomediaImg($img){
        if($img){
            $imgData=array();
            foreach ($img as $a => $b) {
                $imgData[$a] = tomedia($b);
            }
            return $imgData;
        }

    }
    public function getInfoById ($id){
        global  $_W;
        $data=pdo_fetch('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']}  AND id = {$id} ");
        if($data){
            $data['zan'] = Info::getZanInfo($id);
        }
        self::addNum($id);
        return $data;
    }
    public function getInfoByOId ($openid,$id){
        global  $_W;
        self::addNum($id);
        $data=pdo_fetch('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} AND openid = '{$openid}' AND id = {$id} ");
        return $data;
    }
    public function getInfoByShop($Shop_id,$where,$page,$num){
        global  $_W;
        $mymessagelist = pdo_fetchall("SELECT * FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND shop_id = '{$Shop_id}'{$where} ORDER BY createtime DESC LIMIT ".$page.",".$num);
        foreach ($mymessagelist as $k => $v) {
            $mymessagelist[$k]['zan'] = Info::getZanInfo($v['id']);
        }
        return $mymessagelist;
    }
    public function getInfoCountByShop($Shop_id){
        global  $_W;
        $mymessagelist = pdo_fetchall("SELECT id FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND shop_id = '{$Shop_id} AND status = 1'");
        return count($mymessagelist);
    }
    public function getInfoCount(){
        global  $_W;
        $mymessagelist = pdo_fetchall("SELECT count(*) as count FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']}");
        return $mymessagelist[0]['count'];
    }
    public function getMemberCount(){
        global  $_W;
        $memberCount = pdo_fetchall("SELECT count(*) as count FROM ".tablename(MEMBER)." WHERE uniacid = {$_W['uniacid']}");
        return $memberCount[0]['count'];
    }
    public function getInfoByuser ($openid,$where,$page,$num){
        global  $_W;
        $mymessagelist = pdo_fetchall("SELECT * FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND openid = '{$openid} '{$where} ORDER BY createtime DESC LIMIT ".$page.",".$num);
        foreach ($mymessagelist as $k => $v) {
            $mymessagelist[$k]['zan'] = Info::getZanInfo($v['id']);
        }
        return $mymessagelist;
    }

    public function getPayInfoByuser ($openid,$where,$page,$num)
    {
        global $_W;
        $mymessagelist = pdo_fetchall("SELECT i.*,o.createtime as infotime,o.price as infoprice FROM " . tablename(INFOORDER) . " o left join  " . tablename(INFO) . "i on o.message_id=i.id WHERE i.weid = {$_W['uniacid']} AND openid = '{$openid} '{$where} ORDER BY createtime DESC LIMIT " . $page . "," . $num);
        return $mymessagelist;
    }

    public function getTopInfoByuser ($openid,$where,$page,$num)
    {
        global $_W;
        $mymessagelist = pdo_fetchall("SELECT i.*,o.createtime as zdtime,o.price as zdprice  FROM ".tablename(ZDORDER)." o left join  ".tablename(INFO)."i on o.message_id=i.id WHERE i.weid = {$_W['uniacid']} AND i.openid = '{$openid} '{$where} ORDER BY createtime DESC LIMIT ".$page.",".$num);
        return $mymessagelist;
    }

    public function getCollect ($openid,$infosql='')
    {
        global $_W;
        $list = pdo_fetchall("SELECT a.*,b.id as b_id,b.content,b.mid,b.createtime,b.nickname,b.avatar FROM ".tablename(COLLECT)." as a,".tablename(INFO)." as b WHERE a.message_id = b.id AND a.weid = {$_W['uniacid']} AND a.openid = '{$openid}' {$infosql} ORDER BY a.time DESC  ");
        foreach($list as $k=>$v){
            $module = pdo_fetch('SELECT name FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND id = {$v['mid']}");
            $list[$k]['con'] = unserialize($v['content']);
            $list[$k]['modulename'] = $module['name'];
            if($list[$k]['con']['thumbs'][0] == ""){
                $list[$k]['con']['thumbs'] = array();
            }
        }
        return $list;
    }

    public function proCollect($openid){
        global $_W ,$_GPC;
        $message_id = intval($_GPC['message_id']);
        $collect = pdo_fetch("SELECT * FROM ".tablename(COLLECT)." WHERE weid = {$_W['uniacid']} AND openid = '{$openid}' AND message_id = {$message_id}");
        if(!empty($collect)){
            pdo_delete(COLLECT,array('weid'=>$_W['uniacid'],'openid'=>$openid,'message_id'=>$message_id));
            $resArr['error'] = 0;
            $resArr['message'] = "取消收藏成功！";
            return $resArr;
        }else{
            $data['weid'] = $_W['uniacid'];
            $data['openid'] = $openid;
            $data['message_id'] = $message_id;
            $data['time'] = TIMESTAMP;
            pdo_insert(COLLECT,$data);
            $resArr['message'] = "恭喜您，收藏成功！";
            $resArr['error'] = 0;
            return $resArr;
        }
    }
    public function addNum($info_id,$type = 1){

        $set = " scan=scan+1 ";
        if($type != 1){
            $set = " send=send+1 ";
        }
        pdo_query("UPDATE ".tablename(INFO)." SET $set WHERE `id` = '{$info_id}' ");

    }
    public function addZanInfo($openid){
        global $_GPC, $_W;
        $id  = intval($_GPC['info_id']);//商户id
        $zan = pdo_fetch("SELECT * FROM ".tablename(mihua_sq_zan)." WHERE  openid = '{$openid}' AND info_id = {$id}");
        if($zan){
            return 0;
        }
        $data = array(
            'uniacid'   => $_W['uniacid'],
            'info_id'   => $id,
            'openid'   => $openid,
            'createtime'=> time()
        );
        $res = pdo_insert(mihua_sq_zan, $data);
        return $res;
    }
    public static function getZanInfo($info_id){
        $zan = pdo_fetch("SELECT count(*) as count FROM ".tablename(mihua_sq_zan)." WHERE  info_id = {$info_id}");
        if(!$zan['count']){
            return 0;
        }
        return $zan['count'];
    }
}