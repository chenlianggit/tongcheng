<?php

class commonGetData
{

    static function getChannel($type=1,$flag=1){//type=1图片不需要转换，$flag=1不需要云除外链的频道
        global $_W;
        $condition='';
        if($flag==2){
            $condition=" and autourl='' ";
        }
        $modulelist = pdo_fetchall("SELECT * FROM " . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND fid = 0 and ison=1 {$condition} ORDER BY displayorder ASC");
        foreach ($modulelist as $k => $v) {
            $modulelist[$k]['children'] = pdo_fetchall("SELECT id,name FROM " . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND fid = {$v['id']} ORDER BY displayorder ASC");
            if($type==2){
                $modulelist[$k]['thumb'] = tomedia($v['thumb']);
            }
        }
        return $modulelist;
    }
    static function proFoot($uid,$type,$id,$name){
        global $_W;
        $foot=self::getFoot($uid);
        $footdata = array(
        'type'=>$type,
        'id'=>$id,
        'name'=>$name,
        );
        if($foot['content']){//更新
            //更新浏览记录,查看现有多少条记录
            $content=$foot['content'];
            $total=count($content);
            if($total==5){//只存5条记录，大于5条的把最后一条替换掉
                $content[0]['type']=$type;
                $content[0]['id']=$id;
                $content[0]['name']=$name;
            }else{//小于5条追加
                array_unshift($content,$footdata);//数据放在前面
            }
            $s = array();
            foreach ($content as $key =>$v){
                $s[$v['id']] = $v;
            }

            pdo_update(FOOT,array('content'=>json_encode($s)),array('uid'=>$uid,'uniacid'=>$_W['uniacid']));
        }else{//插入
            $inserData=array(
                'uid'=>$uid,
                'uniacid'=>$_W['uniacid'],
                'content'=> json_encode(array($id => $footdata)),
            );
            pdo_insert(FOOT,$inserData);
        }
        //更新，重查
        $res=self::getFoot($uid);
        return $res['content'];
    }
    static function getFoot($uid){
        if(intval($uid)==0){
          return;
        }
        $foot=util::getSingelDataInSingleTable(FOOT,array('uid'=>$uid));
        $foot['content'] =json_decode($foot['content'],1);
        return $foot;
    }

    static function getAdv($type){
        global $_W;
        $advs      = pdo_fetchall("select * from " . tablename(ADV) . " where enabled=1 and uniacid= '{$_W['uniacid']}'  order by displayorder asc");
        $xsms= array();
        foreach ($advs as &$adv) {
            if (substr($adv['link'], 0, 5) != 'http:') {
                $adv['link'] = $adv['link'];
            }
             $adv['type']=json_decode($adv['type']);
            if (in_array($type,(array)$adv['type'])){
                   $xsms[] =$adv;
          }

        }
        unset($adv);
        return $xsms;

    }
    static function getAdv1($type){
     return '1';
    }

    static function getmiaosha($id='',$page='',$num='',$joinCity,$codition,$today,$mody){
    global $_GPC,$_W;
     $pageStart = $page * $num+1;
     if($page){
     $limit=" limit {$pageStart},{$num} ";
     }
      if($id>0){
          $whereid=" AND g.time_id=".$id;
      }
     $xsms = pdo_fetchall(" SELECT g.*,s.shop_name,m.timestart,m.timeend FROM " . tablename(GOODS) . " g
    left join " . tablename(MSTIME) . " m on g.time_id =m.time_id and g.uniacid =m.uniacid {$joinCity} WHERE g.uniacid =:uniacid {$codition} AND g.status=0  AND g.is_time=1 AND g.datestart <=:today AND  g.datestart < :mody AND  g.dateend >= :today and g.time_num>0 {$whereid} ORDER BY m.time_id {$limit} ", array(':uniacid' => $_W['uniacid'], ':today' => $today, ':mody' => $mody));

        return $xsms;
    }

//给数组排序
    static function listSort($arr,$where){
     $flag=array();
     foreach($arr as $arr2){
         $flag[]=$arr2[$where];
         }
     array_multisort($flag, SORT_ASC, $arr);
  return  $arr;

    }

static function getUserCredit($openid){
		global $_W;
		return array('credit1'=> $_W['member']['credit1'],'credit2'=>$_W['member']['credit2']);
	}
    static function getUserCreditList($openid){
        $where['openid']=$openid;
        $list=util::getSingelDataInSingleTable('mc_mapping_fans',$where,'uid');
        $where2['uid']= $list['uid'];
        $data=util::getSingelDataInSingleTable('mc_members',$where2,'credit1,credit2');
        return $data;
    }

    static function getRingNum($condition)
    {
        global $_W;
        $num = pdo_fetchcolumn("SELECT count(*)as num FROM " . tablename(RING) . " r left join " . tablename(MEMBER) . " u on r.openid=u.openid and r.uniacid = u.uniacid WHERE  r.uniacid = '{$_W['uniacid']}' {$condition} ");
        return $num;
    }
static function getRing($type=1,$condition,$pageStart,$num,$replaycondition='',$isadmin=''){
global $_W;
 $item = pdo_fetchall("SELECT r.*,u.avatar,u.nickname FROM " . tablename(RING) . " r left join " . tablename(MEMBER) . " u on r.openid=u.openid and r.uniacid = u.uniacid WHERE  r.uniacid = '{$_W['uniacid']}' {$condition} ORDER BY  r.addtime DESC  limit {$pageStart},{$num}  ");

    $list = Array();
    foreach ($item as $k => $arr) {
        $arr['distance'] = util::getDistance($arr['lat'], $arr['lng'], $_COOKIE['lat'], $_COOKIE['lng']);
        $arr['xsthumb'] = json_decode($arr['xsthumb']);

            foreach ((array)$arr['xsthumb'] as $a => $b) {
                if($b){
                    $arr['xsthumb'] [$a] = tomedia($b);
                }

            }

        if($arr['openid']==$_W['openid']){
            $arr['isme']=1;
        }
        if($isadmin!=''){
            $arr['isadmin']=1;
        }

        $list[] = $arr;
    }
 if($type>=1){

      foreach ($list as $k => $arr) {
      //1赞 2评论
      $sql="SELECT u.avatar,u.nickname,u.openid,z.info,z.addtime FROM " . tablename(ZAN) . " z  left join " . tablename(MEMBER) . " u on z.openid=u.openid  and z.uniacid = u.uniacid WHERE  z.uniacid =:uniacid and z.ring_id=:ring_id ".$replaycondition;
      $sql1=$sql.' and z.zan_type =1 order by z.addtime desc ';
      $sql2=$sql.' and z.zan_type =2 order by z.addtime desc ';
      $sql3=$sql.' and z.zan_type =3 order by z.addtime desc ';
      $zan = pdo_fetchall($sql1,array(':uniacid'=>$_W['uniacid'],':ring_id'=>$arr['ring_id']));
      $ping = pdo_fetchall($sql2,array(':uniacid'=>$_W['uniacid'],':ring_id'=>$arr['ring_id']));
      $guanzhu = pdo_fetchall($sql3,array(':uniacid'=>$_W['uniacid'],':ring_id'=>$arr['ring_id']));

       foreach ($zan as $e => $z) {
        if($z['openid']==$_W['openid']){
             $zan[$e]['iszan']=1;
             }
       }

          foreach ($ping as $a => $b) {
              if($b['openid']==$_W['openid']){
                  $ping[$a]['isping']=1;
              }
          }

       $list[$k]['znum']=count($zan);
       $list[$k]['pnum']=count($ping);
       if( $list[$k]['znum']>0){
        $list[$k]['z'][] = $zan;
       }
     if( $list[$k]['pnum']>0){
             $list[$k]['p'][] = $ping;
            }

     foreach ($guanzhu as $g => $d) {
       if($d['openid']==$_W['openid']){
             $list[$k]['guanzhu']=1;
            }
      }

}
    if($type==2){
        $guan=Array();
       foreach ($list as $l => $q) {
             if($q['guanzhu']==1){
                  $guan[]=$q;
                  }
            }
            return  $guan;
      }
 return $list;
 }
 return  $list;
 }



static function insertlog($params,$uniacid=''){
    if(empty($uniacid)){
        global $_W;
        $uniacid  =$_W['uniacid'];
    }
 $log = pdo_get('core_paylog', array('uniacid' => $uniacid, 'module' => 'yc_youliao', 'tid' => $params['tid']));
    if (empty($log)) {
        $log = array(
            'uniacid' => $uniacid,
            'type' => $params['type'],
            'acid' => $_W['acid'],
            'openid' => $params['user'],
            'module' => 'yc_youliao',
            'tid' => $params['tid'],
            'fee' => $params['fee'],
            'card_fee' => $params['fee'],
            'status' => '0',
            'is_usecard' => '0',
            'tag' =>  $params['title'],
        );
       $result= pdo_insert('core_paylog', $log);
       if (!empty($result)) {
       	return 1;
       }

    }




}


static function getNowmoney($v,$paynum){
    if($v['cardtype']==1){
            $nowmoney=$paynum-$v['cardvalue'];
        }elseif($v['cardtype']==2){
            $nowmoney=$paynum*$v['cardvalue'];
        }elseif($v['cardtype']==3){
            $rand=util::randomFloat(0.01,$v['randomnum']);//根据最小0.01，最大的随机数，随机获取减额度
           $nowmoney=$paynum-$rand;
            setcookie($v['id'], $nowmoney, time() + 3600 * 24 * 7);
        }
        return $nowmoney;

}


static function getDiscountInfo($id){
global $_W;
$id=intval($id);
$codition=' and r.id = '.$id;
 $list=pdo_fetch("select r.*,d.* ,r.shop_id as shop_id from " . tablename(DISCOUNT_RE) . " r left join " . tablename(DISCOUNT) . " d on r.discount_id=d.id and r.uniacid=d.uniacid  where  r.uniacid=:uniacid" .$codition,array(':uniacid' => $_W['uniacid']) );
 return $list;
}

static function getDiscount($page,$num,$mid,$sqlwhere='',$status=''){
global $_W;
$where= "";
$leftjoin=  "";
if(!empty($mid)){
    $select="SELECT * " ;
    $where= " AND r.mid=".$mid;
}else{
    $select="SELECT r.*, s.*,m.nickname,m.avatar,r.status as status,s.status as shop_status" ;
    $leftjoin=  " left join ".tablename(MEMBER)." as m on m.id=r.mid ";
    $where=  $sqlwhere;
}
if($status==''){
    $where .=' AND r.status =1 ';
    }
  $sql=' from '.tablename(DISCOUNT_RE)." as r left join ".tablename(SHOP)." as s on r.shop_id=s.shop_id and r.uniacid=s.uniacid ".$leftjoin." WHERE  r.uniacid =".$_W['uniacid'].$where."   ORDER BY r.createtime DESC ";

 $countStr =pdo_fetchcolumn("SELECT COUNT(*) " .$sql);
$selectStr=pdo_fetchall($select .$sql. " LIMIT " . $page * $num . "," . $num);
 return array($selectStr,$countStr);
}

static function getchat($userinfo_id,$all='0',$order='DESC'){
global $_W;
$sql='SELECT * FROM ' . tablename(CHAT) . " WHERE  (user1 = '{$userinfo_id}' or user2 = '{$userinfo_id}') AND  deleteid <> {$userinfo_id} AND weid = {$_W['uniacid']} ORDER BY time ";
if($all=='0'){
$chat_list=pdo_fetch($sql.$order.' limit 1');
}else{
$chat_list=pdo_fetchall($sql.$order);
}
 return $chat_list;
}

static function getArea($city_id=''){
    global $_W;
    if( !empty($city_id) && $city_id !=0){
        $condition=" and city_id=".$city_id;
    }
    $area = pdo_fetchall(" SELECT * FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}' {$condition} and (parent_id =0 or parent_id is null) ORDER BY  orderby asc");
    return $area;
}


static function chathtml($chatcon,$openid){
    if (empty($chatcon)) return;
    $html='';
    foreach ($chatcon as $k => $v) {
        if ($v['openid'] == $openid) {
            $messageclass = 'message me';
            $bubble = 'bubble bubble_primary right';
        } else {
            $messageclass = 'message';
            $bubble = 'bubble bubble_default left';
        }
        $author_name = $v['nickname'];
        $imgsrc = $v['avatar'];
        $html .= '<div class="clearfix slideInUp">' . '<div class="' . $messageclass . '">' . '<div class="avatar" data-author-id="me"><img src="' . $imgsrc . '" /></div>' . '<div class="content"><p class="author_name"> ' . $author_name . '<time style="font-size:0.7rem;margin-left:0.5rem;">' . date('Y-m-d H:i:s', $v['time']) . '</time></p>' . '<div class="' . $bubble . '">'  ;
        if($v['flag']==1){//0文字 1图片 2语音
            $html .=  '<div class="chat-img"><img src="'  . tomedia($v['content']) . '" /></div>' ;
        }elseif($v['flag']==2){//0文字 1图片 2语音
            $html .=  '<div class="chat-img"><img src="'  . tomedia($v['content']) . '" /></div>' ;
        }else{
            $html .=  ' <div class="bubble_cont"><div class="plain"><p>' . $v['content'] . '</p>' . '</div></div>' ;
        }
        $html .=   '</div>' . '</div>' . '</div>' . '</div>';
    }
    return $html;
}

    static function getShop_apply($pageStart,$num,$sqlwhere=''){
        global $_W;
        $limit=" limit {$pageStart},{$num} ";
        $a="SELECT s.*, c.cate_name,a.area_name,p.applytime,p.f_type  " ;
        $b="SELECT count(*) as num  " ;
        $sql = " FROM " . tablename(SHOP_APPLY) . " p left join ".tablename(SHOP) ." s on p.shop_id=s.shop_id and s.uniacid=p.uniacid  left join ".tablename(CATE) ." c on s.ccate_id=c.cate_id and s.uniacid=c.uniacid left join ".
            tablename(AREA) ." a on a.area_id=s.area_id and s.uniacid=a.uniacid WHERE s.uniacid = '{$_W['uniacid']}'  {$sqlwhere} ORDER BY  s.orderby DESC ";
        $list = pdo_fetchall($a.$sql.$limit);
        $num = pdo_fetch($b.$sql);
        foreach ($list as $k => $v) {
            $list[$k]['logo']=tomedia($v['logo']);
        }
        return Array($list,$num['num']);
    }

    static function getShop($codition,$page='',$num='',$isneedpage='1'){
        global $_W;
        if($isneedpage=='2'){
            $limit=" limit {$page},{$num} ";
        }

        $list = pdo_fetchall("SELECT s.*, c.cate_name,a.area_name FROM " . tablename(SHOP) . " s left join ".tablename(CATE) ." c on s.ccate_id=c.cate_id and s.uniacid=c.uniacid left join ".
            tablename(AREA) ." a on a.area_id=s.area_id and s.uniacid=a.uniacid WHERE s.uniacid = '{$_W['uniacid']}' {$codition} ORDER BY shop_id desc,  s.orderby DESC".$limit);
        foreach ($list as $k => $v) {
            $list[$k]['logo']=tomedia($v['logo']);
        }
        return $list;
    }
    static function gettpl($id){
        if(empty($id))return;
        $where['tplbh'] =$id;
        $item = util::getSingelDataInSingleTable(TPL, $where,'tpl_id');
        return $item;
    }

    static function getHotMsg($info_condition,$shownum= 10,$lat='',$lng=''){
        global $_W;
        $hotmessagelist = pdo_fetchall('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} AND isneedpay = 1 AND haspay > 0 AND status = 1 AND (isneedpay=0 or (isneedpay=1 and haspay=1)) {$info_condition} ORDER BY views DESC LIMIT {$shownum}");
        foreach ($hotmessagelist as $k => $v) {
            if($lat && $lng && $v['lat'] && $v['lng']){
                $hotmessagelist[$k]['distance'] = util::getDistance($v['lat'], $v['lng'], $lat, $lng);
            }
            $module = pdo_fetch('SELECT name FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND id = {$v['mid']}");
            $hotmessagelist[$k]['con'] = unserialize($v['content']);
            $hotmessagelist[$k]['modulename'] = $module['name'];
            $hotmessagelist[$k]['createtime'] = date("Y-m-d H:i",$v['createtime']);
            if($v['freshtime']){
                $hotmessagelist[$k]['freshtime'] = date("Y-m-d H:i",$v['freshtime']);
            }
            $hotmessagelist[$k]['con']['thumbs']= self::tomediaImg($hotmessagelist[$k]['con']['thumbs']);
        }
        return $hotmessagelist;
    }

    static function getNewMsg($info_condition,$shownum= 10,$lat='',$lng=''){
        global $_W;
        $lastedmessagelist = pdo_fetchall('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} {$info_condition} AND status = 1 AND (isneedpay=0 or (isneedpay=1 and haspay=1)) ORDER BY freshtime DESC LIMIT {$shownum}");
        foreach ($lastedmessagelist as $k => $v) {
            $lastedmessagelist[$k]['distance'] = util::getDistance($v['lat'], $v['lng'], $lat, $lng);
            $module = pdo_fetch('SELECT name FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND id = {$v['mid']}");
            $lastedmessagelist[$k]['con'] = unserialize($v['content']);
            $lastedmessagelist[$k]['createtime'] = date("Y-m-d H:i",$v['createtime']);
            if($v['freshtime']) {
                $lastedmessagelist[$k]['freshtime'] = date("Y-m-d H:i", $v['freshtime']);
            }
            $lastedmessagelist[$k]['modulename'] = $module['name'];
            $lastedmessagelist[$k]['con']['thumbs']= self::tomediaImg($lastedmessagelist[$k]['con']['thumbs']);
        }
        return $lastedmessagelist;
    }

    static function getTopMsg($info_condition,$shownum= 10,$lat='',$lng=''){
        global $_W;
        $zdmessagelist = pdo_fetchall('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} AND isding = 1 AND status = 1 AND (isneedpay=0 or (isneedpay=1 and haspay=1)) {$info_condition} ORDER BY dingtime DESC LIMIT {$shownum}");
        foreach ($zdmessagelist as $k => $v) {
            $zdmessagelist[$k]['distance'] = util::getDistance($v['lat'], $v['lng'], $lat, $lng);
            $module = pdo_fetch('SELECT name FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND id = {$v['mid']}");
            $zdmessagelist[$k]['con'] = unserialize($v['content']);
            $zdmessagelist[$k]['modulename'] = $module['name'];
            if($v['freshtime']) {
                $zdmessagelist[$k]['freshtime'] = date("Y-m-d H:i", $v['freshtime']);
            }
            $zdmessagelist[$k]['con']['thumbs']= self::tomediaImg($zdmessagelist[$k]['con']['thumbs']);
            $zdmessagelist[$k]['createtime'] = date("Y-m-d H:i",$v['createtime']);
        }
        return $zdmessagelist;
    }
    static function tomediaImg($img){
        if($img){
            $imgData=array();
            foreach ($img as $a => $b) {
                $imgData[$a] = tomedia($b);
            }
            return $imgData;
        }

    }
    static function getMsgById($id,$page,$num,$city='',$lat='',$lng='',$where='',$fid=0){
        global $_W;
        $info_condition='';
        $id=intval($id);
        if($id>0 && $fid>0 ){
            $info_condition.=" and (mid=".$id." or fmid=".$fid.") ";
        } elseif($id>0 ){
            $info_condition.=" and mid=".$id;
        }
        if($city!=''){
            $info_condition.=" and city like '%".$city."%' ";
        }

        $messagelist = pdo_fetchall('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$_W['uniacid']} AND (isneedpay=0 or (isneedpay=1 and haspay=1)) AND status = 1 {$info_condition} {$where} ORDER BY isding DESC,dingtime DESC,freshtime DESC LIMIT  {$page},{$num} ");
        //if(empty($messagelist))return;
        foreach ($messagelist as $k => $v) {
            if($lat && $lng && $v['lat'] && $v['lng']){
                $messagelist[$k]['distance'] = util::getDistance($v['lat'], $v['lng'], $lat, $lng);
            }
            $module = pdo_fetch('SELECT * FROM ' . tablename(CHANNEL) . " WHERE weid = {$_W['uniacid']} AND id = {$v['mid']} ");
            $messagelist[$k]['con'] = unserialize($v['content']);
            $messagelist[$k]['modulename'] = $module['name'];
            $messagelist[$k]['createtime'] = date("Y-m-d H:i",$v['createtime']);
            if($v['freshtime']){
                $messagelist[$k]['freshtime'] = date("Y-m-d H:i",$v['freshtime']);
            }

            $messagelist[$k]['con']['thumbs']= self::tomediaImg($messagelist[$k]['con']['thumbs']);
        }

        return $messagelist;
    }
    static function getInfoById($id,$uniacid){
        $where['id']=intval($id);
        $where['status']=1;
        $message = pdo_fetch('SELECT * FROM ' . tablename(INFO) . " WHERE weid = {$uniacid} AND id = {$id} ");
        return $message;
    }
    static function getAccountDetail($id,$status_sql=''){
        global $_W;
        $data=pdo_fetch('SELECT a.*,s.shop_name,s.logo FROM ' . tablename(ACCOUNT) . "a left join  " . tablename(SHOP) . " s on a.shop_id=s.shop_id  WHERE a.uniacid = {$_W['uniacid']} {$status_sql} and a.cash_id={$id}    ");
        if(intval($data['shop_id'])>0){
            $userdata = commonGetData::getAdminnameByid($data['admin_id']);
        }else{
            $userdata = MEMBER::getMemberByopenid($data['openid'])  ;
        }
        $data['nickname'] = $userdata['nickname'];
        $data['avatar'] = $userdata['avatar'];
        if($data['check_admin']){//获取处理人信息
            $userdata = commonGetData::getAdminnameByid($data['check_admin'],ADMIN);
            $data['check_nickname'] = $userdata['nickname'];
            $data['check_avatar'] = $userdata['avatar'];
        }
        return $data;
    }
    static function getAdminnameByid($admin_id,$tablename=SHOP_ADMIN){
        $admin_where['admin_id'] =$admin_id;
        $a_data = util::getSingelDataInSingleTable($tablename, $admin_where, 'openid');
        $member_where['openid']=$a_data['openid'];
        $a_data = util::getSingelDataInSingleTable(MEMBER, $member_where, 'nickname,avatar');
        return $a_data;
    }
    static function getAdminByid($admin_id){
        $admin_where['admin_id'] =$admin_id;
        $a_data = util::getSingelDataInSingleTable(ADMIN, $admin_where, '*');
        return $a_data;
    }
    static function getfield($mid){
        global $_W;
        $mid=intval($mid);
        $fieldslist = pdo_fetchall('SELECT * FROM ' . tablename(FIELDS) . " WHERE mid = {$mid} AND weid = {$_W['uniacid']} ORDER BY displayorder ASC");

        return  $fieldslist;
    }
    static function getfield_arr($mid,$uniacid){
        $mid=intval($mid);
        $fieldslist = pdo_fetchall('SELECT * FROM ' . tablename(FIELDS) . " WHERE mid = {$mid} AND weid = {$uniacid} ORDER BY displayorder ASC");
        foreach ($fieldslist as $k => $v) {
            if (!empty($v['mtypecon'])) {
                $fieldslist[$k]['mtypeconarr'] = explode("|", $v['mtypecon']);
            } else {
                $fieldslist[$k]['mtypeconarr'] = '';
            }
        }
        return  $fieldslist;
    }
    static function sensitiveword($type=0)
    {
        global $_W;
        $word=pdo_fetch("SELECT * FROM " . tablename(WORD) . " WHERE uniacid = {$_W['uniacid']} and type={$type} limit 1 ");
        return $word;
    }
    static function getShopCfg($shop_id)
    {
        global $_W;
        $shop_id=intval($shop_id);
        $data=pdo_fetch("SELECT * FROM " . tablename(CFG) . " WHERE uniacid = {$_W['uniacid']} and shop_id={$shop_id} limit 1 ");
        $item=$data['cfg'];
        return unserialize($item);
    }

    static function guolv($content)
    {//过滤敏感字
        $word =self::sensitiveword();
        if (!empty($word)) {
            $sensitivewordarr = explode('|', $word['sensitiveword']);
            if(!empty($word['replace'])){
                $replace=  $word['replace'];
            }else{
                $replace='**';
            }
            $content = str_replace($sensitivewordarr, $replace, $content);
        }
        return $content;
    }

}

