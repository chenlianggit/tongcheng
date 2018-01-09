<?php
global $_GPC,$_W;
$spec = array("id" => random(32), "title" => $_GPC['title']);
include $this->template('web/shop/spec');
exit;