<?php
/**
 * 米花社区
 *
 */
//引入文件
defined('IN_IA') or exit('Access Denied');
require(IA_ROOT."/addons/yc_youliao/class/defineData.php");//define
require(IA_ROOT."/addons/yc_youliao/class/func.php");
require(IA_ROOT."/addons/yc_youliao/class/autoLoad.php");
require(IA_ROOT."/addons/yc_youliao/class/webCommon.php");
require(IA_ROOT."/addons/yc_youliao/class/commonGetData.php");
require(IA_ROOT."/addons/yc_youliao/class/util.php");
require(IA_ROOT."/addons/yc_youliao/class/reqInfo.php");
require(IA_ROOT."/addons/yc_youliao/class/core.php");
require(IA_ROOT."/addons/yc_youliao/class/near_merchant.php");
require(IA_ROOT."/addons/yc_youliao/class/function_common.class.php");
require(IA_ROOT."/addons/yc_youliao/model/Info.php");
require(IA_ROOT."/addons/yc_youliao/model/Admin.php");
require(IA_ROOT."/addons/yc_youliao/model/Adv.php");
require(IA_ROOT."/addons/yc_youliao/model/City.php");
require(IA_ROOT."/addons/yc_youliao/model/Shop_pro.php");
require(IA_ROOT."/addons/yc_youliao/model/Goods.php");
require(IA_ROOT."/addons/yc_youliao/model/Discount.php");
require(IA_ROOT."/addons/yc_youliao/model/Group.php");
require(IA_ROOT."/addons/yc_youliao/model/Member.php");
require(IA_ROOT."/addons/yc_youliao/model/Order.php");
require(IA_ROOT."/addons/yc_youliao/model/Message.php");
require(IA_ROOT."/addons/yc_youliao/model/Queue.php");
require(IA_ROOT."/addons/yc_youliao/model/Qr_code.php");
require(IA_ROOT."/addons/yc_youliao/model/PayResult.php");
require(IA_ROOT."/addons/yc_youliao/model/Msg.php");
require(IA_ROOT."/addons/yc_youliao/model/Redpackage.php");
include IA_ROOT. "/framework/library/qrcode/phpqrcode.php";

class yc_youliaoModuleSite extends WeModuleSite
{


//重新定向功能访问
    public function __call($function_name, $args)
    {
        if (strstr($function_name, 'doWeb')) {
            //微擎后台
            $fname = str_ireplace('doWeb', '', $function_name);
            $this->__web($fname);
        } elseif (strstr($function_name, 'doMobile')) {
            //前端
            $fname = str_ireplace('doMobile', '', $function_name);
            $this->__mobileNew($fname);
        }
    }

    //管理员后台
    public function __web($module)
    {
        global $_GPC, $_W;
        session_start();
        load()->func('file');
        load()->func('tpl');
        load()->model('mc');
        $module = lcfirst($module);
        if (!file_exists(SQ . 'module/web/' . $module . '.php') && !file_exists(SQ . 'module/web/shop/' . $module . '.php')) {
            include $this->template('error');
            exit;
        } else {
            //访问店铺时，shop_id不能为空

            //店铺管理员只能访问shop_ 的function，所有社区内置的账号均使用mihua_sq_wq_admin
            if ($_W['username'] == "mihua_sq_wq_admin" && strpos($module, 'shop_') === false) {
                $content = '您没有访问权限';
                include $this->template('error');
                exit;
            } else {
                if (strpos($module, 'shop_') !== false) {
//                    if(!in_array($_W['role'], array('manager', 'operator', 'founder', 'clerk'))) {
//                        message('您的账号没有访问此公众号的权限.');
//                    }
                    $shop_id = getShop_id();
                    $shop = Shop::getShopInfo($shop_id);
                    setShop_name($shop['shop_name']);
                    setShop_logo($shop['logo']);
                    setIs_discount($shop['is_discount']);
                    setIs_group($shop['is_group']);
                    setIs_time($shop['is_time']);
                    setIs_hot($shop['is_hot']);
                    require('module/web/shop/' . $module . '.php');
                } else {
                    require('module/web/' . $module . '.php');
                }

            }


        }


    }

    //前台
    public function __mobileNew($module)
    {
        global $_GPC, $_W;
        load()->func('file');
        load()->func('tpl');
        load()->model('mc');
        $module = lcfirst($module);
        session_start();
        if (!file_exists(SQ . 'module/mobile/' . $module . '.php')) {
            include $this->template('../error');
            exit;
        } else {
            require('module/mobile/' . $module . '.php');
        }


    }


    public function doMobilePay()
    {
        global $_W, $_GPC;
        $type = trim($_GPC['type']);
        if ($type != 'message' && $type != 'merchant' && $type != 'zhiding' && $type != 'good') {
            message('支付类型不正确！');
        }
        $ordersn = trim($_GPC['ordersn']);
        if ($type == 'merchant') {
            $order = pdo_fetch('SELECT * FROM ' . tablename(INORDER) . " WHERE weid = {$_W['uniacid']} AND ordersn = '{$ordersn}' AND status = 0");
            $ordertitle = '商家入驻支付';
        }
        if ($type == 'message') {
            $order = pdo_fetch('SELECT * FROM ' . tablename(INFOORDER) . " WHERE weid = {$_W['uniacid']} AND ordersn = '{$ordersn}' AND status = 0");
            $ordertitle = '发布信息支付';
        }
        if ($type == 'zhiding') {
            $order = pdo_fetch('SELECT * FROM ' . tablename(ZDORDER) . " WHERE weid = {$_W['uniacid']} AND ordersn = '{$ordersn}' AND status = 0");
            $ordertitle = '置顶信息支付';
        }
        if ($type == 'good') {
            $order = pdo_fetch('SELECT * FROM ' . tablename(ORDER) . " WHERE uniacid = {$_W['uniacid']} AND ordersn = '{$ordersn}' AND status = 0");
            $ordertitle = $_GPC['name'];
        }
        if (empty($order)) {
            message('该订单不能支付！');
        }
        $fee = $order['price'];
        if ($fee <= 0) {
            message('支付错误, 金额小于0！');
        }
        $params = array('tid' => $order['ordersn'], 'ordersn' => $order['ordersn'], 'title' => $ordertitle, 'fee' => $fee);
        PayResult::insertlog($order,$ordertitle);
        $this->pay($params);
    }
public function domobiletest(){
    global $_GPC,$_W;
    $PayResult=new PayResult();
    $params['tid']='renew11221226152984';
     $params['user']=' ojm8pxNBmxdH8LteUbuJAKsD6hDA';
    $params['price']='4';
    $PayResult->payresult_renew ($params);


}

    //支付回调
    public function payResult($params)
    {
        global $_W, $_GPC;
        $_W['siteroot'] =str_replace('addons/bm_payms', '', $_W['siteroot']);
        $id = $params['tid'];
        $ordersnlen = strlen($params['tid']);
        $PayResult=new PayResult();
        $log = Util::getSingelDataInSingleTable('core_paylog', array('module' => 'yc_youliao', 'tid' => $params['tid']));
        $paydetail = $log['tag'];
        $logtag = unserialize($log['tag']);
        $checkReq=$PayResult->checkReq($params);
        if($checkReq==0)return;
        $order = Util::getSingelDataInSingleTable(ORDER, array('ordersn' => $id));

            if ($params['result'] == 'success' && $params['from'] == 'notify') {//支付回调
                if(strstr($id, 'ye')){//余额充值
                    $PayResult->payresult_ye($params);
                }elseif (strstr($id, 'dis')) {//优惠买单
                    $PayResult->payresult_dis($params);
                }elseif(strstr($id,'redpackage')){//抢红包支付
                    $PayResult->payresult_redpackage($params);
                }else if(strstr($id,'shang')){//打赏
                    $PayResult->payresult_shang($params);
                }else if(strstr($id,'renew')){//商户缴费
                    $PayResult->payresult_renew($params);
                }elseif ($ordersnlen == 15) {//发布信息支付
                    $PayResult->payresult_info($params, $paydetail, $logtag);
                } elseif ($ordersnlen == 20) {//置顶信息支付
                    $PayResult->payresult_zd($params, $paydetail, $logtag);
                }  else {//订单支付
                    $PayResult->payresult_order($params, $order);
                }

            }//支付回调业务处理结束

            if ($params['from'] == 'return') {
                if ($params['result'] == 'success' || $params['type'] == "delivery") {
                    $price = $params['fee'];
                    if(strstr($id, 'ye')){//余额充值
                        $PayResult->payresult_ye($params);
                        $info = '余额充值成功！';
                        $info_url =  Util::createModuleUrl('balance', array('op' => 'record','status' => '1'));
                    }elseif (strstr($id, 'dis')) {//优惠买单
                        $dis_id = str_ireplace('dis', '', $id);
                        $order = Util::getSingelDataInSingleTable(DISCOUNT_RE, array('id' => $dis_id));
                        $this->payresult_dis($params);
                        $info = '优惠买单支付成功！';
                        $info_url =  Util::createModuleUrl('user', array('op' => 'mydiscount','id' => $dis_id));
                    } elseif(strstr($id,'renew')){//商户缴费
                        $PayResult->payresult_renew($params);
                        $info = '商户缴费成功！';
                        $id=str_replace('renew','',$params['tid']);
                        $result=pdo_fetch("select * from ".tablename(RENEW)." where ordersn={$id}  and 
		uniacid={$_W['uniacid']}    and status=0");
                        $info_url =  Util::createModuleUrl('shop_admin', array('shop_id' => $result['shop_id']));
                    }elseif ($ordersnlen == 15) {//发布信息支付
                        $info_id = $PayResult->payresult_info($params, $paydetail, $logtag);
                        $info = ' 发布信息支付成功！';
                        $info_url =  Util::createModuleUrl('mylocal');
                    } elseif ($ordersnlen == 20) {//置顶信息支付
                        $info_id =$PayResult->payresult_zd($params, $paydetail, $logtag);
                        $info = ' 置顶信息支付成功！';
                        $info_url =  Util::createModuleUrl('detail', array('id' => $info_id));
                    } else if(strstr($id, 'redpackage')){
                        $info = ' 发布抢红包支付成功！';
                        $PayResult->payresult_redpackage($params);
                        $red_id = str_ireplace('redpackage', '', $params['tid']);
                        $info_url =  Util::createModuleUrl('redpackage', array('op'=>'showredpackage','id' =>$red_id));
                    }else if(strstr($id, 'shang')){
                        $info = '打赏支付成功！';
                        $PayResult->payresult_shang($params);
                        //根据type==0圈子，1就是信息
                        $order_sn = str_ireplace('shang', '', $params['tid']);
                        $cash_data = Util::getSingelDataInSingleTable(CASH, array('cash_ordersn' => $order_sn));
                        if($cash_data['cash_type']==2){//圈子
                            $do='ring';
                            $op='detail';
                        }elseif($cash_data['cash_type']==3){//信息
                            $do='detail';
                            $op='display';
                        }
                        $info_url =  Util::createModuleUrl($do, array('op' => $op, 'id' => $cash_data ['type_id']));
                    }else {//订单支付成功通知
                        $this->payresult_order($params, $order);
                            $info = '订单支付成功！';
                            $info_url = Util::createModuleUrl('order', array('op' => 'detail', 'id' => $order['id']));
                    }

                } else {
                    if ($ordersnlen == 15) {//发布信息支付
                        $info = '发布信息支付失败！';
                        $info2 = '重新发布';
                        $info_url = $this->createMobileUrl('mylocal');
                    } elseif ($ordersnlen == 20) {//发布信息支付
                        $info = '置顶信息支付失败！';
                        $info2 = '重新置顶';
                        $info_url = $this->createMobileUrl('mylocal', array('status' => '1'));
                    } elseif (strstr($id, 'dis')) {
                        $info = '优惠买单失败！';
                        $info2 = '重新买单';
                        $info_url = $this->createMobileUrl('shop', array('shop_id' => $order['shop_id'], 'op' => 'discount'));
                    } else if(strstr($id, 'redpackage')){
                        $info = '发布抢红包支付失败！';
                       // $info2 = '';
                        $info_url = $this->createMobileUrl('redpackage');
                    }else {//订单支付失败通知
                        $info = '订单支付失败！';
                        $info_url = $this->createMobileUrl('order', array('status' => 0));
                    }
                }
            }


        $title = '账单详情';
        include $this->template('../mobile/payinfo');
        exit;
    }



    function message($msg, $redirect = '', $type = '',$isapp = '')
    {
        global $_W, $_GPC;
        if ($redirect == 'refresh') {
            $redirect = $_W['script_name'] . '?' . $_SERVER['QUERY_STRING'];
        }
        if ($redirect == 'referer') {
            $redirect = referer();
        }
        if ($redirect == '') {
            $type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'info';
        } else {
            $type = in_array($type, array('success', 'error', 'info', 'warning', 'ajax', 'sql')) ? $type : 'success';
        }
        if ($_W['isajax'] || !empty($_GET['isajax']) || $type == 'ajax') {
            if ($type != 'ajax' && !empty($_GPC['target'])) {
                exit("
<script type=\"text/javascript\">
parent.require(['jquery', 'util'], function($, util){
	var url = " . (!empty($redirect) ? 'parent.location.href' : "''") . ";
	var modalobj = util.message('" . $msg . "', '', '" . $type . "');
	if (url) {
		modalobj.on('hide.bs.modal', function(){\$('.modal').each(function(){if(\$(this).attr('id') != 'modal-message') {\$(this).modal('hide');}});top.location.reload()});
	}
});
</script>");
            } else {
                $vars = array();
                $vars['message'] = $msg;
                $vars['redirect'] = $redirect;
                $vars['type'] = $type;
                exit(json_encode($vars));
            }
        }
        if (empty($msg) && !empty($redirect)) {
            header('location: ' . $redirect);
        }
        $label = $type;
        if ($type == 'error') {
            $label = 'danger';
        }
        if ($type == 'ajax' || $type == 'sql') {
            $label = 'warning';
        }
        if($isapp=='1'){
            $template = '../mobile/common/message';
        }else {
            $template = 'web/message';
        }
        include $this->template($template);
        exit();
    }

    public function isMobile($mobile)
    {
        if (!is_numeric($mobile)) {
            return false;
        }
        return preg_match('#^13[\\d]{9}$|^14[5,7]{1}\\d{8}$|^15[^4]{1}\\d{8}$|^17[\\d]{9}$|^18[\\d]{9}$#', $mobile) ? true : false;
    }

    public function isCreditNo($vStr)
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

    public function getcookieCity()
    {
        $codition = "";
        $city_id = intval($_COOKIE['city_id']);
        if ($city_id) {
            $codition = " and s.city_id =" . $city_id;
        }

        return $codition;
    }
    public function getShopEndtime($type=1)
    {
        if($type==1){
       $codition = " and s.endtime >=" . TIMESTAMP;
    }else{
            $codition = " and (s.endtime <" . TIMESTAMP. " or s.endtime is null) ";
        }
        return $codition;
    }

    public function joinCity()
    {
        $codition = " left join " . tablename(SHOP) . " s on s.shop_id=g.shop_id left join " . tablename(AREA) . " a on a.area_id=s.area_id and s.status=1";
        return $codition;
    }

    public function joinArea()
    {
        $codition = " left join " . tablename(AREA) . " a on a.area_id=s.area_id ";
        return $codition;
    }

    public function getArea()
    {
        global $_W;
        $city_name=$this->getCity_name();
        $codition =$this->getCityId($city_name);
        $list = pdo_fetchall(" SELECT * FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}' {$codition} and (parent_id =0 or parent_id is null) ORDER BY  orderby asc");
        return $list;

    }
    public function getCityId($city_name){
        global $_W;
        $codition='';
        if ($city_name) {
            $city=pdo_fetchcolumn(" SELECT city_id FROM " . tablename(CITY) . " WHERE  uniacid = '{$_W['uniacid']}'  and name like '{$city_name}' order by city_id desc");
            if(intval($city)>0){
                $codition = " and city_id =" . $city;

            }

        }
        return $codition;
    }
    public function getBusiness()
    {
        global $_W;
        $city_name=$this->getCity_name();
        $codition =$this->getCityId($city_name);
        $list = pdo_fetchall(" SELECT * FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}' {$codition} and parent_id >0  ORDER BY  orderby asc");
        return $list;

    }

    public function getOpenid()
    {
        global $_W;
        return $_W['openid'];
    }

    public function getCredit1()
    {
        global $_W;
        $fans = mc_fetch($_W['openid']);
        return intval($fans['credit1']);
    }

    public function getUid()
    {
        load()->model('mc');
        return mc_openid2uid(getOpenid);
    }

    public function getLng()
    {
        $lng = $_COOKIE['lng'];
        return $lng;
    }

    public function getLat()
    {
        $lat = $_COOKIE['lat'];
        return $lat;
    }
    public function getReqLng()
    {
        $lng = $_COOKIE['reqlng'];
        return $lng;
    }

    public function getReqLat()
    {
        $lat = $_COOKIE['reqlat'];
        return $lat;
    }
    public function getAddress()
    {
        $data = $_COOKIE['address'];
        return $data;
    }

    public function getFormatted_address()
    {
        $data = $_COOKIE['formatted_address'];
        return $data;
    }

    public function getLactionflag()
    {
        $data = $_COOKIE['lactionflag'];
        return $data;
    }

    function getLaction_flag()
    {
        return $_SESSION['lactionflag'] ? $_SESSION['lactionflag'] : 0;
    }


    public function getKeyword()
    {
        global $_GPC;
        $keyword='';
        if (!empty($_GPC['keyword'])) {
            $keyword= trim($_GPC['keyword']);
        }
        return $keyword;
    }
    public function getStarttime()
    {
        global $_GPC;
        $starttime='';
        if (!empty($_GPC['starttime'])) {
            $starttime=strtotime($_GPC['starttime']);
        }
        return $starttime;
    }

    public function getEndtime()
    {
        global $_GPC;
        $endtime='';
        if (!empty($_GPC['endtime'])) {
            $endtime=strtotime($_GPC['starttime']);
        }
        return $endtime;
    }


    public function getWebPage()
    {
        $page =reqInfo::pageIndex();
        return $page;
    }
    public function pageIndex()
    {
        $page =reqInfo::pageIndex();
        return $page;
    }
    public function getWebNum()
    {
        $num =reqInfo::num();
        return $num;
    }
    public function getPage()
    {

        $page =reqInfo::page();
        return $page;
    }
    public function getNum()
    {
        $num =reqInfo::num();
        return $num;
    }
public function messageresult($str,$url,$result=0,$status='error'){
        global $_GPC;
    if ($_GPC['isajax']=="1") {
        die(json_encode(array("result" => $result, "str" =>$str)));
        exit;
    } else {
        message($str, $url, $status);
        exit;
    }
}
    public function getCity_id()
    {
        $city_id = intval($_COOKIE['city_id']);
        return $city_id;
    }

    public function getAdmin_city_id()
    {
        $city_id = intval($_COOKIE['admin_city_id']);
        return $city_id;
    }

    public function getAdmin_city_name()
    {
        $city_id = intval($_COOKIE['admin_city_id']);
        if ($city_id > 0) {
            $where['city_id'] = $city_id;
            $city = util::getSingelDataInSingleTable(CITY, $where);
            $city_name = $city['name'];
            $str2 = '市';
            if (strrchr($city_name, $str2) == $str2) {
                return $city_name;
            } else {
                return $city_name . $str2;
            }
        }
    }

    public function getArea_name()
    {
        $area_name = $_COOKIE['area_name'];
        return $area_name;
    }

    public function getProvince()
    {
        $data = $_COOKIE['province'];
        return $data;
    }

    public function getCity_name()
    {
        $city_name = $_COOKIE['city_name'];
        if (strpos($city_name, '市') !== false) {
            $city_name = str_replace("市", "", $city_name);
        }

        return $city_name;
    }

    public function getDistrict()
    {
        $district = $_COOKIE['district'];
        return $district;
    }




    public function showMsgNum()
    {
        $cfg = $this->module['config'];
        $data=ReqInfo::msgNum( $cfg);
        return $data;

    }
//    检查是否是黑名单
    public function checkBlack(){
        global $_W;
        $openid=$this->getOpenid();
        $userinfo=Member::getMemberByopenid($openid);
        $black=Member::getBlack($userinfo['id']);
        if(!empty($black)){
            if($_W['isajax']) {
                $resArr['error'] = 1;
                $resArr['message'] = '很抱歉，您已被移入黑名单！';
                echo json_encode($resArr);
                die;
            }else{
                message('很抱歉，您已被移入黑名单');
            }

        }
    }
    //根据坐标获取城市名
    public function info_condition()
    {
        $info_condition = "";
        $city = $this->getCity_name();
        $cfg = $this->module['config'];
        if ($city && $cfg['issamecity']==0)  {
            $info_condition .= " and city like '" . $city . "%' ";
        }

        return $info_condition;
    }

    public function mapreq()
    {//获取地理位置信息
        $cfg = $this->module['config'];
        $data=ReqInfo::mapReq( $cfg);
        return $data;

    }

    public function mapUrl()
    {//获取地图
        $cfg = $this->module['config'];
        $data=ReqInfo::mapUrl( $cfg);
        return $data;

    }

    public function chagexy()
    {//获取计算后的坐标
        $cfg = $this->module['config'];
        $data=ReqInfo::chagexy($cfg);
        return $data;
    }

    public function weatherreq()
    {
        $cfg = $this->module['config'];
        $data=ReqInfo::weatherreq($cfg);
        return $data;

    }

//    判断是否是管理员
    public function checkAdmin($openid='')
    {
        if($openid){
            $where['openid'] = $openid;
        }else{
            $where['openid'] = $this->getOpenid();
        }

        $where['status'] = 0;
        $a_data = util::getSingelDataInSingleTable(ADMIN, $where, 'admin_id');
        return $a_data;
    }

//判断是否是店铺管理员
    public function isshop_admin()
    {
        $admin_where['openid'] = $this->getOpenid();
        $admin_where['status'] = 0;
        $isshop_admin = util::getSingelDataInSingleTable(SHOP_ADMIN, $admin_where);
        return $isshop_admin;
    }
    public function getCustomerById($shop_id)
    {
        $admin_where['shop_id'] =intval($shop_id);
        $admin_where['customer'] = 1;
        $isshop_admin = util::getAllDataBySingleTable(SHOP_ADMIN, $admin_where,'admin_id desc');
        return $isshop_admin;
    }
    //发送客服消息
    public function rep_text($openid, $word)
    {
        global $_W;
        $acid = pdo_fetchcolumn("select acid from " . tablename('account') . " where uniacid={$_W['uniacid']} ");
        load()->classs('weixin.account');
        $accObj = WeixinAccount::create($acid);
        $accObj->sendCustomNotice(array('touser' => $openid, 'msgtype' => 'text', 'text' => array('content' => urlencode($word))));
    }

    //获取同城的模块名
    function getmodulename($weid,$mid){
        $moduleres = pdo_fetch("SELECT name FROM ".tablename(CHANNEL)." WHERE weid = {$weid} AND id = {$mid}");
        return $moduleres['name'];
    }

    function getShopQr(){
        global $_W,$_GPC;
        $shop_id=getShop_id();
        if($shop_id==0){
            $shop_id=$_GPC['shop_id'];
        }
        //判断二维码文件是否存在，不存在则创建
       $qr_code=util::getSingelDataInSingleTable(SHOP,array('shop_id'=>$shop_id),'qr_code');
       if($qr_code['qr_code']){
           $qr_code=$qr_code['qr_code'];
       }else{
           $url = $_W['siteroot'] . "app/index.php?i={$_W['uniacid']}&c=entry&do=shop&shop_id={$shop_id}&m=yc_youliao&flag=scan";
           $qr_code=util::getURLQR($url,'shop_'.$shop_id);
           pdo_update(SHOP,array('qr_code'=>$qr_code), array('shop_id'=>$shop_id));
       }
        return $qr_code;



    }
    function isShang(){
        $cfg = $this->module['config'];
        return intval($cfg['isshang']);
    }
    function isRedpacket(){
        $cfg = $this->module['config'];
        return intval($cfg['isredpacket']);
    }

    //生成关注二维码
    function getCreateShopQr($shop_id){
        $barcode=array(
            'action_name'=>'QR_SCENE',
            'action_info'=>array(
                'scene'=>array(
                    'scene_id'=>$shop_id
                )
            ),
        );
        load()->classs('account');
        $this->account = WeAccount::create($GLOBALS['_W']['acid']);
        $weixin_qr=$this->account->barCodeCreateFixed($barcode);
        $qrfile="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$weixin_qr['ticket'];
        return $qrfile;
    }

    protected function red_plan($total, $num, $min)

    {
/*
        $total = $total * 100;
        $min = $min * 100;
        $average = $total / $num;//平均金额
        $max = $average * 5;//用户最大可获得平均金额的倍率
        $base_total = $num * $min;//保底分配金额
        $over_total = $total - $base_total;//随机金额


        if ($total * 0.01 == $num) {//红包金额等于红包数量时，直接发放等额红包
            for ($i = 0; $i < $num; $i++)
                $packs[$i] = $average;
        } else {

            for ($i = 1; $i < $num; $i++)//第一轮循环，分配小额
            {
                $temp = intval(rand(0, $average - $min));//每人递增  随机 0---平均值-最小额
                $over_total -= $temp;
                $packs[$i] = $temp + $min;
            }

            while ($over_total > 0) {//第二轮，分配剩余金额，出现大额红包
                for ($i = 1; $i < $num; $i++) {
                    $temp = intval(rand(0, $max - $average - $min));
                    if ($temp > $over_total) $temp = $over_total;
                    $packs[$i] += $temp;
                    $over_total -= $temp;
                    if ($over_total == 0) break;
                }
            }
        }
        shuffle($packs);
        $packs[$num] = $packs[0];

        return $packs;*/
        $remain=$total * 100;
        $min=1;//每个人最少能收到0.01元
        if ($remain == $num) {//红包金额等于红包数量时，直接发放等额红包
            for ($i = 0; $i < $num; $i++)
                $packs[$i] = $remain / $num;//平均金额;
        }else{
            for ($i=0; $i<$num; $i++) {
                $safe_total=($remain-($num-$i)*$min)/($num-$i);
                if($i ==($num-1)){
                    $packs[$i] = $remain;
                }else{
                    $money=mt_rand($min,$safe_total);
                    $remain=$remain-$money;
                    $packs[$i] = $money;
                }
            }
        }
        return $packs;
    }

    //平均分配金额
    protected function red_average_plan($total, $num)
    {
        $total = $total * 100;
        $average = $total / $num;//平均金额

        for ($i = 0; $i < $num; $i++)
            $packs[$i] = intval($average);

        return ($packs);
    }

    public function  getRefundtime(){
        $cfg = $this->module['config'];
        if ($cfg['refundtime']){
            $refundtime=$cfg['refundtime'];
        }else{
            $refundtime=7;
        }
        return $refundtime;
    }

    public function gorefund($iscanrefund,$createtime,$orderstatus){
        //商品是否支持退款，订单是否已支付
        $fundtime=$this->getRefundtime();
        if($iscanrefund!=0 || $orderstatus<1){
            return 0;
        }

        //订单是否已支付
        //时间是否超过退货退款期退
        //订单成交日期-今天的时间是否小于等于退货时间
        $a=TIMESTAMP-$createtime ;
        $b= $fundtime*24*60*60;
//    echo$createtime.'<br/>';
//    echo TIMESTAMP.'<br/>';
//    echo $b;
        if(abs($a)<=$b){
            return 1;
        }else{
            return 0;
        }

    }
}