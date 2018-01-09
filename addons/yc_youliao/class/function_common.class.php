<?php

class MyFun {

	public function fileext($filename){
		return substr(strrchr($filename, '.'), 1);
    }

    //生成随机文件名函数  
    public function randombylength($length){
        $hash = 'CR-';
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';
        $max = strlen($chars) - 1;
        mt_srand((double)microtime() * 1000000);
        for($i = 0; $i < $length; $i++)
        {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    //生成随机文件名函数  
    public function randombylength_num($length){
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

    //生成随机文件名函数  
    public function randombylength_num_true($length){
        $hash = '';
        $chars = '0123456789';
        $max = strlen($chars) - 1;
        mt_srand((double)microtime() * 1000000);
        for($i = 0; $i < $length; $i++)
        {
            $hash .= $chars[mt_rand(0, $max)];
        }
        return $hash;
    }

    
 //$datetype day也可以改成year（年），month（月），hour（小时）minute（分），second（秒）
    public function doDate($datetype,$doaction,$donum,$datetime='') {
      if(empty($datetime)){$datetime=time();}
      return strtotime($doaction.$donum.' '.$datetype,$datetime);
  }


 /**
 * 友好的时间显示
 *
 * @param int    $sTime 待显示的时间
 * @param string $type  类型. normal | mohu | full | ymd | other
 * @param string $alt   已失效
 * @return string
 */
 function friendlyDate($sTime,$type = 'normal',$alt = 'false') {
    if (!$sTime)
        return '';
    //sTime=源时间，cTime=当前时间，dTime=时间差
    $cTime      =   time();
    $dTime      =   $cTime - $sTime;
    $dDay       =   intval(date("z",$cTime)) - intval(date("z",$sTime));
    //$dDay     =   intval($dTime/3600/24);
    $dYear      =   intval(date("Y",$cTime)) - intval(date("Y",$sTime));
    //normal：n秒前，n分钟前，n小时前，日期
    if($type=='normal'){
        if( $dTime < 60 ){
            if($dTime < 10){
                return '刚刚';    //by yangjs
            }else{
                return intval(floor($dTime / 10) * 10)."秒前";
            }
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        //今天的数据.年份相同.日期相同.
        }elseif( $dYear==0 && $dDay == 0  ){
            //return intval($dTime/3600)."小时前";
            return '今天'.date('H:i',$sTime);
        }elseif($dYear==0){
            return date("m月d日 H:i",$sTime);
        }else{
            return date("Y-m-d H:i",$sTime);
        }
    }elseif($type=='mohu'){
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif( $dDay > 0 && $dDay<=7 ){
            
            return intval($dDay)."天前";
        }elseif( $dDay > 7 &&  $dDay <= 30 ){
            return intval($dDay/7) . '周前';
        }elseif( $dDay > 30 ){
            return intval($dDay/30) . '个月前';
        }
    //full: Y-m-d , H:i:s
    }elseif($type=='mohu_ot'){
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif( $dDay > 0 && $dDay<=7 ){
            return intval($dDay)."天前 ".date("m月d日 H:i",$sTime);
        }elseif( $dDay > 7 &&  $dDay <= 30 ){
            return intval($dDay/7) . '周前 '.date("m月d日 H:i",$sTime);
        }elseif( $dDay > 30 ){
            return intval($dDay/30) . '个月前 '.date("m月d日 H:i",$sTime);
        }else{
            return date("y年m月d日 H:i",$sTime);
        }
    //full: Y-m-d , H:i:s
    }elseif($type=='ym_time'){
        if( $dYear >0 ){
             return date("Y年m月d日 H:i",$sTime);
        }else{
            return date("m月d日 H:i",$sTime);
        }
    //full: Y-m-d , H:i:s
    }elseif($type=='full'){
        return date("Y-m-d H:i:s",$sTime);
    }elseif($type=='ymd'){
        return date("Y-m-d",$sTime);
    }else{
        if( $dTime < 60 ){
            return $dTime."秒前";
        }elseif( $dTime < 3600 ){
            return intval($dTime/60)."分钟前";
        }elseif( $dTime >= 3600 && $dDay == 0  ){
            return intval($dTime/3600)."小时前";
        }elseif($dYear==0){
            return date("Y-m-d H:i:s",$sTime);
        }else{
            return date("Y-m-d H:i:s",$sTime);
        }
    }
}


    //utf8mb4表情转换，用于存储  
    function textEncode($str){
        if(!is_string($str))return $str;
        if(!$str || $str=='undefined')return '';

    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback("/(\\\u[ed][0-9a-f]{3})/i",function($str){
        return addslashes($str[0]);
    },$text); //将emoji的unicode留下，其他不动，这里的正则比原答案增加了d，因为我发现我很多emoji实际上是\ud开头的，反而暂时没发现有\ue开头。
    return json_decode($text);
   /* $txtContent=json_encode($text);  
   
    $txtContent=preg_replace_callback ('#(\\\u263a|\\\u2728|\\\u2b50|\\\u2753|\\\u270a|\\\u261d|\\\u2757|\\\ud[0-9a-f]{3}\\\ud[0-9a-f]{3})#',function($matches){ return  addslashes($matches[1]);}, $txtContent);  
    $txtContent=json_decode($txtContent);  
  
    return $txtContent;  */
}

//表情反转，用于显示  
function textDecode($str){  
    $text = json_encode($str); //暴露出unicode
    $text = preg_replace_callback('/\\\\\\\\/i',function($str){
        return '\\';
    },$text); //将两条斜杠变成一条，其他不动
    return json_decode($text);
} 

    /**
 * 计算两点地理坐标之间的距离
 * @param Decimal $longitude1 起点经度
 * @param Decimal $latitude1 起点纬度
 * @param Decimal $longitude2 终点经度 
 * @param Decimal $latitude2 终点纬度
 * @param Int   $unit    单位 1:米 2:公里
 * @param Int   $decimal  精度 保留小数位数
 * @return Decimal
 */
    function getDistance($longitude1, $latitude1, $longitude2, $latitude2, $unit=2, $decimal=2){
       
  $EARTH_RADIUS = 6370.996; // 地球半径系数
  $PI = 3.1415926;
  
  $radLat1 = $latitude1 * $PI / 180.0;
  $radLat2 = $latitude2 * $PI / 180.0;
  
  $radLng1 = $longitude1 * $PI / 180.0;
  $radLng2 = $longitude2 * $PI /180.0;
  
  $a = $radLat1 - $radLat2;
  $b = $radLng1 - $radLng2;
  
  $distance = 2 * asin(sqrt(pow(sin($a/2),2) + cos($radLat1) * cos($radLat2) * pow(sin($b/2),2)));
  $distance = $distance * $EARTH_RADIUS * 1000;
  
  if($unit==2){
    $distance = $distance / 1000;
}

return round($distance, $decimal);

}




/**
     *$myApp=new Wys_tongchengModuleWxapp();
     * 模拟post进行url请求
     * @param string $url
     * @param string $param
     */
function request_post($url = '', $param = '') {
    if (empty($url) || empty($param)) {
        return false;
    }
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
         curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
         if($param != ''){  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);  
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HEADER, false);//设置header

        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }


    function request_posts($url = '', $param = '') {
        if (empty($url) || empty($param)) {
            return false;
        }
        $ch = curl_init();//初始化curl
        curl_setopt($ch, CURLOPT_URL,$url);//抓取指定网页
         curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
         if($param != ''){  
            curl_setopt($ch, CURLOPT_POSTFIELDS, $param);  
        }
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);//要求结果为字符串且输出到屏幕上
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
        curl_setopt($ch, CURLOPT_HEADER, true);//设置header
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false); // https请求 不验证证书和hosts
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        $data = curl_exec($ch);//运行curl
        curl_close($ch);
        return $data;
    }



      //https 访问 返回获取公众号AccessToken
    function getUserinfo_openid ($appid, $appsecret,$code) {                    
        $cachekey = "accesstoken_user:".$appid;
        $cache = cache_load($cachekey);
        if (!empty($cache) && !empty($cache['user_token']) && $cache['expire_user'] > TIMESTAMP) {
            //$this->account['access_token_user'] = $cache;
            $user_token=$cache['user_token'];
            $user_token['is_cache']=true;
            return  $user_token;
        }

        $url='https://api.weixin.qq.com/sns/jscode2session?appid='.$appid.'&secret='.$appsecret.'&js_code='.$code.'&grant_type=authorization_code'; 
        $html =$this->file_get_content($url);//file_get_contents
        $response =@json_decode($html,true);
        //load()->func('communication');
        //$output = $this->requestApi($url);
        $record = array();
        $record['user_token'] = $response;
        $record['expire_user'] = TIMESTAMP + $response['expires_in'] - 200;        
        //$this->account['access_token_user'] = $record;
        cache_write($cachekey, $record);
        return $response;
    }


    //获取小程序accseeToken
    function getAccessToken ($appid, $appsecret) {                    
        $cachekey = "access_token_xcx:".$appid;
        $cache = cache_load($cachekey);
        if (!empty($cache) && !empty($cache['access_token']) && $cache['expire_token_xcx'] > TIMESTAMP) {
            //$this->account['access_token_user'] = $cache;
            $user_token=$cache['access_token'];
          
            return  $user_token;
        }      
        $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
        $html =$this->file_get_content($url);//file_get_contents
        $response =@json_decode($html,true);
        //load()->func('communication');
        //$output = $this->requestApi($url);
        $record = array();
        $record['access_token'] = $response['access_token'];
        $record['expire_token_xcx'] = TIMESTAMP + $response['expires_in'] - 200;        
        //$this->account['access_token_user'] = $record;
        cache_write($cachekey, $record);
        return $response['access_token'];
    }





    function file_get_content($url) {
        if (function_exists('file_get_contents')) {
        $file_contents = @file_get_contents($url);
        }
        if ($file_contents =='') {
        $ch = curl_init();
        $timeout = 30;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $file_contents = curl_exec($ch);
        curl_close($ch);
        }
        return $file_contents;
        }

     //返回获取公众号AccessToken
    // function getAccessToken ($appid, $appsecret) {                    
    //     $url='https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$appid.'&secret='.$appsecret;
    //     $html = file_get_contents($url);
    //     $output = json_decode($html, true);
    //     $access_token = $output['access_token'];
    //     return $access_token;
    // }
    //发送模板消息

    /**
    *发布模板消息
    * @param string $openid
    * @param string $templateid
    * @param string $formid //打开页面id
    * @param string $data_arr //数据提示
    */
    function send_template_fun($openid,$templateid,$formid,$page,$data_arr,$emphasis_keyword=''){
        $account_api = WeAccount::create();
        $access_token = $account_api->getAccessToken();
        //$access_token=$this->getAccessToken ($appid, $appsecret);     
        $post_data = array (
            'touser'=> $openid,
            'template_id'=> $templateid,
            "page"=> $page,//点击模板消息后跳转到的页面，可以传递参数           
            'form_id'=> $formid,
            'data'=> $data_arr,
            'emphasis_keyword'=>$emphasis_keyword.'.DATA'//keyword2.DATA
             //需要强调的关键字，会加大居中显示
            );

        $url = 'https://api.weixin.qq.com/cgi-bin/message/wxopen/template/send?access_token='.$access_token;
        //这里替换为你的 appID 和 appSecret
        $data = json_encode($post_data, true);   
        //将数组编码为 JSON
        $return = $this->send_post( $url, $data);
        return $return;
    }
    //post 模拟
    function send_post($url,$post_data ) {
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

    function send_post2($url,$post_data ) {
        $options = array(
            'http' => array(
                'method'  => 'POST',
                'header'  => 'Content-type:application/x-www-form-urlencoded',//header 需要设置为 JSON
                //'content' => $post_data,
                'timeout' => 60//超时时间
                )
            );
        $context = stream_context_create( $options );
        $result = file_get_contents( $url, false, $context);
        return $result;
    }




}


?>