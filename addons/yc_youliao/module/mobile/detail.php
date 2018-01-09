<?php
global $_GPC,$_W;
$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$userinfo = Member::initUserInfo(); //用户信息
$openid=$this->getOpenid();
$adv_type=8;//1首页，4拼团，5秒杀，6首单，7买单，8同城
$hide=$hidewater=1;
$id = intval($_GPC['id']);
if($id==0)   return;
if ($op=="ping"){//1点赞，2评论，3关注
$info=trim($_GPC['info']);
$pid = intval($_GPC['pid']);
if(empty($info)){
    echo json_encode(array('status' => '0','str' => '评论内容不能为空'));
    exit;
}

$data = array(
    'uniacid' => $_W['uniacid'],
    'addtime' =>TIMESTAMP,
    'openid' => $openid,
    'info' => $info,
    'info_id' => $id,
    'parent_id' => $pid,
);
$result=pdo_insert(INFO_COMMENT, $data);
if (!empty($result)) {
    echo json_encode(array('status' => '1','avatar' => $userinfo['avatar'],'nickname' => $userinfo['nickname'],'time' => date('m-d H:i', $time ),'info' =>$info));

}
exit;
}elseif ($op=="cancelPing" ){//1点赞，2评论，3关注
$datainfo = util::getSingelDataInSingleTable(INFO_COMMENT,array('openid'=>$openid,'comment_id'=>$id,'uniacid' => $_W['uniacid']));

if (!empty($datainfo)){//删除评论
    util::deleteData2('comment_id', $datainfo['comment_id'],INFO_COMMENT);
    echo json_encode(array('status' => '1'));
    exit;
}else{
    echo json_encode(array('status' => '0'));
    exit;
}


}else{
    //打赏记录
    $Redpackage=new Redpackage();
    $red_data=$Redpackage->getRingRed_recordList($id,3);

    $message = pdo_fetch('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} AND id = {$id} ");
    if ($openid==$message['openid'])$send=1;
    $sameday=util::isDiffDays($message['freshtime']);
    $mapreq = $this->mapreq();
    $chagexy = $this->chagexy();
    $locationdata = util::getDistrictByLatLng($message['lng'],$message['lat'] , $mapreq, $chagexy, '1');
    $message['address'] = $locationdata['address'];
    $formatted_address = $locationdata['formatted_address'];
    $lng=$message['lng'];
    $lat=$message['lat'];
    if($_GPC['gps']=='1'){
        include $this->template('../gps');
        exit();
    }
    //留言
    $comment_where['info_id']=$id;
    $comment_where['parent_id']=0;
    $orderby=' comment_id ASC ';
    $comment = util::getAllDataBySingleTable(INFO_COMMENT,$comment_where,$orderby,$select='*',$type='1');
    $commentNum=count($comment);
    foreach ($comment as $k => $v) {
        //获取用户名，头像
        $memberData=Member::getSingleUser($v['openid']);
        $comment[$k]['avatar']=$memberData['avatar'];
        $comment[$k]['nickname']=$memberData['nickname'];

        //获取回复
        $comment_where['info_id']=$id;
        $comment_where['parent_id']=$v['comment_id'];
        $replay = util::getAllDataBySingleTable(INFO_COMMENT,$comment_where,$orderby,$select='*',$type='1');

        if($replay){
            foreach ($replay as $x => $y) {
                $replayData = Member::getSingleUser($y['openid']);
                $replay[$x]['avatar'] = $replayData['avatar'];
                $replay[$x]['nickname'] = $replayData['nickname'];

            }
            $comment[$k]['replay']=$replay;
        }

    }
    //管理员
    $where['openid'] = $openid;
    $where['status'] = 0;
    $a_data = util::getSingelDataInSingleTable(ADMIN, $where, 'admin_id');
    if ($message['status'] !=1 && $openid != $message['openid'] && empty($a_data)) {
        message('该信息正在审核中或已被删除！');
    }
    $hascollected = pdo_fetch('SELECT id FROM ' . tablename(COLLECT) . " WHERE weid = {$_W['uniacid']} AND openid = '{$_W['fans']['from_user']}' AND message_id = {$id}");
    $content = $feildlist = unserialize($message['content']);
    $feildlist = str_replace('
', '<br>', $feildlist);
    $feildlist =  commonGetData::guolv($feildlist);
    $views_num=intval($cfg['views_num']);//随机最高浏览数量
    if($views_num>0){
        $views =mt_rand(1,$views_num);//根据最大的积分数，随机获取签分
        $views = $message['views'] + $views;
    }else{
        $views = $message['views'] + 1;
    }
    pdo_update(INFO, array('views' => $views), array('id' => $id));
    $moduleres = pdo_fetch('SELECT * FROM ' . tablename(CHANNEL) . " WHERE id = {$message['mid']} AND weid = {$_W['uniacid']}");
    $moduleres['detailhtml'] = htmlspecialchars_decode($moduleres['detailhtml']);


    if (empty($moduleres['detailhtml']) || $moduleres['defult_detail'] == 1) {//没有自定义详情页

        $fieldslist = commonGetData::getfield_arr($message['mid'],$_W['uniacid']);

    } else {
        $htmlres = '';
        foreach ($feildlist as $kk => $vv) {
            $fieldmtype = pdo_fetch('SELECT mtype,danwei FROM ' . tablename(FIELDS) . " WHERE weid = {$_W['uniacid']} AND mid = {$message['mid']} AND enname = '{$kk}'");
            if ($fieldmtype['mtype'] == 'checkbox') {
                $checkboxhtml = '';
                foreach ($vv as $ck => $cv) {
                    $checkboxhtml .= '<div class="span4"><span class="iconfont">&#xe624;</span>' . $cv . '</div>';
                }
                $moduleres['detailhtml'] = str_replace('[' . $kk . ']', $checkboxhtml, $moduleres['detailhtml']);
            } elseif ($fieldmtype['mtype'] == 'select' || $fieldmtype['mtype'] == 'radio') {
                $moduleres['detailhtml'] = str_replace('[' . $kk . ']', $vv . $fieldmtype['danwei'], $moduleres['detailhtml']);
            } else {
                $moduleres['detailhtml'] = str_replace('[' . $kk . ']', $vv . $fieldmtype['danwei'], $moduleres['detailhtml']);
            }
        }
        $moduleres['detailhtml'] = str_replace('[openid]', $message['openid'], $moduleres['detailhtml']);
        $moduleres['detailhtml'] = str_replace('[nickname]', $message['nickname'], $moduleres['detailhtml']);
        $moduleres['detailhtml'] = str_replace('[province]', $message['province'], $moduleres['detailhtml']);
        $moduleres['detailhtml'] = str_replace('[city]', $message['city'], $moduleres['detailhtml']);
        $moduleres['detailhtml'] = str_replace('[district]', $message['district'], $moduleres['detailhtml']);
        $moduleres['detailhtml'] = str_replace('[views]', $message['views'], $moduleres['detailhtml']);
        $createdate = date('Y-m-d H:i:s', $message['createtime']);
        $moduleres['detailhtml'] = str_replace('[createtime]', $createdate, $moduleres['detailhtml']);
        $htmlres .= $moduleres['detailhtml'];
    }
    $hasphonefield = pdo_fetch('SELECT enname FROM ' . tablename(FIELDS) . " WHERE weid = {$_W['uniacid']} AND mid = {$message['mid']} AND mtype = 'telphone'");
    if ($hasphonefield) {
        $phone = $feildlist[$hasphonefield['enname']];
    }

    //置顶
    $info_condition .= " and isding = 1 and mid = {$message['mid']}";
    $shownum=$this->showMsgNum();
    $zdmessagelist = commonGetData::getTopMsg($info_condition,$shownum,'','');
    //分享内容设置
    $title=$share_title=$content['title'];
    $share_info='['.$moduleres['name'].']'.$content['title'];
    $share_img=$content['thumbs'][0];
    if(empty($share_img) && !empty($moduleres['sharethumb'])){
        $share_img=$moduleres['sharethumb'];
    }
    include $this->template('../mobile/detail');
    exit();
}