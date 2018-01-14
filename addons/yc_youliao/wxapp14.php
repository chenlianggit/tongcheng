<?php
require IA_ROOT . "/addons/yc_youliao/class/reqInfo.php";
require IA_ROOT . "/addons/yc_youliao/class/util.php";
require IA_ROOT . "/addons/yc_youliao/model/Shop_pro.php";
require IA_ROOT . "/addons/yc_youliao/class/defineData.php";
require IA_ROOT . "/addons/yc_youliao/model/Info.php";
require IA_ROOT . "/addons/yc_youliao/class/function_common.class.php";
require IA_ROOT . "/addons/yc_youliao/model/Member.php";
require IA_ROOT . "/addons/yc_youliao/class/commonGetData.php";
require IA_ROOT . "/addons/yc_youliao/model/PayResult.php";
require IA_ROOT . "/addons/yc_youliao/model/Goods.php";
defined("IN_IA") or die("Access Denied");

class Yc_youliaoModuleWxapp extends WeModuleWxapp
{
    public function __construct()
    {
        $this->cfg();
    }

    private function cfg()
    {
        goto DdAA9;
        CbhjK:
        $_W["uniacid"] = $this->getUniacid();
        goto yUr0Z;
        yUr0Z:
        $cfg = pdo_fetchcolumn("SELECT settings FROM " . tablename("uni_account_modules") . " WHERE module = :module AND uniacid = :uniacid", array(":module" => MODULE, ":uniacid" => $_W["uniacid"]));
        goto R1RFK;
        DdAA9: global $_W;
        goto CbhjK;
        R1RFK:
        $this->module = unserialize($cfg);
        goto LTtKV;
        LTtKV:
    }

    public function doPageTest()
    {
        goto veVuy;
        jGxdg:
        $data = commonGetData::getAdv(1);
        goto dkvCI;
        OHMM_:
        $errno = 0;
        goto yL52o;
        dkvCI:
        return $this->result($errno, $message, $data);
        goto wGLry;
        yL52o:
        $message = "sucess";
        goto jGxdg;
        veVuy: global $_GPC, $_W;
        goto OHMM_;
        wGLry:
    }

    private function getOpenid()
    {
        goto s6zCC;
        s6zCC: global $_W, $_GPC;
        goto TpMUG;
        HTMD_:
        goto yVrAS;
        goto db3AD;
        x2aTe:
        goto yVrAS;
        goto YSUTl;
        monBA:
        if ($nowtime) {
            goto zmmdS;
        }
        goto HTMD_;
        HA22j:
        if (empty($member["unionId"]) && !empty($userinfo["unionId"])) {
            goto Yh6tK;
        }
        goto monBA;
        DIIcX:
        $userinfo = $account_api->getOauthInfo($code);
        goto GpJvR;
        dWRGL:
        pdo_update(MEMBER, array("nickname" => $_GPC["nickName"], "logintime" => time(), "avatar" => $_GPC["avatarUrl"]), array("uniacid" => $_W["uniacid"], "openid " => $userinfo["openid"]));
        goto PLImH;
        YKk_J: zmmdS:
        goto dWRGL;
        bsst0:
        if (empty($member)) {
            goto tkNnF;
        }
        goto HA22j;
        TpMUG:
        $_W["uniacid"] = $this->getUniacid();
        goto HEjEz;
        K3pKm:
        pdo_update(MEMBER, array("unionId" => $userinfo["unionId"]), array("uniacid" => $_W["uniacid"], "openid" => $userinfo["openId"]));
        goto FE2Fh;
        GpJvR:
        $member = pdo_get(MEMBER, array("uniacid" => $_W["uniacid"], "openid " => $userinfo["openid"]));
        goto KT0FB;
        FE2Fh:
        goto yVrAS;
        goto YKk_J;
        uDgPv:
        pdo_insert(MEMBER, $data);
        goto x2aTe;
        YSUTl: Yh6tK:
        goto K3pKm;
        KT0FB:
        $nowtime = $member["logintime"] - time();
        goto bsst0;
        Jxucc:
        $account_api = WeAccount::create();
        goto DIIcX;
        JbC_v:
        return $userinfo;
        goto hoG14;
        Sf6QQ:
        $data = array("uniacid" => $_W["uniacid"], "openid" => $userinfo["openid"], "nickname" => $_GPC["nickName"], "avatar" => $_GPC["avatarUrl"], "gender" => $_GPC["gender"], "wxapp" => 1, "logintime" => time());
        goto uDgPv;
        HEjEz:
        $code = $_GPC["code"];
        goto Jxucc;
        PLImH: yVrAS:
        goto JbC_v;
        db3AD: tkNnF:
        goto Sf6QQ;
        hoG14:
    }

    public function getUniacid()
    {
        goto d9dls;
        CSvDH: global $_GPC, $_W;
        goto gcEP9;
        RJ2nh:
        $version = $_GPC["v"];
        goto lp7iO;
        Lh2Zf:
        $_W["uniacid"] = $uniacid = $modules["yc_youliao"]["uniacid"];
        goto OCNPc;
        OHkeY: YUZIl:
        goto KrArt;
        d9dls: global $_W, $_GPC;
        goto CSvDH;
        lp7iO:
        $data = pdo_fetchcolumn(" SELECT modules FROM " . tablename("wxapp_versions") . " WHERE  uniacid = '{$uniacid}'  and version = '{$version}'   limit 1");
        goto EfXeb;
        KrArt:
        return $uniacid;
        goto B2unV;
        EfXeb:
        $modules = unserialize($data);
        goto Lh2Zf;
        HeDI3:
        if ($cWX8r) {
            goto YUZIl;
        }
        goto wryms;
        gcEP9:
        $uniacid = $_GPC["i"];
        goto RJ2nh;
        OCNPc:
        $cWX8r = !empty($_W["uniacid"]);
        goto HeDI3;
        wryms:
        $uniacid = pdo_fetchcolumn("SELECT weid FROM " . tablename(CHANNEL) . " order by id asc limit 1");
        goto OHkeY;
        B2unV:
    }

    public function successResult($data)
    {
        goto MQdFW;
        uC8jl:
        $message = "sucess";
        goto c37iE;
        MQdFW:
        $errno = 0;
        goto uC8jl;
        c37iE:
        return $this->result($errno, $message, $data);
        goto b6gDm;
        b6gDm:
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

    public function dopageGetSeid()
    {
        goto PIXK2;
        y9Mv2:
        $sessionId = time() . $myfun->randombylength(8);
        goto Dc1z8;
        VcKbX: CefO2:
        goto jni7w;
        GS6gW:
        return $this->errorResult("2");
        goto GV22H;
        Dc1z8:
        cache_write($sessionId, $userinfo["openid"]);
        goto M1bvZ;
        aAf6G:
        if ($q9pi1) {
            goto CefO2;
        }
        goto GS6gW;
        GV22H:
        die;
        goto VcKbX;
        M1bvZ:
        return $this->successResult($sessionId);
        goto Q6bgD;
        oxFmS:
        $q9pi1 = !empty($userinfo);
        goto aAf6G;
        jni7w:
        $myfun = new myfun();
        goto y9Mv2;
        PIXK2:
        $userinfo = $this->getOpenid();
        goto oxFmS;
        Q6bgD:
    }

    public function dopageGetUser()
    {
        $userinfo = $this->getOpenid();
        return $this->successResult($userinfo);
    }

    public function getUserBySeid()
    {
        goto kUs_r;
        UlDdI: uftp0:
        goto Z3PXT;
        FhgoQ:
        if ($q9pi1) {
            goto uftp0;
        }
        goto HA84B;
        DGlkn:
        $seid = $_GPC["seid"];
        goto z380T;
        hRxVc:
        $q9pi1 = !empty($userinfo);
        goto FhgoQ;
        kUs_r: global $_GPC;
        goto DGlkn;
        HA84B:
        return $this->errorResult("2");
        goto Cbx81;
        Z3PXT:
        return $userinfo;
        goto q2RpB;
        Cbx81:
        die;
        goto UlDdI;
        z380T:
        $userinfo = cache_load($seid);
        goto hRxVc;
        q2RpB:
    }

    public function doPageIndex()
    {
        goto eiH_i;
        HRKP1: Zwlz5:
        goto nzn5a;
        zx8Yz:
        $UMhvK = !($data["isSignIn"] == 1);
        goto Mo58L;
        zJA0G:
        $weatherdata = util::getWeather($weatherurl, $addresData["district"]);
        goto O_g6q;
        UBckK:
        $city = $addresData["city"];
        goto wdX00;
        iJjfn: Bf7_A:
        goto RZpi9;
        gUhdq:
        $info_condition = '';
        goto TqhYg;
        yhGe3:
        if ($Ola_u) {
            goto Zwlz5;
        }
        goto N2YJ_;
        D9BNc:
        $fWBCM = !($cfg["issamecity"] == 0);
        goto T9bbu;
        RZpi9:
        $data["credit"] = $cfg["qiandao_jifen"];
        goto pu0tR;
        WXrm_:
        $sql_city = rtrim($city, "\xe5\270\x82");
        goto D9BNc;
        PvAoG:
        if ($qiandao_random == 1) {
            goto OVad3;
        }
        goto hI1OL;
        kIbbs:
        goto BZ179;
        goto iJjfn;
        pu0tR: BZ179:
        goto wqG8A;
        ToTmt:
        $lat = $_GPC["lat"];
        goto xvxb3;
        mciJ3:
        $topMsg = commonGetData::getTopMsg($info_condition, $msgNum, $lat, $lng);
        goto dwyK9;
        YBzOQ:
        $chagexy = ReqInfo::chagexy($cfg);
        goto aS4Aa;
        aS4Aa:
        $addresData = util::getDistrictByLatLng($lat, $lng, $mapreq, $chagexy);
        goto hKmsV;
        bdcEJ:
        $uid = $_GPC["uid"];
        goto DD3FL;
        g0Au2:
        $cfg = $this->module["config"];
        goto AhCxX;
        G9ckM: jhHBS:
        goto GcMEF;
        pmpqi:
        goto BZ179;
        goto jlBv8;
        DD3FL:
        $Ola_u = !$uid;
        goto yhGe3;
        hI1OL:
        if (!empty($cfg["qiandao_jifen"])) {
            goto Bf7_A;
        }
        goto pmpqi;
        xvxb3:
        $lng = $_GPC["lng"];
        goto SiXEA;
        hKmsV:
        $formatted_address = $addresData["formatted_address"];
        goto UBckK;
        GhAz_:
        $mapreq = ReqInfo::mapReq($cfg);
        goto YBzOQ;
        iN2QR:
        if ($I5aVf) {
            goto etdij;
        }
        goto ToTmt;
        mIBRS:
        $weatherdata = util::getWeather($weatherurl, $city);
        goto B9xqv;
        SiXEA:
        $cfg = $this->module["config"];
        goto GhAz_;
        HBtGK:
        $data["isSignIn"] = $result;
        goto zx8Yz;
        ZnYyy:
        $K_2HV = !($weather2["status"] == "1002");
        goto A1GvT;
        V1xzx: p510y:
        goto XmGO4;
        b89iK:
        if ($slNdp) {
            goto jhHBS;
        }
        goto WXrm_;
        wdX00:
        $slNdp = !$city;
        goto b89iK;
        B9xqv:
        $weather2 = json_decode($weatherdata, 1);
        goto ZnYyy;
        Pqmpq:
        $msgNum = ReqInfo::msgNum($cfg);
        goto Uko2H;
        yRK51:
        $qiandao_random = $cfg["qiandao_random"];
        goto PvAoG;
        O_g6q: B2dLa:
        goto G9ckM;
        XmGO4:
        $weatherurl = ReqInfo::weatherreq();
        goto mIBRS;
        vTz5Q:
        $module = commonGetData::getChannel(1, 2);
        goto Pqmpq;
        nzn5a:
        return $this->successResult($data);
        goto Zacov;
        TqhYg:
        $lat = '';
        goto VzqcU;
        N2YJ_:
        $result = MEMBER::isqiandao($uid);
        goto HBtGK;
        Mo58L:
        if ($UMhvK) {
            goto zJfGX;
        }
        goto yRK51;
        wqG8A: zJfGX:
        goto HRKP1;
        jlBv8: OVad3:
        goto T4dhf;
        T9bbu:
        if ($fWBCM) {
            goto p510y;
        }
        goto RxhYk;
        eiH_i: global $_GPC, $_W;
        goto wMWn6;
        MsDQT:
        $weatherdata = '';
        goto ILn36;
        T4dhf:
        $data["credit"] = -1;
        goto kIbbs;
        Uko2H:
        $newMsg = commonGetData::getNewMsg($info_condition, $msgNum, $lat, $lng);
        goto mciJ3;
        VzqcU:
        $lng = '';
        goto gdafc;
        A1GvT:
        if ($K_2HV) {
            goto B2dLa;
        }
        goto zJA0G;
        GcMEF: etdij:
        goto gveHi;
        ILn36:
        $city = '';
        goto g0Au2;
        Jfg5B:
        $data = array("city" => $city, "formatted_address" => $formatted_address, "weatherdata" => $weatherdata, "advs" => $advs, "module" => $module, "newMsg" => $newMsg, "topMsg" => $topMsg, "hotMsg" => $hotMsg);
        goto bdcEJ;
        gdafc:
        $formatted_address = '';
        goto MsDQT;
        gveHi:
        $advs = commonGetData::getAdv(1);
        goto vTz5Q;
        wMWn6:
        $_W["uniacid"] = $this->getUniacid();
        goto gUhdq;
        dwyK9:
        $hotMsg = commonGetData::getHotMsg($info_condition, $msgNum, $lat, $lng);
        goto Jfg5B;
        AhCxX:
        $I5aVf = !(!empty($_GPC["lat"]) && !empty($_GPC["lng"]));
        goto iN2QR;
        RxhYk:
        $info_condition .= " and city like '" . $sql_city . "%' ";
        goto V1xzx;
        Zacov:
    }

    public function dopageCredit2money()
    {
        goto RSp2E;
        p_YCX: BSBbF:
        goto yHAW0;
        yHAW0:
        return $this->successResult($credit2money);
        goto rFKuC;
        WkBvn:
        $credit2money = $cfg["credit2money"];
        goto dhcfe;
        dhcfe:
        $FuTu2 = !empty($credit2money);
        goto T_uxE;
        T_uxE:
        if ($FuTu2) {
            goto BSBbF;
        }
        goto wLYwl;
        LDBUS:
        $cfg = $this->module["config"];
        goto WkBvn;
        RSp2E: global $_W, $_GPC;
        goto HBVan;
        HBVan:
        $_W["uniacid"] = $this->getUniacid();
        goto LDBUS;
        wLYwl:
        $credit2money = 0.1;
        goto p_YCX;
        rFKuC:
    }

    public function dopageGetLaction()
    {
        goto mNJ4S;
        mNJ4S: global $_GPC, $_W;
        goto vrGDk;
        eEGjP:
        return $this->successResult($addresData);
        goto xdig5;
        na160:
        $mapreq = ReqInfo::mapReq($cfg);
        goto V7tte;
        vrGDk:
        $I5aVf = !(!empty($_GPC["lat"]) && !empty($_GPC["lng"]));
        goto pK1mG;
        Ssx02:
        $lat = $_GPC["lat"];
        goto yovGs;
        InS0m:
        $addresData = util::getDistrictByLatLng($lat, $lng, $mapreq, $chagexy);
        goto eEGjP;
        xdig5: SUMfr:
        goto oP8S7;
        V7tte:
        $chagexy = ReqInfo::chagexy($cfg);
        goto InS0m;
        pK1mG:
        if ($I5aVf) {
            goto SUMfr;
        }
        goto Ssx02;
        yovGs:
        $lng = $_GPC["lng"];
        goto d63ki;
        d63ki:
        $cfg = $this->module["config"];
        goto na160;
        oP8S7:
    }

    public function doPageGetModuleById()
    {
        goto H1CK4;
        alrYU: cLF6s:
        goto ouS4P;
        OabUr:
        $cfg = $this->module["config"];
        goto yCUIt;
        H1CK4: global $_W, $_GPC;
        goto wuJ8O;
        gIJhQ:
        if ($fWBCM) {
            goto E40I1;
        }
        goto t2xT6;
        LsMhT:
        $id = intval($_GPC["id"]);
        goto zozYo;
        mCDIQ:
        $num = reqInfo::num();
        goto Z55wM;
        xpoLM:
        $data = commonGetData::getMsgById($id, $page, $num, $city);
        goto TT5Lr;
        UfA6B:
        $errno = 1;
        goto bHJ3K;
        vbUvi:
        return $this->result($errno, $message);
        goto alrYU;
        zozYo:
        $fVcAq = !($id == 0);
        goto T4Ms8;
        wuJ8O:
        $_W["uniacid"] = $this->getUniacid();
        goto LsMhT;
        Zy7lu:
        $city = '';
        goto OabUr;
        yCUIt:
        $fWBCM = !($cfg["issamecity"] == 0);
        goto gIJhQ;
        ouS4P:
        $page = reqInfo::pageIndex();
        goto mCDIQ;
        Vdm5c: E40I1:
        goto xpoLM;
        t2xT6:
        $city = $_GPC["city"];
        goto Vdm5c;
        TT5Lr:
        return $this->successResult($data);
        goto BrQ0f;
        bHJ3K:
        $message = "id is null";
        goto vbUvi;
        Z55wM:
        $id = intval($id);
        goto Zy7lu;
        T4Ms8:
        if ($fVcAq) {
            goto cLF6s;
        }
        goto UfA6B;
        BrQ0f:
    }

    public function doPageGetInfoById()
    {
        goto rtK6S;
        RzvdV:
        return $this->successResult($data);
        goto hf7E3;
        mraoq:
        $data = commonGetData::getInfoById($id, $_W["uniacid"]);
        goto jbXoi;
        gk_pt:
        $id = intval($_GPC["id"]);
        goto pW0A5;
        ht022:
        $fVcAq = !($id == 0);
        goto XgRPI;
        t3dWZ:
        $errno = 1;
        goto khijV;
        Ez1Mw:
        $_W["uniacid"] = $this->getUniacid();
        goto gk_pt;
        jbXoi:
        $data["content"] = $feildlist = unserialize($data["content"]);
        goto EIPRT;
        J_dwi: xqGfO:
        goto mraoq;
        pW0A5:
        $mid = intval($_GPC["mid"]);
        goto ht022;
        rtK6S: global $_GPC;
        goto Ez1Mw;
        zzkOF:
        $data["images"] = $feildlist[$imageeenname["enname"]];
        goto RzvdV;
        EIPRT:
        $imageeenname = pdo_fetch("SELECT enname FROM " . tablename(FIELDS) . " WHERE weid = {$_W["uniacid"]} AND mid = {$mid} AND mtype in ('images','goodsthumbs','goodsbaoliao')");
        goto zzkOF;
        khijV:
        $message = "id is not null";
        goto obTvy;
        XgRPI:
        if ($fVcAq) {
            goto xqGfO;
        }
        goto t3dWZ;
        obTvy:
        return $this->result($errno, $message);
        goto J_dwi;
        hf7E3:
    }

    public function doPageFields()
    {
        goto OiRkN;
        T0CcM:
        return $this->successResult($fieldslist);
        goto CRUxG;
        QYxWz:
        $fieldslist = commonGetData::getfield_arr($_GPC["id"], $_W["uniacid"]);
        goto T0CcM;
        zcA3v:
        $_W["uniacid"] = $this->getUniacid();
        goto QYxWz;
        OiRkN: global $_GPC;
        goto zcA3v;
        CRUxG:
    }
    //图片上传
    public function doPageSubmit_imgs()
    {
        goto VEi3B;
        imhrN:
        $res = mkdir($uplogo_path, 511, true);
        goto FSpHq;
        kVSge:
        $webimgurl = tomedia($imgdir . $img_file_name);
        goto K0Bbe;
        wTZEj:
        $imgdir = util::getAttImgdir();
        goto G2OCE;
        K2Opf:
        goto nSzkg;
        goto wsueu;
        FSpHq: knOV3:
        goto duDvR;
        OJ3kx: nSzkg:
        goto kVSge;
        wsueu: XDk2r:
        goto bjfWI;
        HSarh:
        if ($X1Fbs) {
            goto knOV3;
        }
        goto imhrN;
        bliYE:
        return $this->successResult($data);
        goto uc1bi;
        K0Bbe:
        $data = array("img_dir" => $imgdir . $img_file_name, "img_path" => $webimgurl);
        goto bliYE;
        bjfWI:
        $restult = true;
        goto OJ3kx;
        VEi3B: global $_W;
        goto NPqBf;
        G2OCE:
        $uplogo_path = ATTACHMENT_ROOT . $imgdir;
        goto zCXeG;
        zCXeG:
        $X1Fbs = is_dir($uplogo_path);
        goto HSarh;
        TySLF:
        if (move_uploaded_file($_FILES["file"]["tmp_name"], $uplogo_path . $img_file_name)) {
            goto XDk2r;
        }
        goto w9xfq;
        ZCqFA:
        $myfun = new MyFun();
        goto wTZEj;
        duDvR:
        $img_file_name = time() . $myfun->randombylength(8) . "\56" . $myfun->fileext($_FILES["file"]["name"]);
        goto TySLF;
        NPqBf:
        $_W["uniacid"] = $this->getUniacid();
        goto ZCqFA;
        w9xfq:
        $restult = false;
        goto K2Opf;
        uc1bi:
    }

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
        $he7vG = empty($black);
        if ($he7vG) {
            $res = $info->postInfo($openid, 2);
            return $this->successResult($res);
        }

        $this->errorResult("很抱歉，您已被移入黑名单");
//        goto Zjddj;
//        zgDvB:
//        $black = Member::getBlack($userinfo["id"]);
//        goto wuc88;
//        K0lKW:
//        $this->errorResult("\xe5\xbe\x88\xe6\212\xb1\xe6\255\211\357\274\x8c\346\x82\250\xe5\xb7\262\350\242\253\xe7\xa7\273\345\205\xa5\351\xbb\x91\345\x90\x8d\xe5\215\225");
//        goto KDtV9;
//        o9zMI:
//        $openid = $this->getUserBySeid();
//        goto PkCGO;
//        KDtV9: r9NcJ:
//        goto z7R8c;
//        z7R8c:
//        $res = $info->postInfo($openid, 2);
//        goto I2655;
//        PkCGO:
//        $info = new Info();
//        goto gKmBX;
//        y1UYI:
//        $_W["uniacid"] = $this->getUniacid();
//        goto o9zMI;
//        gKmBX:
//        $userinfo = Member::getMemberByopenid($openid);
//        goto zgDvB;
//        wuc88:
//        $he7vG = empty($black);
//        goto qx_AD;
//        qx_AD:
//        if ($he7vG) {
//            goto r9NcJ;
//        }
//        goto K0lKW;
//        Zjddj: global $_W, $_GPC;
//        goto y1UYI;
//        I2655:
//        return $this->successResult($res);
//        goto f8dXh;
//        f8dXh:
    }

    public function doPageGetInfoByUser()
    {
        goto a7IZz;
        Zpo7l:
        $_W["uniacid"] = $this->getUniacid();
        goto nwSVG;
        D82jp:
        if ($status) {
            goto oajiU;
        }
        goto qSS02;
        sXHNK:
        $haspay = $_GPC["haspay"];
        goto Xeix2;
        qSS02:
        $where .= " AND status=0 ";
        goto nT7xu;
        rCghS:
        $res = $this->pro_info($res);
        goto d9heL;
        tJ0ii: oajiU:
        goto m0ylH;
        nwSVG:
        $openid = $this->getUserBySeid();
        goto JQrb1;
        k2TSZ: z3GBz:
        goto yFQe0;
        GGF6p:
        $info = new Info();
        goto sXHNK;
        cHEXe:
        $where = '';
        goto Egeml;
        yFQe0:
        $LNTzy = !$isneedpay;
        goto ezRUe;
        LMM46: Eplq_:
        goto wwRUl;
        K1qu3: xOTdZ:
        goto D82jp;
        nT7xu:
        goto Eplq_;
        goto tJ0ii;
        eAKfS:
        $where .= " AND haspay= " . $haspay;
        goto k2TSZ;
        oP1Lo:
        $num = reqInfo::num();
        goto GGF6p;
        AzKGd:
        if ($ImWaE) {
            goto z3GBz;
        }
        goto eAKfS;
        d9heL:
        return $this->successResult($res);
        goto L7Zlw;
        ezRUe:
        if ($LNTzy) {
            goto xOTdZ;
        }
        goto a0X4t;
        m0ylH:
        $where .= " AND status=1 ";
        goto LMM46;
        Egeml:
        $ImWaE = !$haspay;
        goto AzKGd;
        xtUMy:
        $isneedpay = $_GPC["isneedpay"];
        goto cHEXe;
        Xeix2:
        $status = $_GPC["status"];
        goto xtUMy;
        a0X4t:
        $where .= " AND isneedpay= " . $isneedpay;
        goto K1qu3;
        JQrb1:
        $page = reqInfo::pageIndex();
        goto oP1Lo;
        wwRUl:
        $res = $info->getInfoByuser($openid, $where, $page, $num);
        goto rCghS;
        a7IZz: global $_W, $_GPC;
        goto Zpo7l;
        L7Zlw:
    }

    public function doPageGetPayInfoByUser()
    {
        goto p3z5Y;
        rep3U:
        $res = $info->getPayInfoByuser($openid, '', $page, $num);
        goto oLbb6;
        Zg_rW:
        $page = reqInfo::page();
        goto YsqP1;
        CiO5C:
        return $this->successResult($res);
        goto kQYIK;
        OM3JZ:
        $openid = $this->getUserBySeid();
        goto Zg_rW;
        p3z5Y: global $_W, $_GPC;
        goto H6UET;
        K25wa:
        $info = new Info();
        goto rep3U;
        oLbb6:
        $res = $this->pro_info($res);
        goto CiO5C;
        YsqP1:
        $num = reqInfo::num();
        goto K25wa;
        H6UET:
        $_W["uniacid"] = $this->getUniacid();
        goto OM3JZ;
        kQYIK:
    }

    public function pro_info($res)
    {
        goto sjUKK;
        B5gWH:
        foreach ($res as $k => $v) {
            goto tAi4g;
            o3jFZ:
            $res[$k]["con"] = unserialize($v["content"]);
            goto cgR_i;
            aa7B3: gcuQV:
            goto lrbJK;
            tAi4g:
            $module = pdo_fetch("SELECT name FROM " . tablename(CHANNEL) . " WHERE weid = {$_W["uniacid"]} AND id = {$v["mid"]}");
            goto o3jFZ;
            cgR_i:
            $res[$k]["modulename"] = $module["name"];
            goto aa7B3;
            lrbJK:
        }
        goto Zu6vJ;
        Puszl:
        return $res;
        goto ynkoe;
        Zu6vJ: y_j13:
        goto Puszl;
        sjUKK:
        $_W["uniacid"] = $this->getUniacid();
        goto B5gWH;
        ynkoe:
    }

    public function doPageAddviews()
    {
        goto NrqIf;
        rCGWb:
        $cfg = $this->module["config"];
        goto mT1QR;
        JpvZt: gaf4A:
        goto IH2J2;
        Xo1Dv:
        $id = intval($_GPC["message_id"]);
        goto ezitD;
        HN13j:
        return $this->successResult($views);
        goto QFphA;
        d2lbB:
        if ($views_num > 0) {
            goto gaf4A;
        }
        goto k2Got;
        bgcFh:
        pdo_update(INFO, array("views" => $views), array("id" => $id));
        goto HN13j;
        KPFse: BihXy:
        goto bgcFh;
        mYYZG:
        $views = $message["views"] + $views;
        goto KPFse;
        vJUuG:
        $_W["uniacid"] = $this->getUniacid();
        goto rCGWb;
        ezitD:
        $info = new Info();
        goto ofGYP;
        NrqIf: global $_W, $_GPC;
        goto vJUuG;
        k2Got:
        $views = $message["views"] + 1;
        goto hxcrh;
        mT1QR:
        $views_num = intval($cfg["views_num"]);
        goto Xo1Dv;
        hxcrh:
        goto BihXy;
        goto JpvZt;
        IH2J2:
        $views = mt_rand(1, $views_num);
        goto mYYZG;
        ofGYP:
        $message = $info->getInfoById($id);
        goto d2lbB;
        QFphA:
    }

    public function doPageDeleteInfo()
    {
        goto Ob6EW;
        w7VsX:
        if ($message) {
            goto C14r9;
        }
        goto BV3j5;
        ZFkVM:
        $message = $info->getInfoByOId($openid, $id);
        goto w7VsX;
        P0bGW: C14r9:
        goto d_cO3;
        BV3j5:
        return $this->successResult("data is null");
        goto rcfhZ;
        rtQ2b:
        $openid = $this->getUserBySeid();
        goto wUEmn;
        Ob6EW: global $_W, $_GPC;
        goto eBw3Q;
        d_cO3:
        pdo_delete(INFO, array("id" => $id, "openid" => $openid));
        goto yidAw;
        rcfhZ:
        goto O5U0Q;
        goto P0bGW;
        yidAw:
        return $this->successResult("delete success");
        goto k5p29;
        nY78Y:
        $id = intval($_GPC["message_id"]);
        goto rtQ2b;
        wUEmn:
        $info = new Info();
        goto ZFkVM;
        k5p29: O5U0Q:
        goto oIBs2;
        eBw3Q:
        $_W["uniacid"] = $this->getUniacid();
        goto nY78Y;
        oIBs2:
    }

    public function doPageGetTopInfoByUser()
    {
        goto bYjZf;
        kdojo:
        $info = new Info();
        goto a52M8;
        EX8g_:
        $num = reqInfo::num();
        goto kdojo;
        a52M8:
        $res = $info->getTopInfoByuser($openid, '', $page, $num);
        goto k30DB;
        k30DB:
        $res = $this->pro_info($res);
        goto TJLNk;
        PAAhB:
        $openid = $this->getUserBySeid();
        goto KqYdN;
        TJLNk:
        return $this->successResult($res);
        goto nnKjT;
        krz0_:
        $_W["uniacid"] = $this->getUniacid();
        goto PAAhB;
        KqYdN:
        $page = reqInfo::pageIndex();
        goto EX8g_;
        bYjZf: global $_W, $_GPC;
        goto krz0_;
        nnKjT:
    }

    public function doPageGetCollect()
    {
        goto QEI61;
        aOCV6:
        $_W["uniacid"] = $this->getUniacid();
        goto eyygo;
        j7zWX: P3HoU:
        goto ghZxD;
        H9T3c:
        $where = " and b.id=" . $info_id;
        goto j7zWX;
        srRJn:
        if ($M4eek) {
            goto P3HoU;
        }
        goto H9T3c;
        iSzbI:
        $M4eek = !($info_id > 0);
        goto srRJn;
        Mf9WG:
        $page = reqInfo::pageIndex();
        goto jHNYL;
        Ya9CZ:
        $info = new Info();
        goto uNOtl;
        eyygo:
        $openid = $this->getUserBySeid();
        goto Mf9WG;
        QEI61: global $_W, $_GPC;
        goto aOCV6;
        ghZxD:
        $res = $info->getCollect($openid, $page, $num, $where);
        goto nZ66C;
        nZ66C:
        return $this->successResult($res);
        goto YSudQ;
        jHNYL:
        $num = reqInfo::num();
        goto Ya9CZ;
        uNOtl:
        $info_id = intval($_GPC["message_id"]);
        goto iSzbI;
        YSudQ:
    }

    public function doPageGetInfoOdersn()
    {
        goto M2o3Y;
        dlscs:
        $_W["uniacid"] = $this->getUniacid();
        goto CRNHs;
        CRNHs:
        $openid = $this->getUserBySeid();
        goto VL4du;
        M2o3Y: global $_W, $_GPC;
        goto dlscs;
        VL4du:
        $id = intval($_GPC["message_id"]);
        goto BL4Gu;
        BL4Gu:
        $res = util::getSingelDataInSingleTable(INFOORDER, array("message_id" => $id, "from_user" => $openid), "*", 2);
        goto FkPcz;
        FkPcz:
        return $this->successResult($res);
        goto h1gGt;
        h1gGt:
    }

    public function doPageProCollect()
    {
        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
        $openid = $this->getUserBySeid();
        $info = new Info();
        $res = $info->proCollect($openid);
        return $this->result($res["error"], $res["message"]);
//        goto efnOl;
//        l5W_N:
//        $res = $info->proCollect($openid);
//        goto noGRU;
//        wF_CT:
//        $info = new Info();
//        goto l5W_N;
//        noGRU:
//        return $this->result($res["error"], $res["message"]);
//        goto lbDZ2;
//        efnOl: global $_W, $_GPC;
//        goto h32sW;
//        n2Bqk:
//        $openid = $this->getUserBySeid();
//        goto wF_CT;
//        h32sW:
//        $_W["uniacid"] = $this->getUniacid();
//        goto n2Bqk;
//        lbDZ2:
    }

    public function doPageComment()
    {
        goto MQx5H;
        JeD_n:
        $type = intval($_GPC["type"]);
        goto LLJW7;
        Lv9we:
        die;
        goto gmc1D;
        xa1Zz: qr0G7:
        goto vfMBc;
        zxBZW: MrT11:
        goto jtDGJ;
        I_zYQ:
        return $this->successResult($comment);
        goto a1FfO;
        vfMBc:
        $orderby = " comment_id ASC";
        goto s24Mk;
        B6KK6:
        $pid = intval($_GPC["pid"]);
        goto o9jFr;
        MQx5H: global $_W, $_GPC;
        goto lKBwW;
        jtDGJ: aAybi:
        goto Bmlhb;
        o9jFr:
        $o3MoH = !empty($info);
        goto R0tSS;
        LPfi7:
        if ($fVcAq) {
            goto cWF5T;
        }
        goto vWBOU;
        R0tSS:
        if ($o3MoH) {
            goto S4Tqm;
        }
        goto dtrrc;
        lKBwW:
        $_W["uniacid"] = $this->getUniacid();
        goto JeD_n;
        zgoMy: cWF5T:
        goto iL6ka;
        O60jl:
        $comment_where["openid"] = $openid;
        goto opE2u;
        hOukK: CxTcK:
        goto F9nyJ;
        dtrrc:
        return $this->errorResult("\xe8\257\x84\xe8\xae\272\xe5\x86\205\xe5\256\271\344\xb8\x8d\xe8\203\275\xe4\270\272\xe7\251\272");
        goto Lv9we;
        zI0eV:
        $result = pdo_insert(INFO_COMMENT, $data);
        goto RC1qq;
        hof9b:
        $fVcAq = !($id == 0);
        goto LPfi7;
        s24Mk:
        $comment = util::getAllDataBySingleTable(INFO_COMMENT, $comment_where, $orderby, $select = "*", $type = "1");
        goto UoC5T;
        LLJW7:
        $id = intval($_GPC["id"]);
        goto joQtQ;
        joQtQ:
        $openid = $this->getUserBySeid();
        goto mBXmM;
        n9pPA: uY58k:
        goto hof9b;
        gmc1D: S4Tqm:
        goto c04Pd;
        opE2u:
        goto qr0G7;
        goto hOukK;
        c04Pd:
        $data = array("uniacid" => $_W["uniacid"], "addtime" => TIMESTAMP, "openid" => $openid, "info" => $info, "info_id" => $id, "parent_id" => $pid);
        goto zI0eV;
        mBXmM:
        if ($type == 1) {
            goto uY58k;
        }
        goto WtSj1;
        YV6c4:
        return $this->successResult($data);
        goto zxBZW;
        UoC5T:
        foreach ($comment as $k => $v) {
            goto yt4rB;
            P9O5C:
            $comment[$k]["nickname"] = $memberData["nickname"];
            goto rWCLA;
            zDW5R: B5eIA:
            goto ENOCL;
            yt4rB:
            $memberData = Member::getSingleUser($v["openid"]);
            goto CWlf_;
            rWCLA:
            $comment[$k]["addtime"] = date("Y-m-d H:i", $v["addtime"]);
            goto zDW5R;
            CWlf_:
            $comment[$k]["avatar"] = $memberData["avatar"];
            goto P9O5C;
            ENOCL:
        }
        goto T76Dj;
        iL6ka:
        $info = trim($_GPC["info"]);
        goto B6KK6;
        vWBOU:
        return $this->errorResult("id is null");
        goto zgoMy;
        WtSj1:
        if ($id > 0) {
            goto CxTcK;
        }
        goto O60jl;
        a1FfO:
        goto aAybi;
        goto n9pPA;
        F9nyJ:
        $comment_where["info_id"] = $id;
        goto xa1Zz;
        T76Dj: UG2lT:
        goto I_zYQ;
        RC1qq:
        $RiOVM = empty($result);
        goto b2XHs;
        b2XHs:
        if ($RiOVM) {
            goto MrT11;
        }
        goto YV6c4;
        Bmlhb:
    }

    public function doPageQiandao()
    {
        goto aUxoE;
        ZCHr1:
        if ($sHTBP) {
            goto h96iS;
        }
        goto qmx_e;
        Gkera:
        return $this->successResult($res);
        goto LhST3;
        qmx_e:
        return $this->errorResult("uid is null");
        goto yiN89;
        uDlwe:
        $sHTBP = !($uid == 0);
        goto ZCHr1;
        XAB_8:
        $cfg = $this->module["config"];
        goto PwMSQ;
        PE5EQ:
        $uid = intval($_GPC["uid"]);
        goto uDlwe;
        aUxoE: global $_W, $_GPC;
        goto Y7LwG;
        Y7LwG:
        $_W["uniacid"] = $this->getUniacid();
        goto PE5EQ;
        PwMSQ:
        $res = Member::qiandao($uid, $cfg);
        goto Gkera;
        yiN89: h96iS:
        goto XAB_8;
        LhST3:
    }

    public function doPageGetTitle()
    {
        goto rGH2S;
        pCTfz: WkKBO:
        goto gq9OB;
        rGH2S: global $_W;
        goto y3tgV;
        UaXQS:
        $title = $cfg["index_title"];
        goto hiy0e;
        v7z5I:
        $cfg = $this->module["config"];
        goto UaXQS;
        gq9OB:
        return $this->successResult($title);
        goto GB9Tv;
        j8eMM:
        $title = $_W["uniaccount"]["name"];
        goto pCTfz;
        OX3Kr:
        if ($K10P5) {
            goto WkKBO;
        }
        goto j8eMM;
        y3tgV:
        $_W["uniacid"] = $this->getUniacid();
        goto v7z5I;
        hiy0e:
        $K10P5 = !empty($title);
        goto OX3Kr;
        GB9Tv:
    }

    public function doPageGetCate()
    {
        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
//        $data = Shop::getCcate(); //获取子分类
        $data = Shop::getCate();
        return $this->successResult($data);
//        goto YUjz0;
//        NWKXg:
//        $_W["uniacid"] = $this->getUniacid();
//        goto wq11Y;
//        t2DJN:
//        return $this->successResult($data);
//        goto eXelp;
//        YUjz0: global $_W, $_GPC;
//        goto NWKXg;
//        wq11Y:
//        $data = Shop::getCcate();
//        goto t2DJN;
//        eXelp:
    }

    public function doPageGetShop()
    {
        goto Zo0qT;
        CVwsi:
        $_W["uniacid"] = $this->getUniacid();
        goto A4WqX;
        pG5Hk:
        return $this->successResult($data);
        goto TcCeN;
        A4WqX:
        $shop_id = intval($_GPC["shop_id"]);
        goto f_Q1G;
        Zo0qT: global $_W, $_GPC;
        goto CVwsi;
        f_Q1G:
        $data = Shop::getShopInfo($shop_id);
        goto pG5Hk;
        TcCeN:
    }

    public function doPageGetGood()
    {
        goto duvcy;
        X2b7r:
        return $this->successResult($data);
        goto kNkyj;
        lcbrn:
        $data["timelaststr"] = $arr[0];
        goto J7gEi;
        mC4nz:
        $shop_id = intval($_GPC["shop_id"]);
        goto rkTqt;
        RTcbz:
        $_W["uniacid"] = $this->getUniacid();
        goto mC4nz;
        FXwT9:
        if ($DTK2p) {
            goto wtxeu;
        }
        goto Ml3Si;
        J7gEi:
        $data["timelast"] = $arr[1];
        goto x5p1D;
        p1tKW:
        $data["times_flag"] = $ms_status;
        goto P3buo;
        duvcy: global $_W, $_GPC;
        goto RTcbz;
        U2Cm6:
        $changedate = strtotime($date1 . " " . $data["timeend"] . ":00:00");
        goto O2ClJ;
        rVRXP:
        $DTK2p = !($data["is_time"] == "1");
        goto FXwT9;
        Fw2rg:
        $data = Goods::getSingleGood($goods_id, $shop_id);
        goto rVRXP;
        O2ClJ:
        $arr = util::time_tran($changedate);
        goto lcbrn;
        Ml3Si:
        $ms_status = Goods::ms_status($data);
        goto p1tKW;
        P3buo:
        $date1 = date("Y-m-d", time());
        goto U2Cm6;
        rkTqt:
        $goods_id = intval($_GPC["good_id"]);
        goto Fw2rg;
        x5p1D: wtxeu:
        goto X2b7r;
        kNkyj:
    }

    public function doPageGetGood_list()
    {
        goto XKmYP;
        UYqYP:
        $page = reqInfo::pageIndex();
        goto TLTgH;
        d0euC:
        return $this->successResult($data[0]);
        goto qR7V3;
        AguJe:
        $data = Goods::getAllGood($where, $page, $num);
        goto d0euC;
        S41aM:
        $_W["uniacid"] = $this->getUniacid();
        goto UYqYP;
        d4j2m:
        $where["shop_id"] = intval($_GPC["shop_id"]);
        goto AguJe;
        XKmYP: global $_W, $_GPC;
        goto S41aM;
        TLTgH:
        $num = reqInfo::num();
        goto d4j2m;
        qR7V3:
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
    public function doPageGetShopList()
    {
        goto XfzNt;
        D8q3V:
        return $this->successResult($isgroup);
        goto Nv5IY;
        Sq85b:
        $lat = $_GPC["lat"];
        goto QTiUO;
        QTiUO:
        $lng = $_GPC["lng"];
        goto Cclo0;
        Cclo0:
        foreach ($dis as $k => $arr) {
            goto Pn2mU;
            upLY_:
            $arr["inco"] = json_decode($arr["inco"]);
            goto MBXRK;
            c154k: QAnsQ:
            goto WKnBT;
            Pn2mU:
            $arr["distance"] = util::getDistance($arr["lat"], $arr["lng"], $lat, $lng);
            goto upLY_;
            MBXRK:
            $isgroup[] = $arr;
            goto c154k;
            WKnBT:
        }
        goto PR5tK;
        sYEH8:
        $num = reqInfo::num();
        goto WLusB;
        ST29p:
        $sort = array("direction" => "SORT_ASC", "field" => "distance");
        goto HNO4_;
        IbGuU:
        $condition = '';
        goto E1hHM;
        zfjRM:
        $condition .= " and s.ccate_id =" . $cate_id;
        goto BVGqU;
        U0u1a:
        $_W["uniacid"] = $this->getUniacid();
        goto Ashtd;
        PR5tK: moi6q:
        goto uF4iv;
        LXMec:
        array_multisort($arrSort[$sort["field"]], constant($sort["direction"]), $isgroup);
        goto ByfEe;
        Ashtd:
        $page = reqInfo::pageIndex();
        goto sYEH8;
        BVGqU: UowhS:
        goto jdmry;
        E1hHM:
        $c1Fzz = !($cate_id > 0);
        goto Nda2N;
        ByfEe: u2WJR:
        goto D8q3V;
        Nda2N:
        if ($c1Fzz) {
            goto UowhS;
        }
        goto zfjRM;
        pR6MJ:
        if ($BO2dk) {
            goto u2WJR;
        }
        goto LXMec;
        jdmry:
        $dis = pdo_fetchall("SELECT s.* FROM " . tablename(SHOP) . " s WHERE  s.uniacid = '{$_W["uniacid"]}'  {$condition} and s.status =1    ORDER BY orderby limit {$page},{$num}  ");
        goto n1wAG;
        n1wAG:
        $isgroup = array();
        goto Sq85b;
        wc6pJ: m4Gwe:
        goto bBy_S;
        XfzNt: global $_W, $_GPC;
        goto U0u1a;
        uF4iv:
        $arrSort = array();
        goto ST29p;
        HNO4_:
        foreach ($isgroup as $uniqid => $row) {
            goto x81YU;
            A18a5: Q0_RQ:
            goto PnzWr;
            x81YU:
            foreach ($row as $key => $value) {
                $arrSort[$key][$uniqid] = $value;
                cqQNg:
            }
            goto i4rxh;
            i4rxh: SG0zs:
            goto A18a5;
            PnzWr:
        }
        goto wc6pJ;
        WLusB:
        $cate_id = intval($_GPC["cid"]);
        goto IbGuU;
        bBy_S:
        $BO2dk = !($sort["direction"] && count($isgroup) > 1);
        goto pR6MJ;
        Nv5IY:
    }

    public function doPageGetShopList2(){
        global $_W, $_GPC;
        $_W["uniacid"] = $this->getUniacid();
        $page = reqInfo::pageIndex();
        $num = reqInfo::num();
        $cate_id = intval($_GPC["cid"]);
        $condition = '';
        $c1Fzz = !($cate_id > 0);
        if ($c1Fzz) {
            $dis = pdo_fetchall("SELECT s.* FROM " . tablename(SHOP) . " s WHERE  s.uniacid = '{$_W["uniacid"]}'  {$condition} and s.status =1    ORDER BY orderby limit {$page},{$num}  ");
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
            $BO2dk = !($sort["direction"] && count($isgroup) > 1);
            if ($BO2dk) {
                return $this->successResult($isgroup);
                exit;
            }
            array_multisort($arrSort[$sort["field"]], constant($sort["direction"]), $isgroup);
            return $this->successResult($isgroup);
        }
    }
    public function doPageGetDiscount()
    {
        goto E8rmi;
        g3iY2:
        $_W["uniacid"] = $this->getUniacid();
        goto iUsw8;
        ZS0p3:
        $shop_id = intval($_GPC["shop_id"]);
        goto kuu4I;
        kuu4I:
        $where["shop_id"] = $shop_id;
        goto ojXl5;
        iUsw8:
        $page = reqInfo::pageIndex();
        goto xzkZ8;
        ojXl5:
        $discount = Util::getAllDataInSingleTable(DISCOUNT, $where, $page, $num);
        goto uhG3n;
        E8rmi: global $_GPC, $_W;
        goto g3iY2;
        xzkZ8:
        $num = reqInfo::num();
        goto ZS0p3;
        uhG3n:
        return $this->successResult($discount[0]);
        goto Q1Qgf;
        Q1Qgf:
    }

    public function doPagePay()
    {
        goto RdqN9;
        WOW5m:
        $_W["openid"] = $openid = $this->getUserBySeid();
        goto OzGP_;
        U3kNj:
        if ($BELA6) {
            goto o6rsr;
        }
        goto dLTR0;
        xDLfg:
        $BELA6 = !is_error($pay_params);
        goto U3kNj;
        GzkbL:
        $pay_params = $this->pay($order);
        goto xDLfg;
        yzNaN: o6rsr:
        goto kd0PA;
        RdqN9: global $_GPC, $_W;
        goto WOW5m;
        OzGP_:
        $order = array("tid" => $_GPC["ordersn"], "user" => $openid, "fee" => floatval($_GPC["sum"]), "title" => $_W["account"]["name"] . "æ¯ä»");
        goto GzkbL;
        kd0PA:
        return $this->result(0, '', $pay_params);
        goto dUZbN;
        dLTR0:
        return $this->result(1, $pay_params, $_W["openid"]);
        goto yzNaN;
        dUZbN:
    }

    public function payResult($params)
    {
        goto ERfIz;
        pySFS:
        $PayResult->payresult_dis($params, 1);
        goto q6KlA;
        tMFi2:
        $PayResult->payresult_info($params, $paydetail, $logtag, 1, $acid);
        goto DE0Ko;
        ERfIz: global $_W, $_GPC;
        goto SzuFS;
        pOiYs: HsgdD:
        goto HaW16;
        sXALJ:
        if ($ordersnlen == 20) {
            goto T08sz;
        }
        goto UTjFP;
        QynHE: WGzXt:
        goto pySFS;
        JUXdi:
        $log = Util::getSingelDataInSingleTable("core_paylog", array("module" => "yc_youliao", "tid" => $params["tid"]));
        goto RQxk3;
        DE0Ko:
        goto d1_Ts;
        goto q0vmb;
        q0vmb: T08sz:
        goto aJ3EU;
        WUtbq: ET5Xm:
        goto ca1eh;
        HaW16:
        $order = Util::getSingelDataInSingleTable(ORDER, array("ordersn" => $id));
        goto ycoZW;
        etrse:
        goto d1_Ts;
        goto IndMG;
        q6KlA: d1_Ts:
        goto WUtbq;
        WT_LV:
        if ($Q5VlG) {
            goto HsgdD;
        }
        goto za3a0;
        fdUNd:
        if ($EtKxm) {
            goto ET5Xm;
        }
        goto b42t3;
        SzuFS:
        $acid = $this->getUniacid();
        goto i7QKq;
        fAe5N:
        $PayResult->payresult_order($params, $order, 1, $acid);
        goto etrse;
        aJ3EU:
        $PayResult->payresult_zd($params, $paydetail, $logtag, 1, $acid);
        goto JxZKd;
        RQxk3:
        $paydetail = $log["tag"];
        goto Y28My;
        JxZKd:
        goto d1_Ts;
        goto QynHE;
        za3a0:
        return;
        goto pOiYs;
        IndMG: COYYU:
        goto tMFi2;
        UTjFP:
        if (strstr($id, "dis")) {
            goto WGzXt;
        }
        goto fAe5N;
        rP8j6:
        $checkReq = $PayResult->checkReq($params);
        goto qmT97;
        b42t3:
        if ($ordersnlen == 15) {
            goto COYYU;
        }
        goto sXALJ;
        VypC6:
        $ordersnlen = strlen($params["tid"]);
        goto xFjGL;
        qmT97:
        $Q5VlG = !($checkReq == 0);
        goto WT_LV;
        ycoZW:
        $EtKxm = !($params["result"] == "success" && $params["from"] == "notify");
        goto fdUNd;
        Y28My:
        $logtag = unserialize($log["tag"]);
        goto rP8j6;
        xFjGL:
        $PayResult = new PayResult();
        goto JUXdi;
        i7QKq:
        $id = $params["tid"];
        goto VypC6;
        ca1eh:
    }
}