<?php
global $_W, $_GPC;
$title="信息管理";
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	if (!empty($_GPC['akid'])) {
		if($_GPC['allsh'] == 'allsh'){
			foreach ($_GPC['akid'] as $id => $akid) {
				pdo_update(INFO, array('status' => 1), array('id' => $id, 'weid' => $_W['uniacid']));
			}
			$this->message('信息审核成功！', $this->createWebUrl('info', array('op' => 'display')), 'success');
		}
		if($_GPC['alldel'] == 'alldel'){
			foreach ($_GPC['akid'] as $id => $akid) {
				pdo_delete(INFO, array('id' => $id, 'weid' => $_W['uniacid']));
			}
			$this->message('信息删除成功！', $this->createWebUrl('info', array('op' => 'display')), 'success');
		}
	}
	$condition = "weid = {$_W['uniacid']}";
	if (!empty($_GPC['keyword'])) {
		$condition .= " AND content LIKE '%{$_GPC['keyword']}%'";
	}
	if(!empty($_GPC['mid'])){
		$condition .= " AND mid = '{$_GPC['mid']}'";
	}
    $page = $this->getPage();
    $pageindex = $this->getWebPage();
    $num = $this->getNum(); //每次取值的个数
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(INFO)." WHERE ".$condition);
	$limit = ' LIMIT ' . $pageindex . ',' . $num;
	$list = pdo_fetchall("SELECT * FROM ".tablename(INFO)." WHERE ".$condition." ORDER BY createtime DESC ".$limit);
	foreach($list as $k=>$v){
		$list[$k]['fieldlist'] = unserialize($v['content']);
	}
	$modulecenterlist = pdo_fetchall("SELECT id,name FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} AND fid = 0 ORDER BY displayorder ASC");
	foreach($modulecenterlist as $k=>$v){
		$modulecenterlist[$k]['children'] = pdo_fetchall("SELECT id,name FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} AND fid = {$v['id']} ORDER BY displayorder ASC");
	}
	$pager = pagination($total, $page,$num);
}elseif ($operation == 'zhiding') {
	$id = intval($_GPC['id']);
	$isding = intval($_GPC['isding']);
	if($isding == 1){
		$dingtime = strtotime($_GPC['dingtime']);
	}else{
		$dingtime = 0;
	}
	$res = pdo_update(INFO,array('isding'=>$isding,'dingtime'=>$dingtime),array('id'=>$id,'weid'=>$_W['uniacid']));
	if($res){
		$this->message('置顶成功！', $this->createWebUrl('info', array('op' => 'display')), 'success');
	}else{
		$this->message('置顶失败！');
	}
}elseif ($operation == 'post') {
	$id = intval($_GPC['id']);
	if(!empty($id)){
        $message = pdo_fetch("SELECT * FROM ".tablename(INFO)." WHERE id = {$id} AND weid= {$_W['uniacid']}");
        $content = unserialize($message['content']);
		$fieldslist = pdo_fetchall("SELECT * FROM ".tablename(FIELDS)." WHERE mid = {$message['mid']} AND weid = {$_W['uniacid']} ORDER BY displayorder ASC");
		foreach($fieldslist as $k=>$v){
			if(!empty($v['mtypecon'])){
				$fieldslist[$k]['mtypeconarr'] = explode("|",$v['mtypecon']);
			}else{
				$fieldslist[$k]['mtypeconarr'] = '';
			}
		}
	}
	$modulelist = pdo_fetchall("SELECT id,name FROM ".tablename(CHANNEL)." WHERE canrelease = 1 AND weid = {$_W['uniacid']} AND fid = 0 ORDER BY displayorder ASC");
	foreach($modulelist as $k=>$v){
		$modulelist[$k]['children'] = pdo_fetchall("SELECT id,name FROM ".tablename(CHANNEL)." WHERE canrelease = 1 AND weid = {$_W['uniacid']} AND fid = {$v['id']} ORDER BY displayorder ASC");
	}
	$memberlist = pdo_fetchall("SELECT * FROM ".tablename(MEMBER)." WHERE uniacid = {$_W['uniacid']} ORDER BY id DESC");

    $city = pdo_fetchall(" SELECT * FROM " . tablename(CITY) . " WHERE  uniacid = '{$_W['uniacid']}' ORDER BY  orderby asc");
    $area = pdo_fetchall(" SELECT * FROM " . tablename(AREA) . " WHERE  uniacid = '{$_W['uniacid']}'  and (parent_id =0 or parent_id is null) ORDER BY  orderby asc");
//	AND type = 1
}elseif ($operation == 'dopost') {
	$id = intval($_GPC['id']);
	$mid = intval($_GPC['mid']);
	if($mid == 0){
		$this->message("请先选择模型！");
	}
	$moduleres = pdo_fetch("SELECT fid FROM ".tablename(CHANNEL)." WHERE id = {$mid} AND weid = {$_W['uniacid']}");
	$openid = trim($_GPC['openid']);
	if(empty($openid)){
		$this->message("请先选择发布人！");
	}
	if (!empty($id)) {
		$message = pdo_fetch("SELECT * FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND id = {$id}");
	}
	$fieldslist = pdo_fetchall("SELECT * FROM ".tablename(FIELDS)." WHERE mid = {$mid} AND weid = {$_W['uniacid']} ORDER BY displayorder ASC");
	foreach($fieldslist as $k=>$v){
        $fieldname = $_GPC[$v['enname']];
        if( is_array( $fieldname ) )$fieldname =implode(" ",$fieldname);
        $fieldnamelen = mb_strlen($fieldname,'utf-8');
        if(!empty($fieldname)){
            $fieldnamelen = strlen($fieldname);
            if($v['islenval'] == 1){
                if($fieldnamelen < $v['minlen'] || $fieldnamelen > $v['maxlen']){
                    $this->message($v['name']."字符长度应该在".$v['minlen']."字符到".$v['maxlen']."字符之间，当前字符长度".$fieldnamelen);
                }
            }
        }


		if($v['isrequired'] == 1){
			if(empty($fieldname)){
				$this->message("请填写".$v['name']);
			}
		}
		if($v['mtype'] == 'telphone'){
			if(!$this->isMobile($fieldname)){
				$this->message('请填写正确的手机号码');
			}
		}
		if($v['mtype'] == 'idcard'){
			if(!$this->isCreditNo($fieldname)){
				$this->message('请填写正确的身份证号');
			}
		}
	}
	$data['status'] = intval($_GPC['status']);
	$memberres = pdo_fetch("SELECT * FROM ".tablename(MEMBER)." WHERE uniacid = {$_W['uniacid']} AND openid = '{$openid}'");
	$data['nickname'] = $memberres['nickname'];
	$data['avatar'] = $memberres['avatar'];
	$data['weid'] = $_W['uniacid'];
	$data['openid'] = $openid;
	$data['mid'] = $mid;
	$data['fmid'] = $moduleres['fid'];
	//$data['province'] = trim($_GPC['area']['province']);
	$lat=trim($_GPC['lat']);
    $lng=trim($_GPC['lng']);
    $data['lng'] =$lng ;
    $data['lat'] =$lat;
    $data['views'] =intval($_GPC['views']);
    if(!empty($lat) && !empty($lng)){
        $mapreq=$this->mapreq();
        $chagexy=$this->chagexy();
        $city_data=util::getDistrictByLatLng($lat,$lng,$mapreq,$chagexy,'0');
        $data['city'] =$this->getCity_name();
        $data['district'] =$this->getDistrict();
        $data['province'] =$this->getProvince();
    }
	unset($_POST['id']);
	unset($_POST['op']);
	unset($_POST['mid']);
	unset($_POST['token']);
	unset($_POST['submit']);
	unset($_POST['status']);
	unset($_POST['openid']);
	unset($_POST['area']);
	$data['content'] = serialize($_POST);
    $data['freshtime'] = TIMESTAMP;
	if (!empty($id)) {
		pdo_update(INFO,$data,array('id'=>$id));
	}else{
		$data['createtime'] = TIMESTAMP;
		pdo_insert(INFO, $data);
	}
	$this->message('操作成功！', $this->createWebUrl('info', array('op' => 'display')), 'success');
} elseif ($operation == 'delete') {
	$id = intval($_GPC['id']);
	$message = pdo_fetch("SELECT id FROM ".tablename(INFO)." WHERE id = {$id} AND weid= {$_W['uniacid']}");
	if (empty($message)) {
		$this->message('抱歉，信息不存在或是已经被删除！', $this->createWebUrl('info', array('op' => 'display')), 'error');
	}
	pdo_delete(INFO, array('id' => $id));
	$this->message('信息删除成功！', $this->createWebUrl('info', array('op' => 'display')), 'success');
}elseif ($operation == 'shenhe') {
	$id = intval($_GPC['id']);
	$message = pdo_fetch("SELECT id FROM " . tablename(INFO) . " WHERE id = {$id} AND weid= {$_W['uniacid']}");
	if (empty($message)) {
		$this->message('抱歉，信息不存在或是已经被删除！', $this->createWebUrl('info', array('op' => 'display')), 'error');
	}
	pdo_update(INFO, array('status'=>1),array('id' => $id));
	$this->message('信息审核成功！', $this->createWebUrl('info', array('op' => 'display')), 'success');
} elseif ($operation == 'fieldhtml') {
	$id = intval($_GPC['id']);
	$fieldslist = pdo_fetchall("SELECT * FROM ".tablename(FIELDS)." WHERE mid = {$id} AND weid = {$_W['uniacid']} ORDER BY displayorder ASC");
	foreach($fieldslist as $k=>$v){
		if(!empty($v['mtypecon'])){
			$fieldslist[$k]['mtypeconarr'] = explode("|",$v['mtypecon']);
		}else{
			$fieldslist[$k]['mtypeconarr'] = '';
		}
	}
	include $this->template('web/fieldhtml');
	exit;
}elseif($operation == 'getcitys'){
	$name = trim($_GPC['name']);
	$citys = pdo_fetchall("SELECT city FROM ".tablename(CITY)." WHERE uniacid = {$_W['uniacid']} AND province = '{$name}' AND type = 2");
	$html = '<option value="">市</option>';
	foreach($citys as $k=>$v){
		$html .= '<option value="'.$v['city'].'">'.$v['city'].'</option>';
	}
	echo $html;
	exit;
}elseif($operation == 'getdistricts'){
	$name = trim($_GPC['name']);
	$districts = pdo_fetchall("SELECT district FROM ".tablename(CITY)." WHERE weid = {$_W['uniacid']} AND city = '{$name}' AND type = 3");
    $html = '<option value="">区/县</option>';
	foreach($districts as $k=>$v){
		$html .= '<option value="'.$v['district'].'">'.$v['district'].'</option>';
	}
	echo $html;
	exit;
}else {
	$this->message('请求方式不存在');
}
include $this->template('web/info');

function getmodulename($weid,$mid){
	$moduleres = pdo_fetch("SELECT name FROM ".tablename(CHANNEL)." WHERE weid = {$weid} AND id = {$mid}");
	return $moduleres['name'];
}
exit;
?>