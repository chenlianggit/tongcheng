<?php
global $_GPC,$_W;
$title='管理员';
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$page =$this->getPage();
$num = $this->getNum(); //每次取值的个数
if ($op == 'display') {
    $shop=util::getAllDataBySingleTable(SHOP,array(status=>1),'shop_id,shop_name');
    $where['uniacid']=$_W['uniacid'];
    if ($_GPC['submit'] == '搜索') {
        if ($_GPC['mobile']) {
            $mobile = $_GPC['mobile'];
            $where['mobile@'] = $_GPC['mobile'];
        }
        if ($_GPC['nickname']) {
            $nickname= $_GPC['nickname'];
            $where['nickname@'] = $_GPC['nickname'];
        }
        if ($_GPC['userid']) {
            $nickname= $_GPC['userid'];
            $where['id'] = $_GPC['userid'];
        }
        if ($_GPC['shop_id']) {
            $where['shop_id'] = $_GPC['shop_id'];
        }
    }
    $arr =util::getAllDataInSingleTable(MEMBER,$where,$page,$num);
    $pager=$arr[1];
    $total=$arr[2];
    $data=$arr[0];
    $list=array();
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
} elseif ($op == 'postAdmin') {
   $mid= $_GPC['mid'];
   $member=member::getUserByid($mid);
   $admin=$this->checkAdmin($member['openid']);
   if(empty($admin)) {
       $data = array(
           'uniacid' => $_W['uniacid'],
           'openid' => $member['openid'],
           'avatar' => $member['avatar'],
           'nickname' => $member['nickname'],
           'status' => 0,//'0=>正常，1暂停
           'msg_flag' => 0,//'0=>发送通知,1=>不发送通知'
           'addtime' => TIMESTAMP,
       );
       pdo_insert(ADMIN, $data);
       $this->message('操作成功，用户：'.$member['nickname'].'已成为管理员', $this->createWebUrl('admin', array('op' => 'display')), 'success');
       exit;
   }else{
       $this->message('用户：'.$member['nickname'].'已是管理员',$this->createWebUrl('admin', array('op' => 'display')), 'success');
       exit;
   }

}elseif ($op == 'delete') {
    $mid= $_GPC['mid'];
    $member=member::getUserByid($mid);
    if(empty($member)) {
        $this->message('用户：'.$member['nickname'].'不存在，或已删除',  referer(), 'success');
        exit;
    }else{
        pdo_delete(MEMBER,array('id'=>$mid,'uniacid' => $_W['uniacid']));
        $this->message('操作成功，用户：'.$member['nickname'].'已删除',  referer(), 'success');
        exit;
    }

}elseif ($op == 'postCredit') {
    $mid= $_GPC['mid'];
    $item=member::getUserByid($mid);
    $credits = commonGetData::getUserCreditList($item['openid']);
    $item['credit'] = $credits['credit1'];
    $item['balance'] = $credits['credit2'];
    if ($_GPC['submit'] == '充值') {
        $tag='管理员:'.'操作';
        $word='';
        $balance=trim($_GPC['balance']);
        $credit=trim($_GPC['credit']);
        if(!empty($credit)){
            $re = Member::updateUserCredit($item['openid'], $credit, 5, $tag);
            $_fee=floatval($item['credit']+$credit);
            $conarr = explode('-',$credit);
            if($conarr<=1){
                $word.="恭喜您，获得：".$credit."元现金\\n您现在的金额为：". $_fee."元。";
                $this->rep_text($item['openid'], $word);
            }
        }
        if(!empty($balance)){
            $re = Member::updateUserMoney($item['openid'],  $balance, 5, $tag);
            $_fee=floatval($item['balance']+$balance);
            $conarr = explode('-',$balance);
            if($conarr<=1){
                $word.="恭喜您，获得：".$balance."元现金\\n您现在的金额为：". $_fee."元。";
                $this->rep_text($item['openid'], $word);
            }

        }

        $this->message('操作成功',  referer(), 'success');
        exit;
    }
    $where['openid']=$item['openid'];
    $where['uniacid']=$item['uniacid'];
    $where['module']= 'yc_youliao';
    $where['type>']= '0';
    $arr =util::getAllDataInSingleTable('core_paylog',$where,$page,$num,'plid desc ');
    $pager=$arr[1];
    $total=$arr[2];
    $list=$arr[0];

    include $this->template('web/member_post');
    exit();
}

include $this->template('web/member');
exit();
