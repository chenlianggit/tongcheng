<?php 
defined("IN_IA") or die("Access Denied");
require IA_ROOT . "/addons/yc_youliao/class/defineData.php";
require IA_ROOT . "/addons/yc_youliao/class/commonGetData.php";
require IA_ROOT . "/addons/yc_youliao/class/util.php";
require IA_ROOT . "/addons/yc_youliao/class/reqInfo.php";
require IA_ROOT . "/addons/yc_youliao/class/function_common.class.php";
require IA_ROOT . "/addons/yc_youliao/model/Member.php";
require IA_ROOT . "/addons/yc_youliao/model/Shop_pro.php";
require IA_ROOT . "/addons/yc_youliao/model/Goods.php";
require IA_ROOT . "/addons/yc_youliao/model/Info.php";
require IA_ROOT . "/addons/yc_youliao/model/PayResult.php";
class Yc_youliaoModuleWxapp extends WeModuleWxapp
{
	public function __construct()
	{
		$this->cfg();
	}
	private function cfg()
	{
		global $_W;
		$_W["uniacid"] = $this->getUniacid();
		$cfg = pdo_fetchcolumn("SELECT settings FROM " . tablename("uni_account_modules") . " WHERE module = :module AND uniacid = :uniacid", array(":module" => MODULE, ":uniacid" => $_W["uniacid"]));
		$this->module = unserialize($cfg);
	}

	public function doPageTest()
	{
		global $_GPC, $_W;
		$errno = 0;
		$message = "sucess";
		$data = commonGetData::getAdv(1);
		return $this->result($errno, $message, $data);
	}
	//整理照片
    public function doPageTest1()
    {
        global $_GPC, $_W;
        $re = pdo_fetchall("select shop_id,logo,qr_code from  ".tablename(SHOP)." where 1=1  limit 3");

        foreach($re as $k=> &$v){
            $v['qr_code'] = json_decode($v['qr_code'],true);
            $v['logo']=str_replace("http","https",$v['logo']);
            foreach($v['qr_code'] as $k1 => &$v2){
                $v2 = str_replace("http","https",$v2);
            }
            print_r($v);exit;
            $v['qr_code'] = json_encode($v['qr_code']);
            $res =  pdo_update(SHOP, array('qr_code' => $v['qr_code'],'logo'=>$logo ,'uniacid'=> 2), array('shop_id' =>$v['shop_id']));

        }
         print_r($re) ;
//        foreach($re as $k => &$v){
//                $v['qr_code'] = explode(',',$v['qr_code']);
//                if($v['qr_code'][0]){
//                    $logo = $v['qr_code'][0];
//                }else{
//                    $logo = '';
//                }
//                $v['qr_code'] = json_encode($v['qr_code']);
//           $res =  pdo_update(SHOP, array('qr_code' => $v['qr_code'],'logo'=>$logo ,'uniacid'=> 2), array('shop_id' =>$v['shop_id']));
//           echo  $v['shop_id'].'修改'.$res.'<br>';
//        }
        exit;
    }
	private function getOpenid()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$code = $_GPC["code"];
		$account_api = WeAccount::create();
		$userinfo = $account_api->getOauthInfo($code);
		$member = pdo_get(MEMBER, array("uniacid" => $_W["uniacid"], "openid " => $userinfo["openid"]));
		$nowtime = $member["logintime"] - time();
		if (empty($member)) {
			$data = array("uniacid" => $_W["uniacid"], "openid" => $userinfo["openid"], "nickname" => $_GPC["nickName"], "avatar" => $_GPC["avatarUrl"], "gender" => $_GPC["gender"], "wxapp" => 1, "logintime" => time());
			pdo_insert(MEMBER, $data);
		} else {
			if (empty($member["unionId"]) && !empty($userinfo["unionId"])) {
				pdo_update(MEMBER, array("unionId" => $userinfo["unionId"]), array("uniacid" => $_W["uniacid"], "openid " => $userinfo["openId"]));
			} else {
				if ($nowtime) {
					pdo_update(MEMBER, array("nickname" => $_GPC["nickName"], "logintime" => time(), "avatar" => $_GPC["avatarUrl"]), array("uniacid" => $_W["uniacid"], "openid " => $userinfo["openid"]));
				}
			}
		}
		return $userinfo;
	}
	public function getUniacid()
	{
		global $_W, $_GPC;
		global $_GPC, $_W;
		$uniacid = $_GPC["i"];
		$version = $_GPC["v"];
		$data = pdo_fetchcolumn(" SELECT modules FROM " . tablename("wxapp_versions") . " WHERE  uniacid = '{$uniacid}'  and version = '{$version}'   limit 1");
		$modules = unserialize($data);
		$_W["uniacid"] = $uniacid = $modules["yc_youliao"]["uniacid"];
		if (empty($_W["uniacid"])) {
			$uniacid = pdo_fetchcolumn("SELECT weid FROM " . tablename(CHANNEL) . " order by id asc limit 1");
		}
		return $uniacid;
	}
	public function successResult($data)
	{
		$errno = 0;
		$message = "sucess";
		return $this->result($errno, $message, $data);
	}
	public function errorResult($message)
	{
		$errno = 1;
		return $this->result($errno, $message);
	}
	public function doPageAttachurl()
	{
		global $_W;
		return $_W["attachurl"];
	}
	//获取用户标识
	public function dopageGetSeid()
	{
		$userinfo = $this->getOpenid();
		if (empty($userinfo)) {
			return $this->errorResult("2");
			die;
		}
		$myfun = new myfun();
		$sessionId = time() . $myfun->randombylength(8);
		cache_write($sessionId, $userinfo["openid"]);
		return $this->successResult($sessionId);
	}
	public function dopageGetUser()
	{
		$userinfo = $this->getOpenid();
		return $this->successResult($userinfo);
	}
	public function getUserBySeid()
	{
		global $_GPC;
		$seid = $_GPC["seid"];
		$userinfo = cache_load($seid);
		if (empty($userinfo)) {
			return $this->errorResult("用户信息获取失败");
			die;
		}
		return $userinfo;
	}
    public function doPageGetIndex(){
        global $_W, $_GPC;
        $dis = pdo_fetchall("SELECT s.* FROM " . tablename(SHOP) . " s WHERE  s.is_hot = 1 and s.status =1    ORDER BY s.shop_id DESC limit 1,6  ");
        $advs = commonGetData::getAdv(1);
        $cate = Shop::getCate();
        $data['advs']       = $advs;
        $data['hotshop']    = $dis;
        $data['cate']       = $cate;
        return $this->successResult($data);
    }
	public function doPageIndex()
	{

		global $_GPC, $_W;
		$_W["uniacid"] = $this->getUniacid();
		$info_condition = '';
		$lat = '';
		$lng = '';
		$formatted_address = '';
//		$weatherdata = '';
		$city = '';
		$cfg = $this->module["config"];
		if (!empty($_GPC["lat"]) && !empty($_GPC["lng"])) {
			$lat = $_GPC["lat"];
			$lng = $_GPC["lng"];
			$cfg = $this->module["config"];
			$mapreq = ReqInfo::mapReq($cfg);
			$chagexy = ReqInfo::chagexy($cfg);
			$addresData = util::getDistrictByLatLng($lat, $lng, $mapreq, $chagexy);
			$formatted_address = $addresData["formatted_address"];
			$city = $addresData["city"];
//			if ($city) {
//				$sql_city = rtrim($city, "市");
//				if ($cfg["issamecity"] == 0) {
//					$info_condition .= " and city like '" . $sql_city . "%' ";
//				}
//				$weatherurl = ReqInfo::weatherreq();
//				$weatherdata = util::getWeather($weatherurl, $city);
//				$weather2 = json_decode($weatherdata, 1);
//				if ($weather2["status"] == "1002") {
//					$weatherdata = util::getWeather($weatherurl, $addresData["district"]);
//				}
//			}
		}
        $dis = pdo_fetchall("SELECT s.* FROM " . tablename(SHOP) . " s WHERE  s.is_hot = 1 and s.status =1    ORDER BY s.shop_id DESC limit 1,6  ");
        $cate = Shop::getCate();
		$advs = commonGetData::getAdv(1);
		$module = commonGetData::getChannel(1, 2);
		$msgNum = ReqInfo::msgNum($cfg);
		$newMsg = commonGetData::getNewMsg($info_condition, $msgNum, $lat, $lng);
		$topMsg = commonGetData::getTopMsg($info_condition, $msgNum, $lat, $lng);
		$hotMsg = commonGetData::getHotMsg($info_condition, $msgNum, $lat, $lng);
        $nearMsg = commonGetData::getNearMsg($info_condition, $msgNum, $lat, $lng);
        $commentMsg = commonGetData::getCommentMsg($info_condition, $msgNum, $lat, $lng);
//		$data = array("city" => $city, "formatted_address" => $formatted_address, "weatherdata" => $weatherdata, "advs" => $advs, "module" => $module, "newMsg" => $newMsg, "topMsg" => $topMsg, "hotMsg" => $hotMsg);
        $data = array("city" => $city, "formatted_address" => $formatted_address, "advs" => $advs,'hotshop'=>$dis, "module" => $module, "newMsg" => $newMsg, "topMsg" => $topMsg, "hotMsg" => $hotMsg,'nearMsg'=>$nearMsg,'cate'=>$cate,'commentMsg'=>$commentMsg);
        $uid = $_GPC["uid"];
		if ($uid) {
			$result = MEMBER::isqiandao($uid);
			$data["isSignIn"] = $result;
			if ($data["isSignIn"] == 1) {
				$qiandao_random = $cfg["qiandao_random"];
				if ($qiandao_random == 1) {
					$data["credit"] = -1;
				} else {
					if (!empty($cfg["qiandao_jifen"])) {
						$data["credit"] = $cfg["qiandao_jifen"];
					}
				}
			}
		}
        $data['count'] = $this->doPageGetNumber();
		return $this->successResult($data);
	}
	public function dopageCredit2money()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$cfg = $this->module["config"];
		$credit2money = $cfg["credit2money"];
		if (empty($credit2money)) {
			$credit2money = 0.1;
		}
		return $this->successResult($credit2money);
	}
	public function dopageGetLaction()
	{
		global $_GPC, $_W;
		if (!empty($_GPC["lat"]) && !empty($_GPC["lng"])) {
			$lat = $_GPC["lat"];
			$lng = $_GPC["lng"];
			$cfg = $this->module["config"];
			$mapreq = ReqInfo::mapReq($cfg);
			$chagexy = ReqInfo::chagexy($cfg);
			$addresData = util::getDistrictByLatLng($lat, $lng, $mapreq, $chagexy);
			return $this->successResult($addresData);
		}
	}
	public function doPageGetModuleById()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$id = intval($_GPC["id"]);
		if (!$id) {
			$errno = 1;
			$message = "id is null";
			return $this->result($errno, $message);
		}
        $lat = $_GPC["lat"];
        $lng = $_GPC["lng"];
		$page = reqInfo::pageIndex();
		$num = reqInfo::num();
		$id = intval($id);
        $type = $_GPC["type"];
        switch ($type)
        {
            case 'hot':
                $data = commonGetData::getHotMsgById($id,$page, $num, $lat, $lng);
                break;
            case 'comment':
                $data = commonGetData::getCommentMsgById($id, $page, $num, $lat, $lng);
                break;
            case 'near':
                $data = commonGetData::getNearMsgById($id, $page, $num, $lat, $lng);
                break;
            default:
                $data = commonGetData::getNewMsgById($id, $page, $num, $lat, $lng);
        }
		return $this->successResult($data);
	}
	public function doPageGetInfoById()
	{
		global $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$id = intval($_GPC["id"]);
		$mid = intval($_GPC["mid"]);
		if ($id == 0) {
			$errno = 1;
			$message = "id is not null";
			return $this->result($errno, $message);
		}
		$data = commonGetData::getInfoById($id, $_W["uniacid"]);
		$data["content"] = $feildlist = unserialize($data["content"]);
		$imageeenname = pdo_fetch("SELECT enname FROM " . tablename(FIELDS) . " WHERE weid = {$_W["uniacid"]} AND mid = {$mid} AND mtype in ('images','goodsthumbs','goodsbaoliao')");
		$data["images"] = $feildlist[$imageeenname["enname"]];
		return $this->successResult($data);
	}
	public function doPageFields()
	{
		global $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$fieldslist = commonGetData::getfieinld_arr($_GPC["id"], $_W["uniacid"]);
		return $this->successResult($fieldslist);
	}
	public function doPageSubmit_imgs()
	{
		global $_W;
		$_W["uniacid"] = $this->getUniacid();
		$myfun = new MyFun();
		$imgdir = util::getAttImgdir();
		$uplogo_path = ATTACHMENT_ROOT . $imgdir;
		if (!is_dir($uplogo_path)) {
			$res = mkdir($uplogo_path, 511, true);
		}
		$img_file_name = time() . $myfun->randombylength(8) . "." . $myfun->fileext($_FILES["file"]["name"]);
		if (move_uploaded_file($_FILES["file"]["tmp_name"], $uplogo_path . $img_file_name)) {
			$restult = true;
		} else {
			$restult = false;
		}
		$webimgurl = tomedia($imgdir . $img_file_name);
		$data = array("img_dir" => $imgdir . $img_file_name, "img_path" => $webimgurl);
		return $this->successResult($data);
	}
	//添加店铺
    public function doPageAddShopInfo()
    {

        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
        $openid = $this->getUserBySeid();
        $Shop = new Shop();
        $userinfo = Member::getMemberByopenid($openid);
        $black = Member::getBlack($userinfo["id"]);
        $he7vG = empty($black);
        if ($he7vG) {
            $res = $Shop->postShopInfo($openid);

            echo $this->successResult($res);
        }
        $this->errorResult("很抱歉，您已被移入黑名单");
    }
	public function doPageAddInfo()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$openid = $this->getUserBySeid();
		$info = new Info();
		$userinfo = Member::getMemberByopenid($openid);
		$black = Member::getBlack($userinfo["id"]);
		if (!empty($black)) {
			$this->errorResult("很抱歉，您已被移入黑名单");
		}
		$res = $info->postInfo($openid, 2);
		return $this->successResult($res);
	}
    //获取信息数和成员数和人气数
    public function doPageGetNumber()
    {
        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
        $info = new Info();
        $infoCount   = $info->getInfoCount();
        $memberCount = $info->getMemberCount();
        if(!$infoCount){$infoCount=rand(50-99);}
        if(!$memberCount){$infoCount=rand(50-99);}
        if($infoCount<10){
            $infoCount = $infoCount*231;
        }elseif ($infoCount<100){
            $infoCount = $infoCount*131;
        }
        if($memberCount<10){
            $memberCount = $memberCount*231;
        }elseif ($memberCount<100){
            $memberCount = $memberCount*131;
        }

        $res['infoCount']   = $infoCount;
        $res['memberCount'] = $memberCount;
        $res['Popularity']  = intval(($infoCount+$memberCount)*4.42);
        return $res;
    }
	//获取店铺发布信息
    public function doPageGetInfoByShop()
    {
        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
        $openid = $this->getUserBySeid();
        $page = reqInfo::pageIndex();
        $num = reqInfo::num();
        $info = new Info();
        $haspay = $_GPC["haspay"];
        $status = $_GPC["status"];
        $isneedpay = $_GPC["isneedpay"];
        $where = '';
        if ($haspay) {
            $where .= " AND haspay= " . $haspay;
        }
        if ($isneedpay) {
            $where .= " AND isneedpay= " . $isneedpay;
        }
        if ($status) {
            $where .= " AND status= ".$status;
        } else {
            $where .= " AND status = 1 ";
        }
        $shop_id = intval($_GPC["shop_id"]);
        $res = $info->getInfoByShop($shop_id, $where, $page, $num);
        $res = $this->pro_info($res);
        return $this->successResult($res);
    }
	public function doPageGetInfoByUser()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$openid = $this->getUserBySeid();
		$page = reqInfo::pageIndex();
		$num = reqInfo::num();
		$info = new Info();
		$haspay = $_GPC["haspay"];
		$status = $_GPC["status"];
		$isneedpay = $_GPC["isneedpay"];
		$where = '';
		if ($haspay) {
			$where .= " AND haspay= " . $haspay;
		}
		if ($isneedpay) {
			$where .= " AND isneedpay= " . $isneedpay;
		}
		if ($status) {
			$where .= " AND status=1 ";
		} else {
			$where .= " AND status=0 ";
		}
		$res = $info->getInfoByuser($openid, $where, $page, $num);
		$res = $this->pro_info($res);
		return $this->successResult($res);
	}
	public function doPageGetPayInfoByUser()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$openid = $this->getUserBySeid();
		$page = reqInfo::page();
		$num = reqInfo::num();
		$info = new Info();
		$res = $info->getPayInfoByuser($openid, '', $page, $num);
		$res = $this->pro_info($res);
		return $this->successResult($res);
	}
	public function pro_info($res)
	{
		$_W["uniacid"] = $this->getUniacid();
		foreach ($res as $k => $v) {
			$module = pdo_fetch("SELECT name FROM " . tablename(CHANNEL) . " WHERE weid = {$_W["uniacid"]} AND id = {$v["mid"]}");
			$res[$k]["con"] = unserialize($v["content"]);
			$res[$k]["modulename"] = $module["name"];
		}
		return $res;
	}
	public function doPageAddviews()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$cfg = $this->module["config"];
		$views_num = intval($cfg["views_num"]);
		$id = intval($_GPC["message_id"]);
		$info = new Info();
		$message = $info->getInfoById($id);
		if ($views_num > 0) {
			$views = mt_rand(1, $views_num);
			$views = $message["views"] + $views;
		} else {
			$views = $message["views"] + 1;
		}
		pdo_update(INFO, array("views" => $views), array("id" => $id));
		return $this->successResult($views);
	}
	public function doPageDeleteInfo()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$id = intval($_GPC["message_id"]);
		$openid = $this->getUserBySeid();
		$info = new Info();
		$message = $info->getInfoByOId($openid, $id);
		if ($message) {
			pdo_delete(INFO, array("id" => $id, "openid" => $openid));
			return $this->successResult("delete success");
		} else {
			return $this->successResult("data is null");
		}
	}
	public function doPageGetTopInfoByUser()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$openid = $this->getUserBySeid();
		$page = reqInfo::pageIndex();
		$num = reqInfo::num();
		$info = new Info();
		$res = $info->getTopInfoByuser($openid, '', $page, $num);
		$res = $this->pro_info($res);
		return $this->successResult($res);
	}
	public function doPageGetCollect()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$openid = $this->getUserBySeid();
		$page = reqInfo::pageIndex();
		$num = reqInfo::num();
		$info = new Info();
		$info_id = intval($_GPC["message_id"]);
		if ($info_id > 0) {
			$where = " and b.id=" . $info_id;
		}
		$resInfo = $info->getCollect($openid, $page, $num, $where);
        $resShop = Shop::getCollect($openid, $page, $num, $where);
        $isgroup = array();
        $lat = $_GPC["lat"];
        $lng = $_GPC["lng"];
        foreach ($resShop as $k => $arr) {
            $arr["distance"] = util::getDistance($arr["lat"], $arr["lng"], $lat, $lng);
            $arr["inco"] = json_decode($arr["inco"]);
            $isgroup[] = $arr;
        }
        $arrSort = array();
        $sort = array("direction" => "SORT_ASC", "field" => "distance");
        foreach ($isgroup as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if ($sort["direction"] && count($isgroup) > 1) {
            array_multisort($arrSort[$sort["field"]], constant($sort["direction"]), $isgroup);
        }
        $data['info'] = $resInfo;
        $data['shop'] = $isgroup;
		return $this->successResult($data);
	}
	public function doPageGetInfoOdersn()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$openid = $this->getUserBySeid();
		$id = intval($_GPC["message_id"]);
		$res = util::getSingelDataInSingleTable(INFOORDER, array("message_id" => $id, "from_user" => $openid), "*", 2);
		return $this->successResult($res);
	}
	public function doPageProCollect()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$openid = $this->getUserBySeid();
        $shop_id = intval($_GPC['shop_id']);
        $message_id = intval($_GPC['message_id']);
        if($shop_id){
           $res = Shop::proCollect($openid);
            return $this->result($res["error"], $res["message"]);
        }
		$info = new Info();
		$res = $info->proCollect($openid);
		return $this->result($res["error"], $res["message"]);
	}
	public function doPageComment()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$type = intval($_GPC["type"]);
		$id = intval($_GPC["id"]);
		$openid = $this->getUserBySeid();
		if ($type == 1) {
			if ($id == 0) {
				return $this->errorResult("id is null");
			}
			$info = trim($_GPC["info"]);
			$pid = intval($_GPC["pid"]);
			if (empty($info)) {
				return $this->errorResult("评论内容不能为空");
				die;
			}
			$data = array("uniacid" => $_W["uniacid"], "addtime" => TIMESTAMP, "openid" => $openid, "info" => $info, "info_id" => $id, "parent_id" => $pid);
			$result = pdo_insert(INFO_COMMENT, $data);
			if (!empty($result)) {
				return $this->successResult($data);
			}
		} else {
			if ($id > 0) {
				$comment_where["info_id"] = $id;
			} else {
				$comment_where["openid"] = $openid;
			}
			$orderby = " comment_id ASC ";
			$comment = util::getAllDataBySingleTable(INFO_COMMENT, $comment_where, $orderby, $select = "*", $type = "1");
			foreach ($comment as $k => $v) {
				$memberData = Member::getSingleUser($v["openid"]);
				$comment[$k]["avatar"] = $memberData["avatar"];
				$comment[$k]["nickname"] = $memberData["nickname"];
				$comment[$k]["addtime"] = date("Y-m-d H:i", $v["addtime"]);
			}
			return $this->successResult($comment);
		}
	}
	public function doPageQiandao()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$uid = intval($_GPC["uid"]);
		if ($uid == 0) {
			return $this->errorResult("uid is null");
		}
		$cfg = $this->module["config"];
		$res = Member::qiandao($uid, $cfg);
		return $this->successResult($res);
	}
	public function doPageGetTitle()
	{
		global $_W;
		$_W["uniacid"] = $this->getUniacid();
		$cfg = $this->module["config"];
		$title = $cfg["index_title"];
		if (empty($title)) {
			$title = $_W["uniaccount"]["name"];
		}
		return $this->successResult($title);
	}
	//获取信息分类
	public function doPageGetChannel()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
        $module  = commonGetData::getChannel(1, 2); //修改成主类别
        $data = array();
        if(!$module ){
            return $this->errorResult("获取信息分类失败");
            die;
        }
        foreach ($module  as $k =>$v) {
            $data[$k]['id'] = $v['id'];
            $data[$k]['name'] = $v['name'];
            $data[$k]['thumb'] = $v['thumb'];
        }
		return $this->successResult($data);
	}

	//获取商城分类
    public function doPageGetCate()
    {
        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
        $data = Shop::getCate(); //修改成主类别
        return $this->successResult($data);
    }
    //获取用户的名称和商城名称
    public function doPageGetUserName()
    {
        global $_W, $_GPC;
        $openid = $this->getUserBySeid();
        $userinfo = Member::getMemberByopenid($openid);
        if(!$userinfo){
            return $this->errorResult("获取用户信息失败");
        }
        $shopuser = Shop::getShop_nameByOpenid($openid);
        if($shopuser && is_array($shopuser)){
            foreach($shopuser as $k => &$v){
                if($v['logo']){
                    $v['logo'] = "https://".$_SERVER ['HTTP_HOST'].'/attachment/'.$v['logo'];
                }
            }
        }
        $data = $shopuser;
        $data[] = array('shop_id'=>0,'nickname'=>$userinfo['nickname'],'logo'=>$userinfo['avatar'],'telphone'=>$userinfo['telphone']);
        return $this->successResult($data);
    }
    //获取我的入驻店铺
    public function doPageGetMyShopList()
    {
        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
        $openid = $this->getUserBySeid();
        $page = reqInfo::pageIndex();
        $num = reqInfo::num();
        $dis = pdo_fetchall("SELECT * FROM " . tablename(SHOP) . "  WHERE  uniacid = '{$_W["uniacid"]}' AND openid = '{$openid}' {$condition}    ORDER BY starttime DESC limit {$page},{$num}  ");
        $isgroup = array();
        $lat = $_GPC["lat"];
        $lng = $_GPC["lng"];
        foreach ($dis as $k => $arr) {
            $arr["distance"] = util::getDistance($arr["lat"], $arr["lng"], $lat, $lng);
            $arr["inco"] = json_decode($arr["inco"]);
            $isgroup[] = $arr;
        }
        $arrSort = array();
        $sort = array("direction" => "SORT_ASC", "field" => "distance");
        foreach ($isgroup as $uniqid => $row) {
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
            }
        }
        if ($sort["direction"] && count($isgroup) > 1) {
            array_multisort($arrSort[$sort["field"]], constant($sort["direction"]), $isgroup);
        }
        return $this->successResult($isgroup);
    }
    //删除店铺
    public function doPageDelMyShop()
    {
        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
        $openid = $this->getUserBySeid();
        $res = Shop::delShop($openid);
        return $this->result($res["error"], $res["message"]);

    }
	public function doPageGetShop()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$shop_id = intval($_GPC["shop_id"]);
        $openid = $this->getUserBySeid();
        $info = new Info();
		$data = Shop::getShopInfo($shop_id);
		if(!$data){
            return $this->errorResult("找不到店铺");
        }
        $shop_id = intval($_GPC["shop_id"]);
        $infoNum = $info->getInfoCountByShop($shop_id);
        //是否是自己的店铺
        $isMy = Shop::getShopIsMy($shop_id,$openid);
        if(!$infoNum){
            $infoNum = 0;
        }
        if($isMy){
            $isMy = 1;
        }else{
            $isMy = 0;
        }
        $data['infoNum'] =  $infoNum;
        $data['myself'] =  $isMy;
        if($data['inco']){
            $data['inco'] = json_decode($data['inco'],true);
        }
        $data['cate_name'] = Shop::getCateByPcate_id($data['pcate_id']);
        if($data['qr_code']){
            $data['qr_code'] = json_decode($data['qr_code'],true);
        }
		return $this->successResult($data);
	}
	public function doPageGetGood()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$shop_id = intval($_GPC["shop_id"]);
		$goods_id = intval($_GPC["good_id"]);
		$data = Goods::getSingleGood($goods_id, $shop_id);
		if ($data["is_time"] == "1") {
			$ms_status = Goods::ms_status($data);
			$data["times_flag"] = $ms_status;
			$date1 = date("Y-m-d", time());
			$changedate = strtotime($date1 . " " . $data["timeend"] . ":00:00");
			$arr = util::time_tran($changedate);
			$data["timelaststr"] = $arr[0];
			$data["timelast"] = $arr[1];
		}
		return $this->successResult($data);
	}
	public function doPageGetGood_list()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$page = reqInfo::pageIndex();
		$num = reqInfo::num();
		$where["shop_id"] = intval($_GPC["shop_id"]);
		$data = Goods::getAllGood($where, $page, $num);
		return $this->successResult($data[0]);
	}
	public function doPageGetShopList()
	{
		global $_W, $_GPC;
		$_W["uniacid"] = $this->getUniacid();
		$page = reqInfo::pageIndex();
		$num = reqInfo::num();
		$cate_id = intval($_GPC["cid"]);
		$condition = '';
		if ($cate_id > 0) {
			$condition .= " and s.pcate_id =" . $cate_id;
		}
		$dis = pdo_fetchall("SELECT s.* FROM " . tablename(SHOP) . " s WHERE  s.uniacid = '{$_W["uniacid"]}'  {$condition} and s.status =1    ORDER BY orderby limit {$page},{$num}  ");
		$isgroup = array();
		$lat = $_GPC["lat"];
		$lng = $_GPC["lng"];
		foreach ($dis as $k => $arr) {
			$arr["distance"] = util::getDistance($arr["lat"], $arr["lng"], $lat, $lng);
			$arr["inco"] = json_decode($arr["inco"]);
            $arr['qr_code'] = json_decode($arr['qr_code'],true);
			$isgroup[] = $arr;
		}
		$arrSort = array();
		$sort = array("direction" => "SORT_ASC", "field" => "distance");
		foreach ($isgroup as $uniqid => $row) {
			foreach ($row as $key => $value) {
				$arrSort[$key][$uniqid] = $value;
			}
		}
		if ($sort["direction"] && count($isgroup) > 1) {
			array_multisort($arrSort[$sort["field"]], constant($sort["direction"]), $isgroup);
		}
		return $this->successResult($isgroup);
	}
    //搜索框
    public function doPageSearch()
    {
        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
        $page = reqInfo::pageIndex();
        $num = reqInfo::num();
        $key = $_GPC["key"];
        //shop 搜索店铺  info 搜索信息
        $type = $_GPC["type"];
        if($type == 'info'){
            $info = new Info();
            $res = $info->searchInfo($key,$page,$num);
        }else{
            $res = Shop::searchShop($key,$page,$num);
        }
        return $this->successResult($res);

    }
	public function doPageGetDiscount()
	{
		global $_GPC, $_W;
		$_W["uniacid"] = $this->getUniacid();
		$page = reqInfo::pageIndex();
		$num = reqInfo::num();
		$shop_id = intval($_GPC["shop_id"]);
		$where["shop_id"] = $shop_id;
		$discount = Util::getAllDataInSingleTable(DISCOUNT, $where, $page, $num);
		return $this->successResult($discount[0]);
	}
	public function doPagePay()
	{
		global $_GPC, $_W;
		$_W["openid"] = $openid = $this->getUserBySeid();
		$order = array("tid" => $_GPC["ordersn"], "user" => $openid, "fee" => floatval($_GPC["sum"]), "title" => $_W["account"]["name"] . "支付");
		$pay_params = $this->pay($order);
		if (is_error($pay_params)) {
			return $this->result(1, $pay_params, $_W["openid"]);
		}
		return $this->result(0, '', $pay_params);
	}
	public function payResult($params)
	{
		global $_W, $_GPC;
		$acid = $this->getUniacid();
		$id = $params["tid"];
		$ordersnlen = strlen($params["tid"]);
		$PayResult = new PayResult();
		$log = Util::getSingelDataInSingleTable("core_paylog", array("module" => "yc_youliao", "tid" => $params["tid"]));
		$paydetail = $log["tag"];
		$logtag = unserialize($log["tag"]);
		$checkReq = $PayResult->checkReq($params);
		if ($checkReq == 0) {
			return;
		}
		$order = Util::getSingelDataInSingleTable(ORDER, array("ordersn" => $id));
		if ($params["result"] == "success" && $params["from"] == "notify") {
			if ($ordersnlen == 15) {
				$PayResult->payresult_info($params, $paydetail, $logtag, 1, $acid);
			} else {
				if ($ordersnlen == 20) {
					$PayResult->payresult_zd($params, $paydetail, $logtag, 1, $acid);
				} else {
					if (strstr($id, "dis")) {
						$PayResult->payresult_dis($params, 1);
					} else {
						$PayResult->payresult_order($params, $order, 1, $acid);
					}
				}
			}
		}
	}
}