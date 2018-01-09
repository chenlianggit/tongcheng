<?php
global $_GPC,$_W;
$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$user= Member::initUserinfo(); //用户信息
$credits = commonGetData::getUserCreditList($user['openid']);
if($op=='post'){
    $uid         = mc_openid2uid($user['openid']);
    $in['uniacid']=$_W['uniacid'];
    $in['uid']=$uid;
    $in['openid']=$user['openid'];
    $in['money']=floatval($_GPC['money']);
    $in['addtime']=TIMESTAMP;
    pdo_insert(BALANCE,$in);
    $id=pdo_insertid();
    $params = array(
        'tid' => 'ye'.$id,      //充值模块中的订单号，此号码用于业务模块中区分订单，交易的识别码
        'ordersn' =>'ye'.$id,  //收银台中显示的订单号
        'title' => '充值余额',          //收银台中显示的标题
        'fee' => $in['money'],      //收银台中显示需要支付的金额,只能大于 0
        'user' =>$user['openid'],     //付款用户, 付款的用户名(选填项)
    );
    $log = pdo_get('core_paylog', array('uniacid' => $_W['uniacid'], 'module' => MODULE, 'tid' => $params['tid']));
    if (empty($log)) {
        $log = array(
            'uniacid' => $_W['uniacid'],
            'acid' => $_W['acid'],
            'openid' => $user['openid'],
            'module' =>MODULE,
            'tid' => $params['tid'],
            'fee' => $params['fee'],
            'card_fee' => $params['fee'],
            'status' => '0',
            'is_usecard' => '0',
        );
        pdo_insert('core_paylog', $log);
    }
    $this->pay($params);
    exit();
}elseif($op=='record'){
    $status     = intval($_GPC['status']);
    $list=util::getAllDataBySingleTable(BALANCE,array('openid'=>$user['openid'],'status'=>$status),'balance_id desc ');
}
include $this->template('../mobile/balance');
exit;