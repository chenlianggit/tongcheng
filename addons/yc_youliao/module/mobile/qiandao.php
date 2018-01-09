<?php
global $_W,$_GPC;
load()->model('mc');
$uid         = mc_openid2uid($_W['openid']);
$cfg       = $this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if($op=='display') {
   $res=Member::qiandao($uid,$cfg);
    echo json_encode($res);
    exit;


}