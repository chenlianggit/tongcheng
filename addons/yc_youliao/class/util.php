<?php

class Util 
{
	
	//查询模块config
	static function getModuleConfig(){
		$modulelist = uni_modules(false);
		return $modulelist['yc_youliao']['config'];
	}
	
	//注册jssdk，因为微擎自带的方法内没有加openAddress，所以重新写一个。
	static function register_jssdk($debug = false){
		global $_W;
		if (defined('HEADER')) {
			echo '';
			return;
		}

		$sysinfo = array(
			'uniacid' 	=> $_W['uniacid'],
			'acid' 		=> $_W['acid'],
			'siteroot' 	=>"https://".$_SERVER ['HTTP_HOST'],        // $_W['siteroot'],
			'siteurl' 	=>"https://".$_SERVER ['HTTP_HOST'].'attachment',
			'attachurl' =>"https://".$_SERVER ['HTTP_HOST'].'attachment',
			'cookie' 	=> array('pre'=>$_W['config']['cookie']['pre'])
		);
		if (!empty($_W['acid'])) {
			$sysinfo['acid'] = $_W['acid'];
		}
		if (!empty($_W['openid'])) {
			$sysinfo['openid'] = $_W['openid'];
		}
		if (defined('MODULE_URL')) {
			$sysinfo['MODULE_URL'] = MODULE_URL;
		}
		$sysinfo = json_encode($sysinfo);
		$jssdkconfig = json_encode($_W['account']['jssdkconfig']);
		$debug = $debug ? 'true' : 'false';

		$script = <<<EOF
	<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
	<script type="text/javascript">
		window.sysinfo = window.sysinfo || $sysinfo || {};
		
		// jssdk config 对象
		jssdkconfig = $jssdkconfig || {};
		
		// 是否启用调试
		jssdkconfig.debug = $debug;
		
		jssdkconfig.jsApiList = [
			'checkJsApi',
			'onMenuShareTimeline',
			'onMenuShareAppMessage',
			'onMenuShareQQ',
			'onMenuShareWeibo',
			'hideMenuItems',
			'showMenuItems',
			'hideAllNonBaseMenuItem',
			'showAllNonBaseMenuItem',
			'translateVoice',
			'startRecord',
			'stopRecord',
			'onRecordEnd',
			'playVoice',
			'pauseVoice',
			'stopVoice',
			'uploadVoice',
			'downloadVoice',
			'chooseImage',
			'previewImage',
			'uploadImage',
			'downloadImage',
			'getNetworkType',
			'openLocation',
			'getLocation',
			'hideOptionMenu',
			'showOptionMenu',
			'closeWindow',
			'scanQRCode',
			'chooseWXPay',
			'openProductSpecificView',
			'addCard',
			'chooseCard',
			'openCard',
			'openAddress'
		];
		
		wx.config(jssdkconfig);
		
	</script>
EOF;
		echo $script;
	}

    static function web_register_jssdk($debug = false){
        global $_W;
        if (defined('HEADER')) {
            echo '';
            return;
        }

        $sysinfo = array(
            'uniacid' 	=> $_W['uniacid'],
            'acid' 		=> $_W['acid'],
            'siteroot' 	=> $_W['siteroot'],
            'siteurl' 	=> $_W['siteurl'],
            'attachurl' => $_W['attachurl'],
            'cookie' 	=> array('pre'=>$_W['config']['cookie']['pre'])
        );
        if (!empty($_W['acid'])) {
            $sysinfo['acid'] = $_W['acid'];
        }
        if (!empty($_W['openid'])) {
            $sysinfo['openid'] = $_W['openid'];
        }
        if (defined('MODULE_URL')) {
            $sysinfo['MODULE_URL'] = MODULE_URL;
        }
        $sysinfo = json_encode($sysinfo);
        $jssdkconfig = json_encode($_W['account']['jssdkconfig']);
        $debug = $debug ? 'true' : 'false';

        $script = <<<EOF
	<script src="https://res.wx.qq.com/open/js/jweixin-1.1.0.js"></script>
	<script type="text/javascript">
		window.sysinfo = window.sysinfo || $sysinfo || {};
		
	</script>
EOF;
        echo $script;
    }

    //微信端上传图片 传入微信端下载的图片
	static function uploadImageInWeixin($resp){
		global $_W;
		$setting = $_W['setting']['upload']['image'];
		$setting['folder'] = "images/{$_W['uniacid']}".'/'.date('Y/m/');	
		
/* 		load()->func('communication');
		$resp = ihttp_get($url); */
		load()->func('file');
		if (is_error($resp)) {
			$result['message'] = '提取文件失败, 错误信息: '.$resp['message'];
			return json_encode($result);
		}
		if (intval($resp['code']) != 200) {
			$result['message'] = '提取文件失败: 未找到该资源文件.';
			return json_encode($result);
		}
		$ext = '';
		
		switch ($resp['headers']['Content-Type']){
			case 'application/x-jpg':
			case 'image/jpeg':
				$ext = 'jpg';
				break;
			case 'image/png':
				$ext = 'png';
				break;
			case 'image/gif':
				$ext = 'gif';
				break;
			default:
				$result['message'] = '提取资源失败, 资源文件类型错误.';
				return json_encode($result);
				break;
		}
		
		if (intval($resp['headers']['Content-Length']) > $setting['limit'] * 1024) {
			$result['message'] = '上传的媒体文件过大('.sizecount($size).' > '.sizecount($setting['limit'] * 1024);
			return json_encode($result);
		}
		$originname = pathinfo($url, PATHINFO_BASENAME);
		$filename = file_random_name(ATTACHMENT_ROOT .'/'. $setting['folder'], $ext);
		$pathname = $setting['folder'] . $filename;
		$fullname = ATTACHMENT_ROOT . '/' . $pathname;
		if (file_put_contents($fullname, $resp['content']) == false) {
			$result['message'] = '提取失败.';
			return json_encode($result);
		}
		$info = array(
			'name' => $originname,
			'ext' => $ext,
			'filename' => $pathname,
			'attachment' => $pathname,
			'url' => tomedia($pathname),
			'is_image' => $type == 'image' ? 1 : 0,
			'filesize' => filesize($fullname),
		);		
		return json_encode($info);
	}	
	
	
	//格式化时间,多久之前
	static function formatTime($time){
		$difftime = time() - $time;
		
		if($difftime < 60){
			return $difftime . '秒前';
		}
		if($difftime < 120){
			return '1分钟前';	
		}
		if($difftime < 3600){
			return  intval($difftime/60).'分钟前';			
		}		
		if($difftime < 3600*24){
			return  intval($difftime/60/60).'小时前';			
		}
		if($difftime < 3600*24*2){
			return  '昨天';			
		}
		return  intval($difftime/60/60/24).'天前';
	}
	
	//剩余时间
	static function lastTime($time,$secondflag = true){
		$diff = $time - time();
		if($diff <= 0) return '0天0时0分';
		$day = intval($diff/24/3600);
		$hour = intval( ($diff%(24*3600))/3600 );
		$minutes = intval( ($diff%(24*3600))%3600/60 );
		$second = $diff%60;
		if($secondflag){
			return $day. '天' . $hour . '时' .$minutes. '分' .$second. '秒';
		}else{
			return $day. '天' . $hour . '时' .$minutes. '分';
		}
	}	
	
	
	
	//当前距明天的时间差
	static function diffTimeOftomorrow(){
		$tomo = date("Y-m-d",strtotime("+1 day"));
		return strtotime($tomo) - time();
	}
	
	//删除数据库
	static function deleteData($id,$tablename){
		global $_W;
		if($id == '') return false;
		$id = intval($id);
		$datainfo = self::getSingelDataInSingleTable($tablename,array('id'=>$id));
		if (empty($datainfo)) message('抱歉，数据不存在或是已经被删除！');		
		$res = pdo_delete($tablename, array('id' => $id,'uniacid' => $_W['uniacid']), 'AND');
		return $res;
	}
    //删除数据库(条件)
    static function deleteData2($data,$data1,$tablename){
        global $_W;
        if($data == '' || $data1 == '') return false;
        $res = pdo_delete($tablename, array($data => $data1,'uniacid' => $_W['uniacid']), 'AND');
        return $res;
    }

    //插入数据
	static function inserData($tablename,$data){
		global $_W;
		if($data == '') return false;
		$data = $data;
		$data['uniacid'] = $_W['uniacid'];
		$res = pdo_insert($tablename,$data);
		// die("uniacid".$data['uniacid'] .'|||||||||||||params:'.$data['type'].'|||||||||||||pagename:'.$data['pagename']
		// .'|||||||||||||basicparams:'.$data['basicparams'].'|||||||||||||params:'.$data['params']
		// .'|||||||||||||time:'.$data['time'].'|||||||||||||status:'.$data['status']
		// );
		return $res;
	}
	
	//根据条件查询数据条数
	static function countDataNumber($tablename,$where,$str = ''){
		global $_W;
		$data = self::structWhereStringOfAnd($where);	
		return pdo_fetchcolumn(" SELECT COUNT(*) FROM " . tablename($tablename) . " WHERE $data[0] ".$str,$data[1]);
	}
	
	//更新单条数据，对数据进行加减，更新。需传入id
	static function addOrMinusOrUpdateData($tablename,$countarray,$id,$type='addorminus'){
		global $_W;
		if(empty($countarray)) return false;
		$count = '';
		if($type == 'addorminus'){
			foreach($countarray as $k=>$v){
				$count .= ' `'.$k.'`'.' = '.' `'.$k.'` '.' + '.$v.',';
			}
		}elseif($type == 'update'){
			foreach($countarray as $k=>$v){
				$count .= "`".$k."` = '".$v."',";
			}
		}
		$count = trim($count,',');
		$id = intval($id);
		$res = pdo_query("UPDATE ".tablename($tablename)." SET $count WHERE `id` = '{$id}' AND `uniacid` = '{$_W['uniacid']}' ");
		if($res) return true;
		return false;
	}

	//在一个表里查询单条数据
	static function getSingelDataInSingleTable($tablename,$array,$select='*',$type='1',$orderby=''){
        if($type==2){
            $data = self::structWhereStringOfAnd($array,'',$type);
        }else{
            $data = self::structWhereStringOfAnd($array);
        }
		$sql = "SELECT $select FROM ". tablename($tablename) ." WHERE $data[0] ".$orderby;
		return pdo_fetch($sql,$data[1]);
	}


    //在一个表里查询所有符合条件的数据
    static function getAllDataBySingleTable($tablename,$array,$orderby,$select='*',$type='1',$group='1'){
	    if($type==2){
            $data = self::structWhereStringOfAnd($array,'',$type);
        }else{
            $data = self::structWhereStringOfAnd($array);
        }
        if($group==2){
            $sql = "SELECT $select FROM ". tablename($tablename) ." WHERE $data[0] " .$orderby ;
        }else{
            $sql = "SELECT $select FROM ". tablename($tablename) ." WHERE $data[0] " .' order by '.$orderby ;
        }

        return pdo_fetchall($sql,$data[1]);
    }
	//在一个表里查询多条数据
	static function getAllDataInSingleTable($tablename,$where,$page,$num,$order='id DESC',$isNeadPager = true,$select = '*',$type='1'){
        if($type=='2'){
            $data = self::structWhereStringOfAnd($where,'',$type);
        }else{
            $data = self::structWhereStringOfAnd($where);
        }
		$countStr = "SELECT COUNT(*) FROM ".tablename($tablename) ." WHERE $data[0] ";
		$selectStr = "SELECT $select FROM ".tablename($tablename) ." WHERE $data[0] ";
		$res = self::fetchFunctionInCommon($countStr,$selectStr,$data[1],$page,$num,$order,$isNeadPager);
		//print_r ($res);
		return $res;
	}

    //在一个表里查询多条数据的数量
    static function getAllDataNumInSingleTable($tablename,$where,$type='1'){
        global $_W;
	    if(empty($where) &&  $type=='1'){
            $countStr = pdo_fetch("SELECT COUNT(*) as num FROM ".tablename($tablename) ." WHERE uniacid=:uniacid",array(":uniacid"=>$_W['uniacid']));

            return $countStr['num'];
        }elseif(empty($where) &&  $type=='2'){
            $countStr = pdo_fetch("SELECT COUNT(*) as num FROM ".tablename($tablename) ." WHERE weid=:uniacid",array(":uniacid"=>$_W['uniacid']));

            return $countStr['num'];
        }else{
            if($type=='2'){
                $data = self::structWhereStringOfAnd($where,'',$type);
            }else{
                $data = self::structWhereStringOfAnd($where);
            }

            $countStr = "SELECT COUNT(*) as num FROM ".tablename($tablename) ." WHERE $data[0] ";
            $num=pdo_fetch($countStr,$data[1]);
            return $num['num'];

        }


    }
	
	/*
	*	查询数据共用方法
	*	$selectStr -> mysql字符串
	*	$page -> 页码
	*	$num -> 每页数量
	*	$order -> 排序
	*	$isNeadPager -> 是否需要分页
	*/
	static function fetchFunctionInCommon($countStr,$selectStr,$params,$page,$num,$order='`id` DESC',$isNeadPager=false){
		$pindex = max(1, intval($page));
		$psize = $num;
		$total =  $isNeadPager?pdo_fetchcolumn($countStr,$params):'';
            $data = pdo_fetchall($selectStr." ORDER BY $order " . " LIMIT " . ($pindex - 1) * $psize . ',' . $psize,$params);

		$pager = $isNeadPager?pagination($total, $pindex, $psize):'';
		return array($data,$pager,$total);
	}	
	
	//组合AND数据查询where字符串 = ,>= ,<= <、>必须紧挨字符 例：$where = array('status'=>1,'overtime<'=>time());
 	static function structWhereStringOfAnd($array,$head='',$type='1'){
		global $_W;
		if(!is_array($array)) return false;
		if($type=='2'){
            $array['weid'] = $_W['uniacid'];
        }else{
            $array['uniacid'] = $_W['uniacid'];
        }

		$str = '';
		foreach($array as $k=>$v){
			if(isset($k) && $v === '') message('存在异常参数'.$k);
			if(strpos($k,'>') !== false){
				$k = trim(trim($k),'>');
				$eq = ' >= ';
			}elseif(strpos($k,'<') !== false){
				$k = trim(trim($k),'<');
				$eq = ' <= ';
			}elseif(strpos($k,'@') !== false){ //模糊查询
				$eq = ' LIKE ';
				$k = trim(trim($k),'@');
				$v = "%".$v."%";
			}elseif(strpos($k,'#') !== false){ //in查询
				$eq = ' IN ';
				$k = trim(trim($k),'#');
			}else{
				$eq = ' = ';
			}
			$str .= empty($head) ? 'AND `'.$k.'`'.$eq.':'.$k.' ' : 'AND '.$head.'.`'.$k.'`'.$eq.':'.$k.' ';
			
			$params[':'.$k] = $v;
			
		}
		$str = trim($str,'AND');
		return array($str,$params);
	}	
	
	
	//用户唯一字符串
	static function structUserStr($openid){
		global $_W;
		if($openid == '') return false;
		$openid = empty($openid)?$_W['openid']:$openid;
		$rump = substr($openid, -20);
		return 'fshopuser'.$rump.$_W['uniacid'];		
	}
	
	//获取cookie 传入cookie名 //解决js与php的编码不一致情况。
	static function getCookie($str){
		return urldecode($_COOKIE[$str]);
	}
	
	//共用先查询缓存数据
	static function getDataByCacheFirst($key,$name,$funcname,$valuearray){
		$data = self::getCache($key,$name);
		if(empty($data)){
			$data = call_user_func_array($funcname,$valuearray);
			self::setCache($key,$name,$data);
		}
		return $data;
	}
	
	//查询缓存
 	static function getCache($key,$name) {
		global $_W;
		if(empty($key) || empty($name)) return false;
		return cache_read('yc_youliao:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	
	//设置缓存
	static function setCache($key,$name,$value) {
		global $_W;
		if(empty($key) || empty($name)) return false;	
		
		$res = cache_write('yc_youliao:'.$_W['uniacid'].':'.$key.':'.$name,$value);
		return $res;
	}
	
	//删除缓存
	static function deleteCache($key,$name) {
		global $_W;		
		if(empty($key) || empty($name)) return false;
		
		return cache_delete('yc_youliao:'.$_W['uniacid'].':'.$key.':'.$name);
	}
	
	//删除所有缓存 每次设置参数后都要删除
	static function deleteThisModuleCache(){
		global $_W;
		$res = cache_clean('yc_youliao');
		return $res;
	}
	
	//创建目录
	static function mkdirs($path) {
		if (!is_dir($path)) {
			mkdir($path,0777,true);
		}
		return is_dir($path);
	}
    //查看目录是否存在，存在返回true,不存在返回false,并创建目录

    //核查文件是否存在
	static function fileExists($name,$dir=''){
		global $_W;		
		if(empty($name)){
			return false;
		}	
		$name = MD5($name.$GLOBALS['_W']['config']['setting']['authkey']);	
		$dir = yc_youliao . 'cache/' .$_W['uniacid'] . '/' . $dir;	
		$file = $dir . '/' . $name.'.php';		
		if(file_exists($file)){
			return true;
		}else{
			return false;
		}
	}
	
	//加密
	static function encrypt($str){
		global $_W;
		return authcode($str, 'ENCODE' ,$_W['account']['key'],600); 
	}
	//解密
	static function decode($str){
		global $_W;
		return authcode($str, 'DECODE' ,$_W['account']['key'],600); 
	}	
	
	
	//组合URL
	static function createModuleUrl($do,$array=''){
		global $_W;
		$str = '&do='.$do;
        if( is_array( $array ) ) {
            foreach ($array as $k => $v) {
                $str .= '&' . $k . '=' . $v;
            }
        }
		return $_W['siteroot'].'app/index.php?i='.$_W['uniacid'].'&c=entry'.$str.'&m=yc_youliao';
	}	
	
	//处理空格
	static function trimWithArray($array){
		if(!is_array($array)){
			return trim($array);
		}
		foreach($array as $k=>$v){	
			$res[$k] = self::trimWithArray($v);
		}
		return $res;	
	}
	
    public static function httpRequest($url, $post = '', $headers = array(), $forceIp = '', $timeout = 60, $options = array())
    {
        load()->func('communication');
        return ihttp_request($url, $post, $options, $timeout);
    }
	//get请求
    public static function httpGet($url, $forceIp = '', $timeout = 60)
    {
        $res = self::httpRequest($url, '', array(), $forceIp, $timeout);
        if (!is_error($res)) {
            return $res['content'];
        }
        return $res;
    }
	//post请求
    public static function httpPost($url, $data, $forceIp = '', $timeout = 60)
    {
        $headers = array('Content-Type' => 'application/x-www-form-urlencoded');
        $res = self::httpRequest($url, $data, $headers, $forceIp, $timeout);
        if (!is_error($res)) {
            return $res['content'];
        }
        return $res;
    }



function Array2String($Array)
{
    $Return='';
    $NullValue="^^^";
    foreach ($Array as $Key => $Value) {
        if(is_array($Value))
            $ReturnValue='^^array^'.Array2String($Value);
        else
            $ReturnValue=(strlen($Value)>0)?$Value:$NullValue;
        $Return.=urlencode(base64_encode($Key)) . '|' . urlencode(base64_encode($ReturnValue)).'||';
    }
    return urlencode(substr($Return,0,-2));
}

// convert a string generated with Array2String() back to the original (multidimensional) array
// usage: array String2Array ( string String)
function String2Array($String)
{
    $Return=array();
    $String=urldecode($String);
    $TempArray=explode('||',$String);
    $NullValue=urlencode(base64_encode("^^^"));
    foreach ($TempArray as $TempValue) {
        list($Key,$Value)=explode('|',$TempValue);
        $DecodedKey=base64_decode(urldecode($Key));
        if($Value!=$NullValue) {
            $ReturnValue=base64_decode(urldecode($Value));
            if(substr($ReturnValue,0,8)=='^^array^')
                $ReturnValue=String2Array(substr($ReturnValue,8));
            $Return[$DecodedKey]=$ReturnValue;
        }
        else
        $Return[$DecodedKey]=NULL;
    }
    return $Return;
}

//核销二维码链接
    static function getVerify($shop_id,$oid){
        global $_W;
        return  $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&c=entry&do=verification&shop_id=".$shop_id."&m=yc_youliao&oid=".$oid;
    }

//生成二维码
    public static function getURLQR($url,$imgname) {//识别的url，图片名称
        global $_W;
        $errorCorrectionLevel = "L";
        $matrixPointSize      = "4";
        $imgdir=self::getAttImgdir();
        $att_target_file      = $imgdir.'/mihua_sq_' .  $imgname . '.png';
        $target_file          = ATTACHMENT_ROOT.$att_target_file;
        QRcode::png($url, $target_file, $errorCorrectionLevel, $matrixPointSize);
        if (!empty($_W['setting']['remote']['type'])) { // 判断系统是否开启了远程附件
            $remotestatus = file_remote_upload($att_target_file); //上传图片到远程
            if (is_error($remotestatus)) {
                message('远程附件上传失败，请检查配置并重新上传');
            }
        }
        return $att_target_file;
    }
    public static function getTURLQR($url,$imgname) {//识别的url，图片名称
       include 'qrcode.class.php';
        global $_W;
        $errorCorrectionLevel = "L";
        $matrixPointSize      = "4";
        $imgdir=self::getAttImgdir();
        $att_target_file      = $imgdir.'/mihua_sq_' .  $imgname . '.png';
        $target_file          = ATTACHMENT_ROOT.$att_target_file;
        QRcode::png($url, $target_file, $errorCorrectionLevel, $matrixPointSize);
        if (!empty($_W['setting']['remote']['type'])) { // 判断系统是否开启了远程附件
            $remotestatus = file_remote_upload($att_target_file); //上传图片到远程
            if (is_error($remotestatus)) {
                message('远程附件上传失败，请检查配置并重新上传');
            }
        }
        return $att_target_file;
    }

    static function getrandomstr($tablename,$length,$colname){
        global $_W;
        $ordersn=self::randombylength_num($length);
        while(pdo_fetch("select * from ".tablename($tablename)." where {$colname}='{$ordersn}' and  uniacid='{$_W['uniacid']}'")){
            $ordersn=self::randombylength_num($length);
        }
        return $ordersn;
    }
    //生成随机文件名函数
    static  function randombylength_num($length){
        $hash = '';
        $chars = 'abcdefghijklmnopqrstuvwxyz0123456789';
        $max = strlen($chars) - 1;
        mt_srand((double)microtime() * 1000000);
        for($i = 0; $i < $length; $i++)
        {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    /** * @desc 根据两点间的经纬度计算距离 * @param float $lat 纬度值 * @param float $lng 经度值 */
static function getDistance($lat1, $lng1, $lat2, $lng2) {
    if(empty($lat1)|| empty($lng1) || empty($lat2)|| empty($lng2)){
        return 0;
    }
        $earthRadius = 6367000;
        $lat1 = ($lat1 * pi() ) / 180;
        $lng1 = ($lng1 * pi() ) / 180;
        $lat2 = ($lat2 * pi() ) / 180;
        $lng2 = ($lng2 * pi() ) / 180;
        $calcLongitude = $lng2 - $lng1; $calcLatitude = $lat2 - $lat1;
        $stepOne = pow(sin($calcLatitude / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($calcLongitude / 2), 2);
        $stepTwo = 2 * asin(min(1, sqrt($stepOne)));
        $calculatedDistance = ($earthRadius * $stepTwo)/1000;
        return round($calculatedDistance,2);
    }

    //取数组中第一条数据
    static function multi_array_sort($multi_array,$sort_key,$sort=SORT_DESC){
        if(is_array($multi_array)){
            foreach ($multi_array as $row_array){
                if(is_array($row_array)){
                    $key_array[] = $row_array[$sort_key];
                }else{
                    return -1;
                }
            }
        }else{
            return -1;
        }
        array_multisort($key_array,$sort,$multi_array);
        return array_slice($multi_array, 0, 1);
    }


//对数组的某个字段排序方法

    static function arrCmp($arr,$where){
        $flag=array();
        foreach($arr as $arr2){
            $flag[]=$arr2[$where];
        }
        array_multisort($flag, SORT_ASC, $arr);
        return $arr;

    }
    static function img_exists($url)
    {
        if (@file_get_contents($url, 0, null, 0, 1)) {
            return 1;
        } else {
            return 0;
        }
    }


   static function encode_channel_param($gpc) {
        $params = array('qrleft' => intval($gpc['qrleft']), 'qrtop' => intval($gpc['qrtop']), 'qrwidth' => intval($gpc['qrwidth']), 'qrheight' => intval($gpc['qrheight']), 'avatarleft' => intval($gpc['avatarleft']), 'avatartop' => intval($gpc['avatartop']), 'avatarwidth' => intval($gpc['avatarwidth']), 'avatarheight' => intval($gpc['avatarheight']), 'avatarenable' => intval($gpc['avatarenable']), 'nameleft' => intval($gpc['nameleft']), 'nametop' => intval($gpc['nametop']), 'namesize' => intval($gpc['namesize']), 'namecolor' =>$gpc['namecolor'], 'nameenable' => intval($gpc['nameenable']));
        return serialize($params);
    }
   static function decode_channel_param($item, $p) {
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

    static function mergeImage($bg, $qr, $out, $param) {
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
    static function imagecreate($bg) {
        $bgImg = @imagecreatefromjpeg($bg);
        if (false == $bgImg) {
            $bgImg = @imagecreatefrompng($bg);
        }
        if (false == $bgImg) {
            $bgImg = @imagecreatefromgif($bg);
        }
        return $bgImg;
    }
    static function GrabImage($url, $filename = "") {
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

    static function writeText($bg, $out, $text, $param = array()) {
        list($bgWidth, $bgHeight) = getimagesize($bg);
        extract($param);
        $im    = imagecreatefromjpeg($bg);
        $black = imagecolorallocate($im, 0, 0, 0);
        $font  = IA_ROOT . '/app/resource/fonts/mui.ttf';
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
    static function curl_file_get_contents($durl) {
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

   static function sendtemmsg($tplid, $arrmsg,$openid)
    {
        global $_W;

        $account_api = WeAccount::create();
        $token = $account_api->getAccessToken();
        $url = 'https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=' . $token;
        $tpldetailed = pdo_fetch('SELECT * FROM ' . tablename(TPL) . " WHERE id = {$tplid} LIMIT 1");
        $tplkeys = unserialize($tpldetailed['tpl_key']);
        $postData = array();
        $postData['template_id'] = $tpldetailed['tpl_id'];
        $postData['url'] = $arrmsg['url'];
        $postData['topcolor'] = $arrmsg['topcolor'];
        foreach ($tplkeys as $value) {
            $postData['data'][$value['key']]['value'] = $arrmsg[$value['key']];
            $postData['data'][$value['key']]['color'] = $arrmsg[$value['key'] . 'color'];
        }
        pdo_insert(sendlog, array('tpl_id' => $tplid, 'tpl_title' => $tpldetailed['tpl_title'], 'message' => serialize($postData), 'time' => time(), 'uniacid' => $_W['uniacid'], 'target' => $arrmsg['openid'], 'type' => 1));
        $tid = pdo_insertid();
        $success = 0;
        $fail = 0;
        $error = '';
        $postData['touser'] = $arrmsg['openid'];
        $res = ihttp_post($url, json_encode($postData));
        $re = json_decode($res['content'], true);
        if ($re['errmsg'] == 'ok') {
            $success++;
        } else {
            $fail++;
            $error .= $openid;
        }
        pdo_update(sendlog, array('success' => $success, 'fail' => $fail, 'error' => $error, 'status' => 1), array('id' => $tid));
    }

    static  function time_tran($the_time) {
        $timediff = $the_time - time();
        $days     = intval($timediff / 86400);
        if (strlen($days) <= 1) {
            $days = "0" . $days;
        }
        $remain = $timediff % 86400;
        $hours  = intval($remain / 3600);
        if (strlen($hours) <= 1) {
            $hours = "0" . $hours;
        }
        $remain = $remain % 3600;
        $mins   = intval($remain / 60);
        if (strlen($mins) <= 1) {
            $mins = "0" . $mins;
        }
        $secs = $remain % 60;
        if (strlen($secs) <= 1) {
            $secs = "0" . $secs;
        }
        $ret = "";
        if ($days > 0) {
            //$ret .= $days . " 天 ";
            $ret .="<span class='day'>"+$days+" </span>天 ";
        }
        if ($hours > 0) {
            //$ret .= $hours . ":";
            $ret .="<span class='hour'>"+$hours+" </span> "+":";
        }
        if ($mins > 0) {
            //$ret .= $mins . ":";
            $ret .="<span class='min'>"+$mins+" </span> "+":";
        }
        //$ret .= $secs;
        $ret .="<span class='sec'>"+$secs+" </span> ";
        return array($ret, $timediff);
    }

    static  function  randomFloat($min = 0, $max = 1) {
        $num= $min + mt_rand() / mt_getrandmax() * ($max - $min);
        return sprintf("%.2f", $num);
    }


    static function SaveAjaxUpload( $img){
        global $_W;
        $url=self::getimgdir();
        $imgurl = ATTACHMENT_ROOT.$url;
        if(!is_dir($imgurl)){
            mkdir($imgurl,0777,true);
        }

        $img=str_ireplace('data:image/jpeg;base64,','',$img);
        $img = base64_decode($img);
        $photo = self::createimgname();
        $pathname=$imgurl.$photo;
        $randimgurl =$url.$photo;
        file_put_contents($pathname,$img);
        if (!empty($_W['setting']['remote']['type'])) { // 判断系统是否开启了远程附件
            $remote_url=self::checkdir($randimgurl);
            return $remote_url;
        }else{
            return $_W['attachurl'].$url.$photo;
        }

    }


 static function getimgdir(){
     global $_W;
     $url='images/'.$_W['uniacid'].'/'.date('Y').'/'.date('m');
     return $url;
 }

    static function getAttImgdir(){
        global $_W;
        $dir='images/'.$_W['uniacid'].'/'.date('Y').'/'.date('m');
        self::createDir( ATTACHMENT_ROOT.$dir);
        return $dir;
    }
    static function createDir($dir, $mode = 0777){
        if (is_dir($dir) || @mkdir($dir,$mode)) return true;
        if (!mk_dir(dirname($dir),$mode)) return false;
        return @mkdir($dir,$mode);
    }
static function createimgname(){
    $photo = '/'.md5(date('YmdHis').rand(1000, 9999)).'.jpg';
    return $photo;

}
    static function checkdir($pathname){
            $remotestatus = @file_remote_upload($pathname); //上传图片到远程
            if (is_error($remotestatus)) {
                // message('远程附件上传失败，请检查配置并重新上传');
            } else {
                $remoteurl = tomedia($pathname);  // 远程图片的访问URL
                return $remoteurl;
            }

    }


static function getordersn($tablename){
    global $_W;
    $ordersn=date('mdHis').random(4, 1);
    while(pdo_fetch("select * from ".tablename($tablename)." where ordersn='{$ordersn}' and  uniacid='{$_W['uniacid']}'")){
    $ordersn=date('mdHis').random(4, 1);
}
return $ordersn;
}

    static function serverIP(){
        return gethostbyname($_SERVER["SERVER_NAME"]);
    }
  static function result($errno = '0', $message = '', $data = array()){
        $result = array(
            'errno' => $errno,
            'message' => $message,
            'data' => $data
        );
        return $result;
    }
    public static function setOrderStock($id = '') {
        global $_W,$_GPC;
        $uniacid=$_W['uniacid'];
        $goods = pdo_fetchall("SELECT g.goods_id, g.title, g.thumb,  g.marketprice,g.total as 
		goodstotal,o.total,o.optionid,g.sales,g.totalcnf,r.status as orderstatus FROM " . tablename(ORDER_GOODS) .
            " o left join " . tablename(GOODS) . " g on o.goodsid=g.goods_id and  o.uniacid= g.uniacid" .
            " left join " . tablename(ORDER) . " r on r.id=o.orderid and  r.uniacid=o.uniacid" .
            " WHERE o.orderid='{$id}' and g.uniacid='{$uniacid}' ");
        foreach ($goods as $item) {
            if($item['orderstatus']>=2){
                $item['orderstatus']=1;
            }

            if ($item['totalcnf'] <=2 && $item['totalcnf']==$item['orderstatus']) {//0、拍下减库存		1、付款减库存	 2、永不减库存
                //message($item['totalcnf']."订单状态:".$item['orderstatus']."商品数量".$item['goodstotal'] ."订单数量". $item['total']);
                if (!empty($item['optionid'])) {
                    pdo_query("update " . tablename(OPTION) . " set stock=stock-:stock where id=:id",
                        array(":stock" => $item['total'], ":id" => $item['optionid']));
                }
                $data = array();

                if (!empty($item['goodstotal']) && $item['goodstotal'] != -1) {
                    $data['total'] = $item['goodstotal'] - $item['total'];
                }
                $data['sales'] = $item['sales'] + $item['total'];
                pdo_update(GOODS, $data, array('id' => $item['id']));
            }

        }
    }


    static function http_request($url,$timeout=30,$header=array()){
        if (!function_exists('curl_init')) {
            throw new Exception('server not install curl');
        }

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HEADER, true);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
        if (!empty($header)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
        }
        $data = curl_exec($ch);
        list($header, $data) = explode("\r\n\r\n", $data);
        $http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        if ($http_code == 301 || $http_code == 302) {
            $matches = array();
            preg_match('/Location:(.*?)\n/', $header, $matches);
            $url = trim(array_pop($matches));
            curl_setopt($ch, CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_HEADER, false);
            $data = curl_exec($ch);
        }

        if ($data == false) {
            curl_close($ch);
        }
        @curl_close($ch);
        return $data;
    }


    static  function getDistrictByLatLng($lat,$lng,$mapreq,$chagexy,$flag='0',$noauto='0',$ischangexy='0')
    {
       // https://www.szmihua.com/app/index.php?i=43&c=entry&do=index&op=mapWeather&m=yc_youliao&latitude=22.546184141037&longitude=114.06822599595
        if(empty($mapreq) || empty($chagexy) || empty($lat) || empty($lng)  ) return;
        //直接从百度地图获取的坐标不需要转换
        if($ischangexy=='0'){
            $changxyurl =$chagexy. "&coords=" .$lng. "," .$lat;
            $xydata = self::http_request($changxyurl);
            $xydata = json_decode($xydata, 1);
            if($xydata['status']==0){
                $lat=$xydata['result'][0]['x'];
                $lng=$xydata['result'][0]['y'];
            }
        }

        $mapurl = $mapreq . "&location=" . $lng . "," .$lat ;
        $mapdata = self::http_request($mapurl);
        $mapdata = json_decode($mapdata, 1);

        $province=$mapdata['result']['addressComponent']['province'];
        $city_name = $mapdata['result']['addressComponent']['city'];
        $district = $mapdata['result']['addressComponent']['district'];
        $formatted_address = $mapdata['result']['formatted_address'];
        $building = $mapdata['result']['pois'][0]['name'];
        $road = $mapdata['result']['addressComponent']['street'];
        $result_lat = $mapdata['result']['lat'];
        $result_lng = $mapdata['result']['lng'];
        $address=$road.$building;
        if($flag=="0"){//==1不需要缓存、只取数据
            setcookie('province',$province , time() + 3600 * 24 * 7);
            setcookie('city_name',$city_name , time() + 3600 * 24 * 7);
            setcookie('district', $district, time() + 3600 * 24 * 7);
            setcookie('lat', $lng, time() + 3600 * 24 * 7);//百度地图与谷歌地图lat与lng刚好相反
            setcookie('lng', $lat, time() + 3600 * 24 * 7);
            setcookie('address', $address, time() + 3600 * 24 * 7);
            setcookie('road', $road, time() + 3600 * 24 * 7);
            setcookie('building', $building, time() + 3600 * 24 * 7);
            setcookie('formatted_address', $formatted_address, time() + 3600 * 24 * 7);
            setcookie('reqlat', $lng, time() + 3600 * 24 * 7);//百度地图与谷歌地图lat与lng刚好相反
            setcookie('reqlng', $lat, time() + 3600 * 24 * 7);
        }
        if($noauto=='1'){
            //已手动切换城市，要标记
           // setcookie('lactionflag', 1, time() + 3600 * 24 );//只标记一天
            $_SESSION['lactionflag']      = 1;
        }elseif($noauto=='2'){
            $_SESSION['lactionflag']      = 0;
            setcookie('lat', '', time() - 3600 * 24 );
            setcookie('lng', '', time() - 3600 * 24 );
            setcookie('address', '', time() - 3600 * 24 );
            setcookie('formatted_address', '', time() - 3600 * 24 );
        }
        $data['pois']=$mapdata['result']['pois'];
        $data['status']='1';
        $data['province']=$province;
        $data['city']=$city_name;
        $data['district']=$district;
        $data['address']=$address;
        $data['formatted_address']=$formatted_address;
        //print_r($data);
        return $data;
        //返回城市名、实时位置、坐标
    }


    static  function getWeather($weatherurl,$city_name)//获取天气
    {
        if(empty($weatherurl) )return;
        $weatherurl = $weatherurl.$city_name;
        $weatherdata = file_get_contents("compress.zlib://".$weatherurl);
        $weatherdata=mb_convert_encoding( $weatherdata, 'UTF-8', 'UTF-8,GBK,GB2312,BIG5' );
        return $weatherdata;
        //返回城市名、实时位置、坐标
    }


//判断是否是今天
    static function isDiffDays($last_date){
        if (date('Y-m-d') == date('Y-m-d',$last_date)) {
            return 0;
        }else{
            return 1;
        }
    }
    static function isMobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\\d]{9}$|^14[5,7]{1}\\d{8}$|^15[^4]{1}\\d{8}$|^17[\\d]{9}$|^18[\\d]{9}$#', $mobile) ? true : false;
    }
    static function isCreditNo($vStr)
    {
        $vCity = array('11', '12', '13', '14', '15', '21', '22', '23', '31', '32', '33', '34', '35', '36', '37', '41', '42', '43', '44', '45', '46', '50', '51', '52', '53', '54', '61', '62', '63', '64', '65', '71', '81', '82', '91');
        if (!preg_match('/^([\\d]{17}[xX\\d]|[\\d]{15})$/', $vStr)) {
            return false;
        }
        if (!in_array(substr($vStr, 0, 2), $vCity)) {
            return false;
        }
        $vStr = preg_replace('/[xX]$/i', 'a', $vStr);
        $vLength = strlen($vStr);
        if ($vLength == 18) {
            $vBirthday = substr($vStr, 6, 4) . '-' . substr($vStr, 10, 2) . '-' . substr($vStr, 12, 2);
        } else {
            $vBirthday = '19' . substr($vStr, 6, 2) . '-' . substr($vStr, 8, 2) . '-' . substr($vStr, 10, 2);
        }
        if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) {
            return false;
        }
        if ($vLength == 18) {
            $vSum = 0;
            for ($i = 17; $i >= 0; $i--) {
                $vSubStr = substr($vStr, 17 - $i, 1);
                $vSum += pow(2, $i) % 11 * ($vSubStr == 'a' ? 10 : intval($vSubStr, 11));
            }
            if ($vSum % 11 != 1) {
                return false;
            }
        }
        return true;
    }

 static function getStrtotime($type){
        if($type==0) {//今天
            $date1 = date('Y-m-d');
            $date2 = date('Y-m-d', strtotime('+1 day'));
            //echo $date1.'   '.$date2;
//        }else if($type==1){//昨天
//            $date1=date('Y-m-d',strtotime('-1 day'));
//            $date2=date('Y-m-d');
//           // echo $date1.'   '.$date2;
        }else if($type==1){//本周
            $date1=date('Y-m-d',strtotime('+0 week Monday'));
            $date2=date('Y-m-d',strtotime('+1 week Monday'));
            //echo $date1.'   '.$date2;
//        }else if($type==3){//上周
//            $date1=date('Y-m-d',strtotime('-1 week Monday'));
//            $date2=date('Y-m-d',strtotime('+0 week Monday'));
//            //echo $date1.'   '.$date2;
        }else if($type==2){//本月
            $date1=date('Y-m-01',strtotime('+0 month'));
            $date2=date('Y-m-01',strtotime('+1 month'));
//            //echo $date1.'   '.$date2;
//        }else if($type==5) {//上月
//            $date1 = date('Y-m-01', strtotime('-1 month'));
//            $date2 = date('Y-m-01', strtotime('+0 month'));
//            //echo $date1 . '   ' . $date2;
        }else if($type==3) {//本年
            $date1 = date('Y-01-01', strtotime('+0 year'));
            $date2 = date('Y-01-01', strtotime('+1 year'));
            //echo $date1.'   '.$date2;
        }
     $start=strtotime($date1);
     $end=strtotime($date2);
     return array($start,$end);
}
//post 模拟
    public  static function  send_post($url,$post_data ) {
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type:application/json',//header 需要设置为 JSON
                'content' => $post_data,
                'timeout' => 60//超时时间
            )
        );
        $context = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context);
        return $result;
    }

    public static function send_post2($url,$post_data ) {
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type:application/x-www-form-urlencoded',//header 需要设置为 JSON
                'content' => $post_data,
                'timeout' => 60//超时时间
            )
        );

        $context = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context);
        return $result;
    }
    public static function send_post3($url, $post_data) {
        $postdata = http_build_query($post_data);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-type:application/x-www-form-urlencoded',
                'content' => $postdata,
                'timeout' => 15 * 60, // 超时时间（单位:s）
                'client-ip'=>CLIENT_IP,
                'x-forwarded-for'=>CLIENT_IP
            )
        );
        $context = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        return $result;
    }
public static function getYearStamp(){
     return 31556926;
}

}
	
?>