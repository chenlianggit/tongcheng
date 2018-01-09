<?php

/*
	用户表类
*/
class Member
{

    //查询会员余额和积分
    static function getUserCredit($openid){
        global $_W;
        return array('credit1'=> $_W['member']['credit1'],'credit2'=>$_W['member']['credit2']);
    }

    //变动会员积分 $type 是类型 1是兑换优惠券消耗，2是抵扣 3是抵扣退还  4是购物奖励 5管理员赠送
    static function updateUserCredit($openid,$value,$type,$tag='米花社区模块变动会员积分'){
        global $_W;
        load() -> model('mc');
        $uid = mc_openid2uid($openid);
        $result = mc_credit_update($uid, 'credit1', $value,array($uid,$tag,'yc_youliao',$type));

        $paylog = array('type' => $type, 'uniacid' => $_W['uniacid'], 'openid' =>$openid, 'tid' => date('Y-m-d H:i:s'),'fee' => $value, 'module' => 'yc_youliao', 'tag' => $tag,'encrypt_code'=>$tag);
        pdo_insert('core_paylog', $paylog);
        return $result;
    }

    //变动会员余额  1是退款 5管理员赠送 6提现至余额
    static function updateUserMoney($openid,$value,$type,$tag='米花社区订单退款'){
        global $_W;
        load() -> model('mc');
        $uid = mc_openid2uid($openid);
        $result = mc_credit_update($uid, 'credit2', $value,array($uid,$tag,'yc_youliao',$type));
        $paylog = array('type' =>$type, 'uniacid' => $_W['uniacid'], 'openid' =>$openid, 'tid' => date('Y-m-d H:i:s'),'fee' => $value, 'module' => 'yc_youliao', 'tag' => $tag,'encrypt_code'=>$tag);
        pdo_insert('core_paylog', $paylog);
        return $result;
    }

    //初始化用户数据
    static function initUserInfo()
    {
        global $_W;
        //if(empty($_W['openid'])  ) self::alertWechatLogin(); //生产环境必须打开这个
        $hoturl=$_SERVER['HTTP_HOST'];
        if(empty($_W['openid']) && $hoturl=='www.szmihua.com') {
            $_W['openid']= 'ojm8pxKSi0l-0qta85Oho1lmgGp4';//松和
           //$_W['openid']=ojm8pxNBmxdH8LteUbuJAKsD6hDA;//简
            // $_W['openid']=ojm8pxCepg0DOnVt-seG2Kvaitq0;//康

        }//开发者测试


//必须关注
        $settings = Util::getModuleConfig();
        if ($settings['ismustfollow'] == 1) {
            $isfollow = Util::getSingelDataInSingleTable('mc_mapping_fans', array('openid' => $_W['openid']), ' follow ');
            if ($isfollow['follow'] == 0) self::alertWechatLogin();
        }

        $userinfo = self::getSingleUser($_W['openid']); //查询缓存

        if (!empty($userinfo)) {
            if ($userinfo['status'] == 1) die('您的账号已被禁用'); //被拉黑的账户

//            if ($userinfo['logintime'] < time() - 24 * 3600) { //每24小时更新一次登录时间，用户头像，昵称
//                load()->model('mc');
//                $oauthinfo = mc_oauth_userinfo($_W['uniacid']);
//                if (!empty($oauthinfo['nickname'])) {
//                    $data = array('logintime' => time(), 'nickname' => $oauthinfo['nickname'], 'avatar' => $oauthinfo['headimgurl']);
//                    pdo_update(MEMBER, $data, array('id' => $userinfo['id']));
//                    Util::deleteCache('fsuser', $_W['openid']);
//                }
//            }
        } else {
            $userinfo = Util::getSingelDataInSingleTable(MEMBER, array('openid' => $_W['openid']));
            if (empty($userinfo['logintime']) && !empty($_W['openid'])) {
                load()->model('mc');
                $oauthinfo = mc_oauth_userinfo($_W['uniacid']);
                $data = array(
                    'uniacid' => $_W['uniacid'],
                    'openid' => $_W['openid'],
                    'nickname' => $oauthinfo['nickname'],
                    'avatar' => $oauthinfo['headimgurl'],
                    'logintime' => time()
                );
                pdo_insert(MEMBER, $data);
            }
            $userinfo = self::getSingleUser($_W['openid']);
        }

        return $userinfo;
    }
    //查询一条用户数据,传入openid
    static function getSingleUser($openid){
        return Util::getDataByCacheFirst('fsuser',$openid,array('Util','getSingelDataInSingleTable'),array(MEMBER,array('openid'=>$openid)));
        //需删除缓存
    }

    static function getUserByid($id){
        return Util::getSingelDataInSingleTable(MEMBER,array('id'=>$id));
        //需删除缓存
    }
    static function getUserByopenid($openid){
        if(empty($openid))reutrn;
        $data=Util::getSingelDataInSingleTable(MEMBER,array('openid'=>$openid));

        return $data['nickname'];
        //需删除缓存
    }
    static function getMemberByopenid($openid){
        if(empty($openid))reutrn;
        $data=Util::getSingelDataInSingleTable(MEMBER,array('openid'=>$openid));
        return $data;
        //需删除缓存
    }

    //非微信端提示
    static function alertWechatLogin(){
        global $_W;
        $qrcode = tomedia('qrcode_'.$_W['acid'].'.jpg');
        die("<!DOCTYPE html>
            <html><head><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'>
                <title>提示</title><meta charset='utf-8'><meta name='viewport' content='width=device-width, initial-scale=1, user-scalable=0'><link rel='stylesheet' type='text/css' href='https://res.wx.qq.com/connect/zh_CN/htmledition/style/wap_err1a9853.css'>
            </head>
            <body>
            <div class='page_msg'><div class='inner'><span class='msg_icon_wrp'><i class='icon80_smile'></i></span><div class='msg_content'><h4>未识别用户身份，请用微信打开</h4><br><img width='200px' src='".$qrcode."'></div></body></html></div></div></div>
            </body></html>");
    }

    static  function isMember(){
        global $_W;
        $isfollow = Util::getSingelDataInSingleTable('mc_mapping_fans', array('openid' => $_W['openid']), ' follow ');
       return $isfollow['follow'];
    }

     static function searchMember(){
         global $_GPC,$_W;
         $kwd = trim($_GPC['keyword']);
         $wechatid = intval($_GPC['wechatid']);
         if (empty($wechatid)) {
             $wechatid = $_W['uniacid'];
         }
         $params = array();
         $params[':uniacid'] = $wechatid;
         $condition = " and m.uniacid=:uniacid";
         if (!empty($kwd)) {
             $condition .= " AND ( c.nickname LIKE :keyword or c.realname LIKE :keyword or c.mobile LIKE :keyword  or m.openid=:ropenid)";
             $params[':keyword'] = "%{$kwd}%";
             $params[':ropenid'] = "{$kwd}";
         }
         $ds = pdo_fetchall('SELECT m.uid,c.avatar,c.nickname,m.openid,c.mobile FROM ' . tablename('mc_mapping_fans') .
             "m left join " . tablename('mc_members') . ' c on c.uid = m.uid and c.uniacid= m.uniacid ' .
             " WHERE 1 {$condition} order by m.followtime desc", $params);
         return $ds;
     }
    static  function isqiandao($uid){
        $timestr = date("Y-m-d", TIMESTAMP);
        $result = pdo_fetch("select * from " . tablename(QIAN) . " where timestr=:timestr and uid=:uid", array(':timestr' => $timestr, ':uid' => $uid));
        if (!$result) {
            return 1;
        }else{
            return 0;
        }
    }
     static function qiandao($uid,$cfg){
         global $_W;
             if(intval($uid)==0)return array('status' => '0', 'str' => '获取用户信息失败，过一会再试试吧');
         $result=self::isqiandao($uid);
             if ($result==1) {
                 $timestr = date("Y-m-d", TIMESTAMP);
                 $in['uid'] = $uid;
                 $in['timestr'] = $timestr;
                 pdo_insert(QIAN, $in);
                 $jifen = $cfg['qiandao_jifen'];
                 if (empty($jifen)) {
                     $jifen = 1;
                 }
                 $qiandao_random = $cfg['qiandao_random'];//是否随机签到
                 if ($qiandao_random == 1) {
                     $jifen = mt_rand(1, $jifen);//根据最大的积分数，随机获取签分
                 }
                 $openid = pdo_fetchcolumn("select openid from " . tablename('mc_mapping_fans') . " where uid=:uid ", array(':uid' => $uid));
                 $paylog = array('type' => 'credit1', 'uniacid' => $_W['uniacid'], 'openid' => $openid, 'tid' => date('Y-m-d H:i:s'), 'fee' => $jifen, 'module' => MODULE, 'tag' => ' 签到' . $jifen . '积分');
                 pdo_query("update " . tablename('mc_members') . " SET credit1=credit1+'" . $jifen . "' WHERE uid={$uid} ");
                 pdo_insert('core_paylog', $paylog);
                 return array('status' => '1', 'str' => '签到成功,获得' . $jifen . '积分');

             } else {
                 return array('status' => '1', 'str' => '亲，您今天已签到,明天再来吧');

             }

     }

     static function getBlack($uid){
         $black=util::getSingelDataInSingleTable(BLACK,array('uid'=> $uid));
         return $black;
     }


    static public function member_msg($type){//公告
        global $_W;
        $openid=$_W['openid'];
        if($openid){
            if($type==1){
                $tablename=MEMBER;
            }else{
                $tablename=SHOP_ADMIN;
            }
            $msg_id_str=pdo_fetchcolumn("select msg_id_str from ".tablename($tablename)." where openid='{$openid}' and  uniacid = '{$_W['uniacid']}' ");
            if($msg_id_str){
                $msg_id_str=trim($msg_id_str,',');
                $list=pdo_fetchall("select * from ".tablename(MSG)." where status=1 and uniacid = '{$_W['uniacid']}' and msg_id not in({$msg_id_str}) and type ='{$type}' order by msg_id desc");
            }else{
                $list=pdo_fetchall("select * from ".tablename(MSG)." where status=1  and uniacid = '{$_W['uniacid']}' and type ='{$type}' order by msg_id desc ");
            }
        }
        return $list;
    }

    static public function getMsg($type){//公告
        global $_W;
        $openid=$_W['openid'];
        if($openid){

            $list=pdo_fetchall("select * from ".tablename(MSG)." where status=1  and uniacid = '{$_W['uniacid']}' and type ='{$type}' order by msg_id desc ");

        }
        return $list;
    }
}