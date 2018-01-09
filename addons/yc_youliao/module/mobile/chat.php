<?php
global $_GPC,$_W;
$openid = $_W['fans']['from_user'];
$setting = $this->module['config'];
$user=$userinfo = Member::initUserInfo(); //用户信息
$toopenid = trim($_GPC['toopenid']);
$userinfo2 = Member::getSingleUser($toopenid);//对话者
$chat_user_id = $userinfo['id'].','. $userinfo2['id'];
$chat_user_id2 = $userinfo2['id'] .','.$userinfo['id'];
if (empty($openid)) {
message('请在微信浏览器中打开！', '', 'error');
}
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op=='display') {
    if ($openid == $toopenid) {
        message('不能和自己聊天！', '', 'error');
    }
    $touser = Member::getSingleUser($toopenid);
    $chatcon = pdo_fetchall('SELECT * FROM ' . tablename(CHAT) . " WHERE ((user1 = '{$userinfo['id']}' AND user2 = '{$userinfo2['id']}') OR (user1 = '{$userinfo2['id']}' AND user2 = '{$userinfo['id']}')) AND weid = {$_W['uniacid']} ORDER BY time ASC");
    $timestamp = TIMESTAMP;
    $dataup['hasread'] = 1;
    pdo_update(CHAT, $dataup, array('weid' => $_W['uniacid'], 'user2' => $userinfo['id'], 'user1' => $userinfo2['id'], 'hasread' => 0));
    $num=count($chatcon);
    $maxid=$chatcon[$num-1]['id'];
    include $this->template('../mobile/chat');
    exit;
}elseif($op=='addchat'){
    $falg=  intval($_GPC['flag']);////0文字 1图片 2语音
$chatcontent = trim($_GPC['content']);
if (empty($chatcontent)) {
    $resArr['error'] = 1;
    $resArr['msg'] = '请输入对话内容！';
    echo json_encode($resArr);
    die;
}
$data['openid'] = $openid;
$data['toopenid'] = $toopenid;
$data['time'] = TIMESTAMP;
$data['content'] = $chatcontent;
$data['weid'] = $_W['uniacid'];

$data['nickname'] = empty($user) ? '匿名用户' : $user['nickname'];
$data['avatar'] = empty($user) ? STYLE.'images/avatar_default.jpg' : $user['avatar'];
$data['type'] = 1;
$data['userid'] = $chat_user_id;
$data['user1'] =$userinfo['id'];//因openid字符串过长，为避免有openid查询时速度太慢，改用useid
$data['user2'] =$userinfo2['id'];
$data['flag'] =$falg;
$hasliao = commonGetData::getchat($userinfo['id']);
$guotime = TIMESTAMP - $hasliao['time'];
if ($setting['istplon'] == 1 && (empty($hasliao) || $guotime > $setting['kefutplminute'])) {
    $tpllist = pdo_fetch('SELECT tpl_id FROM' . tablename(TPL) . " WHERE tplbh = 'OPENTM207327169' AND uniacid = {$_W['uniacid']}");
    if (!empty($tpllist)) {
        Message::kfmsg($tpllist['tpl_id'],$data);
    }
}
pdo_insert(CHAT, $data);
$maxid = pdo_insertid();
$chatcon=array();
$chatcon[0]=$data;
$html=commonGetData::chathtml($chatcon,$openid);
$resArr['error'] = 0;
$resArr['msg'] = $html;
$resArr['maxid'] =$maxid;
echo json_encode($resArr);
die;
}elseif($op=='addchat2'){
    $chatcontent = trim($_GPC['content']);
    if (empty($chatcontent)) {
        $resArr['error'] = 1;
        $resArr['msg'] = '请输入对话内容！';
        echo json_encode($resArr);
        die;
    }
    $data['openid'] = $_W['fans']['from_user'];
    $data['nickname'] = $_W['fans']['tag']['nickname'];
    $data['avatar'] = $_W['fans']['tag']['avatar'];
    $data['toopenid'] =$toopenid;
    $data['time'] = TIMESTAMP;
    $data['content'] = $chatcontent;
    $data['weid'] = $_W['uniacid'];
    $data['type'] = 2;
    $data['flag'] =intval($_GPC['flag']);//0文字 1图片 2语音
    $data['userid'] = $chat_user_id;
    $data['user1'] =$userinfo['id'];//因openid字符串过长，为避免有openid查询时速度太慢，改用useid
    $data['user2'] =$userinfo2['id'];
    $hasliao = commonGetData::getchat($userinfo['id']);
   $guotime = TIMESTAMP - $hasliao['time'];

    if ($setting['istplon'] == 1 && (empty($hasliao) || $guotime > $setting['kefutplminute'])) {
        $tpllist = pdo_fetch('SELECT tpl_id FROM' . tablename(TPL) . " WHERE tplbh = 'OPENTM207327169' AND uniacid = {$_W['uniacid']}");
        if (!empty($tpllist)) {
            Message::kfmsg($tpllist['tpl_id'],$data);
        }
    }
    pdo_insert(CHAT, $data);
    $resArr['error'] = 0;
    $resArr['msg'] = '';
    echo json_encode($resArr);
    die;

}elseif($op=='say'){
    $timestamp = intval($_GPC['timestamp']);
    $maxid= intval($_GPC['maxid']);
    $maxwhere='';
    if($maxid>0){
        $maxwhere=' and id >'.$maxid;
    }
    $chatcon = pdo_fetchall('SELECT * FROM ' . tablename(CHAT) . " WHERE ((user1 = '{$userinfo['id']}' AND user2 = '{$userinfo2['id']}') OR (user2 = '{$userinfo['id']}' AND user1 = '{$userinfo2['id']}')) AND weid = {$_W['uniacid']} AND time <= {$timestamp} {$maxwhere} ORDER BY time ASC");

    $html=  commonGetData::chathtml($chatcon,$openid);
    $resArr['error'] = 0;
    $resArr['msg'] = $html;
    $resArr['timestamp'] = TIMESTAMP;
    echo json_encode($resArr);
    die;
}elseif($op=='savechat'){
$touser = Member::getSingleUser($toopenid);
$nickname = empty($touser) ? '匿名用户' : $touser['nickname'];
$chatcon = pdo_fetchall('SELECT * FROM ' . tablename(CHAT) . " WHERE ((user1 = '{$userinfo['id']}' AND user2 = '{$userinfo2['id']}') OR (user2 = '{$userinfo['id']}' AND user1 = '{$userinfo2['id']}')) AND weid = {$_W['uniacid']}  ORDER BY time ASC");
//更改未读状态
$dataup['hasread'] = 1;
pdo_update(CHAT, $dataup, array('weid' => $_W['uniacid'], 'user2' => $userinfo['id'], 'user1' => $userinfo2['id'], 'hasread' => 0));
 $num=count($chatcon);
 $maxid=$chatcon[$num-1]['id'];
include $this->template('../mobile/chat');
exit;
}

