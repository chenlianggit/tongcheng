<?php
global $_GPC,$_W;
$messageid = intval($_GPC['message_id']);
$moudleid = intval($_GPC['moudleid']);
$imageeenname = pdo_fetch('SELECT enname FROM ' . tablename(FIELDS) . " WHERE weid = {$_W['uniacid']} AND mid = {$moudleid} AND mtype in ('images','goodsthumbs','goodsbaoliao')");
if (empty($imageeenname)) {
echo '';
die;
} else {
$message = pdo_fetch('SELECT content FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} AND id = {$messageid} ");
$feildlist = unserialize($message['content']);
$imagesarr = $feildlist[$imageeenname['enname']];

$html = '<div class="my-gallery">';
    if (empty($imagesarr))return;
        foreach ($imagesarr as $k => $v) {
        $html .= ' <figure>
            <a href="' . tomedia($v) . '" class="gallery-a" ><img class="pic" src="' . tomedia($v) . '" style="max-width:100%;" /></a>
        </figure>';
        }
        $html .= '</div>
   
';
echo $html;
die;
}