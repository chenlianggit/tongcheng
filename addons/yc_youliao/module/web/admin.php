<?php
global $_GPC,$_W;
$title='管理员';
$do     =  $_GPC['do'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$Admin = new Admin();
if ($op == 'display') {

    if(!empty($_GPC['status'])){
        $codition.=" and status=".$_GPC['status'];
    }
    $list =$Admin->getAdminAll();

} elseif ($op == 'post') {

    $admin_id = intval($_GPC['admin_id']);
    if(!empty($admin_id)){
        $item =$Admin::getAdminByid($admin_id);

    }
    if (checksubmit('submit')) {
//        print_r($_POST);
//        exit;
        $openid=$_GPC['openid'];
        if(empty($openid)){
            $this->message('请选择管理员', referer(), 'error');
        }

        $data = array(
            'uniacid' => $_W['uniacid'],
            'openid' => trim($_GPC['openid']),
            'avatar' => $_GPC['avatar'],
            'nickname' => $_GPC['nickname'],
            'status' => intval($_GPC['status']),//'0=>正常，1暂停
            'msg_flag' => intval($_GPC['msg_flag']),//'0=>发送通知,1=>不发送通知'
            'addtime' =>  TIMESTAMP,
            'admin_name' => $_GPC['admin_name'],
            'mobile' => $_GPC['mobile'],

        );
    if($admin_id==0){
        pdo_insert(ADMIN, $data);
    }else{
        pdo_update(ADMIN, $data,array('admin_id'=>$admin_id,'uniacid'=>$_W['uniacid']));
    }

    $this->message('操作成功！', $this->createWebUrl('admin', array('op' => 'display')), 'success');
    }

}elseif ($op == 'delete') {
    $id = intval($_GPC['admin_id']);
    pdo_delete(ADMIN, array('admin_id' => $id,'uniacid'=>$_W['uniacid']));
    $this->message('删除成功！', $this->createWebUrl('admin', array('op' => 'display')), 'success');
}elseif ($op == 'query') {
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
    include $this->template('web/shop/shop_admin_query');
    exit;

}

include $this->template('web/admin');
exit();
