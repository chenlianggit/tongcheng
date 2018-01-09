<?php
global $_GPC,$_W;
$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$userinfo = Member::initUserinfo(); //用户信息
$this->checkBlack();
$info=new Info();
$resArr=$info->postInfo($userinfo['openid'],1);
echo json_encode($resArr);
die;
