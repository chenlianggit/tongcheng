<?php
global $_W, $_GPC;
$cfg=$this->module['config'];
$op     = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
$title=$cfg['index_title'].'我的收藏';
$member= Member::initUserInfo(); //用户信息
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
	$total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(COLLECT)." WHERE weid = {$_W['uniacid']} AND openid = '{$member['openid']}'");
	$allpage = ceil($total/10)+1;
	$page = intval($_GPC["page"]);
	$pindex = max(1, $page);
	$psize = 10;
	$mycollectlist = pdo_fetchall("SELECT a.*,b.content,b.mid FROM ".tablename(COLLECT)." as a,".tablename(INFO)." as b WHERE a.message_id = b.id AND a.weid = {$_W['uniacid']} AND a.openid = '{$member['openid']}' ORDER BY a.time DESC LIMIT ".($pindex - 1)*$psize.",".$psize);
	foreach($mycollectlist as $k=>$v){
		$messagecontent = unserialize($v['content']);
		$mycollectlist[$k]['messagetitle'] = $messagecontent['title'];
		$mycollectlist[$k]['mid'] = $v['mid'];
	}
	$isajax = intval($_GPC['isajax']);
	if($isajax == 1){
		$html = '';
		foreach($mycollectlist as $k=>$v){		
			$html .= '<li class="mui-table-view-cell">
					<div class="mui-slider-right mui-disabled">
						<a class="mui-btn mui-btn-yellow mui-icon mui-icon-refresh" style="transform: translate(-0px, 0px);" href="'.$this->createMobileUrl('detail',array('id'=>$v['message_id'])).'"></a>
						<a class="mui-btn mui-btn-red mui-icon mui-icon-trash" style="transform: translate(-90px, 0px);" href="'.$this->createMobileUrl('mycollect',array('op'=>'delete','id'=>$v['id'])).'"></a>
					</div>
					<div class="mui-slider-handle">
						<div class="mui-row">
							<div class="mui-col-sm-12 mui-col-xs-12"><span style="color:#900;margin-right:5px;">['.getmodulename($v['weid'],$v['mid']).']</span>'.$v['messagetitle'].'</div>
						</div>
						<div class="mui-row">
							<div class="mui-col-sm-12 mui-col-xs-12"><span class="mui-badge">收藏时间：'.date("Y-m-d H:i:s",$v['time']).'</span></div>
						</div>
					</div>
				</li>';
		}
		echo $html;
		exit();
	}else{
		include $this->template('../mobile/collect');
	}
}elseif($operation == 'do'){
    $info=new Info();
    $res=$info->proCollect($member['openid']);
    echo json_encode($res);
    exit();
}elseif($operation == 'iscang'){
	$message_id = intval($_GPC['message_id']);
	$collect = pdo_fetch("SELECT * FROM ".tablename(COLLECT)." WHERE weid = {$_W['uniacid']} AND openid = '{$member['openid']}' AND message_id = {$message_id}");
	if(!empty($collect)){
		$resArr['hascang'] = 1;
		echo json_encode($resArr);
		exit();
	}else{
		$resArr['hascang'] = 0;
		echo json_encode($resArr);
		exit();
	}
}elseif($operation == 'delete'){
	$id = intval($_GPC['id']);
	$collect = pdo_fetch("SELECT * FROM ".tablename(COLLECT)." WHERE weid = {$_W['uniacid']} AND openid = '{$member['openid']}' AND id = {$id}");
	if(empty($collect)){
		$resArr['error'] = 1;
		$resArr['message'] = "不存在该收藏！";
		echo json_encode($resArr);
		exit();
	}
	pdo_delete(COLLECT,array('id'=>$id,'weid'=>$_W['uniacid']));
	$resArr['message'] = "取消收藏成功！";
	$resArr['error'] = 0;
	echo json_encode($resArr);
	exit();
}

function getmodulename($weid,$mid){
	$moduleres = pdo_fetch("SELECT name FROM ".tablename(BEST_MODULECENTER)." WHERE weid = {$weid} AND id = {$mid}");
	return $moduleres['name'];
}
?>