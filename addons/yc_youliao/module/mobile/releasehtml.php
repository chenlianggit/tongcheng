<?php
global $_W,$_GPC;
$op     =  $_GPC['op'];
if($op=='getmedia'){

    include_once IA_ROOT.'/addons/yc_youliao/class/ImageCrop.class.php';
    $access_token = WeAccount::token();
    $media_id = $_GPC['media_id'];
    $url = 'file.api.weixin.qq.com/cgi-bin/media/get?access_token=' . $access_token . '&media_id=' . $media_id;
    $updir = IA_ROOT.'/attachment/images/' . $_W['uniacid'] . '/' . date('Y', time()) . '/' . date('m', time()) . '/';

    if (!file_exists($updir)) {
        mkdir($updir, 511, true);
    }
    $randimgurl = 'images/' . $_W['uniacid'] . '/' . date('Y', time()) . '/' . date('m', time()) . '/' . date('YmdHis') . rand(1000, 9999) . '.jpg';
    $targetName = IA_ROOT.'/attachment/' . $randimgurl;
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $fp = fopen($targetName, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);

    if (file_exists($targetName)) {
        $resarr['error'] = 0;
        $size = getimagesize($targetName);
        if (empty($size)) {
            return false;
        }
        $tarwidth = $size[0];
        $tarheight = $size[1];
        try{
            $ic = new ImageCrop($targetName, $targetName);
        }catch(Exception $e){
            echo $e->getMessage();
        }
        $ic->Crop($tarwidth, $tarheight, 2);
        $ic->SaveImage();
        $ic->destory();

        if (!empty($_W['setting']['remote']['type'])) {
            load()->func('file');
            $remotestatus =@file_remote_upload($randimgurl);
            if (is_error($remotestatus)) {
                $resarr['error'] = 1;
                $resarr['message'] = '远程附件上传失败，请检查配置并重新上传';
                file_delete($randimgurl);
                echo json_encode($resarr);
                exit;
            } else {
                file_delete($randimgurl);
                $resarr['realimgurl'] = $randimgurl;
                $resarr['imgurl'] = tomedia($randimgurl);
                $resarr['message'] = '上传成功';
                echo json_encode($resarr);
                exit;
            }
        }
        $resarr['realimgurl'] = $randimgurl;
        $resarr['imgurl'] = tomedia($randimgurl);
        $resarr['message'] = '上传成功';
    } else {
        $resarr['error'] = 1;
        $resarr['message'] = '上传失败';
    }
    echo json_encode($resarr, true);
    die;
}
$id = intval($_GPC['id']);
$moduleres = pdo_fetch('SELECT isneedpay,needpay FROM ' . tablename(CHANNEL) . " WHERE id = {$id} AND weid = {$_W['uniacid']}");
$fieldslist = pdo_fetchall('SELECT * FROM ' . tablename(FIELDS) . " WHERE mid = {$id} AND weid = {$_W['uniacid']} ORDER BY displayorder ASC");
foreach ($fieldslist as $k => $v) {
if (!empty($v['mtypecon'])) {
$fieldslist[$k]['mtypeconarr'] = explode('|', $v['mtypecon']);
} else {
$fieldslist[$k]['mtypeconarr'] = '';
}
}
include $this->template('../mobile/releasehtml');