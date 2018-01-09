<?php
//checkauth();
global $_GPC,$_W;
$cfg=$this->module['config'];
$de=$cfg['credit2money'];
if (empty($de)) {
    $de = 0.1;
}

$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$userinfo = Member::initUserInfo(); //用户信息
$credits = commonGetData::getUserCredit(getOpenid);
$id = intval($_GPC['id']);
$shop_id = intval($_GPC['shop_id']);
$goods =Goods::getSingleGood($id,$shop_id);
$shop=  Shop::getShopInfoAll($shop_id);
if($shop['endtime']<TIMESTAMP){
    message('店铺已到期');
}
$piclist = array(array("attachment" => $goods['thumb']));
if ($goods['thumb_url'] != 'N;') {
    $urls = unserialize($goods['thumb_url']);
    if (is_array($urls)) {
        $piclist = array_merge($piclist, $urls);
    }
}

$title=$goods['title'].'--'.$shop['shop_name'];
$from_user=$this->getOpenid();
//分享
$share_img    = !empty($goods['share_img']) ? $_W['attachurl'].$goods['share_img'] :$_W['attachurl'].$cfg['share_img'];
$share_info=!empty($goods['share_info']) ? $goods['share_info'] :$cfg['share_info'];
$share_title=!empty($goods['share_title']) ? $goods['share_title'] :$cfg['share_title'];
$share_link=$_W['siteroot']."app/".$this->createMobileUrl('good',array('id' => $id,'shop_id' => $shop_id));
//评价

$comment_list=pdo_fetchall("select c.*,g.nickname,g.avatar from ".tablename(COMMENT)." c left join ".tablename(MEMBER)." g on g.id=c.mid where c.goods_id=".$id." and c.uniacid =".$_W['uniacid']." order by c.addtime desc");
$comment_count=count($comment_list);


//收藏
$data['shop_id']=$shop_id;
$data['type']=2;
$data['openid']=$from_user;
$data['goods_id']=$id;
$collect=util::getSingelDataInSingleTable(COLLECT,$data,'id','2');
//多规格
$allspecs =util::getAllDataBySingleTable(SPEC,array('goodsid'=>$id), 'displayorder asc');
foreach ($allspecs as &$s) {
    $s['items'] = util::getAllDataBySingleTable(S_ITEM, array('specid' => $s['id'], 'show' => 1), 'displayorder asc');
}
unset($s);

$options = util::getAllDataBySingleTable(OPTION,array('goodsid' =>$id),'id asc');
$specs = array();
if (count($options) > 0) {
    $specitemids = explode("_", $options[0]['specs']);
    foreach ($specitemids as $itemid) {
        foreach ($allspecs as $ss) {
            $items = $ss['items'];
            foreach ($items as $it) {
                if ($it['id'] == $itemid) {
                    $specs[] = $ss;
                    break;
                }
            }
        }
    }
}

$params = util::getAllDataBySingleTable(PARAM,array('goodsid' =>$id),'displayorder asc');
//拼团
if($shop['is_group']==1 && $goods['is_group']==1) {
    $is_group = 1;
    $groupid=$_GPC['groupid'];
    $where = array('uniacid'=>$_W['uniacid'],'gid'=>$id,'status'=>1,'overtime>'=>time());
    $select = ' a.id,a.lastnumber,a.overtime,b.nickname,b.avatar ';
    $data = Group::getLatelyGroup($where,'',1,3,$select,' a.`id` DESC ',false);
    $group = $data[0];
    $groupsz = pdo_fetch("SELECT count(*) as num FROM " . tablename(GROUP) . " WHERE gid = :id and uniacid = :uniacid", array(':id' => $id,':uniacid'=>$_W['uniacid']));
}
//秒杀
if($shop['is_time']==1 && $goods['is_time']==1 ){
    $is_time=1;
    $ms_status=Array();
    $ms_status=Goods::ms_status($goods);
    $goods['timeend']= $ms_status['timeend'];
    $goods['timestart']= $ms_status['timestart'];
    //是否秒杀中
    $times_flag=$ms_status['times_flag'];
    //将今天的日期加上指定的时间变成时间
    $date1=date("Y-m-d",time());
    $changedate=strtotime($date1.' '.$goods['timeend'].":00:00");
    $arr = util::time_tran($changedate);
    $goods['timelaststr'] = $arr[0];
    $goods['timelast'] = $arr[1];

}

include $this->template('../mobile/good');
exit();