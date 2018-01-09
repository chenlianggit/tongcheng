<?php
global $_GPC,$_W;
$messageid = intval($_GPC['id']);
$from_user=$this->getOpenid();
$message = pdo_fetch('SELECT mid FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} AND id = {$messageid}");
$modulecenter = pdo_fetch('SELECT haibaobg,bgparam FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND id = {$message['mid']}");
$logo = tomedia($modulecenter['haibaobg']);
$res=util::img_exists($logo);
if (!file_exists($logo) && $res == 0) {
message('海报背景图片不存在，不能生成带二维码海报！');
}

$errorCorrectionLevel = 'L';
$matrixPointSize = 10;
if (!is_dir('../addons/yc_youliao/shareimg/')) {
mkdir(iconv('UTF-8', 'GBK', '../addons/yc_youliao/shareimg/'), 511, true);
}
$QR = '../addons/yc_youliao/shareimg/' . $messageid . '.png';

$url = $_W['siteroot'] . 'app/' . str_replace('./', '', $this->createMobileUrl('detail', array('id' => $messageid)));
QRcode::png($url, $QR, $errorCorrectionLevel, $matrixPointSize, 2);
if ($logo !== FALSE) {
    $ch                  =util::decode_channel_param($modulecenter, $modulecenter['bgparam']);

    //$ch['qrwidth'] $ch['qrwidth']   $ch['qrleft']
    $QR = imagecreatefromstring(file_get_contents($QR));
    $logo = imagecreatefromstring(file_get_contents($logo));
    $QR_width = imagesx($QR);
    $QR_height = imagesy($QR);
    $logo_width = imagesx($logo);
    $logo_height = imagesy($logo);
    $logo_qr_width = $ch['qrleft'];
    $logo_qr_height = $ch['qrtop'];
    $width =$ch['qrwidth'];
    $height =$ch['qrheight'];
    if ($width && ($QR_width < $QR_height)) {
        $width = ($height / $QR_height) * $QR_width;
    } else {
        $height = ($width / $QR_width) * $QR_width;
    }
    imagecopyresampled($logo, $QR, $logo_qr_width, $logo_qr_height, 0, 0, $width, $height, $QR_width, $QR_width);


}
imagepng($logo, '../addons/yc_youliao/shareimg/' . $messageid . '.png');
$imgurl = '../addons/yc_youliao/shareimg/' . $messageid . '.png';
include $this->template('../mobile/shareimg');