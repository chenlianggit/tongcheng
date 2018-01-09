<?php
global $_W, $_GPC;
//checkauth();
$setting=$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$title=$cfg['index_title'].'发布信息';
$user= Member::initUserInfo(); //用户信息
$member = pdo_fetch('SELECT * FROM ' . tablename(MEMBER) . " WHERE openid = '{$_W['fans']['from_user']}'");
if (empty($member)) {
    if (!empty($_W['fans']['from_user']) && !empty($_W['fans']['tag']['nickname']) && !empty($_W['fans']['tag']['avatar'])) {
        $data['weid'] = $_W['uniacid'];
        $data['openid'] = $_W['fans']['from_user'];
        $data['nickname'] = $_W['fans']['tag']['nickname'];
        $data['avatar'] = $_W['fans']['tag']['avatar'];
        $data['regtime'] = TIMESTAMP;
        pdo_insert(BEST_MEMBER, $data);
        $member = pdo_fetch('SELECT * FROM ' . tablename(MEMBER) . " WHERE openid = '{$_W['fans']['from_user']}'");
    } else {
        $url = $this->createMobileUrl('register');
        header("Location:{$url}");
    }
}
$modulelist = pdo_fetchall('SELECT * FROM ' . tablename(CHANNEL) . " WHERE canrelease = 1 AND weid = {$_W['uniacid']} AND fid = 0 ORDER BY displayorder ASC");
foreach ($modulelist as $k => $v) {
    $modulelist[$k]['children'] = pdo_fetchall('SELECT id,name FROM ' . tablename(CHANNEL) . " WHERE canrelease = 1 AND weid = {$_W['uniacid']} AND fid = {$v['id']} ORDER BY displayorder ASC");
}

include $this->template('../mobile/edit');


