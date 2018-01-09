<?php
global $_W, $_GPC;
$userinfo=$member= Member::initUserInfo(); //用户信息
$toopenid = trim($_GPC['toopenid']);
if($toopenid)$userinfo2 = Member::getSingleUser($toopenid);
$chat_user_id = $member['id'].','. $userinfo2['id'];
$page =$this->getPage();
$num = $this->getNum(); //每次取值的个数
$operation = !empty($_GPC['op']) ? $_GPC['op'] : 'display';
if ($operation == 'display') {
    $title='我的发布';
    $status=intval($_GPC['status']);
    $haspay=intval($_GPC['haspay']);
    $isding=intval($_GPC['isding']);
    $info=new Info();
    if($haspay==1){//发布信息支付成功业务处理
        $where=" AND i.haspay =1";
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(INFOORDER)." o left join  ".tablename(INFO)."i on o.message_id=i.id WHERE i.weid = {$_W['uniacid']} AND i.openid = '{$member['openid']}'{$where}");
        $mymessagelist = $info->getPayInfoByuser ($member['openid'],$where,$page,$num);
    }elseif($isding==1){
        $where=" AND i.isding =1";
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(ZDORDER)." o left join  ".tablename(INFO)."i on o.message_id=i.id WHERE i.weid = {$_W['uniacid']} AND i.openid = '{$member['openid']}'{$where}");
        $mymessagelist = $info->getTopInfoByuser ($member['openid'],$where,$page,$num);
    }else{
        if($status==1){
            $where=" AND status =1";
        }else{
            $where=" AND status <>1";
        }
        $total = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND openid = '{$member['openid']}'{$where}");

        $mymessagelist=$info->getInfoByuser ($member['openid'],$where,$page,$num);
    }

    $allpage = ceil($total/10)+1;
    foreach($mymessagelist as $k=>$v){
		$mymessagelist[$k]['feildlist'] = unserialize($v['content']);
	}

	$isajax = intval($_GPC['isajax']);
	if($isajax == 1){
		$html = '';
		foreach($mymessagelist as $k=>$v){
			$statusresult = '';
            $orderinfo='';
            if($v['infoprice'] >0){
                $orderinfo.='<div class="m-5">发布支付：<span class="red">￥'.$v['infoprice'].'</span></div>';
            }
            if($v['zdprice'] >0){
                $orderinfo.='<div class="m-5">置顶支付：<span class="red">￥'.$v['zdprice'].'</span></div>';
            }
			if($v['isding'] == 1 && $haspay!=1){
				$isding = '<div><span class="mui-badge left">置顶至：'.date('Y-m-d H:i:s',$v['dingtime']).'</span></div>';
				$dingimg='<div class="g-zd"><img  src="'.STYLE.'images/g_zd.png"></div>';
			}else{
				$isding = '';
			}

			$html .= $dingimg.'<li class="mui-table-view-cell">
					<div class="mui-slider-right mui-disabled">
						<a class="mui-btn mui-btn-green m-top mui-icon mui-icon-arrowthinup" style="transform: translate(-0px, 0px);" href="'.$this->createMobileUrl('mylocal',array('op'=>'zhiding','id'=>$v['id'])).'"><span class="list-btn-info">置顶</span></a>
						<a class="mui-btn mui-icon mui-icon mui-icon-loop m-update mui-btn-yellow" style="transform: translate(-0px, 0px);" href="'.$this->createMobileUrl('mylocal',array('op'=>'refresh','id'=>$v['id'])).'"><span class="list-btn-info">刷新</span></a>
						<a class="mui-btn  mui-icon mui-icon-trash m-delete mui-btn-gray" style="transform: translate(-0px, 0px);" href="'.$this->createMobileUrl('mylocal',array('op'=>'delete','id'=>$v['id'])).'"><span class="list-btn-info">删除</span></a>
					</div>
					<div class="mui-slider-handle">
						<div class="mui-row">
							<div class="mui-col-sm-12 mui-col-xs-12"><span class="list-name">['.getmodulename($v['weid'],$v['mid']).']</span>'.$v['feildlist']['title'].'</div>
						</div>
						<div class="mui-row">
							<div class="m-5"><span>添加时间：'.date("Y-m-d H:i:s",$v['createtime']).'</span></div>
							'.$orderinfo.$isding.'
						</div>
					</div>
				</li>';
		}
		echo $html;
		exit();
	}else{
		include $this->template('../mobile/mylocal');
	}
}elseif ($operation == 'zhiding') {
	$id = intval($_GPC['id']);
	$message = pdo_fetch("SELECT * FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND openid = '{$member['openid']}' AND id = {$id}");
	if(empty($message)){
		message('不存在该信息！');
	}

	$module = pdo_fetch("SELECT zdprice FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} AND id = {$message['mid']}");
    if($module['zdprice'] <= 0){
        message('不能置顶！');
    }
	include $this->template('zd_info');
}elseif ($operation == 'dozhiding') {
	$id = intval($_GPC['id']);
	$days = intval($_GPC['days']);
	if($days <= 0){
		$resArr['error'] = 1;
		$resArr['message'] = "置顶天数必须大于0！";
		echo json_encode($resArr);
		exit();
	}
	$message = pdo_fetch("SELECT * FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND openid = '{$member['openid']}' AND id = {$id}");
	if(empty($message)){
		$resArr['error'] = 1;
		$resArr['message'] = "不存在该信息！";
		echo json_encode($resArr);
		exit();
	}
	$module = pdo_fetch("SELECT zdprice FROM ".tablename(CHANNEL)." WHERE weid = {$_W['uniacid']} AND id = {$message['mid']}");
	$ordersn = date('YmdHis') . random(6, 1);
	$dataorder['weid'] = $_W['uniacid'];
	$dataorder['from_user'] = $member['openid'];
	$dataorder['ordersn'] = $ordersn;
	$dataorder['price'] = $module['zdprice']*$days;
	$dataorder['paytype'] = 1;
	$dataorder['createtime'] = TIMESTAMP;
	$dataorder['message_id'] = $id;
	$dataorder['days'] = $days;
	$dataorder['module'] = $message['mid'];
	if($dataorder['price'] == 0){
		$resArr['needpay'] = 0;
		if($message['dingtime'] == 0){
			$dingtime = TIMESTAMP+$days*24*3600;
		}else{
			$dingtime = $message['dingtime']+$days*24*3600;
		}
		pdo_update(INFO,array('isding'=>1,'dingtime'=>$dingtime),array('id'=>$id,'weid'=>$_W['uniacid']));
		$resArr['ordersn'] = '';
	}else{
		$resArr['needpay'] = 1;
		pdo_insert(ZDORDER,$dataorder);
		$resArr['ordersn'] = $ordersn;
	}
	$resArr['error'] = 0;
	echo json_encode($resArr);
	exit();
}elseif ($operation == 'post') {
	$id = intval($_GPC['id']);
	$message = pdo_fetch("SELECT * FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND openid = '{$member['openid']}' AND id = {$id}");
	if(empty($message)){
		message('不存在该信息！');
	}
	$moduleres = pdo_fetch("SELECT needpay FROM ".tablename(CHANNEL)." WHERE id = {$message['mid']} AND weid = {$_W['uniacid']}");
	$content = unserialize($message['content']);
	$fieldslist = pdo_fetchall("SELECT * FROM ".tablename(FIELDS)." WHERE mid = {$message['mid']} AND weid = {$_W['uniacid']} ORDER BY displayorder ASC");
	foreach($fieldslist as $k=>$v){
		if(!empty($v['mtypecon'])){
			$fieldslist[$k]['mtypeconarr'] = explode("|",$v['mtypecon']);
		}else{
			$fieldslist[$k]['mtypeconarr'] = '';
		}
	}
	include $this->template('edit_info');
}elseif($operation == 'update'){
	$id = intval($_GPC['id']);
	$message = pdo_fetch("SELECT * FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND openid = '{$member['openid']}' AND id = {$id}");
	if(empty($message)){
		$resArr['error'] = 1;
		$resArr['message'] = "不存在该信息！";
		echo json_encode($resArr);
		exit();
	}
	$fieldslist = pdo_fetchall("SELECT * FROM ".tablename(FIELDS)." WHERE mid = {$message['mid']} AND weid = {$_W['uniacid']} ORDER BY displayorder ASC");
	foreach($fieldslist as $k=>$v){
		$fieldname = $_GPC[$v['enname']];
        if( is_array( $fieldname ) )$fieldname =implode(" ",$fieldname);
        $fieldnamelen = mb_strlen($fieldname,'utf-8');
		if($v['islenval'] == 1){
			if($fieldnamelen < $v['minlen'] || $fieldnamelen > $v['maxlen']){
				$resArr['error'] = 1;
				$resArr['message'] = $v['name']."字符长度应该在".$v['minlen']."字符到".$v['maxlen']."字符之间，当前字符长度".$fieldnamelen;
				echo json_encode($resArr);
				exit();
			}
		}
		if($v['isrequired'] == 1){
			if(empty($fieldname)){
				$resArr['error'] = 1;
				$resArr['message'] = "请填写".$v['name'];
				echo json_encode($resArr);
				exit();
			}
		}
        if ($v['mtype'] == 'telphone' && $v['isrequired'] == 1) {
            if (!util::isMobile($fieldname)) {
                $resArr['error'] = 1;
                $resArr['message'] = '请填写正确的手机号码';
                echo json_encode($resArr);
                exit();
            }
        }

		if($v['mtype'] == 'idcard' && $v['isrequired'] == 1){
			if(!$this->isCreditNo($fieldname)){
				$resArr['error'] = 1;
				$resArr['message'] = "请填写正确的身份证号";
				echo json_encode($resArr);
				exit();
			}
		}
	}
	unset($_POST['id']);
	$data['content'] = serialize($_POST);
	$moduleres = pdo_fetch("SELECT isshenhe FROM ".tablename(CHANNEL)." WHERE id = {$message['mid']} AND weid = {$_W['uniacid']}");
	$data['status'] = $moduleres['isshenhe'] == 1 ? 0 : 1;
	pdo_update(INFO,$data,array('id'=>$id));
	if($message['isneedpay'] == 1 && $message['haspay'] == 0){
		$messageorder = pdo_fetch("SELECT ordersn FROM ".tablename(INFOORDER)." WHERE weid = {$_W['uniacid']} AND message_id = {$id}");
		$resArr['ispay'] = 1;
		$resArr['ordersn'] = $messageorder['ordersn'];
	}else{
		$resArr['ispay'] = 0;
		$resArr['ordersn'] = '';
	}
	$resArr['message'] = "信息修改成功！";
	$resArr['error'] = 0;
	echo json_encode($resArr);
	exit();
}elseif($operation == 'refresh') {
    $id = intval($_GPC['id']);
//一天只能免费刷新一次，超过次数则按后台设定的收费
    $info_where['id'] = $id;
    $isadmin=util::getSingelDataInSingleTable(INFO, $info_where,'freshtime','2');
    $sameday=util::isDiffDays($isadmin['freshtime']);
    if($sameday==1){//如果不是同一天则让他刷新
        pdo_update(INFO,array('freshtime'=>TIMESTAMP),array('id'=>$id,'weid'=>$_W['uniacid']));
        $resArr['message'] = "恭喜您，刷新成功！";
        $resArr['error'] = 0;
    }else{
        $resArr['message'] = "亲，今天已经刷新过了哦，明天再来吧";
        $resArr['error'] = 0;
    }
    echo json_encode($resArr);
    exit();

}elseif($operation == 'delete'){
	$id = intval($_GPC['id']);
	$message = pdo_fetch("SELECT * FROM ".tablename(INFO)." WHERE weid = {$_W['uniacid']} AND openid = '{$member['openid']}' AND id = {$id}");
	if(empty($message)){
		$resArr['error'] = 1;
		$resArr['message'] = "不存在该信息！";
		echo json_encode($resArr);
		exit();
	}
    $imageeenname = pdo_fetch('SELECT enname FROM ' . tablename(FIELDS) . " WHERE weid = {$_W['uniacid']} AND mid = {$message['mid']} AND mtype in ('images','goodsthumbs','goodsbaoliao')");
    $feildlist = unserialize($message['content']);
    $imagesarr = $feildlist[$imageeenname['enname']];
    if(!empty($imagesarr)){//图片不为空时要删除图片
        foreach ($imagesarr as $k => $v) {
            file_delete($v);
        }
    }
	pdo_delete(INFO,array('id'=>$id));
	$resArr['message'] = "信息删除成功！";
	$resArr['error'] = 0;
	echo json_encode($resArr);
	exit();
}elseif ($operation == 'chat_display') {
    $mychatlist = pdo_fetchall("SELECT id,openid,toopenid,user1,user2 FROM ".tablename(CHAT)." WHERE weid = {$_W['uniacid']} AND user2 = '{$member['id']}' AND  deleteid <> {$member['id']}  ORDER BY hasread ASC,time DESC");

    $reschatlist = array();
    foreach($mychatlist as $k=>$v){
        if(empty($reschatlist[$v['openid']])){
            //查找最近人的聊天头像
            $reschatlist[$v['openid']]['chatlist'] = pdo_fetch("SELECT * FROM ".tablename(CHAT)." WHERE weid = {$_W['uniacid']} AND user1 = '{$v['user1']}' AND user2 = '{$v['user2']}' ORDER BY time DESC");
            //查找最近人的聊天内容，有可能是本人
            $chat_data=pdo_fetch("SELECT content FROM ".tablename(CHAT)." WHERE ((user1 = '{$v['user2']}' AND user2 = '{$v['user1']}') OR (user1 = '{$v['user1']}' AND user2 = '{$v['user2']}')) AND weid = {$_W['uniacid']} ORDER BY time desc");
            $reschatlist[$v['openid']]['chatlist']['content'] = $chat_data['content'];
            $reschatlist[$v['openid']]['hasnotread'] = pdo_fetchcolumn("SELECT COUNT(*) FROM ".tablename(CHAT)." WHERE weid = {$_W['uniacid']} AND user1 = '{$v['user1']}' AND user2 = '{$v['user2']}' AND hasread = 0");

        }
    }
    include $this->template('../mobile/mychat');
}elseif($operation == 'chat_delete'){

    $message = pdo_fetch("SELECT * FROM ".tablename(CHAT)." WHERE weid = {$_W['uniacid']} AND ((user1 = '{$userinfo['id']}' AND user2 = '{$userinfo2['id']}') OR (user2 = '{$userinfo['id']}' AND user1 = '{$userinfo2['id']}'))");
    if(empty($message)){
        $resArr['error'] = 1;
        $resArr['message'] = "不存在该聊天记录！";
        echo json_encode($resArr);
        exit();
    }

    if(empty($message['deleteid'])){//对话者未删除时，仅更新状态
        pdo_update(CHAT,array('deleteid'=>$member['id']),array('user1'=>$userinfo['id'],'user2'=>$userinfo2['id'],'weid'=>$_W['uniacid']));
        pdo_update(CHAT,array('deleteid'=>$member['id']),array('user2'=>$userinfo['id'],'user1'=>$userinfo2['id'],'weid'=>$_W['uniacid']));
    }else{//把两人的对话都删了
        pdo_delete(CHAT,array('user1'=>$userinfo['id'],'user2'=>$userinfo2['id'],'weid'=>$_W['uniacid']));
        pdo_delete(CHAT,array('user2'=>$userinfo['id'],'user1'=>$userinfo2['id'],'weid'=>$_W['uniacid']));
    }
    $resArr['error'] = 0;
    echo json_encode($resArr);
    exit();
}

function getmodulename($weid,$mid){
	$moduleres = pdo_fetch("SELECT name FROM ".tablename(CHANNEL)." WHERE weid = {$weid} AND id = {$mid}");
	return $moduleres['name'];
}
?>