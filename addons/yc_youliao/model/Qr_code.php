<?php

class Qr_code
{

    public static function curl_or_file_get_content($file,$cache_file){
        if (extension_loaded('curl'))
        {
            $url= self::curl_file_get_contents($file);
            $flag=1;
        }else{
            $url = file_get_contents($file);
            $flag=2;
        }
        self::write_cach($cache_file,$url);
        if(filesize($cache_file)==0 && $flag==1){
            $url = file_get_contents($file);
        }elseif(filesize($cache_file)==0 && $flag==2){
            $url= self::curl_file_get_contents($file);
        }
       self::write_cach($cache_file,$url);
        return $url;

    }
    public static function write_cach($cache_file,$url){
        $bild = $cache_file;
        $fp = fopen($bild, 'w');
        $ws = fwrite($fp, $url);
        fclose($fp);
        if ($ws == false || $ws == 0 || empty($ws)) {
            return '';
        }else{
            return 1;
        }
    }
    public static function curl_file_get_contents($durl) {
        $r = null;
        if (function_exists('curl_init') && function_exists('curl_exec')) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $durl);
            curl_setopt($ch, CURLOPT_TIMEOUT, 5);
            curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64; rv:9.0.1) Gecko/20100101 Firefox/9.0.1');
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $r = curl_exec($ch);
            curl_close($ch);
        }
        return $r;
    }

    public static function mergeImage($bg, $qr, $out, $param) {
        list($bgWidth, $bgHeight) = @getimagesize($bg);
        list($qrWidth, $qrHeight) = @getimagesize($qr);
        extract($param);
        $bgImg = self::imagecreate($bg);
        $qrImg = self::imagecreate($qr);
        @imagecopyresized($bgImg, $qrImg, $left, $top, 0, 0, $width, $height, $qrWidth, $qrHeight);
        ob_start();
        @imagejpeg($bgImg, null, 100);
        $contents = ob_get_contents();
        ob_end_clean();
        @imagedestroy($bgImg);
        @imagedestroy($qrImg);
        $fh = fopen($out, "w+");
        fwrite($fh, $contents);
        fclose($fh);
    }
    public static function imagecreate($bg) {
        $bgImg = @imagecreatefromjpeg($bg);
        if (false == $bgImg) {
            $bgImg = @imagecreatefrompng($bg);
        }
        if (false == $bgImg) {
            $bgImg = @imagecreatefromgif($bg);
        }
        return $bgImg;
    }
    public function GrabImage($url, $filename = "") {
        if ($url == "") {
            return false;
        }

        if ($filename == "") {
            $ext = strrchr($url, ".");
            if ($ext != ".gif" && $ext != ".jpg" && $ext != ".png") {
                return false;
            }

            $filename = date("YmdHis") . $ext;
        }
        ob_start();
        readfile($url);
        $img = ob_get_contents();
        ob_end_clean();
        $size = strlen($img);
        $fp2  = @fopen($filename, "a");
        fwrite($fp2, $img);
        fclose($fp2);
        return $filename;
    }

    public static function writeText($bg, $out, $text, $param = array()) {
        list($bgWidth, $bgHeight) = @getimagesize($bg);
        extract($param);
        $im    = imagecreatefromjpeg($bg);
        $black = imagecolorallocate($im, 0, 0, 0);
        $font  = IA_ROOT . '/addons/yc_youliao/font/msyhbd.ttf';
        $white = imagecolorallocate($im, 255, 255, 255);
        imagettftext($im, $size, 0, $left, $top + $size / 2, $white, $font, $text);
        ob_start();
        imagejpeg($im, null, 100);
        $contents = ob_get_contents();
        ob_end_clean();
        imagedestroy($im);
        $fh = fopen($out, "w+");
        fwrite($fh, $contents);
        fclose($fh);
    }
    public static function decode_channel_param($item, $p) {
        $gpc                  = unserialize($p);
        $item['qrleft']       = intval($gpc['qrleft']) ? intval($gpc['qrleft']) : 145;
        $item['qrtop']        = intval($gpc['qrtop']) ? intval($gpc['qrtop']) : 475;
        $item['qrwidth']      = intval($gpc['qrwidth']) ? intval($gpc['qrwidth']) : 240;
        $item['qrheight']     = intval($gpc['qrheight']) ? intval($gpc['qrheight']) : 240;
        $item['avatarleft']   = intval($gpc['avatarleft']) ? intval($gpc['avatarleft']) : 111;
        $item['avatartop']    = intval($gpc['avatartop']) ? intval($gpc['avatartop']) : 10;
        $item['avatarwidth']  = intval($gpc['avatarwidth']) ? intval($gpc['avatarwidth']) : 86;
        $item['avatarheight'] = intval($gpc['avatarheight']) ? intval($gpc['avatarheight']) : 86;
        $item['avatarenable'] = intval($gpc['avatarenable']);
        $item['nameleft']     = intval($gpc['nameleft']) ? intval($gpc['nameleft']) : 210;
        $item['nametop']      = intval($gpc['nametop']) ? intval($gpc['nametop']) : 28;
        $item['namesize']     = intval($gpc['namesize']) ? intval($gpc['namesize']) : 30;
        $item['namecolor']    = $gpc['namecolor'];
        $item['nameenable']   = intval($gpc['nameenable']);
        return $item;
    }
//创建目录
    static function mkdirs($path) {
        if (!is_dir($path)) {
            mkdir($path,0777,true);
        }
        return is_dir($path);
    }
    public static function  qrcode_adv($attachurl,$uniacid,$from_user, $bg,$qr_file,$channel){
       // echo $qr_file;
        $ch                  = pdo_fetch("SELECT * FROM " . tablename(CHANNEL) . " WHERE channel=:channel", array(":channel" => $channel));
        $ch = self::decode_channel_param($ch, $ch['bgparam']);
        $rand_file = $from_user . '.jpg';
        $att_target_file = 'qr-image-' . $rand_file;
        $att_head_cache_file = 'head-image-' . $rand_file;
        $dir_file=ATTACHMENT_ROOT. 'yc_youliao/tmppic/';
        $mihua_dir= MODULE_ROOT . '/tmppic/';
        self::mkdirs($dir_file);
        self::mkdirs($mihua_dir);
        $target_file = $dir_file . $att_target_file;
        $head_cache_file = $mihua_dir . $att_head_cache_file;
        $qr_cache_file=$mihua_dir . 'qr-'.$uniacid.'-'.$from_user . '.jpg';
        self::curl_or_file_get_content($qr_file,$qr_cache_file);
        $bg_file             =tomedia($bg);
        self::mergeImage($bg_file, $qr_cache_file, $target_file, array('left' => $ch['qrleft'], 'top' => $ch['qrtop'], 'width' => $ch['qrwidth'], 'height' => $ch['qrheight']));
        $enableHead = $ch['avatarenable'];
        $enableName = $ch['nameenable'];
        $uid = mc_openid2uid($from_user);
        $fans = mc_fetch($uid, array('nickname', 'avatar'));
        $fans_info = mc_fansinfo($uid, $uniacid, $uniacid);
            if (!empty($fans)) {
                if ($enableName) {
                    if (strlen($fans_info['nickname']) > 0) {
                        self::writeText($target_file, $target_file, '我是' . $fans_info['nickname'], array('size' => $ch['namesize'], 'left' => $ch['nameleft'], 'top' => $ch['nametop']));
                    }
        }
        if ($enableHead) {
            if (strlen($fans['avatar']) > 10) {
                $head_file = $fans['avatar'];
                self::curl_or_file_get_content($head_file,$head_cache_file);
                self::mergeImage($target_file, $head_cache_file, $target_file, array('left' => $ch['avatarleft'], 'top' => $ch['avatartop'], 'width' => $ch['avatarwidth'], 'height' => $ch['avatarheight']));
            }
        }
              //删除缓存的所有数据
                array_map('unlink',glob(MODULE_ROOT . '/tmppic/*'));
        }
        return $target_file;
    }

//删除目录下所有的文件
   static function delFileUnderDir( $dirName )
    {
        if ( $handle = opendir( "$dirName" ) ) {
            while ( false !== ( $item = readdir( $handle ) ) ) {
                if ( $item != "." && $item != ".." ) {
                    if ( is_dir( "$dirName/$item" ) ) {
                        delFileUnderDir( "$dirName/$item" );
                    }
}
}
closedir( $handle );
}
}

//生成二维码
    private function shopQrcode($shop_id) {
        global $_W;
        load()->model('mc');
        load()->classs('account');
        $barcode = array(
            'action_name' => 'QR_LIMIT_SCENE',    // 临时二维码,
            'action_info' => array(
                'scene' => array(
                    'scene_id' => $shop_id
                )
            ),
        );
        $this->account = WeAccount::create($_W['acid']);
        $weixin_qr = $this->account->barCodeCreateFixed($barcode);
        $qr_file = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=" . $weixin_qr['ticket'];

        return $qr_file;


    }

}
	
?>