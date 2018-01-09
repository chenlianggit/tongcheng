<?php
global $_GPC,$_W;
$cfg=$this->module['config'];
$type     = !empty($_GPC['type']) ? $_GPC['type'] : '1';
$userinfo = Member::initUserInfo(); //用户信息
$adv_type=15;
include $this->template('../mobile/search');
exit;