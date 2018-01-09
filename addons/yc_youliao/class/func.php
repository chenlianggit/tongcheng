<?php
    //把参数组合成where_sql【and】
    function composeParamsToWhere($params){
        foreach ($params as $key => $value) {
            $name    = trim($key,':');
            if($before)
                $strs[]  = $before.'.'.$name."=".$key;
            else 
                $strs[]  = $name."=".$key;
        }
        return implode(' and ',$strs);      
    }
    //接收新增，更新参数
    function getNewUpdateData($in_data,$class_in){
        $in = array();
        foreach ($in_data as $key => $value) {
            if($class_in->$key){
                $in[$key] = $value;
           }
       }
       return $in;       
    }
    //获取手机上当前用户的uid 
    function getMemberUid(){
        global $_W;
        $member_uid = $_W['member']['uid']? $_W['member']['uid']:$_SESSION['member_uid'];
        return $member_uid;
    }
    //从数组从获取键值组成新的数组
    function getSomeFromArr($arr,$in_key){
        foreach ($arr as $key => $value) {
            $out_arr[$key] = $value[$in_key];
        }
        return $out_arr;
    }
    //设置当前shop_id
    function setShop_id($shop_id){
        setcookie('shop_id',  $shop_id, time()+3600 * 24 * 7,'/');
        //$_SESSION['shop_id'] = $shop_id;
    }
    function getShop_id(){
        //先从浏览器获得，如果为空再从cookie获得
        $shop_id=intval($_GET['shop_id']);
        if( $shop_id==0){
            return $_COOKIE["shop_id"];
        }else{
            return $shop_id;
        }

       // return $_SESSION['shop_id']?$_SESSION['shop_id']:0;

    }

//设置当前管理员标记
function setAdmin_type($flag){
    $_SESSION['admin_type'] = $flag;
}
function getAdmin_type(){
    return $_SESSION['admin_type']?$_SESSION['admin_type']:0;
}
//设置当前shop_name
function setShop_name($shop_name){
    setcookie('shop_name',  $shop_name, time()+3600 * 24 * 7,'/');
    //$_SESSION['shop_name'] = $shop_name;
}
function getShop_name(){
    //return $_SESSION['shop_name']?$_SESSION['shop_name']:0;
    $shop_id=intval($_GET['shop_id']);
    if( $shop_id>0){
       $shop_name= shop::getShop_name($shop_id);
        return $shop_name;
    }else{
        return $_COOKIE["shop_name"];
    }

}
//设置当前城市id
function setCity_id($city_id){
    $_SESSION['city_id'] = $city_id;
}
function getCity_id(){
    return $_SESSION['city_id']?$_SESSION['city_id']:0;
}
//设置当前shop_logo
function setShop_logo($shop_logo){
    setcookie('shop_logo',  $shop_logo, time()+3600 * 24 * 7,'/');
}
function getShop_logo(){
    $shop_id=intval($_GET['shop_id']);
    if( $shop_id>0){
        $shop= shop::getShopInfo($shop_id);
        return $shop['logo'];
    }else{
        return $_COOKIE["shop_logo"];
    }

}

function setIs_group($flag){
    $_SESSION['is_group'] = $flag;
}
function getIs_group(){
    return $_SESSION['is_group']?$_SESSION['is_group']:0;
}

function setIs_discount($flag){
    $_SESSION['is_discount'] = $flag;
}
function getIs_discount(){
    return $_SESSION['is_discount']?$_SESSION['is_discount']:0;
}
function setIs_time($flag){
    $_SESSION['is_time'] = $flag;
}
function getIs_time(){
    return $_SESSION['is_time']?$_SESSION['is_time']:0;
}

function setIs_hot($flag){
    $_SESSION['is_hot'] = $flag;
}
function getIs_hot(){
    return $_SESSION['is_hot']?$_SESSION['is_hot']:0;
}
function setWebLogin($uniacid,$uid){
    isetcookie('__uniacid', $uniacid, 7 * 86400,'/');
    isetcookie('__uid', $uid, 7 * 86400,'/');
    if(IMS_VERSION > 0.8){
        isetcookie('uniacid_source', "wxapp", 7 * 86400,'/');
        isetcookie('uniacid', $uniacid, 7 * 86400,'/');
    }else{
        isetcookie('uniacid', $uniacid, -7 * 86400,'/');
    }
}

function clear_cook(){
    setcookie('shop_id', '',time()-3600 * 24 * 7,'/');
    setcookie('shop_name', '',time()-3600 * 24 * 7,'/');
    setcookie('shop_logo', '',time()-3600 * 24 * 7,'/');


}



//PHP COOKIE设置函数立即生效。
function delete_cookie($var, $value='', $time=0, $path='', $domain=''){
    setcookie($var, $value, $time, $path, $domain); //假设COOKIE名称为$var，值为$value
    $_COOKIE[$var] = $value;
}